<?php

namespace App\Http\Controllers;

use App\Models\Mekanik;
use App\Models\Motor;
use App\Models\Servis;
use App\Models\ServisSparepart;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServisController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $servis = Servis::with(['motor.pelanggan', 'mekanik'])
            ->when($search, function ($query, $search) {
                $query->where('no_servis', 'like', "%{$search}%")
                      ->orWhereHas('motor', function ($q) use ($search) {
                          $q->where('no_polisi', 'like', "%{$search}%")
                            ->orWhereHas('pelanggan', function ($q2) use ($search) {
                                $q2->where('nama', 'like', "%{$search}%");
                            });
                      });
            })
            ->latest('tanggal_masuk')
            ->paginate(15)
            ->withQueryString();

        return view('servis.index', compact('servis', 'search'));
    }

    public function create()
    {
        return view('servis.create', [
            'motors'     => Motor::with('pelanggan')->orderBy('no_polisi')->get(),
            'mekaniks'   => Mekanik::where('status', 'aktif')
                ->whereDoesntHave('jadwal', function ($q) {
                    $q->whereDate('tanggal', today())
                      ->where('status', 'izin');
                })
                ->orderBy('nama')->get(),
            'spareparts' => Sparepart::orderBy('nama_part')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'motor_id'       => ['required', 'exists:motors,id'],
            'mekanik_id'     => ['required', 'exists:mekaniks,id'],
            'keluhan'        => ['required', 'string'],
            'diagnosa'       => ['nullable', 'string'],
            'biaya_jasa'     => ['required', 'numeric', 'min:0'],
            'sparepart'      => ['array'],
            'sparepart.*.id' => ['required_with:sparepart', 'exists:spareparts,id'],
            'sparepart.*.qty'=> ['required_with:sparepart', 'integer', 'min:1'],
        ]);

        $servis = DB::transaction(function () use ($data) {
            $totalSparepart = 0;

            $servis = Servis::create([
                'no_servis'    => Servis::generateNoServis(),
                'motor_id'     => $data['motor_id'],
                'mekanik_id'   => $data['mekanik_id'] ?? null,
                'tanggal_masuk'=> now(),
                'keluhan'      => $data['keluhan'],
                'diagnosa'     => $data['diagnosa'] ?? null,
                'status'       => 'menunggu',
                'biaya_jasa'   => $data['biaya_jasa'],
                'total_biaya'  => $data['biaya_jasa'],
            ]);

            foreach ($data['sparepart'] ?? [] as $item) {
                $sparepart = Sparepart::findOrFail($item['id']);
                $subtotal  = $sparepart->harga_jual * $item['qty'];
                $totalSparepart += $subtotal;

                ServisSparepart::create([
                    'servis_id'   => $servis->id,
                    'sparepart_id'=> $sparepart->id,
                    'qty'         => $item['qty'],
                    'harga_satuan'=> $sparepart->harga_jual,
                    'subtotal'    => $subtotal,
                ]);

                $sparepart->decrement('stok', $item['qty']);
            }

            $servis->update(['total_biaya' => $servis->biaya_jasa + $totalSparepart]);

            return $servis;
        });

        return redirect()
            ->route('servis.create')
            ->with('success', "Servis {$servis->no_servis} berhasil disimpan.");
    }

    /**
     * Ubah status servis (dikerjakan → selesai → diambil).
     * Dipanggil dari dashboard (tombol cepat) maupun halaman servis lain.
     */
    public function updateStatus(Request $request, Servis $servis)
    {
        $alurStatus = ['dikerjakan', 'selesai', 'diambil'];

        $request->validate([
            'status' => ['required', 'in:' . implode(',', $alurStatus)],
        ]);

        $update = ['status' => $request->status];

        // Catat tanggal keluar otomatis saat selesai/diambil
        if (in_array($request->status, ['selesai', 'diambil']) && ! $servis->tanggal_keluar) {
            $update['tanggal_keluar'] = now();
        }

        $servis->update($update);

        return redirect()->back()
            ->with('success', "Status servis {$servis->no_servis} diubah menjadi <strong>" . ucfirst($request->status) . "</strong>.");
    }
}


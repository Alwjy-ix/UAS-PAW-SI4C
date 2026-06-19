<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class MotorController extends Controller
{
    public function index(Request $request)
    {
        $query = Motor::with('pelanggan')->withCount(['servis' => function ($query) {
            $query->where('status', '!=', 'batal');
        }]);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('no_polisi', 'like', "%{$search}%")
                  ->orWhere('tipe_motor', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', fn($p) => $p->where('nama', 'like', "%{$search}%"));
            });
        }

        $motors = $query->latest()->paginate(10)->withQueryString();

        return view('motor.index', compact('motors', 'search'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        return view('motor.create', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pelanggan_id'    => ['required', 'exists:pelanggans,id'],
            'no_polisi'       => ['required', 'string', 'max:20', 'unique:motors,no_polisi'],
            'merk'            => ['required', 'string', 'max:50'],
            'tipe_motor'      => ['required', 'string', 'max:100'],
            'tahun_pembuatan' => ['nullable', 'integer', 'min:1980', 'max:' . (date('Y') + 1)],
            'no_rangka'       => ['nullable', 'string', 'max:50', 'unique:motors,no_rangka'],
            'no_mesin'        => ['nullable', 'string', 'max:50', 'unique:motors,no_mesin'],
            'warna'           => ['nullable', 'string', 'max:50'],
        ]);

        Motor::create($data);

        return redirect()->route('motor.index')
            ->with('success', "Motor {$data['no_polisi']} berhasil ditambahkan.");
    }

    public function show(Motor $motor)
    {
        $motor->load(['pelanggan', 'servis' => fn($q) => $q->latest('tanggal_masuk')->limit(10)]);
        return view('motor.show', compact('motor'));
    }

    public function edit(Motor $motor)
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        return view('motor.edit', compact('motor', 'pelanggans'));
    }

    public function update(Request $request, Motor $motor)
    {
        $data = $request->validate([
            'pelanggan_id'    => ['required', 'exists:pelanggans,id'],
            'no_polisi'       => ['required', 'string', 'max:20', 'unique:motors,no_polisi,' . $motor->id],
            'merk'            => ['required', 'string', 'max:50'],
            'tipe_motor'      => ['required', 'string', 'max:100'],
            'tahun_pembuatan' => ['nullable', 'integer', 'min:1980', 'max:' . (date('Y') + 1)],
            'no_rangka'       => ['nullable', 'string', 'max:50', 'unique:motors,no_rangka,' . $motor->id],
            'no_mesin'        => ['nullable', 'string', 'max:50', 'unique:motors,no_mesin,' . $motor->id],
            'warna'           => ['nullable', 'string', 'max:50'],
        ]);

        $motor->update($data);

        return redirect()->route('motor.index')
            ->with('success', "Data motor {$motor->no_polisi} berhasil diperbarui.");
    }

    public function destroy(Motor $motor)
    {
        $noPolisi = $motor->no_polisi;
        $motor->delete();

        return redirect()->route('motor.index')
            ->with('success', "Motor {$noPolisi} berhasil dihapus.");
    }
}

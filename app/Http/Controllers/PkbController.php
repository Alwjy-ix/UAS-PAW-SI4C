<?php

namespace App\Http\Controllers;

use App\Models\Servis;
use Illuminate\Http\Request;

class PkbController extends Controller
{
    public function index()
    {
        $servis = Servis::with(['motor.pelanggan', 'mekanik'])
            ->whereIn('status', ['menunggu', 'dikerjakan'])
            ->orderBy('tanggal_masuk', 'asc')
            ->paginate(15);

        return view('pkb.index', compact('servis'));
    }

    public function show(Servis $servis)
    {
        if (!in_array($servis->status, ['menunggu', 'dikerjakan'])) {
            return redirect()->route('pkb.index')->with('error', 'Servis ini sudah tidak aktif di PKB.');
        }

        $servis->load(['motor.pelanggan', 'mekanik', 'sparepart.sparepart']);
        return view('pkb.show', compact('servis'));
    }

    public function update(Request $request, Servis $servis)
    {
        $statusSekarang = $servis->status;

        $validTransitions = [
            'menunggu' => ['dikerjakan', 'batal', 'selesai'],
            'dikerjakan' => ['selesai', 'batal'],
        ];

        if (!array_key_exists($statusSekarang, $validTransitions)) {
            return redirect()->back()->with('error', 'Status servis saat ini tidak dapat diubah melalui PKB.');
        }

        $request->validate([
            'status' => ['required', 'in:' . implode(',', $validTransitions[$statusSekarang])],
            'catatan' => ['nullable', 'string'],
        ]);

        $updateData = [
            'status' => $request->status,
            'catatan' => $request->catatan,
        ];

        if (in_array($request->status, ['selesai', 'batal']) && !$servis->tanggal_keluar) {
            $updateData['tanggal_keluar'] = now();
        }

        if ($request->status === 'batal' && $statusSekarang !== 'batal') {
            foreach ($servis->sparepart as $pivot) {
                $sparepartItem = \App\Models\Sparepart::find($pivot->sparepart_id);
                if ($sparepartItem) {
                    $sparepartItem->increment('stok', $pivot->qty);
                }
            }
        }

        $servis->update($updateData);

        return redirect()->route('pkb.index')->with('success', "PKB {$servis->no_servis} berhasil diperbarui menjadi status {$request->status}.");
    }
}

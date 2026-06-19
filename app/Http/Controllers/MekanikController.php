<?php

namespace App\Http\Controllers;

use App\Models\Mekanik;
use Illuminate\Http\Request;

class MekanikController extends Controller
{
    public function index(Request $request)
    {
        $query = Mekanik::withCount(['servis' => function ($q) {
            $q->where('status', '!=', 'batal');
        }])->with(['jadwal' => function ($q) {
            $q->whereDate('tanggal', today());
        }]);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('npk', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $mekaniks = $query->latest()->paginate(10)->withQueryString();

        return view('mekanik.index', compact('mekaniks', 'search'));
    }

    public function create()
    {
        return view('mekanik.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'npk'          => ['nullable', 'string', 'max:20', 'unique:mekaniks,npk'],
            'nama'         => ['required', 'string', 'max:100'],
            'no_hp'        => ['nullable', 'string', 'max:20'],
            'jabatan'      => ['nullable', 'string', 'max:100'],
            'status'       => ['required', 'in:aktif,nonaktif'],
        ]);

        Mekanik::create($data);

        return redirect()->route('mekanik.index')
            ->with('success', "Mekanik {$data['nama']} berhasil ditambahkan.");
    }

    public function show(Mekanik $mekanik)
    {
        $mekanik->load(['servis' => fn($q) => $q->with('motor.pelanggan')->latest('tanggal_masuk')->limit(10)]);
        return view('mekanik.show', compact('mekanik'));
    }

    public function edit(Mekanik $mekanik)
    {
        return view('mekanik.edit', compact('mekanik'));
    }

    public function update(Request $request, Mekanik $mekanik)
    {
        $data = $request->validate([
            'npk'          => ['nullable', 'string', 'max:20', 'unique:mekaniks,npk,' . $mekanik->id],
            'nama'         => ['required', 'string', 'max:100'],
            'no_hp'        => ['nullable', 'string', 'max:20'],
            'jabatan'      => ['nullable', 'string', 'max:100'],
            'status'       => ['required', 'in:aktif,nonaktif'],
        ]);

        $mekanik->update($data);

        return redirect()->route('mekanik.index')
            ->with('success', "Data mekanik {$mekanik->nama} berhasil diperbarui.");
    }

    public function destroy(Mekanik $mekanik)
    {
        $nama = $mekanik->nama;
        $mekanik->delete();

        return redirect()->route('mekanik.index')
            ->with('success', "Mekanik {$nama} berhasil dihapus.");
    }
}

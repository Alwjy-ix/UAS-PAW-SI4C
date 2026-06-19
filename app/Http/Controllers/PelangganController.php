<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::withCount('motors');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_ktp', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pelanggans = $query->latest()->paginate(10)->withQueryString();

        return view('pelanggan.index', compact('pelanggans', 'search'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'   => ['required', 'string', 'max:100'],
            'no_ktp' => ['nullable', 'string', 'digits:16'],
            'no_hp'  => ['required', 'string', 'max:20'],
            'email'  => ['nullable', 'email', 'max:100'],
            'alamat' => ['nullable', 'string'],
        ]);

        Pelanggan::create($data);

        return redirect()->route('pelanggan.index')
            ->with('success', "Pelanggan {$data['nama']} berhasil ditambahkan.");
    }

    public function show(Pelanggan $pelanggan)
    {
        $pelanggan->load(['motors.servis' => function ($q) {
            $q->latest('tanggal_masuk')->limit(5);
        }]);

        return view('pelanggan.show', compact('pelanggan'));
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $data = $request->validate([
            'nama'   => ['required', 'string', 'max:100'],
            'no_ktp' => ['nullable', 'string', 'digits:16'],
            'no_hp'  => ['required', 'string', 'max:20'],
            'email'  => ['nullable', 'email', 'max:100'],
            'alamat' => ['nullable', 'string'],
        ]);

        $pelanggan->update($data);

        return redirect()->route('pelanggan.index')
            ->with('success', "Data pelanggan {$pelanggan->nama} berhasil diperbarui.");
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $nama = $pelanggan->nama;
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', "Pelanggan {$nama} berhasil dihapus.");
    }
}

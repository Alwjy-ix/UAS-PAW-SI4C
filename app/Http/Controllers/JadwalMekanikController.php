<?php

namespace App\Http\Controllers;

use App\Models\JadwalMekanik;
use App\Models\Mekanik;
use Illuminate\Http\Request;

class JadwalMekanikController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalMekanik::with('mekanik');

        // Filter tanggal — default: minggu ini
        $dari  = $request->input('dari',  now()->startOfWeek()->format('Y-m-d'));
        $sampai = $request->input('sampai', now()->endOfWeek()->format('Y-m-d'));

        $query->whereBetween('tanggal', [$dari, $sampai]);

        if ($mekanikId = $request->input('mekanik_id')) {
            $query->where('mekanik_id', $mekanikId);
        }

        // Tampilkan per tanggal
        $jadwals  = $query->orderBy('tanggal')->get();
        $mekaniks = Mekanik::where('status', 'aktif')->orderBy('nama')->get();

        return view('jadwal.index', compact('jadwals', 'mekaniks', 'dari', 'sampai'));
    }

    public function create()
    {
        $mekaniks = Mekanik::where('status', 'aktif')->orderBy('nama')->get();
        return view('jadwal.create', compact('mekaniks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mekanik_id'  => ['required', 'exists:mekaniks,id'],
            'tanggal'     => ['required', 'date'],

            'status'      => ['required', 'in:hadir,izin'],
            'keterangan'  => ['nullable', 'string', 'max:200'],
        ]);

        // Cek duplikat (mekanik_id + tanggal harus unik)
        $exists = JadwalMekanik::where('mekanik_id', $data['mekanik_id'])
            ->where('tanggal', $data['tanggal'])
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->withErrors(['tanggal' => 'Mekanik ini sudah terjadwal di tanggal tersebut.']);
        }

        $data['shift'] = 'pagi';
        JadwalMekanik::create($data);

        $mekanik = Mekanik::find($data['mekanik_id']);
        return redirect()->route('jadwal.index')
            ->with('success', "Jadwal {$mekanik->nama} berhasil ditambahkan.");
    }

    public function edit(JadwalMekanik $jadwal)
    {
        $mekaniks = Mekanik::where('status', 'aktif')->orderBy('nama')->get();
        return view('jadwal.edit', compact('jadwal', 'mekaniks'));
    }

    public function update(Request $request, JadwalMekanik $jadwal)
    {
        $data = $request->validate([
            'mekanik_id'  => ['required', 'exists:mekaniks,id'],
            'tanggal'     => ['required', 'date'],

            'status'      => ['required', 'in:hadir,izin'],
            'keterangan'  => ['nullable', 'string', 'max:200'],
        ]);

        // Cek duplikat (kecuali record ini sendiri)
        $exists = JadwalMekanik::where('mekanik_id', $data['mekanik_id'])
            ->where('tanggal', $data['tanggal'])
            ->where('id', '!=', $jadwal->id)
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->withErrors(['tanggal' => 'Mekanik ini sudah terjadwal di tanggal tersebut.']);
        }

        $data['shift'] = 'pagi';
        $jadwal->update($data);

        return redirect()->route('jadwal.index')
            ->with('success', "Jadwal berhasil diperbarui.");
    }

    public function destroy(JadwalMekanik $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')
            ->with('success', "Jadwal berhasil dihapus.");
    }

    /** Update status hadir/izin/cuti via AJAX/form mini */
    public function updateStatus(Request $request, JadwalMekanik $jadwal)
    {
        $request->validate([
            'status' => ['required', 'in:hadir,izin'],
        ]);

        $jadwal->update(['status' => $request->status]);

        return redirect()->back()->with('success', "Status kehadiran diperbarui.");
    }
}

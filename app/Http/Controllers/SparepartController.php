<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index(Request $request)
    {
        $query = Sparepart::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_part', 'like', "%{$search}%")
                  ->orWhere('kode_part', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        if ($request->input('menipis')) {
            $query->whereColumn('stok', '<=', 'stok_minimum');
        }

        $spareparts = $query->orderBy('nama_part')->paginate(15)->withQueryString();

        return view('sparepart.index', compact('spareparts', 'search'));
    }

    public function create()
    {
        return view('sparepart.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_part'     => ['required', 'string', 'max:50', 'unique:spareparts,kode_part'],
            'nama_part'     => ['required', 'string', 'max:150'],
            'kategori'      => ['nullable', 'string', 'max:50'],
            'satuan'        => ['required', 'string', 'max:20'],
            'harga_beli'    => ['required', 'numeric', 'min:0'],
            'harga_jual'    => ['required', 'numeric', 'min:0'],
            'stok'          => ['required', 'integer', 'min:0'],
            'stok_minimum'  => ['required', 'integer', 'min:0'],
        ]);

        Sparepart::create($data);

        return redirect()->route('sparepart.index')
            ->with('success', "Sparepart {$data['nama_part']} berhasil ditambahkan.");
    }

    public function show(Sparepart $sparepart)
    {
        return view('sparepart.show', compact('sparepart'));
    }

    public function edit(Sparepart $sparepart)
    {
        return view('sparepart.edit', compact('sparepart'));
    }

    public function update(Request $request, Sparepart $sparepart)
    {
        $data = $request->validate([
            'kode_part'     => ['required', 'string', 'max:50', 'unique:spareparts,kode_part,' . $sparepart->id],
            'nama_part'     => ['required', 'string', 'max:150'],
            'kategori'      => ['nullable', 'string', 'max:50'],
            'satuan'        => ['required', 'string', 'max:20'],
            'harga_beli'    => ['required', 'numeric', 'min:0'],
            'harga_jual'    => ['required', 'numeric', 'min:0'],
            'stok'          => ['required', 'integer', 'min:0'],
            'stok_minimum'  => ['required', 'integer', 'min:0'],
        ]);

        $sparepart->update($data);

        return redirect()->route('sparepart.index')
            ->with('success', "Data {$sparepart->nama_part} berhasil diperbarui.");
    }

    public function destroy(Sparepart $sparepart)
    {
        $nama = $sparepart->nama_part;
        $sparepart->delete();

        return redirect()->route('sparepart.index')
            ->with('success', "Sparepart {$nama} berhasil dihapus.");
    }

    /** Tambah / kurangi stok langsung dari tabel */
    public function updateStok(Request $request, Sparepart $sparepart)
    {
        $request->validate([
            'jumlah'    => ['required', 'integer'],
            'keterangan' => ['nullable', 'string', 'max:200'],
        ]);

        $sparepart->increment('stok', $request->jumlah);

        return redirect()->route('sparepart.index')
            ->with('success', "Stok {$sparepart->nama_part} diperbarui (+{$request->jumlah}).");
    }
}

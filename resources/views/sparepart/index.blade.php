@extends('layouts.app')

@section('title', 'Sparepart & Stok')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Sparepart &amp; Stok</h2>
        <p class="page-subheading">Kelola inventaris suku cadang bengkel</p>
    </div>
    <a href="{{ route('sparepart.create') }}" class="btn-primary">
        <i class="bi bi-plus-circle-fill"></i> Tambah sparepart
    </a>
</div>

{{-- Filter bar --}}
<form method="GET" action="{{ route('sparepart.index') }}" class="bengkel-search-form">
    <div class="search-input-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" id="searchSparepart" class="form-control search-input"
            placeholder="Cari nama, kode, atau kategori..."
            value="{{ $search ?? '' }}" autocomplete="off">
        @if($search)
        <a href="{{ route('sparepart.index') }}" class="search-clear"><i class="bi bi-x-circle-fill"></i></a>
        @endif
    </div>
    <label class="filter-checkbox-label">
        <input type="checkbox" name="menipis" value="1" {{ request('menipis') ? 'checked' : '' }}
               onchange="this.form.submit()" id="filterMenipis">
        <i class="bi bi-exclamation-triangle-fill" style="color:var(--warning)"></i>
        Stok menipis saja
    </label>
    <button type="submit" class="btn-primary">Cari</button>
</form>

<div class="bengkel-panel">
    <table class="bengkel-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Kode</th>
                <th>Nama Part</th>
                <th>Kategori</th>
                <th class="text-right">Harga Beli</th>
                <th class="text-right">Harga Jual</th>
                <th class="text-center">Satuan</th>
                <th class="text-center">Stok</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($spareparts as $part)
            @php $menipis = $part->stokMenipis(); @endphp
            <tr class="{{ $menipis ? 'row-warn' : '' }}">
                <td class="text-muted">{{ $spareparts->firstItem() + $loop->index }}</td>
                <td>
                    <span class="kode-part">{{ $part->kode_part }}</span>
                </td>
                <td>
                    <div class="fw-600">{{ $part->nama_part }}</div>
                    @if($menipis)
                    <div class="stok-warn-label">
                        <i class="bi bi-exclamation-triangle-fill"></i> Stok menipis
                    </div>
                    @endif
                </td>
                <td>
                    @if($part->kategori)
                    <span class="badge-kategori">{{ $part->kategori }}</span>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                <td class="text-right text-muted" style="font-family:var(--font-mono);font-size:13px;">
                    Rp {{ number_format($part->harga_beli, 0, ',', '.') }}
                </td>
                <td class="text-right fw-600" style="font-family:var(--font-mono);font-size:13px;color:var(--accent-dark);">
                    Rp {{ number_format($part->harga_jual, 0, ',', '.') }}
                </td>
                <td class="text-center text-muted">{{ $part->satuan }}</td>
                <td class="text-center">
                    <div class="stok-cell {{ $menipis ? 'stok-cell--warn' : '' }}">
                        <span class="stok-number">{{ $part->stok }}</span>
                        <span class="stok-min">/ min {{ $part->stok_minimum }}</span>
                    </div>
                </td>
                <td class="text-center">
                    <div class="action-btns">

                        <a href="{{ route('sparepart.edit', $part) }}" class="btn-icon btn-icon--edit" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('sparepart.destroy', $part) }}"
                              onsubmit="return confirm('Hapus sparepart {{ $part->nama_part }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon btn-icon--danger" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="empty-row">
                    @if($search)
                        Tidak ada sparepart dengan kata kunci "<strong>{{ $search }}</strong>".
                    @else
                        Belum ada data sparepart. <a href="{{ route('sparepart.create') }}">Tambah sekarang</a>.
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($spareparts->hasPages())
<div class="pagination-wrap">
    {{ $spareparts->links('vendor.pagination.bengkel') }}
</div>
@endif
@endsection

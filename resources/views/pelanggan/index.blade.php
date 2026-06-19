@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Data Pelanggan</h2>
        <p class="page-subheading">Daftar seluruh pelanggan yang terdaftar di bengkel</p>
    </div>
    <a href="{{ route('pelanggan.create') }}" class="btn-primary">
        <i class="bi bi-person-plus-fill"></i> Tambah pelanggan
    </a>
</div>

{{-- Search bar --}}
<form method="GET" action="{{ route('pelanggan.index') }}" class="bengkel-search-form">
    <div class="search-input-wrap">
        <i class="bi bi-search search-icon"></i>
        <input
            type="text"
            name="search"
            id="searchPelanggan"
            class="form-control search-input"
            placeholder="Cari nama, no. KTP, HP, atau email..."
            value="{{ $search ?? '' }}"
            autocomplete="off"
        >
        @if($search)
        <a href="{{ route('pelanggan.index') }}" class="search-clear" title="Hapus pencarian">
            <i class="bi bi-x-circle-fill"></i>
        </a>
        @endif
    </div>
    <button type="submit" class="btn-primary">Cari</button>
</form>

<div class="bengkel-panel">
    <table class="bengkel-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>No. HP</th>
                <th>Email</th>
                <th>Alamat</th>
                <th class="text-center">Motor</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pelanggans as $pelanggan)
            <tr>
                <td class="text-muted">{{ $pelanggans->firstItem() + $loop->index }}</td>
                <td>
                    <div class="pelanggan-name-cell">
                        <div class="pelanggan-avatar">{{ strtoupper(substr($pelanggan->nama, 0, 1)) }}</div>
                        <div>
                            <div class="fw-600">{{ $pelanggan->nama }}</div>
                            @if($pelanggan->no_ktp)
                            <div class="text-muted" style="font-size:12px;"><i class="bi bi-card-text"></i> {{ $pelanggan->no_ktp }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <a href="tel:{{ $pelanggan->no_hp }}" class="text-link">
                        <i class="bi bi-telephone"></i> {{ $pelanggan->no_hp }}
                    </a>
                </td>
                <td class="text-muted">{{ $pelanggan->email ?? '-' }}</td>
                <td class="text-muted td-alamat">{{ $pelanggan->alamat ?? '-' }}</td>
                <td class="text-center">
                    <span class="badge-count">{{ $pelanggan->motors_count }}</span>
                </td>
                <td class="text-center">
                    <div class="action-btns">

                        <a href="{{ route('pelanggan.edit', $pelanggan) }}" class="btn-icon btn-icon--edit" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('pelanggan.destroy', $pelanggan) }}"
                              onsubmit="return confirm('Hapus pelanggan {{ $pelanggan->nama }}? Semua data motor terkait juga akan terpengaruh.')">
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
                <td colspan="7" class="empty-row">
                    @if($search)
                        Tidak ada pelanggan dengan kata kunci "<strong>{{ $search }}</strong>".
                    @else
                        Belum ada data pelanggan. <a href="{{ route('pelanggan.create') }}">Tambah sekarang</a>.
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if ($pelanggans->hasPages())
<div class="pagination-wrap">
    {{ $pelanggans->links('vendor.pagination.bengkel') }}
</div>
@endif
@endsection

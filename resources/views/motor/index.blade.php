@extends('layouts.app')

@section('title', 'Data Motor')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Data Motor</h2>
        <p class="page-subheading">Daftar seluruh motor yang terdaftar di bengkel</p>
    </div>
    <a href="{{ route('motor.create') }}" class="btn-primary">
        <i class="bi bi-plus-circle-fill"></i> Tambah motor
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('motor.index') }}" class="bengkel-search-form">
    <div class="search-input-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" id="searchMotor" class="form-control search-input"
            placeholder="Cari plat nomor, tipe, merk, atau nama pemilik..."
            value="{{ $search ?? '' }}" autocomplete="off">
        @if($search)
        <a href="{{ route('motor.index') }}" class="search-clear" title="Hapus pencarian">
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
                <th>No. Polisi</th>
                <th>Merk &amp; Tipe</th>
                <th>Tahun</th>
                <th>Warna</th>
                <th>Pemilik</th>
                <th class="text-center">Servis</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($motors as $motor)
            <tr>
                <td class="text-muted">{{ $motors->firstItem() + $loop->index }}</td>
                <td>
                    <span class="ticket-no">{{ $motor->no_polisi }}</span>
                </td>
                <td>
                    <div class="fw-600">{{ $motor->tipe_motor }}</div>
                    <div class="text-muted" style="font-size:12px;">{{ $motor->merk }}</div>
                </td>
                <td class="text-muted">{{ $motor->tahun_pembuatan ?? '-' }}</td>
                <td>
                    @if($motor->warna)
                    <div class="warna-cell">
                        {{ $motor->warna }}
                    </div>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('pelanggan.show', $motor->pelanggan) }}" class="text-link fw-600">
                        <i class="bi bi-person"></i> {{ $motor->pelanggan->nama }}
                    </a>
                </td>
                <td class="text-center">
                    <span class="badge-count">{{ $motor->servis_count }}</span>
                </td>
                <td class="text-center">
                    <div class="action-btns">

                        <a href="{{ route('motor.edit', $motor) }}" class="btn-icon btn-icon--edit" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('motor.destroy', $motor) }}"
                              onsubmit="return confirm('Hapus motor {{ $motor->no_polisi }}? Semua riwayat servis terkait juga akan terhapus.')">
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
                <td colspan="8" class="empty-row">
                    @if($search)
                        Tidak ada motor dengan kata kunci "<strong>{{ $search }}</strong>".
                    @else
                        Belum ada data motor. <a href="{{ route('motor.create') }}">Tambah sekarang</a>.
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($motors->hasPages())
<div class="pagination-wrap">
    {{ $motors->links('vendor.pagination.bengkel') }}
</div>
@endif
@endsection

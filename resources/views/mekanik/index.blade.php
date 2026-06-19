@extends('layouts.app')

@section('title', 'Data Mekanik')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Data Mekanik</h2>
        <p class="page-subheading">Kelola data teknisi bengkel</p>
    </div>
    <a href="{{ route('mekanik.create') }}" class="btn-primary">
        <i class="bi bi-person-plus-fill"></i> Tambah mekanik
    </a>
</div>

<form method="GET" action="{{ route('mekanik.index') }}" class="bengkel-search-form">
    <div class="search-input-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" id="searchMekanik" class="form-control search-input"
            placeholder="Cari nama, NPK, jabatan, atau no. HP..."
            value="{{ $search ?? '' }}" autocomplete="off">
        @if($search)
        <a href="{{ route('mekanik.index') }}" class="search-clear"><i class="bi bi-x-circle-fill"></i></a>
        @endif
    </div>
    <select name="status" class="form-control" style="width:140px">
        <option value="">Semua status</option>
        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select>
    <button type="submit" class="btn-primary">Cari</button>
</form>

<div class="bengkel-panel">
    <table class="bengkel-table">
        <thead>
            <tr>
                <th>#</th>
                <th>NPK</th>
                <th>Nama Mekanik</th>
                <th>No. HP</th>
                <th>Jabatan</th>
                <th class="text-center">Total Servis</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mekaniks as $mekanik)
            <tr>
                <td class="text-muted">{{ $mekaniks->firstItem() + $loop->index }}</td>
                <td>
                    <span class="text-muted fw-600">{{ $mekanik->npk ?? '-' }}</span>
                </td>
                <td>
                    <div class="pelanggan-name-cell">
                        <div class="mekanik-avatar">{{ strtoupper(substr($mekanik->nama, 0, 1)) }}</div>
                        <div class="fw-600">{{ $mekanik->nama }}</div>
                    </div>
                </td>
                <td>
                    @if($mekanik->no_hp)
                    <a href="tel:{{ $mekanik->no_hp }}" class="text-link">
                        <i class="bi bi-telephone"></i> {{ $mekanik->no_hp }}
                    </a>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    @if($mekanik->jabatan)
                    <span class="badge-spesialisasi">{{ $mekanik->jabatan }}</span>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
                <td class="text-center">
                    <span class="badge-count">{{ $mekanik->servis_count }}</span>
                </td>
                <td class="text-center">
                    @php
                        $jadwalHariIni = $mekanik->jadwal->first();
                        $isIzin = $jadwalHariIni && $jadwalHariIni->status === 'izin';
                    @endphp
                    @if($isIzin)
                        <span class="badge-status" style="background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba;">Izin</span>
                    @else
                        <span class="badge-status {{ $mekanik->status === 'aktif' ? 'badge-status--selesai' : 'badge-status--nonaktif' }}">
                            {{ ucfirst($mekanik->status) }}
                        </span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="action-btns">

                        <a href="{{ route('mekanik.edit', $mekanik) }}" class="btn-icon btn-icon--edit" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('mekanik.destroy', $mekanik) }}"
                              onsubmit="return confirm('Hapus mekanik {{ $mekanik->nama }}?')">
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
                        Tidak ada mekanik dengan kata kunci "<strong>{{ $search }}</strong>".
                    @else
                        Belum ada data mekanik. <a href="{{ route('mekanik.create') }}">Tambah sekarang</a>.
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($mekaniks->hasPages())
<div class="pagination-wrap">
    {{ $mekaniks->links('vendor.pagination.bengkel') }}
</div>
@endif
@endsection

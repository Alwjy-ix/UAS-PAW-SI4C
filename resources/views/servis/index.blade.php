@extends('layouts.app')

@section('title', 'Riwayat Servis')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Riwayat Servis</h2>
        <p class="page-subheading">Daftar riwayat servis dan perbaikan seluruh pelanggan</p>
    </div>
    <a href="{{ route('servis.create') }}" class="btn-primary">
        <i class="bi bi-plus-circle-fill"></i> Tambah Servis
    </a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('servis.index') }}" class="bengkel-search-form">
    <div class="search-input-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" id="searchServis" class="form-control search-input"
            placeholder="Cari no servis, plat nomor, atau nama pelanggan..."
            value="{{ $search ?? '' }}" autocomplete="off">
        @if($search)
        <a href="{{ route('servis.index') }}" class="search-clear" title="Hapus pencarian">
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
                <th>No. Servis</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Motor</th>
                <th>Mekanik</th>
                <th>Status</th>
                <th class="text-right">Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($servis as $item)
            <tr>
                <td>
                    <span class="ticket-no">{{ $item->no_servis }}</span>
                </td>
                <td class="text-muted">
                    {{ $item->tanggal_masuk->format('d M Y') }}
                </td>
                <td>
                    <div class="fw-600">{{ $item->motor->pelanggan->nama }}</div>
                    <div class="text-muted" style="font-size:12px;">{{ $item->motor->pelanggan->no_hp }}</div>
                </td>
                <td>
                    <div class="fw-600">{{ $item->motor->no_polisi }}</div>
                    <div class="text-muted" style="font-size:12px;">{{ $item->motor->merk }} {{ $item->motor->tipe_motor }}</div>
                </td>
                <td>
                    {{ $item->mekanik ? $item->mekanik->nama : '-' }}
                </td>
                <td>
                    @if($item->status == 'menunggu')
                        <span class="badge-status badge-status--menunggu">Menunggu</span>
                    @elseif($item->status == 'dikerjakan')
                        <span class="badge-status badge-status--dikerjakan">Dikerjakan</span>
                    @elseif($item->status == 'selesai')
                        <span class="badge-status badge-status--selesai">Selesai</span>
                        <form action="{{ route('servis.updateStatus', $item->id) }}" method="POST" style="display:inline-block; margin-left: 8px;">
                            @csrf
                            <input type="hidden" name="status" value="diambil">
                            <button type="submit" class="btn-primary" style="padding: 2px 8px; font-size: 12px; height: auto;" onclick="return confirm('Tandai motor sudah diambil?')">Tandai diambil</button>
                        </form>
                    @elseif($item->status == 'batal')
                        <span class="badge-status badge-status--batal">Batal</span>
                    @else
                        <span class="badge-status badge-status--diambil">Diambil</span>
                    @endif
                </td>
                <td class="text-right fw-600">
                    Rp {{ number_format($item->total_biaya, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="empty-row">
                    @if($search)
                        Tidak ada riwayat servis dengan kata kunci "<strong>{{ $search }}</strong>".
                    @else
                        Belum ada riwayat servis.
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($servis->hasPages())
<div class="pagination-wrap">
    {{ $servis->links('vendor.pagination.bengkel') }}
</div>
@endif
@endsection

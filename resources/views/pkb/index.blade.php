@extends('layouts.app')

@section('title', 'Perintah Kerja Bengkel')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Perintah Kerja Bengkel (PKB)</h2>
        <p class="page-subheading">Daftar servis yang sedang menunggu atau sedang dikerjakan</p>
    </div>
</div>

<div class="bengkel-panel">
    <table class="bengkel-table">
        <thead>
            <tr>
                <th>No. Servis</th>
                <th>Tanggal Masuk</th>
                <th>Pelanggan</th>
                <th>Motor</th>
                <th>Mekanik</th>
                <th>Status</th>
                <th class="text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($servis as $item)
            <tr>
                <td>
                    <span class="ticket-no">{{ $item->no_servis }}</span>
                </td>
                <td class="text-muted">
                    {{ $item->tanggal_masuk->format('d M Y H:i') }}
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
                    @endif
                </td>
                <td class="text-right">
                    <a href="{{ route('pkb.show', $item->id) }}" class="btn-primary" style="padding: 4px 12px; font-size: 13px;">Proses PKB</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="empty-row">
                    Belum ada antrean servis untuk saat ini.
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

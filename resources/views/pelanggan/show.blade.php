@extends('layouts.app')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Detail Pelanggan</h2>
        <p class="page-subheading">Riwayat lengkap pelanggan</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('pelanggan.edit', $pelanggan) }}" class="btn-secondary-outline">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('pelanggan.index') }}" class="btn-secondary-outline">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="bengkel-grid-2">
    {{-- Info pelanggan --}}
    <div class="bengkel-panel">
        <h2 class="panel-title">Informasi Pelanggan</h2>
        <div class="pelanggan-detail-card">
            <div class="pelanggan-avatar-lg">{{ strtoupper(substr($pelanggan->nama, 0, 2)) }}</div>
            <div class="pelanggan-detail-info">
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-person"></i> Nama</span>
                    <span class="detail-value fw-600">{{ $pelanggan->nama }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-card-text"></i> No. KTP</span>
                    <span class="detail-value">{{ $pelanggan->no_ktp ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-telephone"></i> No. HP</span>
                    <span class="detail-value">
                        <a href="tel:{{ $pelanggan->no_hp }}" class="text-link">{{ $pelanggan->no_hp }}</a>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-envelope"></i> Email</span>
                    <span class="detail-value">{{ $pelanggan->email ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-geo-alt"></i> Alamat</span>
                    <span class="detail-value">{{ $pelanggan->alamat ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-calendar"></i> Bergabung</span>
                    <span class="detail-value text-muted">{{ $pelanggan->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar motor --}}
    <div class="bengkel-panel">
        <h2 class="panel-title">Motor Terdaftar ({{ $pelanggan->motors->count() }})</h2>
        @forelse ($pelanggan->motors as $motor)
        <div class="motor-item">
            <div class="motor-item-header">
                <span class="ticket-no">{{ $motor->no_polisi }}</span>
                <span class="text-muted">{{ $motor->merk }} {{ $motor->tipe_motor }}</span>
            </div>
            <div class="motor-item-detail">
                <span class="text-muted">Tahun {{ $motor->tahun_pembuatan }}</span>
                @if($motor->warna)
                    <span class="text-muted">• {{ $motor->warna }}</span>
                @endif
            </div>
            @if($motor->servis->isNotEmpty())
            <div class="motor-servis-mini">
                <span class="text-muted" style="font-size:0.78rem;">Servis terakhir:
                    {{ $motor->servis->first()->tanggal_masuk->format('d M Y') }} —
                    <span class="badge-status badge-status--{{ $motor->servis->first()->status }}">{{ ucfirst($motor->servis->first()->status) }}</span>
                </span>
            </div>
            @endif
        </div>
        @empty
        <p class="text-muted" style="padding: 1rem 0;">Belum ada motor terdaftar.</p>
        @endforelse
    </div>
</div>
@endsection

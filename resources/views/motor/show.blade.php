@extends('layouts.app')

@section('title', 'Detail Motor')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Detail Motor</h2>
        <p class="page-subheading">Riwayat servis <span class="ticket-no">{{ $motor->no_polisi }}</span></p>
    </div>
    <div class="header-actions">
        <a href="{{ route('motor.edit', $motor) }}" class="btn-secondary-outline">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('motor.index') }}" class="btn-secondary-outline">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="bengkel-grid-2">
    {{-- Info motor --}}
    <div class="bengkel-panel">
        <h2 class="panel-title">Informasi Motor</h2>
        <div class="motor-detail-icon"><i class="bi bi-bicycle"></i></div>
        <div class="pelanggan-detail-info">
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-tag"></i> No. Polisi</span>
                <span class="detail-value"><span class="ticket-no">{{ $motor->no_polisi }}</span></span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-tools"></i> Merk</span>
                <span class="detail-value fw-600">{{ $motor->merk }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-bicycle"></i> Tipe</span>
                <span class="detail-value">{{ $motor->tipe_motor }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-calendar"></i> Tahun</span>
                <span class="detail-value">{{ $motor->tahun_pembuatan ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-palette"></i> Warna</span>
                <span class="detail-value">{{ $motor->warna ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-upc-scan"></i> No. Rangka</span>
                <span class="detail-value text-muted" style="font-family:var(--font-mono);font-size:12px;">{{ $motor->no_rangka ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-gear"></i> No. Mesin</span>
                <span class="detail-value text-muted" style="font-family:var(--font-mono);font-size:12px;">{{ $motor->no_mesin ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-person"></i> Pemilik</span>
                <span class="detail-value">
                    <a href="{{ route('pelanggan.show', $motor->pelanggan) }}" class="text-link fw-600">
                        {{ $motor->pelanggan->nama }}
                    </a>
                    <div class="text-muted" style="font-size:12px;">{{ $motor->pelanggan->no_hp }}</div>
                </span>
            </div>
        </div>
    </div>

    {{-- Riwayat servis --}}
    <div class="bengkel-panel">
        <h2 class="panel-title">Riwayat Servis ({{ $motor->servis->count() }})</h2>
        @forelse ($motor->servis as $servis)
        <div class="motor-item">
            <div class="motor-item-header">
                <span class="ticket-no">{{ $servis->no_servis }}</span>
                <span class="badge-status badge-status--{{ $servis->status }}">{{ ucfirst($servis->status) }}</span>
            </div>
            <div class="motor-item-detail">
                {{ $servis->tanggal_masuk->format('d M Y, H:i') }}
            </div>
            <div class="text-muted" style="font-size:13px;margin-top:4px;">
                {{ Str::limit($servis->keluhan, 80) }}
            </div>
            @if($servis->total_biaya)
            <div style="font-size:13px;margin-top:4px;font-family:var(--font-mono);color:var(--accent-dark);">
                Rp {{ number_format($servis->total_biaya, 0, ',', '.') }}
            </div>
            @endif
        </div>
        @empty
        <p class="text-muted" style="padding:1rem 0;">Belum ada riwayat servis untuk motor ini.</p>
        @endforelse
    </div>
</div>
@endsection

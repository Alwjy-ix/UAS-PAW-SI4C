@extends('layouts.app')

@section('title', 'Detail Mekanik')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Detail Mekanik</h2>
        <p class="page-subheading">Profil &amp; riwayat servis</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('mekanik.edit', $mekanik) }}" class="btn-secondary-outline">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('mekanik.index') }}" class="btn-secondary-outline">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="bengkel-grid-2">
    {{-- Profil mekanik --}}
    <div class="bengkel-panel">
        <h2 class="panel-title">Profil Mekanik</h2>
        <div class="mekanik-profile-card">
            <div class="pelanggan-avatar-lg">{{ strtoupper(substr($mekanik->nama, 0, 2)) }}</div>
            <div class="pelanggan-detail-info">
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-person-badge"></i> NPK</span>
                    <span class="detail-value fw-600">{{ $mekanik->npk ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-person"></i> Nama</span>
                    <span class="detail-value fw-600">{{ $mekanik->nama }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-telephone"></i> No. HP</span>
                    <span class="detail-value">
                        @if($mekanik->no_hp)
                        <a href="tel:{{ $mekanik->no_hp }}" class="text-link">{{ $mekanik->no_hp }}</a>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-tools"></i> Jabatan</span>
                    <span class="detail-value">
                        @if($mekanik->jabatan)
                        <span class="badge-spesialisasi">{{ $mekanik->jabatan }}</span>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-circle-fill"></i> Status</span>
                    <span class="detail-value">
                        <span class="badge-status {{ $mekanik->status === 'aktif' ? 'badge-status--selesai' : 'badge-status--nonaktif' }}">
                            {{ ucfirst($mekanik->status) }}
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-wrench"></i> Total Servis</span>
                    <span class="detail-value fw-600">{{ $mekanik->servis->count() }} servis</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="bi bi-calendar"></i> Bergabung</span>
                    <span class="detail-value text-muted">{{ $mekanik->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat servis --}}
    <div class="bengkel-panel">
        <h2 class="panel-title">Riwayat Servis Terakhir</h2>
        @forelse ($mekanik->servis as $servis)
        <div class="motor-item">
            <div class="motor-item-header">
                <span class="ticket-no">{{ $servis->no_servis }}</span>
                <span class="badge-status badge-status--{{ $servis->status }}">{{ ucfirst($servis->status) }}</span>
            </div>
            <div class="motor-item-detail">
                {{ $servis->tanggal_masuk->format('d M Y, H:i') }}
                &nbsp;•&nbsp;
                <span class="fw-600">{{ $servis->motor->no_polisi }}</span>
                ({{ $servis->motor->pelanggan->nama }})
            </div>
            <div class="text-muted" style="font-size:13px;margin-top:4px;">
                {{ Str::limit($servis->keluhan, 80) }}
            </div>
        </div>
        @empty
        <p class="text-muted" style="padding:1rem 0;">Belum ada riwayat servis.</p>
        @endforelse
    </div>
</div>
@endsection

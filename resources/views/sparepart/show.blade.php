@extends('layouts.app')

@section('title', 'Detail Sparepart')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Detail Sparepart</h2>
        <p class="page-subheading">Informasi stok &amp; harga</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('sparepart.edit', $sparepart) }}" class="btn-secondary-outline">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('sparepart.index') }}" class="btn-secondary-outline">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="bengkel-grid-2">
    {{-- Info sparepart --}}
    <div class="bengkel-panel">
        <h2 class="panel-title">Informasi Part</h2>
        <div class="pelanggan-detail-info">
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-upc-scan"></i> Kode Part</span>
                <span class="detail-value"><span class="kode-part">{{ $sparepart->kode_part }}</span></span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-box-seam"></i> Nama Part</span>
                <span class="detail-value fw-600">{{ $sparepart->nama_part }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-tag"></i> Kategori</span>
                <span class="detail-value">
                    @if($sparepart->kategori)
                    <span class="badge-kategori">{{ $sparepart->kategori }}</span>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-rulers"></i> Satuan</span>
                <span class="detail-value">{{ $sparepart->satuan }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-arrow-down-circle"></i> Harga Beli</span>
                <span class="detail-value text-muted" style="font-family:var(--font-mono);">
                    Rp {{ number_format($sparepart->harga_beli, 0, ',', '.') }}
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-arrow-up-circle"></i> Harga Jual</span>
                <span class="detail-value fw-600" style="font-family:var(--font-mono);color:var(--accent-dark);">
                    Rp {{ number_format($sparepart->harga_jual, 0, ',', '.') }}
                </span>
            </div>
            @php
                $margin = $sparepart->harga_jual - $sparepart->harga_beli;
                $pct    = $sparepart->harga_beli > 0 ? round($margin / $sparepart->harga_beli * 100, 1) : 0;
            @endphp
            <div class="detail-row">
                <span class="detail-label"><i class="bi bi-percent"></i> Margin</span>
                <span class="detail-value {{ $margin >= 0 ? '' : 'text-danger' }}" style="font-family:var(--font-mono);">
                    Rp {{ number_format($margin, 0, ',', '.') }} <span class="text-muted">({{ $pct }}%)</span>
                </span>
            </div>
        </div>
    </div>

    {{-- Stok info + tambah stok --}}
    <div class="bengkel-panel">
        <h2 class="panel-title">Informasi Stok</h2>
        <div class="stok-detail-card {{ $sparepart->stokMenipis() ? 'stok-detail-card--warn' : '' }}">
            <div class="stok-big-number">{{ $sparepart->stok }}</div>
            <div class="stok-big-label">{{ $sparepart->satuan }} tersisa</div>
            @if($sparepart->stokMenipis())
            <div class="stok-alert-chip">
                <i class="bi bi-exclamation-triangle-fill"></i>
                Stok menipis! Minimum: {{ $sparepart->stok_minimum }}
            </div>
            @else
            <div class="stok-ok-chip">
                <i class="bi bi-check-circle-fill"></i>
                Stok aman (min. {{ $sparepart->stok_minimum }})
            </div>
            @endif
        </div>

        <hr style="border:none;border-top:1px solid var(--border);margin:20px 0;">

        <h3 style="font-size:14px;font-weight:600;margin:0 0 12px;">Tambah / Kurangi Stok</h3>
        <form method="POST" action="{{ route('sparepart.updateStok', $sparepart) }}" class="bengkel-form stok-form">
            @csrf
            <div class="stok-adjust-row">
                <input type="number" name="jumlah" id="jumlahStok" class="form-control"
                    placeholder="Contoh: +10 atau -3" required style="max-width:160px;">
                <span class="text-muted" style="font-size:13px;">{{ $sparepart->satuan }}</span>
                <button type="submit" class="btn-primary" onclick="return confirmStok()">
                    <i class="bi bi-plus-slash-minus"></i> Update stok
                </button>
            </div>
            <p class="field-hint">Masukkan angka positif untuk tambah, negatif untuk kurangi.</p>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmStok() {
    const val = parseInt(document.getElementById('jumlahStok').value);
    if (isNaN(val)) return false;
    const aksi = val >= 0 ? `menambah ${val}` : `mengurangi ${Math.abs(val)}`;
    return confirm(`Konfirmasi: ${aksi} stok sparepart ini?`);
}
</script>
@endpush

@extends('layouts.app')

@section('title', 'Detail Servis ' . $servis->no_servis)

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Detail Servis</h2>
        <p class="page-subheading">{{ $servis->no_servis }}</p>
    </div>
    <a href="{{ route('servis.index') }}" class="btn-secondary-outline">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="bengkel-panel" style="padding: 2rem;">
    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
        <div>
            <h3 style="margin-top:0; color: var(--primary);">Bengkel AHASS</h3>
            <p class="text-muted" style="margin: 0;">Nota Servis / Pekerjaan Bengkel</p>
        </div>
        <div style="text-align: right;">
            <h4 style="margin: 0; font-size: 1.25rem;">{{ $servis->no_servis }}</h4>
            <p class="text-muted" style="margin: 0;">{{ $servis->tanggal_masuk->format('d M Y, H:i') }}</p>
            <div style="margin-top: 0.5rem;">
                <span class="badge-status badge-status--{{ $servis->status === 'menunggu' ? 'menunggu' : ($servis->status === 'dikerjakan' ? 'dikerjakan' : ($servis->status === 'selesai' ? 'selesai' : 'diambil')) }}">
                    {{ strtoupper($servis->status) }}
                </span>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <!-- Data Pelanggan -->
        <div>
            <h5 style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">Data Pelanggan</h5>
            <div style="background: var(--bg); padding: 1.25rem; border-radius: 8px;">
                <p style="margin: 0 0 0.5rem;"><strong>{{ $servis->motor->pelanggan->nama }}</strong></p>
                <p style="margin: 0 0 0.5rem; color: var(--text-muted);"><i class="bi bi-telephone"></i> {{ $servis->motor->pelanggan->no_hp }}</p>
                <p style="margin: 0; color: var(--text-muted);"><i class="bi bi-geo-alt"></i> {{ $servis->motor->pelanggan->alamat ?? '-' }}</p>
            </div>
        </div>

        <!-- Data Motor & Mekanik -->
        <div>
            <h5 style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">Data Kendaraan</h5>
            <div style="background: var(--bg); padding: 1.25rem; border-radius: 8px;">
                <p style="margin: 0 0 0.5rem;"><strong>{{ $servis->motor->no_polisi }}</strong> — {{ $servis->motor->merk }} {{ $servis->motor->tipe }} ({{ $servis->motor->tahun }})</p>
                <p style="margin: 0 0 0.5rem; color: var(--text-muted);"><i class="bi bi-person-workspace"></i> Mekanik: <strong>{{ $servis->mekanik->nama ?? '-' }}</strong></p>
                <p style="margin: 0; color: var(--text-muted);"><i class="bi bi-calendar-check"></i> Tgl Selesai/Ambil: {{ $servis->tanggal_keluar ? $servis->tanggal_keluar->format('d M Y, H:i') : '-' }}</p>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 2rem;">
        <h5 style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">Keluhan, Diagnosa & Catatan</h5>
        <div style="background: var(--bg); padding: 1.25rem; border-radius: 8px;">
            <div style="margin-bottom: 1rem;">
                <strong>Keluhan Pelanggan:</strong><br>
                <span class="text-muted">{{ $servis->keluhan ?: '-' }}</span>
            </div>
            <div style="margin-bottom: 1rem;">
                <strong>Diagnosa Mekanik:</strong><br>
                <span class="text-muted">{{ $servis->diagnosa ?: '-' }}</span>
            </div>
            <div>
                <strong>Catatan Mekanik:</strong><br>
                <span class="text-muted">{{ $servis->catatan ?: 'Tidak ada catatan.' }}</span>
            </div>
        </div>
    </div>

    <h5 style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">Rincian Biaya</h5>
    <table class="bengkel-table" style="margin-bottom: 2rem;">
        <thead style="background: var(--bg);">
            <tr>
                <th>Deskripsi</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Biaya Jasa Servis</strong></td>
                <td class="text-center">1</td>
                <td class="text-right">Rp {{ number_format($servis->biaya_jasa, 0, ',', '.') }}</td>
                <td class="text-right"><strong>Rp {{ number_format($servis->biaya_jasa, 0, ',', '.') }}</strong></td>
            </tr>
            @foreach($servis->sparepart as $sp)
            <tr>
                <td>{{ $sp->sparepart->nama_part }} <span class="text-muted" style="font-size: 0.8rem;">({{ $sp->sparepart->kode_part }})</span></td>
                <td class="text-center">{{ $sp->qty }}</td>
                <td class="text-right">Rp {{ number_format($sp->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right"><strong>Rp {{ number_format($sp->subtotal, 0, ',', '.') }}</strong></td>
            </tr>
            @endforeach
        </tbody>
        <tfoot style="border-top: 2px solid #eee;">
            <tr>
                <td colspan="3" class="text-right" style="padding-top: 1rem; font-size: 1.25rem;"><strong>Total Tagihan</strong></td>
                <td class="text-right" style="padding-top: 1rem; font-size: 1.25rem; color: var(--primary);"><strong>Rp {{ number_format($servis->total_biaya, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    @if(in_array($servis->status, ['selesai', 'diambil']))
    <div style="text-align: center; margin-top: 3rem; color: var(--text-muted);">
        <p><i>Terima kasih telah mempercayakan kendaraan Anda kepada Bengkel AHASS.</i></p>
    </div>
    @endif
</div>
@endsection

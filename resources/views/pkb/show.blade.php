@extends('layouts.app')

@section('title', 'Proses PKB')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Proses PKB: {{ $servis->no_servis }}</h2>
        <p class="page-subheading">Update status pengerjaan servis</p>
    </div>
</div>

<div class="bengkel-panel mb-4">
    <h2 class="panel-title">Informasi Servis</h2>
    <div class="row">
        <div class="col-md-6 mb-3">
            <strong>Pelanggan:</strong><br>
            {{ $servis->motor->pelanggan->nama }} ({{ $servis->motor->pelanggan->no_hp }})
        </div>
        <div class="col-md-6 mb-3">
            <strong>Motor:</strong><br>
            {{ $servis->motor->no_polisi }} - {{ $servis->motor->merk }} {{ $servis->motor->tipe_motor }}
        </div>
        <div class="col-md-6 mb-3">
            <strong>Mekanik Ditugaskan:</strong><br>
            {{ $servis->mekanik ? $servis->mekanik->nama : 'Belum ditentukan' }}
        </div>
        <div class="col-md-6 mb-3">
            <strong>Waktu Masuk:</strong><br>
            {{ $servis->tanggal_masuk->format('d M Y H:i') }}
        </div>
        <div class="col-12 mb-3">
            <strong>Keluhan:</strong><br>
            {{ $servis->keluhan }}
        </div>
        <div class="col-12 mb-3">
            <strong>Diagnosa:</strong><br>
            {{ $servis->diagnosa ?: '-' }}
        </div>
        <div class="col-12">
            <strong>Sparepart yang Dipakai:</strong><br>
            @if($servis->sparepart->isEmpty())
                <span class="text-muted">-</span>
            @else
                <ul style="padding-left: 20px; margin-top: 4px; margin-bottom: 0;">
                @foreach($servis->sparepart as $sp)
                    <li>{{ $sp->sparepart->nama_part }} ({{ $sp->qty }}x)</li>
                @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

<form method="POST" action="{{ route('pkb.update', $servis->id) }}" class="bengkel-form">
    @csrf
    @method('PUT')

    <div class="bengkel-panel">
        <h2 class="panel-title">Update Pengerjaan</h2>
        
        <div class="form-group">
            <label for="catatan">Catatan mekanik</label>
            <textarea name="catatan" id="catatan" rows="3" class="form-control">{{ old('catatan', $servis->catatan) }}</textarea>
            @error('catatan') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="status">Status Pengerjaan</label>
            <select name="status" id="status" class="form-control" required>
                @if($servis->status == 'menunggu')
                    <option value="dikerjakan">Dikerjakan</option>
                    <option value="selesai">Selesai</option>
                    <option value="batal">Batal</option>
                @elseif($servis->status == 'dikerjakan')
                    <option value="selesai">Selesai</option>
                    <option value="batal">Batal</option>
                @endif
            </select>
            @error('status') <span class="field-error">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="form-actions mt-4">
        <button type="submit" class="btn-primary"><i class="bi bi-save"></i> Simpan & Update Status</button>
        <a href="{{ route('pkb.index') }}" class="btn-secondary-outline">Kembali</a>
    </div>
</form>
@endsection

@extends('layouts.app')

@section('title', 'Tambah Jadwal Mekanik')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Tambah Jadwal</h2>
        <p class="page-subheading">Atur jadwal shift mekanik</p>
    </div>
    <a href="{{ route('jadwal.index') }}" class="btn-secondary-outline">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="bengkel-panel form-panel">
    <form method="POST" action="{{ route('jadwal.store') }}" class="bengkel-form" id="formJadwal">
        @csrf

        <div class="form-group">
            <label for="mekanik_id">Mekanik <span class="required">*</span></label>
            <select name="mekanik_id" id="mekanik_id" class="form-control @error('mekanik_id') is-invalid @enderror" required>
                <option value="" disabled selected>Pilih mekanik...</option>
                @foreach ($mekaniks as $mek)
                <option value="{{ $mek->id }}" {{ old('mekanik_id') == $mek->id ? 'selected' : '' }}>
                    {{ $mek->nama }}@if($mek->jabatan) — {{ $mek->jabatan }}@endif
                </option>
                @endforeach
            </select>
            @error('mekanik_id') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tanggal">Tanggal <span class="required">*</span></label>
                <input type="date" name="tanggal" id="tanggal"
                    class="form-control @error('tanggal') is-invalid @enderror"
                    value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                @error('tanggal') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>



            <div class="form-group">
                <label for="status">Status Kehadiran <span class="required">*</span></label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="hadir" {{ old('status', 'hadir') === 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                    <option value="izin"  {{ old('status') === 'izin'  ? 'selected' : '' }}>🟡 Izin</option>
                </select>
                @error('status') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan"
                class="form-control @error('keterangan') is-invalid @enderror"
                value="{{ old('keterangan') }}" placeholder="Contoh: Ganti jadwal karena sakit">
            @error('keterangan') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="bi bi-calendar-check"></i> Simpan Jadwal
            </button>
            <a href="{{ route('jadwal.index') }}" class="btn-secondary-outline">Batal</a>
        </div>
    </form>
</div>
@endsection

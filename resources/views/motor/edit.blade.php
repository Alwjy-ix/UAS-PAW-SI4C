@extends('layouts.app')

@section('title', 'Edit Motor')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Edit Motor</h2>
        <p class="page-subheading">Perbarui data motor <strong>{{ $motor->no_polisi }}</strong></p>
    </div>
    <a href="{{ route('motor.index') }}" class="btn-secondary-outline">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="bengkel-panel form-panel">
    <form method="POST" action="{{ route('motor.update', $motor) }}" class="bengkel-form" id="formEditMotor">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="pelanggan_id">Pemilik / Pelanggan <span class="required">*</span></label>
            <select name="pelanggan_id" id="pelanggan_id" class="form-control @error('pelanggan_id') is-invalid @enderror" required>
                @foreach ($pelanggans as $pelanggan)
                <option value="{{ $pelanggan->id }}"
                    {{ old('pelanggan_id', $motor->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                    {{ $pelanggan->nama }} — {{ $pelanggan->no_hp }}
                </option>
                @endforeach
            </select>
            @error('pelanggan_id') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="no_polisi">No. Polisi <span class="required">*</span></label>
                <input type="text" name="no_polisi" id="no_polisi"
                    class="form-control @error('no_polisi') is-invalid @enderror"
                    value="{{ old('no_polisi', $motor->no_polisi) }}"
                    style="text-transform:uppercase" required>
                @error('no_polisi') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="merk">Merk <span class="required">*</span></label>
                <input type="text" name="merk" id="merk"
                    class="form-control @error('merk') is-invalid @enderror"
                    value="{{ old('merk', $motor->merk) }}" required>
                @error('merk') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tipe_motor">Tipe Motor <span class="required">*</span></label>
                <input type="text" name="tipe_motor" id="tipe_motor"
                    class="form-control @error('tipe_motor') is-invalid @enderror"
                    value="{{ old('tipe_motor', $motor->tipe_motor) }}" required>
                @error('tipe_motor') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="tahun_pembuatan">Tahun Pembuatan</label>
                <input type="number" name="tahun_pembuatan" id="tahun_pembuatan"
                    class="form-control @error('tahun_pembuatan') is-invalid @enderror"
                    value="{{ old('tahun_pembuatan', $motor->tahun_pembuatan) }}"
                    min="1980" max="{{ date('Y') + 1 }}">
                @error('tahun_pembuatan') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="warna">Warna</label>
                <input type="text" name="warna" id="warna"
                    class="form-control @error('warna') is-invalid @enderror"
                    value="{{ old('warna', $motor->warna) }}" placeholder="Contoh: Merah">
                @error('warna') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="no_rangka">No. Rangka</label>
                <input type="text" name="no_rangka" id="no_rangka"
                    class="form-control @error('no_rangka') is-invalid @enderror"
                    value="{{ old('no_rangka', $motor->no_rangka) }}">
                @error('no_rangka') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="no_mesin">No. Mesin</label>
            <input type="text" name="no_mesin" id="no_mesin"
                class="form-control @error('no_mesin') is-invalid @enderror"
                value="{{ old('no_mesin', $motor->no_mesin) }}">
            @error('no_mesin') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="bi bi-check-lg"></i> Simpan Perubahan
            </button>
            <a href="{{ route('motor.index') }}" class="btn-secondary-outline">Batal</a>
        </div>
    </form>
</div>
@endsection

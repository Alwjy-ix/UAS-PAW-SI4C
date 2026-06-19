@extends('layouts.app')

@section('title', 'Tambah Motor')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Tambah Motor Baru</h2>
        <p class="page-subheading">Daftarkan motor pelanggan ke bengkel</p>
    </div>
    <a href="{{ route('motor.index') }}" class="btn-secondary-outline">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="bengkel-panel form-panel">
    <form method="POST" action="{{ route('motor.store') }}" class="bengkel-form" id="formMotor">
        @csrf

        <div class="form-group">
            <label for="pelanggan_id">Pemilik / Pelanggan <span class="required">*</span></label>
            <select name="pelanggan_id" id="pelanggan_id" class="form-control @error('pelanggan_id') is-invalid @enderror" required>
                <option value="" disabled selected>Pilih pelanggan pemilik motor...</option>
                @foreach ($pelanggans as $pelanggan)
                <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
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
                    value="{{ old('no_polisi') }}" placeholder="Contoh: B 1234 XYZ"
                    style="text-transform:uppercase" required>
                @error('no_polisi') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="merk">Merk <span class="required">*</span></label>
                <input type="text" name="merk" id="merk"
                    class="form-control @error('merk') is-invalid @enderror"
                    value="{{ old('merk', 'Honda') }}" placeholder="Contoh: Honda" required>
                @error('merk') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="tipe_motor">Tipe Motor <span class="required">*</span></label>
                <input type="text" name="tipe_motor" id="tipe_motor"
                    class="form-control @error('tipe_motor') is-invalid @enderror"
                    value="{{ old('tipe_motor') }}" placeholder="Contoh: Vario 150, CBR 150R" required>
                @error('tipe_motor') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="tahun_pembuatan">Tahun Pembuatan</label>
                <input type="number" name="tahun_pembuatan" id="tahun_pembuatan"
                    class="form-control @error('tahun_pembuatan') is-invalid @enderror"
                    value="{{ old('tahun_pembuatan') }}" placeholder="{{ date('Y') }}"
                    min="1980" max="{{ date('Y') + 1 }}">
                @error('tahun_pembuatan') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="warna">Warna</label>
                <input type="text" name="warna" id="warna"
                    class="form-control @error('warna') is-invalid @enderror"
                    value="{{ old('warna') }}" placeholder="Contoh: Merah, Hitam, Putih">
                @error('warna') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="no_rangka">No. Rangka</label>
                <input type="text" name="no_rangka" id="no_rangka"
                    class="form-control @error('no_rangka') is-invalid @enderror"
                    value="{{ old('no_rangka') }}" placeholder="MH1...">
                @error('no_rangka') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="no_mesin">No. Mesin</label>
            <input type="text" name="no_mesin" id="no_mesin"
                class="form-control @error('no_mesin') is-invalid @enderror"
                value="{{ old('no_mesin') }}" placeholder="JB...">
            @error('no_mesin') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="bi bi-check-lg"></i> Simpan Motor
            </button>
            <a href="{{ route('motor.index') }}" class="btn-secondary-outline">Batal</a>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Tambah Pelanggan Baru</h2>
        <p class="page-subheading">Isi data pelanggan di bawah ini</p>
    </div>
    <a href="{{ route('pelanggan.index') }}" class="btn-secondary-outline">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="bengkel-panel form-panel">
    <form method="POST" action="{{ route('pelanggan.store') }}" class="bengkel-form" id="formPelanggan">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="nama">Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                    value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" required>
                @error('nama') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="no_ktp">No. KTP</label>
                <input type="text" name="no_ktp" id="no_ktp" class="form-control @error('no_ktp') is-invalid @enderror"
                    value="{{ old('no_ktp') }}" placeholder="NIK 16 digit" minlength="16" maxlength="16">
                @error('no_ktp') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="no_hp">No. WhatsApp / HP <span class="required">*</span></label>
                <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                    value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" required>
                @error('no_hp') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="Contoh: budi@email.com">
                @error('email') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror"
                placeholder="Jl. Contoh No. 1, Kelurahan, Kecamatan, Kota">{{ old('alamat') }}</textarea>
            @error('alamat') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="bi bi-person-check-fill"></i> Simpan Pelanggan
            </button>
            <a href="{{ route('pelanggan.index') }}" class="btn-secondary-outline">Batal</a>
        </div>
    </form>
</div>
@endsection

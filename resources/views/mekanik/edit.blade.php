@extends('layouts.app')

@section('title', 'Edit Mekanik')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Edit Mekanik</h2>
        <p class="page-subheading">Perbarui data <strong>{{ $mekanik->nama }}</strong></p>
    </div>
    <a href="{{ route('mekanik.index') }}" class="btn-secondary-outline">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="bengkel-panel form-panel">
    <form method="POST" action="{{ route('mekanik.update', $mekanik) }}" class="bengkel-form" id="formEditMekanik">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="npk">NPK (Nomor Pokok Pegawai)</label>
                <input type="text" name="npk" id="npk"
                    class="form-control @error('npk') is-invalid @enderror"
                    value="{{ old('npk', $mekanik->npk) }}">
                @error('npk') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="nama">Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="nama" id="nama"
                    class="form-control @error('nama') is-invalid @enderror"
                    value="{{ old('nama', $mekanik->nama) }}" required>
                @error('nama') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan"
                    class="form-control @error('jabatan') is-invalid @enderror"
                    value="{{ old('jabatan', $mekanik->jabatan) }}">
                @error('jabatan') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="no_hp">No. HP</label>
                <input type="text" name="no_hp" id="no_hp"
                    class="form-control @error('no_hp') is-invalid @enderror"
                    value="{{ old('no_hp', $mekanik->no_hp) }}">
                @error('no_hp') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="status">Status <span class="required">*</span></label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="aktif" {{ old('status', $mekanik->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status', $mekanik->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="bi bi-check-lg"></i> Simpan Perubahan
            </button>
            <a href="{{ route('mekanik.index') }}" class="btn-secondary-outline">Batal</a>
        </div>
    </form>
</div>
@endsection

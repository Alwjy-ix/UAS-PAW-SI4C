@extends('layouts.app')

@section('title', 'Tambah Mekanik')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Tambah Mekanik Baru</h2>
        <p class="page-subheading">Daftarkan teknisi ke bengkel</p>
    </div>
    <a href="{{ route('mekanik.index') }}" class="btn-secondary-outline">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="bengkel-panel form-panel">
    <form method="POST" action="{{ route('mekanik.store') }}" class="bengkel-form" id="formMekanik">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="npk">NPK (Nomor Pokok Pegawai)</label>
                <input type="text" name="npk" id="npk"
                    class="form-control @error('npk') is-invalid @enderror"
                    value="{{ old('npk') }}" placeholder="Contoh: 12345">
                @error('npk') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="nama">Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="nama" id="nama"
                    class="form-control @error('nama') is-invalid @enderror"
                    value="{{ old('nama') }}" placeholder="Nama teknisi" required>
                @error('nama') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan"
                    class="form-control @error('jabatan') is-invalid @enderror"
                    value="{{ old('jabatan') }}" placeholder="Contoh: Kepala Mekanik, Teknisi">
                @error('jabatan') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="no_hp">No. HP</label>
                <input type="text" name="no_hp" id="no_hp"
                    class="form-control @error('no_hp') is-invalid @enderror"
                    value="{{ old('no_hp') }}" placeholder="0812-xxxx-xxxx">
                @error('no_hp') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>



        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="bi bi-person-check-fill"></i> Simpan Mekanik
            </button>
            <a href="{{ route('mekanik.index') }}" class="btn-secondary-outline">Batal</a>
        </div>
    </form>
</div>
@endsection

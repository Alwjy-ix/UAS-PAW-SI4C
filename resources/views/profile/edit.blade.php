@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Edit Profil</h2>
        <p class="page-subheading">Perbarui informasi profil akun Anda</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn-secondary-outline">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="bengkel-panel form-panel">
    <form method="POST" action="{{ route('profile.update') }}" class="bengkel-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Lengkap <span class="required">*</span></label>
            <input type="text" name="name" id="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}" required>
            @error('name') 
                <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> 
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Alamat Email <span class="required">*</span></label>
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}" required>
            @error('email') 
                <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> 
            @enderror
        </div>

        <div class="form-actions" style="margin-top: 24px;">
            <button type="submit" class="btn-primary">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
            <a href="{{ route('dashboard') }}" class="btn-secondary-outline">Batal</a>
        </div>
    </form>
</div>
@endsection

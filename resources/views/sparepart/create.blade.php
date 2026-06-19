@extends('layouts.app')

@section('title', 'Tambah Sparepart')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Tambah Sparepart Baru</h2>
        <p class="page-subheading">Daftarkan suku cadang ke inventaris</p>
    </div>
    <a href="{{ route('sparepart.index') }}" class="btn-secondary-outline">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="bengkel-panel form-panel">
    <form method="POST" action="{{ route('sparepart.store') }}" class="bengkel-form" id="formSparepart">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="kode_part">Kode Part <span class="required">*</span></label>
                <input type="text" name="kode_part" id="kode_part"
                    class="form-control @error('kode_part') is-invalid @enderror"
                    value="{{ old('kode_part') }}" placeholder="Contoh: HND-OIL-10W40"
                    style="font-family:var(--font-mono)" required>
                @error('kode_part') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <input type="text" name="kategori" id="kategori"
                    class="form-control @error('kategori') is-invalid @enderror"
                    value="{{ old('kategori') }}" placeholder="Contoh: Oli, Filter, Busi" list="kategoriList">
                <datalist id="kategoriList">
                    <option value="Oli &amp; Pelumas">
                    <option value="Filter">
                    <option value="Busi">
                    <option value="Rantai &amp; Gear">
                    <option value="Rem">
                    <option value="Kelistrikan">
                    <option value="Bodi">
                    <option value="Aki">
                    <option value="Ban">
                </datalist>
                @error('kategori') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="nama_part">Nama Part <span class="required">*</span></label>
            <input type="text" name="nama_part" id="nama_part"
                class="form-control @error('nama_part') is-invalid @enderror"
                value="{{ old('nama_part') }}" placeholder="Contoh: Oli Mesin Honda 10W-40 800ml" required>
            @error('nama_part') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="harga_beli">Harga Beli (Rp) <span class="required">*</span></label>
                <input type="number" name="harga_beli" id="harga_beli"
                    class="form-control @error('harga_beli') is-invalid @enderror"
                    value="{{ old('harga_beli', 0) }}" min="0" step="500" required>
                @error('harga_beli') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="harga_jual">Harga Jual (Rp) <span class="required">*</span></label>
                <input type="number" name="harga_jual" id="harga_jual"
                    class="form-control @error('harga_jual') is-invalid @enderror"
                    value="{{ old('harga_jual', 0) }}" min="0" step="500" required>
                @error('harga_jual') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="stok">Stok Awal <span class="required">*</span></label>
                <input type="number" name="stok" id="stok"
                    class="form-control @error('stok') is-invalid @enderror"
                    value="{{ old('stok', 0) }}" min="0" required>
                @error('stok') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="stok_minimum">Stok Minimum <span class="required">*</span></label>
                <input type="number" name="stok_minimum" id="stok_minimum"
                    class="form-control @error('stok_minimum') is-invalid @enderror"
                    value="{{ old('stok_minimum', 5) }}" min="0" required>
                <span class="field-hint">Peringatan muncul bila stok ≤ nilai ini</span>
                @error('stok_minimum') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="satuan">Satuan <span class="required">*</span></label>
                <input type="text" name="satuan" id="satuan"
                    class="form-control @error('satuan') is-invalid @enderror"
                    value="{{ old('satuan', 'pcs') }}" placeholder="pcs / botol / set / meter"
                    list="satuanList" required>
                <datalist id="satuanList">
                    <option value="pcs"><option value="botol"><option value="set">
                    <option value="liter"><option value="meter"><option value="pasang">
                </datalist>
                @error('satuan') <span class="field-error"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span> @enderror
            </div>
        </div>

        <div class="margin-preview" id="marginInfo"></div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="bi bi-box-seam"></i> Simpan Sparepart
            </button>
            <a href="{{ route('sparepart.index') }}" class="btn-secondary-outline">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const beli  = document.getElementById('harga_beli');
    const jual  = document.getElementById('harga_jual');
    const info  = document.getElementById('marginInfo');

    function fmt(n) { return 'Rp ' + Number(n).toLocaleString('id-ID'); }

    function hitungMargin() {
        const b = parseFloat(beli.value || 0);
        const j = parseFloat(jual.value || 0);
        const margin = j - b;
        const pct    = b > 0 ? ((margin / b) * 100).toFixed(1) : 0;
        if (j > 0) {
            info.innerHTML = `<span class="${margin >= 0 ? 'margin-ok' : 'margin-minus'}">
                Margin: ${fmt(margin)} (${pct}%)
            </span>`;
        } else {
            info.textContent = '';
        }
    }

    beli.addEventListener('input', hitungMargin);
    jual.addEventListener('input', hitungMargin);
})();
</script>
@endpush

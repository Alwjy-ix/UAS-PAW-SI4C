@extends('layouts.app')

@section('title', 'Tambah servis & perbaikan')

@section('content')
<form method="POST" action="{{ route('servis.store') }}" class="bengkel-form" id="formServis">
    @csrf

    <div class="bengkel-panel">
        <h2 class="panel-title">Data motor & keluhan</h2>

        <div class="form-row">
            <div class="form-group">
                <label for="motor_id">Motor (plat nomor)</label>
                <select name="motor_id" id="motor_id" class="form-control" required>
                    <option value="" disabled selected>Pilih motor...</option>
                    @foreach ($motors as $motor)
                    <option value="{{ $motor->id }}">{{ $motor->no_polisi }} - {{ $motor->tipe_motor }} ({{ $motor->pelanggan->nama }})</option>
                    @endforeach
                </select>
                @error('motor_id') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="mekanik_id">Mekanik <span class="required">*</span></label>
                <select name="mekanik_id" id="mekanik_id" class="form-control" required>
                    <option value="" disabled selected>Pilih mekanik...</option>
                    @foreach ($mekaniks as $mekanik)
                    <option value="{{ $mekanik->id }}">{{ $mekanik->nama }} - {{ $mekanik->jabatan }}</option>
                    @endforeach
                </select>
                @error('mekanik_id') <span class="field-error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="keluhan">Keluhan pelanggan</label>
            <textarea name="keluhan" id="keluhan" rows="2" class="form-control" required></textarea>
            @error('keluhan') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="diagnosa">Diagnosa awal</label>
            <textarea name="diagnosa" id="diagnosa" rows="2" class="form-control"></textarea>
        </div>
    </div>

    <div class="bengkel-panel">
        <h2 class="panel-title">Sparepart yang digunakan</h2>
        <div id="sparepartRows"></div>
        <button type="button" id="btnTambahPart" class="btn-secondary-outline">
            <i class="bi bi-plus-lg"></i> Tambah sparepart
        </button>
    </div>

    <div class="bengkel-panel">
        <h2 class="panel-title">Biaya</h2>
        <div class="form-row">
            <div class="form-group">
                <label for="biaya_jasa">Biaya jasa servis (Rp)</label>
                <input type="number" name="biaya_jasa" id="biaya_jasa" class="form-control" min="0" step="1000" required>
                @error('biaya_jasa') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Estimasi total</label>
                <div class="total-preview" id="totalPreview">Rp 0</div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary"><i class="bi bi-check-lg"></i> Simpan servis</button>
        <a href="{{ route('dashboard') }}" class="btn-secondary-outline">Batal</a>
    </div>
</form>

<template id="sparepartRowTemplate">
    <div class="sparepart-row">
        <select name="sparepart[__INDEX__][id]" class="form-control sparepart-select" required>
            <option value="" disabled selected>Pilih sparepart...</option>
            @foreach ($spareparts as $part)
            <option value="{{ $part->id }}" data-harga="{{ $part->harga_jual }}">{{ $part->nama_part }} ({{ $part->kode_part }}) - Rp {{ number_format($part->harga_jual, 0, ',', '.') }}</option>
            @endforeach
        </select>
        <input type="number" name="sparepart[__INDEX__][qty]" class="form-control sparepart-qty" min="1" value="1" required>
        <span class="sparepart-subtotal">Rp 0</span>
        <button type="button" class="btn-remove-row" aria-label="Hapus baris sparepart">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
</template>

<script>
(function () {
    let rowIndex = 0;
    const rowsContainer = document.getElementById('sparepartRows');
    const template = document.getElementById('sparepartRowTemplate').innerHTML;
    const biayaJasaInput = document.getElementById('biaya_jasa');
    const totalPreview = document.getElementById('totalPreview');

    function formatRupiah(value) {
        return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
    }

    function hitungTotal() {
        let totalPart = 0;
        rowsContainer.querySelectorAll('.sparepart-row').forEach(function (row) {
            const select = row.querySelector('.sparepart-select');
            const qty = parseInt(row.querySelector('.sparepart-qty').value || 0, 10);
            const opt = select.options[select.selectedIndex];
            const harga = opt ? parseFloat(opt.dataset.harga || 0) : 0;
            const subtotal = harga * qty;
            row.querySelector('.sparepart-subtotal').textContent = formatRupiah(subtotal);
            totalPart += subtotal;
        });
        totalPreview.textContent = formatRupiah(totalPart + parseFloat(biayaJasaInput.value || 0));
    }

    function tambahBaris() {
        const html = template.split('__INDEX__').join(rowIndex);
        const wrapper = document.createElement('div');
        wrapper.innerHTML = html.trim();
        const row = wrapper.firstElementChild;

        row.querySelector('.btn-remove-row').addEventListener('click', function () {
            row.remove();
            hitungTotal();
        });
        row.querySelector('.sparepart-select').addEventListener('change', hitungTotal);
        row.querySelector('.sparepart-qty').addEventListener('input', hitungTotal);

        rowsContainer.appendChild(row);
        rowIndex++;
    }

    document.getElementById('btnTambahPart').addEventListener('click', tambahBaris);
    biayaJasaInput.addEventListener('input', hitungTotal);
    tambahBaris();
})();
</script>
@endsection

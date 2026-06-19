@extends('layouts.app')

@section('title', 'Jadwal Mekanik')

@section('content')
<div class="bengkel-page-header">
    <div>
        <h2 class="page-heading">Jadwal Mekanik</h2>
        <p class="page-subheading">Kelola jadwal shift teknisi bengkel</p>
    </div>
    <a href="{{ route('jadwal.create') }}" class="btn-primary">
        <i class="bi bi-calendar-plus-fill"></i> Tambah jadwal
    </a>
</div>

{{-- Filter bar --}}
<form method="GET" action="{{ route('jadwal.index') }}" class="jadwal-filter-bar">
    <div class="form-group" style="margin:0">
        <label style="font-size:12px;font-weight:500;color:var(--ink-muted);display:block;margin-bottom:4px;">Dari</label>
        <input type="date" name="dari" value="{{ $dari }}" class="form-control" style="width:160px;">
    </div>
    <span class="jadwal-filter-sep">—</span>
    <div class="form-group" style="margin:0">
        <label style="font-size:12px;font-weight:500;color:var(--ink-muted);display:block;margin-bottom:4px;">Sampai</label>
        <input type="date" name="sampai" value="{{ $sampai }}" class="form-control" style="width:160px;">
    </div>
    <div class="form-group" style="margin:0">
        <label style="font-size:12px;font-weight:500;color:var(--ink-muted);display:block;margin-bottom:4px;">Mekanik</label>
        <select name="mekanik_id" class="form-control" style="width:180px;">
            <option value="">Semua mekanik</option>
            @foreach ($mekaniks as $mek)
            <option value="{{ $mek->id }}" {{ request('mekanik_id') == $mek->id ? 'selected' : '' }}>
                {{ $mek->nama }}
            </option>
            @endforeach
        </select>
    </div>
    <div style="align-self:flex-end;display:flex;gap:8px;">
        <button type="submit" class="btn-primary">
            <i class="bi bi-funnel"></i> Filter
        </button>
        <a href="{{ route('jadwal.index') }}" class="btn-secondary-outline">Reset</a>
    </div>
</form>

{{-- Kalender grid per hari --}}
@php
    $grouped = $jadwals->groupBy(fn($j) => $j->tanggal->format('Y-m-d'));
    $today   = now()->format('Y-m-d');
@endphp

@if ($jadwals->isEmpty())
<div class="bengkel-panel">
    <p class="empty-row" style="padding:2rem 0;">
        Tidak ada jadwal untuk rentang tanggal ini.
        <a href="{{ route('jadwal.create') }}">Tambah jadwal baru</a>.
    </p>
</div>
@else
<div class="jadwal-grid">
    @foreach ($grouped as $tanggalStr => $items)
    @php
        $tgl  = \Carbon\Carbon::parse($tanggalStr);
        $isToday = $tanggalStr === $today;
    @endphp
    <div class="jadwal-day-card {{ $isToday ? 'jadwal-day-card--today' : '' }}">
        <div class="jadwal-day-header">
            <div>
                <div class="jadwal-day-name">{{ $tgl->translatedFormat('l') }}</div>
                <div class="jadwal-day-date">{{ $tgl->format('d M Y') }}</div>
            </div>
            @if ($isToday)
            <span class="badge-today">Hari ini</span>
            @endif
        </div>
        <div class="jadwal-rows">
            @foreach ($items as $jadwal)
            <div class="jadwal-row">

                <div class="jadwal-mekanik-name">
                    <div class="mekanik-avatar" style="width:26px;height:26px;font-size:11px;">
                        {{ strtoupper(substr($jadwal->mekanik->nama, 0, 1)) }}
                    </div>
                    {{ $jadwal->mekanik->nama }}
                </div>
                <div class="jadwal-status-wrap">
                    {{-- Mini-form ganti status --}}
                    <form method="POST" action="{{ route('jadwal.updateStatus', $jadwal) }}" class="inline-form">
                        @csrf
                        <select name="status" class="status-select status-select--{{ $jadwal->status }}"
                                onchange="this.form.submit()" title="Ubah status">
                            <option value="hadir" {{ $jadwal->status === 'hadir' ? 'selected' : '' }}>✅ Hadir</option>
                            <option value="izin"  {{ $jadwal->status === 'izin'  ? 'selected' : '' }}>🟡 Izin</option>
                        </select>
                    </form>
                </div>
                <div class="jadwal-actions">
                    <a href="{{ route('jadwal.edit', $jadwal) }}" class="btn-icon btn-icon--edit" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('jadwal.destroy', $jadwal) }}"
                          onsubmit="return confirm('Hapus jadwal ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-icon btn-icon--danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @if($jadwal->keterangan)
            <div class="jadwal-keterangan">
                <i class="bi bi-chat-left-text"></i> {{ $jadwal->keterangan }}
            </div>
            @endif
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection

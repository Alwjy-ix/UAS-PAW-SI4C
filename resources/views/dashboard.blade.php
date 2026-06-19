@extends('layouts.app')

@section('title', 'Dashboard overview')

@section('content')
<div class="bengkel-stats">
    <div class="stat-card">
        <span class="stat-label">Pelanggan terdaftar</span>
        <span class="stat-value">{{ $totalPelanggan }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Motor terdaftar</span>
        <span class="stat-value">{{ $totalMotor }}</span>
    </div>
    <div class="stat-card stat-card--accent">
        <span class="stat-label">Servis berjalan</span>
        <span class="stat-value">{{ $servisBerjalan }}</span>
    </div>
    <div class="stat-card stat-card--warn">
        <span class="stat-label">Sparepart menipis</span>
        <span class="stat-value">{{ $sparepartMenipis }}</span>
    </div>
</div>

{{-- ── Grafik Highcharts ──────────────────────────────────── --}}
<div class="bengkel-panel">
    <h2 class="panel-title">Grafik Servis &amp; Omzet — 6 Bulan Terakhir</h2>
    <div id="chartServis" style="height:320px;"></div>
</div>

<div class="bengkel-grid-2">
    <div class="bengkel-panel">
        <h2 class="panel-title">Servis terbaru</h2>
        <table class="bengkel-table">
            <thead>
                <tr>
                    <th>No. servis</th>
                    <th>Motor</th>
                    <th>Pelanggan</th>
                    <th>Tanggal masuk</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($servisTerbaru as $servis)
                <tr>
                    <td><span class="ticket-no">{{ $servis->no_servis }}</span></td>
                    <td>{{ $servis->motor->no_polisi }}</td>
                    <td>{{ $servis->motor->pelanggan->nama }}</td>
                    <td class="text-muted" style="font-size:13px;">{{ $servis->tanggal_masuk->format('d M Y') }}</td>
                    <td>
                        @if($servis->status == 'menunggu')
                            <span class="badge-status badge-status--menunggu">Menunggu</span>
                        @elseif($servis->status == 'dikerjakan')
                            <span class="badge-status badge-status--dikerjakan">Dikerjakan</span>
                        @elseif($servis->status == 'selesai')
                            <span class="badge-status badge-status--selesai">Selesai</span>
                        @elseif($servis->status == 'batal')
                            <span class="badge-status badge-status--batal">Batal</span>
                        @else
                            <span class="badge-status badge-status--diambil">Diambil</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-row">Belum ada data servis.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bengkel-panel">
        <div class="panel-title-row">
            <h2 class="panel-title" style="margin:0;">Jadwal mekanik hari ini</h2>
            <a href="{{ route('jadwal.index') }}" class="panel-link">Lihat semua <i class="bi bi-arrow-right"></i></a>
        </div>
        @if ($jadwalHariIni->isEmpty())
        <p class="text-muted" style="padding:16px 0;font-size:14px;">Belum ada jadwal hari ini.
            <a href="{{ route('jadwal.create') }}" class="text-link">+ Tambah jadwal</a>
        </p>
        @else
        <div class="jadwal-mini-list">
            @foreach ($jadwalHariIni as $jadwal)
            <div class="jadwal-mini-row">

                <div class="jadwal-mini-name">
                    <div class="mekanik-avatar" style="width:26px;height:26px;font-size:11px;">
                        {{ strtoupper(substr($jadwal->mekanik->nama, 0, 1)) }}
                    </div>
                    {{ $jadwal->mekanik->nama }}
                    @if($jadwal->mekanik->jabatan)
                    <span class="text-muted" style="font-size:11px;">· {{ $jadwal->mekanik->jabatan }}</span>
                    @endif
                </div>
                <span class="jadwal-kehadiran kehadiran--{{ $jadwal->status }}">
                    {{ $jadwal->status === 'hadir' ? '✅' : ($jadwal->status === 'izin' ? '🟡' : '🔴') }}
                    {{ ucfirst($jadwal->status) }}
                </span>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
Highcharts.chart('chartServis', {
    chart: {
        type: 'column',
        backgroundColor: 'transparent',
        style: { fontFamily: "'Plus Jakarta Sans', system-ui, sans-serif" }
    },
    title: {
        text: 'Jumlah Servis &amp; Total Omzet per Bulan',
        align: 'left',
        style: { fontSize: '14px', fontWeight: '600', color: '#221F1C' }
    },
    subtitle: {
        text: 'Data 6 bulan terakhir — Bengkel Honda AHASS',
        align: 'left',
        style: { fontSize: '12px', color: '#6B655C' }
    },
    xAxis: {
        categories: @json($bulanLabels),
        crosshair: true,
        accessibility: { description: 'Bulan' },
        labels: { style: { color: '#6B655C', fontSize: '12px' } }
    },
    yAxis: [
        {
            min: 0,
            title: { text: 'Jumlah Servis', style: { color: '#D6231C' } },
            labels: { style: { color: '#D6231C' } },
            allowDecimals: false
        },
        {
            min: 0,
            title: { text: 'Omzet (Rp)', style: { color: '#C97B2E' } },
            labels: {
                style: { color: '#C97B2E' },
                formatter: function () {
                    return 'Rp ' + Highcharts.numberFormat(this.value, 0, ',', '.');
                }
            },
            opposite: true
        }
    ],
    legend: { symbolRadius: 4, itemStyle: { fontWeight: '500', color: '#221F1C' } },
    tooltip: {
        shared: true,
        useHTML: true,
        headerFormat: '<table><caption style="font-weight:600;padding-bottom:4px">{point.key}</caption>',
        pointFormatter: function () {
            const color = this.series.color;
            const val = this.series.yAxis.index === 1
                ? 'Rp ' + Highcharts.numberFormat(this.y, 0, ',', '.')
                : this.y + ' servis';
            return `<tr>
                <th><svg width="20" height="10"><rect x="5" y="0" width="10" height="10" rx="3" ry="3" fill="${color}"/></svg> ${this.series.name}</th>
                <td style="padding-left:8px;font-weight:600">${val}</td>
            </tr>`;
        },
        footerFormat: '</table>'
    },
    plotOptions: {
        column: {
            pointPadding: 0.1,
            borderWidth: 0,
            borderRadius: 4
        }
    },
    credits: { enabled: false },
    series: [
        {
            name: 'Jumlah Servis',
            data: @json($dataServis),
            color: '#D6231C',
            yAxis: 0
        },
        {
            name: 'Omzet (Rp)',
            data: @json($dataOmzet),
            color: '#C97B2E',
            yAxis: 1
        }
    ]
});
</script>
@endpush


<?php

namespace App\Http\Controllers;

use App\Models\JadwalMekanik;
use App\Models\Motor;
use App\Models\Pelanggan;
use App\Models\Servis;
use App\Models\Sparepart;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Data kartu stat ────────────────────────────────────────
        $totalPelanggan   = Pelanggan::count();
        $totalMotor       = Motor::count();
        $servisBerjalan   = Servis::whereIn('status', ['menunggu', 'dikerjakan'])->count();
        $sparepartMenipis = Sparepart::whereColumn('stok', '<=', 'stok_minimum')->count();

        $servisTerbaru = Servis::with(['motor.pelanggan', 'mekanik'])
            ->latest('tanggal_masuk')->limit(6)->get();

        $jadwalHariIni = JadwalMekanik::with('mekanik')
            ->whereDate('tanggal', today())->get();

        // ── Data Highcharts: servis & omzet 6 bulan terakhir ──────
        $bulanLabels  = [];
        $dataServis   = [];
        $dataOmzet    = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $bulanLabels[] = $bulan->translatedFormat('M Y'); // e.g. "Jan 2026"

            $row = Servis::selectRaw("COUNT(*) as jumlah, COALESCE(SUM(total_biaya),0) as omzet")
                ->whereIn('status', ['selesai', 'diambil'])
                ->whereYear('tanggal_masuk', $bulan->year)
                ->whereMonth('tanggal_masuk', $bulan->month)
                ->first();

            $dataServis[] = (int)   $row->jumlah;
            $dataOmzet[]  = (float) $row->omzet;
        }

        return view('dashboard', compact(
            'totalPelanggan', 'totalMotor', 'servisBerjalan', 'sparepartMenipis',
            'servisTerbaru', 'jadwalHariIni',
            'bulanLabels', 'dataServis', 'dataOmzet'
        ));
    }
}


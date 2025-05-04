<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $menu = DB::table('menus')->count();
        $transaksi = DB::table('pesanans')->count();
        $pendapatan = DB::table('pesanans')->whereNotNull('total')->sum('total');

        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $chartData = DB::table('details')
            ->join('pesanans', 'details.pesanan_id', '=', 'pesanans.id')
            ->selectRaw('DATE(pesanans.created_at) as date, SUM(details.qty) as transaksi, SUM(pesanans.total) as pendapatan')
            ->whereBetween('pesanans.created_at', [$startDate, $endDate])
            ->whereNotNull('pesanans.total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return view('admin.home.home', compact('menu', 'transaksi', 'pendapatan', 'chartData'));
    }

    public function kasir()
    {
        return view('kasir.home.home');
    }
    public function owner()
    {
        return view('owner.home.home');
    }
    public function laporan()
    {
        return view('owner.laporan.laporan');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\detail;
use App\Models\pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class laporanController extends Controller
{

    public function index(Request $request)
    {
        $jenis = $request->get('jenis');
        $pesanans = collect(); // default kosong
        $details = collect();

        if ($jenis === 'penjualan') {
            $details = Detail::with('menu')
                ->select('menu_id', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(subtotal) as total_pendapatan'))
                ->when($request->search, function ($query) use ($request) {
                    $query->whereHas('menu', function ($q) use ($request) {
                        $q->where('menu', 'like', '%' . $request->search . '%');
                    });
                })
                ->groupBy('menu_id')
                ->get();
        } else {
            $pesanans = Pesanan::with(['details.menu', 'karyawan'])
                ->when($request->search, function ($query) use ($request) {
                    $query->where('kode_pesanan', 'like', '%' . $request->search . '%');
                })
                ->get();
        }

        return view('owner.laporan.laporan', compact('pesanans', 'details'));
    }
}
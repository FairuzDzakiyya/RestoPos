<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\detail;
use App\Models\pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class laporanController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->get('jenis');
        $pesanans = null;
        $details = null;

        if ($jenis === 'penjualan') {
            $details = Detail::with('menu')
                ->select('menu_id', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(subtotal) as total_pendapatan'))
                ->when($request->search, function ($query) use ($request) {
                    $query->whereHas('menu', function ($q) use ($request) {
                        $q->where('menu', 'like', '%' . $request->search . '%');
                    });
                })
                ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                    $query->whereBetween(DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date]);
                })
                ->groupBy('menu_id')
                ->paginate(7)
                ->appends([
                    'search' => $request->search,
                    'jenis' => 'penjualan',
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date
                ]);
        } else {
            $pesanans = Pesanan::with(['details.menu', 'karyawan'])
                ->when($request->search, function ($query) use ($request) {
                    $query->whereHas('karyawan', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
                })
                ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                    $query->whereBetween(DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date]);
                })
                ->paginate(7)
                ->appends([
                    'search' => $request->search,
                    'jenis' => 'transaksi',
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date
                ]);
        }

        return view('owner.laporan.laporan', compact('pesanans', 'details'));
    }

    public function exportExcel(Request $request)
    {
        $jenis = $request->query('jenis', 'transaksi');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $search = $request->query('search');

        $export = new LaporanExport($jenis, $startDate, $endDate, $search);

        $fileName = $jenis === 'penjualan'
            ? 'Laporan_Penjualan_Barang.xlsx'
            : 'Laporan_Transaksi.xlsx';

        return Excel::download($export, $fileName);
    }
}
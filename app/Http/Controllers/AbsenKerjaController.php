<?php

namespace App\Http\Controllers;

use App\Exports\AbsenKerjaExport;
use App\Imports\AbsenKerjaImport;
use App\Models\AbsenKerja;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AbsenKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        $search = $request->query('search');

        $absensis = AbsenKerja::with('user')
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10)
            ->appends(['search' => $search]);

        $users = User::all();

        // Tambahkan waktu realtime untuk form
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i');

        return view('absen', compact('absensis', 'users', 'currentDate', 'currentTime'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'tgl_absen' => 'required|date',
            'jam_masuk' => 'required',
            'status' => 'required|in:masuk,sakit,cuti',
        ]);

        // Gunakan waktu server untuk jam masuk dan tanggal
        $now = Carbon::now();

        $jamMasuk = $request->jam_masuk;
        $jamKeluar = null;
        $tglAbsen = $request->tgl_absen;

        // Jika status sakit/cuti, set jam khusus
        if (in_array($request->status, ['sakit', 'cuti'])) {
            $jamMasuk = '00:00:00';
            $jamKeluar = '00:00:00';
        } else {
            // Untuk status masuk, gunakan waktu server yang sebenarnya
            $jamMasuk = $now->format('H:i:s');
            $tglAbsen = $now->format('Y-m-d');
        }

        AbsenKerja::create([
            'user_id' => $request->user_id,
            'tgl_absen' => $tglAbsen,
            'jam_masuk' => $jamMasuk,
            'status' => $request->status,
            'jam_keluar' => $jamKeluar,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return redirect()->back()->with('success', 'Data absensi berhasil disimpan.');
    }



    /**
     * Display the specified resource.
     */
    public function show(AbsenKerja $absenKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AbsenKerja $absenKerja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tbl_absen_kerja,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $absen = AbsenKerja::findOrFail($request->id);
        $absen->update(['user_id' => $request->user_id]);

        return redirect()->route('absen')->with('success', 'Nama karyawan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        AbsenKerja::destroy($id);
        return redirect()->back()->with('success', 'Absen berhasil dihapus');
    }

    public function updateStatus(Request $request, $id)
    {
        $absen = AbsenKerja::findOrFail($id);
        $absen->status = $request->status;

        if (in_array($request->status, ['sakit', 'cuti'])) {
            $absen->jam_keluar = '00:00:00'; // Hanya waktu saja
        } else {
            $absen->jam_keluar = null;
        }

        $absen->save();

        return response()->json([
            'success' => true,
            'jam_keluar' => $absen->jam_keluar // Sudah hanya waktu
        ]);
    }

    public function selesaiKerja($id)
    {
        $absen = AbsenKerja::findOrFail($id);

        if ($absen->status === 'masuk') {
            $absen->jam_keluar = date('H:i:s'); // Simpan hanya jam saja
            $absen->save();
        }

        return response()->json([
            'success' => true,
            'jam_keluar' => $absen->jam_keluar
        ]);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new AbsenKerjaImport, $request->file('file'));

        return back()->with('success', 'Data member berhasil diimport.');
    }

    

    public function exportExcel()
    {
        logActivity('Export Excel', 'Mengunduh laporan absen dalam format Excel');
        return Excel::download(new AbsenKerjaExport, 'Absen.xlsx');
    }

    // Mengekspor data absensi ke format PDF

    public function exportPdf()
    {
        logActivity('Export PDF', 'Mengunduh laporan member dalam format PDF');

        $members = AbsenKerja::all();

        $pdf = Pdf::loadView('absen', compact('absensis'));

        return $pdf->download('laporan_absen.pdf');
    }
}

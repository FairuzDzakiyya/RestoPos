<?php

namespace App\Http\Controllers;

use App\Exports\PengajuanExport;
use App\Models\LogActivity;
use App\Models\Member;
use App\Models\Pengajuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajuans = Pengajuan::with('member')->get();
        $members = Member::all();
        return view('kasir.member.pengajuan', compact('pengajuans', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tahun = date('Y');
        $bulan = date('m');

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'nama_barang' => 'required|string|max:100',
            'tgl_pengajuan' => 'nullable|date', // nullable karena bisa auto isi
            'qty' => 'required|integer|min:1',
        ]);

        $lastKode = Pengajuan::selectRaw('COALESCE(MAX(CAST(SUBSTRING(kode_pengajuan, 10, 3) AS UNSIGNED)), 0) AS angka')
            ->whereRaw('SUBSTRING(kode_pengajuan, 4, 4) = ?', [$tahun])
            ->whereRaw('SUBSTRING(kode_pengajuan, 8, 2) = ?', [$bulan])
            ->value('angka');

        $noUrutBaru = $lastKode + 1;
        $kode_pengajuan = 'PGJ' . $tahun . $bulan . str_pad($noUrutBaru, 3, '0', STR_PAD_LEFT);

        Pengajuan::create([
            'kode_pengajuan' => $kode_pengajuan,
            'member_id' => $request->member_id,
            'nama_barang' => $request->nama_barang,
            'tgl_pengajuan' => $request->tgl_pengajuan ?? now()->toDateString(),
            'qty' => $request->qty,
            'terpenuhi' => false,
        ]);

        logActivity('Tambah Pengajuan', 'Menambahkan pengajuan ' . $kode_pengajuan . ' untuk barang ' . $request->nama_barang);

        return redirect()->route('pengajuan')->with('success', 'Pengajuan berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update([
            'member_id' => $request->member_id,
            'nama_barang' => $request->nama_barang,
            'tgl_pengajuan' => $request->tgl_pengajuan,
            'qty' => $request->qty,
        ]);

        logActivity('Update Pengajuan', 'Memperbarui pengajuan ' . $pengajuan->kode_pengajuan);

        return redirect()->back()->with('success', 'Pengajuan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Pengajuan::findOrFail($id);
        $kode = $id->kode_pengajuan;
        $id->delete();

        logActivity('Hapus Pengajuan', 'Menghapus pengajuan ' . $kode);

        return redirect()->route('pengajuan')->with('success', 'Pengajuan berhasil dihapus!');
    }

    /**
     * Toggle status terpenuhi (AJAX).
     */
    public function toggleTerpenuhi($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->terpenuhi = !$pengajuan->terpenuhi;
        $pengajuan->save();

        logActivity(
            'Toggle Status Terpenuhi',
            'Mengubah status pengajuan ' . $pengajuan->kode_pengajuan . ' menjadi ' . ($pengajuan->terpenuhi ? 'Terpenuhi' : 'Belum Terpenuhi')
        );

        return response()->json(['success' => true, 'terpenuhi' => $pengajuan->terpenuhi]);
    }

    public function exportPdf()
    {
        $pengajuans = Pengajuan::with('member')->get();
        $members = Member::all(); // tambahin ini

        logActivity('Export PDF', 'Mengunduh laporan pengajuan dalam format PDF');

        $pdf = Pdf::loadView('kasir.member.pdf', compact('pengajuans', 'members'));

        return $pdf->download('laporan_pengajuan.pdf');
    }

    public function exportExcel()
    {
        logActivity('Export Excel', 'Mengunduh laporan pengajuan dalam format Excel');
        return Excel
            ::download(new PengajuanExport, 'laporan_pengajuan.xlsx');
    }
}
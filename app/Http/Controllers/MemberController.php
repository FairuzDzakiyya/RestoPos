<?php

namespace App\Http\Controllers;

use App\Exports\MemberExport;
use App\Imports\MemberImport;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $members = Member::all( );
        return view('kasir.member.member', compact('members'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tahun = date('Y');
        $bulan = date('m');

        $request->validate([
            'nama_member' => 'required|string|max:50',
            'alamat' => 'nullable|string|max:100',
            'telp' => 'nullable|digits_between:8,15',
            'email' => 'nullable|email|max:50|unique:members,email',
        ]);

        // Ambil nomor urut terakhir untuk tahun & bulan yang sama
        $lastKode = Member::selectRaw('COALESCE(MAX(CAST(SUBSTRING(kode_member, 10, 3) AS UNSIGNED)), 0) AS angka')
            ->whereRaw('SUBSTRING(kode_member, 4, 4) = ?', [$tahun])
            ->whereRaw('SUBSTRING(kode_member, 8, 2) = ?', [$bulan])
            ->value('angka');

        $noUrutBaru = $lastKode + 1;

        // Format kode member: MBRYYYYMMXX
        $kode_member = 'MBR' . $tahun . $bulan . str_pad($noUrutBaru, 3, '0', STR_PAD_LEFT);

        Member::create([
            'kode_member' => $kode_member,
            'nama_member' => $request->nama_member,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'email' => $request->email,
        ]);

        return redirect()->route('member')->with('success', 'Member berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        // dd($request->all());
        $member = Member::findOrFail($id);
        $member->update([
            'nama_member' => $request->nama_member,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Member berhasil diupdate!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = Member::findOrFail($id);
        $id->delete();
        return redirect()->back()->with('success', 'Member berhasil dihapus!');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new MemberImport, $request->file('file'));

        return back()->with('success', 'Data member berhasil diimport.');
    }

    public function exportExcel()
    {
        logActivity('Export Excel', 'Mengunduh laporan pengajuan dalam format Excel');
        return Excel::download(new MemberExport, 'Member.xlsx');
    }

    public function exportPdf()
    {
        logActivity('Export PDF', 'Mengunduh laporan member dalam format PDF');

        $members = Member::all();

        $pdf = Pdf::loadView('kasir.member.memberpdf', compact('members'));

        return $pdf->download('laporan_member.pdf');
    }
}
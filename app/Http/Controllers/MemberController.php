<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::all();
        return view('kasir.member.member', compact('members'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kasir.member.create');
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

        return redirect()->back()->with('success', 'Kategori berhasil diupdate!');
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
}
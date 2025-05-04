<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $karyawans = User::when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->paginate(2) // bisa ganti 5 ke jumlah yang kamu mau
            ->appends(['search' => $search]);
        // $karyawans = User::all();
        return view('owner.karyawan', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,kasir,owner',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('karyawan')->with('success', 'Karyawan berhasil ditambahkan!');
    }
    
    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan')->with('success', 'Karyawan berhasil dihapus!');
    }
}

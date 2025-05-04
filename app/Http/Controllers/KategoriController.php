<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $kategoris = Kategori::when($search, function ($query, $search) {
            $query->where('nama_kategori', 'like', '%' . $search . '%');
        })
            ->paginate(2) // bisa ganti 5 ke jumlah yang kamu mau
            ->appends(['search' => $search]);

        return view('admin.menu.kategori', compact('kategoris'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit dalam halaman utama.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update kategori.
     */
    public function update(Request $request, $id)
    {

        // dd($request->all());
        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diupdate!');
    }

    /**
     * Hapus kategori.
     */
    public function destroy($id)
    {

        // dd($id);
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}

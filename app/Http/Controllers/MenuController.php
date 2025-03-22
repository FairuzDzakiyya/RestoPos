<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use Exception;
use Illuminate\Http\Request;
use Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search'); // ambil query dari input search

        $menus = Menu::with('kategori')
            ->when($search, function ($query, $search) {
                $query->where('menu', 'like', '%' . $search . '%');
            })
            ->get();

        $kategoris = Kategori::all();

        return view('admin.menu.menu', compact('menus', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Simpan gambar ke public/assets/menu
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $namaFile = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('assets/menu'), $namaFile);
            $gambarPath = 'assets/menu/' . $namaFile; // Path untuk disimpan ke database
        } else {
            $gambarPath = null;
        }

        Menu::create(array_merge($request->all(), ['gambar' => $gambarPath]));

        return redirect()->route('menu')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit(Menu $menu)
    {
        // 
    }


    public function update(Request $request)
    {
        // dd($request->all()); // Debug data yang dikirim
        $menu = Menu::findOrFail($request->id);

        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = [
            'kategori_id' => $request->kategori_id,
            'menu' => $request->menu,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($menu->gambar && file_exists(public_path($menu->gambar))) {
                unlink(public_path($menu->gambar));
            }

            // Simpan gambar baru
            $gambar = $request->file('gambar');
            $namaFile = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('assets/menu'), $namaFile);

            $data['gambar'] = 'assets/menu/' . $namaFile;
        }

        $menu->update($data);

        return redirect()->route('menu')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // dd(request()->method()); 
        $id = Menu::findOrFail($id);
        $id->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus');
    }
}

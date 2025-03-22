<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Tampilkan daftar menu untuk transaksi.
     */
    public function index()
    {
        $menus = Menu::all();
        $cart = session('cart', []); // Ambil keranjang dari session
        return view('kasir.transaksi.transaksi', compact('menus', 'cart'));
    }

    /**
     * Tambahkan item ke keranjang (session).
     */
    public function addToCart(Request $request)
    {
        $id = $request->id;
        $menu = Menu::find($id);

        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan');
        }

        $cart = session()->get('cart', []);

        // Jika menu sudah ada di keranjang, tambahkan qty
        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;
        } else {
            // Kalau belum ada, tambahkan menu ke keranjang
            $cart[$id] = [
                "menu" => $menu->menu,
                "harga" => $menu->harga,
                "qty" => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Menu ditambahkan ke keranjang');
    }

    /**
     * Hapus item dari keranjang.
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] > 1) {
                $cart[$id]['qty'] -= 1; // Kurangi qty
            } else {
                unset($cart[$id]); // Hapus jika qty tinggal 1
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item dihapus dari keranjang');
    }


    /**
     * Tampilkan halaman pembayaran.
     */
    public function show()
    {
        $details = session('cart', []); // Ambil data keranjang
        return view('kasir.transaksi.pembayaran', compact('details'));
    }

    /**
     * Proses transaksi dan simpan ke database.
     */
    public function store(Request $request)
    {
        $total_harga = $request->total_harga;
        $jumlah_uang = $request->jumlah_uang;
        $items = session('cart', []);

        if ($jumlah_uang < $total_harga) {
            return redirect()->back()->with('error', 'Jumlah uang tidak mencukupi!');
        }

        // Simpan pesanan
        $pesanan = Pesanan::create([
            'user_id' => auth()->user()->id,
            'tgl_pesan' => now(),
            'total' => $total_harga,
            'status' => 'selesai',
        ]);

        // Simpan detail pesanan
        foreach ($items as $id => $item) {
            Detail::create([
                'pesanan_id' => $pesanan->id,
                'menu_id' => $id,
                'qty' => $item['qty'],
                'harga' => $item['harga'],
                'subtotal' => $item['harga'] * $item['qty'],
            ]);
        }

        // Hitung kembalian
        $kembalian = $jumlah_uang - $total_harga;

        // Hapus keranjang
        session()->forget('cart');

        // Redirect ke halaman berhasil sambil mengirim data pesanan
        return redirect()->route('transaksi.berhasil', [
            'pesanan' => $pesanan->id,
            'kembalian' => $kembalian
        ]);
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['qty'] = max(1, (int) $request->qty); // Minimal 1
        }

        session()->put('cart', $cart);

        return redirect()->back(); // Refresh halaman biar update total harga
    }


    public function berhasil(Pesanan $pesanan, Request $request)
    {
        $kembalian = $request->query('kembalian', 0); // Ambil kembalian dari URL
        return view('kasir.transaksi.berhasil', compact('pesanan', 'kembalian'));
    }

    /**
     * Tampilkan halaman transaksi berhasil.
     */
    public function transaksiBerhasil($pesanan_id)
    {
        $pesanan = Pesanan::findOrFail($pesanan_id);
        return view('kasir.transaksi.berhasil', compact('pesanan'));
    }

    /**
     * Tampilkan struk pembayaran.
     */
    public function printStruk($pesanan_id)
    {
        $pesanan = Pesanan::with('details.menu')->findOrFail($pesanan_id);
        return view('kasir.transaksi.struk', compact('pesanan'));
    }
}
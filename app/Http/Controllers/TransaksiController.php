<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Member;
use App\Models\Menu;
use App\Models\Pesanan;
use DB;
use Illuminate\Http\Request;
use Log;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Throwable;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $menus = Menu::when($search, function ($query, $search) {
            $query->where('menu', 'like', '%' . $search . '%');
        })
            ->get();

        $cart = session('cart', []);
        $members = Member::all();

        return view('kasir.transaksi.transaksi', compact('menus', 'cart', 'members'));
    }


    public function cekMember(Request $request)
    {
        $phone = $request->phone;
        $member = Member::where('telp', $phone)->first();

        if (!$member) {
            return redirect()->route('transaksi')
                ->with('error', 'Member tidak ditemukan!')
                ->with('modal_open', true);
        }

        session()->put('member_id', $member->id);
        session()->put('member_nama', $member->nama_member);

        return redirect()->route('pembayaran')->with('success', 'Member ditemukan: ' . $member->nama_member);
    }

    public function addToCart(Request $request)
    {
        $id = $request->id;
        $menu = Menu::find($id);

        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan');
        }

        // Validasi stok minimal 2
        if ($menu->stok < 0) {
            return redirect()->back()->with('error', 'Stok menu ' . $menu->menu . ' tidak mencukupi (minimal 2)');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // Validasi apakah penambahan qty akan melebihi stok
            if (($cart[$id]['qty'] + 1) > $menu->stok) {
                return redirect()->back()->with('error', 'Stok menu ' . $menu->menu . ' tidak mencukupi');
            }
            $cart[$id]['qty'] += 1;
        } else {
            $cart[$id] = [
                "menu" => $menu->menu,
                "harga" => $menu->harga,
                "qty" => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Menu ditambahkan ke keranjang');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] > 1) {
                $cart[$id]['qty'] -= 1;
            } else {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item dihapus dari keranjang');
    }

    public function show()
    {
        $details = session('cart', []);
        $member = null;

        if (session()->has('member_id')) {
            $member = Member::find(session('member_id'));
        }

        return view('kasir.transaksi.pembayaran', compact('details', 'member'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'jumlah_uang' => str_replace([',', '.'], '', $request->jumlah_uang),
            'total_harga' => str_replace([',', '.'], '', $request->total_harga),
        ]);

        $request->validate([
            'jumlah_uang' => 'required|numeric|min:' . $request->total_harga,
        ]);

        $total_harga = (int) $request->total_harga;
        $jumlah_uang = (int) $request->jumlah_uang;
        $member_id = $request->member_id ?? session('member_id');
        $items = session('cart', []);

        // Validasi stok
        foreach ($items as $id => $item) {
            $menu = Menu::find($id);
            if (!$menu || $menu->stok < $item['qty']) {
                return redirect()->back()->with('error', "Stok untuk menu {$item['menu']} tidak mencukupi!");
            }
        }

        if ($jumlah_uang < $total_harga) {
            return redirect()->back()->with('error', 'Jumlah uang tidak mencukupi!');
        }

        DB::beginTransaction();

        try {
            $pesanan = Pesanan::create([
                'user_id' => auth()->user()->id,
                'kode_pesanan' => 'TRX' . time(),
                'tgl_pesan' => now(),
                'total' => $total_harga,
                'status' => 'selesai',
                'member_id' => $member_id,
            ]);

            foreach ($items as $id => $item) {
                Detail::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $id,
                    'member_id' => $member_id,
                    'qty' => $item['qty'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['qty'],
                ]);

                Menu::where('id', $id)->decrement('stok', $item['qty']);
            }

            DB::commit();

            $kembalian = $jumlah_uang - $total_harga;

            // Panggil fungsi cetak struk
            $this->cetakStruk($pesanan, $items, $total_harga, $jumlah_uang, $kembalian);

            // Hapus session setelah cetak berhasil
            session()->forget('cart');
            session()->forget('member_id');
            session()->forget('member_nama');

            return redirect()->route('transaksi')->with('success', 'Transaksi berhasil disimpan dan dicetak!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $menu = Menu::find($request->id);

        if (isset($cart[$request->id])) {
            // Validasi apakah qty baru akan melebihi stok
            if ((int) $request->qty > $menu->stok) {
                return redirect()->back()->with('error', 'Stok menu ' . $menu->menu . ' tidak mencukupi');
            }
            $cart[$request->id]['qty'] = max(1, (int) $request->qty);
        }

        session()->put('cart', $cart);

        return redirect()->back();
    }

    private function formatKanan($kiri, $kanan, $lebar = 32)
    {
        $spasi = $lebar - strlen($kiri) - strlen($kanan);
        return $kiri . str_repeat(' ', max(0, $spasi)) . $kanan;
    }

    private function cetakStruk($pesanan, $items, $total_harga, $jumlah_uang, $kembalian)
    {
        $printer = null;

        try {
            $connector = new WindowsPrintConnector("POS-51");
            $connector->finalize();
            $printer = new Printer($connector);

            // Header struk
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setFont(Printer::FONT_B);
            $printer->setTextSize(2, 2);
            $printer->text("KARES\n");

            $printer->setFont(Printer::FONT_A);
            $printer->setTextSize(1, 1);
            $printer->text("Jl. Siliwangi No. 45\n");

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text(str_repeat("-", 32) . "\n");
            $printer->text("Kasir: " . auth()->user()->name . "\n");
            $printer->text("No. Transaksi: " . $pesanan->kode_pesanan . "\n");
            $printer->text("Tgl Pesan: " . date('d-m-Y H:i:s') . "\n");

            // Ambil data member dari Detail pertama
            $detail = Detail::where('pesanan_id', $pesanan->id)->first();
            $memberName = "Non-Member";

            if ($detail && $detail->member_id) {
                $member = Member::find($detail->member_id);
                if ($member) {
                    $memberName = $member->nama_member;
                }
            } elseif (session()->has('member_nama')) {
                $memberName = session('member_nama');
            }

            $printer->text("Member   : " . $memberName . "\n");

            $printer->text(str_repeat("-", 32) . "\n");

            // Cetak items
            foreach ($items as $id => $item) {
                $nama = $item['menu'];
                $qty = $item['qty'];
                $harga = number_format($item['harga']);
                $subtotal = number_format($item['harga'] * $item['qty']);

                $printer->text("{$nama}\n");
                $printer->text($this->formatKanan("{$qty} x Rp{$harga}", "Rp" . $subtotal) . "\n");
            }

            $printer->text(str_repeat("-", 32) . "\n");
            $printer->text($this->formatKanan("Total    :", "Rp" . number_format($total_harga)) . "\n");
            $printer->text($this->formatKanan("Tunai    :", "Rp" . number_format($jumlah_uang)) . "\n");
            $printer->text($this->formatKanan("Kembali  :", "Rp" . number_format($kembalian)) . "\n");

            $printer->text(str_repeat("-", 32) . "\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Terima kasih!\n");
            $printer->pulse();
            $printer->cut();

        } catch (\Exception $e) {
            Log::error('Printer error: ' . $e->getMessage());
        } finally {
            if ($printer !== null) {
                try {
                    $printer->close();
                } catch (\Exception $e) {
                    Log::error('Error saat menutup printer: ' . $e->getMessage());
                }
            }
        }
    }
}
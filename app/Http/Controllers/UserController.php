<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan halaman utama dengan daftar buku terbaru.
     */
    public function index(Request $request)
    {
        $kategoris = \App\Models\KategoriBuku::all();
        $query = Buku::query();

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $bukus = $query->latest()->get();
        return view('user.home', compact('bukus', 'kategoris'));
    }

    /**
     * Menampilkan halaman tentang kami (About Us).
     */
    public function about()
    {
        return view('user.about');
    }

    /**
     * Menampilkan halaman kontak admin.
     */
    public function contact()
    {
        return view('user.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'pesan' => 'required'
        ]);
        
        \App\Models\Kontak::create([
            'nama' => $request->nama,
            'email' => Auth::check() ? Auth::user()->email : null,
            'pesan' => $request->pesan
        ]);

        return redirect()->route('contact')->with('success', 'Pesan berhasil dikirim ke Admin. Terima kasih!');
    }

    /**
     * Mencari buku berdasarkan judul atau deskripsi.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $bukus = Buku::where('judul_buku', 'like', "%{$query}%")
                     ->orWhere('deskripsi', 'like', "%{$query}%")
                     ->get();
        return view('user.search', compact('bukus', 'query'));
    }

    /**
     * Menampilkan halaman keranjang belanja (cart).
     */
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('user.cart', compact('cart'));
    }

    /**
     * Menambahkan buku ke dalam keranjang belanja.
     */
    public function addToCart(Request $request, Buku $buku)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$buku->id])) {
            if ($cart[$buku->id]['jumlah'] + 1 > $buku->stok) {
                return redirect()->back()->with('error', 'Maaf, stok tidak mencukupi.');
            }
            $cart[$buku->id]['jumlah']++;
        } else {
            if ($buku->stok < 1) {
                return redirect()->back()->with('error', 'Maaf, stok buku habis.');
            }
            $cart[$buku->id] = [
                'id' => $buku->id,
                'judul_buku' => $buku->judul_buku,
                'harga' => $buku->harga,
                'jumlah' => 1,
                'gambar_buku' => $buku->gambar_buku
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Buku ditambahkan ke keranjang.');
    }

    /**
     * Menghapus buku dari keranjang belanja.
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Buku dihapus dari keranjang.');
    }

    /**
     * Memperbarui jumlah buku di keranjang belanja.
     */
    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            $buku = Buku::find($id);
            $requestedQty = max(1, (int)$request->jumlah);
            
            if ($buku && $requestedQty > $buku->stok) {
                return redirect()->back()->with('error', "Maksimal pemesanan untuk buku ini adalah {$buku->stok} buah.");
            }
            
            $cart[$id]['jumlah'] = $requestedQty;
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Jumlah buku diperbarui.');
    }

    /**
     * Menampilkan halaman checkout.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang kosong.');
        }
        return view('user.checkout', compact('cart'));
    }

    /**
     * Memproses checkout dan menyimpan pesanan (Payment at Delivery).
     */
    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart');
        }

        $totalHarga = 0;
        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['jumlah'];
        }

        // Create Pesanan
        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'total_harga' => $totalHarga,
            'status_pembayaran' => 'Payment at Delivery',
            'status_pesanan' => 'Menunggu Konfirmasi'
        ]);

        foreach ($cart as $item) {
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'buku_id' => $item['id'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga']
            ]);

            // Kurangi stok buku
            $buku = Buku::find($item['id']);
            if ($buku) {
                $buku->stok -= $item['jumlah'];
                $buku->save();
            }
        }

        session()->forget('cart');
        return redirect()->route('user.pesanan')->with('success', 'Pesanan berhasil dibuat. Pembayaran dilakukan dengan metode Payment at Delivery.');
    }

    /**
     * Menampilkan daftar pesanan yang dilakukan oleh pengguna.
     */
    public function pesanan()
    {
        $pesanans = Pesanan::with('detailPesanan.buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('user.pesanan', compact('pesanans'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBuku;
use App\Models\Buku;
use App\Models\Kontak;
use App\Models\User;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan statistik.
     */
    public function dashboard()
    {
        $totalBuku = Buku::count();
        $totalPesanan = Pesanan::count();
        $totalUser = User::where('peran', 'user')->count();
        return view('admin.dashboard', compact('totalBuku', 'totalPesanan', 'totalUser'));
    }

    // --- Kategori Buku ---
    
    /**
     * Menampilkan daftar semua kategori buku.
     */
    public function index()
    {
        $kategoris = KategoriBuku::all();
        return view('admin.kategori.index', compact('kategoris'));
    }

    /**
     * Menampilkan form tambah kategori buku.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Menyimpan data kategori buku baru.
     */
    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required|string|max:255']);
        KategoriBuku::create($request->all());
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit kategori buku.
     */
    public function edit(KategoriBuku $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Mengupdate data kategori buku.
     */
    public function update(Request $request, KategoriBuku $kategori)
    {
        $request->validate(['nama_kategori' => 'required|string|max:255']);
        $kategori->update($request->all());
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diupdate.');
    }

    /**
     * Menghapus data kategori buku.
     */
    public function destroy(KategoriBuku $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    // --- Buku ---

    /**
     * Menampilkan daftar semua buku beserta kategorinya.
     */
    public function bukuIndex()
    {
        $bukus = Buku::with('kategori')->get();
        return view('admin.buku.index', compact('bukus'));
    }

    /**
     * Menampilkan form tambah buku.
     */
    public function bukuCreate()
    {
        $kategoris = KategoriBuku::all();
        return view('admin.buku.create', compact('kategoris'));
    }

    /**
     * Menyimpan data buku baru beserta unggah gambar (jika ada).
     */
    public function bukuStore(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_buku,id',
            'judul_buku' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar_buku' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('gambar_buku');
        if ($request->hasFile('gambar_buku')) {
            $data['gambar_buku'] = $request->file('gambar_buku')->store('buku', 'public');
        }

        Buku::create($data);
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit buku.
     */
    public function bukuEdit(Buku $buku)
    {
        $kategoris = KategoriBuku::all();
        return view('admin.buku.edit', compact('buku', 'kategoris'));
    }

    /**
     * Mengupdate data buku beserta gambar (jika diubah).
     */
    public function bukuUpdate(Request $request, Buku $buku)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_buku,id',
            'judul_buku' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar_buku' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('gambar_buku');
        if ($request->hasFile('gambar_buku')) {
            if ($buku->gambar_buku) {
                Storage::disk('public')->delete($buku->gambar_buku);
            }
            $data['gambar_buku'] = $request->file('gambar_buku')->store('buku', 'public');
        }

        $buku->update($data);
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diupdate.');
    }

    /**
     * Menghapus data buku dan gambar terkait.
     */
    public function bukuDestroy(Buku $buku)
    {
        if ($buku->gambar_buku) {
            Storage::disk('public')->delete($buku->gambar_buku);
        }
        $buku->delete();
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    // --- Users ---

    /**
     * Menampilkan daftar pengguna yang memiliki peran sebagai user biasa.
     */
    public function usersIndex()
    {
        $users = User::where('peran', 'user')->get();
        return view('admin.users.index', compact('users'));
    }

    // --- Pesanan ---

    /**
     * Menampilkan daftar semua pesanan dari pengguna yang berbeda.
     */
    public function pesananIndex()
    {
        $pesanans = Pesanan::with(['user', 'detailPesanan.buku'])->latest()->get();
        return view('admin.pesanan.index', compact('pesanans'));
    }

    /**
     * Menampilkan halaman khusus untuk melihat detail dan mengupdate status pengiriman pesanan.
     */
    public function pesananStatus(Pesanan $pesanan)
    {
        $pesanan->load(['user', 'detailPesanan.buku']);
        return view('admin.pesanan.status', compact('pesanan'));
    }

    /**
     * Memperbarui status pesanan (misal dari Menunggu Konfirmasi menjadi Diproses atau Selesai).
     */
    public function pesananUpdateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate(['status_pesanan' => 'required|string']);
        
        $statusLama = $pesanan->status_pesanan;
        $statusBaru = $request->status_pesanan;

        // Jika pesanan dibatalkan (dan sebelumnya belum dibatalkan), kembalikan stok buku
        if ($statusBaru === 'Dibatalkan' && $statusLama !== 'Dibatalkan') {
            foreach ($pesanan->detailPesanan as $detail) {
                $buku = $detail->buku;
                if ($buku) {
                    $buku->stok += $detail->jumlah;
                    $buku->save();
                }
            }
        } 
        // Jika sebelumnya dibatalkan, lalu diubah lagi menjadi status aktif, kurangi stoknya lagi
        elseif ($statusLama === 'Dibatalkan' && $statusBaru !== 'Dibatalkan') {
            foreach ($pesanan->detailPesanan as $detail) {
                $buku = $detail->buku;
                if ($buku) {
                    $buku->stok -= $detail->jumlah;
                    $buku->save();
                }
            }
        }

        $pesanan->update(['status_pesanan' => $statusBaru]);
        return redirect()->route('admin.pesanan.index')->with('success', 'Status pesanan diupdate.');
    }

    // --- Kontak / Pesan Masuk ---
    
    /**
     * Menampilkan daftar pesan masuk dari user.
     */
    public function kontakIndex()
    {
        $pesanMasuk = Kontak::latest()->get();
        return view('admin.kontak.index', compact('pesanMasuk'));
    }
}

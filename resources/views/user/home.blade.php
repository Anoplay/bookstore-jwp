@extends('layouts.app')

@section('content')
<div class="p-5 mb-4 rounded-3 text-white text-center" style="background: linear-gradient(135deg, var(--primary-brown), var(--secondary-brown));">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold"><i class="fas fa-book"></i> Selamat Datang di BookStore</h1>
        <p class="col-md-8 mx-auto fs-4">Temukan berbagai koleksi buku terbaik dengan mudah dan cepat. Harga terjangkau dan kualitas terjamin.</p>
        <a href="#buku-terbaru" class="btn btn-light btn-lg mt-3">Lihat Koleksi</a>
    </div>
</div>

<h2 class="mb-3 text-center" id="buku-terbaru" style="color: var(--text-dark);">Koleksi Buku</h2>

<!-- Filter Kategori -->
<div class="d-flex justify-content-center mb-4 flex-wrap gap-2">
    <a href="{{ route('home') }}" class="btn {{ !request('kategori') ? 'btn-brown' : 'btn-outline-brown' }}">Semua Kategori</a>
    @foreach($kategoris as $kat)
        <a href="{{ route('home', ['kategori' => $kat->id]) }}" class="btn {{ request('kategori') == $kat->id ? 'btn-brown' : 'btn-outline-brown' }}">
            {{ $kat->nama_kategori }}
        </a>
    @endforeach
</div>

<div class="row row-cols-1 row-cols-md-4 g-4">
    @forelse($bukus as $buku)
    <div class="col">
        <div class="card h-100 shadow-sm">
            @if($buku->gambar_buku)
                <img src="{{ asset('storage/'.$buku->gambar_buku) }}" class="card-img-top" alt="{{ $buku->judul_buku }}" style="height: 250px; object-fit: cover;">
            @else
                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 250px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                </div>
            @endif
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $buku->judul_buku }}</h5>
                <p class="text-muted small mb-1">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</p>
                <p class="fw-bold text-danger mb-2">Rp {{ number_format($buku->harga, 0, ',', '.') }}</p>
                <p class="card-text small text-truncate">{{ $buku->deskripsi }}</p>
                
                <div class="mt-auto">
                    @if($buku->stok > 0)
                        <form action="{{ route('cart.add', $buku->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-brown w-100"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                        </form>
                    @else
                        <button class="btn btn-secondary w-100" disabled>Stok Habis</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center">
        <p>Belum ada buku yang tersedia saat ini.</p>
    </div>
    @endforelse
</div>
@endsection

@extends('layouts.app')

@section('content')
<h3 class="mb-4 text-center">Hasil Pencarian untuk: "{{ $query }}"</h3>

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
        <p>Buku tidak ditemukan.</p>
    </div>
    @endforelse
</div>
@endsection

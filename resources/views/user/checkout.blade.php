@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h3 class="mb-4 text-center">Konfirmasi Pembayaran & Pengiriman</h3>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Metode Pembayaran: Payment at Delivery (COD)</h5>
                <p>Anda akan melakukan pembayaran ketika buku telah sampai di alamat tujuan Anda.</p>
                <hr>
                <h5 class="mb-3">Detail Pesanan:</h5>
                <ul class="list-group mb-3">
                    @php $total = 0; @endphp
                    @foreach($cart as $item)
                        @php $total += $item['harga'] * $item['jumlah']; @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $item['judul_buku'] }} ({{ $item['jumlah'] }}x)
                            <span>Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold list-group-item-warning">
                        TOTAL PEMBAYARAN COD
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </li>
                </ul>

                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Alamat Pengiriman</label>
                        <textarea name="alamat" class="form-control" rows="3" required placeholder="Masukkan alamat lengkap pengiriman..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100 btn-lg"><i class="fas fa-check-circle"></i> Konfirmasi & Pesan Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<h3 class="mb-4">Keranjang Belanja</h3>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f1ebd9;">
                        <tr>
                            <th>Buku</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @forelse($cart as $id => $item)
                            @php $total += $item['harga'] * $item['jumlah']; @endphp
                            <tr>
                                <td>{{ $item['judul_buku'] }}</td>
                                <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" min="1" class="form-control form-control-sm d-inline-block text-center" style="width: 70px;" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td>Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Keranjang masih kosong.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h5 class="card-title">Ringkasan Belanja</h5>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <strong>Total Tagihan:</strong>
                    <strong>Rp {{ number_format($total ?? 0, 0, ',', '.') }}</strong>
                </div>
                @if(count($cart) > 0)
                    <a href="{{ route('checkout') }}" class="btn btn-brown w-100">Checkout (Payment at Delivery)</a>
                @endif
                <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 mt-2">Lanjut Belanja</a>
            </div>
        </div>
    </div>
</div>
@endsection

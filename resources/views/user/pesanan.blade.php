@extends('layouts.app')

@section('content')
<h3 class="mb-4">Daftar Pesanan Saya</h3>

<div class="card">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover mb-0">
            <thead style="background-color: #f1ebd9;">
                <tr>
                    <th>No Pesanan</th>
                    <th>Tanggal</th>
                    <th>Detail Buku</th>
                    <th>Total Harga</th>
                    <th>Status Pembayaran</th>
                    <th>Status Pengiriman</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanans as $pesanan)
                <tr>
                    <td>#{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $pesanan->created_at->format('d M Y') }}</td>
                    <td>
                        <ul class="list-unstyled mb-0 small">
                        @foreach($pesanan->detailPesanan as $detail)
                            <li>- {{ $detail->buku->judul_buku }} ({{ $detail->jumlah }}x)</li>
                        @endforeach
                        </ul>
                    </td>
                    <td class="fw-bold">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                    <td><span class="badge bg-secondary">{{ $pesanan->status_pembayaran }}</span></td>
                    <td>
                        <span class="badge {{ $pesanan->status_pesanan == 'Selesai' ? 'bg-success' : ($pesanan->status_pesanan == 'Dibatalkan' ? 'bg-danger' : 'bg-warning text-dark') }}">
                            {{ $pesanan->status_pesanan }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Anda belum memiliki pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

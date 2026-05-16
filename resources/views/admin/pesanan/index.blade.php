@extends('layouts.admin')

@section('content')
<h3 class="mb-3">Daftar Pesanan User</h3>

<div class="card">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No Pesanan</th>
                    <th>User</th>
                    <th>Buku Dipesan</th>
                    <th>Total Harga</th>
                    <th>Status Pembayaran</th>
                    <th>Status Pengiriman</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanans as $pesanan)
                <tr>
                    <td>#{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $pesanan->user->nama }}</td>
                    <td>
                        <ul class="list-unstyled mb-0">
                        @foreach($pesanan->detailPesanan as $detail)
                            <li>{{ $detail->buku->judul_buku }} ({{ $detail->jumlah }}x)</li>
                        @endforeach
                        </ul>
                    </td>
                    <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                    <td><span class="badge bg-secondary">{{ $pesanan->status_pembayaran }}</span></td>
                    <td>
                        <span class="badge {{ $pesanan->status_pesanan == 'Selesai' ? 'bg-success' : ($pesanan->status_pesanan == 'Dibatalkan' ? 'bg-danger' : 'bg-warning text-dark') }}">
                            {{ $pesanan->status_pesanan }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.pesanan.status', $pesanan->id) }}" class="btn btn-sm btn-brown"><i class="fas fa-edit"></i> Update Status</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

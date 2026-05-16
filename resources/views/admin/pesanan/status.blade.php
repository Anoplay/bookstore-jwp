@extends('layouts.admin')

@section('content')
<h3 class="mb-4">Detail & Update Status Pengiriman</h3>

<div class="row">
    <div class="col-md-7">
        <!-- Informasi Pesanan -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Informasi Pesanan #{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th width="35%">Nama Pemesan</th>
                        <td>: {{ $pesanan->user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Email Pemesan</th>
                        <td>: {{ $pesanan->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Pesanan</th>
                        <td>: {{ $pesanan->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Metode Pembayaran</th>
                        <td>: <span class="badge bg-secondary">{{ $pesanan->status_pembayaran }}</span></td>
                    </tr>
                    <tr>
                        <th>Total Tagihan</th>
                        <td>: <span class="fw-bold text-danger">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Detail Buku yang Dipesan -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Buku yang Dipesan</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan->detailPesanan as $detail)
                        <tr>
                            <td>{{ $detail->buku->judul_buku }}</td>
                            <td class="text-center">{{ $detail->jumlah }}</td>
                            <td class="text-end">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <!-- Form Update Status Pengiriman -->
        <div class="card border-brown shadow-sm">
            <div class="card-header text-white" style="background-color: var(--primary-brown);">
                <h5 class="mb-0"><i class="fas fa-truck"></i> Status Pengiriman</h5>
            </div>
            <div class="card-body">
                <div class="mb-4 text-center">
                    <p class="mb-1 text-muted">Status Saat Ini:</p>
                    <span class="badge fs-5 {{ $pesanan->status_pesanan == 'Selesai' ? 'bg-success' : ($pesanan->status_pesanan == 'Dibatalkan' ? 'bg-danger' : 'bg-warning text-dark') }}">
                        {{ $pesanan->status_pesanan }}
                    </span>
                </div>

                <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold mb-2">Ubah Status Pengiriman</label>
                        <select name="status_pesanan" class="form-select form-select-lg" required>
                            <option value="Menunggu Konfirmasi" {{ $pesanan->status_pesanan == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="Diproses" {{ $pesanan->status_pesanan == 'Diproses' ? 'selected' : '' }}>Diproses (Packing)</option>
                            <option value="Dikirim" {{ $pesanan->status_pesanan == 'Dikirim' ? 'selected' : '' }}>Dikirim (Dalam Perjalanan)</option>
                            <option value="Selesai" {{ $pesanan->status_pesanan == 'Selesai' ? 'selected' : '' }}>Selesai (Diterima)</option>
                            <option value="Dibatalkan" {{ $pesanan->status_pesanan == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <small class="text-muted mt-2 d-block">
                            *Jika diubah menjadi "Dibatalkan", stok buku akan otomatis dikembalikan ke sistem.
                        </small>
                    </div>
                    <button type="submit" class="btn btn-brown w-100 py-2 fs-5">Simpan Status</button>
                    <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline-secondary w-100 mt-2">Kembali ke List Pesanan</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

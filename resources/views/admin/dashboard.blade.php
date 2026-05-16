@extends('layouts.admin')

@section('content')
<h3 class="mb-4">Admin Dashboard</h3>
<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-primary shadow-sm h-100" style="background-color: var(--secondary-brown) !important; border:none;">
            <div class="card-body">
                <h5 class="card-title">Total Buku</h5>
                <h2>{{ $totalBuku }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-success shadow-sm h-100" style="background-color: #5d4037 !important; border:none;">
            <div class="card-body">
                <h5 class="card-title">Total Pesanan</h5>
                <h2>{{ $totalPesanan }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-info shadow-sm h-100" style="background-color: #795548 !important; border:none;">
            <div class="card-body">
                <h5 class="card-title">Total User</h5>
                <h2>{{ $totalUser }}</h2>
            </div>
        </div>
    </div>
</div>
<div class="card mt-4">
    <div class="card-body">
        <p>Selamat datang di panel Admin BookStore. Silakan gunakan menu di samping untuk mengelola toko buku Anda.</p>
    </div>
</div>
@endsection

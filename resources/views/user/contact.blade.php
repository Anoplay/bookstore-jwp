@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3 class="mb-4 text-center">Contact Admin</h3>
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="text-muted text-center mb-4">Jika Anda memiliki pertanyaan, keluhan, atau saran, jangan ragu untuk menghubungi Admin kami melalui form di bawah ini.</p>
                
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="{{ Auth::check() ? Auth::user()->nama : '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ Auth::check() ? Auth::user()->email : '' }}">
                    </div>
                    <div class="mb-3">
                        <label>Pesan / Keluhan / Pertanyaan</label>
                        <textarea name="pesan" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-brown w-100">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

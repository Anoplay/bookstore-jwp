@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Kategori Buku</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold mb-2">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" required autofocus>
                    </div>
                    <button class="btn btn-brown w-100" type="submit">Simpan</button>
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

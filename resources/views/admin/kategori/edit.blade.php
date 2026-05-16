@extends('layouts.admin')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Kategori Buku</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold mb-2">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" value="{{ $kategori->nama_kategori }}" required>
                </div>
                <button class="btn btn-brown w-100" type="submit">Update</button>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

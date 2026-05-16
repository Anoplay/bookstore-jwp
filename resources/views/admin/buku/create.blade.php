@extends('layouts.admin')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Buku</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold mb-2">Judul Buku</label>
                    <input type="text" name="judul_buku" class="form-control" value="{{ old('judul_buku') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold mb-2">Kategori</label>
                    <select name="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold mb-2">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold mb-2">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" min="0" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold mb-2">Stok</label>
                        <input type="number" name="stok" class="form-control" value="{{ old('stok', 0) }}" min="0" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold mb-2">Gambar Buku</label>
                    <input type="file" name="gambar_buku" class="form-control" accept="image/*">
                </div>
                
                <button class="btn btn-brown w-100" type="submit">Simpan</button>
                <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

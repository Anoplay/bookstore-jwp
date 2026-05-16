@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Buku</h3>
    <a href="{{ route('admin.buku.create') }}" class="btn btn-brown"><i class="fas fa-plus"></i> Tambah Buku</a>
</div>

<div class="card">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul Buku</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bukus as $buku)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($buku->gambar_buku)
                            <img src="{{ asset('storage/'.$buku->gambar_buku) }}" width="50" alt="Gambar">
                        @else
                            <span class="text-muted">No Img</span>
                        @endif
                    </td>
                    <td>{{ $buku->judul_buku }}</td>
                    <td>{{ $buku->kategori->nama_kategori ?? '-' }}</td>
                    <td>Rp {{ number_format($buku->harga, 0, ',', '.') }}</td>
                    <td>{{ $buku->stok }}</td>
                    <td>
                        <a href="{{ route('admin.buku.edit', $buku->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data buku.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

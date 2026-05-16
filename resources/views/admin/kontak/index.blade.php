@extends('layouts.admin')

@section('content')
<h3 class="mb-3">Pesan Masuk dari Pengunjung</h3>

<div class="card">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Isi Pesan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesanMasuk as $key => $pesan)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $pesan->created_at->format('d M Y, H:i') }}</td>
                    <td>{{ $pesan->nama }}</td>
                    <td>{{ $pesan->email ?? '-' }}</td>
                    <td>{{ $pesan->pesan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada pesan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

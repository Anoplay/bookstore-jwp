@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card mt-5">
            <div class="card-header text-center">
                <h4>Login BookStore</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-brown w-100" type="submit">Login</button>
                </form>
                <div class="mt-3 text-center">
                    Belum punya akun? <a href="{{ route('register') }}" style="color:var(--primary-brown)">Register di sini</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

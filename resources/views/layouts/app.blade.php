<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookStore</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-brown: #3A2815;
            --secondary-brown: #C9A87A;
            --light-cream: #FFFCF8;
            --card-bg: #FAF6F1;
            --text-dark: #3e2723;
        }
        body {
            background-color: var(--light-cream);
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar-custom {
            background-color: var(--primary-brown);
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #fff;
        }
        .navbar-custom .nav-link:hover {
            color: var(--secondary-brown);
        }
        .btn-brown {
            background-color: var(--primary-brown);
            color: #fff;
            border-color: var(--primary-brown);
        }
        .btn-brown:hover {
            background-color: var(--secondary-brown);
            color: #fff;
            border-color: var(--secondary-brown);
        }
        .btn-outline-brown {
            border-color: var(--primary-brown);
            color: var(--primary-brown);
        }
        .btn-outline-brown:hover {
            background-color: var(--primary-brown);
            color: #fff;
        }
        .card {
            border: 1px solid #e0d0c1;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            background-color: var(--card-bg);
        }
        .card-header {
            background-color: var(--primary-brown);
            color: white;
            border-bottom: 1px solid #e0d0c1;
        }
        footer {
            background-color: var(--primary-brown);
            color: white;
            margin-top: auto;
        }
        .badge-brown {
            background-color: var(--secondary-brown);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('home') }}"><i class="fas fa-book-open me-2"></i> BookStore</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border-color: rgba(255,255,255,0.5);">
      <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      @if(!Auth::check() || Auth::user()->peran === 'user')
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('about') }}">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('contact') }}">Contact Admin</a>
        </li>
      </ul>
      <form class="d-flex me-3" action="{{ route('search') }}" method="GET">
        <input class="form-control me-2" type="search" name="q" placeholder="Cari buku..." value="{{ request('q') }}">
        <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
      </form>
      @else
      <!-- Empty space for admin left alignment -->
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <span class="nav-link fw-bold text-warning"><i class="fas fa-user-shield"></i> Panel Administrator</span>
        </li>
      </ul>
      @endif

      <ul class="navbar-nav">
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
        @else
            @if(Auth::user()->peran === 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
            </li>
            @endif
            
            @if(Auth::user()->peran === 'user')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cart') }}">
                    <i class="fas fa-shopping-cart"></i> Cart
                    @php $cart = session('cart', []); @endphp
                    <span class="badge bg-warning text-dark rounded-pill">{{ count($cart) }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.pesanan') }}">Pesanan Saya</a>
            </li>
            @endif
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle"></i> {{ Auth::user()->nama }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4 mb-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<footer class="py-4 text-center mt-auto">
    <div class="container">
        <p class="mb-0">&copy; {{ date('Y') }} BookStore Perpustakaan. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

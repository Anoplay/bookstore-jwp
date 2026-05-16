<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BookStore</title>
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
            --sidebar-width: 260px;
        }
        body {
            background-color: var(--light-cream);
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        /* Sidebar Styling */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            min-height: 100vh;
            background-color: var(--primary-brown);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        #sidebar .sidebar-header {
            padding: 25px 20px;
            background-color: rgba(0,0,0,0.2);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        #sidebar ul.components {
            padding: 15px 0;
        }
        #sidebar ul li a {
            padding: 15px 25px;
            font-size: 1.05em;
            display: block;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        #sidebar ul li a:hover {
            background-color: rgba(255,255,255,0.05);
            color: #fff;
            border-left-color: var(--secondary-brown);
        }
        #sidebar ul li.active > a {
            background-color: var(--secondary-brown);
            color: #fff;
            border-left-color: #fff;
            font-weight: 500;
        }
        #sidebar ul li a i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }
        /* Main Content Styling */
        #content {
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            margin-left: var(--sidebar-width);
        }
        .navbar-admin {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 15px 30px;
        }
        .main-content {
            padding: 30px;
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.03);
            background-color: var(--card-bg);
            border-radius: 10px;
        }
        .card-header {
            background-color: var(--primary-brown);
            color: white;
            border-bottom: none;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
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
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header text-center">
            <h4 class="mb-0 fw-bold"><i class="fas fa-book-open text-warning me-2"></i>Admin Panel</h4>
        </div>

        <ul class="list-unstyled components">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            <li class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                <a href="{{ route('admin.kategori.index') }}"><i class="fas fa-tags"></i> Kategori Buku</a>
            </li>
            <li class="{{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
                <a href="{{ route('admin.buku.index') }}"><i class="fas fa-book"></i> Data Buku</a>
            </li>
            <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> Pengguna</a>
            </li>
            <li class="{{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
                <a href="{{ route('admin.pesanan.index') }}"><i class="fas fa-shopping-bag"></i> Pesanan</a>
            </li>
            <li class="{{ request()->routeIs('admin.kontak.*') ? 'active' : '' }}">
                <a href="{{ route('admin.kontak.index') }}"><i class="fas fa-envelope"></i> Pesan Masuk</a>
            </li>
        </ul>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-admin">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 fs-5 text-muted">
                    <i class="fas fa-bars me-3"></i> BookStore Administration
                </span>
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3 fw-medium"><i class="fas fa-user-circle fs-5 me-1 align-middle"></i> {{ Auth::user()->nama }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content Area -->
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

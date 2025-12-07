<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 240px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: #212529;
            color: white;
            padding-top: 60px;
        }
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            border-radius: 8px;
            margin: 2px 0;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #0d6efd;
            color: white;
        }
        .main-content {
            margin-left: 240px;
            padding: 30px;
            margin-top: 70px;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 240px;
            right: 0;
            height: 60px;
            z-index: 1000;
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h5">Admin Dashboard</span>

        <div class="d-flex gap-2">
            {{-- ✅ Home Button --}}
            <a href="{{ url('/') }}" class="btn btn-sm btn-outline-light">
                🏠 Home
            </a>

            {{-- Logout Button --}}
            <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                @csrf
            </form>
        </div>
    </div>
</nav>

{{-- Sidebar --}}
<div class="sidebar">
    <div class="text-center mb-3">
        <h5>Menu</h5>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
    <a href="{{ route('admin.brands.index') }}" class="{{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">🏷️ Brands</a>
    <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">🗂️ Categories</a>
    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">📦 Products</a>
    <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">🛒 Orders</a>
    <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">💬 Messages</a>
    <a href="{{ route('admin.shop_content.index') }}" class="{{ request()->routeIs('admin.shop_content.*') ? 'active' : '' }}">🛍️ Shop Content</a>
    <a href="{{ route('admin.eye_test.index') }}" class="{{ request()->routeIs('admin.eye_test.*') ? 'active' : '' }}">👁️ Eye Test Bookings</a>
</div>

{{-- Main content --}}
<div class="main-content">
    <div class="container-fluid">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

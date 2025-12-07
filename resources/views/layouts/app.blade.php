<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Eyematic')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('home') }}">Eyematic</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <li class="nav-item">
    <a class="btn btn-primary ms-3" href="{{ route('eye_test.form') }}">
        Eye Test Booking
    </a>
</li>

    <div class="collapse navbar-collapse justify-content-between" id="nav">
        <ul class="navbar-nav me-auto align-items-lg-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="productsDropdown" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                 Products
                </a>
            <ul class="dropdown-menu" aria-labelledby="productsDropdown">

            <li><a class="dropdown-item" href="{{ route('products.index') }}">All Products</a></li>

            <li><hr class="dropdown-divider"></li>

        {{-- 🔽 Dropdown for Brands --}}
        <li class="dropdown-submenu positions-relative">
            <a class="dropdown-item dropdown-toggle" href="#" >Brands</a>
            <ul class="dropdown-menu">
            @foreach(\App\Models\Brand::orderBy('name')->get() as $b)
                <li><a href="{{ route('products.byBrand', $b->slug) }}" class="dropdown-item">{{ $b->name }}</a></li>
            @endforeach
            </ul>
        </li>

        {{-- 🔽 Dropdown for Categories --}}
        <li class="dropdown-submenu positions-relative">
            <a class="dropdown-item dropdown-toggle" href="#" >Categories</a>
            <ul class="dropdown-menu">
            @foreach(\App\Models\Category::orderBy('name')->get() as $c)
                <li><a href="{{ route('products.byCategory', $c->slug) }}" class="dropdown-item">{{ $c->name }}</a></li>
            @endforeach
            </ul>
        </li>
        </li>
            </ul>
        </ul>

  <li class="nav-item">
    <a class="btn btn-success ms-2"
       href="https://wa.me/6385745525" target="_blank">
        <i class="bi bi-whatsapp"></i> WhatsApp
        </a>
        </li>
                <form class="d-flex ms-lg-3 mt-2 mt-lg-0" action="{{ route('products.index') }}" method="GET" role="search">
        <input
            class="form-control me-2"
            type="search"
            name="search"
            placeholder="Search products..."
            value="{{ request('search') }}"
            aria-label="Search">
        <button class="btn btn-outline-light" type="submit">Search</button>
        </form>

      <ul class="navbar-nav ms-auto">
        @auth
          @if(auth()->user()->role === 'vendor')
            <li class="nav-item"><a href="{{ route('vendor.dashboard') }}" class="nav-link">Vendor</a></li>
          @elseif(in_array(auth()->user()->role, ['admin','superadmin']))
            <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Admin</a></li>
          @endif
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <form method="POST" action="{{ route('logout') }}">@csrf
                  <button class="dropdown-item">Logout</button>
                </form>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
              </li>
            </ul>
          </li>
          <li class="nav-item"><a href="{{ route('cart.index') }}" class="nav-link">Cart</a></li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.index') }}">My Orders</a>
        </li>
        @else
          <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
          <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<main class="container py-4">
  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
  @yield('content')
</main>


<footer class="bg-dark text-white text-center py-3 mt-auto">
  <p class="mb-0">&copy; {{ date('Y') }} Eyematic. All rights reserved.</p>
</footer>
</body>
</html>

<style>
/* Fix nested dropdown position */
.dropdown-submenu:hover > .dropdown-menu {
  display: block;
  position: absolute;
  top: 50%;
  left: 100%;
  margin-top: 0;
}
.dropdown-submenu > a::after {
  content: "▶";
  float: right;
  margin-left: 5px;
}
</style>

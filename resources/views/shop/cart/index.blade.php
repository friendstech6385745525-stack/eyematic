@extends('layouts.app')
@section('title', 'My Cart')

@section('content')
<div class="container py-5">

    <h2 class="mb-4 text-center fw-bold">🛒 My Shopping Cart</h2>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if($cartItems->count() > 0)
        <div class="row g-4">
            @foreach($cartItems as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="row g-0">
                            <div class="col-4">
                                <img src="{{ asset('storage/' . $item->product->images[0]) }}"
                                     alt="{{ $item->product->name }}"
                                     class="img-fluid rounded-start"
                                     style="height: 100%; object-fit: cover;">
                            </div>
                            <div class="col-8">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title mb-2">{{ $item->product->name }}</h5>
                                    <p class="mb-1 text-muted">RM{{ number_format($item->qty * $item->price, 2) }}</p>
                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="qty" value="{{ $item->qty }}" min="1"
                                                class="form-control form-control-sm me-2" style="width: 70px;">
                                            <button type="submit" class="btn btn-sm btn-outline-success">Update</button>
                                        </form>

                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Remove this item from cart?')">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- 🧾 Cart Summary -->
        <div class="card shadow-sm border-0 mt-5">
            <div class="card-body d-flex flex-column align-items-end">
                <h4>Total: <strong>RM{{ number_format($cartItems->sum(fn($i) => $i->price * $i->qty), 2) }}</strong></h4>
                <div class="mt-3">
                    <a href="{{ route('checkout.page') }}" class="btn btn-warning btn-lg">Proceed to Checkout</a>
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-lg ms-2"
                                onclick="return confirm('Clear all items in your cart?')">
                            Clear Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center p-5">
            <h5>Your cart is empty 😕</h5>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection

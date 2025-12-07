@extends('layouts.app')
@section('title', 'Order Successful')

@section('content')
<div class="container text-center mt-5">

    {{-- ✅ Show payment success message if exists --}}
    @if(session('message'))
        <div class="alert alert-success text-center">{{ session('message') }}</div>
    @endif

    <div class="alert alert-success shadow-sm">
        <h3 class="fw-bold">🎉 Order Placed Successfully!</h3>
        <p>Your order #{{ $order->id }} has been received.</p>
        <p>Status:
            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'processing' ? 'info' : 'warning') }}">
                {{ ucfirst($order->status) }}
            </span>
        </p>
    </div>

    <div class="card shadow-sm p-4 mt-4">
        <h5>Order Details</h5>

        @if($order->items && $order->items->isNotEmpty())
            <table class="table table-bordered mt-3">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price (RM)</th>
                        <th>Total (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ number_format($item->price * $item->qty, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No order items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <p class="text-muted mt-3">No order items found.</p>
        @endif

        <h5 class="text-end mt-3">Total: <strong>RM{{ number_format($order->total, 2) }}</strong></h5>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-primary mt-4">
        🧾 View My Orders
    </a>
    <a href="{{ url('/') }}" class="btn btn-outline-secondary mt-4">
        🏠 Back to Home
    </a>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Order Details')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm p-4">

                @if(auth()->check())
            @php $cartItems = \App\Models\OrderItem::with('product')->where('order_id', $order->id)->get(); @endphp
            @else
            @php $cartItems = collect(session('cart', [])); @endphp
            @endif

        <h3 class="fw-bold mb-3">Order #{{ $order->id }}</h3>
        <p><strong>Status:</strong>
            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'processing' ? 'info' : 'warning') }}">
                {{ ucfirst($order->status) }}
            </span>
        </p>
        <p><strong>Total:</strong> RM{{ number_format($order->total, 2) }}</p>
        <p><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>

        <hr>

        <h5 class="mt-4">Items</h5>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price (RM)</th>
                    <th>Total (RM)</th>
                </tr>
            </thead>
            <tbody>
               @if(!empty($cartItems) && count($cartItems) > 0)
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                        <td>{{ number_format($item->price * $item->qty, 2) }}</td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="3" class="text-center text-muted">No items found.</td></tr>
            @endif
            </tbody>
        </table>

        <div class="text-end mt-3">
            <h5>Total Amount: <strong>RM{{ number_format($order->total, 2) }}</strong></h5>
        </div>

        <div class="mt-4 text-end">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">⬅ Back to My Orders</a>

        </div>
    </div>
</div>
@endsection

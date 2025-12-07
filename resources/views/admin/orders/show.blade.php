@extends('layouts.admin')
@section('title', 'Order #' . $order->id)

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm p-4">
        <h3 class="fw-bold mb-3">Order #{{ $order->id }}</h3>
        <p><strong>User:</strong> {{ $order->user->name ?? 'Deleted User' }}</p>
        <p><strong>Email:</strong> {{ $order->user->email ?? '-' }}</p>
        <p><strong>Status:</strong>
            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'processing' ? 'info' : 'warning') }}">
                {{ ucfirst($order->status) }}
            </span>
        </p>
        <p><strong>Total:</strong> RM{{ number_format($order->total, 2) }}</p>
        <p><strong>Placed on:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>

        <hr>
      <h4 class="mb-3">Order Items</h4>

@if($order->items && $order->items->count())
    <div class="row">
        @foreach($order->items as $item)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm p-3 border-0" style="border-radius: 12px;">
                    <img src="{{ asset('uploads/products/' . $item->product->image) }}"
                         class="card-img-top"
                         style="height:180px;object-fit:cover;border-radius:10px">

                    <div class="card-body">
                        <h5>{{ $item->product_name }}</h5>
                        <p><strong>Qty:</strong> {{ $item->qty }}</p>
                        <p><strong>Price:</strong> RM{{ number_format($item->price,2) }}</p>
                        <p><strong>Total:</strong> RM{{ number_format($item->price * $item->qty,2) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="text-muted">No items found for this order.</p>
@endif

        <div class="mt-4 text-end">
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-inline">
                @csrf @method('PUT')
                <select name="status" class="form-select d-inline w-auto">
                    <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                    <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Processing</option>
                    <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Completed</option>
                    <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
                </select>
                <button type="submit" class="btn btn-primary ms-2">Update Status</button>
            </form>

             {{-- ✅ Quick action buttons --}}
    @if($order->payment_method == 'cod' && $order->status == 'pending')
        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-inline">
            @csrf @method('PUT')
            <input type="hidden" name="status" value="processing">
            <button type="submit" class="btn btn-warning ms-2">Mark as Paid</button>
        </form>
    @endif

    @if($order->status == 'processing')
        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-inline">
            @csrf @method('PUT')
            <input type="hidden" name="status" value="completed">
            <button type="submit" class="btn btn-success ms-2">Mark as Delivered</button>
        </form>
    @endif

    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary ms-2">⬅ Back</a>
</div>
</div>
</div>
@endsection

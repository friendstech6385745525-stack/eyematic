@extends('layouts.app')
@section('title','My Orders')

@section('content')
<div class="container">
  <h3 class="fw-bold mb-4">My Orders</h3>

  @if($orders->count())
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Status</th>
            <th>Total (RM)</th>
            <th>Items</th>
            <th>Actions</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
            <tr>
              <td>{{ $order->id }}</td>
              <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
              <td>
                <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'completed' ? 'success' : 'secondary') }}">
                  {{ ucfirst($order->status) }}
                </span>
              </td>
              <td>{{ number_format($order->total, 2) }}</td>
              <td>{{ $order->items ? $order->items->count() : 0 }}</td>
            <td>
                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                  View
                </a>
              </td>

              <td>
                <!-- Cancel Button for User -->
                @if($order->status === 'pending')
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                            onclick="return confirm('Are you sure you want to cancel this order?')">
                        Cancel
                    </button>
                    </form>
                @else
                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                @endif
                </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $orders->links() }}
    </div>
  @else
    <div class="alert alert-info">You haven’t placed any orders yet.</div>
  @endif
</div>
@endsection

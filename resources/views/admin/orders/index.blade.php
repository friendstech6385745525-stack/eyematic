@extends('layouts.admin')
@section('title','All Orders')

@section('content')
<div class="container">
  <h3 class="fw-bold mb-4">All Orders</h3>

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>User</th>
          <th>Date</th>
          <th>Total</th>
          <th>Status</th>
          <th>Payment</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
        <tr>
          <td>{{ $order->id }}</td>
          <td>{{ $order->user->name ?? 'Deleted User' }}</td>
          <td>{{ $order->created_at->format('d M Y H:i') }}</td>
          <td>RM{{ number_format($order->total,2) }}</td>
          <td>
            <form action="{{ route('admin.orders.updateStatus',$order) }}" method="POST" class="d-flex">
              @csrf @method('PUT')
              <select name="status" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                <option value="pending"   {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                <option value="processing"{{ $order->status=='processing'?'selected':'' }}>Processing</option>
                <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Completed</option>
                <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
              </select>
            </form>
          </td>
          <td>
            <span class="badge bg-{{ $order->payment_method == 'cod' ? 'secondary' : 'success' }}">
              {{ strtoupper($order->payment_method ?? 'N/A') }}
            </span>
          </td>

          <td>
            <a href="{{ route('admin.orders.show',$order) }}" class="btn btn-sm btn-outline-primary">View</a>
          </td>
          <td>
            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Remove this order permanently?')">
                Remove
                </button>
            </form>
            </td>

        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $orders->links() }}
</div>
@endsection

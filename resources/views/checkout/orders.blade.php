@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<div class="container">
  <h2 class="mb-4">My Orders</h2>

  @if($orders->isEmpty())
    <div class="alert alert-info">You have no orders yet.</div>
  @else
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Date</th>
          <th>Status</th>
          <th>Total (RM)</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
          <tr>
            <td>#{{ $order->id }}</td>
            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
            <td><span class="badge bg-secondary">{{ ucfirst($order->status) }}</span></td>
            <td>{{ number_format($order->total, 2) }}</td>
          </tr>
          <tr>
            <td colspan="4">
              <ul class="mb-0">
                @foreach($order->items as $item)
                  <li>{{ $item->product_name }} × {{ $item->qty }} — RM{{ number_format($item->price,2) }}</li>
                @endforeach
              </ul>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</div>
@endsection

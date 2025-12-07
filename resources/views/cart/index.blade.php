@extends('layouts.app')
@section('title','My Cart')

@section('content')
<h2 class="mb-4">Shopping Cart</h2>

@if(empty($cart))
  <div class="alert alert-info">Your cart is empty.</div>
@else
  <table class="table table-bordered align-middle">
    <thead class="table-light">
      <tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th><th>Action</th></tr>
    </thead>
    <tbody>
      @foreach($cart as $id => $item)
        <tr>
          <td>{{ $item['name'] }}</td>
          <td>{{ $item['qty'] }}</td>
          <td>RM{{ number_format($item['price'],2) }}</td>
          <td>RM{{ number_format($item['price'] * $item['qty'],2) }}</td>
          <td>
            <form action="{{ route('cart.remove',$id) }}" method="POST">@csrf @method('DELETE')
              <button class="btn btn-sm btn-danger">Remove</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div class="text-end">
    <a href="{{ route('checkout.index') }}" class="btn btn-success">Proceed to Checkout</a>
  </div>
@endif
@endsection

@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="container">
  <h2 class="mb-4">Checkout</h2>

  @if(auth()->check())
            @php $cart = \App\Models\Cart::with('product')->where('user_id', auth()->id())->get(); @endphp
            @else
            @php $cart = collect(session('cart', [])); @endphp
            @endif

  <table class="table table-bordered">
    <thead class="table-light">
      <tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr>
    </thead>
    <tbody>
      @foreach($cart as $item)
      <tr>
        <td>{{ $item['name'] }}</td>
        <td>{{ $item['qty'] }}</td>
        <td>RM{{ number_format($item['price'],2) }}</td>
        <td>RM{{ number_format($item['price'] * $item['qty'],2) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <h4 class="text-end">Grand Total: RM{{ number_format($total,2) }}</h4>

  <form action="{{ route('checkout.place') }}" method="POST">
    @csrf
    <button class="btn btn-success mt-3">Place Order</button>
  </form>
</div>
@endsection

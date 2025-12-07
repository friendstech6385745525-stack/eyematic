@extends('layouts.app')
@section('title', 'Payment')

@section('content')
<div class="container mt-5">
  <div class="card shadow-sm p-4">
    <h4 class="fw-bold mb-4 text-center">Select Payment Method</h4>

    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
    <p><strong>Total Amount:</strong> RM{{ number_format($order->total, 2) }}</p>

    <form action="{{ route('checkout.confirm', $order->id) }}" method="POST" class="mt-4">
      @csrf
      <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
        <label class="form-check-label" for="cod">
          💵 Cash on Delivery
        </label>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="payment_method" id="online" value="online">
        <label class="form-check-label" for="online">
          💳 Online Payment (Simulated)
        </label>
      </div>

      <button type="submit" class="btn btn-success w-100">Proceed to Pay</button>
    </form>
  </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Pay Now')

@section('content')
<div class="container text-center mt-5">
    <h3>Pay ₹{{ number_format($order->total, 2) }} using Razorpay</h3>
    <button id="rzp-button" class="btn btn-primary mt-3">Pay Now</button>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ env('RAZORPAY_KEY') }}",
        "amount": "{{ $order->total * 100 }}",
        "currency": "INR",
        "name": "Eyematic",
        "description": "Order #{{ $order->id }}",
        "order_id": "{{ $razorpayOrderId ?? '' }}",
        "handler": function (response){
            fetch("{{ route('razorpay.verify') }}", {
                method: "POST",
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}','Content-Type': 'application/json'},
                body: JSON.stringify({
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_signature: response.razorpay_signature
                })
            }).then(() => window.location.href = "{{ route('checkout.success', $order->id) }}");
        },
        "theme": { "color": "#0d6efd" }
    };
    var rzp = new Razorpay(options);
    document.getElementById('rzp-button').onclick = function(e){
        rzp.open();
        e.preventDefault();
    }
</script>
@endsection

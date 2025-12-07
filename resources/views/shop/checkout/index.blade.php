@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">🛒 Checkout</h3>

    <div class="row">
        <div class="col-md-8">
            <h5>Billing Information</h5>
            <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <div class="mb-3">
            <label for="address" class="form-label fw-bold">Shipping Address</label>
            <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
            </div>
            <h5 class="mt-4">Select Payment Method</h5>

            <div class="form-check mt-2">
                <input class="form-check-input" type="radio" name="payment_method" id="onlinePay" value="razorpay" checked>
                <label class="form-check-label" for="onlinePay">Pay Online (Razorpay)</label>
            </div>

            <div class="form-check mt-2">
                <input class="form-check-input" type="radio" name="payment_method" id="codPay" value="cod">
                <label class="form-check-label" for="codPay">Cash on Delivery (COD)</label>
            </div>
        </div>

        <div class="col-md-4">
            <h5>Order Summary</h5>
            <ul class="list-group mb-3">
                @foreach($cartItems as $item)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $item['name'] }} (x{{ $item['qty'] }})</span>
                        <strong>₹{{ number_format($item['price'] * $item['qty'], 2) }}</strong>
                    </li>
                @endforeach
            </ul>

            <h5>Total: <strong>₹{{ number_format($total, 2) }}</strong></h5>

            <button id="payNowBtn" class="btn btn-primary w-100 mt-3">Continue</button>
        </div>
    </div>
</div>

{{-- ✅ Razorpay JS --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.getElementById('payNowBtn').addEventListener('click', function () {
    const method = document.querySelector('input[name="payment_method"]:checked').value;

    if (method === 'cod') {
        // 💵 Cash on Delivery
        fetch("{{ route('checkout.place') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        })
        .then(res => res.json())
        .then(data => window.location.href = "/checkout/success/" + data.order_id);
    } else {
        // 💳 Razorpay Online Payment
        fetch("{{ route('razorpay.order') }}", {
            method: "POST",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        })
        .then(res => res.json())
        .then(data => {
            const options = {
                key: data.key,
                amount: data.amount,
                currency: "INR",
                name: "Eyematic Store",
                description: "Product Payment",
                order_id: data.order_id,
                handler: function (response) {
                    fetch("{{ route('razorpay.verify') }}", {
                        method: "POST",
                        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify(response)
                    }).then(() => window.location.href = "/checkout/success/" + data.order_id);
                },
                prefill: {
                    name: "{{ auth()->user()->name }}",
                    email: "{{ auth()->user()->email }}",
                    contact: "9000000000"
                },
                theme: { color: "#0d6efd" }
            };
            const rzp = new Razorpay(options);
            rzp.open();
        });
    }
});
</script>
@endsection

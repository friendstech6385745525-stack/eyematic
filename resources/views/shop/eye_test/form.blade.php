@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card p-4 shadow-sm">
        <h3 class="mb-4">Book Eye Test Appointment</h3>

        <form method="POST" action="{{ route('eye.test.submit') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Your Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Home Address</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Preferred Date</label>
                <input type="date" name="preferred_date" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Submit Request</button>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2>Book Eye Test (Home Service)</h2>

    <form action="{{ route('eye_test.submit') }}" method="POST" class="mt-4">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Preferred Date</label>
            <input type="date" name="preferred_date" class="form-control" required>
        </div>

        <button class="btn btn-primary">Submit Booking</button>
    </form>
</div>
@endsection

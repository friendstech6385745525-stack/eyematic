@extends('layouts.admin')

@section('content')
<div class="container py-4">

    <h2>Eye Test Bookings</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->name }}</td>
                <td>{{ $booking->phone }}</td>
                <td>{{ $booking->address }}</td>
                <td>{{\Carbon\Carbon::parse($booking->preferred_date)->format('d-m-Y') }}</td>
                <td>
                    <form action="{{ route('admin.eye_test.updateStatus', $booking->id) }}" method="POST">
                        @csrf
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="pending" {{ $booking->status=='pending'?'selected':'' }}>Pending</option>
                            <option value="approved" {{ $booking->status=='approved'?'selected':'' }}>Approved</option>
                            <option value="cancelled" {{ $booking->status=='cancelled'?'selected':'' }}>Cancelled</option>
                        </select>
                    </form>
                </td>

                <td>
                    <form action="{{ route('admin.eye_test.destroy', $booking->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $bookings->links() }}

</div>
@endsection

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EyeTestBooking;
use Illuminate\Http\Request;

class EyeTestBookingAdminController extends Controller
{
    public function index()
    {
        $bookings = EyeTestBooking::latest()->paginate(10);
        return view('admin.eye_test.index', compact('bookings'));
    }

    public function updateStatus(Request $request, EyeTestBooking $booking)
    {
        $booking->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status updated!');
    }

    public function destroy(EyeTestBooking $booking)
    {
        $booking->delete();
        return redirect()->back()->with('success', 'Booking removed!');
    }
}

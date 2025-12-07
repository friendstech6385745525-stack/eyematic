<?php

namespace App\Http\Controllers;

use App\Models\EyeTestBooking;
use Illuminate\Http\Request;

class EyeTestBookingController extends Controller
{
    public function form()
    {
        return view('eye_test.form');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'preferred_date' => 'required|date',
        ]);

        EyeTestBooking::create($request->all());

        return redirect()->route('eye_test.success')->with('success', 'Your appointment request has been submitted!');
    }

    public function success()
    {
        return view('eye_test.success');
    }
}

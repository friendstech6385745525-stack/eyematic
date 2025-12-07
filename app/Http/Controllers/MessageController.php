<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller {
        public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'new';

        Message::create($validated);

        return back()->with('success', 'Thank you! Your message has been sent.');
    }

}



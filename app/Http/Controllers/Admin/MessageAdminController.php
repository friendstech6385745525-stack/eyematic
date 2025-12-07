<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin,superadmin']);
    }

    /** List all customer messages */
    public function index()
    {
        $messages = Message::latest()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    /** Show a single message */
    public function show(Message $message)
    {
        if ($message->status === 'new') {
            $message->update(['status'=>'read']);
        }
        return view('admin.messages.show', compact('message'));
    }

    /** Mark as replied or closed */
    public function update(Request $request, Message $message)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied,closed',
        ]);
        $message->update(['status'=>$request->status]);
        return back()->with('success','Status updated.');
    }

    /** Delete message */
    public function destroy(Message $message)
    {
        $message->delete();
        return back()->with('success','Message deleted.');
    }
}

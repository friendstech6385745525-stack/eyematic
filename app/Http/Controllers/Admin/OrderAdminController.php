<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user','items.product'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }


/*    public function show(Order $order)
    {
        $order->load('items.product','user');
        return view('admin.orders.show', compact('order'));
    }
*/
    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }



    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated to ' . ucfirst($order->status));
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('message', 'Order removed successfully.');
    }
}

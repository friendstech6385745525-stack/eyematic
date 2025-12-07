<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Order, OrderItem, Cart, Product};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // -------------------------
    // 1. SHOW CHECKOUT PAGE
    // -------------------------
    public function checkout()
    {
        $user = Auth::user();

        $cartItems = Cart::with('product')
                         ->where('user_id', $user->id)
                         ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

        return view('shop.checkout.index', compact('cartItems', 'total'));
    }

        // 3. PAYMENT PAGE
    // -------------------------
    public function payment(Order $order)
    {
        return view('shop.checkout.payment', compact('order'));
    }

    // -------------------------
    // 2. PLACE ORDER (COD OR ONLINE)
    // -------------------------
    public function placeOrder(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cod,online',
            'address' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $cartItems = Cart::with('product')
                         ->where('user_id', $user->id)
                         ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'address' => $request->address,
                'status' => $request->payment_method === 'cod' ? 'processing' : 'pending',
                'payment_method' => $request->payment_method,
            ]);

            // Add items to order
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'qty' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            // Clear cart
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            // Redirect depending on payment method
            if ($request->payment_method === 'online') {
                return redirect()->route('checkout.payment', $order->id);
            }

            return redirect()->route('checkout.success', $order->id)
                             ->with('message', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    // -------------------------

    // -------------------------
    // 4. CONFIRM PAYMENT (DUMMY)
    // -------------------------
    public function confirmPayment(Request $request, Order $order)
    {
        $order->update([
            'status' => 'completed'
        ]);

        return redirect()->route('checkout.success', $order->id)
                         ->with('message', 'Payment successful!');
    }

    // -------------------------
    // 5. ORDER SUCCESS PAGE
    // -------------------------
    public function success(Order $order)
    {
        $order->load('items.product');

        return view('shop.checkout.success', compact('order'));
    }

    // -------------------------
    // 6. USER ORDERS LIST
    // -------------------------
    public function myOrders()
    {
        $orders = Order::with('items.product')
                       ->where('user_id', auth()->id())
                       ->latest()
                       ->paginate(10);

        return view('shop.orders.index', compact('orders'));
    }

    // -------------------------
    // 7. SHOW ORDER DETAILS
    // -------------------------
    public function show(Order $order)
    {
        // Only admin or owner can see
        if (auth()->user()->role !== 'admin' && auth()->id() !== $order->user_id) {
            abort(403, "Unauthorized.");
        }

        $order->load('items.product');

        return view(auth()->user()->role === 'admin'
            ? 'admin.orders.show'
            : 'shop.orders.show', compact('order'));
    }

    public function buyNow(Product $product)
    {
        $user = auth()->user();

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $product->price,
            'status' => 'pending',
            'payment_method' => 'cod', // you can change later
        ]);

        // Insert item
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $product->price,
            'qty' => 1,
        ]);

        // Redirect to payment page
        return redirect()->route('checkout.payment', $order->id)
                        ->with('success', 'You are checking out 1 item.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;


class CartController extends Controller
{
    /**
     * Show the cart contents.
     */
           public function index()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('shop.cart.index', compact('cartItems'));
    }


    /**
     * Add product to cart.
     */
            public function add(Request $request, Product $product)
        {
            $quantity = $request->input('qty', 1);

            // ✅ If logged in → save to DB
            if (auth()->check()) {
                $cartItems = CartItem::where('user_id', auth()->id())
                            ->where('product_id', $product->id)
                            ->first();

                if ($cartItems) {
                    $cartItems->qty += $quantity;
                    $cartItems->save();
                } else {
                    CartItem::create([
                        'user_id' => auth()->id(),
                        'product_id' => $product->id,
                        'qty' => $quantity,
                        'price' => $product->price,
                    ]);
                }
            }
            // ✅ If guest → store in session
            else {
                $cartItems = session()->get('cart', []);
                if (isset($cartItems[$product->id])) {
                    $cartItems[$product->id]['qty'] += $quantity;
                } else {
                    $cartItems[$product->id] = [
                        'name' => $product->name,
                        'price' => $product->price,
                        'qty' => $quantity,
                        'image' => $product->images[0] ?? null,
                    ];
                }
                session()->put('cart', $cartItems);
            }

            return back()->with('success', 'Added to cart successfully');
        }

    /**
     * Update quantities.
     */
/*    public function update(Request $request)
    {
        $cart = session('cart', []);

        foreach ($request->input('qty', []) as $productId => $qty) {
            if (isset($cart[$productId])) {
                $cart[$productId]['qty'] = max(1, (int) $qty);
            }
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Cart updated!');
    }*/

    public function update(Request $request, $id)
{
    $cartItems = CartItem::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $cartItems->update(['qty' => $request->qty]);

    return back()->with('message', 'Cart updated successfully!');
}

    public function updateQuantity(Request $request, $id)
{
    $cart = session('cart', []);

    if (isset($cart[$id])) {
        $newQty = max(1, (int) $request->qty); // prevent zero/negative
        $cart[$id]['qty'] = $newQty;

        session(['cart' => $cart]);
        return redirect()->route('cart.index')->with('message', 'Quantity updated successfully.');
    }

    return redirect()->route('cart.index')->with('error', 'Item not found in cart.');
}


/*public function updateQuantity(Request $request, $id)
{
    $request->validate(['qty' => 'required|integer|min:1|max:10']);

    $item = \App\Models\CartItem::where('id', $id)
        ->where('user_id', Auth::id())
        ->first();

    if ($item) {
        $item->qty = $request->qty;
        $item->save();
        return back()->with('message', 'Quantity updated successfully.');
    }

    return back()->with('error', 'Item not found.');
}*/

    /**
     * Remove single item.
     */

    public function remove($id)
{
    $cartItems = CartItem::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $cartItem->delete();

    return back()->with('message', 'Item removed from cart.');
}



    /**
 * 🗑️ Remove an item from cart session
 */
public function removeFromCart($id)
{
    $item = Cart::where('id', $id)
        ->where('user_id', Auth::id())
        ->first();

    if ($item) {
        $item->delete();
        return redirect()->route('cart.index')->with('message', 'Item removed from cart.');
    }

    return redirect()->route('cart.index')->with('error', 'Item not found.');
}


    /**
     * Empty the whole cart.
     */
        public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();
        return back()->with('message', 'Cart cleared successfully.');
    }

}

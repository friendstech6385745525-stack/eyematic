<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => 'required|in:customer,vendor'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    Auth::login($user);

    // ✅ Move session cart to DB after registration
if (session()->has('cart')) {
    $sessionCart = session('cart');
    foreach ($sessionCart as $productId => $item) {
        $cart = \App\Models\Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cart) {
            $cart->quantity += $item['quantity'];
            $cart->save();
        } else {
            \App\Models\Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
            ]);
        }
    }
    session()->forget('cart');
}


    return redirect(RouteServiceProvider::profile);
}
}

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ShopController, CartController, CheckoutController, MessageController, OrderController, EyeTestBookingController
};
use App\Http\Controllers\Admin\{
    ProductController as AdminProductController,
    ShopContentController, MessageAdminController, DashboardController, BrandController, CategoryController, OrderAdminController, EyeTestBookingAdminController, HomepageSectionController
};
use App\Http\Controllers\Vendor\ProductController as VendorProductController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

// Public pages
Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/products', [ShopController::class, 'index'])->name('products.index');
Route::get('/product/{product:slug}', [ShopController::class, 'show'])->name('products.show');

// Filters
Route::get('/brands/{slug}', [ShopController::class, 'filterByBrand'])->name('products.byBrand');
Route::get('/categories/{slug}', [ShopController::class, 'filterByCategory'])->name('products.byCategory');

/* Route::get('/auth/google', [SocialLoginController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialLoginController::class, 'callback']);
*/

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    // Check existing user
    $user = User::where('email', $googleUser->email)->first();

    // If not exists → auto-register
    if (!$user) {
        $user = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_id' => $googleUser->id,
            'password' => bcrypt(Str::random(16)), // random password
            'role' => 'customer', // default role
        ]);
    }

    // Auto login
    Auth::login($user);

    return redirect('/'); // redirect to homepage
});



// Authenticated user actions
Route::middleware(['auth'])->group(function () {

    // Cart routes (CartController should implement these methods)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');          // matches CartController@update
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');      // matches CartController@remove
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // User orders
    Route::get('/my-orders', [CheckoutController::class, 'myOrders'])->name('orders.index');
    Route::post('/my-orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Order viewing (single order)
    Route::get('/orders/{order}', [CheckoutController::class, 'show'])->name('orders.show');

    // Unified checkout routes (matches the new CheckoutController)
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.page');             // show checkout page (DB cart)
    Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');// place order (creates order + items)
    Route::get('/checkout/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/confirm/{order}', [CheckoutController::class, 'confirmPayment'])->name('checkout.confirm');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Quick buy (single product buy now)
    Route::get('/buy-now/{product}', [CheckoutController::class, 'buyNow'])->name('buy.now');

    // Messages/contact
    Route::post('/contact', [MessageController::class, 'store'])->name('message.store');

    // (Optional) Razorpay endpoints — add back only if you're implementing them in the same controller
     Route::post('/razorpay/order', [CheckoutController::class, 'createRazorpayOrder'])->name('razorpay.order');
     Route::post('/razorpay/verify', [CheckoutController::class, 'verifyPayment'])->name('razorpay.verify');

    // Eye test booking
    Route::get('/eye-test', [EyeTestBookingController::class, 'form'])->name('eye_test.form');
    Route::post('/eye-test', [EyeTestBookingController::class, 'submit'])->name('eye_test.submit');
    Route::get('/eye-test/success', [EyeTestBookingController::class, 'success'])->name('eye_test.success');


});

// Admin area
Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin,superadmin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('shop_content', ShopContentController::class);
    Route::resource('messages', MessageAdminController::class)->only(['index','show','update','destroy']);
    Route::resource('brands', BrandController::class);
    Route::resource('categories', CategoryController::class);

    // Order management (admin)
    Route::get('/orders', [OrderAdminController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderAdminController::class,'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [OrderAdminController::class,'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{order}', [OrderAdminController::class, 'destroy'])->name('orders.destroy');

    // Eye test bookings management
    Route::get('/eye-test', [EyeTestBookingAdminController::class, 'index'])->name('eye_test.index');
    Route::post('/eye-test/{booking}/status', [EyeTestBookingAdminController::class, 'updateStatus'])->name('eye_test.updateStatus');
    Route::delete('/eye-test/{booking}', [EyeTestBookingAdminController::class, 'destroy'])->name('eye_test.destroy');


    // Home Page Sections
    Route::get('/home-sections', [HomepageSectionController::class, 'index'])->name('home.sections.index');
    Route::get('/home-sections/create', [HomepageSectionController::class, 'create'])->name('home.sections.create');
    Route::post('/home-sections/store', [HomepageSectionController::class, 'store'])->name('home.sections.store');
    Route::get('/home-sections/{section}/edit', [HomepageSectionController::class, 'edit'])->name('home.sections.edit');
    Route::post('/home-sections/{section}/update', [HomepageSectionController::class, 'update'])->name('home.sections.update');
    Route::delete('/home-sections/{section}/delete', [HomepageSectionController::class, 'destroy'])->name('home.sections.delete');

});

// Vendor area
Route::prefix('vendor')->name('vendor.')->middleware(['auth','role:vendor,superadmin'])->group(function () {
    Route::get('/', fn() => view('vendor.dashboard'))->name('dashboard');
    Route::resource('products', VendorProductController::class);
});

// Dashboard & profile (default)
Route::get('/', [ShopController::class, 'home'])->middleware(['auth', 'verified'])->name('home');
/*Route::get('/', function () {
    return view('shop.home');
})->middleware(['auth', 'verified'])->name('home');
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Debug helper (remove in production)
Route::get('/debug-session', function () {
    return response()->json([
        'session'  => session()->all(),
        'cookies'  => request()->cookies->all(),
        'app_url'  => config('app.url'),
        'session_driver' => config('session.driver'),
    ]);
});

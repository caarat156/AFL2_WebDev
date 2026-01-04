<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PaymentController;


/*
|--------------------------------------------------------------------------
| 🌐 PUBLIC AREA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('homeumum');
})->middleware('guest')->name('homeumum');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');
Route::get('/workshops/{workshop}', [WorkshopController::class, 'show'])->name('workshops.show');

// USER ONLY
Route::get('/workshops/{workshop}/register', 
    [WorkshopController::class, 'registerForm']
)->middleware('auth')->name('workshops.register');

Route::post('/workshops/{workshop}/register', 
    [WorkshopController::class, 'storeRegistration']
)->middleware('auth')->name('workshops.storeRegistration');

// GUEST ONLY
Route::post('/workshops/{workshop}/guest-register',
    [WorkshopController::class, 'storeGuestRegistration']
)->name('workshops.guestRegister');

Route::view('/about', 'about')->name('about');

Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');

/*
|--------------------------------------------------------------------------
| 💳 MIDTRANS PAYMENT (SANDBOX)
|--------------------------------------------------------------------------
*/

Route::post('/create-payment', function (\Illuminate\Http\Request $request) {

    \Midtrans\Config::$serverKey    = config('midtrans.server_key');
    \Midtrans\Config::$clientKey    = config('midtrans.client_key');
    \Midtrans\Config::$isProduction = config('midtrans.is_production');
    \Midtrans\Config::$isSanitized  = true;
    \Midtrans\Config::$is3ds        = true;

    $params = [
        'transaction_details' => [
            'order_id'     => $request->order_id,
            'gross_amount' => $request->amount,
        ],
        'customer_details' => [
            'first_name' => $request->name,
            'email'      => $request->email,
        ]
    ];

    $snapToken = \Midtrans\Snap::getSnapToken($params);

    return response()->json([
        'snap_token' => $snapToken
    ]);
});

/*
|--------------------------------------------------------------------------
| 👤 USER AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {

    Route::get('/home', [HomeController::class, 'userHome'])->name('home');

    Route::get('/products', [ProductController::class, 'userIndex'])->name('products');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    Route::get('/stores', [StoreController::class, 'userIndex'])->name('stores');

    Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');

    Route::middleware(['auth'])->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
        Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    
        Route::post('/checkout', [CartController::class, 'checkout'])
            ->name('checkout');
    ;
    
        
    });


    // 👤 Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 💬 Reviews
    Route::resource('reviews', ReviewController::class);

    // 📍 Address
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');

    // 💳 Payment
    Route::post('/payment/snap-token',[PaymentController::class, 'createSnapToken'])->name('payment.snap-token');
    Route::post('/midtrans/callback', [PaymentController::class, 'callback']);
    Route::get('/payment/finish', [PaymentController::class, 'finish'])
    ->name('user.payment.finish')
    ->middleware('auth');
Route::post('/midtrans/notification', [PaymentController::class, 'callback']);






});

/*
|--------------------------------------------------------------------------
| 🛠️ ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/home', [HomeController::class, 'adminHome'])->name('home');

    // 📦 Products
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/transactions', [ProductController::class, 'viewTransactions'])->name('transactions');

    // 🏪 Stores
    Route::get('/stores', [StoreController::class, 'adminIndex'])->name('stores');
    Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');
    Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');
    Route::get('/stores/{store}/edit', [StoreController::class, 'edit'])->name('stores.edit');
    Route::put('/stores/{id}', [StoreController::class, 'update'])->name('stores.update');
    Route::delete('/stores/{store}', [StoreController::class, 'destroy'])->name('stores.destroy');

    // 🎓 Workshops
    Route::get('/workshops', [WorkshopController::class, 'adminIndex'])->name('workshops');
    Route::get('/workshops/create', [WorkshopController::class, 'create'])->name('workshops.create');
    Route::post('/workshops', [WorkshopController::class, 'store'])->name('workshops.store');
    Route::get('/workshops/{workshop}/edit', [WorkshopController::class, 'edit'])->name('workshops.edit');
    Route::put('/workshops/{workshop}', [WorkshopController::class, 'update'])->name('workshops.update');
    Route::delete('/workshops/{workshop}', [WorkshopController::class, 'destroy'])->name('workshops.destroy');
    Route::get('/workshops/{workshop}/participants', [WorkshopController::class, 'showParticipants'])->name('workshops.participants');

    Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('profile');
});

require __DIR__.'/auth.php';

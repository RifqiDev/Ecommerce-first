<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SesiControler;
use App\Http\Controllers\CartControler;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

//bad end

Route::get('register', [SesiControler::class, 'register'])->name('register');
Route::post('register', [SesiControler::class, 'register_action'])->name('register.action');
Route::get('password', [UserController::class, 'password'])->name('password');
Route::post('password', [UserController::class, 'password_action'])->name('password.action');




//front end
Route::resource('index','App\Http\Controllers\Index');
Route::resource('shop','App\Http\Controllers\Shop');
Route::resource('shop2','App\Http\Controllers\Shop');
Route::resource('detail','App\Http\Controllers\Detail');
Route::resource('checkout','App\Http\Controllers\Checkout');
Route::resource('cart','App\Http\Controllers\Cart');
Route::resource('contact','App\Http\Controllers\Contact');






Route::middleware(['guest'])->group(function(){
    Route::get('login', [App\Http\Controllers\SesiControler::class, 'index'])->name('login');
    Route::post('login',[App\Http\Controllers\SesiControler::class, 'login']);

});


Route::get('/home', function () {
    return redirect('/admin');
    });

    Route::middleware(['auth'])->group(function(){
    Route::group(['middleware' => ['isUser']], function () {
        Route::get('/user', [App\Http\Controllers\Admin::class, 'user'])->middleware('UserAkses:user');
        Route::post('checkout/send-whatsapp', [CheckoutController::class, 'sendWhatsAppMessage']);
        Route::get('/checkout/success', function () {
            return view('checkout');
        })->name('checkout.success');
        Route::get('/checkout', [CheckoutController::class, 'index']);
        Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
        Route::resource('users', 'App\Http\Controllers\UserController');
        Route::get('cart', [CartControler::class, 'index'])->name('index');
        Route::post('/cart/{productId}/add', [CartControler::class, 'addToCart'])->name('cart.add');
        Route::delete('/cart/remove/{cartId}', [CartControler::class, 'removeFromCart'])->name('cart.remove');

        Route::post('/update-cart/{cartId}', 'CartController@updateCart');
        Route::get('logout', [SesiControler::class, 'logout'])->name('logout');
    });

    Route::group(['middleware' => ['isAdmin']], function () {
        Route::get('admin',[App\Http\Controllers\Admin::class, 'index'])->middleware('UserAkses:admin');
        Route::resource('homelte', 'App\Http\Controllers\Homelte');
        Route::resource('satuan', 'App\Http\Controllers\Satuan');
        Route::resource('kategori', 'App\Http\Controllers\Kategori');
        Route::resource('pelanggan', 'App\Http\Controllers\ControllerPelanggan');
        Route::resource('stok', 'App\Http\Controllers\ControllerStok');
        Route::resource('pemasok', 'App\Http\Controllers\ControllerPemasok');
        Route::resource('status', 'App\Http\Controllers\Status');
        Route::resource('templetkampus', 'App\Http\Controllers\KampusController');
        Route::resource('mutasi', 'App\Http\Controllers\MutasiController');
        Route::get('logout', [SesiControler::class, 'logout'])->name('logout');
    });
    Route::get('logout', [SesiControler::class, 'logout'])->name('logout');
    });

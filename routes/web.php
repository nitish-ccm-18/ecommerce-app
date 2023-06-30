<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{category_id?}', [HomeController::class,'index'])->where('category_id', '[0-9]+');

/* ------------------------User Related Routes starts here-----------------------------*/
// User Registration
Route::get('/register', [Authcontroller::class, 'register'])
->name('register');
Route::post('/register', [Authcontroller::class, 'store'])
->name('user.create');


// User auth
Route::get('/login', [Authcontroller::class, 'login'])
->name('login');
Route::post('/login', [Authcontroller::class, 'authenticate'])
->name('authenticate');
Route::get('/logout',[Authcontroller::class, 'logout'])
->name('logout');


// Password Recovery 
Route::get('/password/forgot', [AuthController::class, 'forgot_password'])
->name('password.request');
Route::post('/password/forgot', [AuthController::class, 'send_password_reset_email'])
->name('password.email');

// Reset Password
Route::get('/reset-password/{token}', [AuthController::class, 'reset_password'])
->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'update_password'])
->name('password.update');

// Profile Management
Route::get('/profile/me', [ProfileController::class, 'my_profile'])
->name('myprofile');
Route::patch('/profile/update', [ProfileController::class,'update'])
->name('profile.update');

// User Dashboard
Route::get('/user/dashboard', [UserController::class, 'dashboard'])
->name('user.dashboard');

/*--------------------- User Related Routes Ends Here----------------------------*/




/*---------------------Admin Routes Starts Here----------------------------*/

// Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
->name('admin.dashboard');

// Categories Routes
Route::get('/categories/create', [CategoryController::class, 'create'])
->name('categories.create');
Route::post('/categories/create', [CategoryController::class, 'store'])
->name('categories.store');

Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])
->name('categories.edit');
Route::patch('/categories/update', [CategoryController::class, 'update'])
->name('categories.update');

Route::get('/categories', [CategoryController::class, 'index'])
->name('categories.index');


Route::get('/categories/{id}/status', [CategoryController::class, 'change_status'])->whereNumber('id')
->name('categories.status.change');

Route::get('/categories/{id}', [CategoryController::class, 'show'])->whereNumber('id')
->name('categories.show');


// Product Routes
Route::get('/products/create', [ProductController::class, 'create'])
->name('products.create');
Route::post('/products/create', [ProductController::class, 'store'])
->name('products.store');

Route::get('/products/edit/{id}', [ProductController::class,'edit'])
->name('products.edit');
Route::post('/products/edit', [ProductController::class,'update'])
->name('products.update');

Route::get('/products', [ProductController::class, 'index'])
->name('products.index');

Route::get('/products/{id}/status', [ProductController::class, 'change_status'])
->name('products.status.change');

Route::get('/products/{id}', [ProductController::class,'show'])
->name('products.show');


// Show Any User Profile 
Route::get('/profile/{id}', [ProfileController::class,'user_profile'])
->whereNumber('id')
->name('user.profile');

/*---------------------Admin Routes Ends Here----------------------------*/


// Cart Route
Route::post('/cart/add', [AjaxController::class,'add_to_cart'])
->name('cart.add');
Route::get('/cart/count', [AjaxController::class,'countCartItems'])
->name('cart.count');
Route::view('cart','cart')->name('cart');



















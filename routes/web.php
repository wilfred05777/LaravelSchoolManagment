<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StaffViewController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\CheckAge;
use App\Models\User;

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

// FSSFSSFSSSFFFFFSFSFSFSFSFSFSF

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
})->middleware('checkage');

// Route::get('contact', function () {
//    return view('contact');
// });
// Route::get('/contact', 'ContactController@index' );

Route::get('/home', function(){
    return view('home');
});

Route::get('/contact', [ContactController::class, 'index'])->name('con');

Route::get('/userprofile',[UserProfileController::class, 'index']);

Route::get('/staffview', [StaffViewController::class, 'index'])->name('conn1');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    $users = User::all();
    return view('dashboard', compact('users'));
})->name('dashboard');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\StaffViewController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\CheckAge;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

// category COntroller
Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add', [CategoryController::class, 'AddCat'])->name('store.category');

Route::get('/userprofile',[UserProfileController::class, 'index']);

Route::get('/staffview', [StaffViewController::class, 'index'])->name('conn1');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    // $users = User::all();
    $users = DB::table('users')->get();

    return view('dashboard', compact('users'));
})->name('dashboard');

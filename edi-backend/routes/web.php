<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

//Landing page
// Route::get('/', function () {
//     return view('landing');
// });
Route::get('/', [HomeController::class, 'landing'])->name('landing');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('do-login', [AuthController::class, 'doLogin'])->name('do-login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('home', [HomeController::class, 'index'])->name('home');
// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    require_once __DIR__.'/Web/admin.php';
});

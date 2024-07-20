<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRoleAdminMiddleware;

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
    return view('welcome');
});




route::get('login',[AuthController::class,'showFromLogin']);
route::post('login',[AuthController::class,'login'])->name('login');

route::get('register',[AuthController::class,'showFromRegister']);
route::post('register',[AuthController::class,'register'])->name('register');
route::post('logout',[AuthController::class,'logout'])->name('logout');


// Route::get('/home', function () {
//     return view('home');
// })->middleware('auth');
// route::get('/admin',function () {
//     return 'Đây là trang admin';
// })->middleware(['auth','auth.admin']);

// Route::middleware('auth')->group(function (){
//     Route::get('/home', function () {
//         return view('home');
//     });
//     Route::get('/home2', function () {
//         return view('home');
//     });

//     Route::middleware('auth.admin')->group(function (){
//         route::get('/admin',function () {
//             return 'Đây là trang admin';
//         });
//     });
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group( function () {
    //FITUR DASAR
    Route::middleware(['user'])->group(function () { 
        Route::get('/profile/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.profile');
        Route::put('/profile/update/{id}', [App\Http\Controllers\UserController::class, 'update_profile'])->name('user.update.profile');
    });
    //FITUR ADMIN 
    Route::middleware(['iso'])->group( function () {
        //manajemen pengguna
        Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
        Route::post('/user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
        Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
        Route::delete('/user/delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.delete');
        Route::get('/user/show/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');

        //manajemen halaman
        Route::get('/halaman',[App\Http\Controllers\halamanController::class,'menu'])->name('menu.index');


        //manajemen postingan
        Route::get('/post', [App\Http\Controllers\beritaController::class, 'index'])->name('post.index');
        Route::get('/post/create', [App\Http\Controllers\beritaController::class, 'create'])->name('post.create');
        Route::get('/post/edit/{post}', [App\Http\Controllers\beritaController::class, 'edit'])->name('post.edit');
        Route::put('/post/update/{post}', [App\Http\Controllers\beritaController::class, 'update'])->name('post.update');
        Route::post('/post/store', [App\Http\Controllers\beritaController::class, 'store'])->name('post.store');
        // Route::get('/post/view/{post}', [App\Http\Controllers\beritaController::class, 'show'])->name('post.view');
    });
});
//FITUR TANPA AUTENTIKASI
Route::get('/berita', [App\Http\Controllers\beritaController::class, 'show'])->name('post.view');
Route::get('/page', [App\Http\Controllers\halamanController::class,'showpage'])->name('page.show');
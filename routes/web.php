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
Auth::routes(['register' => false, 'password.request'=> false]);
Route::post('/login',[App\Http\Controllers\Auth\loginController::class, 'Authenticate'])->name('masuk');
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

        //manajemen halaman: menu
        Route::get('/halaman',[App\Http\Controllers\halamanController::class,'menu'])->name('menu.index');
        Route::post('/halaman',[App\Http\Controllers\halamanController::class,'store_menu'])->name('menu.store');
        Route::get('/halaman/edit/{menu}',[App\Http\Controllers\halamanController::class,'edit_menu'])->name('menu.edit');
        Route::put('/halaman/edit/{menu}', [App\Http\Controllers\halamanController::class, 'update_menu'])->name('menu.update');
        Route::delete('/halaman/delete/{menu}', [App\Http\Controllers\halamanController::class, 'destroy_menu'])->name('menu.delete');
        //manajemen halaman: submenu
        Route::get('/halaman/submenu/{menu}',[App\Http\Controllers\halamanController::class,'submenu'])->name('submenu.index');
        Route::get('/halaman/submenu/{menu}/create',[App\Http\Controllers\halamanController::class, 'create_submenu'])->name('submenu.create');
        Route::post('/halaman/submenu/{menu}/create', [App\Http\Controllers\halamanController::class, 'store'])->name('submenu.store');
        Route::get('/halaman/submenu/{menu}/edit/{submenu}', [App\Http\Controllers\halamanController::class, 'edit_submenu'])->name('submenu.edit');
        Route::put('/halaman/submenu/{menu}/edit/{submenu}', [App\Http\Controllers\halamanController::class, 'update_submenu'])->name('submenu.update');
        Route::delete('/halaman/submenu/{menu}/delete/{submenu}', [App\Http\Controllers\halamanController::class, 'destroy_submenu'])->name('submenu.delete');
        //manajemen halaman: subsubmenu
        Route::get('/halaman/subsubmenu/{submenu}',[App\Http\Controllers\halamanController::class,'subsubmenu'])->name('subsubmenu.index');
        Route::get('/halaman/subsubmenu/{submenu}/create', [App\Http\Controllers\halamanController::class, 'create_subsubmenu'])->name('subsubmenu.create');
        Route::post('/halaman/subsubmenu/{submenu}/create', [App\Http\Controllers\halamanController::class, 'store'])->name('subsubmenu.store');
        Route::get('/halaman/subsubmenu/{submenu}/edit/{subsubmenu}',[App\Http\Controllers\halamanController::class, 'edit_subsubmenu'])->name('subsubmenu.edit');
        Route::put('/halaman/subsubmenu/{submenu}/edit/{subsubmenu}',[App\Http\Controllers\halamanController::class, 'update_subsubmenu'])->name('subsubmenu.update');
        Route::delete('/halaman/subsubmenu/{submenu}/delete/{subsubmenu}', [App\Http\Controllers\halamanController::class, 'destroy_subsubmenu'])->name('subsubmenu.delete');
        //manajemen halaman: subsubsubmenu
        Route::get('/halaman/subsubsubmenu/{subsubmenu}',[App\Http\Controllers\halamanController::class,'subsubsubmenu'])->name('subsubsubmenu.index');
        Route::get('/halaman/subsubsubmenu/{subsubmenu}/create', [App\Http\Controllers\halamanController::class, 'create_subsubsubmenu'])->name('subsubsubmenu.create');
        Route::post('/halaman/subsubsubmenu/{subsubmenu}/create', [App\Http\Controllers\halamanController::class, 'store'])->name('subsubsubmenu.store');
        Route::get('/halaman/subsubsubmenu/{subsubmenu}/edit/{subsubsubmenu}', [App\Http\Controllers\halamanController::class, 'edit_subsubsubmenu'])->name('subsubsubmenu.edit');
        Route::put('/halaman/subsubsubmenu/{subsubmenu}/edit/{subsubsubmenu}', [App\Http\Controllers\halamanController::class, 'update_subsubsubmenu'])->name('subsubsubmenu.update');
        Route::delete('/halaman/subsubsubmenu/{subsubmenu}/edit/{subsubsubmenu}', [App\Http\Controllers\halamanController::class, 'destroy_subsubsubmenu'])->name('subsubsubmenu.delete');

        //manajemen template website
        Route::get('/template',[App\Http\Controllers\layoutController::class,'index'])->name('template.index');
    });
    //manajemen postingan
    Route::get('/post', [App\Http\Controllers\beritaController::class, 'index'])->name('post.index');
    Route::get('/post/create', [App\Http\Controllers\beritaController::class, 'create'])->name('post.create');
    Route::post('/post/store', [App\Http\Controllers\beritaController::class, 'store'])->name('post.store');
    Route::get('/post/edit/{post}', [App\Http\Controllers\beritaController::class, 'edit'])->name('post.edit');
    Route::put('/post/update/{post}', [App\Http\Controllers\beritaController::class, 'update'])->name('post.update');
    Route::delete('/post/delete/{post}', [App\Http\Controllers\beritaController::class, 'destroy'])->name('post.delete');
});
//FITUR TANPA AUTENTIKASI
Route::middleware(['pengunjung'])->group( function (){
    Route::get('/', function () {
        return view('welcome');
    });
    Route::middleware(['trending'])->group( function (){
        Route::get('/berita', [App\Http\Controllers\beritaController::class, 'show'])->name('post.view');    
    });
    Route::get('/page', [App\Http\Controllers\halamanController::class,'showpage'])->name('page.show');    
});

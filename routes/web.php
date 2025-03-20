<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your Application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes(['register' => false, 'password.request'=> false]);
Route::post('/login',[App\Http\Controllers\Auth\LoginController::class, 'Authenticate'])->name('masuk');
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
        Route::put('/halaman/submenu/{menu}/edit/{submenu}', [App\Http\Controllers\halamanController::class, 'update'])->name('submenu.update');
        Route::delete('/halaman/submenu/{menu}/delete/{submenu}', [App\Http\Controllers\halamanController::class, 'destroy_submenu'])->name('submenu.delete');
        //manajemen halaman: subsubmenu
        Route::get('/halaman/subsubmenu/{submenu}',[App\Http\Controllers\halamanController::class,'subsubmenu'])->name('subsubmenu.index');
        Route::get('/halaman/subsubmenu/{submenu}/create', [App\Http\Controllers\halamanController::class, 'create_subsubmenu'])->name('subsubmenu.create');
        Route::post('/halaman/subsubmenu/{submenu}/create', [App\Http\Controllers\halamanController::class, 'store'])->name('subsubmenu.store');
        Route::get('/halaman/subsubmenu/{submenu}/edit/{subsubmenu}',[App\Http\Controllers\halamanController::class, 'edit_subsubmenu'])->name('subsubmenu.edit');
        Route::put('/halaman/subsubmenu/{submenu}/edit/{subsubmenu}',[App\Http\Controllers\halamanController::class, 'update'])->name('subsubmenu.update');
        Route::delete('/halaman/subsubmenu/{submenu}/delete/{subsubmenu}', [App\Http\Controllers\halamanController::class, 'destroy_subsubmenu'])->name('subsubmenu.delete');
        //manajemen halaman: subsubsubmenu
        Route::get('/halaman/subsubsubmenu/{subsubmenu}',[App\Http\Controllers\halamanController::class,'subsubsubmenu'])->name('subsubsubmenu.index');
        Route::get('/halaman/subsubsubmenu/{subsubmenu}/create', [App\Http\Controllers\halamanController::class, 'create_subsubsubmenu'])->name('subsubsubmenu.create');
        Route::post('/halaman/subsubsubmenu/{subsubmenu}/create', [App\Http\Controllers\halamanController::class, 'store'])->name('subsubsubmenu.store');
        Route::get('/halaman/subsubsubmenu/{subsubmenu}/edit/{subsubsubmenu}', [App\Http\Controllers\halamanController::class, 'edit_subsubsubmenu'])->name('subsubsubmenu.edit');
        Route::put('/halaman/subsubsubmenu/{subsubmenu}/edit/{subsubsubmenu}', [App\Http\Controllers\halamanController::class, 'update'])->name('subsubsubmenu.update');
        Route::delete('/halaman/subsubsubmenu/{subsubmenu}/edit/{subsubsubmenu}', [App\Http\Controllers\halamanController::class, 'destroy_subsubsubmenu'])->name('subsubsubmenu.delete');

        //manajemen template /layout website
        Route::get('/galeri-geser', [App\Http\Controllers\layoutController::class, 'index'])->name('slider.index');
        Route::get('/galeri-geser/create',[App\Http\Controllers\layoutController::class, 'create'])->name('slider.create');
        Route::post('/galeri-geser/create',[App\Http\Controllers\layoutController::class, 'store'])->name('slider.store');
        Route::get('/galeri-geser/edit/{slider}', [App\Http\Controllers\layoutController::class, 'edit'])->name('slider.edit');
        Route::put('/galeri-geser/edit/{slider}',[App\Http\Controllers\layoutController::class, 'update'])->name('slider.update');

        Route::get('/post/category/create',[App\Http\Controllers\beritaController::class, 'kategori_create'])->name('post.category.create');
        Route::post('/post/category/create',[App\Http\Controllers\beritaController::class, 'kategori_store'])->name('post.category.store');
        Route::get('/post/category/edit/{cat}',[App\Http\Controllers\beritaController::class, 'kategori_edit'])->name('post.category.edit');
        Route::put('/post/category/edit/{cat}',[App\Http\Controllers\beritaController::class, 'kategori_update'])->name('post.category.update');
        Route::delete('/post/category/delete/{cat}',[App\Http\Controllers\beritaController::class, 'kategori_destroy'])->name('post.category.delete');
    });
    //manajemen postingan
    Route::get('/post', [App\Http\Controllers\beritaController::class, 'index'])->name('post.index');
    Route::get('/post/create', [App\Http\Controllers\beritaController::class, 'create'])->name('post.create');
    Route::post('/post/store', [App\Http\Controllers\beritaController::class, 'store'])->name('post.store');
    Route::get('/post/edit/{post}', [App\Http\Controllers\beritaController::class, 'edit'])->name('post.edit');
    Route::put('/post/update/{post}', [App\Http\Controllers\beritaController::class, 'update'])->name('post.update');
    Route::delete('/post/delete/{post}', [App\Http\Controllers\beritaController::class, 'destroy'])->name('post.delete');

    Route::get('/banner',[App\Http\Controllers\layoutController::class, 'index'])->name('banner.index');
    Route::get('/banner/create',[App\Http\Controllers\layoutController::class, 'create'])->name('banner.create');
    Route::post('/banner/create',[App\Http\Controllers\layoutController::class, 'store'])->name('banner.store');
    Route::get('/banner/edit/{banner}', [App\Http\Controllers\layoutController::class, 'edit'])->name('banner.edit');
    Route::put('/banner/edit/{banner}',[App\Http\Controllers\layoutController::class, 'update'])->name('banner.update');

    Route::get('/agenda-kegiatan', [App\Http\Controllers\agendaController::class, 'index'])->name('kalender.index');
    Route::get('/agenda-kegiatan/create', [App\Http\Controllers\agendaController::class, 'create'])->name('kalender.create');
    Route::post('/agenda-kegiatan/create', [App\Http\Controllers\agendaController::class, 'store'])->name('kalender.store');
    Route::get('/agenda-kegiatan/edit/{agenda}', [App\Http\Controllers\agendaController::class, 'edit'])->name('kalender.edit');
    Route::put('/agenda-kegiatan/edit/{agenda}', [App\Http\Controllers\agendaController::class, 'update'])->name('kalender.update');
    Route::delete('/agenda-kegiatan/delete/{agenda}', [App\Http\Controllers\agendaController::class, 'destroy'])->name('kalender.delete');

    Route::get('/file', [App\Http\Controllers\unduhController::class, 'index'])->name('unduh.index');
    Route::get('/file/create', [App\Http\Controllers\unduhController::class, 'create'])->name('unduh.create');
    Route::post('/file/create', [App\Http\Controllers\unduhController::class, 'store'])->name('unduh.store');
    Route::get('/file/edit/{file}', [App\Http\Controllers\unduhController::class, 'edit'])->name('unduh.edit');
    Route::put('/file/edit/{file}', [App\Http\Controllers\unduhController::class, 'update'])->name('unduh.update');
    Route::delete('/file/delete/{file}', [App\Http\Controllers\unduhController::class, 'destroy'])->name('unduh.delete');

    Route::get('/file/category/create',[App\Http\Controllers\unduhController::class, 'kategori_create'])->name('unduh.category.create');
    Route::post('/file/category/create',[App\Http\Controllers\unduhController::class, 'kategori_store'])->name('unduh.category.store');
    Route::get('/file/category/edit/{cat}',[App\Http\Controllers\unduhController::class, 'kategori_edit'])->name('unduh.category.edit');
    Route::put('/file/category/edit/{cat}',[App\Http\Controllers\unduhController::class, 'kategori_update'])->name('unduh.category.update');
    Route::delete('/file/category/delete/{cat}',[App\Http\Controllers\unduhController::class, 'kategori_destroy'])->name('unduh.category.delete');

    Route::get('/link', [App\Http\Controllers\linkController::class, 'index'])->name('link.index');
    Route::get('/link/create', [App\Http\Controllers\linkController::class, 'create'])->name('link.create');
    Route::post('/link/create', [App\Http\Controllers\linkController::class, 'store'])->name('link.store');
    Route::get('/link/edit/{link}', [App\Http\Controllers\linkController::class, 'edit'])->name('link.edit');
    Route::put('/link/edit/{link}', [App\Http\Controllers\linkController::class, 'update'])->name('link.update');
    Route::delete('/link/delete/{link}', [App\Http\Controllers\linkController::class, 'destroy'])->name('link.delete');
});
//FITUR TANPA AUTENTIKASI
Route::middleware(['pengunjung','meta'])->group( function (){
    Route::get('/', function () {
        return view('welcome');
    });
    Route::middleware(['trending'])->group( function (){
        Route::get('/berita', [App\Http\Controllers\beritaController::class, 'show'])->name('post.view');    
    });
    Route::get('/list-berita', [App\Http\Controllers\beritaController::class, 'list'])->name('post.list');
    Route::post('/list-berita', [App\Http\Controllers\beritaController::class, 'search'])->name('post.search');
    Route::get('/berita/kategori/{kategori}', [App\Http\Controllers\beritaController::class, 'categories'])->name('post.category');
    Route::get('/galeri', [App\Http\Controllers\layoutController::class, 'galeri'])->name('galeri');
    Route::get('/page', [App\Http\Controllers\halamanController::class,'show'])->name('page.show');
    Route::get('/daftar-berita',[App\Http\Controllers\beritaController::class, 'list'])->name('post.list');
    Route::post('/daftar-berita', [App\Http\Controllers\beritaController::class, 'search'])->name('post.search');
    Route::get('/unduh', [App\Http\Controllers\unduhController::class, 'show'])->name('unduh.show');
    Route::get('/unduh-file/{id}', [App\Http\Controllers\unduhController::class, 'download'])->name('unduh-file');
    Route::get('/agenda', [App\Http\Controllers\agendaController::class, 'show'])->name('kalender.show');
});

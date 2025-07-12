<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
        Route::get('/logs', function() {
            $logs = App\Models\logs::orderBy('created_at', 'desc')->simplePaginate(20);
            return view('logs')->with('logs', $logs);
        })->name('logs');
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

        //manajemen halaman: subsubsubsubmenu
        Route::get('/halaman/subsubsubsubmenu/{subsubsubmenu}',[App\Http\Controllers\halamanController::class,'subsubsubsubmenu'])->name('subsubsubsubmenu.index');
        Route::get('/halaman/subsubsubsubmenu/{subsubsubmenu}/create', [App\Http\Controllers\halamanController::class, 'create_subsubsubsubmenu'])->name('subsubsubsubmenu.create');
        Route::post('/halaman/subsubsubsubmenu/{subsubsubmenu}/create', [App\Http\Controllers\halamanController::class, 'store'])->name('subsubsubsubmenu.store');
        Route::get('/halaman/subsubsubsubmenu/{subsubsubmenu}/edit/{subsubsubsubmenu}', [App\Http\Controllers\halamanController::class, 'edit_subsubsubsubmenu'])->name('subsubsubsubmenu.edit');
        Route::put('/halaman/subsubsubsubmenu/{subsubsubmenu}/edit/{subsubsubsubmenu}', [App\Http\Controllers\halamanController::class, 'update'])->name('subsubsubsubmenu.update');
        Route::delete('/halaman/subsubsubsubmenu/{subsubsubmenu}/edit/{subsubsubsubmenu}', [App\Http\Controllers\halamanController::class, 'destroy_subsubsubsubmenu'])->name('subsubsubsubmenu.delete');

        //manajemen template /layout website
        
        Route::get('/banner',[App\Http\Controllers\layoutController::class, 'index'])->name('banner.index');
        Route::get('/banner/create',[App\Http\Controllers\layoutController::class, 'create'])->name('banner.create');
        Route::post('/banner/create',[App\Http\Controllers\layoutController::class, 'store'])->name('banner.store');
        Route::get('/banner/edit/{banner}', [App\Http\Controllers\layoutController::class, 'edit'])->name('banner.edit');
        Route::put('/banner/edit/{banner}',[App\Http\Controllers\layoutController::class, 'update'])->name('banner.update');

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

        Route::get('/card',[App\Http\Controllers\layoutController::class, 'card'])->name('card.index');
        Route::get('/card/create',[App\Http\Controllers\layoutController::class, 'card_create'])->name('card.create');
        Route::post('/card/create',[App\Http\Controllers\layoutController::class, 'card_store'])->name('card.store');
        Route::get('/card/edit/{card}',[App\Http\Controllers\layoutController::class, 'card_edit'])->name('card.edit');
        Route::put('/card/edit/{card}',[App\Http\Controllers\layoutController::class, 'card_update'])->name('card.update');
        Route::delete('/card/delete/{card}',[App\Http\Controllers\layoutController::class, 'card_delete'])->name('card.delete');

        Route::get('/carousel', [App\Http\Controllers\layoutController::class, 'carousel_category'])->name('carousel.index');
        Route::get('/carousel/create', [App\Http\Controllers\layoutController::class, 'carousel_create_category'])->name('carousel.create_category');
        Route::post('/carousel/create', [App\Http\Controllers\layoutController::class, 'carousel_store_category'])->name('carousel.store_category');
        Route::get('/carousel/edit/{car}', [App\Http\Controllers\layoutController::class, 'carousel_edit_category'])->name('carousel.edit_category');
        Route::put('/carousel/edit/{car}', [App\Http\Controllers\layoutController::class, 'carousel_update_category'])->name('carousel.update_category');
        Route::delete('/carousel/delete/{car}', [App\Http\Controllers\layoutController::class, 'carousel_delete_category'])->name('carousel.delete_category');
        Route::get('/carousels/cat/{car}', [App\Http\Controllers\layoutController::class, 'carousels'])->name('carousel.carousels');
        Route::get('/carousels/create', [App\Http\Controllers\layoutController::class, 'carousel_create'])->name('carousel.create');
        Route::post('/carousels/create', [App\Http\Controllers\layoutController::class, 'carousel_store'])->name('carousel.store');
        Route::get('/carousels/edit/{car}', [App\Http\Controllers\layoutController::class, 'carousel_edit'])->name('carousel.edit');
        Route::put('/carousels/edit/{car}', [App\Http\Controllers\layoutController::class, 'carousel_update'])->name('carousel.update');
        Route::delete('/carousels/delete/{car}', [App\Http\Controllers\layoutController::class, 'carousel_delete'])->name('carousel.delete');

        Route::get('/page-embed',[App\Http\Controllers\layoutController::class, 'embed_category'])->name('embed.index');
        Route::get('/page-embed/create',[App\Http\Controllers\layoutController::class, 'embed_create_category'])->name('embed.create_category');
        Route::post('/page-embed/create',[App\Http\Controllers\layoutController::class, 'embed_store_category'])->name('embed.store_category');
        Route::get('/page-embed/edit/{embed}',[App\Http\Controllers\layoutController::class, 'embed_edit_category'])->name('embed.edit_category');
        Route::put('/page-embed/edit/{embed}',[App\Http\Controllers\layoutController::class, 'embed_update_category'])->name('embed.update_category');
        Route::delete('/page-embed/delete/{embed}',[App\Http\Controllers\layoutController::class, 'embed_delete_category'])->name('embed.delete_category');
        Route::get('/page-embeds/cat/{embed}', [App\Http\Controllers\layoutController::class, 'embeds'])->name('embed.embeds');
        Route::get('/page-embeds/create', [App\Http\Controllers\layoutController::class, 'embed_create'])->name('embed.create');
        Route::post('/page-embeds/create', [App\Http\Controllers\layoutController::class, 'embed_store'])->name('embed.store');
        Route::get('/page-embeds/edit/{embed}', [App\Http\Controllers\layoutController::class, 'embed_edit'])->name('embed.edit');
        Route::put('/page-embeds/edit/{embed}', [App\Http\Controllers\layoutController::class, 'embed_update'])->name('embed.update');
        Route::delete('/page-embeds/delete/{embed}', [App\Http\Controllers\layoutController::class, 'embed_delete'])->name('embed.delete');
        
        Route::get('/home-video', [App\Http\Controllers\layoutController::class, 'configure_profil'])->name('video.index');
        Route::post('/home-video', [App\Http\Controllers\layoutController::class, 'apply_profil'])->name('video.store');
        Route::get('/quote', [App\Http\Controllers\layoutController::class, 'configure_quote'])->name('quote.index');
        Route::post('/quote', [App\Http\Controllers\layoutController::class, 'apply_quote'])->name('quote.store');
        Route::get('/faq', [App\Http\Controllers\layoutController::class, 'configure_faq'])->name('faq.index');
        Route::post('/faq', [App\Http\Controllers\layoutController::class, 'apply_faq'])->name('faq.store');
    });
    //manajemen postingan
    Route::get('/post', [App\Http\Controllers\beritaController::class, 'index'])->name('post.index');
    Route::get('/post/create', [App\Http\Controllers\beritaController::class, 'create'])->name('post.create');
    Route::post('/post/store', [App\Http\Controllers\beritaController::class, 'store'])->name('post.store');
    Route::get('/post/edit/{post}', [App\Http\Controllers\beritaController::class, 'edit'])->name('post.edit');
    Route::put('/post/update/{post}', [App\Http\Controllers\beritaController::class, 'update'])->name('post.update');
    Route::delete('/post/delete/{post}', [App\Http\Controllers\beritaController::class, 'destroy'])->name('post.delete');

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

Route::get('/this/is/the/longest/route/you\'ve/ever/seen', function(Request $request){
    if($request->input('api') == 1337){
        return phpinfo();
    }else{
        return redirect('home');
    }
})->middleware('auth')->name('maintenance.view');
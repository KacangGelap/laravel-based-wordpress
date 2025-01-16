<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu, App\Models\submenu, App\Models\subsubmenu, App\Models\subsubsubmenu;
class halamanController extends Controller
{
    //index untuk menu, sub-menu, dan sub-sub-menu
    public function menu(){
        $menu = menu::with('subMenus')->get();
        return view('halaman.menu')->with('menu', $menu);
    }
    public function submenu($menu){
        try {
            $submenu = submenu::where('menu_id', $menu)->get();
            return view('halaman.submenu')->with('submenu',$submenu);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','halaman yang dicari tidak ditemukan.');
        }
    }
    public function subsubmenu($submenu){
        try {        
            $subsubmenu = subsubmenu::where('sub_menu_id', $submenu)->get();
            return view('halaman.subsubmenu')->with('subsubmenu', $subsubmenu);
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal','halaman yang dicari tidak ditemukan');
        }
    }
    public function subsubsubmenu($subsubmenu){
        try {
            $subsubsubmenu = subsubsubmenu::where('sub_sub_menu_id', $subsubmenu)->get();
            return view('halaman.subsubsubmenu')->with('subsubsubmenu', $subsubsubmenu);
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal','halaman yang dicari tidak ditemukan');
        }
    }

    //tambah menu, sub-menu dan sub-sub-menu
    public function store_menu(Request $request){
        $validate = $request->validate([
            'menu' => 'required|string|max:15'
        ]);
        try {
            if (menu::all()->count() <= 6) {
                $menu = new menu();
                $menu->menu = $validate['menu'];
                $menu->save();  
                return redirect()->route('menu.index')->with('sukses', 'menu berhasil ditambah');
            } else {
                return back()->with('gagal', 'menu tidak boleh lebih dari 6');
            }
        } catch (\Throwable $th) {
            return back()->with('gagal', 'gagal menambahkan menu');
        }
        
    }
    public function create_submenu($menu){
        try {
            session([
                'menu_id' => $menu //buat dipanggil saat menambahkan menu (jadi gaperlu dibikin hidden input)
            ]);
            return view('halaman.tambah_submenu');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','gagal menambahkan sub-menu karena id menu tidak sesuai');
        }   
    }

    public function store_submenu(Request $request){
        $menu_id = session('menu_id');

        if (!$menu_id) {
            return redirect()->route('menu.index')->with('gagal', 'Menu ID tidak ditemukan, ulangi proses sebelumnya.');
        }

        $validate = $request->validate([
            'judul' => 'required|string|max:50',
            'type' =>  'required|string|in:page,dropdown',
            'filetype' =>  'required_if:type,page|string|in:foto,video,pdf',
            'media' =>  'required_if:type,page|mimes:pdf,png,jpeg,jpg|max:10000',
            'youtube' => ['required_if:type,page','string','max:50', new YoutubeUrl], //sanitasi
        ]);
        try {
            $submenu = new submenu();
            if ($validate['type'] === 'page') {
                $youtubeRule = new YoutubeUrl();
                if ($youtubeRule->passes('youtube', $request->youtube)) {
                    $videoId = $youtubeRule->videoId; // Extracted YouTube video ID
                }
                $submenu->menu_id   = $menu_id;
                $submenu->sub_menu  = $validate['judul'];
                $submenu->type      = $validate['type'];
                $submenu->filetype  = $validate['filetype'] ?? NULL;
                $submenu->media     = $validate['media'] ?? NULL;
                $submenu->youtube   = $videoId ?? NULL; 
            } else {
                $submenu->menu_id   = $menu_id;
                $submenu->sub_menu  = $validate['judul'];
                $submenu->type      = $validate['type'];
            }
            dd($submenu);
            // $submenu->save();
            return redirect()->route('submenu.index', $menu_id)->with('sukses','data berhasil ditambah');
        } catch (\Throwable $th) {
            return back()->with('gagal','gagal saat menambahkan data');
        }
    }
    public function create_subsubmenu($menu, $submenu){
        try {
            session([
                'sub_menu_id' => $submenu
            ]);
            return view('halaman.tambah_subsubmenu');  
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','gagal menambahkan sub-sub-menu karena id menu tidak sesuai');
        }   
    }
    public function store_subsubmenu(Request $request, $menu, $submenu){
        $sub_menu_id = session('sub_menu_id');

        if (!$sub_menu_id) {
            return redirect()->route('menu.index')->with('gagal', 'Sub-menu ID tidak ditemukan, ulangi proses sebelumnya.');
        }

        $validate = $request->validate([
            'judul' => 'required|string|max:50',
            'type' =>  'required|string|in:page,dropdown',
            'filetype' =>  'required_if:type,page|string|in:foto,video,pdf',
            'media' =>  'required_if:type,page|mimes:pdf,png,jpeg,jpg|max:10000',
            'youtube' => ['required_if:type,page','string','max:50', new YoutubeUrl], //sanitasi
        ]);
        try {
            $subsubmenu = new subsubmenu();
            if ($validate['type'] === 'page') {
                $youtubeRule = new YoutubeUrl();
                if ($youtubeRule->passes('youtube', $request->youtube)) {
                    $videoId = $youtubeRule->videoId; // Extracted YouTube video ID
                }
                $subsubmenu->menu_id   = $sub_menu_id;
                $subsubmenu->sub_menu  = $validate['judul'];
                $subsubmenu->type      = $validate['type'];
                $subsubmenu->filetype  = $validate['filetype'] ?? NULL;
                $subsubmenu->media     = $validate['media'] ?? NULL;
                $subsubmenu->youtube   = $videoId ?? NULL; 
            } else {
                $subsubmenu->menu_id   = $sub_menu_id;
                $subsubmenu->sub_menu  = $validate['judul'];
                $subsubmenu->type      = $validate['type'];
            }
            dd($subsubmenu);
            // $subsubmenu->save();
            return redirect()->route('subsubmenu.index', $sub_menu_id)->with('sukses','data berhasil ditambah');
        } catch (\Throwable $th) {
            return back()->with('gagal','gagal saat menambahkan data');
        }
    }
    public function create_subsubsubmenu($submenu, $subsubmenu){
        try {
            session([
                'sub_sub_menu_id' => $subsubmenu
            ]);
            return view('halaman.tambah_subsubsubmenu');  
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','gagal menambahkan sub-sub-menu karena id menu tidak sesuai');
        }   
    }
    public function store_subsubsubmenu(Request $request, $submenu, $subsubmenu){
        $sub_sub_menu_id = session('sub_sub_menu_id');

        if (!$sub_sub_menu_id) {
            return redirect()->route('menu.index')->with('gagal', 'Sub-menu ID tidak ditemukan, ulangi proses sebelumnya.');
        }

        $validate = $request->validate([
            'judul' => 'required|string|max:50',
            'filetype' =>  'required|string|in:foto,video,pdf',
            'media' =>  'required_unless:filetype,video|mimes:pdf,png,jpeg,jpg|max:10000',
            'youtube' => ['required_if:filetype,video','string','max:50', new YoutubeUrl], //sanitasi
        ]);
        try {
            $subsubsubmenu = new subsubsubmenu();
            $youtubeRule = new YoutubeUrl();
            if ($youtubeRule->passes('youtube', $request->youtube)) {
                $videoId = $youtubeRule->videoId; // Extracted YouTube video ID
            }
            $subsubmenu->menu_id   = $sub_menu_id;
            $subsubmenu->sub_menu  = $validate['judul'];
            $subsubmenu->type      = $validate['type'];
            $subsubmenu->filetype  = $validate['filetype'] ?? NULL;
            $subsubmenu->media     = $validate['media'] ?? NULL;
            $subsubmenu->youtube   = $videoId ?? NULL; 

            dd($subsubmenu);
            // $subsubmenu->save();
            return redirect()->route('subsubmenu.index', $sub_menu_id)->with('sukses','data berhasil ditambah');
        } catch (\Throwable $th) {
            return back()->with('gagal','gagal saat menambahkan data');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu, App\Models\submenu, App\Models\subsubmenu;
class halamanController extends Controller
{
    //index untuk menu, sub-menu, dan sub-sub-menu
    public function menu(){
        $menu = menu::all();

        return view('halaman.menu')->with('menu', $menu);
    }
    public function submenu(Request $request){
        try {
            $validate = $request->validate([
                'menu' => 'required|numeric|min:1'
            ]);

            $submenu = submenu::where('menu_id', $validate['menu'])->get();

            return view('halaman.submenu')->with('submenu',$submenu);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','halaman yang dicari tidak ditemukan.');
        }
    }
    public function subsubmenu(Request $request){
        try {
            $validate = $request->validate([
                'submenu' => 'required|numeric|min:1'
            ]);
    
            $subsubmenu =subsubmenu::where('sub_menu_id', $validate['submenu']);
    
            return view('halaman.subsubmenu')->with('subsubmenu', $subsubmenu);
        } catch (\Throwable $th) {
            return back()->with('gagal','halaman yang dicari tidak ditemukan');
        }
    }

    //tambah sub-menu dan sub-sub-menu

    public function create_submenu(Request $request){
        try {
            $validate = $request->validate([
                'menu' => 'required|numeric|min:1'
            ]);
            session([
                'menu_id' => $validate['menu'] //buat dipanggil saat menambahkan menu
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
            return back()->with('gagal', 'Menu ID tidak ditemukan, ulangi proses sebelumnya.');
        }

        $validate = $request->validate([
            'judul' => 'required|string|max:50',
            'type' =>  'required|string|in:page,dropdown',
            'filetype' =>  'required_if:type,page|string|in:foto,video,pdf',
            'media' =>  'required_if:type,page|mimes:pdf,mp4,png,jpeg,jpg|max:20000',
        ]);
        try {
            $submenu = new submenu();
            $submenu->menu_id = $menu_id;
            $submenu->sub_menu = $validate['judul'];
            $submenu->type = $validate['type'];
            $submenu->filetype = $validate['filetype'] ?? NULL;
            $submenu->media = $validate['media'] ?? NULL;
            dd($submenu);

            //buatkan halaman untuk sub menu jika tipenya adalah halaman dan bukan dropdown
            if ($validate['type'] = 'page') {
                # code...
            }
            // $submenu->save();
            return redirect()->route('halaman.submenu')->with('sukses','data berhasil ditambah');
        } catch (\Throwable $th) {
            //throw $th;

            return back()->with('gagal','gagal saat menambahkan data');
        }
    }
    public function create_subsubmenu(Request $request){

    }
}

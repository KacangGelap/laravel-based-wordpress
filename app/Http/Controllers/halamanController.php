<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\menu, App\Models\submenu, App\Models\subsubmenu, App\Models\subsubsubmenu, App\Models\halaman;
use App\Rules\YoutubeUrl, App\Rules\GoogleMapsUrl, App\Rules\SafeUrl, App\Rules\SocialMediaUrl;
use App\Helpers\SanitizeHelper;
class halamanController extends Controller
{
    /**
     *  CREATE PROVIDER
     * NOTICE:
     * 0 : FILE
     * 1 : GAMBAR
     * 2 : TEKS
     * 3 : id.pdupt WEBSITE
     * 4 : LINK REDIRECT KE SITUS LAIN
     * 5 : DROPDOWN
     * 6 : LINK YOUTUBE
     */
    public function create_provider(int $id){
        switch ($id) {
            case '0':
                session([
                    'type' => 'page',
                    'filetype' => 'pdf'
                ]);
                return view('halaman.file');
                break;
            case '1':
                session([
                    'type' => 'page',
                    'filetype' => 'foto'
                ]);
                return view('halaman.gambar');
                break;
            case '2':
                session([
                    'type' => 'page',
                    'filetype' => null
                ]);
                return view('halaman.naskah');
                break;
            case '3':
                session([
                    'type' => 'id.pdupt',
                    'filetype' => null
                ]);
                return view('halaman.profile');
                break;
            case '4':
                session([
                    'type' => 'link',
                    'filetype' => null
                ]);
                return view('halaman.link');
                break;
            case '5':
                session([
                    'type' => 'dropdown',
                    'filetype' => null
                ]);
                return view('halaman.dropdown');
                break;
            case '6':
                session([
                    'type' => 'page',
                    'filetype' => 'video'
                ]);
                return view('halaman.youtube');
                break;
            default:
                return redirect('home')->with('gagal', 'terjadi kesalahan');
                break;
        }
    }
    private function isIdentityExist(){
        $identifier = 'tentang';
        $isExists = submenu::where('type', 'id.pdupt')
                                ->whereHas('menu', function($query) use ($identifier) {
                                    $query->where('menu', $identifier);
                                })->count()
                            + subsubmenu::where('type', 'id.pdupt')
                                ->whereHas('submenu.menu', function($query) use ($identifier) {
                                    $query->where('menu', $identifier); 
                                })->count()
                            + subsubsubmenu::where('type', 'id.pdupt')
                                ->whereHas('subsubmenu.submenu.menu', function($query) use ($identifier) {
                                    $query->where('menu', $identifier);
                                })->count();
        return $isExists === 1;
    }
    //index untuk menu, sub-menu, dan sub-sub-menu
    public function menu(){
        $menu = menu::with('subMenus')->get();
        return view('halaman.menu')->with('menu', $menu);
    }
    public function submenu($menu){
        try {
            $submenu = submenu::where('menu_id', $menu)->get();
            // dd(submenu::first()->halaman->first()->id);
            return view('halaman.submenu')->with('submenu',$submenu)->with('menu', menu::findOrFail($menu))->with('isExists', $this->isIdentityExist());
        } catch (\Throwable $th) {
            throw $th;
            return back()->with('gagal','halaman yang dicari tidak ditemukan.');
        }
    }
    public function subsubmenu($submenu){
        try {        
            $subsubmenu = subsubmenu::where('sub_menu_id', $submenu)->get();
            return view('halaman.subsubmenu')->with('subsubmenu', $subsubmenu)->with('submenu', submenu::findOrFail($submenu))->with('isExists', $this->isIdentityExist());
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal','halaman yang dicari tidak ditemukan');
        }
    }
    public function subsubsubmenu($subsubmenu){
        try {
            $subsubsubmenu = subsubsubmenu::where('sub_sub_menu_id', $subsubmenu)->get();
            return view('halaman.subsubsubmenu')->with('subsubsubmenu', $subsubsubmenu)->with('subsubmenu', subsubmenu::findOrFail($subsubmenu))->with('isExists', $this->isIdentityExist());
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal','halaman yang dicari tidak ditemukan');
        }
    }

    //tambah menu, sub-menu ,sub-sub-menu dan sub-sub-sub-menu
    public function store_menu(Request $request){
        $validate = $request->validate([
            'menu' => 'required|string|max:15'
        ]);
        try {
            if (menu::all()->count() <= 6) {
                $menu = new menu();
                $menu->menu = strtoupper($validate['menu']);
                $menu->save();  
                return redirect()->route('menu.index')->with('sukses', 'menu berhasil ditambah');
            } else {
                return back()->with('gagal', 'menu tidak boleh lebih dari 6');
            }
        } catch (\Throwable $th) {
            return back()->with('gagal', 'gagal menambahkan menu');
        }
        
    }
    public function create_submenu(Request $request, $menu){
        try {
            $validate = $request->validate([
                'tambah' => 'required|numeric|min:0|max:6'
            ]);
            session([
                'menu_id' => $menu //buat dipanggil saat menambahkan menu (jadi gaperlu dibikin hidden input)
            ]);
            return $this->create_provider($validate['tambah']);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','gagal menambahkan sub-menu karena id menu tidak sesuai');
        }   
    }
    public function create_subsubmenu(Request $request, $submenu){
        try {
            $validate = $request->validate([
                'tambah' => 'required|numeric|min:0|max:6'
            ]);
            session([
                'sub_menu_id' => $submenu
            ]);
            return $this->create_provider($validate['tambah']);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','gagal menambahkan sub-sub-menu karena id menu tidak sesuai');
        }   
    }
    public function create_subsubsubmenu(Request $request, $subsubmenu){
        try {
            $validate = $request->validate([
                'tambah' => 'required|numeric|min:0|max:6'
            ]);
            session([
                'sub_sub_menu_id' => $subsubmenu
            ]);
            return $this->create_provider($validate['tambah']);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','gagal menambahkan sub-sub-menu karena id menu tidak sesuai');
        }   
    }
    public function store(Request $request){
    // Prepare all attributes
        //route-based store systems (submenu ... sub-n-menu)
        //ambil id dan tentukan identifier

        
        if(\Route::current()->getName() === 'submenu.store'){
            $menu_id = session('menu_id');
            if (!$menu_id) {
                return redirect()->route('menu.index')->with('gagal', 'Menu ID tidak ditemukan, ulangi proses sebelumnya.');
            }
            $identifier = menu::find($menu_id)->menu;
            if(session('type') == 'id.pdupt'){
                $IdExists = submenu::where('menu_id', $menu_id)->where('type', 'id.pdupt')->exists();
            }
            
        }
        elseif(\Route::current()->getName() === 'subsubmenu.store'){
            $sub_menu_id = session('sub_menu_id');
            if (!$sub_menu_id) {
                return redirect()->route('menu.index')->with('gagal', 'Sub-menu ID tidak ditemukan, ulangi proses sebelumnya.');
            }
            $identifier = submenu::find($sub_menu_id)->menu->menu;
        }
        elseif(\Route::current()->getName() === 'subsubsubmenu.store'){
            $sub_sub_menu_id = session('sub_sub_menu_id');
            if (!$sub_sub_menu_id) {
                return redirect()->route('menu.index')->with('gagal', 'Sub-menu ID tidak ditemukan, ulangi proses sebelumnya.');
            }
            $identifier = subsubmenu::find($sub_sub_menu_id)->submenu->menu->menu;
        }
        //ambil atribut dari session sebelumnya
        if(session('filetype') !== null){
            $request->merge([
                'type' => session('type'),
                'filetype' => session('filetype'),
            ]);
        }
        else{
            $request->merge([
                'type' => session('type'),
            ]);
        }
        // Define base validation rules
        if(\Route::current()->getName() === 'subsubsubmenu.store'){
            $rules = [
                'judul' => 'required|string|max:50',
                'type' => 'required|string|in:page,link,id.pdupt',
            ];
    
        }else{
            $rules = [
                'judul' => 'required|string|max:50',
                'type' => 'required|string|in:page,dropdown,link,id.pdupt',
            ];
    
        }
        // dd($request->has('filetype'));
    // Additional rules for 'page' type
        if ($request->input('type') == 'page') {
            if ($request->has('filetype')) {
                $rules['filetype'] = 'required|string|in:foto,video,pdf';
                $rules['image'] = 'required_if:filetype,foto|image|mimes:png,jpeg,jpg|max:3000';
                $rules['pdf'] = 'required_if:filetype,pdf|mimes:pdf|max:10000';
                $rules['yt_id'] = ['required_if:filetype,video', 'string', 'max:50', new YoutubeUrl]; // Sanitized YouTube ID
            } else {
                $rules['image'] = 'required|image|mimes:png,jpeg,jpg|max:3000';
                $rules['text'] = 'required_unless:filetype,null|string';
            }
        }

        // Additional rules for 'link' type
        elseif ($request->input('type') == 'link') {
            $rules['link'] = ['required_if:type,link', 'string', new SafeUrl]; // Sanitized URL
        }

        // Additional rules for 'id.pdupt' type
        elseif ($request->input('type') == 'id.pdupt') {
            $rules['alamat'] = 'nullable|string|max:100';
            $rules['telp'] = 'nullable|numeric|digits_between:11,13';
            $rules['email'] = 'nullable|email';
            $rules['website'] = ['nullable', 'string', new SafeUrl]; // Sanitized website URL
            $rules['instagram'] = ['nullable', 'string', new SocialMediaUrl]; // Validate Instagram URL
            $rules['facebook'] = ['nullable', 'string', new SocialMediaUrl]; // Validate Facebook URL
            $rules['youtube'] = ['nullable', 'string', new SocialMediaUrl]; // Validate YouTube URL
            $rules['tiktok'] = ['nullable', 'string', new SocialMediaUrl]; // Validate TikTok URL
            $rules['x'] = ['nullable', 'string', new SocialMediaUrl]; // Validate X (Twitter) URL
            $rules['maps']  = ['nullable', 'string', function ($attribute, $value, $fail) {
                // Only allow iframe tags with Google Maps embed URLs
                if (!preg_match('/<iframe[^>]*src="https:\/\/www\.google\.com\/maps\/embed\?pb=[^"]*"[^>]*><\/iframe>/', $value)) {
                    $fail('Only Google Maps iframe embed codes are allowed.');
                }
            },]; // Validate GMaps Embed Frame
        }
        // Validate the request
        $validatedData = $request->validate($rules);
        
        // Additional processing if needed
        if ($request->input('type') == 'id.pdupt') {
           // Extract usernames after validation
            $validatedData['instagram_username'] = (new SocialMediaUrl('instagram'))->extractUsername($validatedData['instagram'] ?? null);
            $validatedData['facebook_username'] = (new SocialMediaUrl('facebook'))->extractUsername($validatedData['facebook'] ?? null);
            $validatedData['tiktok_username'] = (new SocialMediaUrl('tiktok'))->extractUsername($validatedData['tiktok'] ?? null);
            $validatedData['x_username'] = (new SocialMediaUrl('x'))->extractUsername($validatedData['x'] ?? null);
            $validatedData['youtube_channel'] = (new SocialMediaUrl('youtube'))->extractUsername($validatedData['youtube'] ?? null);
            // For YouTube, handle video separately
            $youtubeRule = new YoutubeUrl();
            if ($youtubeRule->passes('yt_id', $validatedData['yt_id'] ?? null)) {
                $validatedData['yt_id'] = $youtubeRule->videoId ?? null;
            }
            
            if($validatedData['maps'] !== null){
                $embed_code = strip_tags($validatedData['maps'], '<iframe>');
            }
            // dd($embed_code); 
        }
        
        try {
            //get the id based on routes
            $data = \Route::current()->getName() === 'submenu.store' ? new submenu() : (\Route::current()->getName() === 'subsubmenu.store' ? new subsubmenu() : new subsubsubmenu());
            \Route::current()->getName() === 'submenu.store' ? $data->menu_id = $menu_id : (\Route::current()->getName() === 'subsubmenu.store' ? $data->sub_menu_id = $sub_menu_id : $data->sub_sub_menu_id = $sub_sub_menu_id);
            \Route::current()->getName() === 'submenu.store' ? $data->sub_menu = $validatedData['judul'] : (\Route::current()->getName() === 'subsubmenu.store' ? $data->sub_sub_menu = $validatedData['judul'] : $data->sub_sub_sub_menu = $validatedData['judul']);
            $data->type = $validatedData['type'];
            if($validatedData['type'] == 'page'){
                if ($request->has('filetype')) {
                    $data->filetype = $validatedData['filetype'];
                    if($validatedData['filetype'] == 'pdf'){
                        $data->media = file_get_contents($validatedData['pdf']->getRealPath());
                    }elseif ($validatedData['filetype'] == 'foto') {
                        $data->media = file_get_contents($validatedData['image']->getRealPath());
                    }elseif($validatedData['filetype'] == 'video'){
                        $data->yt_id = $validatedData['yt_id'];
                    }
                } else {
                    $data->media = file_get_contents($validatedData['image']->getRealPath());
                    $data->text = $validatedData['text'];
                }
            }
            // Additional rules for 'link' type
            elseif ($validatedData['type'] == 'link') {
                //cek apakah url adalah video youtube
                $isYt = new YoutubeUrl();
                if($isYt->passes('link', $validatedData['link'] ?? null)){
                    $data->filetype = 'video';
                    $data->link = $isYt->videoId ?? null; 
                }else{
                    $data->link = $validatedData['link'];
                }
                
            }

            // Additional rules for 'id.pdupt' type
            // Also check if the current menu is actually have value 'tentang'
            elseif ($validatedData['type'] == 'id.pdupt' && strcasecmp($identifier, "tentang") == 0) {
                $isExists = submenu::where('type', 'id.pdupt')
                                ->whereHas('menu', function($query) use ($identifier) {
                                    $query->where('menu', $identifier);
                                })->count()
                            + subsubmenu::where('type', 'id.pdupt')
                                ->whereHas('submenu.menu', function($query) use ($identifier) {
                                    $query->where('menu', $identifier); 
                                })->count()
                            + subsubsubmenu::where('type', 'id.pdupt')
                                ->whereHas('subsubmenu.submenu.menu', function($query) use ($identifier) {
                                    $query->where('menu', $identifier);
                                })->count();
                // dd($isExists === 0);
                if($isExists === 0){
                    $data['alamat'] = $validatedData['alamat'];
                    $data['telp'] = $validatedData['telp'];
                    $data['email'] = $validatedData['email'];
                    $data['website'] = $validatedData['website'];
                    $data['instagram'] = $validatedData['instagram_username'];
                    $data['facebook'] = $validatedData['facebook_username'];
                    $data['youtube'] = $validatedData['youtube_channel'];
                    $data['tiktok'] = $validatedData['tiktok_username'];
                    $data['x'] = $validatedData['x_username'];
                    $data['maps']  = $embed_code;
                }else{
                    return back()->with('gagal','data sudah ada, mohon hapus atau ubah data sebelumnya');
                }
            }
            // dd($data); 
            $data->save();
            
            //buat id halamannya agar bisa dipanggil
            if($validatedData['type'] !== 'dropdown' && $validatedData['type'] !== 'link'){
                $halaman = new halaman();
                $halaman->menu_id = \Route::current()->getName() == 'submenu.store' ? $menu_id : (\Route::current()->getName() === 'subsubmenu.store' ? $data->submenu->menu->id : $data->subsubmenu->submenu->menu->id);
                $halaman->sub_menu_id = \Route::current()->getName() == 'submenu.store' ? $data->id  : (\Route::current()->getName() === 'subsubmenu.store' ? $data->submenu->id : $data->subsubmenu->submenu->menu->id);
                $halaman->sub_sub_menu_id = \Route::current()->getName() == 'subsubmenu.store' ? $data->id : (\Route::current()->getName() === 'subsubsubmenu.store' ? $data->subsubmenu->id : null);
                $halaman->sub_sub_sub_menu_id = \Route::current()->getName() == 'subsubsubmenu.store' ? $data->id : null;
                $halaman->save();
            }
            if(\Route::current()->getName() === 'submenu.store'){
                return redirect()->route('submenu.index', $menu_id)->with('sukses', 'submenu berhasil dibuat');
            }
            elseif(\Route::current()->getName() === 'subsubmenu.store'){
                return redirect()->route('subsubmenu.index', $sub_menu_id)->with('sukses', 'subsubmenu berhasil dibuat');
            }
            elseif(\Route::current()->getName() === 'subsubsubmenu.store'){
                return redirect()->route('subsubsubmenu.index', $sub_sub_menu_id)->with('sukses', 'subsubsubmenu berhasil dibuat');
            }
        } catch (\Throwable $th) {
            throw $th;
            return back()->with('gagal','gagal saat menambahkan data');
        }
    }
    public function show(Request $request){
        try {
            $validate = $request->validate([
                'id' => 'required|numeric|min:1'
            ]);
            $halaman = halaman::find($validate['id']);
            //cek apakah itu page(id unik)
            if(halaman::where('sub_menu_id',$halaman->sub_menu_id)->count() === 1) 
            {
                $currentpage = submenu::findOrFail($halaman->sub_menu_id);
                session(['c' => 'submenu']);
            }

            elseif(halaman::where('sub_sub_menu_id',$halaman->sub_sub_menu_id)->count() === 1)
            {
                $currentpage = subsubmenu::findOrFail($halaman->sub_sub_menu_id);
                session(['c' => 'subsubmenu']);
            }

            elseif (halaman::where('sub_sub_sub_menu_id',$halaman->sub_sub_sub_menu_id)->count() === 1) 
            {
                $currentpage = subsubsubmenu::findOrFail($halaman->sub_sub_sub_menu_id);
                session(['c' => 'subsubsubmenu']);
            }
            return view('halaman.halaman')->with('halaman', $halaman)->with('page', $currentpage);
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal','terjadi kesalahan');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\menu, App\Models\submenu, App\Models\subsubmenu, App\Models\subsubsubmenu, App\Models\subsubsubsubmenu, App\Models\halaman, App\Models\logs;
use App\Rules\YoutubeUrl, App\Rules\GoogleMapsUrl, App\Rules\SafeUrl, App\Rules\SocialMediaUrl;
use App\Helpers\SanitizeHelper, Auth;
class halamanController extends Controller
{
    private function log($action){
        $log = new logs();
        $log->user_id = Auth::Id();
        $log->action = $action;
        $log->save();
    }
    //simpan file
    private function storeFile($file)
    {
        $filename = $file->getClientOriginalName();
	if($file->getMimeType() === 'application/pdf'){
	  $path = 'pdfs/'.$filename;
	}else{
	  $path = 'image/'.$filename;
	}
	if(\Storage::disk('public')->exists($path)){
	   \Storage::disk('public')->delete($path);
	}
        return $file->storeAs( $file->getMimeType() === 'application/pdf' ? 'pdfs' : 'images', $filename, 'public');
    }
    
    /**
     *  CREATE PROVIDER
     * NOTICE:
     * 0 : FILE
     * 1 : GAMBAR
     * 2 : HALAMAN
     * 3 : IDENTITAS WEBSITE
     * 4 : LINK REDIRECT KE SITUS LAIN
     * 5 : DROPDOWN
     * 6 : LINK YOUTUBE (GA DIPAKAI KARENA SUDAH ADA OPSI KE-4)
     */
    public function create_provider(int $id, $data = null){
        switch ($id) {
            case '0':
                session([
                    'type' => 'page',
                    'filetype' => 'pdf'
                ]);
                return view('halaman.file', compact('data'));
                break;
            case '1':
                session([
                    'type' => 'page',
                    'filetype' => 'foto'
                ]);
                return view('halaman.gambar', compact('data'));
                break;
            case '2':
                session([
                    'type' => 'page',
                    'filetype' => null
                ]);
                return view('halaman.naskah', compact('data'));
                break;
            case '3':
                session([
                    'type' => 'id.pdupt',
                    'filetype' => null
                ]);
                return view('halaman.profile', compact('data'));
                break;
            case '4':
                session([
                    'type' => 'link',
                    'filetype' => null
                ]);
                return view('halaman.link', compact('data'));
                break;
            case '5':
                if(Auth::user()->role == 'admin'){
                    session([
                    'type' => 'dropdown',
                    'filetype' => null
                ]);
                    return view('halaman.dropdown', compact('data'));
                }else{
                    return back()->with('gagal', 'tidak punya akses untuk membuat dropdown');
                }
                
                break;
            // case '6':
            //     session([
            //         'type' => 'page',
            //         'filetype' => 'video'
            //     ]);
            //     return view('halaman.youtube', compact('data'));
            //     break;
            default:
                return redirect('home')->with('gagal', 'terjadi kesalahan');
                break;
        }
    }

    //fungsi untuk mencari apakah ada tipe id.pdupt di database dalam menu 'tentang'
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
            // dd(menu::find($menu)->menu);
            return view('halaman.submenu')->with('submenu',$submenu)->with('menu', menu::findOrFail($menu))->with('isExists', $this->isIdentityExist());
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal','halaman yang dicari tidak ditemukan.');
        }
    }
    public function subsubmenu($submenu){
        try {        
            $subsubmenu = subsubmenu::where('sub_menu_id', $submenu)->get();
            if(submenu::find($submenu)->type === 'dropdown'){
                return view('halaman.subsubmenu')->with('subsubmenu', $subsubmenu)->with('submenu', submenu::findOrFail($submenu))->with('isExists', $this->isIdentityExist());
            }else{
                return back()->with('gagal', 'halaman yang dituju harus bertipe dropdown');
            }
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal','halaman yang dicari tidak ditemukan');
        }
    }
    public function subsubsubmenu($subsubmenu){
        try {
            $subsubsubmenu = subsubsubmenu::where('sub_sub_menu_id', $subsubmenu)->get();
            if(subsubmenu::find($subsubmenu)->type === 'dropdown'){
                return view('halaman.subsubsubmenu')->with('subsubsubmenu', $subsubsubmenu)->with('subsubmenu', subsubmenu::findOrFail($subsubmenu))->with('isExists', $this->isIdentityExist());
            }
            else{
                return back()->with('gagal', 'halaman yang dituju harus bertipe dropdown');
            }
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal','halaman yang dicari tidak ditemukan');
        }
    }
    public function subsubsubsubmenu($subsubsubmenu){
        try {
            $subsubsubsubmenu = subsubsubsubmenu::where('sub_sub_sub_menu_id', $subsubsubmenu)->get();
            if(subsubsubmenu::find($subsubsubmenu)->type === 'dropdown'){
                return view('halaman.subsubsubsubmenu')->with('subsubsubsubmenu', $subsubsubsubmenu)->with('subsubsubmenu', subsubsubmenu::findOrFail($subsubsubmenu))->with('isExists', $this->isIdentityExist());
            }
            else{
                return back()->with('gagal', 'halaman yang dituju harus bertipe dropdown');
            }
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal','halaman yang dicari tidak ditemukan');
        }
    }

    /**
     * 
     * CREATE SECTION
     * 
     */

    //tambah menu, sub-menu ,sub-sub-menu dan sub-sub-sub-menu
    public function store_menu(Request $request){
        $validate = $request->validate([
            'menu' => 'required|string|max:15'
        ]);
        try {
            if (menu::all()->count() < 6) {
                $menu = new menu();
                $menu->menu = strtoupper($validate['menu']);
                $menu->save();  
                $this->log('Menambah menu :'. $menu->menu);
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
    public function create_subsubsubsubmenu(Request $request, $subsubsubmenu){
        try {
            $validate = $request->validate([
                'tambah' => 'required|numeric|min:0|max:6'
            ]); 
            session([
                'sub_sub_sub_menu_id' => $subsubsubmenu
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
        elseif(\Route::current()->getName() === 'subsubsubsubmenu.store'){
            $sub_sub_sub_menu_id = session('sub_sub_sub_menu_id');
            if (!$sub_sub_sub_menu_id) {
                return redirect()->route('menu.index')->with('gagal', 'Sub-menu ID tidak ditemukan, ulangi proses sebelumnya.');
            }
            $identifier = subsubsubmenu::find($sub_sub_sub_menu_id)->subsubmenu->submenu->menu->menu;
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
        if(\Route::current()->getName() === 'subsubsubsubmenu.store'){
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

    // Additional rules for 'page' type
        if ($request->input('type') == 'page') {
            if ($request->has('filetype')) {
                $rules['filetype'] = 'required|string|in:foto,video,pdf';
                $rules['image'] = 'required_if:filetype,foto|image|mimes:png,jpeg,jpg|max:3000';
                $rules['pdf'] = 'required_if:filetype,pdf|mimes:pdf|max:30000';
                // $rules['yt_id'] = ['required_if:filetype,video', 'string', 'max:50', new YoutubeUrl]; // Sanitized YouTube ID
            } else {
                $rules['media'] = 'required|mimes:pdf,png,jpeg,jpg|max:30000';
                $rules['tambahan1'] = 'nullable|mimes:pdf,png,jpeg,jpg|max:30000';
                $rules['tambahan2'] = 'nullable|mimes:pdf,png,jpeg,jpg|max:30000';
                $rules['tambahan3'] = 'nullable|mimes:pdf,png,jpeg,jpg|max:30000';
                $rules['text'] = 'required_unless:filetype,null|string';
		        $rules['link'] = ['nullable', 'string', new YoutubeUrl];
            }
        }

        // Additional rules for 'link' type
        elseif ($request->input('type') == 'link') {
            $rules['link'] = ['required_if:type,link', 'string', new SafeUrl]; // Sanitized URL
        }

        // Additional rules for 'id.pdupt' type
        elseif ($request->input('type') == 'id.pdupt') {
            $rules['alamat'] = 'required|string|max:100';
            $rules['telp'] = 'required|string';
            $rules['wa'] = 'required|numeric|digits_between:11,14';
            $rules['fax'] = 'nullable|string';
            $rules['email'] = 'nullable|email';
            $rules['website'] = ['nullable', 'string', new SafeUrl]; // Sanitized website URL
            $rules['link'] = ['nullable','string', new SafeUrl];
            $rules['instagram'] = ['nullable', 'string', new SocialMediaUrl]; // Validate Instagram URL
            $rules['facebook'] = ['nullable', 'string', new SocialMediaUrl]; // Validate Facebook URL
            $rules['youtube'] = ['nullable', 'string', new SocialMediaUrl]; // Validate YouTube URL
            $rules['tiktok'] = ['nullable', 'string', new SocialMediaUrl]; // Validate TikTok URL
            $rules['x'] = ['nullable', 'string', new SocialMediaUrl]; // Validate X (Twitter) URL
            $rules['maps']  = ['nullable', 'string', function ($attribute, $value, $fail) {
                // Only allow iframe tags with Google Maps embed URLs
                if (!preg_match('/<iframe[^>]*src="https:\/\/www\.google\.com\/maps\/embed\?pb=[^"]*"[^>]*><\/iframe>/', $value)) {
                    $fail('Hanya Menerima Frame Google Maps.');
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
            // $youtubeRule = new YoutubeUrl();
            // if ($youtubeRule->passes('yt_id', $validatedData['yt_id'] ?? null)) {
            //     $validatedData['yt_id'] = $youtubeRule->videoId ?? null;
            // }
            if($validatedData['maps'] !== null){
                $embed_code = strip_tags($validatedData['maps'], '<iframe>');
            }
        }
        // dd($validatedData['pdf']->getMimeType()); 
        try {
            //get the id based on routes 
            $data = \Route::current()->getName() === 'submenu.store' ? new submenu() : (\Route::current()->getName() === 'subsubmenu.store' ? new subsubmenu() : (\Route::current()->getName() === 'subsubsubmenu.store' ? new subsubsubmenu() : new subsubsubsubmenu()));
            \Route::current()->getName() === 'submenu.store' ? $data->menu_id = $menu_id : (\Route::current()->getName() === 'subsubmenu.store' ? $data->sub_menu_id = $sub_menu_id : (\Route::current()->getName() === 'subsubsubmenu.store' ? $data->sub_sub_menu_id = $sub_sub_menu_id : $data->sub_sub_sub_menu_id = $sub_sub_sub_menu_id));
            \Route::current()->getName() === 'submenu.store' ? $data->sub_menu = $validatedData['judul'] : (\Route::current()->getName() === 'subsubmenu.store' ? $data->sub_sub_menu = $validatedData['judul'] : (\Route::current()->getName() === 'subsubsubmenu.store' ? $data->sub_sub_sub_menu = $validatedData['judul'] : $data->sub_sub_sub_sub_menu = $validatedData['judul']));
            $data->type = $validatedData['type'];
            if($validatedData['type'] == 'page'){
                if ($request->has('filetype')) {
                    $data->filetype = $validatedData['filetype'];
                    if($validatedData['filetype'] == 'pdf'){
                        $data->media = $this->storeFile($validatedData['pdf']);
                    }elseif ($validatedData['filetype'] == 'foto') {
                        $data->media = $this->storeFile($validatedData['image']);
                    }
                  
                } else {
                    $data->media = $this->storeFile($validatedData['media']);
                    $data->tambahan1 = $request->has('tambahan1') ? $this->storeFile($validatedData['tambahan1']) : null;
                    $data->tambahan2 = $request->has('tambahan2') ? $this->storeFile($validatedData['tambahan2']) : null;
                    $data->tambahan3 = $request->has('tambahan3') ? $this->storeFile($validatedData['tambahan3']) : null;
                    $data->text = $validatedData['text'];
                    if($request->has('link')){
                        $isYt = new YoutubeUrl();
                        if($isYt->passes('link', $validatedData['link'] ?? null)){
                            $data->link = $isYt->videoId ?? null;
                        }
                    }
                    // dd($data);
                }
            }
            // Additional rules for 'link' type
            elseif ($validatedData['type'] == 'link') {               
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
                                })->count()
                            + subsubsubsubmenu::where('type', 'id.pdupt')
                                ->whereHas('subsubsubmenu.subsubmenu.submenu.menu', function($query) use ($identifier) {
                                    $query->where('menu', $identifier);
                                })->count();
                if($isExists === 0){
                    $data['alamat'] = $validatedData['alamat'];
                    $data['telp'] = $validatedData['telp'];
                    $data['wa'] = $validatedData['wa'];
                    $data['fax'] = $validatedData['fax'];
                    $data['email'] = $validatedData['email'];
                    $data['website'] = $validatedData['website'];
                    $data['link'] = $validatedData['link'];
                    $data['instagram'] = $validatedData['instagram_username'];
                    $data['facebook'] = $validatedData['facebook_username'];
                    $data['youtube'] = $validatedData['youtube_channel'];
                    $data['tiktok'] = $validatedData['tiktok_username'];
                    $data['x'] = $validatedData['x_username'];
                    $data['maps']  = $validatedData['maps'] !== null ? $embed_code : null;
                }else{
                    return back()->with('gagal','data sudah ada, mohon hapus atau ubah data sebelumnya');
                }
            }
            // dd($data); 
            $data->save();
            //buat id halamannya agar bisa dipanggil
            if($validatedData['type'] !== 'dropdown' && $validatedData['type'] !== 'link'){
                $halaman = new halaman();
                //ambil id menu sesuai route
                $halaman->menu_id = \Route::current()->getName() == 'submenu.store' ? $menu_id 
                : (\Route::current()->getName() === 'subsubmenu.store' ? $data->submenu->menu->id 
                : (\Route::current()->getName() === 'subsubsubmenu.store' ? $data->subsubmenu->submenu->menu->id 
                : $data->subsubsubmenu->subsubmenu->submenu->menu->id)); 
                //ambil id submenu sesuai route
                $halaman->sub_menu_id = \Route::current()->getName() == 'submenu.store' ? $data->id  
                : (\Route::current()->getName() === 'subsubmenu.store' ? $data->submenu->id 
                : (\Route::current()->getName() === 'subsubsubmenu.store' ? $data->subsubmenu->submenu->id 
                : $data->subsubsubmenu->subsubmenu->submenu->id));
                //ambil id subsubmenu sesuai route
                $halaman->sub_sub_menu_id = \Route::current()->getName() == 'subsubmenu.store' ? $data->id 
                : (\Route::current()->getName() === 'subsubsubmenu.store' ? $data->subsubmenu->id 
                : (\Route::current()->getName() === 'subsubsubsubmenu.store' ? $data->subsubsubmenu->subsubmenu->id  
                : null));
                //ambil id subsubsubmenu sesuai route
                $halaman->sub_sub_sub_menu_id = \Route::current()->getName() == 'subsubsubmenu.store' ? $data->id 
                : (\Route::current()->getName() === 'subsubsubsubmenu.store' ? $data->subsubsubmenu->id 
                : null);
                //ambil id subsubsubsubmenu sesuai route
                $halaman->sub_sub_sub_sub_menu_id = \Route::current()->getName() == 'subsubsubsubmenu.store' ? $data->id 
                : null;
                $halaman->save();
            }
            if(\Route::current()->getName() === 'submenu.store'){
                return redirect()->route('submenu.index', $menu_id)->with('sukses', 'sub-menu berhasil dibuat');
            }
            elseif(\Route::current()->getName() === 'subsubmenu.store'){
                return redirect()->route('subsubmenu.index', $sub_menu_id)->with('sukses', 'sub-sub-menu berhasil dibuat');
            }
            elseif(\Route::current()->getName() === 'subsubsubmenu.store'){
                return redirect()->route('subsubsubmenu.index', $sub_sub_menu_id)->with('sukses', 'sub-sub-sub-menu berhasil dibuat');
            }
            elseif(\Route::current()->getName() === 'subsubsubsubmenu.store'){
                return redirect()->route('subsubsubsubmenu.index', $sub_sub_sub_menu_id)->with('sukses', 'sub-sub-sub-sub-menu berhasil dibuat');
            }
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal','gagal saat menambahkan data');
        }
    }

    /**
     * 
     * SHOW SECTION
     * 
     */

    public function show(Request $request){
        try {
            $validate = $request->validate([
                'id' => 'required|numeric|min:1'
            ]);
            $halaman = halaman::findOrFail($validate['id']);
            //cek apakah itu page(id unik)
            $currentpage = subsubsubsubmenu::find($halaman->sub_sub_sub_sub_menu_id) ?? subsubsubmenu::find($halaman->sub_sub_sub_menu_id) ?? subsubmenu::find($halaman->sub_sub_menu_id) ?? submenu::find($halaman->sub_menu_id);
            return view('halaman.halaman')->with('halaman', $halaman)->with('page', $currentpage);
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal','Halaman Tidak Ditemukan');
        }
    }

    /**
     * 
     *  EDIT SECTION
     * 
     */
    
    public function edit_submenu(Request $request, $menu, $submenu){
        try {
            $validate = $request->validate([
                'edit' => 'required|numeric|min:0|max:6'
            ]);
            session([
                'menu_id' => $menu,
                'sub_menu_id' => $submenu
            ]);
            $data = submenu::findOrFail($submenu);
            return $this->create_provider($validate['edit'], $data);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','gagal mengubah sub-menu karena id menu atau id data tidak sesuai');
        }   
    }
    public function edit_subsubmenu(Request $request, $submenu, $subsubmenu){
        try {
            $validate = $request->validate([
                'edit' => 'required|numeric|min:0|max:6'
            ]);
            session([
                'sub_menu_id' => $submenu,
                'sub_sub_menu_id' => $subsubmenu
            ]);
            $data = subsubmenu::findOrFail($subsubmenu);
            return $this->create_provider($validate['edit'],$data);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','gagal menambahkan sub-sub-menu karena id submenu atau id data tidak sesuai');
        }   
    }
    public function edit_subsubsubmenu(Request $request, $subsubmenu, $subsubsubmenu){
        try {
            $validate = $request->validate([
                'edit' => 'required|numeric|min:0|max:6'
            ]);
            session([
                'sub_sub_menu_id' => $subsubmenu,
                'sub_sub_sub_menu_id' => $subsubsubmenu
            ]);
            $data = subsubsubmenu::findOrFail($subsubsubmenu);
            return $this->create_provider($validate['edit'], $data);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','gagal menambahkan sub-sub-sub-menu karena id subsubmenu atau id data tidak sesuai');
        }   
    }
    public function edit_subsubsubsubmenu(Request $request, $subsubsubmenu, $subsubsubsubmenu){
        try {
            $validate = $request->validate([
                'edit' => 'required|numeric|min:0|max:6'
            ]);
            session([
                'sub_sub_sub_menu_id' => $subsubsubmenu,
                'sub_sub_sub_sub_menu_id' => $subsubsubsubmenu
            ]);
            $data = subsubsubsubmenu::findOrFail($subsubsubsubmenu);
            return $this->create_provider($validate['edit'], $data);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','gagal menambahkan sub-sub-sub-menu karena id subsubmenu atau id data tidak sesuai');
        }   
    }
    public function update(Request $request){
        // dd($request);
        //init id seperti fungsi store sesuai dengan route
        $routeName = \Route::current()->getName();
        if($routeName === 'submenu.update'){
            $menu_id = session('menu_id');
            $submenu_id = session('sub_menu_id');
        }
        elseif ($routeName === 'subsubmenu.update') {
            $submenu_id = session('sub_menu_id');
            $subsubmenu_id = session('sub_sub_menu_id');
        }
        elseif ($routeName === 'subsubsubmenu.update') {
            $subsubmenu_id = session('sub_sub_menu_id');
            $subsubsubmenu_id = session('sub_sub_sub_menu_id');
        }
        elseif ($routeName === 'subsubsubsubmenu.update') {
            $subsubsubmenu_id = session('sub_sub_sub_menu_id');
            $subsubsubsubmenu_id = session('sub_sub_sub_sub_menu_id');
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
        if($routeName === 'subsubsubsubmenu.update'){
            $rules = [
                'judul' => 'nullable|string|max:50',
                'type' => 'nullable|string|in:page,link,id.pdupt',
            ];
    
        }else{
            $rules = [
                'judul' => 'nullable|string|max:50',
                'type' => 'nullable|string|in:page,dropdown,link,id.pdupt',
            ];
    
        }
        if ($request->input('type') == 'page') {
            if ($request->has('filetype')) {
                $rules['filetype'] = 'nullable|string|in:foto,video,pdf';
                $rules['image'] = 'nullable|image|mimes:png,jpeg,jpg|max:3000';
                $rules['pdf'] = 'nullable|mimes:pdf|max:30000';
                // $rules['yt_id'] = ['nullable', 'string', 'max:50', new YoutubeUrl]; // Sanitized YouTube ID
            } else {
                $rules['media'] = 'nullable|mimes:pdf,png,jpeg,jpg|max:30000';
                $rules['tambahan1'] = 'nullable|mimes:pdf,png,jpeg,jpg|max:30000';
                $rules['tambahan2'] = 'nullable|mimes:pdf,png,jpeg,jpg|max:30000';
                $rules['tambahan3'] = 'nullable|mimes:pdf,png,jpeg,jpg|max:30000';
                $rules['text'] = 'nullable|string';
		$rules['link'] = ['nullable', 'string', new YoutubeUrl];
            }
        }
        // Additional rules for 'link' type
        elseif ($request->input('type') == 'link') {
            $rules['link'] = ['nullable', 'string', new SafeUrl]; // Sanitized URL
        }

        // Additional rules for 'id.pdupt' type
        elseif ($request->input('type') == 'id.pdupt') {
            $rules['alamat'] = 'nullable|string|max:100';
            $rules['telp'] = 'nullable|string';
            $rules['wa'] = 'nullable|numeric|digits_between:11,14';
            $rules['fax'] = 'nullable|string';
            $rules['email'] = 'nullable|email';
            $rules['website'] = ['nullable', 'string', new SafeUrl]; // Sanitized website URL
            $rules['link'] = ['nullable','string', new SafeUrl];
            $rules['instagram'] = ['nullable', 'string', new SocialMediaUrl]; // Validate Instagram URL
            $rules['facebook'] = ['nullable', 'string', new SocialMediaUrl]; // Validate Facebook URL
            $rules['youtube'] = ['nullable', 'string', new SocialMediaUrl]; // Validate YouTube URL
            $rules['tiktok'] = ['nullable', 'string', new SocialMediaUrl]; // Validate TikTok URL
            $rules['x'] = ['nullable', 'string', new SocialMediaUrl]; // Validate X (Twitter) URL
            $rules['maps']  = ['nullable', 'string', function ($attribute, $value, $fail) {
                // Only allow iframe tags with Google Maps embed URLs
                if (!preg_match('/<iframe[^>]*src="https:\/\/www\.google\.com\/maps\/embed\?pb=[^"]*"[^>]*><\/iframe>/', $value)) {
                    $fail('Hanya Menerima Frame Google Maps.');
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
            // // For YouTube, handle video separately
            // $youtubeRule = new YoutubeUrl();
            // if ($youtubeRule->passes('yt_id', $validatedData['yt_id'] ?? null)) {
            //     $validatedData['yt_id'] = $youtubeRule->videoId ?? null;
            // }
            
            if($validatedData['maps'] !== null){
                $embed_code = strip_tags($validatedData['maps'], '<iframe>');
            }
        }
        try {
            // dd($validatedData['x_username']);
            if($routeName == 'submenu.update'){
                $data = submenu::findOrFail($submenu_id);
                $data->update([
                    'sub_menu' => $validatedData['judul'] ?? $data->sub_menu
                ]);
            }elseif($routeName == 'subsubmenu.update'){
                $data = subsubmenu::findOrFail($subsubmenu_id);
                $data->update([
                    'sub_sub_menu' => $validatedData['judul'] ?? $data->sub_sub_menu
                ]);
            }elseif($routeName == 'subsubsubmenu.update'){
                $data = subsubsubmenu::findOrFail($subsubsubmenu_id);
                $data->update([
                    'sub_sub_sub_menu' => $validatedData['judul'] ?? $data->sub_sub_sub_menu
                ]);
            }elseif($routeName == 'subsubsubsubmenu.update'){
                $data = subsubsubsubmenu::findOrFail($subsubsubsubmenu_id);
                $data->update([
                    'sub_sub_sub_sub_menu' => $validatedData['judul'] ?? $data->sub_sub_sub_sub_menu
                ]);
            }
            $data->update([
                'media' => isset($validatedData['media']) && is_file($validatedData['media']->getRealPath()) 
                    ? $this->storeFile($validatedData['media'])
                    : (isset($validatedData['pdf']) && is_file($validatedData['pdf']->getRealPath()) 
                        ? $this->storeFile($validatedData['pdf'])
                        : (isset($validatedData['image']) && is_file($validatedData['image']->getRealPath()) 
                            ? $this->storeFile($validatedData['image'])
                            : $data->media)),

                'tambahan1' => $request->has('hapus_tambahan1') ? null :
                    (isset($validatedData['tambahan1']) && is_file($validatedData['tambahan1']->getRealPath()) 
                        ? $this->storeFile($validatedData['tambahan1']) 
                        : $data->tambahan1),
                'tambahan2' => $request->has('hapus_tambahan2') ? null :
                    (isset($validatedData['tambahan2']) && is_file($validatedData['tambahan2']->getRealPath()) 
                        ? $this->storeFile($validatedData['tambahan2']) 
                        : $data->tambahan2),
                'tambahan3' => $request->has('hapus_tambahan3') ? null :
                    (isset($validatedData['tambahan3']) && is_file($validatedData['tambahan3']->getRealPath()) 
                        ? $this->storeFile($validatedData['tambahan3']) 
                        : $data->tambahan3),

                // 'yt_id' => $validatedData['yt_id'] ?? $data->yt_id,
                'alamat' => $validatedData['alamat'] ?? $data->alamat,
                'telp' => $validatedData['telp'] ?? $data->telp,
                'wa' => $validatedData['wa'] ?? $data->wa,
                'fax' => $validatedData['fax'] ?? $data->fax,
                'email' => $validatedData['email'] ?? $data->email,
                'website' => $validatedData['website'] ?? $data->website,
                'instagram' => $validatedData['instagram_username'] ?? $data->instagram,
                'facebook' => $validatedData['facebook_username']?? $data->facebook,
                'youtube' => $validatedData['youtube_channel']?? $data->youtube,
                'tiktok' => $validatedData['tiktok_username'] ?? $data->tiktok,
                'x' => $validatedData['x_username'] ?? $data->x,
                'maps' => $validatedData['maps'] ?? $data->maps,
                'text' => $validatedData['text'] ?? $data->text,
            ]);
            if ($request->has('hapus_link')) {
                $data->update(['link' => null]);
            } elseif ($request->has('link')) {
                $isYt = new YoutubeUrl();
                if ($isYt->passes('link', $validatedData['link'] ?? null)) {
                    $data->update(['link' => $isYt->videoId ?? $data->link]);
                } else {
                    $data->update(['link' => $validatedData['link'] ?? $data->link]);
                }
            }

            if($routeName === 'submenu.update'){
                return redirect()->route('submenu.index', $menu_id)->with('sukses', 'sub-menu berhasil diupdate');
            }
            elseif($routeName === 'subsubmenu.update'){
                return redirect()->route('subsubmenu.index', $submenu_id)->with('sukses', 'sub-sub-menu berhasil diupdate');
            }
            elseif($routeName === 'subsubsubmenu.update'){
                return redirect()->route('subsubsubmenu.index', $subsubmenu_id)->with('sukses', 'sub-sub-sub-menu berhasil diupdate');
            }
            elseif($routeName === 'subsubsubsubmenu.update'){
                return redirect()->route('subsubsubsubmenu.index', $subsubsubmenu_id)->with('sukses', 'sub-sub-sub-sub-menu berhasil diupdate');
            }
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function destroy_menu($menu){
        try {
            $data = menu::find($menu);
            $data->delete();

            return back()->with('sukses', 'data berhasil dihapus');
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function destroy_submenu($menu, $submenu){
        try {
            $data = submenu::find($submenu);
            // dd($submenu);
            $data->delete();

            return back()->with('sukses','data berhasil dihapus');
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function destroy_subsubmenu($submenu, $subsubmenu){
        try {
            $data = subsubmenu::find($subsubmenu);
            $data->delete();

            return back()->with('sukses','data berhasil dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function destroy_subsubsubmenu($subsubmenu, $subsubsubmenu){
        try {
            $data = subsubsubmenu::find($subsubsubmenu);
            $data->delete();

            return back()->with('sukses','data berhasil dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function destroy_subsubsubsubmenu($subsubsubmenu, $subsubsubsubmenu){
        try {
            $data = subsubsubsubmenu::find($subsubsubsubmenu);
            $data->delete();

            return back()->with('sukses','data berhasil dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
}

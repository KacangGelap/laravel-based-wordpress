<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\layout, App\Models\post, App\Models\submenu, App\Models\subsubmenu, App\Models\subsubsubmenu, App\Models\subsubsubsubmenu, App\Models\halaman;
use App\Models\card;
use App\Models\advanced_carousel, App\Models\advanced_carousel_category;
use App\Models\page_embed, App\Models\page_embed_category;
use App\Rules\YoutubeUrl, App\Rules\GoogleMapsUrl, App\Rules\SafeUrl, App\Rules\SocialMediaUrl;
class layoutController extends Controller
{
    private function storeFile($file){
        $filename = $file->getClientOriginalName();
        $path = 'images/'.$filename;
        if (\Storage::disk('public')->exists($path)){
            \Storage::disk('public')->delete($path);
        }
        return $file->storeAs('images', $filename, 'public');
    }
    // private function getOgMetadata($url){
    //     try {
    //         $response = Http::withoutVerifying()->timeout(5)->get($url);
    //         $html = $response->body();

    //         libxml_use_internal_errors(true);
    //         $dom = new \DOMDocument();
    //         $dom->loadHTML($html);
    //         libxml_clear_errors();

    //         $metaTags = $dom->getElementsByTagName('meta');
    //         $ogDataRaw = [];

    //         foreach ($metaTags as $tag) {
    //             if ($tag->hasAttribute('property') && str_starts_with($tag->getAttribute('property'), 'og:')) {
    //                 $property = $tag->getAttribute('property'); // misal "og:title"
    //                 $content = $tag->getAttribute('content');
    //                 $key = str_replace('og:', '', $property); // jadikan "title"
    //                 $ogDataRaw[$key] = $content;
    //             }
    //         }

    //         return $ogDataRaw;
    //     } catch (\Exception $e) {
    //         return [
    //             'title' => null,
    //             'description' => null,
    //             'image' => null,
    //             'error' => $e->getMessage(),
    //         ];
    //     }
    // }
    public function index(){
        if (\Route::current()->getName() === 'banner.index') {
            $layout = layout::where('type', 'banner')->first();
        } else {
            $layout = layout::where('type', '!=' ,'banner')->get();
        }
        
        return view('template.index')->with('data', $layout);
    }
    public function galeri(){ //only berita on images and 1 video on every linked menu
        $isYt = new YoutubeUrl();
        $videos = [];

        // Fetch up to 10 recent records per model (or more if needed)
        $records = collect();

        $records = $records->merge(
            submenu::whereNotNull('link')->orderBy('created_at', 'desc')->limit(10)->get()
        );
        $records = $records->merge(
            subsubmenu::whereNotNull('link')->orderBy('created_at', 'desc')->limit(10)->get()
        );
        $records = $records->merge(
            subsubsubmenu::whereNotNull('link')->orderBy('created_at', 'desc')->limit(10)->get()
        );

        // Sort all records globally by created_at descending
        $sortedRecords = $records->sortByDesc('created_at');

        foreach ($sortedRecords as $data) {
            $filterYt = 'https://youtu.be/' . $data->link;

            if ($isYt->passes('link', $filterYt)) {
                $videos[] = $isYt->videoId;

                if (count($videos) === 4) {
                    break;
                }
            }
        }


                  
	    // dd($video);
        $berita = post::orderBy('created_at', 'desc')->limit(15)->get();
        $submenu = submenu::where('type' , 'page')
                    ->where('filetype', '!=', 'pdf')
                    ->orWhere('filetype', null)
                    ->where('type', '!=', 'id.pdupt')
                    ->where('type', '!=', 'dropdown')
                    ->where('type', '!=', 'link')
                    ->orderBy('created_at', 'desc')->limit(2)
		    ->get();
        $subsubmenu = subsubmenu::where('type' , 'page')
                    ->where('filetype', '!=', 'pdf')
                    ->orWhere('filetype', null)
                    ->where('type', '!=', 'id.pdupt')
                    ->where('type', '!=', 'dropdown')
                    ->where('type', '!=', 'link')
		    ->orderBy('created_at', 'desc')->limit(2)
                    ->get();
        $subsubsubmenu = subsubsubmenu::where('type' , 'page')
                    ->where('filetype', '!=', 'pdf')
                    ->orWhere('filetype', null)
                    ->where('type', '!=', 'id.pdupt')
                    ->where('type', '!=', 'dropdown')
                    ->where('type', '!=', 'link')
		    ->orderBy('created_at', 'desc')->limit(2)
                    ->get();
        return view('post.galeri')->with('berita',$berita)->with('submenu',$submenu)->with('subsubmenu', $subsubmenu)->with('subsubsubmenu',$subsubsubmenu)->with('videos', $videos);
    }
    public function create(){
        $data = layout::all();
        return view('template.create')->with('data', $data);
    }
    public function store(Request $request){
        if(\Route::current()->getName() === 'banner.store'){
            $request->merge([
                'type' => 'banner'
            ]);
        }
        $validated = $request->validate([
            'media' =>  'nullable|max:3000|mimes:png,jpg,jpeg|image',
            'text'  =>  'nullable|string|max:50',
            'type'  =>  'required|string|in:banner,carousel-1,carousel-2,carousel-3,carousel-4,carousel-5|unique:layout',
        ]);
        try {
            // dd($validated['media']);
            $data = new layout();
            $data->media = $this->storeFile($validated['media']);
            $data->type = $validated['type'];
            $data->text = $validated['text'] ?? null;
            $data->save();
            if(\Route::current()->getName() === 'banner.store'){
                return redirect()->route('banner.index')->with('sukses', 'banner berhasil disimpan');
            }else{
                return redirect()->route('slider.index')->with('sukses', 'galeri geser berhasil disimpan');
            }
        } catch (\Throwable $th) {
            throw $th;
            return back()->with('gagal','terjadi kesalahan');
        }
    }
    public function edit($id){
        $data = layout::findOrFail($id);
        $data_exist = layout::all();
        return view('template.edit')->with('data', $data)->with('data_exist', $data_exist);
    }
    public function update(Request $request, $id){
        $validated = $request->validate([
            'media' =>  'nullable|max:3000|mimes:png,jpg,jpeg|image',
            'text'  =>  'nullable|string|max:50',
            'type'  =>  'nullable|string|in:banner,carousel-1,carousel-2,carousel-3,carousel-4,carousel-5|unique:layout',
        ]);
        try {
            $data = layout::findOrFail($id);
            $data->update([
                'media' => isset($validated['media']) && is_file($validated['media']->getRealPath())
                ? $this->storeFile($validated['media'])
                : $data->media,
                'text' => \Route::current()->getName() === 'slider.update' && isset($validated['text'])
                ? $validated['text']
                : $data->text,
                'type' => \Route::current()->getName() === 'banner.update'
                ? 'banner'
                : ($validated['type'] ?? $data->type),
            ]);
            if(\Route::current()->getName() === 'banner.update'){
                return redirect()->route('banner.index')->with('sukses', 'banner berhasil diubah');
            }else{
                return redirect()->route('slider.index')->with('sukses', 'galeri geser berhasil diubah');
            }
        } catch (\Throwable $th) {
            throw $th;
            return back()->with('gagal', 'Terjadi Kesalahan');
        }
    }
    public function destroy($id){
        try {
            $data = layout::findOrFail($id);
            $routeName = \Route::current()->getName();
            if($routeName === 'banner.destroy' && $data->type === 'banner'){
                $data->delete();
            }
            elseif($routeName === 'slider.destroy' && $data->type !== 'banner'){
                $data->delete();
            }else{
                return back()->with('gagal','Akses ditolak');
            }
            return back()->with('sukses','data berhasil dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }

    // card, advance carousel , page embed, yt profile, quote
    public function card(){
        $data = card::all();
        return view('misc.card.index')->with('data', $data);
    }
    public function card_create(){
        $data = card::all();
        if($data->count() < 3){
            return view('misc.card.create');
        }else{
            return back()->with('gagal', 'data maksimal 3');
        }
        
    }
    public function card_store(Request $request){
        $validated = $request->validate([
            'judul' => 'required|string|max:50',
            'image' => 'required|max:3000|mimes:png,jpg,jpeg|image'
        ]);
        try {
            $current_data = card::all();
            if($current_data->count() < 3){
                $data = new card();
                $data->judul = $validated['judul'];
                $data->image = $this->storeFile($validated['image']);
                $data->save();

                return redirect()->route('card.index')->with('sukses', 'data telah ditambah');
            }else{
                return redirect()->route('card.index')->with('gagal', 'maksimal upload adalah 3 data');
            }
            
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function card_edit($id){
        $data = card::findOrFail($id);

        return view('misc.card.edit')->with('data', $data);
    }
    public function card_update(Request $request, $id){
        $validated = $request->validate([
            'judul' => 'nullable|string|max:50',
            'image' => 'nullable|max:3000|mimes:png,jpg,jpeg|image'
        ]);
        try {
            $data = card::findOrFail($id);
            $data->update([
                'judul' => $validated['judul'] ?? $data->judul,
                'image' => isset($validated['image']) && is_file($validated['image']->getRealPath())
                ? $this->storeFile($validated['image'])
                : $data->image,
            ]);

            return redirect()->route('card.edit', $data->id)->with('sukses', 'data berhasil diubah');
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function card_delete($id){
        try {
            $card = card::findOrFail($id);
            $card->delete();

            return back()->with('sukses', 'data berhasil dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function carousel_category(){
        $data = advanced_carousel_category::all();

        return view('misc.carousel.index')->with('data', $data);
    }
    public function carousel_create_category(){
        return view('misc.carousel.create_category');
    }
    public function carousel_store_category(Request $request){
        $validated = $request->validate([
            'kategori' => 'required|string|max:20'
        ]);
        try {
            $data = new advanced_carousel_category();
            $data->kategori = $validated['kategori'];
            $data->save();

            return redirect()->route('carousel.index')->with('sukses', 'data berhasil ditambah');
        } catch (\Throwable $th) {
            //throw $th;
            return back()-with('gagal', 'terjadi kesalahan');
        }
    }
    public function carousel_edit_category($id){
        $data = advanced_carousel_category::findOrFail($id);

        return view('misc.carousel.edit_category')->with('data', $data);
    }
    public function carousel_update_category(Request $request, $id){
        $validated = $request->validate([
            'kategori' => 'nullable|string|max:20'
        ]);
        try {
            $data = advanced_carousel_category::findOrFail($id);
            $data->update([
                'kategori' => $validated['kategori'] ?? $data->kategori
            ]);
            return redirect()->route('carousel.index')->with('sukses', 'data berhasil diubah');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function carousel_delete_category($id){
        try {
            $data = advanced_carousel_category::findOrFail($id);
            $data->delete();
            return back()->with('sukses', 'data berhasil dihapus');
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function carousels($id){
        $cat = advanced_carousel_category::findOrFail($id);
        $data = advanced_carousel::where('kategori_id', $cat->id)->simplePaginate(20);
        return view('misc.carousel.carousels')->with('data', $data)->with('cat', $cat);
    }
    public function carousel_create(){
        $cat = advanced_carousel_category::all();
        return view('misc.carousel.create')->with('cat',$cat);
    }
    public function carousel_store(Request $request){
        $validated = $request->validate([
            'kategori_id' => 'required|numeric|min:1',
            'judul' => 'required|string|max:50',
            'image' => 'required|max:3000|mimes:png,jpg,jpeg|image'
        ]);
        try {
            $data = new advanced_carousel();
            $data->kategori_id = $validated['kategori_id'];
            $data->judul = $validated['judul'];
            $data->media = $this->storeFile($validated['image']);
            $data->save();

            return redirect()->route('carousel.carousels', $data->kategori_id)->with('sukses', 'data berhasil ditambah');
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function carousel_edit($id){
        $data = advanced_carousel::findOrFail($id);
        // dd($data->media);
        return view('misc.carousel.edit')->with('data', $data)->with('cat',advanced_carousel_category::all());
    }
    public function carousel_update(Request $request, $id){
        $validated = $request->validate([
            'kategori_id' => 'nullable|numeric|min:1',
            'judul' => 'nullable|string|max:20',
            'image' => 'nullable|max:3000|mimes:png,jpg,jpeg|image'
        ]);
        try {
            $data = advanced_carousel::findOrFail($id);
            $data->update([
                'kategori_id' => $validated['kategori_id'] ?? $data->kategori_id,
                'judul' => $validated['judul'] ?? $data->judul,
                'media' => isset($validated['image']) && is_file($validated['image']->getRealPath())
                ? $this->storeFile($validated['image'])
                : $data->media,
            ]);
            return redirect()->route('carousel.carousels', $data->kategori_id)->with('sukses','data berhasil diubah');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','terjadi kesalahan');
        }
    }
    public function carousel_delete($id){
        try {
            $data = advanced_carousel::findOrFail($id);
            $data->delete();
            return back()->with('sukses', 'data berhasil dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function embed_category(){
        $data = page_embed_category::all();
        return view('misc.embed.index')->with('data',$data);
    }
    public function embed_create_category(){
        if(page_embed_category::all()->count()  < 3){
            return view('misc.embed.create_category');
        }else{
            return redirect()->route('embed.index')->with('gagal','maks inputan adalah 3');
        }
        
    }
    public function embed_store_category(Request $request){
        $validated = $request->validate([
            'kategori' => 'required|string|max:50'
        ]);
        try {
            if(page_embed_category::all()->count() < 3){
                $data = new page_embed_category();
                $data->kategori = $validated['kategori'];
                $data->save();
                return redirect()->route('embed.index')->with('sukses','data berhasil ditambah');
            }else{
                return redirect()->route('embed.index')->with('gagal','maks inputan adalah 3');
            }
            
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','terjadi kesalahan');
        }
    }
    public function embed_edit_category($id){
        $data = page_embed_category::findOrFail($id);
        return view('misc.embed.edit_category')->with('data',$data);
    }
    public function embed_update_category(Request $request, $id){
        $validated = $request->validate([
            'kategori'=>'nullable|string|max:50'
        ]);
        try {
            $data = page_embed_category::findOrFail($id);
            $data->update([
                'kategori' => $validated['kategori'] ?? $data->kategori
            ]);
            return redirect()->route('embed.index')->with('sukses','data berhasil ditambah');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','terjadi kesalahan');
        }
    }
    public function embed_delete_category($id){
        try {
            $data = page_embed_category::findOrFail($id);
            $data->delete();
            return back()->with('sukses','data telah dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','terjadi kesalahan');
        }
    }
    public function embeds($id){
         $cat = page_embed_category::findOrFail($id);
        $selfHost = parse_url(url('/'), PHP_URL_HOST);

        // Ambil semua embed tanpa paginate dulu
        $raw = page_embed::where('kategori_id', $cat->id)->get();

        // Proses dan filter collection
        $parsed = $raw->map(function ($item) use ($selfHost) {
            $parsedUrl = parse_url($item->link);
            $host = $parsedUrl['host'] ?? null;
            $path = $parsedUrl['path'] ?? null;

            if ($host !== $selfHost || $path !== '/page') {
                return null; // tandai sebagai tidak valid
            }

            parse_str($parsedUrl['query'] ?? '', $queryParams);
            $halamanId = $queryParams['id'] ?? null;

            if (!$halamanId) return null;

            $halaman = halaman::find($halamanId);
            if (!$halaman) return null;

            $item->halaman = $halaman;
            $item->currentpage = subsubsubsubmenu::find($halaman->sub_sub_sub_sub_menu_id)
                ?? subsubsubmenu::find($halaman->sub_sub_sub_menu_id)
                ?? subsubmenu::find($halaman->sub_sub_menu_id)
                ?? submenu::find($halaman->sub_menu_id);

            return $item;
        })->filter()->values(); // hapus null dan reset key

        // Manual pagination
        $page = request()->get('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $paginated = new LengthAwarePaginator(
            $parsed->slice($offset, $perPage)->values(),
            $parsed->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('misc.embed.embeds', [
            'data' => $paginated,
            'cat' => $cat,
        ]);
    }

    public function embed_create(){
        return view('misc.embed.create')->with('cat', page_embed_category::all());
    }
    public function embed_store(Request $request){
        $validated = $request->validate([
            'kategori_id' => 'required|numeric|min:1',
            'link' => ['required', 'url', function ($attribute, $value, $fail) {
                $parsedUrl = parse_url($value);
                $selfHost = parse_url(url('/'), PHP_URL_HOST);

                // 1. Cek domain
                if (($parsedUrl['host'] ?? '') !== $selfHost) {
                    return $fail("Link harus berasal dari domain {$selfHost}.");
                }

                // 2. Cek path harus '/page'
                if (($parsedUrl['path'] ?? '') !== '/page') {
                    return $fail("Path URL harus '/page'. Contoh: https://{$selfHost}/page?id=21");
                }

                // 3. Cek harus ada query 'id'
                parse_str($parsedUrl['query'] ?? '', $queryParams);
                if (!isset($queryParams['id'])) {
                    return $fail("Link harus memiliki parameter ?id= pada URL.");
                }
            }],
        ]);

        try {
            $data = new page_embed();
            $data->kategori_id = $validated['kategori_id'];
            $data->link = $validated['link'];
            $data->save();
            return redirect()->route('embed.embeds', $data->kategori_id)->with('sukses','data berhasil ditambah');
        } catch (\Throwable $th) {
            throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function embed_edit($id){
        $data = page_embed::findOrFail($id);
        return view('misc.embed.edit')->with('data', $data)->with('cat',page_embed_category::all());
    }
    public function embed_update(Request $request, $id){
        $validated = $request->validate([
            'kategori_id' => 'required|numeric|min:1',
            'link' => ['required', 'url', function ($attribute, $value, $fail) {
                $parsedUrl = parse_url($value);
                $selfHost = parse_url(url('/'), PHP_URL_HOST);

                // 1. Cek domain
                if (($parsedUrl['host'] ?? '') !== $selfHost) {
                    return $fail("Link harus berasal dari domain {$selfHost}.");
                }

                // 2. Cek path harus '/page'
                if (($parsedUrl['path'] ?? '') !== '/page') {
                    return $fail("Path URL harus '/page'. Contoh: https://{$selfHost}/page?id=21");
                }

                // 3. Cek harus ada query 'id'
                parse_str($parsedUrl['query'] ?? '', $queryParams);
                if (!isset($queryParams['id'])) {
                    return $fail("Link harus memiliki parameter ?id= pada URL.");
                }
            }],
        ]);
        try {
            $data =page_embed::findOrFail($id);
            $data->update([
                'kategori_id' => $validated['kategori_id'] ?? $data->kategori_id,
                'link' => $validated['link'] ?? $data->link,
            ]);
            return redirect()->route('embed.embeds', $data->kategori_id)->with('sukses', 'data behasil diubah');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','terjadi kesalahan');
        }
    }
    public function embed_delete($id){
        try {
            $data = page_embed::findOrFail($id);
            $data->delete();
            return back()->with('sukses','data berhasil dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
    public function configure_quote(){
        $quote = Storage::exists('quote.txt') ? Storage::get('quote.txt') : '';
        return view('misc.quote', compact('quote'));
    }
    public function apply_quote(Request $request)
    {
        $request->validate([
            'quote' => 'required|string|max:120',
        ]);
        try {
            Storage::put('quote.txt', $request->input('quote'));
            return redirect()->route('quote.index')->with('sukses', 'Quote telah diperbarui!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('quote.index')->with('gagal', 'Terjadi kesalahan');
        }
    }
    public function configure_faq(){
        $faq = Storage::exists('faq.txt') ? Storage::get('faq.txt') : '';
        return view('misc.faq', compact('faq'));
    }
    public function apply_faq(Request $request)
    {
        $validated = $request->validate([
            'faq' => ['required', 'url', function ($attribute, $value, $fail) {
                $parsedUrl = parse_url($value);
                $selfHost = parse_url(url('/'), PHP_URL_HOST);

                // 1. Cek domain
                if (($parsedUrl['host'] ?? '') !== $selfHost) {
                    return $fail("Link harus berasal dari domain {$selfHost}.");
                }

                // 2. Cek path harus '/page'
                if (($parsedUrl['path'] ?? '') !== '/page') {
                    return $fail("Path URL harus '/page'. Contoh: https://{$selfHost}/page?id=21");
                }

                // 3. Cek harus ada query 'id'
                parse_str($parsedUrl['query'] ?? '', $queryParams);
                if (!isset($queryParams['id'])) {
                    return $fail("Link harus memiliki parameter ?id= pada URL.");
                }
            }],
        ]);
        try {
            Storage::put('faq.txt', $request->input('faq'));
            return redirect()->route('faq.index')->with('sukses', 'FAQ telah diperbarui!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('faq.index')->with('gagal', 'Terjadi kesalahan');
        }
    }
    public function configure_profil(){
        $profil = Storage::exists('profil.txt') ? Storage::get('profil.txt') : '';
        return view('misc.profil', compact('profil'));
    }
    public function apply_profil(Request $request)
    {
        $validated = $request->validate([
            'profil' => ['required', 'string', new YoutubeUrl],
        ]);
        try {
            $isYt = new YoutubeUrl();
            if($isYt->passes('link', $validated['profil'] ?? null)){
                Storage::put('profil.txt', $isYt->videoId ?? null);
            }
            

            return redirect()->route('video.index')->with('sukses', 'data updated successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('video.index')->with('gagal', 'terjadi kesalahan');
        }
        
    }
}
 
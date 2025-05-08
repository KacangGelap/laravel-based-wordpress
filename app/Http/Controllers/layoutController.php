<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\layout, App\Models\post, App\Models\submenu, App\Models\subsubmenu, App\Models\subsubsubmenu;
use App\Rules\YoutubeUrl;
class layoutController extends Controller
{
    private function storeFile($file)
    {
        $filename = $file->getClientOriginalName();
	$path = 'images/'.$filename;
	if (\Storage::disk('public')->exists($path)){
	    \Storage::disk('public')->delete($path);
	}
        return $file->storeAs('images', $filename, 'public');
    }
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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\unduh, App\Models\filecat;
class unduhController extends Controller
{
    private function storeFile($file)
    {
        $filename = $file->getClientOriginalName();
	if($file->getMimeType() === 'application/pdf'){
	   $path = 'pdfs/'.$filename;
	}else{
	   $path = 'images/'.$filename;
	}
	if(Storage::disk('public')->exists($path)){
	  Storage::disk('public')->delete($path);
	}
        return $file->storeAs( $file->getMimeType() === 'application/pdf' ? 'pdfs' : 'images', $filename, 'public');
    }
    public function download($id){
        $file = unduh::findOrFail($id); 
        $filePath = $file->media;
    
        if (Storage::exists("$filePath")) {
            return Storage::download("$filePath");
        } else {
            return redirect()->back()->with('gagal', 'File not found.');
        }
    }
    public function index(){
        // $data = unduh::orderBy('created_at','desc')->get();
        $filecat = filecat::all();
        return view('unduh.index')->with('filecat', $filecat);
    }
    public function create(){
        $filecat = filecat::all();
        return view('unduh.create')->with('filecat', $filecat);
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'media' => 'required|mimes:pdf,png,jpg',
            'kategori'=>'required|numeric|min:1',
        ]);
        try {
            $data = new unduh();
            $data->nama = $request->file('media')->getClientOriginalName();
            $data->media = $this->storeFile($request->file('media'));
            $data->filecat_id = $validatedData['kategori'];
            $data->save();

            return redirect()->route('unduh.index')->with('sukses','file berhasil ditambahkan');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('unduh.index')->with('gagal','terjadi kesalahan');
        }
    }
    public function edit($id){
        $data = unduh::findOrFail($id);
        $filecat = filecat::all();
        return view('unduh.edit')->with('data', $data)->with('filecat', $filecat);
    }
    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'media' => 'required|mimes:pdf,png,jpg',
            'kategori'=>'required|numeric|min:1',
        ]);
        try {
            $data = unduh::findOrFail($id);
            $data->update([
                'nama' => $request->file('media')->getClientOriginalName(),
                'media'=> $this->storeFile($request->file('media')),
                'filecat_id'=>$validatedData['kategori']
            ]);

            return redirect()->route('unduh.index')->with('sukses', 'file berhasil diubah');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('unduh.index')->with('gagal', 'terjadi kesalahan');
        }
    }
    public function show(){
        $filecat = filecat::all();
        return view('unduh.show')->with('filecat', $filecat);
    }
    public function destroy($id){
        try {
            $data = unduh::findOrFail($id);
            $data->delete();
            return redirect()->route('unduh.index')->with('sukses', 'file berhasil dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('unduh.index')->with('gagal', 'terjadi kesalahan');
        }
    }
    public function kategori_create(){
        return view('unduh.kategori');
    }

    public function kategori_store(Request $request){
        $validated = $request->validate([
            'kategori' => 'required|string|max:20'
        ]);
        try {
            $data = new filecat();
            $data->cat = $validated['kategori'];
            if(filecat::all()->count() !== 6){
                $data->save();
                return redirect()->route('unduh.index')->with('sukses', 'kategori berhasil ditambah');
            }
            else{
                return redirect()->route('unduh.index')->with('gagal','kategori sudah melebihi batas');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('unduh.index')->with('gagal', 'terjadi kesalahan');
        }
    }
    public function kategori_edit($id){
        $data = filecat::findOrFail($id);

        return view('unduh.kategori')->with('data',$data);
    }
    public function kategori_update(Request $request, $id){
        $validated = $request->validate([
            'kategori' => 'required|string|max:20'
        ]);
        try {
            $data = filecat::findOrFail($id);
            // dd($data);
            $data->update([
                'cat' => $validated['kategori'] ?? $data->cat
            ]);
            return redirect()->route('unduh.index')->with('sukses', 'kategori berhasil diubah');
        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->route('unduh.index')->with('gagal', 'terjadi kesalahan');
        }
    }
    public function kategori_destroy($id){
        try {
            $data = filecat::findOrFail($id);
            $data->delete();
            return back()->with('sukses','kategori berhasil dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','terjadi kesalahan');
        }
    }
}

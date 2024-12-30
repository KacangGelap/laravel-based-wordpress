<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategori, App\Models\post;
use Auth;
class beritaController extends Controller
{
    public function index(){
        $data = post::all();
        $kegiatan = post::where('kategori_id', 1)->get();
        $informasi = post::where('kategori_id', 2)->get();
        $apelPagi = post::where('kategori_id', 3)->get();
        $kerjaBakti = post::where('kategori_id', 4)->get();
        return view('post.index')->with('data', $data)
        ->with('kegiatan', $kegiatan)
        ->with('informasi', $informasi)
        ->with('apelPagi', $apelPagi)
        ->with('kerjaBakti', $kerjaBakti);
    }
    public function create(){
        $kategori = kategori::all();
        return view('post.create')->with('kategori', $kategori);
    }
    public function store(Request $request){
        $request->validate([
            'judul' => 'required|string|min:5',
            'media1'=> 'required|image|mimes:jpeg,png,jpg,bmp|max:2000',
            'media2'=> 'nullable|image|mimes:jpeg,png,jpg,bmp|max:2000',
            'media3'=> 'nullable|image|mimes:jpeg,png,jpg,bmp|max:2000',
            'deskripsi1'=>'required|string|min:20|max:365',
            'deskripsi2'=>'nullable|string|min:20|max:365',
            'deskripsi3'=>'nullable|string|min:20|max:365',
            'kategori_id'=>'required|numeric'
        ]);
        try {
            $data = new post();
            // data yang wajib diisi
            $data->judul = $request->input('judul');
            $data->media1 = 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media1')));
            $data->deskripsi1 = $request->input('deskripsi1');
            $data->kategori_id = $request->input('kategori_id');
            //data yang opsional diisi
            if($request->file('media2') != NULL){
                $data->media2 = 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media2')));
            }
            if($request->input('deskripsi2') != NULL){
                $data->deskripsi2 = $request->input('deskripsi2');
            }
            if($request->file('media3') != NULL){
                $data->media3 = 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media3')));
            }
            if($request->input('deskripsi3') != NULL){
                $data->deskripsi3 = $request->input('deskripsi3');
            }

            // dd($data);
            $data->user_id = Auth::Id();
            $data->save();
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->route('post.create')->with('gagal','terjadi kesalahan');
        }
        return redirect()->route('post.index')->with('sukses','data berhasil ditambah');
    }
    public function edit(string $post){
        $item = post::findOrFail($post);
        $kategori = kategori::all();
        return view('post.edit')->with('post',$item)->with('kategori', $kategori);
    }
    public function update(Request $request, string $post){
        $request->validate([
            'judul' => 'required|string|min:5|max:100',
            'media1'=> 'nullable|image|mimes:jpeg,png,jpg,bmp|max:3000',
            'media2'=> 'nullable|image|mimes:jpeg,png,jpg,bmp|max:3000',
            'media3'=> 'nullable|image|mimes:jpeg,png,jpg,bmp|max:3000',
            'deskripsi1'=>'nullable|string|min:20',
            'deskripsi2'=>'nullable|string|min:20',
            'deskripsi3'=>'nullable|string',
            'kategori_id'=>'nullable|numeric'
        ]);
        // dd($request->has('kategori_id'));
        try {
            $post = post::findOrFail($post);
            $post->update([
                'judul' => $request->input('judul'),
                'media1'=> $request->has('media1') ? 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media1'))) : $post->media1,
                'media2'=> $request->has('media2') ? 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media2'))) : $post->media2,
                'media3'=> $request->has('media3') ? 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media3'))) : $post->media3,
                'deskripsi1'=> $request->has('deskripsi1') ? $request->input('deskripsi1') : $post->deskripsi1,
                'deskripsi2'=> $request->has('deskripsi2') ? $request->input('deskripsi2') : $post->deskripsi2,
                'deskripsi3'=> $request->has('deskripsi3') ? $request->input('deskripsi3') : $post->deskripsi3,
                'kategori_id'=> $request->has('kategori_id') ? $request->input('kategori_id') : $post->kategori_id,
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('gagal','Terjadi Kesalahan');
        }
        return redirect()->route('post.view',['post'=>$post->id])->with('sukses','data berhasil diubah');
    }
    public function show(Request $request){
        try {
            $validated = $request->validate([
                'post' => 'required|numeric'
            ]);
    
            $post = $validated['post'];
            $item = post::findOrFail($post);
            $latest = post::orderBy('created_at','desc')->get();
            return view('post.show')->with('post', $item)->with('latest', $latest);
        } catch (\Throwable $th) {
            return back()->with('gagal','terjadi kesalahan');
        }
        
    }
    public function destroy(string $post){
        try {
            $post = post:: findOrFail($post);
            $post->delete();
        } catch (\Throwable $th) {
            return redirect()->route('post.index')->with('gagal','terjadi kesalahan');
        }
        
    }
}

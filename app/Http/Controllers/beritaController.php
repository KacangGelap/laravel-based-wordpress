<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategori, App\Models\post;
use Auth;
class beritaController extends Controller
{
    public function index(){
        $data = post::all();
        $kegiatan = post::where('kategori_id', 1)->count();
        $informasi = post::where('kategori_id', 2)->count();
        $apelPagi = post::where('kategori_id', 3)->count();
        $kerjaBakti = post::where('kategori_id', 4)->count();
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
            'judul' => 'required|string|min:5|max:100',
            'media1'=> 'required|image|mimes:jpeg,png,jpg|max:2000',
            'media2'=> 'nullable|image|mimes:jpeg,png,jpg|max:2000',
            'media3'=> 'nullable|image|mimes:jpeg,png,jpg|max:2000',
            'media4'=> 'nullable|image|mimes:jpeg,png,jpg|max:2000',
            'deskripsi'=>'required|string|min:20|max:500',
            'contributor'=>'required|string|max:50',
            'kategori_id'=>'required|numeric'
        ]);
        try {
            $data = new post();
            // data yang wajib diisi
            $data->judul        = $request->input('judul');
            $data->user_id      = Auth::Id();
            $data->contributor  = $request->input('contributor');
            $data->deskripsi    = $request->input('deskripsi');
            $data->media1       = 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media1')));
            $data->media2       = $request->has('media2') ? 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media2'))) : NULL;
            $data->media3       = $request->has('media3') ? 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media3'))) : NULL;
            $data->media4       = $request->has('media4') ? 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media4'))) : NULL;
            $data->kategori_id  = $request->input('kategori_id');
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
            'media1'=> 'nullable|image|mimes:jpeg,png,jpg|max:2000',
            'media2'=> 'nullable|image|mimes:jpeg,png,jpg|max:2000',
            'media3'=> 'nullable|image|mimes:jpeg,png,jpg|max:2000',
            'media4'=> 'nullable|image|mimes:jpeg,png,jpg|max:2000',
            'deskripsi'=>'nullable|string|min:20|max:500',
            'contributor'=>'nullable|string|max:50',
            'kategori_id'=>'nullable|numeric'
        ]);
        try {
            $post = post::findOrFail($post);
            $post->update([
                'judul' => $request->input('judul'),
                'media1'=> $request->has('media1') ? 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media1'))) : $post->media1,
                'media2'=> $request->has('media2') ? 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media2'))) : $post->media2,
                'media3'=> $request->has('media3') ? 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media3'))) : $post->media3,
                'media4'=> $request->has('media4') ? 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('media4'))) : $post->media4,
                'deskripsi'=> $request->has('deskripsi') ? $request->input('deskripsi') : $post->deskripsi,
                'contributor'=> $request->has('contributor') ? $request->input('contributor') : $post->contributor,
                'kategori_id'=> $request->has('kategori_id') ? $request->input('kategori_id') : $post->kategori_id,
            ]);
        } catch (\Throwable $th) {
            // throw $th;
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
            return view('post.show')->with('post', $item);
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('gagal','terjadi kesalahan');
        }
        
    }
    public function destroy(string $post){
        try {
            $post = post::findOrFail($post);
            $post->delete();
            return redirect()->route('post.index')->with('sukses','Berita berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('post.index')->with('gagal','terjadi kesalahan');
        }
        
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategori, App\Models\post;
use Illuminate\Support\Facades\Storage;
use Auth;
class beritaController extends Controller
{
    private function storeFile($file)
    {
        $filename = $file->getClientOriginalName();
	if(Storage::disk('public')->exists('images/'.$filename)){
	   Storage::disk('public')->delete('images/'.$filename);
	}
        return $file->storeAs('images', $filename, 'public');
    }
    public function index(){
        $data = post::orderBy('created_at', 'desc')->get();
        $kategori = kategori::all();
        return view('post.index')->with('data', $data)
                ->with('kategori', $kategori);
    }
    public function list(){
        $berita = post::orderBy('created_at', 'desc')->get();
        $kategori = kategori::all();
        return view('post.list')->with('berita', $berita)->with('kategori', $kategori);
    }
    public function search(Request $request){
        
        try {
            $validated = $request->validate([
                'search' => 'required|string|max:255|min:5',
            ]);
            $query = $validated['search'];
            $berita = Post::where('judul', 'like', '%' . $query . '%')
            ->orWhere('deskripsi', 'like', '%' . $query . '%')
            ->get();
        return view('post.list')->with('berita', $berita)->with('query', $query);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal', 'pencarian harus menggunakan minimal 5 huruf');
        }
    }
    public function categories($id){
        $data = post::where('kategori_id', $id)->get();
        return view('post.list')->with('berita', $berita);
    }
    public function create(){
        $kategori = kategori::all();
        return view('post.create')->with('kategori', $kategori);
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|min:5|max:100',
            'media1'      => 'required|image|mimes:jpeg,png,jpg|max:3000',
            'media2'      => 'nullable|image|mimes:jpeg,png,jpg|max:3000',
            'media3'      => 'nullable|image|mimes:jpeg,png,jpg|max:3000',
            'media4'      => 'nullable|image|mimes:jpeg,png,jpg|max:3000',
            'deskripsi'   => 'required|string|min:20|max:3000',
            'contributor' => 'required|string|max:50',
            'kategori_id' => 'required|numeric'
        ]);

        try {
            $data = new Post();
            $data->judul       = ucfirst($request->input('judul'));
            $data->user_id     = Auth::id();
            $data->contributor = $request->input('contributor');
            $data->deskripsi   = $request->input('deskripsi');
            $data->kategori_id = $request->input('kategori_id');

            // Save files and store only the file paths
            $data->media1 = $this->storeFile($request->file('media1'));
            $data->media2 = $request->hasFile('media2') ? $this->storeFile($request->file('media2')) : null;
            $data->media3 = $request->hasFile('media3') ? $this->storeFile($request->file('media3')) : null;
            $data->media4 = $request->hasFile('media4') ? $this->storeFile($request->file('media4')) : null;

            $data->save();
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->route('post.create')->with('gagal', 'Terjadi kesalahan');
        }

        return redirect()->route('post.index')->with('sukses', 'Data berhasil ditambah');
    }

    public function edit(string $post){
        $item = post::findOrFail($post);
        $kategori = kategori::all();
        return view('post.edit')->with('post',$item)->with('kategori', $kategori);
    }
    public function update(Request $request, string $postId)
    {
        $request->validate([
            'judul' => 'required|string|min:5|max:100',
            'media1' => 'nullable|image|mimes:jpeg,png,jpg|max:3000',
            'media2' => 'nullable|image|mimes:jpeg,png,jpg|max:3000',
            'media3' => 'nullable|image|mimes:jpeg,png,jpg|max:3000',
            'media4' => 'nullable|image|mimes:jpeg,png,jpg|max:3000',
            'deskripsi' => 'nullable|string|min:20|max:3000',
            'contributor' => 'nullable|string|max:50',
            'kategori_id' => 'nullable|numeric'
        ]);

        try {
            $post = Post::findOrFail($postId);
            $post->update([
                'judul'       => $request->input('judul'),
                'media1'      => $request->hasFile('media1') ? $this->storeFile($request->file('media1')) : $post->media1,
                'media2'      => $request->hasFile('media2') ? $this->storeFile($request->file('media2')) : $post->media2,
                'media3'      => $request->hasFile('media3') ? $this->storeFile($request->file('media3')) : $post->media3,
                'media4'      => $request->hasFile('media4') ? $this->storeFile($request->file('media4')) : $post->media4,
                'deskripsi'   => $request->filled('deskripsi') ? $request->input('deskripsi') : $post->deskripsi,
                'contributor' => $request->filled('contributor') ? $request->input('contributor') : $post->contributor,
                'kategori_id' => $request->filled('kategori_id') ? $request->input('kategori_id') : $post->kategori_id,
            ]);

        } catch (\Throwable $th) {
            return redirect()->back()->with('gagal', 'Terjadi Kesalahan');
        }

        return redirect()->route('post.view', ['post' => $post->id])->with('sukses', 'Data berhasil diubah');
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

    public function kategori_create(){
        return view('post.kategori');
    }

    public function kategori_store(Request $request){
        $validated = $request->validate([
            'kategori' => 'required|string|max:20'
        ]);
        try {
            $data = new kategori();
            $data->kategori = $validated['kategori'];
            if(kategori::all()->count() !== 6){
                $data->save();
                return redirect()->route('post.index')->with('sukses', 'kategori berhasil ditambah');
            }
            else{
                return redirect()->route('post.index')->with('gagal','kategori sudah melebihi batas');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('post.index')->with('gagal', 'terjadi kesalahan');
        }
    }
    public function kategori_edit($id){
        $data = kategori::findOrFail($id);

        return view('post.kategori')->with('data',$data);
    }
    public function kategori_update(Request $request, $id){
        $validated = $request->validate([
            'kategori' => 'required|string|max:20'
        ]);
        try {
            $data = kategori::findOrFail($id);
            // dd($data);
            $data->update([
                'kategori' => $validated['kategori'] ?? $data->kategori
            ]);
            return redirect()->route('post.index')->with('sukses', 'kategori berhasil diubah');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->route('post.index')->with('gagal', 'terjadi kesalahan');
        }
    }
    public function kategori_destroy($id){
        try {
            $data = kategori::findOrFail($id);
            $data->delete();
            return back()->with('sukses','kategori berhasil dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','terjadi kesalahan');
        }
    }
}

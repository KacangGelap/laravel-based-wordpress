<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\link;
use App\Rules\SafeUrl;
class linkController extends Controller
{
    private function storeFile($file)
    {
        $filename = $file->getClientOriginalName();
        return $file->storeAs('images', $filename, 'public');
    }
    public function index(){
        $data = link::all();

        return view('link.index')->with('data', $data);
    }
    public function create(){
        if(link::all()->count() < 10){
            return view('link.create');
        }else{
            return back()->with('gagal', 'hanya bisa mengisi sebanyak 10 link');
        }
        
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'nama' => 'required|string|max:50',
            'media'=> 'required|image|mimes:png,jpg,jpeg|max:3000',
            'url' => ['required','string', new SafeUrl]
        ]);
        try {
            if(link::all()->count() < 10){
                $data = new link();
                $data->nama = $validatedData['nama'];
                $data->media = $this->storeFile($validatedData['media']);
                $data->url = $validatedData['url'];
                $data->save();

                return redirect()->route('link.index')->with('sukses', 'link berhasil ditambah');
            }else{
                return redirect()->route('link.index')->with('gagal', 'hanya bisa mengisi sebanyak 10 link');
            }
            
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('link.index')->with('gagal', 'terjadi kesalahan');
        }
    }
    public function edit($id){
        $data = link::findOrFail($id);
        return view('link.edit')->with('data', $data);
    }
    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'nama' => 'required|string|max:50',
            'media'=> 'nullable|image|mimes:png,jpg,jpeg|max:3000',
            'url' => ['required','string', new SafeUrl]
        ]);
        try {
            $data = link::findOrFail($id);
            $data->update([
                'nama' => $validatedData['nama'],
                'media' => $request->has('media') ? $this->storeFile($validatedData['media']) : $data->media,
                'url' => $validatedData['url'],
            ]);
            

            return redirect()->route('link.index')->with('sukses', 'link berhasil diubah');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('link.index')->with('gagal', 'terjadi kesalahan');
        }
    }
    public function destroy($id){
        try {
            $data = link::findOrFail($id);
            $data->delete();
            return redirect()->route('link.index')->with('sukses','link berhasil dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('link.index')->with('gagal','terjadi kesalahan');
        }
    }
}

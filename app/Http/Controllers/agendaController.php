<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\agenda;
class agendaController extends Controller
{
    public function index(){
        $data = agenda::orderBy('created_at','desc')->simplePaginate(15);
        return view('kalender.index')->with('data', $data);
    }
    public function create(){
        return view('kalender.create');
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'nama_kegiatan' => 'required|string|max:100',
            'penyelenggara' => 'required|string|max:100',
            'mulai' => 'required|date_format:Y-m-d\TH:i',
            'selesai' => 'required|date_format:Y-m-d\TH:i|after:mulai',
            'lokasi' => 'required|string',
            'alamat' => 'required|string',
            'menghadiri' => 'required|string'
        ]);
        try {
            $data = new agenda();
            $data->nama_kegiatan = $validatedData['nama_kegiatan'];
            $data->penyelenggara = $validatedData['penyelenggara'];
            $data->mulai        = $validatedData['mulai'];
            $data->selesai      = $validatedData['selesai'];
            $data->lokasi       = $validatedData['lokasi'];
            $data->alamat       = $validatedData['alamat'];
            $data->menghadiri   = $validatedData['menghadiri'];
            $data->save();

            return redirect()->route('kalender.index')->with('sukses','agenda berhasil dibuat');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal','terjadi kesalahan');
        }
    }
    public function edit($id){
        $data = agenda::findOrFail($id);

        return view('kalender.edit')->with('data', $data);
    }
    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'nama_kegiatan' => 'required|string|max:100',
            'penyelenggara' => 'required|string|max:100',
            'mulai' => 'required|date_format:Y-m-d\TH:i',
            'selesai' => 'required|date_format:Y-m-d\TH:i|after:mulai',
            'lokasi' => 'required|string',
            'alamat' => 'required|string',
            'menghadiri' => 'required|string'
        ]);
        try {
            $data = agenda::findOrFail($id);
            $data->update([
                'nama_kegiatan' => $validatedData['nama_kegiatan'],
                'penyelenggara' => $validatedData['penyelenggara'],
                'mulai' => $validatedData['mulai'],
                'selesai' => $validatedData['selesai'],
                'lokasi' => $validatedData['lokasi'],
                'alamat' => $validatedData['alamat'],
                'menghadiri' => $validatedData['menghadiri'],
            ]);
            return redirect()->route('kalender.index')->with('sukses','agenda berhasil diubah');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('kalender.index')->with('gagal','terjadi kesalahan');
        }
    }
    public function show(){
        $data = agenda::orderBy('created_at', 'desc')->get();
        return view('kalender.show')->with('data', $data);
    }
    public function destroy($id){
        try {
            $data = agenda::findOrFail($id);
            $data->delete();
            return redirect()->route('kalender.index')->with('sukses', 'agenda berhasil dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('gagal', 'terjadi kesalahan');
        }
    }
}

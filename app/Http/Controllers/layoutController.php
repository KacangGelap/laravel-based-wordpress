<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\layout;
class layoutController extends Controller
{
    public function index(){
        $layout = layout::all();
        return view('template.index')->with('layout', $layout);
    }

    public function create(){
        return view('template.create');
    }
    
    public function store(Request $request){
        $validated = $request->validate([
            'media' =>  'nullable|max:2000|mimes:png,jpg|image',
            'text'  =>  'nullable|string|', //sanitasi input utk medsos dan gmaps
            'type'  =>  'required|string|in:logo-pemkot,logo,banner,carousel-1,carousel-2,carousel-3,carousel-4,carousel-5,maps,alamat,facebook,instagram,youtube,email,telp|unique:layout',
        ]);
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

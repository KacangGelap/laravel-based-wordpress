<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\layout;
class formController extends Controller
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
            'media' => 'required|max:2000|mimes:png,jpg|image',
            'type' => 'required|string|in:banner,carousel-1,carousel-2,carousel-3',
        ]);
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

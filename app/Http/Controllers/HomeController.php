<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\logs;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $log = logs::latest()->first();
        return view('home')->with('log',$log);
    }
}

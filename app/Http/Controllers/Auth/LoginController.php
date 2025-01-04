<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    public function authenticate(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => 'required|captcha',
        ],['validation.captcha' => 'Captcha tidak valid']);
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:8',
        ]);
        try {
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    return redirect()->route('home');
                  }
                  else{
                      return back()->withErrors([
                          'username' => 'Kredensial yang anda miliki tidak ditemukan, pastikan nama username dan kata sandi sesuai.',
                      ])->onlyInput('username');
                  }
            }
          }
        catch (\Throwable $th) {
            throw $th;
        }
    }
}

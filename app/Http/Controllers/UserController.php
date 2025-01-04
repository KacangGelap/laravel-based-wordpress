<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use Image;
class UserController extends Controller
{
    public function index(){
        $user = User::all();
        return view('user.index')->with('user', $user);
    }

    public function create(){
        return view('user.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'      =>  'required|string|max:25',
            'no_hp'     =>  'nullable|numeric|digits_between:11,13',
            'username'  =>  'required|string|unique:users',
            'opd'       =>  'required|string|in:Diskominfo,
                            Korpri,Pkk,Setda,Setwan,Itda,DIsdikbud,Dinkes,Dpupr,
                            Dpkpp,Dpkp,Dspm,Dpmptsp,Disnaker,Dlh,Disdukcapil,
                            Dishub,Disporapar,Dkukmp,Dpk,Dkppp,Dppkb,Satpol PP,
                            Bkpsdm,Bapperinda,Bapenda,Bpkad,Bakesbangpol,Bpbd,
                            Rsud,Ukpbj,Puskesmas Bontang Selatan 1,Puskesmas Bontang Selatan 2,
                            Puskesmas Bontang Utara 1,Puskesmas Bontang Utara 2,Puskesmas Bontang Barat,
                            Puskesmas Bontang Lestari,Laboratorium Kesehatan,Kec-Bontang Barat,Kec-Bontang Utara,
                            Kec-Bontang Selatan,Kel-Kanaan,Kel-Belimbing,Kel-Gunung Telihan,Kel-Bontang Baru,
                            Kel-Api-Api,Kel-Gunung Elai,Kel-Guntung,Kel-Loktuan,Kel-Tanjung Laut,Kel-Tanjung Laut Indah,Kel-Berbas Tengah,
                            Kel-Berbas Pantai,Kel-Satimpo,Kel-Bontang Lestari',
            'password'  =>  'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_\-.])[A-Za-z\d@$!%*?&_\-.]+$/'
        ],[
            'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character (@, $, !, %, *, ?, &, _, -, .).',
        ]);
        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->no_hp = $request->input('no_hp');
            $user->opd = $request->input('opd');
            $user->password = Hash::make($request->input('password'));
            dd($user);
            $user->save();
        } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('gagal','data gagal ditambah');
        }
        return redirect()->route('user.index')->with('sukses','data berhasil ditambah');
    }

    public function edit(string $id){
        $user = User::findOrFail($id);
        return view('user.edit')->with('user', $user);
    }

    public function update(Request $request, string $id){
        $user = User::findOrFail($id);
        $isEmailChanged = $user->email !== $request->input('email');

        $rules = [
            'profile'  => 'nullable|image|mimes:jpg,png|max:2000',
            'no_hp'    => 'nullable|numeric|digits_between:11,13',
            'name'     => 'string|max:25',
            'password' => 'nullable|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_\-.])[A-Za-z\d@$!%*?&_\-.]+$/',
        ];

        $messages = [
            'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character (@, $, !, %, *, ?, &, _, -, .).',
        ];

        if ($isEmailChanged) {
            $rules['email'] = 'string|email|unique:users';
        } else {
            $rules['email'] = 'string|email';
        }

        // Validate the request
        $request->validate($rules, $messages);

        try {
            // Handle the profile image if it exists
            if ($request->hasFile('profile')) {
                $image = $request->file('profile');

                $img = Image::make($image->getPathname());
                $img->resize(200, 200);
                $base64Image = 'data:image/jpg;charset:utf8;base64,' . base64_encode($img->encode());
                $user->profile = $base64Image;
            }

            // Update the user data
            $user->update([
                'name'     => $request->input('name', $user->name),
                'no_hp'    => $request->input('no_hp', $user->no_hp),
                'email'    => $isEmailChanged ? $request->input('email') : $user->email,
                'password' => $request->has('password') ? Hash::make($request->input('password')) : $user->password,
            ]);

            return redirect()->route('user.show', $user->id)->with('sukses', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->route('user.show', $id)->with('gagal', 'Data gagal diubah');
        }
    }

    public function destroy(Request $request, string $id){
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('gagal','terjadi kesalahan');
        }
        return redirect()->route('user.index')->with('sukses','data berhasil dihapus');
    }

    public function show(string $id){
        try {
            $user = User::findOrFail($id);
            return view('user.show')->with('user', $user);
        } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('gagal','terjadi kesalahan');
        }
    }

    public function update_profile(Request $request, string $id){
        $user = User::findOrFail($id);
        $isEmailChanged = $user->email !== $request->input('email');
        $rules = [
            'profile'  => 'nullable|image|mimes:jpg,png|max:2000',
            'no_hp'    => 'nullable|numeric|digits_between:11,13',
            'name'     => 'string|max:25',
            'password' => 'nullable|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_\-.])[A-Za-z\d@$!%*?&_\-.]+$/',
        ];

        $messages = [
            'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character (@, $, !, %, *, ?, &, _, -, .).',
        ];

        if ($isEmailChanged) {
            $rules['email'] = 'string|email|unique:users';
        } else {
            $rules['email'] = 'string|email';
        }

        // Validate the request
        $request->validate($rules, $messages);

        try {
            // Handle the profile image if it exists
            if ($request->hasFile('profile')) {
                $image = $request->file('profile');

                // Use Intervention Image to process the image
                $img = Image::make($image->getPathname());
                $img->resize(200, 200);
                $base64Image = 'data:image/jpg;charset:utf8;base64,' . base64_encode($img->encode());   
                $user->profile = $base64Image;
            }

            // Update the user data
            $user->update([
                'name'     => $request->input('name', $user->name),
                'no_hp'    => $request->input('no_hp', $user->no_hp),
                'email'    => $isEmailChanged ? $request->input('email') : $user->email,
                'password' => $request->has('password') ? Hash::make($request->input('password')) : $user->password,
            ]);

            return redirect()->route('user.profile', $user->id)->with('sukses', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->route('user.profile', $id)->with('gagal', 'Data gagal diubah');
        }
    }

}

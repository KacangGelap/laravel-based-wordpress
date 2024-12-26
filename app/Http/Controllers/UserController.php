<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\Models\User;
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
            'email'     =>  'required|string|email|unique:users',
            'password'  =>  'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_\-.])[A-Za-z\d@$!%*?&_\-.]+$/'
        ],[
            'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character (@, $, !, %, *, ?, &, _, -, .).',
        ]);
        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            // dd($user);
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
        try {
            $user = User::findOrFail($id);
            $isEmailChanged = $user->email !== $request->input('email');
            $rules = [
                'profile'  => 'required|image|mimes:jpg,png|max:2000',
                'no_hp'    => 'nullable|numeric|digits_between:11,13',
                'name'     => 'string|max:25',
                'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_\-.])[A-Za-z\d@$!%*?&_\-.]+$/',
            ];
            $messages = [
                'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character (@, $, !, %, *, ?, &, _, -, .).',
            ];
            if ($isEmailChanged) {
                $rules['email'] = 'string|email|unique:users';
            } else {
                $rules['email'] = 'string|email';
            }

            $request->validate($rules, $messages);

            // Update user data
            $user->update([
                'profile'  => $request->has('profile') ? 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('profile'))) : $user->profile,
                'name'     => $request->has('name') ? $request->input('name') : $user->name,
                'no_hp'    => $request->has('no_hp') ? $request->input('no_hp') : $user->no_hp,
                'email'    => $isEmailChanged ? $request->input('email') : $user->email,
                'password' => $request->has('password') ? Hash::make($request->input('password')) : $user->password,
            ]);

            return redirect()->route('user.profile', $user->id)->with('sukses', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->route('user.profile', $id)->with('gagal', 'Data gagal diubah');
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
        try {
            $user = User::findOrFail($id);
            $isEmailChanged = $user->email !== $request->input('email');
            $rules = [
                'profile'  => 'required|image|mimes:jpg,png|max:2000',
                'no_hp'    => 'nullable|numeric|digits_between:11,13',
                'name'     => 'string|max:25',
                'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_\-.])[A-Za-z\d@$!%*?&_\-.]+$/',
            ];
            $messages = [
                'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character (@, $, !, %, *, ?, &, _, -, .).',
            ];
            if ($isEmailChanged) {
                $rules['email'] = 'string|email|unique:users';
            } else {
                $rules['email'] = 'string|email';
            }

            $request->validate($rules, $messages);

            // Update user data
            $user->update([
                'profile'  => $request->has('profile') ? 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('profile'))) : $user->profile,
                'name'     => $request->has('name') ? $request->input('name') : $user->name,
                'no_hp'    => $request->has('no_hp') ? $request->input('no_hp') : $user->no_hp,
                'email'    => $isEmailChanged ? $request->input('email') : $user->email,
                'password' => $request->has('password') ? Hash::make($request->input('password')) : $user->password,
            ]);

            return redirect()->route('user.profile', $user->id)->with('sukses', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return redirect()->route('user.profile', $id)->with('gagal', 'Data gagal diubah');
        }
    }

}

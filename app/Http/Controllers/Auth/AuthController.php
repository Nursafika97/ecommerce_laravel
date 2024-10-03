<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:dns',
            'password' => 'required|min:8|max:15'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            Alert::error('Error', 'Pastikan semua email dan password terisi dengan benar!');
            return redirect()->back()->withErrors($validator)->withInput(); // Add this line to redirect back with input
        }

        // Attempt to log in as admin
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            toast('Selamat datang admin!', 'success');
            return redirect()->route('admin.dashboard');
        } 
        // Attempt to log in as user
        elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            toast('Selamat datang!', 'success');
            return redirect()->route('user.dashboard');
        } 
        // If login fails
        else {
            Alert::error('Login Gagal!', 'Email atau password tidak valid!');
            return redirect()->back()->withInput(); // Add this line to redirect back with input
        }
    }

    public function admin_logout() {
        Auth::guard('admin')->logout();
        toast('Berhasil logout!', 'success');
        return redirect('/');
    }

    public function user_logout() {
        Auth::logout();
        toast('Berhasil logout!', 'success');
        return redirect('/');
    }

    // untuk register
    public function register()
    {
        return view(register);
    }
    public function post_register(Request $request)
    {
        $validator = Validator ::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email.dns',
            'password' => 'required|min:8|max:8',
        ]);

        if ($Validator -> fails()){
            Alert :: error('GAgal!', 'Pastikan semua terisi dengan benar');
            return redirect()-> back();
        }

        $user = User:: create([
            'name' => $request->name,
            'email' =>$request->email,
            'password'=> bcrypt($request->password),
            'point' => 10000,
        ]);
        if($user){
            Alert::succes('Berhasil!', 'Akun baru berhasil dibuat, silahkan melakukan login!');
            return redirect('/');
        } else{
            Alert::error('Gagal!','Akun gagal dibuat, silahkan coba lagi!');
            return redirect()->back();
        }
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Models\User; // Ensure you import the User model

class AuthController extends Controller
{
    // Login method
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:dns',
            'password' => 'required|min:8|max:15',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Pastikan semua email dan password terisi dengan benar!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            toast('Selamat datang admin!', 'success');
            return redirect()->route('admin.dashboard');
        } elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            toast('Selamat datang!', 'success');
            return redirect()->route('user.dashboard');
        } else {
            Alert::error('Login Gagal!', 'Email atau password tidak valid!');
            return redirect()->back()->withInput();
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

    // Register method
    public function register()
    {
        return view('register'); // Corrected view name wrapped in quotes
    }

    // Post register method
    public function post_register(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required|min:8|max:15', // Fixed validation rule to allow passwords up to 15 characters
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pastikan semua terisi dengan benar!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'point' => 10000, // Default points
        ]);

        // Check if user creation is successful
        if ($user) {
            Alert::success('Berhasil!', 'Akun baru berhasil dibuat, silahkan login!');
            return redirect('/');
        } else {
            Alert::error('Gagal!', 'Akun gagal dibuat, silahkan coba lagi!');
            return redirect()->back()->withInput();
        }
    }
}
<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        // return view('/home');
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // dd($request->all());
    
        $email = $request->input('email'); 
        $password = Hash::make('password');
        // // $password = Hash::make($plainPassword); // Hash kata sandi yang dimasukkan
    
        // // Mengambil kredensial user dari database berdasarkan email
        $user = DB::table('users')
            ->where('email', $email)
            ->first();
        $user = Auth::user();
            
            if ($user->email == $email) {
                // Jika kredensial cocok, maka login berhasil
                // Lakukan sesuatu setelah login berhasil, seperti menyimpan data ke sesi atau melakukan redirect ke halaman lain
                Auth::login($user);
                return "oke";
                // return redirect('home')->with('status', 'User berhasil login!');
            } else {
                return "tetot";
                // Jika kredensial tidak cocok, redirect dengan pesan error
                // return redirect('login')->with('status', 'Gagal login: Email atau password tidak valid.');
        }
    
    }
    
}
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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $email = $request->input('email');
        $password = $request->input('password');
    
        //Mengambil kredensial user dari database berdasarkan email
        $user = DB::table('users')
            ->where('email', $email)
            ->first();
        
            return redirect('home')->with('status', 'User berhasil login!');

        if ($request->email == $user->email && $request->password == $user->password) {
            // // Jika kredensial cocok, maka login berhasil
            // Lakukan sesuatu setelah login berhasil
            return redirect('home')->with('status', 'User berhasil login!');
        } else {
            // Jika kredensial tidak cocok, redirect dengan pesan error
            return redirect('login')->with('status', 'User berhasil login!');
        }
    }
}

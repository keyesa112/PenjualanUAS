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
    
        $user = User::where('email', $email)->first();
    
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            if ($user->idrole === 1) { //admin
                return redirect('/home')->with('status', 'User berhasil login!');
            } elseif ($user->idrole === 2) { //kasir
                return redirect('/home-kasir')->with('status', 'User berhasil login!');
            }
            // return redirect('/home')->with('status', 'User berhasil login!');
        } else {
            return redirect('/')->with('status', 'Gagal login: Email atau password tidak valid.');
        }
        }

    public function logout(Request $request)
    {
        Auth::logout(); // Log the user out
        return redirect('/'); // Redirect to login page or any other desired page after logout
    }
    
}
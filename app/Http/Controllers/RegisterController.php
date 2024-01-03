<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $roles = DB::select('SELECT *
                FROM roles
                WHERE deleted_at is NULL');
        return view('auth/register', compact('roles'));
    }

    public function register(Request $request)
    {
    /**
     * Store a newly created resource in storage.
     */

        $idUsers = $request->id;
        $username = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password); // Hash the password
        $idRole = $request->idRole;

        // Execute the query to insert a new record with the hashed password
        DB::insert("INSERT INTO users (iduser, username, email, password, idrole) 
                VALUES (?, ?, ?, ?, ?)", [$idUsers, $username, $email, $password, $idRole]);

        return redirect('/signup')->with('status', 'User berhasil ditambahkan!');
    }
}

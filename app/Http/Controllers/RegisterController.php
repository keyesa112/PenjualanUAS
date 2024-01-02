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
    
        //native
        $idUsers = $request->id;
        $username = $request->name;
        $email = $request->email;
        $password = $request->password;
        $idRole = $request->idRole;

        // Execute the native SQL query to insert a new record
        DB::insert("INSERT INTO users (id_users, username, email, password, idRole) 
                VALUES (?, ?, ?, ?, ?)", [$idUsers, $username, $email, $password, $idRole]);

        return redirect('home')->with('status', 'User berhasil ditambahkan!');
    }
}

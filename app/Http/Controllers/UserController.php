<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $users = DB::table('users')
        //         ->whereNotNull('deleted_at')
        //         ->get();

        // $users = User::with('role') ->get();
        
        //native
        $users = DB::table('users')
                ->select('users.*', 'roles.nama_role')
                ->join('roles', 'users.idrole', '=', 'roles.idrole')
                ->whereNull('users.deleted_at')
                ->get();
            
        return view('users/index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $roles = DB::table('roles')->get(); // Mengambil semua peran dari tabel roles

        //native
        $roles = DB::select('SELECT *
                FROM roles');
        $users = DB::table('users')->get();       
        return view('users.create', compact('roles','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        // DB::table('users')->insert([
        //     'iduser' => $request -> id,
        //     'username' => $request -> name,
        //     'email' => $request -> email,
        //     'password' => $request -> password,
        //     'idRole' => $request -> idRole
        // ]);

        //native
        $idUsers = $request->id;
        $username = $request->name;
        $email = $request->email;
        $password = $request->password;
        $idRole = $request->idRole;

        // Execute the native SQL query to insert a new record
        DB::insert("INSERT INTO users (iduser, username, email, password, idRole) 
                VALUES (?, ?, ?, ?, ?)", [$idUsers, $username, $email, $password, $idRole]);

        return redirect('user')->with('status', 'User berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $users = User::where('iduser', $id)->get();
        $users = $users[0];
        $roles = DB::select('SELECT *
            FROM roles');
        // return $users;
        return view('users/show', compact('users','roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $roles = DB::table('roles')->get();
        $users = DB::table('users')->where('iduser', $id)->first();
        return view('users/edit', compact('users','roles'));    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $users = DB::table('users')
        // ->update([
        //     'username' => $request -> name,
        //     'email' => $request -> email,
        //     'password' => $request -> password,
        //     'idRole' => $request -> idRole 
        // ]);

         //native
            DB::update('UPDATE users SET username = ?, email = ?, password = ?, idRole = ? WHERE iduser = ?', [
                $request->name,
                $request->email,
                $request->password,
                $request->idRole,
                $id
            ]);

        return redirect('user')->with('status', 'User berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('users')
            ->where('iduser', $id)
            ->update(['deleted_at' => now()]);

        $records = DB::table('users')
            ->whereNull('deleted_at')
            ->get();

        return redirect('user')->with('status', 'User berhasil dihapus!');
    }
}

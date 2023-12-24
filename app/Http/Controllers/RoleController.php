<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function data()
    {
        //menampilkan data
        // // $role = DB::table('roles')
        //     ->whereNotNull('deleted_at')
        //     ->get();

        //native
        $role = DB::select('SELECT *
                            FROM roles
                            WHERE deleted_at is NULL');

       // return $role;
        return view('role.data', ['role' => $role]);
    }

    public function add()
    {
        return view('role.add');
    }

    public function addProcess(Request $request)
    {
        // DB::table('roles')->insert([
        //     'idrole' => $request -> id,
        //     'nama_role' => $request -> name
        // ]);

        //native
        $idRole = $request->id;
        $namaRole = $request->name;

        // Execute the native SQL query to insert data
        DB::insert("INSERT INTO roles (idrole, nama_role) 
                    VALUES (?, ?)", [$idRole, $namaRole]);

        return redirect('role')->with('status', 'Role berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $role = DB::table('roles')
                ->where('idrole', $id)
                ->first();
                // $role = DB::select("SELECT * FROM roles WHERE idrole = ?", [$id]);
        return view('role/edit', compact('role'));
    }


    public function editProcess(Request $request, $id)
    {
        // $role = DB::table('roles')->where('idrole', $id)
        //         ->update([
        //         'nama_role' => $request -> name  
        // ]);

        //native
    

        // Execute the native SQL query to update the record
        DB::update("UPDATE roles SET nama_role = ? 
                    WHERE idrole = ?", [$request->name, $id]);

        return redirect('role')->with('status', 'Role berhasil diubah!');
    }

    public function delete($id)
    {
        DB::table('roles')
            ->where('idrole', $id)
            ->update(['deleted_at' => now()]);

        $records = DB::table('roles')
            ->whereNull('deleted_at')
            ->get();

        return redirect('role')->with('status', 'Role berhasil dihapus!');

        //querynative
    //     $pdo = DB::connection()->getPdo();

    // // Execute a raw SQL query to update the 'deleted_at' field
    // $sql = "UPDATE roles SET deleted_at = :deleted_at WHERE idrole = :id";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([
    //     'deleted_at' => now(),
    //     'id' => $id,
    // ]);

    // // Execute a raw SQL query to select records where 'deleted_at' is NULL
    // $sql = "SELECT * FROM roles WHERE deleted_at IS NULL";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute();

    // // Fetch the records
    // $records = $stmt->fetchAll(PDO::FETCH_OBJ);

    // return redirect('role')->with('status', 'Role berhasil dihapus!');
    }

    public function show($id)
    {
        $role = DB::table('roles')->where('idrole', $id)->first();
        // return $users;
        return view('role/show', compact('role'));

    }
}

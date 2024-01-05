<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PenerimaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penerimaan = DB::select('SELECT *
            FROM penerimaan
            WHERE deleted_at is NULL');    

        $penerimaan = DB::table('penerimaan')
            ->select('penerimaan.*', 'pengadaan.timestamp', 'users.username')
            ->join('pengadaan', 'penerimaan.idpengadaan', '=', 'pengadaan.idpengadaan')
            ->join('users', 'penerimaan.iduser', '=', 'users.iduser')
            ->whereNull('penerimaan.deleted_at')
            ->get();

        return view('penerimaan.index', compact('penerimaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengadaan = DB::select('SELECT *
            FROM pengadaan');// Mengambil semua peran dari tabel vendor
        $users = DB::select('SELECT *
            FROM users');// Mengambil semua peran dari tabel vendor
        return view('penerimaan.create', compact('pengadaan', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){

        $created_at = $request->timestamp;
        $status = $request->status;
        $pengadaan = $request->idpengadaan;
        $users = $request->filterUser;

        // Execute the native SQL query to insert a new record
        DB::insert("INSERT INTO penerimaan (created_at, status, idpengadaan, iduser) 
                VALUES (?, ?, ?, ?)", [$created_at, $status, $pengadaan, $users]);

        return redirect('detpenerimaan/create')->with('status', 'Penerimaan barang berlangsung!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idpenerimaan)
    {
        $penerimaan = DB::table('penerimaan')->where('idpenerimaan', $idpenerimaan)->first();
        
        // return $users;
        return view('penerimaan/show', compact('penerimaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $idpenerimaan)
    {
        $pengadaan = DB::select('SELECT *
            FROM pengadaan');// Mengambil semua peran dari tabel vendor
        $users = DB::select('SELECT *
            FROM users');// Mengambil semua peran dari tabel vendor
        $penerimaan = DB::table('penerimaan')->where('idpenerimaan', $idpenerimaan)->first();
        return view('penerimaan.edit', compact('pengadaan', 'users', 'penerimaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idpenerimaan)
    {
        DB::update('UPDATE penerimaan SET created_at = ?, status = ?, idpengadaan = ?,iduser = ?
        WHERE idpenerimaan = ?', [
            $request->timestamp,
            $request->status,
            $request->idpengadaan,
            $request->filterUser,
            $idpenerimaan
        ]);

        return redirect('penerimaan')->with('status', 'Penerimaan berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idpenerimaan)
    {
        DB::table('penerimaan')
        ->where('idpenerimaan', $idpenerimaan) // Assuming 'idpenerimaan' is the correct column name
        ->update(['deleted_at' => now()]);

    $records = DB::table('penerimaan')
        ->whereNull('deleted_at')
        ->get();


        return redirect('penerimaan')->with('status', 'Penerimaan berhasil dihapus!');
    }
}

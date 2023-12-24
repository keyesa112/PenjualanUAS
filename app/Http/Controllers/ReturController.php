<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $retur = DB::select('SELECT *
            FROM retur
            WHERE deleted_at is NULL');    

        $retur = DB::table('retur')
            ->select('retur.*', 'penerimaan.created_at as timestamp', 'users.username')
            ->join('penerimaan', 'retur.idpenerimaan', '=', 'penerimaan.idpenerimaan')
            ->join('users', 'retur.iduser', '=', 'users.iduser')
            ->whereNull('retur.deleted_at')
            ->get();

        return view('retur.index', compact('retur'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penerimaan = DB::select('SELECT *
            FROM penerimaan');// Mengambil semua peran dari tabel vendor
        $users = DB::select('SELECT *
            FROM users');// Mengambil semua peran dari tabel vendor
        return view('retur.create', compact('penerimaan', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $created_at = $request->timestamp;
        $penerimaan = $request->idpenerimaan;
        $users = $request->filterUser;

        // Execute the native SQL query to insert a new record
        DB::insert("INSERT INTO retur (created_at, idpenerimaan, iduser) 
                VALUES (?, ?, ?)", [$created_at, $penerimaan, $users]);

        return redirect('retur')->with('status', 'Retur berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idretur)
    {
        $retur = DB::table('retur')->where('idretur', $idretur)->first();
        
        // return $users;
        return view('retur/show', compact('retur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $idretur)
    {
        $penerimaan = DB::select('SELECT *
            FROM penerimaan');// Mengambil semua peran dari tabel vendor
        $users = DB::select('SELECT *
            FROM users');// Mengambil semua peran dari tabel vendor
        $retur = DB::table('retur')->where('idretur', $idretur)->first();
        return view('retur.edit', compact('retur', 'users', 'penerimaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idretur)
    {
        DB::update('UPDATE retur SET created_at = ?, idpenerimaan = ?, iduser = ?
        WHERE idretur = ?', [
            $request->timestamp,
            $request->idpengadaan,
            $request->filterUser,
            $idretur
        ]);

        return redirect('retur')->with('status', 'Retur berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idretur)
    {
        DB::table('retur')
        ->where('retur', $idretur)
        ->update(['deleted_at' => now()]);

        $records = DB::table('retur')
            ->whereNull('deleted_at')
            ->get();

        return redirect('retur')->with('status', 'Retur berhasil dihapus!');
    }
}

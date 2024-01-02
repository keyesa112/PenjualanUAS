<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MarginPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $margin = DB::select('SELECT *
            FROM margin_penjualan
            WHERE deleted_at is NULL');    

        $margin = DB::table('margin_penjualan')
            ->select('margin_penjualan.*', 'users.username')
            ->join('users', 'margin_penjualan.iduser', '=', 'users.iduser')
            ->whereNull('margin_penjualan.deleted_at')
            ->get();

        return view('penjualan.margin.index', compact('margin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = DB::select('SELECT *
            FROM users');// Mengambil semua peran dari tabel vendor
        return view('penjualan.margin.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $created_at = $request->timestamp;
        $persen = $request->persen;
        $status = $request->status;
        $users = $request->filterUser;
        $updated_at = $request->timestamp2;

        // Execute the native SQL query to insert a new record
        DB::insert("INSERT INTO margin_penjualan (created_at, persen, status, iduser, updated_at) 
                VALUES (?, ?, ?, ?, ?)", [$created_at, $persen, $status, $users, $updated_at]);

        return redirect('margin')->with('status', 'Margin berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idmargin_penjualan)
    {
        $margin = DB::table('margin_penjualan')->where('idmargin_penjualan', $idmargin_penjualan)->first();
        
        // return $users;
        return view('penjualan.margin.show', compact('margin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $idmargin_penjualan)
    {   
        $users = DB::select('SELECT *
            FROM users');// Mengambil semua peran dari tabel vendor

        $margin = DB::table('margin_penjualan')->where('idmargin_penjualan', $idmargin_penjualan)->first();
        return view('penjualan.margin.edit', compact('margin', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idmargin_penjualan)
    {
        DB::update('UPDATE margin_penjualan SET created_at = ?, persen = ?, status= ?, iduser = ?, updated_at = ?
        WHERE idmargin_penjualan = ?', [
            $request->timestamp, 
            $request->persen,
            $request->status,
            $request->filterUser,
            $request->timestamp2,
            $idmargin_penjualan
        ]);

        return redirect('margin')->with('status', 'Margin berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

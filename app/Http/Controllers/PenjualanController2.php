<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PenjualanController2 extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $penjualan = DB::select('SELECT *
        //     FROM penjualan
        //     WHERE deleted_at is NULL');    

        // $penjualan = DB::table('penjualan')
        //         ->select('penjualan.*', 'users.username', 'margin_penjualan.persen')
        //         ->join('users', 'penjualan.iduser', '=', 'users.iduser')
        //         ->join('margin_penjualan', 'penjualan.idmargin_penjualan', '=', 'margin_penjualan.idmargin_penjualan')
        //         ->whereNull('penjualan.deleted_at')
        //         ->get();

            // return view('penjualan-kasir.index', compact('penjualan'));
        
            $penjualan = DB::select('SELECT * FROM info_penjualan'); // Sesuaikan query dengan kebutuhan

            // Kirim data ke view
            return view('penjualan-kasir.index', ['penjualan' => $penjualan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $margin = DB::select('SELECT *
                FROM margin_penjualan');// Mengambil semua peran dari tabel vendor
        $users = DB::select('SELECT *
                FROM users');// Mengambil semua peran dari tabel vendor
        return view('penjualan-kasir.create', compact('margin', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $created_at = $request->timestamp;
        $subtotal = $request->subtotal;
        $ppn = $request->ppn;
        $total = $request->total;
        $margin = $request->persen;
        $users = $request->filterUser;

        // Execute the native SQL query to insert a new record
        DB::insert("INSERT INTO penjualan (created_at, subtotal_nilai, ppn, total_nilai, idmargin_penjualan, iduser) 
                VALUES (?, ?, ?, ?, ?, ?)", [$created_at, $subtotal, $ppn, $total, $margin, $users]);

        return redirect('detpenjualan-kasir/create')->with('status', 'Transaksi Penjualan Berlangsung!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idpenjualan)
    {
        $penjualan = DB::table('penjualan')->where('idpenjualan', $idpenjualan)->first();
        return view('penjualan-kasir.show', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $idpenjualan)
    {
        $penjualan = DB::table('penjualan')->where('idpenjualan', $idpenjualan)->first();
        $margin = DB::select('SELECT *
                FROM margin_penjualan');// Mengambil semua peran dari tabel vendor
        $users = DB::select('SELECT *
                FROM users');// Mengambil semua peran dari tabel vendor
        return view('penjualan-kasir.edit', compact('margin', 'users','penjualan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idpenjualan)
    {
        
        DB::update('UPDATE penjualan SET created_at = ?, subtotal_nilai = ?,ppn = ?, total_nilai = ?, idmargin_penjualan = ?, iduser = ?
        WHERE idpenjualan = ?', [
            $request->timestamp,
            $request->subtotal,
            $request->ppn,
            $request->total,
            $request->persen,
            $request->filterUser,
            $idpenjualan
        ]);

        return redirect('penjualan-kasir')->with('status', 'Penjualan berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idpenjualan)
    {
        DB::table('penjualan')
        ->where('idpenjualan', $idpenjualan)
        ->update(['deleted_at' => now()]);

        $records = DB::table('penjualan')
            ->whereNull('deleted_at')
            ->get();

        return redirect('penjualan-kasir')->with('status', 'penjualan berhasil dihapus!');
    }
}

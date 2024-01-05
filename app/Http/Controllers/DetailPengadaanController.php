<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\DetailPengadaan;
use Illuminate\Http\Request;

class DetailPengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengadaan2 = DB::select('SELECT *
            FROM detail_pengadaan
            WHERE deleted_at is NULL');   

        $pengadaan2 = DB::table('detail_pengadaan')
                    ->select('detail_pengadaan.*', 'barang.nama')
                    ->join('barang', 'detail_pengadaan.barang_idbarang', '=', 'barang.idbarang')
                    ->whereNull('detail_pengadaan.deleted_at')
                    ->get();

        return view('pengadaan.det_pengadaan.index', compact('pengadaan2'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = DB::select('SELECT *
                FROM barang');// Mengambil semua peran dari tabel vendor
        $pengadaan = DB::select('SELECT *
                FROM pengadaan');// Mengambil semua peran dari tabel vendor
        return view('pengadaan.det_pengadaan.create', compact('barangs', 'pengadaan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $barangs = $request->idBarang;
        $harga = $request->subtotal;
        $jumlah = $request->ppn;
        $subtotal = $request->total;
        $pengadaan = $request->idpengadaan;

        // Execute the native SQL query to insert a new record
        DB::insert("INSERT INTO detail_pengadaan (barang_idbarang, harga_satuan, jumlah, sub_total, pengadaan_idpengadaan) 
                VALUES (?, ?, ?, ?, ?)", [$barangs, $harga, $jumlah, $subtotal, $pengadaan]);

        $idpengadaan = $request->idpengadaan; // Assuming you have the ID of the pengadaan

        // Call the stored procedure using DB::statement
        DB::statement("CALL UpdateTotalPengadaan($idpengadaan)");

        return redirect('detpengadaan/create')->with('status', 'Barang berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $iddetail_pengadaan)
    {
        $detpengadaan = DB::table('detail_pengadaan')->where('iddetail_pengadaan', $iddetail_pengadaan)->first();
        
        // return $users;
        return view('pengadaan.det_pengadaan.show', compact('detpengadaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $iddetail_pengadaan)
    {
        $pengadaan = DB::select('SELECT *
            FROM pengadaan');// Mengambil semua peran dari tabel vendor
        $barangs = DB::select('SELECT *
            FROM barang');// Mengambil semua peran dari tabel vendor
        $detpengadaan = DB::table('detail_pengadaan')->where('iddetail_pengadaan', $iddetail_pengadaan)->first();
        return view('pengadaan.det_pengadaan.edit', compact('pengadaan', 'barangs', 'detpengadaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $iddetail_pengadaan)
    {
        DB::update('UPDATE detail_pengadaan SET barang_idbarang = ?, harga_satuan = ?, jumlah= ?, sub_total = ?, pengadaan_idpengadaan = ?
        WHERE iddetail_pengadaan = ?', [
            $request->idBarang, 
            $request->subtotal,
            $request->ppn,
            $request->total,
            $request->idpengadaan,
            $iddetail_pengadaan
        ]);

        return redirect('detpengadaan')->with('status', 'Pengadaan berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $iddetail_pengadaan)
    {
            DB::table('detail_pengadaan')
            ->where('iddetail_pengadaan', $iddetail_pengadaan)
            ->update(['deleted_at' => now()]);
    
        $records = DB::table('detail_pengadaan')
            ->whereNull('deleted_at')
            ->get();
    
        return redirect('detpengadaan')->with('status', 'Pengadaan berhasil dihapus!');
    }
}

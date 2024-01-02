<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DetailPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detpenjualan = DB::select('SELECT *
            FROM detail_penjualan
            WHERE deleted_at is NULL');   

        $detpenjualan = DB::table('detail_penjualan')
                    ->select('detail_penjualan.*', 'barang.nama','penjualan.created_at')
                    ->join('barang', 'detail_penjualan.idbarang', '=', 'barang.idbarang')
                    ->join('penjualan', 'detail_penjualan.penjualan_idpenjualan', '=', 'penjualan.idpenjualan')
                    ->whereNull('detail_penjualan.deleted_at')
                    ->get();

        return view('penjualan.det_penjualan.index', compact('detpenjualan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = DB::select('SELECT *
                FROM barang');// Mengambil semua peran dari tabel vendor
        $penjualan = DB::select('SELECT *
                FROM penjualan');// Mengambil semua peran dari tabel vendor
        return view('penjualan.det_penjualan.create', compact('barangs', 'penjualan'));
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
        $penjualan = $request->idpenjualan;

        // Execute the native SQL query to insert a new record
        DB::insert("INSERT INTO detail_penjualan (idbarang, harga_satuan, jumlah, subtotal, penjualan_idpenjualan) 
                VALUES (?, ?, ?, ?, ?)", [$barangs, $harga, $jumlah, $subtotal, $penjualan]);

        return redirect('detpenjualan')->with('status', 'Detail penjualan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $iddetail_penjualan)
    {
        $detpenjualan = DB::table('detail_penjualan')->where('iddetail_penjualan', $iddetail_penjualan)->first();
        
        // return $users;
        return view('penjualan.det_penjualan.show', compact('detpenjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $iddetail_penjualan)
    {
        $penjualan = DB::select('SELECT *
            FROM penjualan');// Mengambil semua peran dari tabel vendor
        $barangs = DB::select('SELECT *
            FROM barang');// Mengambil semua peran dari tabel vendor
        $detpenjualan = DB::table('detail_penjualan')->where('iddetail_penjualan', $iddetail_penjualan)->first();
        return view('penjualan.det_penjualan.edit', compact('penjualan', 'barangs', 'detpenjualan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $iddetail_penjualan)
    {
        DB::update('UPDATE detail_penjualan SET idbarang = ?, penjualan_idpenjualan = ?, harga_satuan = ?, jumlah = ?, subtotal = ?
        WHERE iddetail_penjualan = ?', [
            $request->idBarang, 
            $request->idpenjualan,
            $request->subtotal,
            $request->ppn,
            $request->total,
            $iddetail_penjualan
        ]);

        return redirect('detpenjualan')->with('status', 'Detail penjualan berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $iddetail_penjualan)
    {
        DB::table('detail_penjualan')
            ->where('iddetail_penjualan', $iddetail_penjualan)
            ->update(['deleted_at' => now()]);
    
        $records = DB::table('detail_penjualan')
            ->whereNull('deleted_at')
            ->get();
    
        return redirect('detpenjualan')->with('status', 'Detail penjualan berhasil dihapus!');
    }
}

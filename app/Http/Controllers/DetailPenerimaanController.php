<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DetailPenerimaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detpenerimaan = DB::select('SELECT *
            FROM detail_penerimaan
            WHERE deleted_at is NULL');   

        $detpenerimaan = DB::table('detail_penerimaan')
                    ->select('detail_penerimaan.*', 'penerimaan.created_at','barang.nama')
                    ->join('penerimaan', 'detail_penerimaan.idpenerimaan', '=', 'penerimaan.idpenerimaan')
                    ->join('barang', 'detail_penerimaan.barang_idbarang', '=', 'barang.idbarang')
                    ->whereNull('detail_penerimaan.deleted_at')
                    ->get();

        return view('penerimaan.det_penerimaan.index', compact('detpenerimaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = DB::select('SELECT *
                 FROM barang');// Mengambil semua peran dari tabel vendor
        $penerimaan = DB::select('SELECT *
                FROM penerimaan');// Mengambil semua peran dari tabel vendor
        return view('penerimaan.det_penerimaan.create', compact('barangs', 'penerimaan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $barangs = $request->idBarang;
        $penerimaan = $request->idpenerimaan;
        $harga = $request->subtotal;
        $jumlah = $request->ppn;
        $subtotalResult = DB::select("SELECT calculate_subtotal(:price, :quantity) as subtotal", [
            'price' => $harga,
            'quantity' => $jumlah,
        ]);
        
        $subtotal = $subtotalResult[0]->subtotal;

        // Execute the native SQL query to insert a new record
        DB::insert("INSERT INTO detail_penerimaan (barang_idbarang, idpenerimaan, harga_satuan_terima, jumlah_terima, sub_total_terima) 
                VALUES (?, ?, ?, ?, ?)", [$barangs, $penerimaan, $harga, $jumlah, $subtotal]);
        return redirect('detpenerimaan/create')->with('status', 'Barang berhasil diterima!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $iddetail_penerimaan)
    {
        $detpenerimaan = DB::table('detail_penerimaan')->where('iddetail_penerimaan', $iddetail_penerimaan)->first();
        
        // return $users;
        return view('penerimaan.det_penerimaan.show', compact('detpenerimaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $iddetail_penerimaan)
    {
        $penerimaan = DB::select('SELECT *
            FROM penerimaan');// Mengambil semua peran dari tabel vendor
        $barangs = DB::select('SELECT *
            FROM barang');// Mengambil semua peran dari tabel vendor
        $detpenerimaan = DB::table('detail_penerimaan')->where('iddetail_penerimaan', $iddetail_penerimaan)->first();
        return view('penerimaan.det_penerimaan.edit', compact('penerimaan', 'barangs', 'detpenerimaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $iddetail_penerimaan)
    {
        DB::update('UPDATE detail_penerimaan SET barang_idbarang = ?, idpenerimaan = ?, harga_satuan_terima= ?, jumlah_terima = ?, sub_total_terima = ?
        WHERE iddetail_penerimaan = ?', [
            $request->idBarang, 
            $request->idpenerimaan,
            $request->subtotal,
            $request->ppn,
            $request->total,
            $iddetail_penerimaan
        ]);

        return redirect('detpenerimaan')->with('status', 'Pengadaan berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $iddetail_penerimaan)
    {
        DB::table('detail_penerimaan')
        ->where('iddetail_penerimaan', $iddetail_penerimaan)
        ->update(['deleted_at' => now()]);

    $records = DB::table('detail_penerimaan')
        ->whereNull('deleted_at')
        ->get();

    return redirect('detpenerimaan')->with('status', 'Penerimaan berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KartuStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kartustok = DB::select('SELECT *
        FROM kartu_stok
        WHERE deleted_at is NULL');   

        $kartustok = DB::table('kartu_stok')
                    ->select('kartu_stok.*','barang.nama',)
                    ->join('barang', 'kartu_stok.idbarang', '=', 'barang.idbarang')
                    ->whereNull('kartu_stok.deleted_at')
                    ->get();

        return view('penjualan.kartustok.index', compact('kartustok'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = DB::select('SELECT *
            FROM barang');// Mengambil semua peran dari tabel vendor
        return view('penjualan.kartustok.create', compact('barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jenistransaksi = $request->jenis;
        $masuk = $request->masuk;
        $keluar = $request->keluar;
        $stock = $request->stock;
        $created_at = $request->timestamp;
        $idtransaksi = $request->idtransaksi;
        $idbarang = $request->idBarang;

        // Execute the native SQL query to insert a new record
        DB::insert("INSERT INTO kartu_stok (jenis_transaksi, masuk, keluar, stock, created_at, idtransaksi, idbarang) 
                VALUES (?, ?, ?, ?, ?, ?, ?)", [$jenistransaksi, $masuk, $keluar, $stock, $created_at, $idtransaksi, $idbarang]);

        return redirect('kartustok')->with('status', 'Kartu stok berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idkartu_stok)
    {
        $kartustok = DB::table('kartu_stok')->where('idkartu_stok', $idkartu_stok)->first();
        
        // return $users;
        return view('penjualan.kartustok.show', compact('kartustok'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $idkartu_stok)
    {
        $barangs = DB::select('SELECT *
            FROM barang');// Mengambil semua peran dari tabel vendor
        $kartustok = DB::table('kartu_stok')->where('idkartu_stok', $idkartu_stok)->first();
        return view('penjualan.kartustok.edit', compact('barangs','kartustok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idkartu_stok)
    {
        DB::update('UPDATE kartu_stok SET jenis_transaksi = ?, masuk = ?, keluar= ?, stock = ?, created_at = ?, idtransaksi = ?, idbarang = ?
        WHERE idkartu_stok = ?', [
            $request->jenis, 
            $request->masuk,
            $request->keluar,
            $request->stock,
            $request->timestamp,
            $request->idtransaksi,
            $request->idBarang,
            $idkartu_stok
        ]);

        return redirect('kartustok')->with('status', 'Kartu stok berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idkartu_stok)
    {
        DB::table('kartu_stok')
        ->where('idkartu_stok', $idkartu_stok)
        ->update(['deleted_at' => now()]);

        $records = DB::table('kartu_stok')
            ->whereNull('deleted_at')
            ->get();

        return redirect('kartu_stok')->with('status', 'Kartu stok berhasil dihapus!');
    }
}

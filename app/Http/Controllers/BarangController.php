<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $barangs = DB::table('barang')->get();
        // $barangs = Barang::with('satuan')->get();

        //native
        $barangs = DB::table('barang')
                    ->join('satuan', 'barang.idsatuan', '=', 'satuan.idsatuan')
                    ->select('barang.*', 'satuan.nama_satuan')
                    ->whereNull('barang.deleted_at')
                    ->get();
                    
        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $satuans = DB::table('satuan')->get(); // Mengambil semua peran dari tabel roles
        return view('barang.create', compact('satuans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // DB::table('barang')->insert([
        //     'idbarang' => $request -> idbarang,
        //     'jenis' => $request -> jenis,
        //     'nama' => $request -> name,
        //     'status' => $request -> status,
        //     'harga' => $request -> harga,
        //     'idsatuan' => $request -> idsatuan
        // ]);

        //native
        DB::insert('INSERT INTO barang (idbarang, jenis, nama, status, harga, idsatuan) VALUES (?, ?, ?, ?, ?, ?)', [
            $request->idbarang,
            $request->jenis,
            $request->name,
            $request->status,
            $request->harga,
            $request->idsatuan,
        ]);        
        return redirect('barang')->with('status', 'Barang berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($idbarang)
    {
        $barangs = Barang::where('idbarang', $idbarang)->get();
        $barangs = $barangs[0];
        // return $users;
        return view('barang/show', compact('barangs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($idbarang)
    {
        $barangs = DB::table('barang')->where('idbarang', $idbarang)->first();
        $satuans = Satuan::all(); 
        return view('barang/edit', compact('barangs','satuans')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idbarang)
    {
        // $barangs = DB::table('barang')->where('idbarang', $idbarang)
        // ->update([
        //     'jenis' => $request -> jenis,
        //     'nama' => $request -> name,
        //     'status' => $request -> status,
        //     'harga' => $request -> harga,
        //     'idsatuan' => $request -> idsatuan
        // ]);

        //native
        DB::update('UPDATE barang SET jenis = ?, nama = ?, status = ?, harga = ?, idsatuan = ? WHERE idbarang = ?', [
            $request->jenis,
            $request->name,
            $request->status,
            $request->harga,
            $request->idsatuan,
            $idbarang, 
        ]);
        return redirect('barang')->with('status', 'Barang berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idbarang)
    {
        DB::table('barang')
            ->where('idbarang', $idbarang)
            ->update(['deleted_at' => now()]);

        $records = DB::table('barang')
            ->whereNull('deleted_at')
            ->get();

        return redirect('barang')->with('status', 'Barang berhasil dihapus!');
    }
}

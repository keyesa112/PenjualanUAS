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
                    ->join('satuan', 'barang.idSatuan', '=', 'satuan.id')
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
        //     'id' => $request -> id,
        //     'jenis' => $request -> jenis,
        //     'nama' => $request -> name,
        //     'tatus_aktif' => $request -> status,
        //     'harga' => $request -> harga,
        //     'idSatuan' => $request -> idSatuan
        // ]);

        //native
        DB::insert('INSERT INTO barang (id, jenis, nama, tatus_aktif, harga, idSatuan) VALUES (?, ?, ?, ?, ?, ?)', [
            $request->id,
            $request->jenis,
            $request->name,
            $request->status,
            $request->harga,
            $request->idSatuan,
        ]);        
        return redirect('barang')->with('status', 'Barang berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $barangs = Barang::where('id', $id)->get();
        $barangs = $barangs[0];
        // return $users;
        return view('barang/show', compact('barangs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barangs = DB::table('barang')->where('id', $id)->first();
        $satuans = Satuan::all(); 
        return view('barang/edit', compact('barangs','satuans')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $barangs = DB::table('barang')->where('id', $id)
        // ->update([
        //     'jenis' => $request -> jenis,
        //     'nama' => $request -> name,
        //     'tatus_aktif' => $request -> status,
        //     'harga' => $request -> harga,
        //     'idSatuan' => $request -> idSatuan
        // ]);

        //native
        DB::update('UPDATE barang SET jenis = ?, nama = ?, tatus_aktif = ?, harga = ?, idSatuan = ? WHERE id = ?', [
            $request->jenis,
            $request->name,
            $request->status,
            $request->harga,
            $request->idSatuan,
            $id, 
        ]);
        return redirect('barang')->with('status', 'Barang berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('barang')
            ->where('id', $id)
            ->update(['deleted_at' => now()]);

        $records = DB::table('barang')
            ->whereNull('deleted_at')
            ->get();

        return redirect('barang')->with('status', 'Barang berhasil dihapus!');
    }

    public function caribarang(Request $request)
    {
        // print_r($request->all());
        $brg = $request->barangs;
        
        $barangs = DB::table('barang')
        ->where('nama', 'like', '%' . $brg . '%') // Mencari nama barang yang mengandung kata kunci
        ->whereNull('deleted_at') // Pastikan data tidak terhapus
        ->get();

        print_r($barangs);

    }
}

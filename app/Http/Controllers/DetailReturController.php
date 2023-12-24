<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DetailReturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detretur = DB::select('SELECT *
        FROM detail_retur
        WHERE deleted_at is NULL');   

        $detretur = DB::table('detail_retur')
                    ->select('detail_retur.*', 'retur.created_at', 'barang.nama',)
                    ->join('retur', 'detail_retur.idretur', '=', 'retur.idretur')
                    ->join('detail_penerimaan', 'detail_retur.iddetail_penerimaan', '=', 'detail_penerimaan.barang_idbarang')
                    ->join('barang', 'detail_penerimaan.barang_idbarang', '=', 'barang.idbarang')
                    ->whereNull('detail_retur.deleted_at')
                    ->get();

        return view('retur.det_retur.index', compact('detretur'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $retur = DB::select('SELECT *
            FROM retur');// Mengambil semua peran dari tabel vendor
        $detail_penerimaan = DB::select('SELECT *
                FROM detail_penerimaan');// Mengambil semua peran dari tabel vendor
        $barangs = DB::select('SELECT *
        FROM barang');// Mengambil semua peran dari tabel vendor
        return view('retur.det_retur.create', compact('retur', 'detail_penerimaan', 'barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
   
        $jumlah = $request->ppn;
        $alasan = $request->alasan;
        $idretur = $request->idretur;
        $idpenerimaan = $request->idpenerimaan;

        // Execute the native SQL query to insert a new record
        DB::insert("INSERT INTO detail_retur (jumlah, alasan, idretur, iddetail_penerimaan) 
                VALUES (?, ?, ?, ?)", [$jumlah, $alasan, $idretur, $idpenerimaan]);

        return redirect('detretur')->with('status', 'Retur berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $iddetail_retur)
    {
        $detretur = DB::table('detail_retur')->where('iddetail_retur', $iddetail_retur)->first();
        
        // return $users;
        return view('retur.det_retur.show', compact('detretur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $iddetail_retur)
    {
        $retur = DB::select('SELECT *
            FROM retur');// Mengambil semua peran dari tabel vendor
        $detail_penerimaan = DB::select('SELECT *
                FROM detail_penerimaan');// Mengambil semua peran dari tabel vendor
        $detretur = DB::table('detail_retur')->where('iddetail_retur', $iddetail_retur)->first();
        return view('retur.det_retur.edit', compact('retur', 'detail_penerimaan','detretur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $iddetail_retur)
    {
        DB::update('UPDATE detail_retur SET jumlah = ?, alasan = ?, idretur= ?, iddetail_penerimaan = ?
        WHERE iddetail_retur = ?', [
            $request->ppn, 
            $request->alasan,
            $request->idretur,
            $request->idpenerimaan,
            $iddetail_retur
        ]);

        return redirect('detretur')->with('status', 'Retur berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $iddetail_retur)
    {
        DB::table('detail_retur')
        ->where('iddetail_retur', $iddetail_retur)
        ->update(['deleted_at' => now()]);

        $records = DB::table('detail_retur')
            ->whereNull('deleted_at')
            ->get();

        return redirect('detretur')->with('status', 'Retur berhasil dihapus!');
    }
}

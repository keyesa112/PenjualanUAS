<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $satuans = DB::table('satuans')->get();
        // $satuans = DB::table('satuan')->get();

        //native
        $satuans = DB::select('SELECT *
                    FROM satuan
                    WHERE deleted_at is NULL');    
                    
        return view('satuan.index', ['satuans' => $satuans]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $satuans = DB::table('satuan')->get();
        return view('satuan.create', compact('satuans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // DB::table('satuan')->insert([
        //     'idsatuan' => $request -> idsatuan,
        //     'nama_satuan' => $request -> name,
        //     'status' => $request -> status
        // ]);

        //native
        DB::insert('INSERT INTO satuan (idsatuan, nama_satuan, status) VALUES (?, ?, ?)', [
            $request->idsatuan,
            $request->name,
            $request->status,
        ]);
        return redirect('satuan')->with('status', 'Satuan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($idsatuan)
    {
        $satuans = DB::table('satuan')
                    ->where('idsatuan', $idsatuan)
                    ->first();
        return view('satuan/show', compact('satuans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($idsatuan)
    {
        $satuans = DB::table('satuan')
                    ->where('idsatuan', $idsatuan)
                    ->first();
        return view('satuan/edit', compact('satuans'));    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idsatuan)
    {
        // $satuans = DB::table('satuan')->where('idsatuan', $idsatuan)
        // ->update([
        //     'nama_satuan' => $request -> name,
        //     'status' => $request -> status
        // ]);

        //native
        DB::update('UPDATE satuan SET nama_satuan = ?, status = ? WHERE idsatuan = ?', [
            $request->name,
            $request->status,
            $idsatuan,
        ]);
        return redirect('satuan')->with('status', 'Satuan berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idsatuan)
    {
        DB::table('satuan')
            ->where('idsatuan', $idsatuan)
            ->update(['deleted_at' => now()]);

        $records = DB::table('satuan')
            ->whereNull('deleted_at')
            ->get();

        return redirect('satuan')->with('status', 'Satuanberhasil dihapus!');
    }
}

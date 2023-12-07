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
        //     'id' => $request -> id,
        //     'nama_satuan' => $request -> name,
        //     'status_aktif' => $request -> status
        // ]);

        //native
        DB::insert('INSERT INTO satuan (id, nama_satuan, status_aktif) VALUES (?, ?, ?)', [
            $request->id,
            $request->name,
            $request->status,
        ]);
        return redirect('satuan')->with('status', 'Satuan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $satuans = DB::table('satuan')
                    ->where('id', $id)
                    ->first();
        return view('satuan/show', compact('satuans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $satuans = DB::table('satuan')
                    ->where('id', $id)
                    ->first();
        return view('satuan/edit', compact('satuans'));    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $satuans = DB::table('satuan')->where('id', $id)
        // ->update([
        //     'nama_satuan' => $request -> name,
        //     'status_aktif' => $request -> status
        // ]);

        //native
        DB::update('UPDATE satuan SET nama_satuan = ?, status_aktif = ? WHERE id = ?', [
            $request->name,
            $request->status,
            $id,
        ]);
        return redirect('satuan')->with('status', 'Satuan berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('satuan')
            ->where('id', $id)
            ->update(['deleted_at' => now()]);

        $records = DB::table('satuan')
            ->whereNull('deleted_at')
            ->get();

        return redirect('satuan')->with('status', 'Satuanberhasil dihapus!');
    }
}

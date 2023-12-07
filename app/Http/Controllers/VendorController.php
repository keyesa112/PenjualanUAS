<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $vendors = DB::table('vendor')->get();

        //native
        $vendors = DB::select('SELECT *
                    FROM vendor
                    WHERE deleted_at is NULL');    
        return view('vendor.index', ['vendors' => $vendors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = DB::table('vendor')->get();
        return view('vendor.create', compact('vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // DB::table('vendor')->insert([
        //     'id' => $request -> id,
        //     'nama_vendor' => $request -> name,
        //     'badan_hukum' => $request -> badan,
        //     'status_aktif' => $request -> status
        // ]);

         //native
         $id = $request->id;
         $nama_vendor = $request->name;
         $badan_hukum = $request -> badan;
         $status_aktif = $request -> status;
 
         // Execute the native SQL query to insert data
         DB::insert("INSERT INTO vendor (id, nama_vendor, badan_hukum, status_aktif) 
                     VALUES (?, ?, ?, ?)", [$id, $nama_vendor, $badan_hukum, $status_aktif]);
        return redirect('vendor')->with('status', 'Vendor berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vendors = DB::table('vendor')
                    ->where('id', $id)
                    ->first();
        return view('vendor/show', compact('vendors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $vendors = DB::table('vendor')
                ->where('id', $id)
                ->first();
        return view('vendor/edit', compact('vendors'));    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        // $vendors = DB::table('vendor')->where('id', $id)
        // ->update([
        //     'nama_vendor' => $request -> name,
        //     'badan_hukum' => $request -> badan,
        //     'status_aktif' => $request -> status
        // ]);

        //native
        DB::update('UPDATE vendor SET nama_vendor = ?, badan_hukum = ?, status_aktif = ? WHERE id = ?', [
            $request->name,
            $request->badan,
            $request->status,
            $id
        ]);
        return redirect('vendor')->with('status', 'Vendor berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('vendor')
        ->where('id', $id)
        ->update(['deleted_at' => now()]);

        $records = DB::table('vendor')
        ->whereNull('deleted_at')
        ->get();

        return redirect('vendor')->with('status', 'User berhasil dihapus!');
    }
}

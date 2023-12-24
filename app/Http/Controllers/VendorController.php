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
        //     'idvendor' => $request -> idvendor,
        //     'nama_vendor' => $request -> name,
        //     'badan_hukum' => $request -> badan,
        //     'status' => $request -> status
        // ]);

         //native
         $idvendor = $request->idvendor;
         $nama_vendor = $request->name;
         $badan_hukum = $request -> badan;
         $status = $request -> status;
 
         // Execute the native SQL query to insert data
         DB::insert("INSERT INTO vendor (idvendor, nama_vendor, badan_hukum, status) 
                     VALUES (?, ?, ?, ?)", [$idvendor, $nama_vendor, $badan_hukum, $status]);
        return redirect('vendor')->with('status', 'Vendor berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($idvendor)
    {
        $vendors = DB::table('vendor')
                    ->where('idvendor', $idvendor)
                    ->first();
        return view('vendor/show', compact('vendors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($idvendor)
    {
        $vendors = DB::table('vendor')
                ->where('idvendor', $idvendor)
                ->first();
        return view('vendor/edit', compact('vendors'));    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$idvendor)
    {
        // $vendors = DB::table('vendor')->where('idvendor', $idvendor)
        // ->update([
        //     'nama_vendor' => $request -> name,
        //     'badan_hukum' => $request -> badan,
        //     'status' => $request -> status
        // ]);

        //native
        DB::update('UPDATE vendor SET nama_vendor = ?, badan_hukum = ?, status = ? WHERE idvendor = ?', [
            $request->name,
            $request->badan,
            $request->status,
            $idvendor
        ]);
        return redirect('vendor')->with('status', 'Vendor berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idvendor)
    {
        DB::table('vendor')
        ->where('idvendor', $idvendor)
        ->update(['deleted_at' => now()]);

        $records = DB::table('vendor')
        ->whereNull('deleted_at')
        ->get();

        return redirect('vendor')->with('status', 'User berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pengadaan = DB::select('SELECT *
            FROM pengadaan
            WHERE deleted_at is NULL');    

        $pengadaan = DB::table('pengadaan')
                 ->select('pengadaan.*', 'vendor.nama_vendor')
                 ->join('vendor', 'pengadaan.vendor_idvendor', '=', 'vendor.idvendor')
                 ->whereNull('pengadaan.deleted_at')
                 ->get();

        $vendors = DB::table('vendor')->get();
        return view('pengadaan.index', compact('pengadaan', 'vendors'));

        // $vendors = DB::table('vendor')->get();

        // // Mendapatkan vendor yang dipilih dari dropdown filter
        // $selectedVendor = $request->input('filterVendor');
    
        // // Query untuk mendapatkan data pengadaan berdasarkan vendor yang dipilih
        // $pengadaanQuery = DB::table('pengadaan')
        //     ->select('pengadaan.*', 'vendor.nama_vendor')
        //     ->join('vendor', 'pengadaan.vendor_idvendor', '=', 'vendor.idvendor')
        //     ->whereNull('pengadaan.deleted_at');
    
        // // Jika vendor dipilih, tambahkan kondisi filter berdasarkan vendor yang dipilih
        // if ($selectedVendor) {
        //     $pengadaanQuery->where('pengadaan.vendor_idvendor', $selectedVendor);
        // }
    
        // // Ambil data pengadaan berdasarkan query yang sudah dibuat
        // $pengadaan = $pengadaanQuery->get();
    
        // return view('pengadaan.index', compact('pengadaan', 'vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = DB::select('SELECT *
                FROM vendor');// Mengambil semua peran dari tabel vendor
        $users = DB::select('SELECT *
                FROM users');// Mengambil semua peran dari tabel vendor
        return view('pengadaan.create', compact('vendors', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $timestamp = $request->timestamp;
        // $idpengadaan = $request->idpengadaan;
        $status = $request->status;
        $subtotal = $request->subtotal;
        $ppn = $request->ppn;
        $total = $request->total;
        $vendors = $request->filterVendor;
        $users = $request->filterUser;

        // Execute the native SQL query to insert a new record
        DB::insert("INSERT INTO pengadaan (timestamp, status, subtotal_nilai, ppn, total_nilai, vendor_idvendor, user_iduser) 
                VALUES (?, ?, ?, ?, ?, ?, ?)", [$timestamp, $status, $subtotal, $ppn, $total, $vendors, $users]);

        return redirect('detpengadaan/create')->with('status', 'Pengadaan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idpengadaan)
    {
        $pengadaan = DB::table('pengadaan')->where('idpengadaan', $idpengadaan)->first();
        
        // return $users;
        return view('pengadaan/show', compact('pengadaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $idpengadaan)
    {
        $vendors = DB::select('SELECT *
                FROM vendor');// Mengambil semua peran dari tabel vendor
        $users = DB::select('SELECT *
                FROM users');// Mengambil semua peran dari tabel vendor
        $pengadaan = DB::table('pengadaan')->where('idpengadaan', $idpengadaan)->first();
        return view('pengadaan.edit', compact('vendors', 'users', 'pengadaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $idpengadaan)
    {
        DB::update('UPDATE pengadaan SET timestamp = ?, status = ?, subtotal_nilai = ?,ppn = ?, total_nilai = ?, vendor_idvendor = ?, user_iduser = ?
        WHERE idpengadaan = ?', [
            $request->timestamp,
            $request->status,
            $request->subtotal,
            $request->ppn,
            $request->total,
            $request->filterVendor,
            $request->filterUser,
            $idpengadaan
        ]);

        return redirect('pengadaan')->with('status', 'User berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $idpengadaan)
    {
        DB::table('pengadaan')
        ->where('idpengadaan', $idpengadaan)
        ->update(['deleted_at' => now()]);

    $records = DB::table('pengadaan')
        ->whereNull('deleted_at')
        ->get();

    return redirect('pengadaan')->with('status', 'Pengadaan berhasil dihapus!');
    }
}

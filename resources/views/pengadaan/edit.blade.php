@extends('main')

@section('title','vendor')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Pengadaan</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="">vendor</a>
                    </li>
                    <li class="active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="content mt-3">
 
    <div class="animated fadeIn">
            @if (session('status'))
                <div class="alert alert-success">
            {{ session('status') }}
                </div>
            @endif
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <strong>Data vendor</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('vendor') }}" class="btn btn-secondry btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <form action="{{ url('pengadaan/'. $pengadaan->idpengadaan )}}" method="post">
                                @method('patch')
                                @csrf
                                <div class="form-group">
                                    <label>Timestamp</label>
                                    <input type="datetime-local" name="timestamp" class="form-control" autofocus required>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="">Pilih status</option>
                                        <option value="1"{{ old('status') == 1 ? ' selected' : '' }}>Belum Selesai</option>
                                        <option value="0"{{ old('status') == 0 ? ' selected' : '' }}>Selesai</option>
                                    </select>
                                </div>    
                                <div class="form-group">
                                    <label>Subtotal</label>
                                    <input type="text" name="subtotal" id="subtotal" class="form-control" autofocus required>
                                </div>
                                
                                <div class="form-group">
                                    <label>PPN</label>
                                    <input type="text" name="ppn" id="ppn" class="form-control" autofocus required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Total</label>
                                    <input type="text" name="total" id="total" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                        <label for="filterVendor">Vendor</label>
                                        <select name="filterVendor" id="filterVendor" class="form-control">
                                            <option value="">Pilih Vendor</option>
                                            @foreach($vendors as $vendor)
                                                <option value="{{ $vendor->idvendor }}">{{ $vendor->nama_vendor }}</option>
                                            @endforeach
                                        </select>            
                                    </div>             
                                    <div class="form-group">
                                        <label for="filterUser">User</label>
                                        <select name="filterUser" id="filterUser" class="form-control">
                                            <option value="">Pilih User</option>
                                            <!-- Diisi dengan data user yang tersedia -->
                                            @foreach($users as $user)
                                                <option value="{{ $user->iduser }}">{{ $user->username }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                                                                                                                                                     
                                <button type="submit" class="btn btn-success">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div> 
<script>
    document.getElementById('myForm').addEventListener('submit', function(event) {
        // Mendapatkan elemen input timestamp
        const timestampInput = document.querySelector('input[name="timestamp"]');
    
        // Mendapatkan waktu sekarang
        const now = new Date();
    
        // Menyesuaikan format waktu menjadi format yang diterima oleh input datetime-local (YYYY-MM-DD HH:MI:SS)
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Month dimulai dari 0 (Januari = 0)
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        // Menetapkan nilai awal pada input timestamp sebelum formulir dikirim
        timestampInput.value = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    });
    
    </script>
    
    <script>
        // Mendapatkan elemen input PPN dan Subtotal
        const ppnInput = document.getElementById('ppn');
        const subtotalInput = document.getElementById('subtotal');
        
        // Mendapatkan elemen input Total (yang hanya bisa dibaca)
        const totalInput = document.getElementById('total');
    
        // Menambahkan event listener saat input PPN atau Subtotal berubah
        ppnInput.addEventListener('input', calculateTotal);
        subtotalInput.addEventListener('input', calculateTotal);
    
        // Fungsi untuk menghitung Total
        function calculateTotal() {
            // Mengambil nilai dari input PPN dan Subtotal
            const ppnValue = parseFloat(ppnInput.value) || 0;
            const subtotalValue = parseFloat(subtotalInput.value) || 0;
    
            // Menghitung Total berdasarkan nilai PPN * Subtotal
            const totalValue = (ppnValue * subtotalValue);
    
            // Menetapkan nilai Total ke input Total
            totalInput.value = totalValue.toFixed(2); // Format menjadi dua angka desimal
        }
    </script>
@endsection
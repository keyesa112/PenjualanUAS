@extends('main')

@section('title','vendor')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>vendor</h1>
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
                    <strong>Data Pengadaan</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('detpengadaan') }}" class="btn btn-secondry btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <form action="{{ url('detpengadaan/'. $detpengadaan->iddetail_pengadaan )}}" method="post">
                                @method('patch')
                                @csrf
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <select name="idBarang" class="form-control" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($barangs as $barang)
                                            <option value="{{ $barang->idbarang }}" 
                                                @if (old('idBarang', $detpengadaan->barang_idbarang) == $barang->idbarang) 
                                                    selected 
                                                @endif 
                                                data-harga="{{ $barang->harga }}">
                                                {{ $barang->nama }}
                                            </option>
                                        @endforeach
                                    </select>                                                                      
                                </div>    
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" name="subtotal" id="subtotal" class="form-control" autofocus required  value="{{ old('subtotal', $detpengadaan->harga_satuan) }}">
                                </div>
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="text" name="ppn" id="ppn" class="form-control" autofocus required value="{{ old('ppn', $detpengadaan->jumlah) }}">
                                </div>
                                
                                <div class="form-group">
                                    <label>Sub Total</label>
                                    <input type="text" name="total" id="total" class="form-control" readonly value="{{ old('total', $detpengadaan->sub_total) }}">
                                </div>             
                                <div class="form-group">
                                    <label>Pengadaan</label>
                                    <select name="idpengadaan" class="form-control" required>
                                        <option value="">Pilih Pengadaan</option>
                                        @foreach ($pengadaan as $barang)
                                            <option value="{{ $barang->idpengadaan }}"
                                                @if (old('idpengadaan', $detpengadaan->pengadaan_idpengadaan) == $barang->idpengadaan) 
                                                    selected 
                                                @endif>{{ $barang->timestamp }}
                                            </option>
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
    
    <script>
        $(document).ready(function() {
            $('#idBarang').change(function() {
                var selectedHarga = $(this).find(':selected').data('subtotal');
                $('#subtotal').val(selectedHarga);
            });
        });
    </script>
@endsection
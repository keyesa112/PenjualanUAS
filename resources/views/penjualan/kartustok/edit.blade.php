@extends('main')

@section('title','kartu stok')

<?php
use Carbon\Carbon;
?>


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>kartu stok</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="">kartu stok</a>
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
                    <strong>Data kartustok</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('kartustok') }}" class="btn btn-secondry btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <form action="{{ url('kartustok/'. $kartustok->idkartu_stok )}}" method="post">
                                @method('patch')
                                @csrf
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <select name="idBarang" class="form-control" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($barangs as $barang)
                                            <option value="{{ $barang->idbarang }}" 
                                                @if (old('idBarang', $kartustok->idbarang) == $barang->idbarang) 
                                                    selected 
                                                @endif 
                                                data-harga="{{ $barang->harga }}">
                                                {{ $barang->nama }}
                                            </option>
                                        @endforeach
                                    </select>                                                                      
                                </div>   
                                <div class="form-group">
                                    <label for="jenis">Jenis Transaksi</label>
                                    <select name="jenis" class="form-control" required>
                                        <option value="">Pilih Jenis Transaksi</option>
                                        <option value="1"{{ old('status') == 1 ? ' selected' : '' }}>Tunai</option>
                                        <option value="0"{{ old('status') == 0 ? ' selected' : '' }}>Non-Tunai</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Masuk</label>
                                    <input type="text" name="masuk" id="masuk" class="form-control" autofocus required value="{{ old('masuk', $kartustok->masuk) }}">
                                </div>
                                <div class="form-group">
                                    <label>Keluar</label>
                                    <input type="text" name="keluar" id="keluar" class="form-control" autofocus required value="{{ old('masuk', $kartustok->keluar) }}">
                                </div>
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="text" name="stock" id="stock" class="form-control" readonly value="{{ old('masuk', $kartustok->stock) }}">
                                </div>
                                <div class="form-group">
                                    <label>Created at</label>
                                    <input type="datetime-local" name="timestamp" class="form-control" autofocus required value="{{ old('timestamp', Carbon::parse($kartustok->created_at)->format('Y-m-d\TH:i')) }}">
                                </div> 
                                <div class="form-group">
                                    <label>ID Transaksi</label>
                                    <input type="text" name="idtransaksi" id="idtransaksi" class="form-control" autofocus required value="{{ old('masuk', $kartustok->idtransaksi) }}">
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
    const masukInput = document.getElementById('masuk');
    const keluarInput = document.getElementById('keluar');
    
    // Mendapatkan elemen input Total (yang hanya bisa dibaca)
    const stockInput = document.getElementById('stock');

    // Menambahkan event listener saat input PPN atau Subtotal berubah
    masukInput.addEventListener('input', calculateTotal);
    keluarInput.addEventListener('input', calculateTotal);

    // Fungsi untuk menghitung Total
    function calculateTotal() {
        // Mengambil nilai dari input PPN dan Subtotal
        const masukValue = parseFloat(masukInput.value) || 0;
        const keluarValue = parseFloat(keluarInput.value) || 0;

        // Menghitung Total berdasarkan nilai PPN * Subtotal
        const stockValue = (masukValue - keluarValue);

        // Menetapkan nilai Total ke input Total
        stockInput.value = stockValue; // Format menjadi dua angka desimal
    }
</script>
@endsection
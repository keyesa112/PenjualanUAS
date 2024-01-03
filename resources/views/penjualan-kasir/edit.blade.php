@extends('main2')

@section('title','penjualan')

<?php
use Carbon\Carbon;
?>


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Penjualan</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="">Penjualan</a>
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
                    <strong>Data penjualan</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('penjualan-kasir') }}" class="btn btn-secondry btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <form action="{{ url('penjualan-kasir/'. $penjualan->idpenjualan )}}" method="post">
                                @method('patch')
                                @csrf
                                <div class="form-group">
                                    <label>Created at</label>
                                    <input type="datetime-local" name="timestamp" class="form-control" autofocus required value="{{ old('timestamp', Carbon::parse($penjualan->created_at)->format('Y-m-d\TH:i')) }}">
                                </div>        
                                <div class="form-group">
                                    <label>Subtotal</label>
                                    <input type="text" name="subtotal" id="subtotal" class="form-control" autofocus required value="{{ old('subtotal', $penjualan->subtotal_nilai) }}">
                                </div>
                                <div class="form-group">
                                    <label for="persen">Margin (%)</label>
                                    <select name="persen" id="persen" class="form-control">
                                        <option value="">Pilih Margin</option>
                                        @foreach($margin as $item)
                                            <option value="{{ $item->idmargin_penjualan }}"
                                                @if (old('persen', $penjualan->idmargin_penjualan) == $item->idmargin_penjualan)
                                                    selected
                                                @endif>{{ $item->persen }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>PPN</label>
                                    <input type="text" name="ppn" id="ppn" class="form-control" autofocus required value="{{ old('ppn', $penjualan->ppn) }}">
                                </div>
                                
                                <div class="form-group">
                                    <label>Total</label>
                                    <input type="text" name="total" id="total" class="form-control" readonly>
                                </div>            
                                <div class="form-group">
                                    <label for="filterUser">User</label>
                                    <select name="filterUser" id="filterUser" class="form-control">
                                        <option value="">Pilih User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->iduser }}"
                                                @if (old('filterUser', $user->iduser) == $user->iduser) 
                                                    selected 
                                                @endif>{{ $user->username }}
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
    // Mendapatkan elemen input Subtotal, PPN, dan Total
    const subtotalInput = document.getElementById('subtotal');
    const ppnInput = document.getElementById('ppn');
    const totalInput = document.getElementById('total');
    const marginDropdown = document.getElementById('persen'); // Tambahkan ini

    // Menambahkan event listener saat input Subtotal, PPN, atau Margin (%) berubah
    subtotalInput.addEventListener('input', calculateTotal);
    ppnInput.addEventListener('input', calculateTotal);
    marginDropdown.addEventListener('change', calculateTotal); // Ganti menjadi 'change'

    // Fungsi untuk menghitung Total
    function calculateTotal() {
        // Mengambil nilai dari input Subtotal, PPN, dan Margin (%)
        const subtotal = parseFloat(subtotalInput.value) || 0;
        const ppn = parseFloat(ppnInput.value) || 0;
        const selectedMarginIndex = marginDropdown.selectedIndex; // Mengambil index margin yang dipilih
        const selectedMarginValue = marginDropdown.options[selectedMarginIndex].text; // Mengambil nilai margin dari dropdown

        // Memeriksa jika margin yang dipilih valid, kemudian mengonversi ke bentuk desimal
        const margin = selectedMarginValue !== 'Pilih Margin' ? (parseFloat(selectedMarginValue) / 100) : 0;

        // Menghitung total harga berdasarkan rumus yang diberikan
        const total = ((margin * subtotal) + subtotal) * ppn;

        // Menetapkan nilai Total ke input Total
        totalInput.value = total.toFixed(2); // Format menjadi dua angka desimal
    }
</script>
@endsection
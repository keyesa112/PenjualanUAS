@extends('main')


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
                    <strong>Detail Pengadaan</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('detpengadaan/') }}" class="btn btn-secondry btn-sm">
                        <i class="fa fa-close"></i> Close
                    </a>
                </div>
            </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <form action="{{ url('detpengadaan') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <select name="idBarang" class="form-control" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($barangs as $barang)
                                        <option value="{{ $barang->idbarang }}" data-harga="{{ $barang->harga }}">{{ $barang->nama }}</option>
                                        @endforeach
                                    </select>                                    
                                </div>    
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" name="subtotal" id="subtotal" class="form-control" autofocus required>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="text" name="ppn" id="ppn" class="form-control" autofocus required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Sub Total</label>
                                    <input type="text" name="total" id="total" class="form-control" readonly>
                                </div>             
                                <div class="form-group">
                                    <label>Pengadaan</label>
                                    <select name="idpengadaan" class="form-control" required>
                                        <option value="">Pilih Pengadaan</option>
                                        @foreach ($pengadaan as $barang)
                                            <option value="{{ $barang->idpengadaan }}">{{ $barang->timestamp }}</option>
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
<script>
    // Your existing JavaScript logic to handle calculations and form data

    // Get the form and buttons
    const formSection = document.getElementById('formSection');
    const saveButton = document.getElementById('saveButton');
    const nextButton = document.getElementById('nextButton');
    const doneButton = document.getElementById('doneButton');

    // Event listener for the save button
    saveButton.addEventListener('click', function(event) {
        // Your logic to handle form submission (saving data to database, etc.)

        // Show/hide elements after saving
        saveButton.style.display = 'none'; // Hide Save button
        nextButton.style.display = 'inline-block'; // Show Next button
        doneButton.style.display = 'inline-block'; // Show Done button
    });

    // Event listener for the next button
    nextButton.addEventListener('click', function(event) {
        // Reset form or proceed to the next step
        // Example:
        // Clear input values, show the form again, or move to the next step

        // After resetting the form or moving to the next step, show the Save button again
        saveButton.style.display = 'inline-block'; // Show Save button
        nextButton.style.display = 'none'; // Hide Next button
        doneButton.style.display = 'none'; // Hide Done button
    });

    // Event listener for the done button
    doneButton.addEventListener('click', function(event) {
        // Finish the process, redirect, or perform any other necessary action
    });
</script>

@endsection
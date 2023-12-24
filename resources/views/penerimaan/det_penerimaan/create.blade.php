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
                    <strong>Detail Penerimaan</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('penerimaan/') }}" class="btn btn-secondry btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <form action="{{ url('detpenerimaan') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="idpenerimaan">Penerimaan</label>
                                    <select name="idpenerimaan" id="idpenerimaan" class="form-control">
                                        <option value="">Pilih Penerimaan</option>
                                        @foreach($penerimaan as $item)
                                            <option value="{{ $item->idpenerimaan }}">{{ $item->created_at }}</option>
                                        @endforeach
                                    </select>            
                                </div>
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
                                    <label>Jumlah Terima</label>
                                    <input type="text" name="ppn" id="ppn" class="form-control" autofocus required>
                                </div> 
                                <div class="form-group">
                                    <label>Sub Total</label>
                                    <input type="text" name="total" id="total" class="form-control" readonly>
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
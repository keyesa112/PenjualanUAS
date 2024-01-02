@extends('main')

@section('title','vendor')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Penerimaan</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="">Penerimaan</a>
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
                    <strong>Data Penerimaan</strong>
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
                            <form action="{{ url('detpenerimaan/'. $detpenerimaan->iddetail_penerimaan )}}" method="post">
                                @method('patch')
                                @csrf
                                <div class="form-group">
                                    <label for="idpenerimaan">Penerimaan</label>
                                    <select name="idpenerimaan" id="idpenerimaan" class="form-control">
                                        <option value="">Pilih Penerimaan</option>
                                        @foreach($penerimaan as $item)
                                            <option value="{{ $item->idpenerimaan }}"
                                                @if (old('idpenerimaan', $detpenerimaan->idpenerimaan) == $item->idpenerimaan) 
                                                    selected 
                                                @endif>{{ $item->created_at }}
                                            </option>
                                        @endforeach
                                    </select>            
                                </div>                                
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <select name="idBarang" class="form-control" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($barangs as $barang)
                                            <option value="{{ $barang->idbarang }}" 
                                                @if (old('idBarang', $detpenerimaan->barang_idbarang) == $barang->idbarang) 
                                                    selected 
                                                @endif 
                                                data-harga="{{ $barang->harga }}">{{ $barang->nama }}
                                            </option>
                                        @endforeach
                                    </select>                                    
                                </div>                                
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" name="subtotal" id="subtotal" class="form-control" autofocus required value="{{ old('subtotal', $detpenerimaan->harga_satuan_terima) }}">
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Terima</label>
                                    <input type="text" name="ppn" id="ppn" class="form-control" autofocus required value="{{ old('ppn', $detpenerimaan->jumlah_terima) }}">
                                </div> 
                                <div class="form-group">
                                    <label>Sub Total</label>
                                    <input type="text" name="total" id="total" class="form-control" readonly value="{{ old('total', $detpenerimaan->sub_total_terima) }}">
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
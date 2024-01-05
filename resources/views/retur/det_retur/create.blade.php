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
                    <strong>Data Retur</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('retur/') }}" class="btn btn-secondry btn-sm">
                        <i class="fa fa-close"></i> Close
                    </a>
                </div>
            </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <form action="{{ url('detretur') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Barang</label>
                                    <select name="idpenerimaan" class="form-control" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($detail_penerimaan as $detailRetur)
                                            <option value="{{ $detailRetur->iddetail_penerimaan }}">{{ $detailRetur->barang_idbarang }}
                                            </option>
                                        @endforeach
                                    </select>                                                                      
                                </div>      
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="text" name="ppn" id="ppn" class="form-control" autofocus required>
                                </div>     
                                <div class="form-group">
                                    <label>Alasan</label>
                                    <input type="text" name="alasan" id="alasan" class="form-control" autofocus required>
                                </div>     
                                    <div class="form-group">
                                        <label>Retur</label>
                                        <select name="idretur" id="idretur" class="form-control">
                                            <option value="">Pilih Retur</option>
                                            <!-- Diisi dengan data user yang tersedia -->
                                            @foreach($retur as $user)
                                                <option value="{{ $user->idretur }}">{{ $user->created_at }}</option>
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
@endsection
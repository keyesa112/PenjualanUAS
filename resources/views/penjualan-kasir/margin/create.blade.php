@extends('main2')


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
                    <strong>Margin Penjualan</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('margin-kasir/') }}" class="btn btn-secondry btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <form action="{{ url('margin-kasir') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Timestamp</label>
                                    <input type="datetime-local" name="timestamp" class="form-control" autofocus required>
                                </div>
                                <div class="form-group">
                                    <label>Margin Penjualan (%)</label>
                                    <input type="text" name="persen" class="form-control" autofocus required>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="">Pilih status</option>
                                        <option value="1"{{ old('status') == 1 ? ' selected' : '' }}>Aktif</option>
                                        <option value="0"{{ old('status') == 0 ? ' selected' : '' }}>Tidak Aktif</option>
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
                                    <div class="form-group">
                                        <label>Updated at</label>
                                        <input type="datetime-local" name="timestamp2" class="form-control" autofocus required>
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
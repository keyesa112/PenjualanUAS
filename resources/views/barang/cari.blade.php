@extends('main')

@section('title','barang')


@section('breadcrumbs')

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Barang</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="{{ url('barangs/create') }}">Barang</a>
                    </li>
                    <li class="active">Add</li>
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
                    <strong>Data Barang</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('barang/') }}" class="btn btn-secondry btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            {{-- <form action="{{ url('barang') }}" method="post"> --}}
                                @csrf
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control" id="namabarang" autofocus required >
                                </div>
                                <button onclick="caribarang()" class="btn btn-success">Cari barang</button>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div> 

<script>
function caribarang() {
    var el = $("#namabarang").val(); // Mengambil nilai dari input dengan ID namabarang

    $.ajax({
        type: "POST",
        url: "/caribarang",
        data: {
            _token: "{{ csrf_token() }}",
            barang: el
        },
        success: function (results) {
            console.log(results);
            // Kode untuk menjalankan jika sukses
        },
        error: function (res) {
            console.log(res);
            // Kode untuk menangani kesalahan
        }
    });
}


</script>
@endsection
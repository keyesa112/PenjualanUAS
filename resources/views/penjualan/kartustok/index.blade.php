@extends('main')

@section('title','kartu stok')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Kartu Stok</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="{{ url('kartustok/create') }}">Kartu Stok</a>
                    </li>
                    <li class="active">Data</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="content mt-3">
 <!-- Form untuk pencarian barang dan filter vendor -->
</div>
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <strong>Data Kartu Stok</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('kartustok/create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
            </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                             <tr>
                                 <th>ID</th>
                                 <th>Barang</th>
                                 <th>Jenis Transaksi</th>
                                 <th>Masuk</th>
                                 <th>Keluar</th>
                                 <th>Stock</th>
                                 <th>Created at</th>
                                 <th>ID Transaksi<th>
                             </tr>
                        </thead>
                        <tbody>
                         @foreach ($kartustok as $item)
                         <tr>
                             <td>{{ $loop->iteration }}</td>
                             <td>{{ $item->nama }}</td>
                             <td>{{ $item->jenis_transaksi }}</td>
                             <td>{{ $item->masuk }}</td>
                             <td>{{ $item->keluar }}</td>
                             <td>{{ $item->stock }}</td>
                             <td>{{ $item->created_at }}</td>
                             <td>{{ $item->idtransaksi }}</td>
                             <td class="text-center">
                                <a href="{{ url('kartustok/' . $item->idkartu_stok ) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ url('kartustok/'.$item->idkartu_stok.'/edit') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ url('kartustok/' . $item->idkartu_stok) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </form>
                            </td>
                         </tr>
                         @endforeach
                        </tbody>
                     </table>
                 </div>
                </div>
        </div>
</div>
</div> 
@endsection
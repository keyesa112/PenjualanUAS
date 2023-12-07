@extends('main')

@section('title','barang')


@section('breadcrumbs')
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
                        <a href="{{ url('barang/add') }}">Barang</a>
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
 
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <strong>Data Barang</strong>
                </div>
                <div class="pull-right">
                </div>
                <div class="pull-right">
                    <a href="{{ url('barang/create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add
                    </a>
                    <a href="{{ url('/cari') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-search"></i> Search
                    </a>
                </div>
            </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                             <tr>
                                 <th>ID</th>
                                 <th>Jenis</th>
                                 <th>Nama</th>
                                 <th>Status</th>
                                 <th>Harga</th>
                                 <th>Satuan</th>
                                 <th></th>
                             </tr>
                        </thead>
                        <tbody>
                         @foreach ($barangs as $item)
                         <tr>
                             <td>{{ $loop->iteration }}</td>
                             <td>{{ $item->jenis }}</td>
                             <td>{{ $item->nama }}</td>
                             <td>{{ $item->tatus_aktif }}</td>
                             <td>{{ $item->harga }}</td>
                             <td>{{ $item->nama_satuan }}</td>
                             <td class="text-center">
                                <a href="{{ url('barang/' . $item->id ) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ url('barang/'.$item->id.'/edit') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ url('barang/' . $item->id) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
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
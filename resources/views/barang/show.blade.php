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
                        <a href="{{ url('barang/create') }}">Barang</a>
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
                    <strong>Detail barang</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('barang/') }}" class="btn btn-default btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>
                <div class="card-body table-responsive">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Jenis</th>
                                        <td>{{ $barangs->jenis }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td>{{ $barangs->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $barangs->status }}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga</th>
                                        <td>{{ $barangs->harga }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $barangs->satuan->nama_satuan }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                 </div>
                </div>
        </div>
</div>
</div> 
@endsection
@extends('main')

@section('title','pengadaan')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Detail Pengadaan</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="{{ url('pengadaan/add') }}">Pengadaan</a>
                    </li>
                    <li class="active">Detail Pengadaan</li>
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
                    <strong>Detail Pengadaan</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('detpengadaan/') }}" class="btn btn-default btn-sm">
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
                                        <th>Nama Barang</th>
                                        <td>{{ $detpengadaan->barang_idbarang }}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga</th>
                                        <td>{{ $detpengadaan->harga_satuan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah</th>
                                        <td>{{ $detpengadaan->jumlah }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sub Total</th>
                                        <td>{{ $detpengadaan->sub_total }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pengadaan</th>
                                        <td>{{ $detpengadaan->pengadaan_idpengadaan }}</td>
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
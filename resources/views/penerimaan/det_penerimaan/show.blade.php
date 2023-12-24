@extends('main')

@section('title','penerimaan')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Detail Penerimaan</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="{{ url('detpenerimaan/add') }}">Detail Penerimaan</a>
                    </li>
                    <li class="active">Detail Penerimaan</li>
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
                    <strong>Data Penerimaan</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('penerimaan/') }}" class="btn btn-default btn-sm">
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
                                        <th>Timestamp</th>
                                        <td>{{ $detpenerimaan->barang_idbarang }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $detpenerimaan->idpenerimaan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sub Total</th>
                                        <td>{{ $detpenerimaan->harga_satuan_terima }}</td>
                                    </tr>
                                    <tr>
                                        <th>PPN</th>
                                        <td>{{ $detpenerimaan->jumlah_terima }}</td>
                                    </tr>
                                    <tr>
                                        <th>PPN</th>
                                        <td>{{ $detpenerimaan->sub_total_terima }}</td>
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
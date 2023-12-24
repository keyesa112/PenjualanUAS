@extends('main')

@section('title','pengadaan')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Pengadaan</h1>
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
                    <li class="active">Data Pengadaan</li>
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
                    <strong>Data Pengadaan</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('pengadaan/') }}" class="btn btn-default btn-sm">
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
                                        <td>{{ $pengadaan->timestamp }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $pengadaan->status }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sub Total</th>
                                        <td>{{ $pengadaan->subtotal_nilai }}</td>
                                    </tr>
                                    <tr>
                                        <th>PPN</th>
                                        <td>{{ $pengadaan->ppn }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td>{{ $pengadaan->total_nilai }}</td>
                                    </tr>
                                    <tr>
                                        <th>Vendor</th>
                                        <td>{{ $pengadaan->vendor_idvendor }}</td>
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
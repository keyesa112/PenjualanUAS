@extends('main')

@section('title','penerimaan')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Retur</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="{{ url('retur/add') }}">Retur</a>
                    </li>
                    <li class="active">Data Retur</li>
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
                    <strong>Data Retur</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('retur/') }}" class="btn btn-default btn-sm">
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
                                        <td>{{ $retur->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <th>Penerimaan</th>
                                        <td>{{ $retur->idpenerimaan }}</td>
                                    </tr>
                                    <tr>
                                        <th>User</th>
                                        <td>{{ $retur->iduser }}</td>
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
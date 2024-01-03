@extends('main2')

@section('title','margin')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Margin Penjualan</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="{{ url('margin/add') }}">Margin Penjualan</a>
                    </li>
                    <li class="active">Margin Penjualan</li>
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
                    <strong>Data Margin</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('margin/') }}" class="btn btn-default btn-sm">
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
                                        <th>Created at</th>
                                        <td>{{ $margin->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <th>Margin Penjualan (%)</th>
                                        <td>{{ $margin->persen }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $margin->status }}</td>
                                    </tr>
                                    <tr>
                                        <th>User</th>
                                        <td>{{ $margin->iduser }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated at</th>
                                        <td>{{ $margin->updated_at }}</td>
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
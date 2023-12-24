@extends('main')

@section('title','pengadaan')


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
                        <a href="{{ url('retur/create') }}">Retur</a>
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
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <strong>Data Retur</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('retur/create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
            </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                             <tr>
                                 <th>ID</th>
                                 <th>Timestamp</th>
                                 <th>Penerimaan</th>
                                 <th>User</th>
                                 <th></th>
                             </tr>
                        </thead>
                        <tbody>
                         @foreach ($retur as $item)
                         <tr>
                             <td>{{ $loop->iteration }}</td>
                             <td>{{ $item->created_at }}</td>
                             <td>{{ $item->timestamp }}</td>
                             <td>{{ $item->username }}</td>
                             <td class="text-center">
                                <a href="{{ url('retur/' . $item->idretur ) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ url('retur/'.$item->idretur.'/edit') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ url('retur/' . $item->idretur) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
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
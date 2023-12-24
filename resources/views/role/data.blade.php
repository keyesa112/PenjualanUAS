@extends('main')

@section('title','Role')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Role</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="{{ url('role/add') }}">Role</a>
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
                    <strong>Data Role</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('role/add') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
            </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                             <tr>
                                 <th>ID</th>
                                 <th>Nama Role</th>
                                 <th></th>
                             </tr>
                        </thead>
                        <tbody>
                         @foreach ($role as $item)
                         <tr>
                             <td>{{ $loop->iteration }}</td>
                             <td>{{ $item->nama_role }}</td>
                             <td class="text-center">
                                <a href="{{ url('role/' . $item->idrole) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ url('role/edit/' . $item->idrole ) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ url('role/' . $item->idrole) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
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
@extends('main')

@section('title','pengadaan')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Penerimaan</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="{{ url('penerimaan/create') }}">Penerimaan</a>
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
                    <strong>Data Penerimaan</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('detpenerimaan/create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
            </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                             <tr>
                                 <th>ID</th>
                                 <th>Penerimaan</th>
                                 <th>Barang</th>
                                 <th>Jumlah Terima</th>
                                 <th>Harga Satuan</th>
                                 <th>Sub Total</th>
                                 <th></th>
                             </tr>
                        </thead>
                        <tbody>
                         @foreach ($detpenerimaan as $item)
                         <tr>
                             <td>{{ $loop->iteration }}</td>
                             <td>{{ $item->created_at }}</td>
                             <td>{{ $item->nama }}</td>
                             <td>{{ $item->jumlah_terima }}</td>
                             <td>{{ $item->harga_satuan_terima }}</td>
                             <td>{{ $item->sub_total_terima }}</td>
                             <td class="text-center">
                                <a href="{{ url('detpenerimaan/' . $item->iddetail_penerimaan ) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ url('detpenerimaan/'.$item->iddetail_penerimaan.'/edit') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ url('detpenerimaan/' . $item->iddetail_penerimaan) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
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
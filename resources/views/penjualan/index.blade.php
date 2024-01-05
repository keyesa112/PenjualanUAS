@extends('main')

@section('title','penjualan')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Penjualan</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="{{ url('penjualan/create') }}">Penjualan</a>
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
</div>
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <strong>Data Penjualan</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('penjualan/create') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
            </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                             <tr>
                                 <th>ID</th>
                                 <th>Waktu Penjualan</th>
                                 <th>Nama Barang</th>
                                 <th>Harga Satuan</th>
                                 <th>Jumlah</th>
                                 <th>Sub Total Barang</th>
                                 <th>Sub Total Bayar</th>
                                 <th>PPN(%)</th>
                                 <th>Total Bayar</th>
                                 <th>
                             </tr>
                        </thead>
                        <tbody>
                         @foreach ($penjualan as $item)
                         <tr>
                             <td>{{ $loop->iteration }}</td>
                             <td>{{ $item->created_at }}</td>
                             <td>{{ $item->nama }}</td>
                             <td>{{ $item->harga_satuan }}</td>
                             <td>{{ $item->jumlah }}</td>
                             <td>{{ $item->subtotal }}</td>
                             <td>{{ $item->subtotal_nilai }}</td>
                             <td>{{ $item->ppn }}</td>
                             <td>{{ $item->total_nilai }}</td>
                             <td class="text-center">
                                <a href="{{ url('penjualan/' . $item->idpenjualan ) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ url('penjualan/'.$item->idpenjualan.'/edit') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ url('penjualan/' . $item->idpenjualan) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
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
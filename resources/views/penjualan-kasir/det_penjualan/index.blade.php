@extends('main2')

@section('title','detail penjualan')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Detail penjualan</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="{{ url('penjualan/create') }}">Detail penjualan</a>
                    </li>
                    <li class="active">Detail penjualan</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
    <div class="content mt-3">
        <!-- Form untuk pencarian barang dan filter vendor -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="searchBarang">Cari Barang</label>
                    <input type="text" id="searchBarang" class="form-control" placeholder="Masukkan nama barang...">
                    <button type="submit" style="float">Cari</button>
                </div>
            </div>
        </div>
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <div class="pull-left">
                        <strong>Detail penjualan</strong>
                    </div>
                    <div class="pull-right">
                        <a href="{{ url('detpenjualan-kasir/create') }}" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i> Add
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                             <tr>
                                 <th>ID</th>
                                 <th>Nama Barang</th>
                                 <th>Harga</th>
                                 <th>Jumlah Barang</th>
                                 <th>Sub Total</th>
                                 <th></th>
                             </tr>
                        </thead>
                        <tbody>
                         @foreach ($detpenjualan as $item)
                         <tr>
                             <td>{{ $loop->iteration }}</td>
                             <td>{{ $item->nama }}</td>
                             <td>{{ $item->harga_satuan }}</td>
                             <td>{{ $item->jumlah }}</td>
                             <td>{{ $item->subtotal }}</td>
                             <td class="text-center">
                                <a href="{{ url('detpenjualan-kasir/' . $item->iddetail_penjualan) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>                                
                                <a href="{{ url('detpenjualan-kasir/'.$item->iddetail_penjualan.'/edit') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ url('detpenjualan-kasir' . $item->iddetail_penjualan) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
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
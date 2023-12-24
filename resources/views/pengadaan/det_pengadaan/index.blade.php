@extends('main')

@section('title','detail pengadaan')


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
                        <a href="{{ url('pengadaan/create') }}">Detail Pengadaan</a>
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
                        <strong>Detail Pengadaan</strong>
                    </div>
                    <div class="pull-right">
                        <a href="{{ url('detpengadaan/create') }}" class="btn btn-success btn-sm">
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
                         @foreach ($pengadaan2 as $item)
                         <tr>
                             <td>{{ $loop->iteration }}</td>
                             <td>{{ $item->nama }}</td>
                             <td>{{ $item->harga_satuan }}</td>
                             <td>{{ $item->jumlah }}</td>
                             <td>{{ $item->sub_total }}</td>
                             <td class="text-center">
                                <a href="{{ url('detpengadaan/' . $item->iddetail_pengadaan) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>                                
                                <a href="{{ url('detpengadaan/'.$item->iddetail_pengadaan.'/edit') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ url('detpengadaan' . $item->iddetail_pengadaan) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
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
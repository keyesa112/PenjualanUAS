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
                        <a href="{{ url('pengadaan/create') }}">Pengadaan</a>
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
 <div class="row mb-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="searchBarang">Cari Barang</label>
            <input type="text" id="searchBarang" class="form-control" placeholder="Masukkan nama barang...">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="filterVendor">Filter Vendor</label>
            <select name="filterVendor" id="filterVendor" class="form-control">
                <option value="">Pilih Vendor</option>
                @foreach($vendors->where('status', 1) as $vendor)
                    <option value="{{ $vendor->idvendor }}">{{ $vendor->nama_vendor }}</option>
                @endforeach
            </select>                       
        </div>
    </div>
</div>
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <strong>Data Pengadaan</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('pengadaan/create') }}" class="btn btn-success btn-sm">
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
                                 <th>Status</th>
                                 <th>Sub Total</th>
                                 <th>PPN</th>
                                 <th>Total</th>
                                 <th></th>
                             </tr>
                        </thead>
                        <tbody>
                         @foreach ($pengadaan as $item)
                         <tr>
                             <td>{{ $loop->iteration }}</td>
                             <td>{{ $item->timestamp }}</td>
                             <td>{{ $item->status }}</td>
                             <td>{{ $item->subtotal_nilai }}</td>
                             <td>{{ $item->ppn }}</td>
                             <td>{{ $item->total_nilai }}</td>
                             <td class="text-center">
                                <a href="{{ url('pengadaan/' . $item->idpengadaan ) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ url('pengadaan/'.$item->idpengadaan.'/edit') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ url('pengadaan/' . $item->idpengadaan) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
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
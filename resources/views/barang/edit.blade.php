@extends('main')

@section('title','barang')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>barang</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="">barang</a>
                    </li>
                    <li class="active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="content mt-3">
 
    <div class="animated fadeIn">
            @if (session('status'))
                <div class="alert alert-success">
            {{ session('status') }}
                </div>
            @endif
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <strong>Data barang</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('barang') }}" class="btn btn-secondry btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <form action="{{ url('barang/'. $barangs->idbarang )}}" method="post">
                                @method('patch')
                                @csrf
                                <div class="form-group">
                                    <label for="jenis">Jenis</label>
                                    <select name="jenis" class="form-control" required>
                                        <option value="">Pilih jenis</option>
                                        <option value="1"{{ old('status') == 1 ? ' selected' : '' }}>Makanan</option>
                                        <option value="0"{{ old('status') == 0 ? ' selected' : '' }}>Barang</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control"value="{{ $barangs->nama}}" autofocus required>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="">Pilih status</option>
                                        <option value="1"{{ old('status') == 1 ? ' selected' : '' }}>Aktif</option>
                                        <option value="0"{{ old('status') == 0 ? ' selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>                                                              
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="number" name="harga" class="form-control" value="{{ $barangs->harga}}" autofocus required>
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Satuan</label>
                                    <select name="idbarang" class="form-control" required>
                                        <option value="">Pilih Satuan</option>
                                        @foreach($satuans->where('status', 1) as $item)
                                            <option value="{{ $item->idsatuan }}">{{ $item->nama_satuan }}</option>
                                        @endforeach
                                    </select>                                                                       
                                </div>                                                
                                <button type="submit" class="btn btn-success">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div> 
@endsection
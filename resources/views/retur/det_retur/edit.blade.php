@extends('main')

@section('title','vendor')


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
                        <a href="">Retur</a>
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
                    <strong>Data Retur</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('retur') }}" class="btn btn-secondry btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <form action="{{ url('detretur/'. $detretur->iddetail_retur )}}" method="post">
                                @method('patch')
                                @csrf
                                <div class="form-group">
                                    <label>Pengadaan</label>
                                    <select name="idpenerimaan" class="form-control" required>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($detail_penerimaan as $detailRetur)
                                            <option value="{{ $detailRetur->iddetail_penerimaan }}">{{ $detailRetur->barang_idbarang }}
                                            </option>
                                        @endforeach
                                    </select>                                                                      
                                </div>      
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    <input type="text" name="ppn" id="ppn" class="form-control" autofocus required value="{{ old('ppn', $detretur->jumlah) }}">
                                </div>     
                                <div class="form-group">
                                    <label>Alasan</label>
                                    <input type="text" name="alasan" id="alasan" class="form-control" value="{{ old('alasan', $detretur->alasan) }}"  autofocus required>
                                </div>     
                                    <div class="form-group">
                                        <label for="idretur">User</label>
                                        <select name="idretur" id="idretur" class="form-control">
                                            <option value="">Pilih Retur</option>
                                            <!-- Diisi dengan data user yang tersedia -->
                                            @foreach($retur as $user)
                                                <option value="{{ $user->idretur }}">{{ $user->created_at }}</option>
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
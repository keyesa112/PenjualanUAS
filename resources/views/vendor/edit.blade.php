@extends('main')

@section('title','vendor')


@section('breadcrumbs')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>vendor</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li>
                        <a href="">vendor</a>
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
                    <strong>Data vendor</strong>
                </div>
                <div class="pull-right">
                    <a href="{{ url('vendor') }}" class="btn btn-secondry btn-sm">
                        <i class="fa fa-undo"></i> Back
                    </a>
                </div>
            </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <form action="{{ url('vendor/'. $vendors->idvendor )}}" method="post">
                                @method('patch')
                                @csrf
                                <div class="form-group">
                                    <label>Nama vendors</label>
                                    <input type="text" name="name" class="form-control" value="{{ $vendors->nama_vendor}}" autofocus required>
                                </div>
                                <div class="form-group">
                                    <label for="status">Badan Hukum</label>
                                    <select name="badan" class="form-control" required>
                                        <option value="">Pilih Badan Hukum</option>
                                        <option value="1"{{ old('status') == 1 ? ' selected' : '' }}>MUI</option>
                                        <option value="0"{{ old('status') == 0 ? ' selected' : '' }}>Tidak Ada</option>
                                    </select>
                                </div> 
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="">Pilih status</option>
                                        <option value="1"{{ old('status') == 1 ? ' selected' : '' }}>Aktif</option>
                                        <option value="0"{{ old('status') == 0 ? ' selected' : '' }}>Tidak Aktif</option>
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
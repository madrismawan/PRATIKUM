@extends('layouts.admin')
@section('judul','Admin | Tambah Produk Page')
@section('content')
<div style="margin-top:50px ">
    <div class="container">
        <div class="row align-items-centre">
            <div class="col-lg-2">
            </div>
            <div class="col-md-8">
                <div class="component">
                    <div class="card">
                        <form class="form-signin" action="/addImage/{{ $products->id }}" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="card-header">
                            <center>
                                <span>Tambah Foto Produk</span>
                            </center>
                        </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Pilih Foto</label>
                            <input type="file" class="form-control" placeholder="Nama Produk" aria-label="Nama Produk" aria-describedby="basic-addon1" name="files[]" multiple="multiple">
                        </div>
                        
                        </div>
                            <div class="card-footer">
                                <button class="btn btn-md btn-outline-success" type="submit">Tambah</button>
                            </div>
                        </form>
                        
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
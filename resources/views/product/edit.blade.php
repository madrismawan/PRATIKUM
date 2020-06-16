@extends('layouts.admin')
@section('judul','Admin | Edit Produk Page')
@section('content')
<div style="margin-top:50px ">
    <div class="container">
        <div class="row align-items-centre">
            <div class="col-lg-2">
            </div>
            <div class="col-md-8">
                <div class="component">
                    <div class="card">
                        <form class="form-signin" action="{{ route('products.update', $products->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                        <div class="card-header">
                            <center>
                                <span>Edit Produk</span>
                            </center>
                        </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" placeholder="Nama Produk" value="{{ $products->product_name }}" aria-label="Nama Produk" aria-describedby="basic-addon1" name="product_name">
                        </div>
                        <div class="form-group">
                            <label>Harga Satuan</label>
                            <input type="text" class="form-control" placeholder="Harga Satuan" value="{{ $products->price }}" aria-label="Harga Satuan" aria-describedby="basic-addon1" name="price">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Produk</label>
                            <input type="text" class="form-control" placeholder="Deskripsi Produk" value="{{ $products->description }}"  aria-label="Deskripsi Produk" aria-describedby="basic-addon1" name="description">
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="text" class="form-control" placeholder="Stock" aria-label="Stock" value="{{ $products->stock }}" aria-describedby="basic-addon1" name="stock">
                        </div>
                        <div class="form-group">
                            <label>Berat Produk</label>
                            <input type="text" class="form-control" placeholder="Berat Produk" aria-label="Berat Produk" value="{{ $products->weight }}"  aria-describedby="basic-addon1" name="weight">
                        </div>
                       <!--                         <div class="form-group">
                            
                            <select class="form-control" name="category_id[]" multiple="multiple">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" @foreach($details as $detail) {{ $detail->category_id == $category->id ? 'selected' : '' }} @endforeach>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            
                        </div> -->
                    </div>
                        <div class="card-footer">
                            <button class="btn btn-md btn-outline-success" type="submit"  onclick="return confirm('Apa yakin ingin mengubah data ini?')">Edit</button>
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
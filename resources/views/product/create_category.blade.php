@extends('layouts.admin')
@section('judul','Admin | Tambah Kategori Produk Page')
@section('content')
<div style="margin-top:50px ">
    <div class="container">
        <div class="row align-items-centre">
            <div class="col-lg-2">
            </div>
            <div class="col-md-8">
                <div class="component">
                    <div class="card">
                        <form class="form-signin" action="/category_detail/store" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="card-header">
                            <center>
                                <span>Tambah Produk</span>
                            </center>
                        </div>
                    <div class="card-body">
                        <input type="hidden" name="product_id" value="{{$id}}">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" placeholder="{{ $product->product_name }}" aria-label="Nama Produk" aria-describedby="basic-addon1" name="product_name" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category_id" class="form-control" aria-describedby="basic-addon1" aria-label="Kategori">
                                <option>-Pilih kategori baru-</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @foreach($category_details as $category_detail)
                                        <?php if ($category->id == $category_detail->category_id): ?>
                                            style="display: none" <?php endif; ?> @endforeach>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                            <div class="card-footer">
                                <button class="btn btn-md btn-success btn-icon-text" type="submit">
                                    Tambah
                                </button>
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

<script type="text/javascript">
    function hide(){
        var earrings = document.getElementById('earringstd');
        earrings.style.visibility = 'hidden';
    }
</script>
@endsection
@extends('layouts.table')
@section('judul','Admin | Produk Page')
@section('content')
    <div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Produk</h4>
                  <span>
                  <button type="button" class="btn-sm btn-success btn-icon-text" onclick="">
                      <i class="mdi mdi-upload btn-icon-prepend"></i>     
                      <a href="{{ route('products.create') }}" style="color: white;">Tambah Produk</a>
                  </button>
                  <button type="button" class="btn-sm btn-danger btn-icon-text" onclick="" style="margin: 10px">
                      <i class="mdi  mdi-delete btn-icon-prepend"></i>
                      <a href="/products-trash" style="color: white">Trash</a>
                  </button>
                  </span>
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>
                            No
                          </th>
                          <th>
                         Nama Produk
                          </th>
                          <th>
                            Stock
                          </th>
                          <th>
                            Harga
                          </th>
                          <th>
                            Kategori
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($products as $product)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $product->product_name }}</td>
                          <td>{{ $product->stock }}</td>
                          <td>{{ $product->price }}</td>
                          <td> @foreach($categories as $category)
                                  @if($product->id == $category->product_id)
                                    <li>{{ $category->category_name }}</li>
                                  @endif
                               @endforeach
                          </td>
                          <td>
                              <a class="btn-sm btn-success" href="{{ route('discounts.show', $product->id) }}"><i class="mdi mdi-cash-usd "></i></a>
                              <a class="btn-sm btn-info" href="{{ route('products.show',$product->id) }}"><i class="mdi mdi-eye"></i></a>
    
                              <a class="btn-sm btn-warning" href="{{ route('products.edit',$product->id)}}"><i class="mdi mdi-pencil"></i></a>
                              
                              <a class="btn-sm btn-danger" href="/products/delete/{{ $product->id }}" onclick="return confirm('Apa yakin ingin menghapus data ini?')"><i class="mdi mdi-delete"></i></a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {!! $products->links() !!}
                  </div>
                </div>
              </div>
            </div>
@endsection
@extends('layouts.table')
@section('judul','Admin | Produk Trash')
@section('content')
    <div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Trash Produk</h4>
                  <span>
                  <button type="button" class="btn-sm btn-warning btn-icon-text" onclick="">
                      <i class="mdi mdi-keyboard-backspace btn-icon-prepend"></i>     
                      <a href="/products" style="color: white;">Back</a>
                  </button>
                  <button type="button" class="btn-sm btn-success btn-icon-text" onclick="">
                      <i class="mdi mdi-file-restore btn-icon-prepend"></i>     
                      <a href="/products-restore-all" style="color: white;"  onclick="return confirm('Apa yakin ingin mengembalikan semua data ini?')">Restore All</a>
                  </button>
                  <button type="button" class="btn-sm btn-danger btn-icon-text" onclick="">
                      <i class="mdi mdi-delete-forever btn-icon-prepend"></i>
                      <a href="/products-delete-all" style="color: white"  onclick="return confirm('Apa yakin ingin menghapus permanen semua data ini?')">Delete All</a>
                  </button>
                  </span>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                         Nama Produk
                          </th>
                          <th>
                            Rating
                          </th>
                          <th>
                            Stock
                          </th>
                          <th>
                            Berat
                          </th>
                          <th>
                            Harga
                          </th>
                          <th>
                            Deskripsi Produk
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
                          <td>{{ $product->product_name }}</td>
                          <td>{{ $product->product_rate }}</td>
                          <td>{{ $product->stock }}</td>
                          <td>{{ $product->weight }}</td>
                          <td>{{ $product->price }}</td>
                          <td>{{ $product->description }}</td>
                          <td>{{ $product->category_name }}</td>
                          <td>
                              <a class="btn-sm btn-info" href="/products/restore/{{ $product->id }}"  onclick="return confirm('Apa yakin ingin mengembalikan data ini?')">Restore</a>
                              <a class="btn-sm btn-danger" href="/products/destroy/{{ $product->id }}"  onclick="return confirm('Apa yakin ingin menghapus permanen data ini?')">Delete</a>
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
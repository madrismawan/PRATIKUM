@extends('layouts.table')
@section('judul','Admin | Kategori Trash')
@section('content')
    <div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Trash Kategori</h4>
                  <span>
                  <button type="button" class="btn-sm btn-warning btn-icon-text" onclick="">
                      <i class="mdi mdi-keyboard-backspace btn-icon-prepend"></i>     
                      <a href="/categories" style="color: white;">Back</a>
                  </button>
                  <button type="button" class="btn-sm btn-success btn-icon-text" onclick="">
                      <i class="mdi mdi-file-restore btn-icon-prepend"></i>     
                      <a href="/categories-restore-all" style="color: white;"  onclick="return confirm('Apa yakin ingin mengembalikan semua data ini?')">Restore All</a>
                  </button>
                  <button type="button" class="btn-sm btn-danger btn-icon-text" onclick="">
                      <i class="mdi mdi-delete-forever btn-icon-prepend"></i>
                      <a href="/categories-delete-all" style="color: white"  onclick="return confirm('Apa yakin ingin menghapus permanen semua data ini?')">Delete All</a>
                  </button>
                  </span>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                         Nama Kategori
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($product_categories as $category)
                        <tr>
                          <td>{{ $category->category_name }}</td>
                          <td>
                              <a class="btn-sm btn-info" href="/categories/restore/{{ $category->id }}"  onclick="return confirm('Apa yakin ingin mengembalikan data ini?')">Restore</a>
                              <a class="btn-sm btn-danger" href="/categories/destroy/{{ $category->id }}"  onclick="return confirm('Apa yakin ingin menghapus permanen data ini?')">Delete</a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {!! $product_categories->links() !!}
                  </div>
                </div>
              </div>
            </div>
@endsection
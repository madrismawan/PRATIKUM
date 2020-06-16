@extends('layouts.table')
@section('judul','Admin | Detail Kategori Page')
@section('content')
    <div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Detail Kategori</h4>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <td>Nama Kategori</td>
                          <td>{{ $category->category_name }}</td>
                        </tr>
                      </tbody>
                    </table>
                    <button type="button" class="btn btn-warning btn-icon-text">
                          <i class="mdi mdi-file-restore btn-icon-prepend"></i>     
                          <a href="{{ route('categories.edit', $category->id) }}" style="color: white;">Edit Kurir</a>
                  </button>
                  </div>
                </div>
              </div>
            </div>
@endsection
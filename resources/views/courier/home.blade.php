@extends('layouts.table')
@section('judul','Admin | Kurir Page')
@section('content')
    <div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Kurir</h4>
                  <button type="button" class="btn-sm btn-success btn-icon-text" onclick="">
                          <i class="mdi mdi-upload btn-icon-prepend"></i>     
                          <a href="{{ route('couriers.create') }}" style="color: white;">Tambah Kurir</a>
                  </button>
                  <button type="button" class="btn-sm btn-danger btn-icon-text" onclick="">
                      <i class="mdi  mdi-delete btn-icon-prepend"></i>
                      <a href="/couriers-trash" style="color: white">Trash</a>
                  </button>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                            No
                          </th>
                          <th>
                            Nama Kurir
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($couriers as $courier)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $courier->courier }}</td>
                          <td>
                              <a class="btn-sm btn-info" href="{{ route('couriers.show',$courier->id) }}"><i class="mdi mdi-eye"></i></a>
    
                              <a class="btn-sm btn-warning" href="{{ route('couriers.edit',$courier->id)}}"><i class="mdi mdi-pencil"></i></a>

                              <a class="btn-sm btn-danger" href="/couriers/delete/{{ $courier->id }}" onclick="return confirm('Apa yakin ingin menghapus permanen data ini?')"><i class="mdi mdi-delete"></i></a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {!! $couriers->links() !!}
                  </div>
                </div>
              </div>
            </div>
@endsection
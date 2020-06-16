@extends('layouts.table')
@section('judul','Admin | Kurir Trash')
@section('content')
    <div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Trash Kurir</h4>
                  <span>
                  <button type="button" class="btn-sm btn-warning btn-icon-text" onclick="">
                      <i class="mdi mdi-keyboard-backspace btn-icon-prepend"></i>     
                      <a href="/couriers" style="color: white;">Back</a>
                  </button>
                  <button type="button" class="btn-sm btn-success btn-icon-text" onclick="">
                      <i class="mdi mdi-file-restore btn-icon-prepend"></i>     
                      <a href="/couriers-restore-all" style="color: white;"  onclick="return confirm('Apa yakin ingin mengembalikan semua data ini?')">Restore All</a>
                  </button>
                  <button type="button" class="btn-sm btn-danger btn-icon-text" onclick="">
                      <i class="mdi mdi-delete-forever btn-icon-prepend"></i>
                      <a href="/couriers-delete-all" style="color: white"  onclick="return confirm('Apa yakin ingin menghapus permanen semua data ini?')">Delete All</a>
                  </button>
                  </span>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
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
                          <td>{{ $courier->courier }}</td>
                          <td>
                              <a class="btn-sm btn-info" href="/couriers/restore/{{ $courier->id }}"  onclick="return confirm('Apa yakin ingin mengembalikan data ini?')">Restore</a>
                              <a class="btn-sm btn-danger" href="/couriers/destroy/{{ $courier->id }}"  onclick="return confirm('Apa yakin ingin menghapus permanen data ini?')">Delete</a>
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
@extends('layouts.detail_transaksi')
@section('judul','Admin | Cek Order Page')
@section('content')
    <div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Order {{$status}}</h4>
                  @if ($message = Session::get('notif'))
                    <div class="alert alert-danger alert-block">
                      <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
                    </div>
                  @endif
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>
                            No
                          </th>
                          <th>
                         Tanggal Transaksi
                          </th>
                          <th>
                            Nama User
                          </th>
                          <th>
                            Alamat
                          </th>
                          <th>
                            Total
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $transaction->created_at }}</td>
                          <td>{{ $transaction->name }}</td>
                          <td>{{ $transaction->address }}</td>
                          <td>Rp. {{ $transaction->total }}</td>
                          <td>{{ $transaction->status }}</td>
                          <td>
                              <a class="btn-sm btn-info" href="cek/{{$transaction->id}}"><i class="mdi mdi-eye"></i></a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {!! $transactions->links() !!}
                  </div>
                </div>
              </div>
            </div>
@endsection
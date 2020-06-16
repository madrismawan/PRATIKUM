@extends('layouts.table')
@section('judul','Admin | Diskon Produk Page')
@section('content')
    <div class="col-lg-11 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Diskon @foreach($product as $products){{ $products->product_name }}@endforeach</h4>
                  <?php if ($max_date < date('Y-m-d')|| is_null($max_date)):?>
                    <span>
                  <button type="button" class="btn-sm btn-success btn-icon-text" onclick="">
                      <i class="mdi mdi-upload btn-icon-prepend"></i>     
                      <a href="/discounts/add/{{ $id }}" style="color: white;">Tambah Diskon</a>
                  </button>
                  </span>
                <?php endif; ?>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                            No
                          </th>
                          <th>
                            Diskon (%)
                          </th>
                          <th>
                            Mulai Berlaku
                          </th>
                          <th>
                            Akhir Berlaku
                          </th>
                          <th>
                            Keterangan
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($discounts as $discount)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $discount->percentage }}</td>
                          <td>{{ $discount->start }}</td>
                          <td>{{ $discount->end }}</td>
                          <td>
                            <?php if ($discount->end < date('Y-m-d')) {
                                echo "Masa Berlaku Habis";
                            }     else{
                                echo "Masih Berlaku";
                            } ?>
                          </td>
                          <td>
                              <a class="btn-sm btn-warning" href="{{ route('discounts.edit',$discount->id)}}"><i class="mdi mdi-pencil"></i></a>
                              
                              <a class="btn-sm btn-danger" href="/discounts/delete/{{ $discount->id }}" onclick="return confirm('Apa yakin ingin menghapus data ini?')"><i class="mdi mdi-delete"></i></a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {!! $discounts->links() !!}
                  </div>
                </div>
              </div>
            </div>
@endsection
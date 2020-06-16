@extends('layouts.user')
@section('judul','User | Invoice Page')
@section('content')
    <div class="breadcumb_area bg-img" style="background-image: url(assets/user/img/bg-img/breadcumb.jpg); margin-top: 5%">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Invoice</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="checkout_area section-padding-100">
        <div class="container">
            <div class="row">
    		<div class="col-12 col-md-6 col-lg-12 ml-lg-center">
    			<div class="table-responsive">
                    <table class="table table-bordered">
                    	<thead>
                    		<tr>
                    			<th>No</th>
                    			<th>Tanggal Memesan</th>
                    			<th>Action</th>
                    		</tr>
                    		<tbody>
                    			@foreach($transactions as $transaction)
                    			<tr>
                    				<td>{{$loop->iteration}}</td>
                    				<td>{{$transaction->date_order}}</td>
                    				<td><a href="/users/invoice/{{$transaction->id}}" class="btn btn-info">Cek</a></td>
                    			</tr>
                    			@endforeach
                    		</tbody>
                    	</thead>
                    </table>
                    {!! $transactions->links() !!}
                    </div>
                </div>
               </div>
              </div>
             </div>
@endsection
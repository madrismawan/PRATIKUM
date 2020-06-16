@extends('layouts.admin')
@section('judul','Admin | Register Page')
@section('content')
<div style="margin-top:50px ">
    <div class="container">
        <div class="row align-items-centre">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <div class="component">
                    <div class="card">
                        <form class="form-signin" action="/adminRegister" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="card-header">
                            <center>
                                <span>REGISTER</span>
                            </center>
                        </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="username">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" placeholder="Nama" aria-label="Nama" aria-describedby="basic-addon1" name="name">
                        </div>
                        <div class="form-group">
                            <label>No Telepon</label>
                            <input type="text" class="form-control" placeholder="No Telpon" aria-label="Phone" aria-describedby="basic-addon1" name="phone">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" name="password">
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" class="form-control" placeholder="Konfirmasi Password" aria-label="Password" aria-describedby="basic-addon1" name="password_confirmation">
                        </div>
                    </div>
                        <div class="card-footer">
                            <button class="btn btn-md btn-outline-primary" type="submit">REGISTER</button>
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

@endsection
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Login Page</title>

    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('assets/user/img/core-img/favicon.ico') }}">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/user/css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/style.css') }}">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
<center>
    <!-- ##### Checkout Area Start ##### -->
    <div class="checkout_area section-padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-5 ml-lg" style="margin-left: 30%;">
                    <div class="order-details-confirmation">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="cart-page-heading">
                                <h5>LOGIN</h5>
                                <p>Silahkan Login Terlebih Dahulu</p>
                            </div>

                            <ul class="order-details-form mb-4">
                                <input type="email" class="form-control" placeholder="E-Mail" name="email" style="font-size: 13px;">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                                <input type="Password" class="form-control" placeholder="Password" name="password" style="font-size: 13px;">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                                <a href="{{ route('register') }}">Belum Punya akun?</a>
                            </ul>
                            <button class="btn btn-primary btn-lg" style="width: 80px;" type="submit">LOGIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="{{ URL::asset('assets/user/js/jquery/jquery-2.2.4.min.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ URL::asset('assets/user/js/popper.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ URL::asset('assets/user/js/bootstrap.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/user/js/plugins.js') }}"></script>
    <!-- Classy Nav js -->
    <script src="{{ URL::asset('assets/user/js/classy-nav.min.js') }}"></script>
    <!-- Active js -->
    <script src="{{ URL::asset('assets/user/js/active.js') }}"></script>
</center>
</body>
</html>
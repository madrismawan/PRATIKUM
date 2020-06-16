<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>@yield('judul')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="A new design system for developing with less effort.">
    <meta name="author" content="BootstrapBay">

    <link href="{{ asset('assets/user2/assets/img/favicon.ico') }}" rel="icon" type="image/png">
    
    <link rel="stylesheet" href="{{ asset('assets/user2/assets/vendor/bootstrap/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/user2/assets/css/lazy.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/user2/assets/css/demo.css') }}">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">
  </head>
  <body class="index">
      @yield('content')

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/user2/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/user2/assets/vendor/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/user2/assets/vendor/bootstrap/bootstrap.min.js') }}" ></script>

    <!-- optional plugins -->
    <script src="{{ asset('assets/user2/assets/vendor/nouislider/js/nouislider.min.js') }}"></script>

    <!--   lazy javascript -->
    <script src="{{ asset('assets/user2/assets/js/lazy.js') }}"></script>
  </body>
</html>

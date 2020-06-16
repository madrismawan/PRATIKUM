<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>@yield('judul')</title>

    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('assets/user/img/core-img/favicon.ico') }}">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/user/css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/style.css') }}">
     <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
     <!-- ##### Header Area Start ##### -->
    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="/home"><img src="{{ asset('assets/user/img/core-img/logo.png') }}" alt=""></a>
                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
                <!-- Menu -->
                <div class="classy-menu">
                    <!-- close btn -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <!-- Nav Start -->
                    <div class="classynav">
                        <ul>
                            <li><a href="{{route('transactions.show', Auth::user()->id)}}">Check Out</a></li>
                            <li><a href="/users/{{Auth::user()->id}}/invoice">Invoice</a></li>
                            @if(Auth::check())
                                <?php 
                                    $id = Auth::user()->id;
                                    $notif_count = Auth()->user()->unreadNotifications->count();
                                    $notifications = DB::table('user_notifications')->where('notifiable_id',$id)->where('read_at',NULL)->orderBy('created_at','desc')->get();
                                ?>
                            <li><a href="#">Pesan @if($notif_count != 0)<span class="badge" style="background-color: red; color: white;">{{$notif_count}}</span>@endif</a>
                                <ul class="dropdown" style="width: 300px;">
                                    <center><a href="/marknotif" class="btn" style="background-color: white;">Baca Semua</a></center>
                                    @foreach($notifications as $notif)
                                        <li>{!!$notif->data!!}</li>
                                        <br>                                  
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <!-- Search Area -->
                <div class="search-area">
                    <form action="#" method="post">
                        <input type="search" name="search" id="headerSearch" placeholder="Type for search">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
                <!-- Favourite Area -->
                <div class="favourite-area">
                    <a href="#"><img src="{{ asset('assets/user/img/core-img/heart.svg') }}" alt=""></a>
                </div>
                <!-- User Login Info -->
                <div class="user-login-info">
                    <a href="">{{ Auth::user()->name }}</a>
                </div>
                <div class="user-login-info">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }} <span class="caret">
                        </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                </div>
                <!-- Cart Area -->
                <div class="cart-area">
                    <a href="#" id="essenceCartBtn"><img src="{{ asset('assets/user/img/core-img/bag.svg') }}" alt=""></a>
                </div>
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->
    @yield('content')
   

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="{{ asset('assets/user/js/jquery/jquery-2.2.4.min.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ asset('assets/user/js/popper.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/user/js/bootstrap.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ asset('assets/user/js/plugins.js') }}"></script>
    <!-- Classy Nav js -->
    <script src="{{ asset('assets/user/js/classy-nav.min.js') }}"></script>
    <!-- Active js -->
    <script src="{{ asset('assets/user/js/active.js') }}"></script>

</body>

</html>
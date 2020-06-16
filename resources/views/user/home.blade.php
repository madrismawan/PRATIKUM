@extends('layouts.user')
@section('judul','User | Home Page')
@section('content')
    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb_area bg-img" style="background-image: url(assets/user/img/bg-img/breadcumb.jpg); margin-top: 5%">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>{{$title}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Shop Grid Area Start ##### -->
    <section class="shop_grid_area section-padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="shop_sidebar_area">

                        <!-- ##### Single Widget ##### -->
                        <div class="widget catagory mb-50">
                            <!-- Widget Title -->
                            <h6 class="widget-title mb-30">Cari Berdasarkan Kategori</h6>

                            <!--  Catagories  -->
                            
                                <form action="/users/search/category" method="GET">
                                    <div class="catagories-menu">
                                        <h4 style="color: white;">-------------------</h4>
                                        <select class="w-100 form-control" name="category">
                                            <option>--Pilih Category Produk--</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <h4 style="color: white;">-------------------</h4>
                                    <button type="submit" class="btn btn-info btn-lg">Cari</button>
                                </form>
                            
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8 col-lg-9">
                    <div class="shop_grid_product_area">
                        <div class="row">
                            <div class="col-12">
                                <div class="product-topbar d-flex align-items-center justify-content-between">
                                    <!-- Total Products -->
                                    <div class="total-products">
                                        <p><span>{{$count_product}}</span> Produk Ditemukan</p>
                                    </div>
                                    <!-- Sorting -->
                                    <div class="product-sorting d-flex">
                                        <p>Sort by:</p>
                                        <form action="#" method="get">
                                            <select name="select" id="sortByselect">
                                                <option value="value">Highest Rated</option>
                                                <option value="value">Newest</option>
                                                <option value="value">Price: $$ - $</option>
                                                <option value="value">Price: $ - $$</option>
                                            </select>
                                            <input type="submit" class="d-none" value="">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        	@foreach($products as $product)
                            
                            <!-- Single Product -->
                            <div class="col-12 col-sm-6 col-lg-4">
                            	
                                <div class="single-product-wrapper" id="product_template">
                                    <!-- Product Image -->
                                    
                                    <div class="product-img">
                                    	@foreach($product_images as $image)
                                        @if($image->product_id==$product->id)
                                        <img src="/image/product_image/{{$image->image_name}}" alt="">
                                        <!-- Product Badge -->
                                        @break
                                        @endif
                            			@endforeach
                                        @foreach($discounts as $discount)
                                            @if($product->id==$discount->id_product && $discount->end > @date())
                                                <div class="product-badge offer-badge">
                                                    <span>-{{$discount->percentage}}%</span>
                                                </div>
                                            @endif
                                        @endforeach
                                        <!-- Favourite -->
                                        <div class="product-favourite">
                                            <a href="#" class="favme fa fa-heart"></a>
                                        </div>
                                    </div>
                                    <!-- Product Description -->
                                    <div class="product-description">
                                        <span>topshop</span>
                                        <a href="{{ route('users.show', $product->id) }}">
                                        	<p>Rating {{ $product->product_rate }}</p>
                                            <h6>{{ $product->product_name }}</h6>
                                        </a>
                                        <?php $harga = $product->price; ?>
                                        @foreach($discounts as $discount)
                                        
                                        @if($product->id==$discount->id_product && $discount->end > @date('Y-m-d'))
                                            <?php                                     
                                                    $harga = $product->price - ($product->price*$discount->percentage/100);
                                             ?>
                                             @break
                                        @endif
                                        @endforeach
                                            <p class="product-price">Rp. {{$harga}}</p>
                                        <!-- Hover Content -->
                                        <div class="hover-content">
                                            <div class="add-to-cart-btn">
                                                <button class="btn essence-btn"><a href="{{ route('users.show', $product->id) }}" style="color: white;">Cek Produk</a></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                    <!-- Pagination -->
                    <nav aria-label="navigation">
                        <ul class="pagination mt-50 mb-70">{!! $products->links() !!}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Shop Grid Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix">
        <div class="container">
            <div class="row">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area d-flex mb-30">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="#"><img src="img/core-img/logo2.png" alt=""></a>
                        </div>
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <ul>
                                <li><a href="shop.html">Shop</a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area mb-30">
                        <ul class="footer_widget_menu">
                            <li><a href="#">Order Status</a></li>
                            <li><a href="#">Payment Options</a></li>
                            <li><a href="#">Shipping and Delivery</a></li>
                            <li><a href="#">Guides</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Use</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row align-items-end">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_heading mb-30">
                            <h6>Subscribe</h6>
                        </div>
                        <div class="subscribtion_form">
                            <form action="#" method="post">
                                <input type="email" name="mail" class="mail" placeholder="Your email here">
                                <button type="submit" class="submit"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_social_area">
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>

@endsection

@extends('layouts.user')
@section('judul','User | Detail Produk Page')
@section('content')
<!-- Modal -->
<div class="modal fade" id="review" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Review Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
        @foreach($reviews as $review)
            <div class="row" style="margin-bottom: : 10px; margin-top: 10px;">
                <div class="col-md-6">
                    <div style="background-color: #ddd4bd; padding: 5px 15px; border-radius: 10px;">
                        <p style="margin: 0; font-size: 10px;">{{$review->name}}</p>
                        <p style="margin: 0; color: black;">{{$review->content}}</p>                        
                    </div>
                </div>
            </div>
            @foreach($response as $item)
                @if($review->id == $item->review_id)
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-6 ml-auto">
                        <div style="background-color: #7ed957; padding: 5px 15px; border-radius: 10px;">
                            <p style="margin: 0; font-size: 10px;">{{$review->name}}</p>
                            <p style="margin: 0;">{{$review->content}}</p> 
                            <hr>
                            <p style="margin: 0; font-size: 10px;">{{$item->name}}</p>
                            <p style="margin: 0; color: black;">{{$item->content}}</p>                        
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        @endforeach
        </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
 <!-- Modal -->
            <div class="modal fade" id="checkout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Review Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="/users/checkout/{{$product->id}}" method="POST">
                      @csrf
                      <div class="form-group">
                        <label>Produk</label>
                        <input type="text" name="" value="{{$product->product_name}}" readonly="" class="form-control">
                      </div>
                      <div class="form-group">
                        <label>Jumlah</label>
                        <input type="text" name="qty" value="1" class="form-control" min="1">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Checkout</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
<section class="single_product_details_area d-flex align-items-center">
        <!-- Single Product Thumb -->
        <div class="single_product_thumb clearfix">
        	@if($sum_image > 1)
            <div class="product_thumbnail_slides owl-carousel" style="height: 65%; width: 65%;">
                @foreach($images as $item)
                <img src="/image/product_image/{{ $item->image_name }}" alt="">
                @endforeach
            </div>
            @else
            	<div class="product-img"  style="height: 65%; width: 65%;">
                @foreach($images as $item)
                <img src="/image/product_image/{{ $item->image_name }}" alt="">
                @endforeach
            </div>
            @endif
        </div>
        <?php 
            $price = $product->price;
            $diskon = 0;
            if (isset($discount)) {
                $diskon = $discount->percentage;
                $price = $price - ($price*$diskon/100);
            }
         ?>
        <!-- Single Product Description -->
        <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
            @if ($message = Session::get('notif'))
              <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
              </div>
            @endif
            <div class="order-details-confirmation">
                <div class="cart-page-heading">
                    <h5>Detail Produk</h5>
                    </div>
                    <form class="btn-submit" method="POST">
                        <input type="hidden" name="product_id" value="{{$product->id}}" id="product_id">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}" id="user_id">
                        <ul class="order-details-form mb-4">
                            <li><span>Nama Produk</span> <span>{{$product->product_name}}</span></li>
                            <li><span>Deskripsi</span> <span>{{$product->description}}</span></li>
                            <li><span>Diskon</span> <span>{{$diskon}}%</span></li>
                            <li><span>Harga Satuan</span> <span>Rp. {{$price}}</span></li>
                            <input id="qty" type="hidden" name="qty" value="1" class="form-control" style="width: 20%;">
                        </ul>
                        <button class="btn btn-success btn-lg">Add to Cart</button>
                    </form>
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#review" style="margin-top: 25px;">
                          Lihat Review
                        </button>
                        <button type="button" class="btn btn-warning btn-lg" data-toggle="modal" data-target="#checkout" style="margin-top: 25px;">
                          Checkout
                        </button>
                    </div>
                </div>
    </section>
    <!-- ##### Single Product Details Area End ##### -->

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

<script>
    $(document).ready(function(){
      var total = 0;
      $('#qty').keyup(function(){
          var qty = $('#qty').val();
          var price = $('#price').val();
          total = qty * price;
      $('#sub-total').html(total);
      });
    });
</script>
@endsection
<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Admin;
use App\Product;
use App\Notifications\AdminNotification;
class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $review = new Review;
        $review->product_id = $request->product_id;
        $review->user_id = Auth::user()->id;
        $review->transaction_id = $request->transaction_id;
        $review->rate = $request->rate;
        $review->content = $request->content;
        $review->save();
        $admin = Admin::find(1);
        $notif = "<a class='dropdown-item' href='/products/".$request->product_id."'>".
                "<div class='item-content flex-grow'>".
                  "<h6 class='ellipsis font-weight-normal'>".Auth::user()->name."</h6>".
                  "<p class='font-weight-light small-text text-muted mb-0'>Ada Review Baru".
                  "</p>".
                "</div>".
              "</a>";
        $admin->notify(new AdminNotification($notif));
        $rating = DB::table('product_reviews')->where('product_reviews.product_id', '=', $request->product_id)->avg('product_reviews.rate');
        $product = Product::find($request->product_id);
        $product->product_rate = $rating;
        $product->save();
        return redirect()->back()->with(['success'=>'Review product berhasil!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}

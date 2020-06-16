<?php

namespace App\Http\Controllers;

use App\Response;
use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ResponseController extends Controller
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
        $response = new Response;
        $response->review_id = $request->review_id;
        $response->admin_id = $request->admin_id;
        $response->content = $request->content;
        $response->save();

        $review = DB::table('product_reviews')->select('product_reviews.*')->where('product_reviews.id', '=', $request->review_id)->first();
        $product = Product::find($review->product_id);
        $user = User::find($review->user_id);
        $user->notify(new UserNotification("<a href ='/users/".$review->product_id."'>Reviewmu di produk ".$product->product_name." telah direspon oleh admin</a>"));
        return redirect()->back()->with(['terkirim'=>'Balasan Terkirim']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function show(Response $response)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function edit(Response $response)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Response $response)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function destroy(Response $response)
    {
        //
    }
}

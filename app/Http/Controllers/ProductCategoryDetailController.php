<?php

namespace App\Http\Controllers;
use App\Product;
use App\Category;
use DB;
use Illuminate\Http\Request;
use Redirect;

class Product_Category_DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_category_details = DB::table('product_category_details')
            ->join('products', 'product_category_details.product_id', '=', 'products.id')
            ->join('product_categories', 'product_category_details.category_id', '=', 'product_categories.id')
            ->select('product_category_details.*','products.product_name','product_categories.category_name')
            ->get();
        return view('category_detail.home', compact('product_category_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product_category_details = DB::table('product_category_details')
            ->join('products', 'product_category_details.product_id', '=', 'products.id')
            ->join('product_categories', 'product_category_details.category_id', '=', 'product_categories.id')
            ->select('product_category_details.*','products.product_name','product_categories.category_name')
            ->get();
        return view('category_detail.show', compact('product_category_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_Category_Detail $product_category_detail)
    {
        $product_category_detail->delete();
        return redirect()->back();
    }
}

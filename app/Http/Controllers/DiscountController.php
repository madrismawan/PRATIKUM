<?php

namespace App\Http\Controllers;

use App\Discount;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect;

class DiscountController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:admin','authAdmin:admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $discounts['discounts'] = DB::table('discounts')->select('discounts.*')->where('discounts.id_product', '=', $id)->get();
        return view('discount.home', compact('discounts', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products['products'] = DB::table('products')
                            ->select('products.*')
                            ->get();
        return view('discount.create', $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute Wajib Diisi',
            'max' => ':attribute Harus Diisi maksimal :max karakter',
            'min' => ':attribute Harus Diisi minimum :min karakter',
            'string' => ':attribute Hanya Diisi Huruf dan Angka',
            'confirmed' => ':attribute Konfirmasi Password Salah',
            'unique' => ':attribute Username sudah ada',
            'email' => ':attribute Format Email Salah',
            'numeric' => ':attribute Data Harus Angka',
        ];

        $this->validate($request,[
            'id_product' => 'required',
            'percentage' => 'required|numeric',
        ],$messages);

        $discounts = new Discount;
        $discounts->id_product = $request->id_product;
        $discounts->percentage = $request->percentage;
        $discounts->start  = $request->start;
        $discounts->end = $request->end;
        $discounts->save();
        return Redirect::to('discounts/'.$discounts->id_product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discounts = DB::table('discounts')->select('discounts.*')->where('discounts.id_product', '=', $id)
                    ->where('discounts.deleted_at', '=', null)
                    ->orderby('discounts.end', 'desc')->paginate(10);
        $product = DB::table('products')->select('products.product_name')
                    ->where('products.id', '=', $id)->get();
        $max_date = DB::table('discounts')->where('discounts.id_product', '=', $id)->max('discounts.end');
                    
        return view('discount.home', compact('discounts', 'id', 'max_date', 'product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = DB::table('products')
                            ->select('products.*')
                            ->get();
        $discount = Discount::find($id);
        return view('discount.edit', compact('products', 'discount', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'required' => ':attribute Wajib Diisi',
            'max' => ':attribute Harus Diisi maksimal :max karakter',
            'min' => ':attribute Harus Diisi minimum :min karakter',
            'string' => ':attribute Hanya Diisi Huruf dan Angka',
            'confirmed' => ':attribute Konfirmasi Password Salah',
            'unique' => ':attribute Username sudah ada',
            'email' => 'attribute Format Email Salah',
        ];

        $this->validate($request,[
            'id_product' => 'required',
            'percentage' => 'required|numeric'
        ],$messages);

        $update = [
            'id_product' => $request->id_product,
            'percentage' => $request->percentage,
            'start' => $request->start,
            'end' => $request->end,
        ];
        Discount::where('id', $id)->update($update);
        return Redirect::to('discounts/'.$request->id_product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        //
    }

    public function soft_delete($id){
        $discounts = Discount::find($id);
        $discounts->delete();
        return redirect()->back();
    }

    public function add_discount($id){
        $products = DB::table('products')
                    ->select('products.*')
                    ->where('products.id', '=', $id)
                    ->get();
        return view('discount.create', compact('products', 'id'));
    }
}

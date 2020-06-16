<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\DB;
use App\Product_image;
use Auth;
class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $cek = Cart::where('user_id', '=', $request->user_id)
                    ->where('product_id', '=', $request->product_id)
                    ->where('carts.status', '=', 'notyet')->first();
        if (is_null($cek)) {
            $carts = new Cart;
            $carts->product_id = $request->product_id;
            $carts->qty = $request->qty;
            $carts->user_id = $request->user_id;
            $carts->status = "notyet";
            $carts->save();
            return response()->json(['notif' => "sukses menambahkan ke keranjang" ]);
        }else{
           return response()->json(['notif' => "Produk Sudah di keranjang" ]); 
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = DB::table('carts')
                    ->join('products', 'products.id', '=', 'carts.product_id')
                    ->join('users', 'users.id', '=', 'carts.user_id')
                    ->select('products.*', 'carts.qty', 'carts.id AS cart_id')
                    ->where('users.id', '=', $id)
                    ->where('carts.deleted_at', '=', null)
                    ->where('carts.status', '=', 'notyet')
                    ->get();
        $discounts = DB::table('discounts')->select('discounts.*')->get();
        $images = DB::table('product_images')->select('product_images.*')->get();
        $count_carts = Cart::where('user_id', '=', Auth::user()->id)->where('carts.status', '=', 'notyet')->count('id');
        $sub_total = DB::select('SELECT SUM(carts.`qty`*products.`price`) AS subtotal
                                    FROM carts JOIN products ON products.`id` = carts.`product_id`
                                    JOIN users ON carts.`user_id` = users.`id`
                                    WHERE users.`id` =? AND carts.`status`= "notyet"', array($id));
        return view('user.cart', compact('id', 'products', 'images', 'discounts', 'count_carts', 'sub_total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'qty' => 'integer',
        ]);
        $carts = Cart::find($id);
        $cek = DB::table('products')->select('products.*')->where('products.id', '=', $carts->product_id)->first();
        if ($cek->stock < $request->qty) {
            return redirect()->back()->with(['notif' => 'Maaf Stock Permintaan tidak Mencukupi untuk dipesan.']);
        }else{
            $carts->qty = $request->qty;
            $carts->save();
            $sub_total = DB::select('SELECT SUM(carts.`qty`*products.`price`) AS subtotal
                                        FROM carts JOIN products ON products.`id` = carts.`product_id`
                                        JOIN users ON carts.`user_id` = users.`id`
                                        WHERE users.`id` =? AND carts.`status`= "notyet"', array($request->user_id));
            return redirect()->back()->with(['notif' => 'Berhasil Mengupdate Keranjang!']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function delete($id){
        $carts = Cart::find($id);
        $carts->delete();
        return redirect()->back();
    }

    public function checkout_status($id){
            $id_cart = DB::table('carts')->select('carts.*')->where('carts.deleted_at', '=', null)
                    ->where('carts.status', '=', 'notyet')
                    ->where('user_id', '=', $id)->get();
            foreach ($id_cart as $cart) {
                $carts = Cart::find($cart->id);
                $carts->status = "checkedout";
                $carts->save();
            }
            return redirect('transactions/'.$id);
        
    }
    public function cancel_checkout($id){
        $id_cart = DB::table('carts')->select('carts.*')->where('carts.deleted_at', '=', null)
                    ->where('carts.status', '=', 'checkedout')
                    ->where('user_id', '=', $id)->get();

        foreach ($id_cart as $cart) {
                $carts = Cart::find($cart->id);
                $carts->status = "notyet";
                $carts->save();
            }
        return redirect('carts/'.$id);
    }
}

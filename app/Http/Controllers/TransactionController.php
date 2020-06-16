<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use App\Province;
use App\City;
use App\Courier;
use App\Cart;
use App\User;
use App\Discount;
use App\Product;
use App\DetailTransaction;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Admin;
use App\Notifications\AdminNotification;
class TransactionController extends Controller
{
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
        $t = mktime(date('H')+8, date('i'), date('s'), date('m'), date('d')+1, date('Y'));
        $besok = date('Y-m-d H:i:s', $t);
        $kabupaten = City::where('cities.city_id', '=', $request->city_destination)->first();
        $provinsi = Province::where('provinces.province_id', $request->province_destination)->first();
        $transaction = new Transaction;
        $transaction->regency = $kabupaten->title;
        $transaction->timeout = date('Y-m-d H:i:s', $t);
        $transaction->address = $request->address;
        $transaction->province = $provinsi->title;
        $transaction->total = $request->subtotal+$request->ongkir;
        $transaction->shipping_cost = $request->ongkir;
        $transaction->sub_total = $request->subtotal;
        $transaction->user_id = Auth::user()->id;
        $transaction->courier_id = $request->courier;
        $transaction->proof_of_payment = "belum dibayar";
        $transaction->status = "unverified";
        $transaction->save();
        $admin = Admin::find(1);
        $notif = 'Ada Transaksi Baru!';
        $admin->notify(new AdminNotification($notif));
        $id_cart = DB::table('carts')->select('carts.*')->where('carts.deleted_at', '=', null)
                    ->where('carts.status', '=', 'checkedout')
                    ->where('user_id', '=', Auth::user()->id)->get();
        $diskon = 0;
        foreach ($id_cart as $cart) {
            $discounts = Discount::where('discounts.end', '>', date('Y-m-d'))->get();
            $carts = Cart::find($cart->id);
            $product = Product::where('id', '=', $cart->product_id)->first();
            foreach ($discounts as $discount) {
                if($discount->id_product == $cart->product_id){
                    $diskon = $discount->percentage;
                    break;
                }
            }
            $detail_transaction = new DetailTransaction;
            $detail_transaction->transaction_id = $transaction->id;
            $detail_transaction->product_id = $product->id;
            $detail_transaction->qty = $cart->qty;
            $detail_transaction->discount = $diskon;
            $detail_transaction->selling_price = $product->price;
            $detail_transaction->save();
            $carts->status = "sold";
            $carts->save();
        }
        return redirect('/users/'.Auth::user()->id.'/invoice');
    }

    public function getOngkir(Request $request){
        $cost = RajaOngkir::ongkosKirim([
            'origin'    => 94,
            'destination' => $request->city_id,
            'weight' => $request->weight,
            'courier' => $request->courier
        ])->get();
        $msg = $cost[0]['costs'][$request->paket]['cost'][0]['value'];
        return response()->json(['ongkir'=>$msg]);
    }

    public function getService(Request $request){
        $cost = RajaOngkir::ongkosKirim([
            'origin'    => 240,
            'destination' => $request->city_id,
            'weight' => $request->weight,
            'courier' => $request->courier
        ])->get();
        $msg = $cost[0]['costs'];
        return response()->json(['ongkir'=>$msg]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $count_carts = Cart::where('user_id', '=', Auth::user()->id)->where('carts.status', '=', 'notyet')->count('id');
        $products = DB::table('products')->join('carts', 'carts.product_id', '=', 'products.id')
                        ->join('users', 'users.id', '=', 'carts.user_id')
                        ->select('products.*', 'carts.qty')
                        ->where('carts.status', '=', 'checkedout')
                        ->where('users.id', '=', Auth::user()->id)->get();
        $user = User::find($id);
        $discounts = Discount::where('discounts.end' , '>', date('Y-m-d'))->get();
        $provinces = Province::pluck('title', 'province_id');
        $couriers = Courier::pluck('title', 'code');
        return view('user.checkout', compact('count_carts', 'products', 'user', 'discounts', 'couriers', 'provinces'));
    }

    public function getCities($id){
        $city = City::where('province_id', '=', $id)->pluck('title', 'city_id');
        return json_encode($city);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function checkout_no_cart(Request $request, $id){
        $product = Product::find($id);
        if ($product->stock < $request->qty) {
            return redirect()->back()->with(['notif'=>"Stock tidak mencukupi"]);
        }else{
            $cart = new Cart;
            $cart->product_id = $id;
            $cart->qty = $request->qty;
            $cart->user_id = Auth::user()->id;
            $cart->status = "checkedout";
            $cart->save();
            return redirect('transactions/'.Auth::user()->id);
        }
    }
}

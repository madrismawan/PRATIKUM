<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\User;
use App\Cart;
use App\Discount;
use DB;
use Auth;
use App\Transaction;
use App\Admin;
use App\Notifications\AdminNotification;
class UserController extends Controller
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
        $products = DB::table('products')->orderby('products.id', 'desc')->paginate(9);
        $title = "HOME";
        $count_product = DB::table('products')->where('products.deleted_at', '=', NULL)->count('products.id');
        $product_carts = DB::table('carts')
                    ->join('products', 'products.id', '=', 'carts.product_id')
                    ->join('users', 'users.id', '=', 'carts.user_id')
                    ->select('products.*', 'carts.qty', 'carts.id AS cart_id')
                    ->where('carts.deleted_at', '=', null)
                    ->where('carts.user_id', '=', Auth::user()->id)->get();
        $product_images = DB::table('product_images')->select('product_images.*')->get();
        $categories = DB::table('product_categories')->select('product_categories.*')->get();
        $discounts = Discount::where('discounts.end', '>', date('Y-m-d'))->get();
        return view('user.home', compact('products', 'product_carts', 'product_images', 'categories', 'discounts', 'title', 'count_product'));
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
        $product = Product::find($id);
        $images = DB::table('product_images')
                ->join('products', 'products.id', '=', 'product_images.product_id')
                ->select('product_images.image_name')
                ->where('products.id', '=', $id)->get();
        $sum_image = DB::table('product_images')->where('product_images.product_id', '=', $id)
                            ->count('product_images.id');
        $product_carts = DB::table('carts')
                    ->join('products', 'products.id', '=', 'carts.product_id')
                    ->join('users', 'users.id', '=', 'carts.user_id')
                    ->select('products.*', 'carts.qty', 'carts.id AS cart_id')
                    ->where('carts.deleted_at', '=', null)
                    ->where('carts.user_id', '=', Auth::user()->id)->get();
        $image_carts = DB::table('product_images')->select('product_images.*')->get();
        $categories = DB::table('product_categories')->select('product_categories.*')->get();
        $discount = Discount::where('id_product', '=', $id)->orderby('end', 'desc')->first();

        $reviews = DB::table('product_reviews')->join('products', 'products.id', '=', 'product_reviews.product_id')
                ->join('users', 'users.id', '=', 'product_reviews.user_id')
                ->select('product_reviews.*', 'users.name')
                ->where('products.id', '=', $id)->orderby('product_reviews.id', 'desc')->get();
        $response = DB::table('response')->join('product_reviews', 'product_reviews.id', '=', 'response.review_id')
                ->join('admins', 'admins.id', '=', 'response.admin_id')
                ->select('admins.name', 'response.*')->get();

        return view('user.product_detail', compact('product', 'images', 'sum_image', 'id', 'product_carts', 'image_carts', 'categories', 'discount','reviews', 'response'));
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
    public function destroy($id)
    {
        //
    }

    public function invoice($id){
        $transactions = DB::table('transactions')->select('transactions.*')->where('transactions.user_id', '=', $id)
        ->orderby('id', 'desc')->paginate(10);
        return view('user.invoice', compact('transactions'));
    }

    public function getInvoice($id){
        $transaction = DB::table('transactions')->select('transactions.*')->where('transactions.id', '=', $id)->first();
        $products = DB::table('transaction_details')->join('products', 'products.id', '=', 'transaction_details.product_id')
                    ->select('transaction_details.*', 'products.weight', 'products.product_name')
                    ->where('transaction_details.transaction_id', '=', $transaction->id)->get();
        $reviews = DB::table('product_reviews')->select('product_reviews.*')->where('product_reviews.transaction_id', '=', $id)->get();
        return view('user.invoice_detail', compact('transaction', 'products', 'reviews'));
    }

    public function search_category(Request $request){
        $product_images = DB::table('product_images')->select('product_images.*')->get();
        $categories = DB::table('product_categories')->select('product_categories.*')->get();
        $discounts = Discount::where('discounts.end', '>', date('Y-m-d'))->get();
        $title = "HASIL PENCARIAN";
        $products = DB::table('products')
                    ->join('product_category_details', 'products.id', 'product_category_details.product_id')
                    ->join('product_categories', 'product_categories.id', 'product_category_details.category_id')
                    ->select('products.*')->where('products.category', '=', $request->kind)
                    ->where('product_categories.id', '=', $request->category)
                    ->where('product_category_details.deleted_at', '=', NULL)
                    ->orderby('products.id', 'desc')->paginate(9);
        $count_product = DB::table('products')
                    ->join('product_category_details', 'products.id', 'product_category_details.product_id')
                    ->join('product_categories', 'product_categories.id', 'product_category_details.category_id')
                    ->where('product_categories.id', '=', $request->category)
                    ->where('product_category_details.deleted_at', '=', NULL)
                    ->where('products.deleted_at', '=', NULL)
                    ->count('products.id');
        return view('user.home', compact('products', 'product_images', 'categories', 'discounts', 'title', 'count_product'));
    }

    public function uploadPOP(Request $request, $id){
        $image = $request->proof_of_payment;
        $nama_image = time()."_".$image->getClientOriginalName();
        $folder = 'image/proof_of_payment';
        $image->move($folder,$nama_image);
        $transaction = Transaction::find($id);
        $transaction->proof_of_payment = $nama_image;
        $transaction->save();
        $notif = 'Ada Transaksi Baru!';
        $admin = Admin::find(1);
        $admin->notify(new AdminNotification($notif));
        return redirect()->back()->with(['notif' => "Bukti Pembayaran telah Diupload"]);
    }

    public function search(Request $request){
        $product_images = DB::table('product_images')->select('product_images.*')->get();
        $categories = DB::table('product_categories')->select('product_categories.*')->get();
        $discounts = Discount::where('discounts.end', '>', date('Y-m-d'))->get();
        $title = "HASIL PENCARIAN";
        $products = DB::table('products')
                        ->select('products.*')
                        ->where('products.product_name', 'LIKE', '%'.$request->search.'%')
                        ->orderby('products.id', 'desc')->paginate(9);
        $count_product = DB::table('products')->where('products.product_name', 'LIKE', '%'.$request->search.'%')->where('deleted_at', '=', NULL)->count('products.id');
        return view('user.home', compact('products', 'product_images', 'categories', 'discounts', 'title', 'count_product'));
    }

    public function confirmation($id){
        $transaction = Transaction::find($id);
        $transaction->status = "success";
        $transaction->save();
        return redirect()->back()->with(['notif' => "Terima Kasih Telah Berbelanja"]);
    }

    public function cancel_transaction($id){
        $transaction = Transaction::find($id);
        $transaction->status = "canceled";
        $transaction->save();
        return redirect()->back()->with(['notif' => "Transaksi telah dibatalkan"]);
    }

    public function marknotif(){
        $user = User::find(Auth::user()->id);
        $user->unreadNotifications()->update(['read_at' => now()]);
        return redirect()->back();
    }
}

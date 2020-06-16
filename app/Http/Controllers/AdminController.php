<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\Product;
use App\User;
use App\Admin;
use App\Notifications\UserNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Charts\AdminChart;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:admin','authAdmin:admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tahun = CARBON::NOW()->format('Y');
        $result = DB::table('transactions')
                    ->select(DB::raw('COALESCE(SUM(total),0) AS pendapatan'), DB::raw('MONTH(created_at) AS bulan'))
                    ->where(DB::raw('YEAR(created_at)'),'=', $tahun)
                    ->where('status','=','success')
                    ->groupBy(DB::raw('MONTH(created_at)'))
                    ->get();
        return view('admin.home', compact('tahun', 'result'));
    }

    public function orderNew(){
        $status = "UNVERIFIED";
        $transactions = DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.user_id')
            ->select('transactions.*', 'users.name')
            ->where('transactions.status', '=', 'unverified')
            ->orderby('transactions.created_at', 'desc')->paginate(10);
        return view('admin.cek_order', compact('transactions', 'status'));
    }

    public function orderProces(){
        $status = "VERIFIED DAN DELIVERED";
        $transactions = DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.user_id')
            ->select('transactions.*', 'users.name')
            ->where('transactions.status', '=', 'verified')
            ->orWhere('transactions.status', '=', 'delivered')
            ->orderby('transactions.created_at', 'desc')->paginate(10);
        return view('admin.cek_order', compact('transactions', 'status'));
    }

    public function orderSuccess(){
        $status = "SUCCESS";
        $transactions = DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.user_id')
            ->select('transactions.*', 'users.name')
            ->where('transactions.status', '=', 'success')
            ->orderby('transactions.created_at', 'desc')->paginate(10);
        return view('admin.cek_order', compact('transactions', 'status'));
    }

    public function orderCancel(){
        $status = "CANCELED AND EXPIRED";
        $transactions = DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.user_id')
            ->select('transactions.*', 'users.name')
            ->where('transactions.status', '=', 'canceled')
            ->orWhere('transactions.status', '=', 'expired')
            ->orderby('transactions.created_at', 'desc')->paginate(10);
        return view('admin.cek_order', compact('transactions', 'status'));
    }

    public function orderDetail($id){
        $transaction = DB::table('transactions')
        ->join('users', 'users.id', '=', 'transactions.user_id')
        ->select('transactions.*', 'users.name')
        ->where('transactions.id', '=', $id)->first();
        return view('admin.edit_status_order', compact('transaction'));
    }

    public function orderUpdate(Request $request, $id){
        $transaction = Transaction::find($id);
        $transaction->status = $request->status;
        $transaction->save();
        $user = User::find($transaction->user_id);
        $user->notify(new UserNotification("<a href ='/users/invoice/".$transaction->id."'>Status Transaksimu dengan id ".$transaction->id." telah diupdate</a>"));
        if ($request->status=='unverified') {
            return redirect('admin/order/new')->with(['notif' => "Status Transaksi Sukses Diupdate"]);
        }elseif($request->status=='canceled'){
            return redirect('admin/order/cancel')->with(['notif' => "Status Transaksi Sukses Diupdate"]);
        }elseif($request->status=='delivered'){
            $transaction_detail = DB::table('transaction_details')->where('transaction_details.transaction_id', '=', $id)->get();
            foreach ($transaction_detail as $item) {
                $product = Product::find($item->product_id);
                $product->stock = $product->stock - $item->qty;
                $product->save();
            }
            return redirect('admin/order/process')->with(['notif' => "Status Transaksi Sukses Diupdate"]);
        }elseif($request->status == 'verified'){
            return redirect('admin/order/process')->with(['notif' => "Status Transaksi Sukses Diupdate"]);
        }
    }

    public function markReadAdmin(){
        $admin = Admin::find(1);
        $admin->unreadNotifications()->update(['read_at' => now()]);
        return redirect()->back();
    }

    public function chart(){
        $tahun = CARBON::NOW()->format('Y');
        $result = DB::table('transactions')
                    ->select(DB::raw('COALESCE(SUM(total),0) as pendapatan'), DB::raw('MONTH(created_at) as bulan'))
                    ->where(DB::raw('YEAR(created_at)'),'=', $tahun)
                    ->where('status','=','success')
                    ->groupBy(DB::raw('MONTH(created_at)'))
                    ->get();
        return response()->json($result);
    }

}

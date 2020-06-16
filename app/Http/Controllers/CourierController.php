<?php

namespace App\Http\Controllers;

use App\Courier;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use PDF;

class CourierController extends Controller
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
    public function index()
    {
        $couriers['couriers'] = Courier::where('deleted_at','=',NULL)->orderby('id','desc')->paginate(5);
        return view('courier.home', $couriers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courier.create');
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
            'email' => 'attribute Format Email Salah',
        ];

        $this->validate($request,[
            'courier' => 'required|unique:couriers|max:100',
        ],$messages);

        $couriers = new Courier;
        $couriers->courier = $request->courier;
        $couriers->save();
        return Redirect::to('couriers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function show(Courier $courier)
    {
        return view('courier.show', compact('courier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $data['courier'] = Courier::where($where)->first();
        return view('courier.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Courier  $courier
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
            'courier' => 'required|unique:couriers|max:100',
        ],$messages);

        $update = [
            'courier' => $request->courier,
        ];
        Courier::where('id', $id)->update($update);
        return Redirect::to('couriers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Courier  $courier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Courier::where('id', $id)->delete();
        return Redirect::to('couriers');
    }

    public function soft_delete($id){
        $couriers = Courier::find($id);
        $couriers->delete();
        return Redirect::to('couriers');
    }

    public function trash(){
        $couriers['couriers'] = DB::table('couriers')->where('deleted_at','!=',NULL)->orderby('id','desc')->paginate(5);
        return view('courier.trash', $couriers);
    }

    public function restore($id){
        $couriers = Courier::onlyTrashed()->where('id',$id);
        $couriers->restore();
        return Redirect::to('couriers-trash');
    }

    public function restore_all(){
        $couriers = Courier::onlyTrashed();
        $couriers->restore();
        return Redirect::to('couriers-trash');   
    }

    public function delete($id){
        $couriers = Courier::onlyTrashed()->where('id', $id);
        $couriers->forceDelete();
        return Redirect::to('couriers-trash');
    }

    public function delete_all($id){
        $couriers = Courier::onlyTrashed();
        $couriers->forceDelete();
        return Redirect::to('couriers-trash');
    }
}

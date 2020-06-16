<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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
        $categories['product_categories'] = Category::orderby('id','desc')->paginate(5);
        return view('category.home', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
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
            'category_name' => 'required|unique:product_categories|max:100',
        ],$messages);

        $category = new Category;
        $category->category_name = $request->category_name;
        $category->save();
        return Redirect::to('categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $data['product_category'] = Category::where($where)->first();
        return view('category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
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
            'category_name' => 'required|max:100',
        ],$messages);

        $update = [
            'category_name' => $request->category_name,
        ];
        Category::where('id', $id)->update($update);
        return Redirect::to('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::where('id', $id)->delete();
        return Redirect::to('categories');
    }

    public function soft_delete($id){
        $categories = category::find($id);
        $categories->delete();
        return Redirect::to('categories');
    }

    public function trash(){
        $categories['product_categories'] = DB::table('product_categories')->where('deleted_at','!=',NULL)->orderby('id','desc')->paginate(5);
        return view('category.trash', $categories);
    }

    public function restore($id){
        $categories = Category::onlyTrashed()->where('id',$id);
        $categories->restore();
        return Redirect::to('categories-trash');
    }

    public function restore_all(){
        $categories = Category::onlyTrashed();
        $categories->restore();
        return Redirect::to('categories-trash');   
    }

    public function delete($id){
        $categories = Category::onlyTrashed()->where('id', $id);
        $categories->forceDelete();
        return Redirect::to('categories-trash');
    }

    public function delete_all($id){
        $categories = Category::onlyTrashed();
        $categories->forceDelete();
        return Redirect::to('categories-trash');
    }
}

<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Product_Category_Detail;
use App\Product_image;
use Redirect;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductController extends Controller
{
    public function __construct()
    {
       $this->middleware(['auth:admin','authAdmin:admin']);
    }

	public function index(Request $request){
        /*$products['products'] = Product::orderby('id','desc')->paginate(10);*/
        $products = DB::table('products')
            ->select('products.*')
            ->where('products.deleted_at','=', NULL)
            ->orderby('id','desc')->paginate(10);
        $categories = DB::table('product_categories')
                        ->join('product_category_details', 'product_categories.id', '=', 'product_category_details.category_id')
                        ->select('product_categories.*', 'product_category_details.*')
                        ->where('product_category_details.deleted_at', '=', NULL)
                        ->get();
        return view('product.home',compact('products', 'categories'));
	}

    public function create(){
        $categories['product_categories'] = Category::all();
        return view('product.create', $categories);
    }

    public function store(Request $request){
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
            'product_name' => 'required|max:100',
            'price' => 'required|numeric',
            'stock' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ],$messages);

    	$product = new Product;
    	$product->product_name = $request->product_name;
    	$product->price = $request->price;
    	$product->description = $request->description;
    	$product->product_rate = 0;
    	$product->stock = $request->stock;
    	$product->weight = $request->weight;
        $product->category = $request->category;
    	$product->save();

        foreach ($request->category_id as $categories) {
            $category = new Product_Category_Detail;
            $category->category_id = $categories;
            $category->product_id = $product->id;
            $category->save();
        }

    	return redirect('/addImage/'.$product->id);
    }

    public function show($id){
        $where = array('products.id' => $id);
    	$products = Product::find($id);
        $image = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_images.product_id')
            ->select('product_images.*')
            ->where($where)->get();
        $categories = DB::table('product_categories')
            ->join('product_category_details', 'product_categories.id', '=', 'product_category_details.category_id')
            ->join('products', 'products.id', '=', 'product_category_details.product_id')
            ->select('product_categories.category_name', 'product_category_details.*')
            ->where('products.id', '=', $id)->where('product_category_details.deleted_at', '=', NULL)->get();
        $reviews = DB::table('product_reviews')->join('users', 'users.id', '=', 'product_reviews.user_id')
                ->select('product_reviews.*', 'users.name')->where('product_reviews.product_id', '=',$id)
                ->orderby('product_reviews.id', 'desc')->get();
        $responses = DB::table('response')->select('response.*')->get();
        return view('product.show', compact('products', 'image', 'categories', 'id', 'reviews', 'responses'));
    }

    public function edit($id){
        $categories = DB::table('product_categories')->get();
        $products = Product::find($id);
        $details = DB::table('product_category_details')
                    ->join('products', 'products.id', '=', 'product_category_details.product_id')
                    ->select('product_category_details.*')
                    ->where('products.id', '=', $id)
                    ->get();
        return view('product.edit', compact('categories', 'products', 'details', 'id'));
    }

    public function update(Request $request, $id){
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
            'price' => 'required|numeric',
            'stock' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ],$messages);

        $update = [
            'product_name' => $request->product_name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'weight' => $request->weight,
        ];
        Product::where('id', $id)->update($update);
        return Redirect::to('products');
    }

    public function soft_delete($id){
        $products = Product::find($id);
        $products->delete();
        return Redirect::to('products');
    }

    public function destroy($id){
        Product::where('id', $id)->delete();
        return Redirect::to('products');    
    }

    public function upload($id){
        $products = Product::find($id);
        return view('product.image', compact('products', 'id'));
    }

    public function upload_image(Request $request, $id){
        
        $this->validate($request, [
            'files.*' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        $files = [];
        foreach ($request->file('files') as $file) {
            if($file->isValid()){
                $nama_image = time()."_".$file->getClientOriginalName();
                $folder = 'image/product_image';
                $file->move($folder,$nama_image);
                $files[] = [
                    'product_id' => $id,
                    'image_name' => $nama_image,
                ];
            }
        }

        Product_image::insert($files);
        return Redirect::to('products');
    }

    public function trash(){
         $products['products'] = DB::table('products')
            ->join('product_category_details', 'products.id','=','product_category_details.product_id')
            ->join('product_categories', 'product_categories.id','=','product_category_details.category_id')
            ->select('products.*','product_categories.category_name')
            ->where('products.deleted_at','!=', NULL)
            ->orderby('id','desc')->paginate(10);

        return view('product.trash', $products);
    }

    public function restore($id){
        $products = Product::onlyTrashed()->where('id',$id);
        $products->restore();
        return Redirect::to('products-trash');
    }

    public function restore_all(){
        $products = Product::onlyTrashed();
        $products->restore();
        return Redirect::to('products-trash');   
    }

    public function delete($id){
        $products = Product::onlyTrashed()->where('id', $id);
        $products->forceDelete();
        return Redirect::to('products-trash');
    }

    public function delete_all($id){
        $products = Product::onlyTrashed();
        $products->forceDelete();
        return Redirect::to('products-trash');
    }

    public function soft_delete_category($id){
        $category_detail = Product_Category_Detail::find($id);
        $category_detail->delete();
        return redirect()->back();
    }

    public function add_category($id){
        $product = Product::find($id);
        $categories = Category::all();
        $category_details = DB::table('products')
            ->join('product_category_details', 'products.id', '=', 'product_category_details.product_id')
            ->select('product_category_details.*')
            ->where('products.id', '=', $id)->where('product_category_details.deleted_at', '=', NULL)
            ->get();
        return view('product.create_category', compact('product', 'categories' , 'category_details','id'));
    }

    public function store_category(Request $request){
        $category_detail = new Product_Category_Detail;
        $category_detail->category_id = $request->category_id;
        $category_detail->product_id = $request->product_id;
        $category_detail->save();
        return redirect('/products/'.$request->product_id);
    }
}

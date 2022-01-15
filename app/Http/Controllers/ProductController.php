<?php
    
namespace App\Http\Controllers;
    
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
    
class ProductController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    function __construct()
    {
        $this->middleware('permission:GET::permission/products/create', ['only' => ['create','store']]);
        $this->middleware('permission:GET::permission/products', ['only' => ['index']]);
        $this->middleware('permission:GET::permission/products/{product}', ['only' => ['show']]);
        $this->middleware('permission:GET::permission/products/{product}/edit', ['only' => ['edit','update']]);
        $this->middleware('permission:DELETE::permission/products/{product}', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->call_middleware('users');
        $arrayUser =$this->arr;

        $this->call_middleware('products');
        $arrayProduct =$this->arr;

        $this->call_middleware('roles');
        $arrayRole =$this->arr;

        $this->call_middleware('permissions');
        $arrayPermission =$this->arr;
        
        $products = Product::latest()->paginate(5);
        return view('products.index',compact('products','arrayUser','arrayPermission','arrayProduct','arrayRole'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->call_middleware('users');
        $arrayUser =$this->arr;

        $this->call_middleware('products');
        $arrayProduct =$this->arr;

        $this->call_middleware('roles');
        $arrayRole =$this->arr;

        $this->call_middleware('permissions');
        $arrayPermission =$this->arr;

        return view('products.create',compact('arrayUser','arrayPermission','arrayProduct','arrayRole'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        Product::create($request->all());
    
        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->call_middleware('users');
        $arrayUser =$this->arr;

        $this->call_middleware('products');
        $arrayProduct =$this->arr;

        $this->call_middleware('roles');
        $arrayRole =$this->arr;

        $this->call_middleware('permissions');
        $arrayPermission =$this->arr;

        return view('products.show',compact('product','arrayUser','arrayPermission','arrayProduct','arrayRole'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->call_middleware('users');
        $arrayUser =$this->arr;

        $this->call_middleware('products');
        $arrayProduct =$this->arr;

        $this->call_middleware('roles');
        $arrayRole =$this->arr;

        $this->call_middleware('permissions');
        $arrayPermission =$this->arr;

        return view('products.edit',compact('product','arrayUser','arrayPermission','arrayProduct','arrayRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
         request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        $product->update($request->all());
    
        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
}
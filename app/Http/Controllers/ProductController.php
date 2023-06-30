<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Gate;
use Auth;

class ProductController extends Controller
{

    // list all products
    public function index() 
    {
        $categories = Category::where('status',1)->with(['products'])->get();
        return view('products.index',["categories"=>$categories]);
    }


    // Display form for creating product
    public function create()
    {
        // get current logged in user
        $user = Auth::user();

        if($user->can('create', Product::class)) {
            $categories = Category::all();
            return view('products.create',['categories'=>$categories]);
        }
        abort(403);
    }

     // create a new product
     public function store(Request $request)
     {
        // get current logged in user
        $user = Auth::user();

        if($user->can('create', Product::class)) {
             // validate data
            $request->validate([
                'category_id' => 'required',
                'product_name' => 'required ',
                'product_description' => 'required',
                'product_price' => 'required',
                'product_sale_price' => 'required',
                'product_quantity' => 'required',
                'product_weight' => 'required',
                'product_image' => 'required'
            ]);
            
            $image = $request->file('product_image');
            $image_filename = time().'-'.$image->getClientOriginalName();
            $image->move(public_path('public/Image/Products'),$image_filename);

            Product::create([
                'category_id' => $request->category_id,
                'name' => $request->product_name,
                'description' => $request->product_description,
                'quantity' => $request->product_quantity,
                'weight' => $request->product_weight,
                'price' => $request->product_price,
                'sale_price' => $request->product_sale_price,
                'status' => TRUE,
                'featured' => False,
                'image' => $image_filename
            ]);
            Alert('Created Successfully','New product created successfully.');
            return redirect()->route('products.index');
        }
        abort(403);
        
        
     }

     // Display the specified product
    public function show($id)
    {
        $category = Product::find($id)->category;
        return view('products.show', ['product'=>$product,'category'=>$category]);
      
    }


    // Display form for update category
    public function edit($id) 
    {
        // get current logged in user
        $user = Auth::user();

        if($user->can('update', Product::class)) {
            $product = Product::find($id);
            // if product not found
            if($product == null) return back();
            
            $category = $product->category;
            return view('products.edit', ['product'=>$product,'category'=>$category]);
        }
        abort(403);
    }


    // Update specified
    public function update(Request $request) 
    {
        // get current logged in user
        $user = Auth::user();

        if($user->can('update', Product::class)) {
            // validate data
            $request->validate([
                'category_id' => 'required',
                'product_name' => 'required ',
                'product_description' => 'required ',
                'product_price' => 'required',
                'product_sale_price' => 'required',
                'product_quantity' => 'required',
                'product_weight' => 'required',
            ]);
    
            $product = Product::find($request->id);
            $product->category_id = $request->category_id;
            $product->description = $request->product_description;
            $product->price = $request->product_price;
            $product->sale_price = $request->product_sale_price;
            $product->quantity = $request->product_quantity;
            $product->weight = $request->product_weight;
            
            if($request->file('product_image')){
                // remove existing file
                $image = $product->image;
    
                if(file_exists(public_path().'/public/Image/Products/'.$image) && $image){
                    unlink(public_path().'/public/Image/Products/'.$image);
                }
                
                $file= $request->file('product_image');
                $filename= time().'-'.$file->getClientOriginalName();
                $file-> move(public_path('public/Image/Products'), $filename);
        
                $product->image = $filename;
            }
    
            $product->save();
            Alert('Updated Successfully','Product updated successfully.');
            return redirect()->route('products.index');
        }
        abort(403);
    }


    // Change Category Status
    public function change_status($id) {
        $user = Auth::user();
        
        if($user->can('change_status', Product::class)) {
            $product = Product::find($id);
            $status =  (int) $product->status == 0 ? 1 : 0;
            $product->update(
                ['status' => $status ]
            );
            Alert('Status Changed','Product status created successfully.');
            return redirect('/products');
        }
        abort(403);
    }
}

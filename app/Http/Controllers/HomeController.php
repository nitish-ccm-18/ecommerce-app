<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    // return landing page with all given category and their product 
    public function index(string $category_id = null) {
        // Get all active category
        $categories = Category::all()->where('status', 1);
        // Fetch Product with active category and active product status
        $products = Product::whereHas('category', function($query) { 
            return $query->where('status',1); 
        })->where('status',1)->get();
        
        // find product of incoming category
        if($category_id) $products = $products->where('category_id',$category_id);

        // paginate If there are products
        $products = $products->isNotEmpty() ?  $products->toQuery()->paginate(6): $products;
        
        return view('welcome', ['products' => $products, 'categories' => $categories]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Session;


class AjaxController extends Controller
{
        // Handle request when add to cart is pressed
        public function add_to_cart(Request $request) 
        {
            $total = 0;
            $product_id = $request->product_id;
            
            // find product
            $product = Product::find($product_id);
    
            $cart = Session::get('cart', []);
        
            // check if given product is exist in the cart or not
            if(isset($cart[$product_id])) {
                $cart[$product_id]['quantity']++;
                $cart[$product_id]['subtotal'] += $product->sale_price;
            }else {
                $cart[$product_id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category->name,
                    'price' => $product->sale_price,
                    'image' => $product->image,
                    'quantity' => 1,
                    'subtotal' => $product->sale_price
                ];
            }
            // calculate total
            foreach($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            // Store value in session
            Session::put('cart',$cart);
            Session::put('total',$total);
            Session::forget('coupon');
            return Session::get('cart');
        }

         // Get count of cart items
        public function countCartItems(Request $request) 
        {
            return Session::get('cart') ? count(Session::get('cart')) : 0;
        }
    
}

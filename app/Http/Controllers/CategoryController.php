<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Gate;
use Auth;

class CategoryController extends Controller
{
    public function index() 
    {
        $categories = Category::all();
        return view('categories.index', ['categories'=>$categories]);
    }

    public function create() 
    {
        // get current logged in user
        $user = Auth::user();

        if($user->can('create', Category::class)) {
            return view('categories.create');
        }
        abort(403);
    } 

    public function store(Request $request) 
    {
        // get current logged in user
        $user = Auth::user();

        if($user->can('create', Category::class)) {
            // validate data
            $request->validate([
                'name' => 'required | max:10',
                'description' => 'required',
                'thumbnail' => 'required',
            ]);
    
            $image = $request->file('thumbnail');
            $image_filename = time() . $image->getClientOriginalName();
            $image->move(public_path('public/Image/Categories'),$image_filename);
    
            Category::create([
                'name' => $request->name,
                'description' => $request->description,
                'thumbnail' => $image_filename,
                'status' => TRUE
            ]);
            Alert('Created Successfully','New category created successfully.');
            return redirect()->route('categories.index');
        }
        abort(403);
    } 


    public function edit($id) 
    {
         // get current logged in user
         $user = Auth::user();
        
         if($user->can('update', Category::class)) {
            $category = Category::find($id);
            return view('categories.edit', ['category'=>$category]);
         }
         abort(403);
    }


    public function update(Request $request) 
    {
        // get current logged in user
        $user = Auth::user();
        
        if($user->can('update', Category::class)) {
            // validate data
            $request->validate([
                'name' => 'required | max:10',
                'description' => 'required',
                
            ]);
            $category = Category::find($request->id);
            $category->name = $request->name;
            $category->description = $request->description;
    
            if($request->file('thumbnail')) {
                // remove existing file
                $image = Category::find($request->id)->thumbnail;
                if(file_exists(public_path().'/public/Image/Categories/'.$image) && $image){
                    unlink(public_path().'/public/Image/Categories/'.$image);
                }
    
                $file= $request->file('thumbnail');
                $filename= time().'-'.$file->getClientOriginalName();
                $file-> move(public_path('public/Image/Categories'), $filename);
            
                $category->thumbnail = $filename;
                
            }
            $category->save();
    
            Alert('Updated Successfully','Category updated successfully.');
            return redirect()->route('categories.index');
        }
        abort(403);
    }

    public function show($id) 
    {
        // get current logged in user
        $user = Auth::user();
        
        if($user->can('view', Category::class)) {
            $category = Category::find($id);
            return view('categories.show', ['category'=>$category]);
        }
        abort(403);
    }

    // Change Category Status
    public function change_status($id) {
        $user = Auth::user();
        
        if($user->can('change_status', Category::class)) {
            $category = Category::find($id);
            $status =  (int) $category->status == 0 ? 1 : 0;
            $category->update(
                ['status' => $status ]
            );
            Alert('Status Changed','Category status created successfully.');
            return redirect('/categories');
        }
        abort(403);
    }
}

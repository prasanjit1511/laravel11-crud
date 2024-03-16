<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request){
        //$products = Product::orderBy('created_at','DESC')->paginate(10);
        $products = Product::latest();
        if(!empty($request->get('keyword'))){
            $products =  $products->where('name', 'like','%'.$request->get('keyword').'%');
            $products =  $products->orWhere('sku', 'like','%'.$request->get('keyword').'%');
        }
        $products = $products->paginate(10);

        return view('products.list',[
            'products' => $products
        ]);
    }

    public function create(){
     return view('products.create');
    }

    public function store(Request $request){

        $rules = [
           'name' => 'required|min:5',
           'sku' => 'required|min:3',
           'price' => 'required|numeric',
        ];

        if($request->image != ""){
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            // dd($validator->errors()->all());

            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }
        // product insert
        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;

        if($request->image != ""){

            //image store
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time().'.'.$ext; // unique image name
        
            // save the image to the products directory
            $image->move(public_path('uploads/products/'),$imageName);
        
            //save image filename to the database
            $product->image = $imageName; // Corrected this line
               
        }
        $product->save();

        return redirect()->route('products.index')->with('success','Product added Successfully.');

    }

    public function edit($id){

        $product = Product::findOrfail($id);

        return view('products.edit',[
            'product' => $product
        ]);
    }
    public function update($id, Request $request){

        $product = Product::findOrfail($id);

        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric',
         ];
 
         if($request->image != ""){
             $rules['image'] = 'image';
         }
 
         $validator = Validator::make($request->all(),$rules);
 
         if($validator->fails()){
 
             // dd($validator->errors()->all());
 
             return redirect()->route('products.edit',$product->id)->withInput()->withErrors($validator);
         }
         // product insert
         
         $product->name = $request->name;
         $product->sku = $request->sku;
         $product->price = $request->price;
         $product->description = $request->description;
 
         if($request->image != ""){

            // old delete images
            File::delete(public_path('uploads/products/'.$product->image));
 
             //image store
             $image = $request->image;
             $ext = $image->getClientOriginalExtension();
             $imageName = time().'.'.$ext; // unique image name
         
             // save the image to the products directory
             $image->move(public_path('uploads/products/'),$imageName);
         
             //save image filename to the database
             $product->image = $imageName; // Corrected this line
                
         }
         $product->save();
 
         return redirect()->route('products.index')->with('success','Product Upadted Successfully.');
    }
    public function destroy($id){

        $product = Product::findOrfail($id);

        File::delete(public_path('uploads/products/'.$product->image));

        $product->delete();

        return redirect()->route('products.index')->with('success','Product deleted Successfully.');


    }
}

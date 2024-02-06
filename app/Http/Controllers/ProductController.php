<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\units;
use App\Models\Prices;
use Illuminate\Support\Str;
use App\Models\BranchStock;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
       
        return view('products.listproducts',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = units::all();
        $categories = Categories::all();
        return view('products.create',compact('categories','units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'category' => 'required'
        ]);
        $prices = count($request->unit);

        $product = Product::create([
            'product_code' => rand(100,700),
            'product_name' => $request->product_name,
            'product_description' => $request->product_desc,
            'cate_id' => $request->category
        ]);
       

        for($i=0;$i<=$prices;$i++){
           if(isset($request->unit[$i]))
           {
            
                $product = Prices::create([
                    "product_id" => $product->id,
                    "unit" => $request->unit[$i],
                    "size" => $request->qty[$i],
                    "pur_price" => $request->pur_price[$i],
                    "sale_price" => $request->sale_price[$i],
                    "disc" => $request->disc[$i],
                    "stock" => $request->stock[$i],
                    "created_at" => now()
                ]);
                if($request->barcode[$i] == "" || $request->barcode[$i] == 0)
                {
                    Prices::where('id',$product->id)->update([
                        "internal_barcode" => $product->id,
                        "external_barcode" => $product->id
                    ]);
                }
                else
                {
                    Prices::where('id',$product->id)->update([
                        "internal_barcode" => $product->id,
                        "external_barcode" => $request->barcode[$i]
                    ]);
                }
           }
            
        }
        $message = "Product added successfully پروڈکٹ کامیابی کے ساتھ شامل ہو گئی۔";
        return back()->with('message',$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::where('id',$id)->first();
       
        $units = units::all();
        $categories = Categories::all();
        $prices = Prices::where('product_id',$id)->get();
       return view('products.edit',compact('product','units','categories','prices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'product_desc' => 'required',
            'category' => 'required',
            'id' => 'required'
        ]);
        $prices = count($request->unit);
      
        Product::where('id',$request->id)->update([
            'product_name' => $request->product_name,
            'product_description' => $request->product_desc,
            'cate_id' => $request->category
        ]);
        

        Prices::where('product_id',$request->id)->delete();
        for($i=0;$i<=$prices;$i++){
           if(isset($request->unit[$i]))
           {
                $product = Prices::create([
                    "product_id" => $request->id,
                    "unit" => $request->unit[$i],
                    "size" => $request->qty[$i],
                    "pur_price" => $request->pur_price[$i],
                    "sale_price" => $request->sale_price[$i],
                    "disc" => $request->disc[$i],
                    "stock" => $request->stock[$i],
                    "created_at" => now()
                ]);
                if($request->barcode[$i] == "" || $request->barcode[$i] == 0)
                {
                    Prices::where('id',$product->id)->update([
                        "internal_barcode" => $product->id,
                        "external_barcode" => $product->id
                    ]);
                }
                else
                {
                    Prices::where('id',$product->id)->update([
                        "internal_barcode" => $product->id,
                        "external_barcode" => $request->barcode[$i]
                    ]);
                }
           }
            
        }
        $message = "Product updated successfully پروڈکٹ کو کامیابی سے اپ ڈیٹ کیا گیا۔";
        return back()->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Product::where('id',$request->id)->update([
            'disable' => 1
        ]);
        $message = "Product disabled successfully پروڈکٹ کو کامیابی سے غیر فعال کر دیا گیا۔";
        return back()->with('message',$message);
    }

    public function restore(Request $request)
    {
        Product::where('id',$request->id)->update([
            'disable' => 0
        ]);
        $message = "Product enabled successfully پروڈکٹ کو کامیابی سے فعال کر دیا گیا۔";
        return back()->with('message',$message);
    }

    public function getsizes($product_id){
        $sizes = Prices::where('product_id',$product_id)->get();
        return response()->json([
            'sizes' => $sizes,
            'product_id' => $product_id
        ]);
    }
    public function getpurprices($id){
        $prices = Prices::where('id',$id)->first();
        return response()->json([
          'price' => $prices  
        ]);
    }
    public function getsalesizes($product_id){
        $sizes = BranchStock::where('product_id',$product_id)
        ->where('branch_id',auth()->user()->branch_id)
        ->get();
        return response()->json([
            'sizes' => $sizes,
            'product_id' => $product_id
        ]);
    }
    public function getsaleprices($id){
        $prices = DB::table('branch_stocks')
        ->join('prices','branch_stocks.product_id','=','prices.product_id')
        ->where('branch_stocks.id',$id)
        ->select('branch_stocks.*','prices.sale_price')
        ->first();
        return response()->json([
          'price' => $prices  
        ]);
    }

}

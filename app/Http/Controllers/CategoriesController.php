<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\Product;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        return view('categories.listcategories',compact('categories'));
    }

    public static function product_counter($cate_id){
        return Product::where('cate_id',$cate_id)->count('id');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cate_name' => 'required'
        ]);

        $check = Categories::where('cate_name',$request->cate_name)->first();
       
        if($check){
            $message = "Category already exist. زمرہ پہلے سے موجود ہے۔";
        } 
        else
        {
            $category = Categories::insert([
                'cate_name' => $request->cate_name
            ]);
            if($category){
                $message = 'Category Saved Successfully زمرہ کامیابی سے محفوظ ہو گیا۔';
            }
            else
            {
                $message = 'Category not saved زمرہ محفوظ نہیں ہوا۔';
            }
        }
      
        return back()->with('message',$message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $update = Categories::where('id',$request->id)->update([
            'cate_name' => $request->cate_name
        ]);
        if($update){
            $message = 'Category updated. زمرہ کامیابی سے اپ ڈیٹ ہو گیا۔';
        }
        return back()->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
       
        $delete = Categories::where('id',$request->id)->delete();
        if($delete){
            $message = 'Category deleted. زمرہ کامیابی سے حذف کر دیا گیا۔';
        }
        return back()->with('message',$message);

    }
}

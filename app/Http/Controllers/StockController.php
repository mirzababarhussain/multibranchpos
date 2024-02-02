<?php

namespace App\Http\Controllers;

use App\Models\Branches;
use App\Models\BranchStock;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Prices;
class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('disable',0)->get();
        $branches = Branches::where('disable',0)->get();
        return view('stock.liststock', compact('products','branches'));
    }

    static function stock($id,$branch_id){

        if($branch_id > 0){
            return BranchStock::where('branch_id',$branch_id)->where('product_id',$id)->get();
        }
        else
        {

            return Prices::where('product_id',$id)->get();
        }
    }
    public function branch_stock($id){
        $products = DB::table('branch_stocks')
        ->join('products','branch_stocks.product_id','=','products.id')
        ->select('products.*','branch_stocks.branch_id as branch_id')
        ->where('branch_stocks.branch_id',$id)
        ->get();
        $branches = Branches::where('disable',0)->get();
        $selected_branch = Branches::where('id',$id)->first();
        return view('stock.branchstock', compact('products','selected_branch'));
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
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id = $request->branch_id;
        
        if($id == 0){
            return redirect(route('stock'));
        }
        else
        {
            $products = DB::table('branch_stocks')
            ->join('products','branch_stocks.product_id','=','products.id')
            ->select('products.*','branch_stocks.branch_id as branch_id')
            ->where('branch_stocks.branch_id',$id)
            ->get();
            $branches = Branches::where('disable',0)->get();
            $selected_branch = Branches::where('id',$id)->first();
            return view('stock.liststock', compact('products','branches','selected_branch'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}

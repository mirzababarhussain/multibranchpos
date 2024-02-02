<?php

namespace App\Http\Controllers;

use App\Models\Prices;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\units;
use App\Models\Purchasemaster;
use App\Models\Ledger;
use App\Models\Vendorbalance;
use App\Models\Invaccounts;
use Illuminate\Support\Facades\DB;
class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = DB::table('purchasemasters')
        ->join('vendors', 'purchasemasters.vendor_id','=','vendors.id')
        ->select('purchasemasters.*','vendors.v_name','vendors.v_address','vendors.v_phone')
        ->orderBy('vendors.id','desc')->get();
        return view('purchases.listpurchases',compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $check_pending = Purchasemaster::where('pur_status','initiated')->first();
        
        if($check_pending)
        {
            $master = Purchasemaster::where('id',$check_pending->id)->first();
        }
        else
        {
            $master = Purchasemaster::create([ 'pur_date' => date('d/m/Y')]);

        }
       
        $vendors = Vendor::where('v_disable',0)->get();
        $products = Product::where('disable',0)->get();
        $units = units::all();
        return view('purchases.create', compact('vendors','products','units','master'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $size = Prices::where('id',$request->size)->first();
        $check = Purchase::where([
            'master_id' => $request->pur_id,
            'product_id' => $request->product_id,
            'size_desc' => $size->size,
            'unit' => $size->unit
            ])->first();
        if($check){

            $update_qty =  $request->qty + $check->pur_qty;
            Purchase::where('id',$check->id)->update([
                'pur_price' => $request->pur_price,
                'pur_qty' => $update_qty,
                'line_total' => $update_qty * $request->pur_price
            ]);
        }
        else
        {
            Purchase::create([
                'master_id' => $request->pur_id,
                'product_id' => $request->product_id,
                'size_desc' => $size->size,
                'unit' => $size->unit,
                'pur_price' => $request->pur_price,
                'pur_qty' => $request->qty,
                'line_total' => $request->qty * $request->pur_price
            ]);
        }
      

        return response()->json([
            'msg' => 'ok'
        ]);
    }

    public function getproducts($id){
        $products = DB::table('purchases')
        ->select('purchases.*','products.product_name','products.product_code')
        ->join('products','purchases.product_id','products.id')
        ->where('purchases.master_id',$id)->get();
        $sum = Purchase::where('master_id',$id)->sum('line_total');
        return response()->json([
            'products' => $products,
            'total_purchase' => number_format($sum) 
        ]);
    }

    public function delete_row($id){
        Purchase::where('id',$id)->delete();
        return response()->json([
            'msg' => 'ok'
        ],200);
    }

    public function confirm_status(Request $request){
        $sum = Purchase::where('master_id',$request->id)->sum('line_total');
        Purchasemaster::where('id',$request->id)->update([
            'pur_status' => $request->status,
            'vendor_id' => $request->vendor_id,
            'pur_date' => $request->pur_date,
            'total_pur' => $sum
        ]);
        $purmasterdata = Purchasemaster::where('id',$request->id)->first();
        if($request->status == 'Confirm'){
            // Update Stock
            $purchases = Purchase::where('master_id',$request->id)->get();
            $newStock = 0;
            foreach($purchases as $purchase){

                $stock = Prices::where('product_id',$purchase->product_id)
                ->where('unit',$purchase->unit)
                ->where('size',$purchase->size_desc)
                ->first();
                $newStock = $stock->stock + $purchase->pur_qty;
                Prices::where('product_id',$purchase->product_id)
                ->where('unit',$purchase->unit)
                ->where('size',$purchase->size_desc)
                ->update(['stock'=>$newStock]);

          
            }

              // Vendor Balance

              $vbalance = Invaccounts::where('account_id',$purmasterdata->vendor_id)->where('account_type','vendor')->first();
              $newbalance = $vbalance->balance + $sum;
              Invaccounts::where('account_id',$purmasterdata->vendor_id)->where('account_type','vendor')->update(['balance' => $newbalance]);
              
              // Payable inventory entry in Vendor
              Ledger::create([
                  'account_id' => $purmasterdata->vendor_id,
                  'account_type' => 'vendor',
                  'trans_detail' => 'purchase @'.$request->id,
                  'debit' =>0,
                  'credit' =>$sum,
                  'balance' => $newbalance
              ]);
              $pbalance = Invaccounts::where('account_type','purchase')->first();
              $pnewbalance = $pbalance->balance + $sum;
              Invaccounts::where('account_type','purchase')->update(['balance' => $pnewbalance]);

              Ledger::create([
                'account_id' => $request->id,
                'account_type' => 'purchase',
                'trans_detail' => 'vendor @'.$purmasterdata->vendor_id,
                'debit' =>$sum,
                'credit' =>0,
                'balance' => $pnewbalance
            ]);
        }
       
        return response()->json([
            'msg' => 'ok'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $master = DB::table('purchasemasters')
        ->join('vendors', 'purchasemasters.vendor_id','=','vendors.id')
        ->select('purchasemasters.*','vendors.v_name','vendors.v_address','vendors.v_phone','vendors.v_email')
        ->where('purchasemasters.id',$id)->first();
        if($master->pur_status == 'Confirm'){

            return view('purchases.show',compact('master'));
        }
        else{
            $vendors = Vendor::where('v_disable',0)->get();
            $products = Product::where('disable',0)->get();
            $units = units::all();
            return view('purchases.create', compact('vendors','products','units','master'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}

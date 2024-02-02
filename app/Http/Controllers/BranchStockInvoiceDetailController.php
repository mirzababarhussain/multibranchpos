<?php

namespace App\Http\Controllers;

use App\Models\BranchStockInvoiceDetail;
use Illuminate\Http\Request;
use App\Models\Prices;
use Illuminate\Support\Facades\DB;
use App\Models\BranchStock;
use App\Models\BranchStockInvoice;

class BranchStockInvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $size = Prices::where('id',$request->size)->first();
        $check = BranchStockInvoiceDetail::where([
            'stock_inv_id' => $request->pur_id,
            'product_id' => $request->product_id,
            'size' => $size->size,
            'unit' => $size->unit
            ])->first();
        if($check){

            $update_qty =  $request->qty + $check->issued_stock;
            BranchStockInvoiceDetail::where('id',$check->id)->update([
                'issued_stock' => $update_qty,
            ]);
        }
        else
        {
            BranchStockInvoiceDetail::create([
                'stock_inv_id' => $request->pur_id,
                'product_id' => $request->product_id,
                'size' => $size->size,
                'unit' => $size->unit,
                'issued_stock' => $request->qty,
            ]);
        }
      

        return response()->json([
            'msg' => 'ok'
        ]);
    }

    public function getproducts($id){
        $products = DB::table('branch_stock_invoice_details')
        ->select('branch_stock_invoice_details.*','products.product_name','products.product_code')
        ->join('products','branch_stock_invoice_details.product_id','products.id')
        ->where('branch_stock_invoice_details.stock_inv_id',$id)->get();
        $sum = BranchStockInvoiceDetail::where('stock_inv_id',$id)->sum('issued_stock');
        return response()->json([
            'products' => $products,
            'total_purchase' => $sum 

        ]);
    }

    public function delete_row($id){
        BranchStockInvoiceDetail::where('id',$id)->delete();
        return response()->json([
            'msg' => 'ok'
        ],200);
    }

    public function confirm_stock_receving(Request $request){

        BranchStockInvoice::where('id',$request->id)
        ->update([
            'inv_status' => $request->status
        ]);

        $stock_inv_data = BranchStockInvoice::where('id',$request->id)->first();

        if($request->status == 'Confirm')
        {
            // Update Stock
            
            $stocklists = BranchStockInvoiceDetail::where('stock_inv_id',$request->id)->get();
            $newStock = 0;
            foreach($stocklists as $stocklist)
            {

                $stock = BranchStock::where('branch_id',$stock_inv_data->branch_id)
                ->where('product_id',$stocklist->product_id)
                ->where('unit',$stocklist->unit)
                ->where('size',$stocklist->size)
                ->first();

                
                if($stock){
                    $newStock = $stock->stock + $stocklist->issued_stock;
                    BranchStock::where('branch_id',$stock_inv_data->branch_id)
                    ->where('product_id',$stocklist->product_id)
                    ->where('unit',$stocklist->unit)
                    ->where('size',$stocklist->size)
                    ->update(['stock'=>$newStock]);
                }
                else
                {
                    BranchStock::create([
                        'branch_id' => $stock_inv_data->branch_id,
                        'product_id' => $stocklist->product_id,
                        'unit' => $stocklist->unit,
                        'size' => $stocklist->size,
                        'stock'=> $stocklist->issued_stock
                    ]);
                }

                /** Update Main Store Stock */

                $main_stock = Prices::where('product_id',$stocklist->product_id)
               ->where('unit',$stocklist->unit)
               ->where('size',$stocklist->size)->first();

               $new_stock = $main_stock->stock - $stocklist->issued_stock;
               if($new_stock < 0){
                $new_stock = 0;
               }
               Prices::where('product_id',$stocklist->product_id)
               ->where('unit',$stocklist->unit)
               ->where('size',$stocklist->size)
               ->update(['stock' => $new_stock]);
            
            }
                     
        }
        return response()->json([
            'msg' => 'ok'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(BranchStockInvoiceDetail $branchStockInvoiceDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BranchStockInvoiceDetail $branchStockInvoiceDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BranchStockInvoiceDetail $branchStockInvoiceDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BranchStockInvoiceDetail $branchStockInvoiceDetail)
    {
        //
    }
}

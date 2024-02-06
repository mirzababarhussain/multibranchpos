<?php

namespace App\Http\Controllers;

use App\Models\Branches;
use App\Models\BranchStockInvoice;
use App\Models\BranchStockInvoiceDetail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\units;
use Illuminate\Support\Facades\Auth;
use App\Models\BranchStock;
use App\Models\Prices;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class BranchStockInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->branch_id == 1){
            $stock_invoices = DB::table('branch_stock_invoices')
            ->join('branches','branch_stock_invoices.branch_id','=','branches.id')
            ->where('branch_stock_invoices.branch_id',auth()->user()->branch_id)
            ->select('branch_stock_invoices.*','branches.branch_name','branches.branch_address')
            ->get();
        }
        else
        {
            $stock_invoices = DB::table('branch_stock_invoices')
            ->join('branches','branch_stock_invoices.branch_id','=','branches.id')
            ->select('branch_stock_invoices.*','branches.branch_name','branches.branch_address')
            ->get();
        }
      
        return view('stock_inv.list',compact('stock_invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $check_pending = BranchStockInvoice::where('inv_status','Initiated')->first();
        
        if($check_pending)
        {
            $master = BranchStockInvoice::where('id',$check_pending->id)->first();
        }
        else
        {
            $master = BranchStockInvoice::create(
                [ 
                    'stock_inv_date' => date('d/m/Y'),
                    'inv_status' => 'Initiated',
                    'branch_id' => '0',
                    'created_by' => Auth::user()->id
                ]
            
            );

        }
       
        $branches = Branches::where('disable',0)->get();
        $products = Product::where('disable',0)->get();
        $units = units::all();
        return view('stock_inv.create', compact('branches','products','units','master'));
    }

    public function confirm_status(Request $request){
        BranchStockInvoice::where('id',$request->id)->update([
            'inv_status' => $request->status,
            'branch_id' => $request->vendor_id,
            'stock_inv_date' => $request->pur_date,
        ]);
        $stock_inv_data = BranchStockInvoice::where('id',$request->id)->first();

        if($request->status == 'Confirm')
        {
            // Update Stock
            
            $stocklists = BranchStockInvoiceDetail::where('stock_inv_id',$request->id)->get();
            $newStock = 0;
            foreach($stocklists as $stocklist){

                $barcode = Prices::where('product_id',$stocklist->product_id)
               ->where('unit',$stocklist->unit)
               ->where('size',$stocklist->size)->first();
               
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
                    $product = BranchStock::create([
                        'branch_id' => $stock_inv_data->branch_id,
                        'product_id' => $stocklist->product_id,
                        'unit' => $stocklist->unit,
                        'size' => $stocklist->size,
                        'stock'=> $stocklist->issued_stock
                    ]);
                    BranchStock::where('id',$product->id)->update([
                        'external_barcode' => $barcode->external_barcode,
                        'internal_barcode' => $product->id
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $master = DB::table('branch_stock_invoices')
        ->join('branches','branch_stock_invoices.branch_id','=','branches.id')
        ->where('branch_stock_invoices.id',$id)
        ->select('branch_stock_invoices.*','branches.branch_name','branches.branch_address','branches.branch_contact_person','branches.branch_phone')
        ->first();
        $details = DB::table('branch_stock_invoice_details')
        ->join('products','branch_stock_invoice_details.product_id','=','products.id')
        ->where('branch_stock_invoice_details.stock_inv_id',$id)
        ->Select('branch_stock_invoice_details.*','products.*')
        ->get();
        $created_by = DB::table('users')->where('id',$master->created_by)->first();
        $received_by = DB::table('users')->where('id',$master->received_by)->first();
     
        return view('stock_inv.show',compact('master','details','created_by','received_by'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BranchStockInvoice $branchStockInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BranchStockInvoice $branchStockInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BranchStockInvoice $branchStockInvoice)
    {
        //
    }
}

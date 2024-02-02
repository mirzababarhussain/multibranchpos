<?php

namespace App\Http\Controllers;

use App\Models\BranchSaleReturnMaster;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SaleReturnDetail;
use Illuminate\Support\Facades\DB;
use App\Models\BranchStock;
use App\Models\Prices;
use App\Models\Invaccounts;
use App\Models\Ledger;
use PhpParser\Node\Expr\FuncCall;

class BranchSaleReturnMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('disable',0)->get();
        $customers = Customer::where('disable',0)->get();
        $invdata = BranchSaleReturnMaster::where('branch_id',auth()->user()->branch_id)->where('ret_inv_status',0)->first();
        if($invdata){
            $data = $invdata;
        }
        else
        {
           $data =  BranchSaleReturnMaster::create([
                'branch_id' => auth()->user()->branch_id,
                'user_id' => auth()->user()->id,
                'ret_inv_code' => auth()->user()->branch_id."-".rand(11000,20000)."-".date('d').date('m').date('y') //branch_id-randcode-daymonthyear
            ]);
        }
        return view('salereturn',compact('products','customers','data'));
    }
    public function get_returns(){
        $invoices = DB::table('branch_sale_return_masters')
        ->join('customers','branch_sale_return_masters.customer_id','=','customers.id')
        ->where('branch_sale_return_masters.branch_id',auth()->user()->branch_id)
        ->select('branch_sale_return_masters.*','customers.customer_code','customers.name')->get();
        return view('listsalereturn',compact('invoices'));
    }
    public function get_return_view($id){
        $data = DB::table('branch_sale_return_masters')
        ->join('customers','branch_sale_return_masters.customer_id','=','customers.id')
        ->where('branch_sale_return_masters.id',$id)
        ->select('branch_sale_return_masters.*','customers.customer_code','customers.name')->first();
        return view('returnview',compact('data'));
    }
    public function add_return_product(Request $request){
        $id = $request->id;

       $product = DB::table('branch_stocks')
       ->join('prices','branch_stocks.product_id','=','prices.product_id')
       ->where('branch_stocks.id',$id)
       ->select('branch_stocks.*','prices.sale_price')
       ->first();

       $check_already = SaleReturnDetail::where(
        'ret_inv_id',$request->inv_id,
       )->where('product_id',$product->product_id)
       ->where('unit',$product->unit)
       ->where('size',$product->size)
       ->first();

       $new_stock = 0;
       
       if($check_already)
       
       {
       
        $new_stock = $request->sale_qty + $check_already->sale_qty;

        SaleReturnDetail::where('id',$check_already->id)->update([
            'sale_qty' => $new_stock,
            'sub_total' => $product->sale_price * $new_stock
        ]);
       
        }
       else
       {
     
        SaleReturnDetail::create([
                'ret_inv_id' => $request->inv_id,
                'product_id' => $product->product_id,
                'unit' => $product->unit,
                'size' => $product->size,
                'sale_price' => $product->sale_price,
                'sale_qty' => $request->sale_qty,
                'sub_total' => $product->sale_price * $request->sale_qty
            ]);
        }
       return response()->json([
            'message' => $product
       ]);
    }

    public function get_return_products($id){
        $products = DB::table('sale_return_details')
        ->join('products','sale_return_details.product_id','=','products.id')
        ->where('sale_return_details.ret_inv_id',$id)
        ->select('sale_return_details.*','products.product_name','products.product_description','products.product_code')
        ->get();
        return response()->json([
            'products' => $products
        ]);
    }
    public function remove_sale_return_products($id){
        SaleReturnDetail::where('id',$id)->delete();
        return response()->json([
            'message' => 'ok'
        ]); 
    }

    public function confirm_sale_ret_inv(Request $request)
    {

        /** get sale detail */
        $sale_details = SaleReturnDetail::where('ret_inv_id',$request->inv_id)
        ->get();
        $branch_balance = 0;
        $total_profit = 0;
        foreach($sale_details as $sale_detail){

            /** check if stock is available */

            $branch_stock = BranchStock::where('product_id',$sale_detail->product_id)
            ->where('unit',$sale_detail->unit)
            ->where('size',$sale_detail->size)
            ->where('branch_id',auth()->user()->branch_id)
            ->first();

            /** update branch stock */
            $new_stock = $branch_stock->stock + $sale_detail->sale_qty;
            
            BranchStock::where('product_id',$sale_detail->product_id)
            ->where('unit',$sale_detail->unit)
            ->where('size',$sale_detail->size)
            ->where('branch_id',auth()->user()->branch_id)
            ->update(['stock'=>$new_stock]);
            
            /** get customer profit on products */
            $profit = Prices::where('product_id',$sale_detail->product_id)
            ->where('unit',$sale_detail->unit)
            ->where('size',$sale_detail->size)
            ->first();
            /** save customer profit on each product */

                $customer_balance = Invaccounts::where('account_id',$request->cust_id)
                ->where('account_type','customer_sale_profit')
                ->first();
                $profit_amount = $profit->disc * $sale_detail->sale_qty;
                $total_profit = $total_profit + $profit_amount;
               $customer_new_profit = $customer_balance->balance - $profit_amount;

                /** ledger entry for profit */
                Ledger::create([
                    'account_id' => $request->cust_id,
                    'account_type' => 'customer_sale_profit',
                    'paid_date' => date('Y-m-d'),
                    'trans_detail' => 'customer profit Deduction return product@'.$sale_detail->product_id,
                    'credit' => 0,
                    'debit' => $profit_amount,
                    'balance' => $customer_new_profit
                ]);
                Invaccounts::where('account_id',$request->cust_id)
                ->where('account_type','customer_sale_profit')
                ->update([
                    'balance' => $customer_new_profit
                ]);

                

                $branch_balance = $branch_balance - $sale_detail->sub_total;
          
            }
            /** ledger entry to Branch cash sale */

            $branch_balance_data = Invaccounts::where('account_id',Auth()->user()->branch_id)
            ->where('account_type','branch')
            ->first();

            $branch_new_balance = $branch_balance_data->balance + $branch_balance;
            
            Invaccounts::where('account_id',auth()->user()->branch_id)
            ->where('account_type','branch')
            ->update([
                'balance' => $branch_new_balance
            ]);
            
            Ledger::create([
                'account_id' => auth()->user()->branch_id,
                'account_type' => 'branch',
                'paid_date' => date('Y-m-d'),
                'trans_detail' => 'payment Paid to Customer for Return Sale Inv @'.$request->inv_id,
                'credit' => $branch_balance,
                'debit' => 0,
                'balance' => $branch_new_balance
            ]);
            /** Update status of INVOICE */
            BranchSaleReturnMaster::where('id',$request->inv_id)
            ->update([
                'ret_inv_date' => $request->inv_date,
                'customer_id' => $request->cust_id,
                'ret_inv_status' => 1,
                'user_id' => auth()->user()->id,
                'total_sale_return' => $branch_balance,
            ]);

            return response()->json([
                'message' => 'ok'
            ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BranchSaleReturnMaster $branchSaleReturnMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BranchSaleReturnMaster $branchSaleReturnMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BranchSaleReturnMaster $branchSaleReturnMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BranchSaleReturnMaster $branchSaleReturnMaster)
    {
        //
    }
}

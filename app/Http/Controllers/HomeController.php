<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\BranchSaleMaster;
use App\Models\BranchSaleDetail;
use App\Models\BranchStock;
use App\Models\Invaccounts;
use App\Models\Ledger;
use App\Models\Prices;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::where('disable',0)->get();
        $customers = Customer::where('disable',0)->get();
        $invdata = BranchSaleMaster::where('branch_id',auth()->user()->branch_id)->where('inv_status',0)->first();
        if($invdata){
            $data = $invdata;
        }
        else
        {
           $data =  BranchSaleMaster::create([
                'branch_id' => auth()->user()->branch_id,
                'user_id' => auth()->user()->id,
                'inv_code' => auth()->user()->branch_id."-".rand(400,10000)."-".date('d').date('m').date('y') //branch_id-randcode-daymonthyear
            ]);
        }
        return view('home',compact('products','customers','data'));
    }
    public function get_sale_ivoices(){

        $sales = DB::table('branch_sale_masters')
        ->join('customers', 'branch_sale_masters.customer_id','=','customers.id')
        ->where('branch_sale_masters.branch_id',auth()->user()->branch_id)
        ->select('branch_sale_masters.*','customers.customer_code','customers.name')
        ->get();
        return view('listsale',compact('sales'));
    }
    public function get_sale_invoice($id){
        $data = DB::table('branch_sale_masters')
        ->join('customers', 'branch_sale_masters.customer_id','=','customers.id')
        ->where('branch_sale_masters.id',$id)
        ->select('branch_sale_masters.*','customers.customer_code','customers.name')
        ->first();
        return view('saleview',compact('data'));
    }
    public function add_product_sale(Request $request){

       $id = $request->id;

       $product = DB::table('branch_stocks')
       ->join('prices','branch_stocks.product_id','=','prices.product_id')
       ->where('branch_stocks.id',$id)
       ->select('branch_stocks.*','prices.sale_price')
       ->first();

       $check_already = BranchSaleDetail::where(
        'inv_id',$request->inv_id,
       )->where('product_id',$product->product_id)
       ->where('unit',$product->unit)
       ->where('size',$product->size)
       ->first();

       $new_stock = 0;
       
       if($check_already)
       
       {
       
        $new_stock = $request->sale_qty + $check_already->sale_qty;
        BranchSaleDetail::where('id',$check_already->id)->update([
            'sale_qty' => $new_stock,
            'sub_total' => $product->sale_price * $new_stock
        ]);
       
        }
       else
       {
     
            BranchSaleDetail::create([
                'inv_id' => $request->inv_id,
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

    public function get_sale_products($id){
        $products = DB::table('branch_sale_details')
        ->join('products','branch_sale_details.product_id','=','products.id')
        ->where('branch_sale_details.inv_id',$id)
        ->select('branch_sale_details.*','products.product_name','products.product_description','products.product_code')
        ->get();
        return response()->json([
            'products' => $products
        ]);
    }
    public function remove_sale_products($id){
        BranchSaleDetail::where('id',$id)->delete();
        return response()->json([
            'message' => 'ok'
        ]); 
    }
    public function get_customer($id){

        $customer = Customer::where('id',$id)->first();
        return response()->json([
            'customer' => $customer
        ]);
    }
    public function confirm_sale_inv(Request $request)
    {

        /** get sale detail */
        $sale_details = BranchSaleDetail::where('inv_id',$request->inv_id)
        ->get();
        $branch_balance = 0;
        $total_profit = 0;
        foreach($sale_details as $sale_detail)
        {

            /** check if stock is available */

            $branch_stock = BranchStock::where('product_id',$sale_detail->product_id)
            ->where('unit',$sale_detail->unit)
            ->where('size',$sale_detail->size)
            ->where('branch_id',auth()->user()->branch_id)
            ->first();

            /** update branch stock */
            $new_stock = $branch_stock->stock - $sale_detail->sale_qty;
            
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
               $customer_new_profit = $customer_balance->balance + $profit_amount;

                /** ledger entry for profit */
                Ledger::create([
                    'account_id' => $request->cust_id,
                    'account_type' => 'customer_sale_profit',
                    'paid_date' => date('Y-m-d'),
                    'trans_detail' => 'customer profit on sale product@'.$sale_detail->product_id,
                    'debit' => 0,
                    'credit' => $profit_amount,
                    'balance' => $customer_new_profit
                ]);
                Invaccounts::where('account_id',$request->cust_id)
                ->where('account_type','customer_sale_profit')
                ->update([
                    'balance' => $customer_new_profit
                ]);

                

                $branch_balance = $branch_balance + $sale_detail->sub_total;
          
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
                'trans_detail' => 'payment received for sale inv @'.$request->inv_id,
                'credit' => $branch_balance,
                'debit' => 0,
                'balance' => $branch_new_balance
            ]);
            /** Update status of INVOICE */
            BranchSaleMaster::where('id',$request->inv_id)
            ->update([
                'inv_date' => $request->inv_date,
                'customer_id' => $request->cust_id,
                'inv_status' => 1,
                'user_id' => auth()->user()->id,
                'total_sale' => $branch_balance,
                'customer_profit' => $total_profit
            ]);

            return response()->json([
                'message' => 'ok'
            ]);
    }
}

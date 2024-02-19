<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use Illuminate\Http\Request;
use App\Models\Branches;
use App\Models\BranchSaleMaster;
use Illuminate\Support\Facades\DB;
use App\Models\Ledger;
use App\Models\Vendor;
use App\Models\Customer;

class ReportsController extends Controller
{

    public function payment_report(){
        $branches = Branches::all();
        if(auth()->user()->branch_id > 0){
            $branches = Branches::where('id',auth()->user()->branch_id)->get();
        }
        return view('reports.branches_payment',compact('branches'));
        
    }
    public function get_payment_report(Request $request){

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $report_heading = "Ledger/Payment Report ".$start_date.' and '.$end_date;
        $branch = "All Branches";
        if($request->selected_branch == 0){

          $datas =   DB::table('ledgers')
          ->whereBetween('ledgers.paid_date',[$start_date,$end_date])
          ->get();
        }
        else
        {
            $branch_data = Branches::where('id',$request->selected_branch)->first();
            $branch = $branch_data->branch_code."-".$branch_data->branch_name."-".$branch_data->branch_address;
            $datas = DB::table('ledgers')
            ->where('ledgers.account_id',$request->selected_branch)
            ->where('ledgers.account_type','branch')
            ->whereBetween('ledgers.paid_date',[$start_date,$end_date])
            ->get();
        }
        $branches = Branches::all();
        if(auth()->user()->branch_id > 0){
            $branches = Branches::where('id',auth()->user()->branch_id)->get();
        }
        return view('reports.branches_payment',compact('datas','branches','report_heading','branch'));
    }
   
    public function sale_report(){
        $branches = Branches::all();
        if(auth()->user()->branch_id > 0){
            $branches = Branches::where('id',auth()->user()->branch_id)->get();
        }
        return view('reports.branches_sale',compact('branches'));
    }
    public function get_sale_report(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $report_heading = "Sale Report ".$start_date.' and '.$end_date;
        $branch = "All Branches";
        if($request->selected_branch == 0){

          $datas =   DB::table('branch_sale_masters')
          ->join('branches','branch_sale_masters.id','=','branches.id')
          ->join('customers','branch_sale_masters.customer_id','=','customers.id')
          ->whereBetween('branch_sale_masters.inv_date',[$start_date,$end_date])
          ->select('branch_sale_masters.*','branches.branch_code','branches.branch_name','branches.branch_address', 'customers.customer_code','customers.name')
          ->get();
        }
        else
        {
            $branch_data = Branches::where('id',$request->selected_branch)->first();
            $branch = $branch_data->branch_code."-".$branch_data->branch_name."-".$branch_data->branch_address;
            $datas = DB::table('branch_sale_masters')
            ->join('branches','branch_sale_masters.id','=','branches.id')
            ->join('customers','branch_sale_masters.customer_id','=','customers.id')
            ->where('branch_sale_masters.branch_id',$request->selected_branch)
            ->whereBetween('branch_sale_masters.inv_date',[$start_date,$end_date])
            ->select('branch_sale_masters.*','branches.branch_code','branches.branch_name','branches.branch_address', 'customers.customer_code','customers.name')
            ->get();
        }
        $branches = Branches::all();
        if(auth()->user()->branch_id > 0){
            $branches = Branches::where('id',auth()->user()->branch_id)->get();
        }
        return view('reports.branches_sale',compact('datas','branches','report_heading','branch'));
    }

    static function account_info($account_id,$account_type){

        $account_info = '';
        if($account_type == 'customer' || $account_type == 'customer_investement' || $account_type == 'customer_sale_profit'){

            $data = DB::table('customers')->where('id',$account_id)->first();
            $account_info = $data->customer_code."-".$data->name; 
        }
        elseif($account_type == 'vendor'){
            $data = DB::table('vendors')->where('id',$account_id)->first();
            $account_info = $data->v_code."-".$data->v_name; 
        }
        elseif($account_type == 'bank'){
            $data = DB::table('banks')->where('id',$account_id)->first();
            $account_info = $data->bank_name."-".$data->bank_account_number; 
        }
        elseif($account_type == 'branch'){
            $data = DB::table('branches')->where('id',$account_id)->first();
            $account_info = $data->branch_code."-".$data->branch_name; 
        }
        
        elseif($account_type == 'investment'){
            $account_info = "Investment";
        }
        elseif($account_type == 'sale'){
            $account_info = "Sale";
        }
        elseif($account_type == 'purchase'){
            $account_info = "Purchase";
        }
        return $account_info;
    }

    public function sale_return_report(){
        $branches = Branches::all();
        if(auth()->user()->branch_id > 0){
            $branches = Branches::where('id',auth()->user()->branch_id)->get();
        }
        return view('reports.branches_sale_return',compact('branches'));
    }
    public function get_sale_return_report(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $report_heading = "Sale Return Report ".$start_date.' and '.$end_date;
        $branch = "All Branches";
        if($request->selected_branch == 0){

          $datas =   DB::table('branch_sale_return_masters')
          ->join('branches','branch_sale_return_masters.id','=','branches.id')
          ->join('customers','branch_sale_return_masters.customer_id','=','customers.id')
          ->whereBetween('branch_sale_return_masters.ret_inv_date',[$start_date,$end_date])
          ->where('branch_sale_return_masters.ret_inv_status',1)
          ->select('branch_sale_return_masters.*','branches.branch_code','branches.branch_name','branches.branch_address', 'customers.customer_code','customers.name')
          ->get();
        }
        else
        {
            $branch_data = Branches::where('id',$request->selected_branch)->first();
            $branch = $branch_data->branch_code."-".$branch_data->branch_name."-".$branch_data->branch_address;
            $datas = DB::table('branch_sale_return_masters')
            ->join('branches','branch_sale_return_masters.id','=','branches.id')
            ->join('customers','branch_sale_return_masters.customer_id','=','customers.id')
            ->where('branch_sale_return_masters.branch_id',$request->selected_branch)
            ->whereBetween('branch_sale_return_masters.ret_inv_date',[$start_date,$end_date])
          ->where('branch_sale_return_masters.ret_inv_status',1)
          ->select('branch_sale_return_masters.*','branches.branch_code','branches.branch_name','branches.branch_address', 'customers.customer_code','customers.name')
            ->get();
        }
        $branches = Branches::all();
        if(auth()->user()->branch_id > 0){
            $branches = Branches::where('id',auth()->user()->branch_id)->get();
        }

        return view('reports.branches_sale_return',compact('datas','branches','report_heading','branch'));
    }

    public function purchase_report(){
        $vendors = Vendor::all();
        return view('reports.purchases',compact('vendors'));
    }
    public function get_purchase_report(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $report_heading = "Purchase  Report ".$start_date.' and '.$end_date;
        $vendor = "All Vendors";
        if($request->selected_vendor == 0){

        $datas = DB::table('purchasemasters')
        ->join('vendors','purchasemasters.vendor_id','=','vendors.id')
        ->whereBetween('purchasemasters.pur_date',[$start_date,$end_date])
        ->select('purchasemasters.*','vendors.*')
        ->get();
        
        }
        else
        {
        $vendordata = Vendor::where('id',$request->selected_vendor)->first();
        $vendor = $vendordata->v_code."-".$vendordata->v_name."-".$vendordata->v_address;
        $datas = DB::table('purchasemasters')
        ->join('vendors','purchasemasters.vendor_id','=','vendors.id')
        ->whereBetween('purchasemasters.pur_date',[$start_date,$end_date])
        ->where('vendors.id',$request->selected_vendor)
        ->select('purchasemasters.*','vendors.*')
        ->get();
        }

        $vendors = Vendor::all();
        return view('reports.purchases',compact('vendors','datas','vendor','report_heading'));

    }
    
    public function customer_report(){

        $customers = Customer::all();
        return view('reports.customer_statement',compact('customers'));
    }

    public function get_customer_report(Request $request){
        DB::enableQueryLog();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $report_heading = "Customer Statement ".$start_date.' and '.$end_date;
        $customer = "All Customers";
        if($request->selected_customer == 0){

        $datas = DB::table('ledgers')
        ->join('customers','ledgers.account_id','=','customers.id')
        ->whereIn('ledgers.account_type',['customer_sale_profit','customer_investment','customer'])
        ->whereBetween('ledgers.paid_date',[$start_date,$end_date])
        ->select('ledgers.*','customers.*')->get();
        
        }
        else
        {
        $customerdata = Customer::where('id',$request->selected_customer)->first();
        $customer = $customerdata->customer_code."-".$customerdata->name."-".$customerdata->address;
        $datas = DB::table('ledgers')
        ->join('customers','ledgers.account_id','=','customers.id')
        ->where('ledgers.account_id','=',$request->selected_customer)
        ->whereIn('ledgers.account_type',['customer_sale_profit','customer_investment','customer'])
        ->whereBetween('ledgers.paid_date',[$start_date,$end_date])
        ->select('ledgers.*','customers.*')
        ->get();
        }
        
        $customers = Customer::all();
        return view('reports.customer_statement',compact('customers','datas','customer','report_heading'));

    }

    public function vendor_report(){

        $vendors = Vendor::all();
        return view('reports.vendor',compact('vendors'));
    }

    public function get_vendor_report(Request $request){

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $report_heading = "Vendor Report ".$start_date.' and '.$end_date;
        $vendor = "All Vendors";
        if($request->selected_vendor == 0){

        $datas = DB::table('ledgers')
        ->join('vendors','ledgers.account_id','=','vendors.id')
        ->where('ledgers.account_type','vendor')
        ->whereBetween('ledgers.paid_date',[$start_date,$end_date])
        ->select('ledgers.*','vendors.*')
        ->get();
        
        }
        else
        {
        $vendordata = Vendor::where('id',$request->selected_vendor)->first();
        $vendor = $vendordata->v_code."-".$vendordata->v_name."-".$vendordata->v_address;
        $datas = DB::table('ledgers')
        ->join('vendors','ledgers.account_id','=','vendors.id')
        ->where('ledgers.account_type','=','vendor')
        ->where('ledgers.account_id',$request->vendordata)
        ->whereBetween('ledgers.paid_date',[$start_date,$end_date])
        ->select('ledgers.*','vendors.*')
        ->get();
        }
        $vendors = Vendor::all();
        return view('reports.vendor',compact('vendors','datas','vendor','report_heading'));

    }

    public function get_income(){
        return view('reports.incom');
    }


}

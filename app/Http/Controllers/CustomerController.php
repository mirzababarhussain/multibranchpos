<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerInvestment;
use App\Models\Invaccounts;
use App\Http\Controllers\LedgerController;
use App\Models\Ledger;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branch_id = auth()->user()->branch_id;
        if($branch_id > 0){
            $customers = Customer::where('branch_id',$branch_id)->get();
        }
        else
        {
            $customers = Customer::all();
        }
        return view('customers.list',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //customer general information

        $customer = Customer::create([
            'name' => $request->name,
            'cnic' => $request->cnic,
            'phone' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'branch_id' => auth()->user()->branch_id,
            'created_by' => auth()->user()->id
        ]);
        $customer_code = $customer->id.rand(5000,10000);
        // customer investment 
        CustomerInvestment::create([
            'customer_id' => $customer->id,
            'amount' => $request->amount,
            'profit_percentage' => $request->profit_percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        // customer investment balance entry
        Invaccounts::create([
            'account_id' => $customer->id,
            'account_type' => 'customer_investment',
            'balance' => 0
        ]);
        $account_balance = Invaccounts::where('account_id',0)->where('account_type','investment')->first();
        $new_balance = $account_balance->balance + $request->amount;
        Invaccounts::where('account_id',0)->where('account_type','investment')->update([
            'balance' => $new_balance
        ]);
        //Ledger entries
        LedgerController::ledger(0,'investment','invested by customer@'.$customer_code,$request->amount,0,$new_balance,date('Y-m-d'));
        LedgerController::ledger($customer->id,'customer_investment','investment',0,$request->amount,0,date('Y-m-d'));
        // customer sale/purchase balance entry
        Invaccounts::create([
            'account_id' => $customer->id,
            'account_type' => 'customer_sale_profit',
            'balance' => 0
        ]);
        Customer::where('id',$customer->id)->update(['customer_code' => $customer_code]);
        // return with customer code
        return view('customers.create',compact('customer','customer_code'))->with('message','Customer created successfully');
    }
    public function destroy(Request $request)
    {
        Customer::where('id',$request->id)->update(['disable' => 1]);
        $message = "Customer disabled successfully   کامیابی سے غیر فعال کر دیا گیا ہے۔";
        return back()->with('message',$message);
    }
    public function restore(Request $request)
    {
        Customer::where('id',$request->id)->update(['disable' => 0]);
        $message = "Customer enabled successfully   کامیابی سے  فعال کر دیا گیا ہے۔";
        return back()->with('message',$message);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        $customer = Customer::where('id',$id)->first();
        $investment = CustomerInvestment::where('customer_id',$id)->first();
        $sale_profits = Ledger::where('account_type','customer_sale_profit')->where('account_id',$id)->orderBy('id','desc')->get();
        $invest_profits = Ledger::where('account_type','customer_investment')->where('account_id',$id)->orderBy('id','desc')->get();
        $this->calculate_investment_profit($id,$investment->start_date,$investment->end_date,$investment->amount,$investment->profit_percentage);

        return view('customers.view',compact('customer','investment','sale_profits','invest_profits'));
    }
    public function calculate_investment_profit($customer_id,$req_start_date,$req_end_date,$total,$percentage){
        $start_date = $req_start_date; // Start date
        $end_date = $req_end_date; // End date

// Get current month and year
$current_month = date('n');
$current_year = date('Y');

// Loop through each month between start and end dates
$start_month = date('n', strtotime($start_date));
$start_year = date('Y', strtotime($start_date));

$end_month = date('n', strtotime($end_date));
$end_year = date('Y', strtotime($end_date));

for ($year = $start_year; $year <= $end_year; $year++) {
    $month_start = ($year == $start_year) ? $start_month : 1;
    $month_end = ($year == $end_year) ? $end_month : 12;

    for ($month = $month_start; $month <= $month_end; $month++) {
        // Check if the month is not greater than the current month
        if (($year < $current_year) || ($year == $current_year && $month <= $current_month)) {
           $tDetail = 'Customer Monthly Profit for Month '.$end_month.'-'.$end_year;
           $acdetail = 'Customer Monthly Profit for Month '.$month.'-'.$year;
            $check = Ledger::where('account_id',$customer_id)
            ->where('account_type','customer_investment')
            ->where('trans_detail',$tDetail)->first();
            if(!$check){

            $balance = 0;
            $amount = $total * ($percentage/100);
           $account_data =  Invaccounts::where('account_type','customer_investment')->where('account_id',$customer_id)->first();
           $balance = $account_data->balance + $amount;
           
           Invaccounts::where('account_type','customer_investment')->where('account_id',$customer_id)->update([
            'balance'=> $balance
           ]);
           Ledger::create([
                'account_id' => $customer_id,
                'account_type' => 'customer_investment',
                'paid_date' => date('Y-m-d'),
                'trans_detail' => $acdetail,
                'credit' => $amount,
                'debit' => 0,
                'balance' => $balance
            ]);
        }

          
        }
    }
}

    }
    public function show_json($id)
    {
        $customer = Customer::where('id',$id)->first();
        $sale_profits = Invaccounts::where('account_type','customer_sale_profit')->where('account_id',$id)->first();
        $invest_profits = Invaccounts::where('account_type','customer_investment')->where('account_id',$id)->first();
        return response()->json([
            'customer' => $customer,
            'sale_profit' => $sale_profits,
            'invest_profit' => $invest_profits

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::where('id',$id)->first();
        $investment = CustomerInvestment::where('customer_id',$id)->first();
       
        return view('customers.edit',compact('customer','investment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        Customer::where('id',$request->id)->update([
            'name' => $request->name,
            'cnic' => $request->cnic,
            'phone' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            
        ]);
        $message = "Customer updated successfully   کامیابی سے  ترمیم کر دیا گیا ہے۔";
        return back()->with('message',$message);
        
    }

}

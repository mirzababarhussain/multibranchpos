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
        $sale_profits = Ledger::where('account_type','customer_sale_profit')->where('account_id',$id)->get();
        $invest_profits = Ledger::where('account_type','customer_investment')->where('account_id',$id)->get();
        return view('customers.view',compact('customer','investment','sale_profits','invest_profits'));
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

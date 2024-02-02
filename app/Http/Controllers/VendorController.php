<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Vendorbanks;
use App\Models\Vendorbalance;
use App\Models\Invaccounts;
use App\Models\Ledger;
use App\Http\Controllers\LedgerController;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = Vendor::all();
        return view('vendors.listvendors',compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'v_name' => 'required',
            'v_address' => 'required',
            'v_phone' => 'required',
            'v_balance' => 'required'
        ]);

        $vendor = Vendor::create([
            'v_code' => Str::random(5),
            'v_name' => $request->v_name,
            'v_phone' => $request->v_phone,
            'v_email' => $request->v_email,
            'v_address' => $request->v_address,
            'v_contact_name' => $request->contact_name,
            'v_contact_phone' => $request->contact_phone,
            'v_contact_email' => $request->contact_email,
        ]);
        // Opening Balance of Vendor
        Invaccounts::create([
            'account_id' => $vendor->id,
            'account_type' => 'vendor',
            'balance' => $request->v_balance
        ]);
         // Save first transaction
         LedgerController::ledger($vendor->id,'vendor','Opening Balance',0,0,$request->v_balance,'');
         // Save vendor's banks
        $banks = count($request->bank_name);
        for($i = 0; $i<= $banks; $i++){
            if(isset($request->bank_name[$i])){

                Vendorbanks::create([
                    'v_id' => $vendor->id,
                    'name' => $request->bank_name[$i],
                    'account_title' => $request->account_title[$i],
                    'account_no' => $request->account_number[$i]
                    
                ]);
            }
        }
        $message = "Vendor added successfully وینڈر کامیابی کے ساتھ شامل کر دیا گیا ہے۔";
        return back()->with('message',$message);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vendor = Vendor::where('id',$id)->first();
        $balance = Invaccounts::where('account_id',$id)->where('account_type','vendor')->first();
        $transactions = Ledger::where('account_id',$id)->where('account_type','vendor')->orderBy('id','desc')->get();
        $banks = Vendorbanks::where('v_id',$id)->get();

        return view('vendors.view',compact('vendor','transactions','banks','balance'));
    }

    public function show_json($id)
    {
        $vendor = Vendor::where('id',$id)->first();
        $balance = Invaccounts::where('account_id',$id)->where('account_type','vendor')->first();
        $banks = Vendorbanks::where('v_id',$id)->get();

        return response()->json([
            'vendor' => $vendor,
            'balance' => $balance,
            'banks' => $banks
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $vendor = Vendor::where('id',$id)->first();
        $transactions = Ledger::where('account_id',$id)->where('account_type','vendor')->orderBy('id','desc')->get();
        $banks = Vendorbanks::where('v_id',$id)->get();
        return view('vendors.edit',compact('vendor','transactions','banks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'v_name' => 'required',
            'v_address' => 'required',
            'v_phone' => 'required',
        ]);

        $vendor = Vendor::where('id',$request->id)->update([
            'v_name' => $request->v_name,
            'v_phone' => $request->v_phone,
            'v_email' => $request->v_email,
            'v_address' => $request->v_address,
            'v_contact_name' => $request->contact_name,
            'v_contact_phone' => $request->contact_phone,
            'v_contact_email' => $request->contact_email,
        ]);
        
         
         // update vendor's banks
        Vendorbanks::where('v_id',$request->id)->delete();
        $banks = count($request->bank_name);
        for($i = 0; $i<= $banks; $i++){
            if(isset($request->bank_name[$i])){

                Vendorbanks::create([
                    'v_id' => $request->id,
                    'name' => $request->bank_name[$i],
                    'account_title' => $request->account_title[$i],
                    'account_no' => $request->account_number[$i]
                    
                ]);
            }
        }
        $message = "Vendor update successfully وینڈر کو کامیابی سے اپ ڈیٹ کر دیا گیا ہے۔";
        return back()->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Vendor::where('id',$request->id)->update(['v_disable' => 1]);
        $message = "Vendor disabled successfully وینڈر کو کامیابی سے غیر فعال کر دیا گیا ہے۔";
        return back()->with('message',$message);
    }
    public function restore(Request $request)
    {
        Vendor::where('id',$request->id)->update(['v_disable' => 0]);
        $message = "Vendor enabled successfully وینڈر کو کامیابی سے  فعال کر دیا گیا ہے۔";
        return back()->with('message',$message);
    }
}

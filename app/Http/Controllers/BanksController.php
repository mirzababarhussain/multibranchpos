<?php

namespace App\Http\Controllers;

use App\Models\banks;
use Illuminate\Http\Request;
use App\Models\Invaccounts;
use App\Models\Ledger;
use App\Http\Controllers\LedgerController;
use Illuminate\Support\Facades\DB;

class BanksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks = banks::all();
        return view('banks.listbanks',compact('banks'));
    }

    public function index_json($id){
        if($id == 1){
            $banks = DB::table('banks')
            ->join('invaccounts','banks.id','=','invaccounts.account_id')
            ->where('invaccounts.account_type','=','bank')
            ->select('banks.*', 'invaccounts.balance')
            ->get();
            return response()->json([
                'banks' => $banks
            ]);
        }
        if($id == 2){

            $sale = Invaccounts::where('account_type','sale')->get();
            return response()->json([
                'sale' => $sale
            ]);
        }
       
     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('banks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $banks = count($request->bank_name);
        for($i = 0; $i<= $banks; $i++){
            if(isset($request->bank_name[$i])){

                $bank = banks::create([
                    'bank_name' => $request->bank_name[$i],
                    'banks_account_title' => $request->account_title[$i],
                    'bank_account_number' => $request->account_number[$i],
                    'bank_opening_balance' => $request->opening_balance[$i]
                    
                ]);
                Invaccounts::create([
                    'account_id' => $bank->id,
                    'account_type' => 'bank',
                    'balance' => $request->opening_balance[$i]
                ]);
                LedgerController::ledger($bank->id,'bank','Opening Balance',0,0,$request->opening_balance[$i]);
            }
        }
        $message = "Bank added successfully بینک کامیابی کے ساتھ شامل کر دیا گیا ہے۔";
        return redirect(route('banks'))->with('message',$message);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bank = banks::where('id',$id)->first();
        $balance = Invaccounts::where('account_id',$id)->where('account_type','bank')->first();
        $transactions = Ledger::where('account_id',$id)->where('account_type','bank')->get();

        return view('banks.view',compact('bank','transactions','balance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bank = banks::where('id',$id)->first();
        return view('banks.edit',compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
       banks::where('id',$request->id)->update([
                    'bank_name' => $request->bank_name,
                    'banks_account_title' => $request->account_title,
                    'bank_account_number' => $request->account_number
       ]);
       $message = "Bank updated successfully بینک کامیابی کے ساتھ اپ ڈیٹ کر دیا گیا ہے۔";
        return redirect(route('banks'))->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        banks::where('id',$request->id)->update(['disable' => 1]);
        $message = "Bank disabled successfully بینک کو کامیابی سے غیر فعال کر دیا گیا ہے۔";
        return back()->with('message',$message);
    }
    public function restore(Request $request)
    {
        banks::where('id',$request->id)->update(['disable' => 0]);
        $message = "Bank enabled successfully بینک کو کامیابی سے  فعال کر دیا گیا ہے۔";
        return back()->with('message',$message);
    }

    
    

    public function show_json($id)
    {
        $bank = banks::where('id',$id)->first();
        $balance = Invaccounts::where('account_id',$id)->where('account_type','bank')->first();

        return response()->json([
            'bank' => $bank,
            'balance' => $balance,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\banks;
use App\Models\Branches;
use App\Models\Invaccounts;
use App\Models\Ledger;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Carbon;

class LedgerController extends Controller
{
    static function ledger($account_id,$account_type,$trans_detail,$debit,$credit,$balance,$paid_date){
        Ledger::create([

            'account_id' => $account_id,
            'account_type' => $account_type,
            'trans_detail' => $trans_detail,
            'debit' => $debit,
            'credit' => $credit,
            'balance' => $balance,
            'paid_date' => $paid_date
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ledgers = Ledger::whereDate('created_at', Carbon::today())->get();;
        return view('ledger.listledger',compact('ledgers'));
    }

    static function account_detail($id,$type){
        $data = '';
        if($id > 0){

            if($type == 'vendor'){

                $account_data = Vendor::where('id',$id)->first();
                $data = " - ".$account_data->v_name.' '.$account_data->v_address;
            }
            if($type == 'bank'){

                $account_data = banks::where('id',$id)->first();
                $data = " - ".$account_data->bank_name.' '.$account_data->banks_account_title.' '.$account_data->bank_account_number;
            }
            if($type == 'branch'){

                $account_data = Branches::where('id',$id)->first();
                $data = " - ".$account_data->branch_name.' '.$account_data->branch_address;
            }
          
        }
        return $data;

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        if($id == 1)
        {
            $vendors = Vendor::where('v_disable',0)->get();
            return view('ledger.sentpayment',compact('vendors'));

        }
        if($id == 2){
            $branches = Branches::where('disable',0)->get();
            $banks = banks::where('disable',0)->get();
            return view('ledger.br_to_bank',compact('branches','banks'));
        }
        if($id == 3){
            $banks = banks::where('disable',0)->get();
            return view('ledger.bank_to_bank',compact('banks'));
        }
        if($id == 4){
            $branches = Branches::where('disable',0)->get();
            $sale = Invaccounts::where('account_id',0)->where('account_type','sale')->get();
            return view('ledger.br_to_mainstore',compact('branches'));
        }
        if($id == 5){
            $banks = banks::where('disable',0)->get();
            return view('ledger.mainstore_to_bank',compact('banks'));
        }
    }
    public function sale_json(){
        $balance = Invaccounts::where('account_id',0)->where('account_type','sale')->first();

        return response()->json([
            'balance' => $balance,
        ]);
    }
    public function sale_to_bank(Request $request){
        $from_main_account = $request->payment_from;
        $sub_paymnet_from = $request->sub_paymnet_from;
        $payment_to = $request->payment_to;
        $paid_date = $request->paid_date;
        $paid_amount = $request->paid_amount;
        $paid_desc = $request->paid_desc;
        $message = 'ok';
        // vendor
        $bank = Invaccounts::where('account_id',$payment_to)->where('account_type','bank')->first();
       
        $Paid_from = Invaccounts::where('account_id',0)->where('account_type','sale')->first();

        if($paid_amount > $Paid_from->balance){
            $message = 'Balance is low than paid amount';
        }

        if($message == 'ok')
        {

        
      
            $bank_balance = $bank->balance  + $paid_amount;
            $paid_acc_balance = $Paid_from->balance - $paid_amount;
            // Update vendor Balance
            Invaccounts::where('account_id',$payment_to)->where('account_type','bank')->update([
            'balance' => $bank_balance
            ]);
        // Update paid from account balance
            Invaccounts::where('account_id',0)->where('account_type','sale')->update([
            'balance' => $paid_acc_balance
            ]);
            // Ledger Entry 1
            $this->ledger($payment_to,'bank',$paid_desc.'@sale',$paid_amount,0,$bank_balance,$paid_date);
            //Ledger entry 2
            $this->ledger(0,'sale',$paid_desc.'@bank#'.$payment_to,0,$paid_amount,$paid_acc_balance,$paid_date);
       
        }
    
        return response()->json([
            'message' => $message
        ],200);
    }
    public function branch_to_mainstore(Request $request){
        $from_main_account = $request->payment_from;
        $sub_paymnet_from = $request->sub_paymnet_from;
        $payment_to = $request->payment_to;
        $paid_date = $request->paid_date;
        $paid_amount = $request->paid_amount;
        $paid_desc = $request->paid_desc;
        $message = 'ok';
        // vendor
        $sale = Invaccounts::where('account_id',0)->where('account_type','sale')->first();
       
        $Paid_from = Invaccounts::where('account_id',$sub_paymnet_from)->where('account_type','branch')->first();

        if($paid_amount > $Paid_from->balance){
            $message = 'Branch balance is low than paid amount';
        }

        if($message == 'ok')
        {

        
      
            $sale_balance = $sale->balance  + $paid_amount;
            $paid_acc_balance = $Paid_from->balance - $paid_amount;
            // Update vendor Balance
            Invaccounts::where('account_id',0)->where('account_type','sale')->update([
            'balance' => $sale_balance
            ]);
        // Update paid from account balance
            Invaccounts::where('account_id',$sub_paymnet_from)->where('account_type','branch')->update([
            'balance' => $paid_acc_balance
            ]);
            // Ledger Entry 1
            $this->ledger($payment_to,'sale',$paid_desc.'@branch#'.$sub_paymnet_from,$paid_amount,0,$sale_balance,$paid_date);
            //Ledger entry 2
            $this->ledger($sub_paymnet_from,'branch',$paid_desc.'@sale#0',0,$paid_amount,$paid_acc_balance,$paid_date);
       
        }
    
        return response()->json([
            'message' => $message
        ],200);
    }
    public function bank_to_bank(Request $request){
        $from_main_account = $request->payment_from;
        $sub_paymnet_from = $request->sub_paymnet_from;
        $payment_to = $request->payment_to;
        $paid_date = $request->paid_date;
        $paid_amount = $request->paid_amount;
        $paid_desc = $request->paid_desc;
        $message = 'ok';
        // vendor
        $bank = Invaccounts::where('account_id',$payment_to)->where('account_type','bank')->first();
       
        $Paid_from = Invaccounts::where('account_id',$sub_paymnet_from)->where('account_type','bank')->first();

        if($paid_amount > $Paid_from->balance){
            $message = 'Bank balance is low than paid amount';
        }

        if($message == 'ok')
        {

        
      
            $bank_balance = $bank->balance  + $paid_amount;
            $paid_acc_balance = $Paid_from->balance - $paid_amount;
            // Update vendor Balance
            Invaccounts::where('account_id',$payment_to)->where('account_type','bank')->update([
            'balance' => $bank_balance
            ]);
        // Update paid from account balance
            Invaccounts::where('account_id',$sub_paymnet_from)->where('account_type','bank')->update([
            'balance' => $paid_acc_balance
            ]);
            // Ledger Entry 1
            $this->ledger($payment_to,'bank',$paid_desc.'@bank#'.$sub_paymnet_from,$paid_amount,0,$bank_balance,$paid_date);
            //Ledger entry 2
            $this->ledger($sub_paymnet_from,'bank',$paid_desc.'@bank#'.$payment_to,0,$paid_amount,$paid_acc_balance,$paid_date);
       
        }
    
        return response()->json([
            'message' => $message
        ],200);
       }
    public function branch_to_bank(Request $request){
        $from_main_account = $request->payment_from;
        $sub_paymnet_from = $request->sub_paymnet_from;
        $payment_to = $request->payment_to;
        $paid_date = $request->paid_date;
        $paid_amount = $request->paid_amount;
        $paid_desc = $request->paid_desc;
        $message = 'ok';
        // vendor
        $bank = Invaccounts::where('account_id',$payment_to)->where('account_type','bank')->first();
       
        $Paid_from = Invaccounts::where('account_id',$sub_paymnet_from)->where('account_type','branch')->first();

        if($paid_amount > $Paid_from->balance){
            $message = 'Branch balance is low than paid amount';
        }

        if($message == 'ok')
        {

        
      
            $bank_balance = $bank->balance  + $paid_amount;
            $paid_acc_balance = $Paid_from->balance - $paid_amount;
            // Update vendor Balance
            Invaccounts::where('account_id',$payment_to)->where('account_type','bank')->update([
            'balance' => $bank_balance
            ]);
        // Update paid from account balance
            Invaccounts::where('account_id',$sub_paymnet_from)->where('account_type','branch')->update([
            'balance' => $paid_acc_balance
            ]);
            // Ledger Entry 1
            $this->ledger($payment_to,'bank',$paid_desc.'@br#'.$sub_paymnet_from,$paid_amount,0,$bank_balance,$paid_date);
            //Ledger entry 2
            $this->ledger($sub_paymnet_from,'branch',$paid_desc.'@bank#'.$payment_to,0,$paid_amount,$paid_acc_balance,$paid_date);
       
        }
    
        return response()->json([
            'message' => $message
        ],200);
       }

   public function pay_to_vendor(Request $request){
    $from_main_account = $request->payment_from;
    $sub_paymnet_from = $request->sub_paymnet_from;
    $payment_to = $request->payment_to;
    $paid_date = $request->paid_date;
    $paid_amount = $request->paid_amount;
    $paid_desc = $request->paid_desc;
    $type = '';
    // vendor
    $vendor = Invaccounts::where('account_id',$payment_to)->where('account_type','vendor')->first();
   
  
    $message = 'ok';
    if($from_main_account == 1){
        // banks
        $Paid_from = Invaccounts::where('account_id',$sub_paymnet_from)->where('account_type','bank')->first();
     
        $type = 'bank';
    }
    if($from_main_account == 2){
        // sale account
        $Paid_from = Invaccounts::where('account_id',0)->where('account_type','sale')->first();
        
        $type = 'sale';
    }
    if($paid_amount > $Paid_from->balance){
        $message = 'insufficient balance from paying "'.$type.'"  account';
    }
    if($paid_amount > $vendor->balance){
        $message = 'Paid amount is greater than vendor amount';
    }
    $pay_refer = ' '.$type.'#'.$sub_paymnet_from;
    $to_refer = ' vendor#'.$payment_to;
   if($message == 'ok')
   {
        $vendor_balance = $vendor->balance - $paid_amount;
        $paid_acc_balance = $Paid_from->balance - $paid_amount;
        // Update vendor Balance
        Invaccounts::where('account_id',$payment_to)->where('account_type','vendor')->update([
        'balance' => $vendor_balance
        ]);
    // Update paid from account balance
        Invaccounts::where('account_id',$sub_paymnet_from)->where('account_type',$type)->update([
        'balance' => $paid_acc_balance
        ]);
        // Ledger Entry 1
        $this->ledger($payment_to,'vendor',$paid_desc.$pay_refer,$paid_amount,0,$vendor_balance,$paid_date);
        //Ledger entry 2
        $this->ledger($sub_paymnet_from,$type,$paid_desc.$to_refer,0,$paid_amount,$paid_acc_balance,$paid_date);
   }
   

    return response()->json([
        'message' => $message
    ],200);
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
    public function show(Ledger $ledger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ledger $ledger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ledger $ledger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ledger $ledger)
    {
        //
    }
}

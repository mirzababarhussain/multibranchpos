<?php

namespace App\Http\Controllers;

use App\Models\Branches;
use Illuminate\Http\Request;
use App\Models\Invaccounts;
use App\Models\Ledger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class BranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branches::all();
       return view('branches.listbranches',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch_name' => 'required',
            'branch_address' => 'required',
            'branch_contact_person' => 'required',
            'branch_phone' => 'required',
        ]);
        $branch = Branches::create([
            'branch_code' => rand(1000,5000),
            'branch_name' => $request->branch_name,
            'branch_address' => $request->branch_address,
            'branch_contact_person' => $request->branch_contact_person,
            'branch_phone' => $request->branch_phone,
            'branch_email' => $request->branch_email
        ]);

        Invaccounts::create([
            'account_id' => $branch->id,
            'account_type' => 'branch',
            'balance' => 0
        ]);
        $message = "Branch Created Successfully برانچ کامیابی سے بنائی گئی ہے۔";
        return back()->with('message',$message);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $branch = Branches::where('id',$id)->first();
        $transactions = Ledger::where('account_id',$id)->where('account_type','branch')->get();
        $balance = Invaccounts::where('account_id',$id)->where('account_type','branch')->first();
        $total_credit = Ledger::where('account_id',$id)->where('account_type','branch')->sum('credit');
        return view('branches.view',compact('branch','transactions','balance','total_credit'));
        
    }
    public function show_json($id){
        $balance = Invaccounts::where('account_id',$id)->where('account_type','branch')->first();
        return response()->json([
            'balance' => $balance 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $branch = Branches::where('id',$id)->first();
        return view('branches.edit',compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'branch_name' => 'required',
            'branch_address' => 'required',
            'branch_contact_person' => 'required',
            'branch_phone' => 'required',
        ]);
        Branches::where('id',$request->id)->update([

            'branch_name' => $request->branch_name,
            'branch_address' => $request->branch_address,
            'branch_contact_person' => $request->branch_contact_person,
            'branch_phone' => $request->branch_phone,
            'branch_email' => $request->branch_email
        ]);

        $message = "Branch updated Successfully برانچ کو کامیابی سے اپ ڈیٹ کر دیا گیا ہے۔";
        return redirect(route('branches'))->with('message',$message);
    }
    public function destroy(Request $request)
    {
        Branches::where('id',$request->id)->update([
            'disable' => 1
        ]);
        $message = "Branch disabled successfully برانچ کو کامیابی سے غیر فعال کر دیا گیا۔";
        return back()->with('message',$message);
    }

    public function restore(Request $request)
    {
        Branches::where('id',$request->id)->update([
            'disable' => 0
        ]);
        $message = "Branch enabled successfully برانچ کو کامیابی سے فعال کر دیا گیا۔";
        return back()->with('message',$message);
    }

    public function branch_user_list(){
        $users = DB::table('users')->leftJoin('branches','users.branch_id','=','branches.id')->select('users.*','branches.branch_name')->get();
        $branches = Branches::where('disable',0)->get();
        return view('users.list',compact('users','branches'));
    }

    public function create_branch_user(){
        $users = DB::table('users')->leftJoin('branches','users.branch_id','=','branches.id')->get();
        $branches = Branches::where('disable',0)->get();
        return view('users.create',compact('users','branches'));
    }
    public function store_branch_user(Request $request){

        $request->validate([
            'user_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'branch_id' => 'required'
        ]);

        User::create([
            'name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'branch_id' => $request->branch_id
        ]);

        $message = "Branch User addedd Successfully برانچ صارف کو کامیابی کے ساتھ شامل کیا گیا ہے۔";
        return redirect(route('branches.branch_user_list'))->with('message',$message);
    }
    public function delete_branch_user(Request $request){
        User::where('id',$request->id)->update([
            'disable' => 1
        ]);
        $message = "Branch user disabled Successfully برانچ صارف کو کامیابی سے غیر فعال کر دیا گیا ہے۔";
        return redirect(route('branches.branch_user_list'))->with('message',$message);
    }
    public function restore_branch_user(Request $request){
        User::where('id',$request->id)->update([
            'disable' => 0
        ]);
        $message = "Branch user Enable Successfully برانچ صارف کو کامیابی سے  فعال کر دیا گیا ہے۔";
        return redirect(route('branches.branch_user_list'))->with('message',$message); 
    }
    public function edit_branch_user($id){
        $user = DB::table('users')
        ->where('id',$id)
        ->first();
        $branches = Branches::where('disable',0)->get();
        return view('users.edit',compact('user','branches'));
    }
    public function update_branch_user(Request $request){
        if($request->update_password == 'yes'){
            ///Update password
            User::where('id',$request->id)->update([
                'password' => Hash::make($request->password),
            ]);
        }
        else
        {
            // Update general information
            User::where('id',$request->id)->update([
                'name' => $request->user_name,
                'email' => $request->email,
                'branch_id' => $request->branch_id,
                'disable' => $request->user_status
            ]);
        }
        return redirect(route('branches.edit_branch_user',$request->id))->with('message','User settings has been updated successfully');
    }
    static function get_branch_data($id){
        return Branches::where('id',$id)->first();
    }
    
}

@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Add New User نیا صارف  شامل کریں۔</h4>
          </div>
          
        </div>
      </div>
    </div>
    <div class="row">
      <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        
        <div class="row">
          <div class="card shadow">
            <div id="sticky-action" class="sticky-action">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col-sm-6">
                    <h5>اس سیکشن میں صارف نیا صارف  شامل کر سکتا ہے۔</h5> 
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ route('branches.branch_user_list') }}" class="btn btn-shadow btn-primary">
                      Back to User صارف  کی فہرست پر واپس                   </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">

              <form method="POST" action="{{ route('branches.store_branch_user') }}" >
                @csrf
              
              <div class="modal-body">
                <div>
                  <label>Branch   </label>
                 
                  <select class="form-control" required name="branch_id" id="mySelect2">
                      <option value="">---Select---</option>
                      <option value="0">Main Store</option>
                      @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->branch_name }} {{ $branch->branch_address }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="mt-3">
                  <label>Enter User's Name  باکس میں صارف کا نام درج کریں۔</label>
                  <input type="text" name="user_name" class="form-control" required>
                </div>
           
                <div class="mt-3">
                  <label>Enter Login ID (email)  باکس میں صارف کا ای میل درج کریں۔</label>
                  <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mt-3">
                  <label>Enter Login Password  باکس میں صارف کا پاس ورڈ درج کریں۔</label>
                  <input type="password" name="password" class="form-control" required>
                </div>
               
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success shadow mt-2">Save   محفوظ کریں</button>
              </div>
            </form>
              
            </div>
          </div>
        </div>
      </div>
    </div> 
    
  </div>

  
@endsection


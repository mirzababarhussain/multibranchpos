@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Add New Branch  نئی برانچ شامل کریں۔</h4>
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
                    <h5>اس سیکشن میں صارف نئی برانچ شامل کر سکتا ہے۔</h5>
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ route('branches') }}" class="btn btn-shadow btn-primary">
                      Back to Brach list برانچ کی فہرست پر واپس                   </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">

              <form method="POST" action="{{ route('branches.store') }}">
                @csrf
                <div class="row">

                  <div class="col-sm-6 mt-2">
                    <label>Branch Name برانچ کا نام <small class="text text-danger">*</small></label>
                    <input type="text" name="branch_name" class="form-control" required>
                  </div>

                  <div class="col-sm-6 mt-2">
                    <label>Branch address برانچ کا پتہ <small class="text text-danger">*</small></label>
                    <input type="text" name="branch_address" class="form-control" required>
                  </div>

                  <div class="col-sm-4 mt-4">
                    <label>Branch Contact Person برانچ کا مالک<small class="text text-danger">*</small></label>
                    <input type="text" name="branch_contact_person" class="form-control" required>
                  </div>

                  <div class="col-sm-4 mt-4">
                    <label>Phone   برانچ کے مالک کا فون<small class="text text-danger">*</small></label>
                    <input type="text" name="branch_phone" class="form-control" required>
                  </div>

                  <div class="col-sm-4 mt-4">
                    <label> Email ای میل<small class="text text-danger"></small></label>
                    <input type="email" name="branch_email" class="form-control" >
                  </div>
                 
                </div>
                  
                
                <button type="submit" name="btn_Save" class="btn btn-success mt-4 float-end">Save Brach برانچ کو محفوظ کریں۔</button>
              </form>
              
            </div>
          </div>
        </div>
      </div>
    </div> 
    
  </div>

 
@endsection


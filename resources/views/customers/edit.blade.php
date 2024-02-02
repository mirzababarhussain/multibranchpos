@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Edit Customer گاہک میں ترمیم کریں۔</h4>
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
                    <h5>اس سیکشن میں صارف گاہک میں ترمیم کر سکتا ہے۔</h5> 
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ route('customers') }}" class="btn btn-shadow btn-primary">
                      Back to Customer گاہک کی فہرست پر واپس                   </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">

              <form method="POST" action="{{ route('customers.update') }}">
                @csrf
                <div class="row ">
               
                  <input type="hidden" name="id" value="{{ $customer->id }}">
                  <h5>Customer Information</h5>
                  <div class="col-sm-4 mt-2">
                     
                      <label>Customer's Name   گاہک کا نام</label>
                      <input type="text" value="{{ $customer->name }}" name="name" class="form-control" required>
                      
                  </div>

                  <div class="col-sm-4 mt-2">
                     
                    <label>CNIC     شناختی کارڈ نمبر</label>
                    <input type="text" name="cnic" value="{{ $customer->cnic }}" class="form-control" required>
                    
                  </div>
                 
                  <div class="col-sm-4 mt-2">
                     
                    <label>Address       گاہک کا پتہ</label>
                    <input type="text" value="{{ $customer->address }}" name="address" class="form-control" required>
                    
                  </div>

                  <div class="col-sm-4 mt-4">
                     
                    <label>Mobile         گاہک کا موبائل نمبر</label>
                    <input type="text" value="{{ $customer->phone }}" name="mobile" class="form-control" required>
                    
                  </div>

                  <div class="col-sm-4 mt-4">
                     
                    <label>Email         گاہک کا ای میل</label>
                    <input type="email" name="email" value="{{ $customer->email }}" class="form-control">
                    
                  </div>
                 
             
              </div>
                <button type="submit" name="btn_Save" class="btn btn-shadow btn-success mt-4 float-end">Save محفوظ کریں۔</button>
              </form>
              
            </div>
          </div>
        </div>
      </div>
    </div> 
    
  </div>

  <script>
   
    function verify(){
      var per = document.getElementById('profit_percentage').value;
      var amount = document.getElementById('amount').value;
      var sdate = document.getElementById('start_date').value;
      var edate = document.getElementById('end_date').value;
      if(per > 0){
        if(sdate == "" || edate == ""){
          alert('Please select dates');
          return false;
        }
      }
      if(amount > 0){
        if(sdate == "" || edate == ""){
          alert('Please select dates');
          return false;
        }
      }
    }
   
</script>
@endsection


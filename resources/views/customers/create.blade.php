@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Add New Customer     نیا گاہک شامل کریں۔</h4>
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
                    <h5>اس سیکشن میں صارف نیا گاہک  شامل کر سکتا ہے۔</h5> 
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ route('customers') }}" class="btn btn-shadow btn-primary">
                      Back to Customers گاہک  کی فہرست پر واپس                   </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              @if(isset($customer_code))
              <h2>کسٹمر کو کامیابی کے ساتھ محفوظ کر لیا گیا ہے، براہ کرم کسٹمر کوڈ نوٹ کریں۔ </h2>
              <h2>Code : {{ $customer_code }}</h2>
              <h2>Name: {{ $customer->name }}</h2>
              <h2>{{ $customer->cnic }}</h2>
              <h3>{{ $customer->phone }}</h3>
              <h3>{{ $customer->address }}</h3>
              <div>
                

                  <br>
                  <a href="{{ route('customers.create') }}" class="btn btn-shadow btn-primary">
                    Add New customer نیا گاہک  شامل کریں۔
                  </a>
              </div>
              @else
              

              <form method="POST" action="{{ route('customers.store') }}">
                @csrf
                <div class="row ">
               
               
                  <h5>Customer Information</h5>
                  <div class="col-sm-4 mt-2">
                     
                      <label>Customer's Name   گاہک کا نام</label>
                      <input type="text" name="name" class="form-control" required>
                      
                  </div>

                  <div class="col-sm-4 mt-2">
                     
                    <label>CNIC     شناختی کارڈ نمبر</label>
                    <input type="text" name="cnic" class="form-control" required>
                    
                  </div>
                 
                  <div class="col-sm-4 mt-2">
                     
                    <label>Address       گاہک کا پتہ</label>
                    <input type="text" name="address" class="form-control" required>
                    
                  </div>

                  <div class="col-sm-4 mt-4">
                     
                    <label>Mobile         گاہک کا موبائل نمبر</label>
                    <input type="text" name="mobile" class="form-control" required>
                    
                  </div>

                  <div class="col-sm-4 mt-4">
                     
                    <label>Email         گاہک کا ای میل</label>
                    <input type="email" name="email" class="form-control">
                    
                  </div>
                  <div class="col-sm-6 mt-5">
                    <h5>Customer Sale/Purchase Profit Account</h5>
                    <br>
                    <h3>NILL - 0%</h3>
                  </div>

                  <div class="col-sm-6 mt-5">
                    <h5>Customer Business Profit Account</h5>
                    <div class="row">
                      <div class="col-sm-6 mt-4">
                        <label>Business Investment Amount (Rs.)</label>
                        <input type="number" name="amount" class="form-control" required>
                      </div>
                      <div class="col-sm-6 mt-4">
                        <label>Profit Percentage</label>
                        <input type="number" name="profit_percentage" class="form-control" required>%
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6 mt-2">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control">
                      </div>
                      <div class="col-sm-6 mt-2">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control">
                      </div>
                    </div>
                   
                  </div>
             
              </div>
                <button type="submit" name="btn_Save" class="btn btn-shadow btn-success mt-4 float-end">Save Bank   محفوظ کریں۔</button>
              </form>
             
              @endif
            </div>
          </div>
        </div>
      </div>
    </div> 
    
  </div>

 
@endsection


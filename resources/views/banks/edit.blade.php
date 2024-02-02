@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Edit Bank بینک میں ترمیم کریں۔</h4>
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
                    <h5>اس سیکشن میں صارف بینک میں ترمیم کر سکتا ہے۔</h5> 
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ route('banks') }}" class="btn btn-shadow btn-primary">
                      Back to Vendor بینک کی فہرست پر واپس                   </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">

              <form method="POST" action="{{ route('banks.update') }}">
                <input type="hidden" name="id" value="{{ $bank->id }}">
                @csrf
                <div class="row ">
               
               
                <div class="col-sm-12 mt-4"><h4>Banks   بینک</h4></div>
                <div class="row deen" id="dyn_row">
                    
                  <div class="col-sm-4 mt-2">
                     
                      <label>Bank's Name بینک کا نام</label>
                      <input type="text" value="{{ $bank->bank_name }}" name="bank_name" class="form-control" required>
                      
                  </div>

                  <div class="col-sm-4 mt-2">
                     
                    <label>Account Title   اکاؤنٹ کا عنوان</label>
                    <input type="text" value="{{ $bank->banks_account_title }}"  name="account_title" class="form-control" required>
                    
                </div>
                 
                <div class="col-sm-4 mt-2">
                     
                  <label>Account Number اکاؤنٹ نمبر</label>
                  <input type="text" value="{{ $bank->bank_account_number }}"  name="account_number" class="form-control" required>
                  
              </div>

             

             
              </div>
                <button type="submit" name="btn_Save" class="btn btn-shadow btn-success mt-4 float-end">Save Bank بینک کو محفوظ کریں۔</button>
              </form>
              
            </div>
          </div>
        </div>
      </div>
    </div> 
    
  </div>

  <script>
    function add_row(){
       // var getrow = document.getElementById('dyn_row');
        $("#dyn_row").append('<div class="row mt-2"><div class="col-sm-4 mt-2"><input type="text" name="bank_name[]" class="form-control" required> </div> <div class="col-sm-4 mt-2"> <input type="text" name="account_title[]" class="form-control" required> </div> <div class="col-sm-4 mt-2"> <input type="text" name="account_number[]" class="form-control" required><a href="#" class="text text-danger float-end remove_price_line">X</a></div></div>');
        $('select').select2();
      }
    $('.deen').on('click', '.remove_price_line', function(e) {
  e.preventDefault();

  $(this).parent().parent().remove();
});
   
</script>
@endsection


@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Add New Banks نیا بینک  شامل کریں۔</h4>
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
                    <h5>اس سیکشن میں صارف نیا بینک  شامل کر سکتا ہے۔</h5> 
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ route('banks') }}" class="btn btn-shadow btn-primary">
                      Back to Banks بینک  کی فہرست پر واپس                   </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">

              <form method="POST" action="{{ route('banks.store') }}">
                @csrf
                <div class="row ">
               
               
                <div class="row deen" id="dyn_row">
                  
                  <div class="col-sm-3 mt-2">
                     
                      <label>Bank's Name بینک کا نام</label>
                      <input type="text" name="bank_name[]" class="form-control" required>
                      
                  </div>

                  <div class="col-sm-3 mt-2">
                     
                    <label>Account Title   اکاؤنٹ کا عنوان</label>
                    <input type="text" name="account_title[]" class="form-control" required>
                    
                </div>
                 
                <div class="col-sm-3 mt-2">
                     
                  <label>Account Number اکاؤنٹ نمبر</label>
                  <input type="text" name="account_number[]" class="form-control" required>
                  
              </div>
              <div class="col-sm-3 mt-2">
                     
                <label>Opening Balance  افتتاحی توازن</label>
                <input type="text" name="opening_balance[]" class="form-control" required>
                
            </div>
             
              </div>
              <a href="javascript:add_row()">Add More</a>
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
        $("#dyn_row").append('<div class="row mt-2"><div class="col-sm-3 mt-2"><input type="text" name="bank_name[]" class="form-control" required> </div> <div class="col-sm-3 mt-2"> <input type="text" name="account_title[]" class="form-control" required> </div> <div class="col-sm-3 mt-2"> <input type="text" name="account_number[]" class="form-control" required></div><div class="col-sm-3"><input type="text" class="form-control" required name="opening_balance[]"><a href="#" class="text text-danger float-end remove_price_line">X</a></div></div>');
        $('select').select2();
      }
    $('.deen').on('click', '.remove_price_line', function(e) {
  e.preventDefault();

  $(this).parent().parent().remove();
});
   
</script>
@endsection


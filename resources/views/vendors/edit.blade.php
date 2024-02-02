@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h2 class="mb-0">Edit Vendor وینڈر میں ترمیم کریں۔</h2>
          </div>
          
        </div>
      </div>
    </div>
    <div class="row">
      <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        
        <div class="row">
          <div class="card">
            <div id="sticky-action" class="sticky-action">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col-sm-6">
                    <h5>اس سیکشن میں صارف وینڈر میں ترمیم کر سکتا ہے۔</h5> 
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ route('vendors') }}" class="btn btn-shadow btn-primary">
                      Back to Vendor وینڈر کی فہرست پر واپس                   </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">

              <form method="POST" action="{{ route('vendors.update') }}">
                <input type="hidden" name="id" value="{{ $vendor->id }}">
                @csrf
                <div class="row ">
                <div class="row mt-4"><h4>Vendor's Basic detail وینڈر کی بنیادی تفصیلات</h4></div>

                
                  <div class="col-sm-12 mt-3">
                      <label>Enter Vendor's Name وینڈر کا نام درج کریں۔ <small class="text text-danger">*</small></label>
                      <input type="text" value="{{ $vendor->v_name }}" name="v_name" class="form-control" required placeholder="enter vendor name">
                  </div>
                  <div class="col-sm-12 mt-3">
                    <label>Enter Vendor Address وینڈر کا پتہ درج کریں۔ <small class="text text-danger">*</small></label>
                    <textarea name="v_address" required class="form-control" placeholder="enter vendor address">{{ $vendor->v_address }}</textarea>
                </div>
                  <div class="col-sm-4 mt-3">
                    <label>Enter Vendor's Phone وینڈر کا فون درج کریں۔ <small class="text text-danger">*</small></label>
                    <input type="text" name="v_phone" value="{{ $vendor->v_phone }}" class="form-control" required placeholder="enter vendor phone">
                </div>
                <div class="col-sm-4 mt-3">
                  <label>Enter Vendor's Email وینڈر کا ای میل درج کریں۔ </label>
                  <input type="email" name="v_email" value="{{ $vendor->v_email }}" class="form-control" placeholder="enter vendor email">
              </div>
              
                
                </div>
               <div class="col-sm-12 mt-4"><h4>Contact Person Detail (optional) رابطہ شخص کی تفصیلات (اختیاری)</h4></div>
               <div class="row"> 
                <div class="col-sm-4">
                    <label>Name</label>
                    <input type="text" name="contact_name" value="{{ $vendor->v_contact_name }}" class="form-control">
                  </div>
                  <div class="col-sm-4">
                    <label>Phone</label>
                    <input type="text" name="contact_phone" class="form-control" value="{{ $vendor->v_contact_phone }}">
                  </div>
                  <div class="col-sm-4">
                    <label>E-mail</label>
                    <input type="email" name="contact_email" class="form-control" value="{{ $vendor->v_contact_email }}">
                  </div>
                </div>
                <div class="col-sm-12 mt-4"><h4>Vendor's Banks وینڈر کے بینک</h4></div>
                <div class="row deen" id="dyn_row">
                  @foreach ($banks as $bank )
                    
                  <div class="col-sm-4 mt-2">
                     
                      <label>Bank's Name بینک کا نام</label>
                      <input type="text" value="{{ $bank->name }}" name="bank_name[]" class="form-control" required>
                      
                  </div>

                  <div class="col-sm-4 mt-2">
                     
                    <label>Account Title   اکاؤنٹ کا عنوان</label>
                    <input type="text" value="{{ $bank->account_title }}"  name="account_title[]" class="form-control" required>
                    
                </div>
                 
                <div class="col-sm-4 mt-2">
                     
                  <label>Account Number اکاؤنٹ نمبر</label>
                  <input type="text" value="{{ $bank->account_no }}"  name="account_number[]" class="form-control" required>
                  
              </div>
              @endforeach

             
              </div>
              <a href="javascript:add_row()">Add More</a>
                <button type="submit" name="btn_Save" class="btn btn-shadow btn-success mt-4 float-end">Save Vendor وینڈر کو محفوظ کریں۔</button>
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


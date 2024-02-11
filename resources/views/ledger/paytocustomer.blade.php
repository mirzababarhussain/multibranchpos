@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          
          <div class="col-md-12">
            <div class="page-header-title">
              <h4 class="mb-0">Pay to Customer </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="card shadow">
        <div id="sticky-action" class="sticky-action">
          <div class="card-header">
            <div class="row align-items-center">
              
              <div class="col-sm-12 text-sm-end mt-3 mt-sm-0">

                <a href="{{ route('ledger.payments') }}" class="btn btn-shadow btn-primary float-end">
                  Back to Payments
                </a>

               
              </div>
            </div>
          </div>
        </div>
        
        <div class="card-body">
          <div class="row">
                <div class="col-sm-6">
                    <h4>Payment FROM <br>اکاؤنٹ سے ادائیگی</h4>
                    <select class="form-control mt-5" required id="payment_from">
                        <option value="">---Select---</option>
                        <option value="1">Banks</option>
                        <option value="2">Cash Sale - Main Store</option>
                    </select>
                    <div class="row mt-4" id="select_account_row" >
                        <select id="choose_account">
                            
                        </select>
                        <div class="mt-3">
                          <label>Select Payment Date</label>
                            <input type="date" id="payment_date" class="form-control" style="text-align: right; font-size: 18px;font-weight: bold; color:red">
                            <label>Enter Paid Amount</label>
                            <input type="number" id="paid_amount" class="form-control" style="text-align: right; font-size: 18px;font-weight: bold; color:red">
                            <label>Enter Description</label>
                            <textarea id="payment_desc" class="form-control" style="text-align: right; font-size: 18px;font-weight: bold; color:red"></textarea>
                          </div>
                    </div>

                </div>
                <div class="col-sm-6">
                  <h4>Payment To  Customer<br>اکاؤنٹ میں ادائیگی</h4>
                  <select class="form-control" required id="vendor">
                      <option value="">---Select---</option>
                      @foreach ($customers as $customer)
                        
                      <option value="{{ $customer->id }}">{{ $customer->customer_code }}-{{ $customer->name }}</option>
                      
                      @endforeach
                  </select>
                  <div class="row mt-5">
                    <div id="v_data"></div>
                    
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="card bg-danger available-balance-card">
                          <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                              <div>
                                <p class="mb-0 text-white text-opacity-75">Sale Profit Balance</p>
                                <h4 class="mb-0 text-white" id="sale_profit"></h4>
                              </div>
                              <div class="avtar">
                                <i class="ti ti-arrows-left-right f-18"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="card bg-warning available-balance-card">
                          <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                              <div>
                                <p class="mb-0 text-white text-opacity-75">Invest Profit Balance</p>
                                <h4 class="mb-0 text-white" id="inv_profit"></h4>
                              </div>
                              <div class="avtar">
                                <i class="ti ti-arrows-left-right f-18"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <h5>Select Payment for</h5>
                        <select id="payment_for" class="form-control">
                            <option value="">---Select---</option>
                            <option value="customer_sale_profit">Sale Profit</option>
                            <option value="customer_investment">Investment Profit</option>
                        </select>
                    </div>
                    <button onclick="return save_payment()" type="button" class="btn btn-shadow btn-success mt-3 float-end">Save Now</button>

                  
              </div>

              
          </div>
        </div>
      </div>
    </div>
        
  </div>

  <script>

    function save_payment(){
      var payment_from = document.getElementById('payment_from').value;
      var payment_to = document.getElementById('vendor').value;
      var sub_paymnet_from = document.getElementById('choose_account').value;
      var paid_date = document.getElementById('payment_date').value;
      var paid_amount = document.getElementById('paid_amount').value;
      var paid_desc = document.getElementById('payment_desc').value;
      var payment_for = document.getElementById('payment_for').value;
      if(payment_from == ""){
        error_msg('warning','Please select from account<br> براہ کرم اکاؤنٹ منتخب کریں جہاں سے آپ ادائیگی کرنا چاہتے ہیں');
        document.getElementById('payment_from').focus();
        return false;
      }
      else if(payment_to == ""){
        error_msg('warning','Please select Customer<br> براہ کرم گاہک کو منتخب کریں۔');
        document.getElementById('vendor').focus();
        return false;
      }
      else if(sub_paymnet_from == ""){
        error_msg('warning','Please select Sub account<br> براہ کرم ذیلی اکاؤنٹ منتخب کریں۔');
        document.getElementById('choose_account').focus();
        return false;
      }
      else if(paid_date == ""){
        error_msg('warning','Please select Payment Date<br> براہ کرم ادائیگی کی تاریخ منتخب کریں۔');
        document.getElementById('payment_date').focus();
        return false;
      }
      else if(paid_amount == ""){
        error_msg('warning','Please Enter Paid Amount<br> براہ کرم ادا شدہ رقم درج کریں۔');
        document.getElementById('paid_amount').focus();
        return false;
      }
      else if(paid_desc == ""){
        error_msg('warning','Please Enter Detail<br> براہ کرم ادائیگی کی تفصیلات درج کریں۔');
        document.getElementById('payment_desc').focus();
        return false;
      }
      else if(payment_for == ""){
        error_msg('warning','Please Select payment for<br>  برائے مہربانی فروخت کے منافع یا سرمایہ کاری کے منافع کے لیے ادائیگی کا انتخاب کریں۔');
        document.getElementById('payment_desc').focus();
        return false;
      }
      //loading_msg();
      var url = "{{ route('ledger.pay_to_customer') }}";
      $.ajax({
        url:url,
        type:'POST',
        data:{
          payment_from: payment_from,
          sub_paymnet_from: sub_paymnet_from,
          payment_to:payment_to,
          paid_date:paid_date,
          paid_amount:paid_amount,
          paid_desc:paid_desc,
          payment_for:payment_for 
        },
        success: function(data){
          if(data.message == 'ok'){
            error_msg('success','Payment recorded successfully');
            window.location = "{{ route('ledger.payments') }}";
          }
          else{
            error_msg('error',data.message);
          }
        },
        error: function(reject){
          error_msg('error','Server Error');
        }
      });
    }
   
    $(document).ready(function(){ 
          
            $('#vendor').change(function (e) { 
                e.preventDefault();
                    var id = $(this).val();
                    let a = '{{ route("customers.show_json","id")}}';
                    var url = a.replace('id',id);
                    $('#v_data').empty();
                    $('#sale_profit').empty();
                    $('#inv_profit').empty();
                    //loading_msg();
                $.ajax({
                    url : url,
                    type : 'GET',
                    data : {},
                    contentType : false,
                    processData : false,

                    success : function(data){
                      console.log(data);
                      $('#v_data').append('<h3>'+data.customer['name']+'<small><br>'+data.customer['address']+'</small></h3>');
                     
                      $('#sale_profit').append(data.sale_profit['balance']);
                      $('#inv_profit').append(data.invest_profit['balance']);
                    },

                    error : function(reject){
                      console.log(reject);
                    }
                });
            });

            $('#payment_from').change(function (e) { 
                e.preventDefault();
                    var id = $(this).val();
                    let a = '{{ route("banks.index_json","id")}}';
                    var url = a.replace('id',id);

                   
                   
                $.ajax({
                    url : url,
                    type : 'GET',
                    data : {},
                    contentType : false,
                    processData : false,

                    success : function(data){
                      console.log(data);
                      $('#choose_account').empty();
                      $('#choose_account').append('<option value="">--Select--</option>');
                      if(id == 1){
                        $.each(data.banks,function(index,bank){
                        $('#choose_account').append('<option value="'+bank.id+'">'+bank.bank_name+' '+bank.banks_account_title+' '+bank.bank_account_number+'</option>');
                        });
                      }
                      if(id == 2){
                        $.each(data.sale,function(index,sale){
                          $('#choose_account').append('<option value="sale">Sale Account  '+sale.balance+'</option>');
                        });
                      }
                    
                    },

                    error : function(reject){
                      console.log(reject);
                    }
                });
            });

            
           
          });

  </script>
  
@endsection

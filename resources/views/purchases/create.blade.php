@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          
          <div class="col-md-12">
            <div class="page-header-title">
              <h4 class="mb-0">New Purchase نئی خریداری</h4>
              
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <div class="card shadow">
    <div class="row bg bg-white p-5">
      <div class="col-sm-4">Purchase Date خریداری کی تاریخ<input value="{{ $master->pur_date }}" type="date" id="pur_date" name="pur_date" required class="form-control"></div>
      <div class="col-sm-8">Vendor  : 
      <select class="form-control select" name="vendor" id="vendor" required style="height: 40px">
        <option value="">---Select Vendor---</option>
        @foreach ($vendors as $vendor )
            <option value="{{ $vendor->id }}"
                @if($master->vendor_id == $vendor->id)
                  @php
                    echo "selected"
                  @endphp
                @else
                  
                @endif
              >{{ $vendor->v_name }} {{ $vendor->v_address }}</option>
        @endforeach  
      </select>
    
    </div>
    <div class="col-sm-4 mt-4 card p-2 text text-success" id="loader_section" style="display: none">
      <div class="d-flex justify-content-center">
        <div class="spinner-border" role="status"></div>
        
      </div>
      <h4 class="text text-center mt-4 text text-success">Loading....</h4>
      <h4 class="text text-center mt-4 text text-success">برائے مہربانی انتظار کریں</h4>
    </div>
    <div class="col-sm-4 mt-4 card p-2" id="pro_section">
      
        <div class="row">
          <label>Product مصنوعات</label>
        <select class="form-control" id="product">
            <option value="">---Select---</option>
            @foreach ($products as $product)
              <option value="{{ $product->id }}">{{ $product->product_name }} - {{ $product->product_code }}</option>
            @endforeach

        </select>
      </div>
      <div class="row mt-2">
        <label>Size سائز</label>
      <select class="form-control" id="size">
          
          
      </select>
    </div>
      <div class="row mt-2">
          <div class="col-sm-6">
              <label>Price قیمت خرید</label>
              <input type="text" class="form-control" name="pur_price" id="pur_price">
          </div>
          <div class="col-sm-6">
            <label>Qty مقدار</label>
            <input type="number" class="form-control" name="qty" id="qty">
          </div>
      </div>
     
     
      <input type="button" onclick="return add_product()" class="btn btn-shadow btn-secondary float-end mt-3" value=" Add خریداری کی فہرست میں شامل کریں۔">
    </div>
    <style>
      .pre-scrollable {
    max-height: 280px;
    overflow-y: scroll;
}
    </style>
    <div class="col-sm-8 card mt-4 pre-scrollable p-0">
        <table class="table table-striped table-bordered dataTable">
            <thead>
                <tr>
                    <th style="background-color:#f0e2ae">Sr.No.</th>
                    <th style="background-color:#f0e2ae">Code</th>
                    <th style="background-color:#f0e2ae">Product</th>
                    <th style="background-color:#f0e2ae">Pur Price</th>
                    <th style="background-color:#f0e2ae">Qty</th>
                    <th style="background-color:#f0e2ae">Total</th>
                    <th style="background-color:#f0e2ae"></th>
                </tr>
            </thead>
            <tbody id="line_row">

            </tbody>
        </table>
    </div>
    <p class="mb-0 text-danger text-opacity-75 text-center">Total Purchase خریداری کی کل رقم</p>
    <h4 class="mb-0 text-danger text text-center" id="total_purchase"></h4>
    </div>
    
    </div>
    <div class="d-flex flex-wrap gap-2 float-end">
      <button type="button" onclick="return confirm_purchase({{ $master->id }},'Cancel')" class="btn btn-shadow btn-danger">Cancel منسوخ</button>
      <button type="button" onclick="return confirm_purchase({{ $master->id }},'Draft')" class="btn btn-shadow btn-primary">Draft مسودہ</button>
      <button type="button" onclick="return confirm_purchase({{ $master->id }},'In Process')" class="btn btn-shadow btn-warning">In Process پروسیسنگ</button>
      <button type="button" onclick="return confirm_purchase({{ $master->id }},'Confirm')" class="btn btn-shadow btn-success">Confirm & Update Stock تصدیق شدہ</button>
     
    </div>
    <p><br></p>
    <p><br></p>
    <p><br></p>
    
  </div>

    <script>
      function confirm_purchase(id,status){
        let vendor = document.getElementById('vendor').value;
        let pur_date = document.getElementById('pur_date').value;
        if(vendor == "" || pur_date == ""){
          alert("Please Select Purchase Date and Vendor");
          return false;
        }
        document.getElementById('loader_section').style.display = "";
       document.getElementById('pro_section').style.display = "none";
        let url = '{{ route("purchases.confirm_status") }}';
        $.ajax({
          url:url,
          type: 'POST',
          data:{
            id:id,
            status:status,
            vendor_id:vendor,
            pur_date:pur_date
          },
          success: function(data){
            window.location = '{{ url('purchases') }}';
          },
          error: function(response){
            console.log(reponse);
          }
        })
      }
      function delete_row(id){
        let a = '{{ route("purchases.delete_row","id") }}';
        var url = a.replace('id',id);
        $.ajax({
          url:url,
          type:'GET',
          data:{},
          success: function(data){
            get_product({{ $master->id }});
            blink_text();
          },
          error: function(response){
            console.log(response);
          }
        })
      }
      function get_product(id){
        let a = '{{ route("purchases.getproducts","id")}}';
        var url = a.replace('id',id);
        $.ajax({
          url:url,
          type:'GET',
          data:{},
          success: function(data){
            console.log(data.total_purchase);
            $('#total_purchase').empty();
            $('#line_row').empty();
            var counter = 0;
            $.each(data.products,function(index,product){
              counter++;
              $('#line_row').append('<tr><td>'+counter+'</td><td>'+product.product_code+'</td><td>'+product.product_name+' ('+product.size_desc+' '+product.unit+')</td><td>'+product.pur_price+'</td><td>'+product.pur_qty+'</td><td>'+product.line_total+'</td><td><a href="javascript:delete_row('+product.id+')" class="text text-danger">X</a></td></tr>');
            });
            $('#total_purchase').append(data.total_purchase);
            
          },
          error: function(reponse){
            console.log(reponse);
          }
        })
      }
      function add_product(){
        var product_id = document.getElementById('product').value;
        var size = document.getElementById('size').value;
        var qty = document.getElementById('qty').value;
        var pur_price = document.getElementById('pur_price').value;
        if(product_id == "" || size == "" || qty == "" || qty <= 0 || pur_price <= 0 || pur_price == ""){
          alert('Please complete product form');
          return false;
        }
        else
        {
         let pur_id = {{ $master->id }};
         let url = '{{ route("purchases.store") }}';
         $.ajax({
          url:url,
          type: 'POST',
          data: {
            pur_id:pur_id,
            product_id:product_id,
            size:size,
            qty:qty,
            pur_price:pur_price
          },
          
          success: function(data){
            clear_form();
            get_product({{ $master->id }});
          },
          error: function(response){
            console.log(response);
          }
         }) 
        }
      }
        $(document).ready(function(){ 
            // Get Sub Types
            get_product({{ $master->id }});
            $('#product').change(function (e) { 
                e.preventDefault();
                   document.getElementById("size").innerHTML = ''; 
                    var product_id = $(this).val();
                    let a = '{{ route("getsizes","id")}}';
                    var url = a.replace('id',product_id);
                $.ajax({
                    url : url,
                    type : 'GET',
                    data : product_id,
                    contentType : false,
                    processData : false,

                    success : function(data){
                        let products = data.sizes; 
                            if(products.length > 0){ 

                                $('#size').append('<option value="">---Select---</option>');   
                                $.each(products, function (key, value) 
                                {
                                   $('#size').append('<option value="'+value.id+'">'+value.size+ ' '+value.unit+'</option>');
                                });
                            }
                    },

                    error : function(reject){
                      console.log(reject);
                    }
                });
            });

            $('#size').change(function (e) { 
                e.preventDefault();
                   document.getElementById("pur_price").value = ''; 
                    var id = $(this).val();
                    let a = '{{ route("getpurprices","id")}}';
                    var url = a.replace('id',id);
                $.ajax({
                    url : url,
                    type : 'GET',
                    data : id,
                    contentType : false,
                    processData : false,

                    success : function(data){
                       document.getElementById('pur_price').value = data.price.pur_price;
                       document.getElementById('qty').focus();
                    },

                    error : function(reject){
                      console.log(reject);
                    }
                });
            });
          });

          function clear_form(){
            $('#pur_price').val('');
            $('#qty').val('');
            $('#size').empty();
            $('#product').val(null).trigger('change');
            blink_text();
          }
          function blink_text() {
    $('#total_purchase').fadeOut(500);
    $('#total_purchase').fadeIn(500);
}
    </script>
@endsection

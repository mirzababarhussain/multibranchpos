@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          
          <div class="col-md-12">
            <div class="page-header-title">
              <h4 class="mb-0">Purchase Invoice</h4>
              
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <div class="row bg bg-white">
      <div class="col-sm-4"><b>Purchase Date خریداری کی تاریخ
      </b> <p> {{ $master->pur_date }} </p>
      </div>
      <div class="col-sm-4"><b>Vendor  : </b>
        <p>{{ $master->v_name }}<br>{{ $master->v_address }}<br>{{ $master->v_phone }}<br>{{ $master->v_email }}</p>
    
    </div>
     <div class="col-sm-4">
      <b>Total Payable</b>
      <h4 class="mb-0 text text-center" id="total_purchase"></h4>  
    </div> 
   
 
    <div class="col-sm-12 card mt-4">
        <table class="table table-striped table-bordered dataTable">
            <thead>
                <tr>
                    <th style="background-color:#f0e2ae">Sr.No.</th>
                    <th style="background-color:#f0e2ae">Code</th>
                    <th style="background-color:#f0e2ae">Product</th>
                    <th style="background-color:#f0e2ae">Pur Price</th>
                    <th style="background-color:#f0e2ae">Qty</th>
                    <th style="background-color:#f0e2ae">Total</th>
                </tr>
            </thead>
            <tbody id="line_row">

            </tbody>
        </table>
    </div>
    </div>
    <div class="d-flex flex-wrap gap-2 float-end">
      <button type="button"  class="btn btn-shadow btn-primary mt-3"><i class="fas fa-print"></i> Print Purchase Invoice</button>
     
    </div>
    
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
              $('#line_row').append('<tr><td>'+counter+'</td><td>'+product.product_code+'</td><td>'+product.product_name+' ('+product.size_desc+' '+product.unit+')</td><td>'+product.pur_price+'</td><td>'+product.pur_qty+'</td><td>'+product.line_total+'</td></tr>');
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

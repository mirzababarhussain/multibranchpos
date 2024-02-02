@extends('layouts.app')

@section('content')
<div class="pc-content">

    <div class="row">
      <!-- [ sample-page ] start -->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body p-0">
            <select id="product_search" class="form-control">
              <option value="">Search Product</option>
              @foreach ($products as $product)
                  <option value="{{ $product->id }}">{{ $product->product_code }}-{{ $product->product_name }}</option>
              @endforeach
          </select>
          </div>
        </div>
        <script>
            function close_box(){
              document.getElementById('product_board').style.display = "none";
            }
        </script>
        <div class="modal-content bg bg-white border border-secondary shadow p-3" id="product_board" style="display: block" >
          <div class="modal-header">
            <h5 class="modal-title">Product     مصنوعات</h5>
            <button type="button" class="btn-close" onclick="close_box()"> </button>
          </div>
            <div class="row p-5">
              <div class="col-sm-6">

                <div class="row">
                  <label>Size سائز</label>
                  <select class="form-control" id="size"></select>
                </div>

              

                <div class="row mt-3">
                  <label>Qty مقدار</label>
                  <input type="number" class="form-control text text-right text-danger" name="sale_qty" id="sale_qty">
                </div>
              
                <button type="button" onclick="return add_product()" class="btn btn-success mt-4 w-100">Add to List</button>
              </div>
              
                
            <div class="col-sm-6">
                
                <h4 class="text text-center">Available Stock</h4>
               <div class="row"><h5 id="qty"></h5></div> 
              <div class="row"><h5 id="up"></h5></div>
            </div>
          </div>

        </div>
      </div>
        
            <div class="row">
              <div class="col-xl-8">
                <button id="basic" style="display:none" class="btn btn-shadow btn-primary"><i class="fas fa-print"></i> Print</button>

                <div class="card shadow" id="print_area">
                  
                  <div class="card-body border-bottom bg-light">
                    <div class="row">
                        <div class="col-sm-3">
                          <h5>Date 
                            <input type="date" name="inv_date" id="inv_date" class="form-control" value="{{ date('Y-m-d') }}">
                          </h5>
                        </div>
                        <div class="col-sm-3">
                          <h5>Inv #: <span class="ms-2 f-14 px-2 badge bg-light-secondary rounded-pill">{{ $data->inv_code }}</span></h5>
                        </div>
                        <div class="col-sm-3">
                          <h5>Cart Item <span class="ms-2 f-14 px-2 badge bg-light-secondary rounded-pill" id="cart_item">0</span></h5>
                        </div>
                        <div class="col-sm-3">
                          <h5>Till By <span class="ms-2 f-14 px-2 badge bg-light-secondary rounded-pill">{{ auth()->user()->name }}</span></h5>
                        </div>
                        
                    </div>
                    
                  </div>
                
                  <div class="card-body p-0 table-body">
                    <div class="p-0">
                      <table class="table mb-0 border border-secondary" id="pc-dt-simple">
                        <thead style="background-color:#f0e2ae" >
                          <tr>
                            <th class="border-secondary">Product</th>
                            <th class="border-secondary">Size</th>
                            <th class="text-end border-secondary">Price</th>
                            <th class="text-center border-secondary">Quantity</th>
                            <th class="text-end border-secondary">Total</th>
                            <th class="text-end border-secondary d-print-none"></th>
                          </tr>
                        </thead>
                        <tbody id="products_row">
                          
                          
                        </tbody>
                      </table>
                      <div class="col-sm-12 text text-center center" id="selected_customer">
                            
                      </div>
                      <div class="col-sm-12 text text-center center" id="selected_customer">
                            
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-end">
                  <button id="confirm_btn"  class="btn btn-shadow btn-success" onclick="return confirm_sale_invoice()">Confirm Invoice</button>
                </div>
              </div>
              <div class="col-xl-4">
                <div class="card shadow">
                  <div class="card-body">
                    
                    <div class="input-group my-2">
                      <select id="customer" class="form-control">
                          <option value="">---Select Customer---</option>
                          @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->customer_code }}-{{ $customer->name }}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="card shadow">
                  <div class="card-body py-2">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item px-0">
                        <h5 class="mb-0">Customer Detail</h5>
                      </li>
                      <li class="list-group-item px-0">
                        <div class="float-end">
                          <h5 class="mb-0" id="cust_code">02400</h5>
                        </div><span class="text-muted">Code</span>
                      </li>
                      <li class="list-group-item px-0">
                        <div class="float-end">
                          <h5 class="mb-0" id="cust_name">-</h5>
                        </div><span class="text-muted">Customer Name</span>
                      </li>
                      <li class="list-group-item px-0">
                        <div class="float-end">
                          <h5 class="mb-0" id="cust_contact">-</h5>
                        </div><span class="text-muted">Contact</span>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="card shadow">
                  <div class="card-body py-1">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item px-0">
                        <div class="float-end">
                          <h5 class="mb-0" id="sub_total">0.00</h5>
                        </div>
                        <h5 class="mb-0 d-inline-block">Total</h5>
                      </li>
                    </ul>
                  </div>
                </div>
                
               
              </div>
            </div>
        
      </div>
      <!-- [ sample-page ] end -->
    </div>
    <input type="hidden" value="0" id="product_counter">
  </div>
  <script>
    function confirm_sale_invoice(){
        var inv_date = document.getElementById('inv_date').value;
        var customer_id = document.getElementById('customer').value;
        var inv_id = {{ $data->id }};
        var product_counter = document.getElementById('product_counter').value;

        if(inv_date == ""){
          Swal.fire({
            icon: 'error',
            title: 'Please Select Invoice Date'
          });
          return false;
        }
        else if(product_counter == 0 || product_counter == ""){
          Swal.fire({
            icon: 'error',
            title: 'No Product found in invoice.'
          });
          return false;
        }
        else if(customer_id == ""){
          Swal.fire({
            icon: 'error',
            title: 'Please Select Customer'
          });
          return false;
        }
        else if(inv_id == ""){
          Swal.fire({
            icon: 'error',
            title: 'No Invoice # found, invoice can not proceed'
          });
          return false;
        }
        let url = "{{ route('home.confirm_sale_inv') }}";
        $.ajax({
          url:url,
          type:'POST',
          data:{
            inv_date:inv_date,
            cust_id:customer_id,
            inv_id:inv_id
          },
          success: function(data){
            document.getElementById('confirm_btn').style.display = "none";
            document.getElementById('basic').style.display = "";
            $('#print_area').printThis({
        base: "https://jasonday.github.io/printThis/"
      });
          },
          error: function(response){
            console.log(response);
          }
        });

    }
     $(document).ready(function(){ 
      get_sale_product();
     });
     $('#customer').change(function (e) { 
                e.preventDefault();
                  $('#cust_code').empty();
                  $('#cust_name').empty();
                  $('#cust_contact').empty();
                  $('#selected_customer').empty(); 
                    var cust_id = $(this).val();
                    let a = '{{ route("home.get_customer","id")}}';
                    var url = a.replace('id',cust_id);
                  $.ajax({
                    url:url,
                    type: 'GET',
                    data:{},
                    success: function(data){
                      console.log(data.customer);
                      $('#cust_code').append(data.customer['customer_code']+'/'+data.customer['cnic']);
                      $('#cust_name').append(data.customer['name']);
                      document.getElementById('selected_customer').innerHTML = "Customer : "+data.customer['customer_code']+'/'+data.customer['cnic']+'/'+data.customer['name'];

                      $('#cust_contact').append(data.customer['phone']+'/'+data.customer['address']); 
                    },
                    error: function(response){
                      console.log(response);
                    }
                  });
     });
     function remove_sale_products(id){
      Swal.fire({
                title: 'confirm Delete?',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: `Yes`,
                denyButtonText: `Don't Delete`
              }).then((result) => {
                if (result.isConfirmed) {
                  let a = "{{ route('home.remove_sale_products','id') }}";
                  var url = a.replace('id',id);
                  $.ajax({
                    url:url,
                    type:'GET',
                    data:{},
                    success: function(data){

                      Swal.fire('Deleted!', '', 'success');
                      get_sale_product();
                      $('#product_search').select2('open');
                    },
                    error: function(response){
                      console.log(response);
                    }
                  })
                } 
              });
     }
    function get_sale_product(){
      $('select').val([]).trigger('change');
      
      document.getElementById('sale_qty').value = "";
      $('#products_row').empty();
        var id = {{ $data->id }};
        let a = "{{ route('home.get_sale_products','id') }}";
        var url = a.replace('id',id);
        $.ajax({
          url:url,
          type:'GET',
          data:{},
          success: function(data){
            let products = data.products;
            var total_sale = 0;
            var total_qty = 0;
            var cart_items = 0;
            $('#sub_total').empty();
            $('#cart_item').empty();
            if(products.length > 0){
              $.each(products,function(id,product){
                total_sale = parseInt(total_sale) + parseInt(product.sub_total);
                total_qty = parseInt(total_qty) + parseInt(product.sale_qty);
                cart_items = parseInt(cart_items) + 1;
                $('#products_row').append('<tr><td> <div class="media align-items-center"> <div class="media-body ms-3"> <h5 class="mb-1">'+product.product_name+'('+product.product_code+')</h5> <p class="text-sm text-muted mb-0">'+product.product_description+'</p> </div> </div> </td><td>'+product.size+' '+product.unit+'</td><td class="text-end"> <h5 class="mb-0">'+product.sale_price+'</h5> </td> <td class="text-center">'+product.sale_qty+'</td> <td class="text-end"> <h5 class="mb-0">'+product.sub_total+'</h5> </td> <td class="d-print-none text-end"> <a href="javascript:remove_sale_products('+product.id+')" class="avtar avtar-s btn-link-danger btn-pc-default"> <i class="ti ti-trash f-18 d-print-none"></i> </a> </td> </tr>');
              });
            }
            $('#products_row').append('<tr><td colspan="3">TOTAL</td><td align="right">'+total_qty+'</td><td align="right">'+total_sale.toLocaleString("en-US")+" PKR"+'</td></tr>');
            $('#cart_item').append(cart_items);
            document.getElementById('product_counter').value = cart_items;
            $('#sub_total').append(total_sale.toLocaleString("en-US")+" PKR")
      close_box();
      $('#product_search').select2('open');

          },
          error: function(response){
            console.log(response);
          }
        });
    }
    $(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});
    function add_product(){
      var product_id = document.getElementById('product_search').value;
      var size_id = document.getElementById('size').value;
      var qty = document.getElementById('sale_qty').value;
      if(product_id == "" || size_id == "" || qty == "" || qty <= 0)
      {
            Swal.fire({
            icon: 'info',
            title: 'Please fill product detail'
          });
          return false;
      }
      var url = "{{ route('home.add_product_sale') }}";
      $.ajax({
        url:url,
        type: 'POST',
        data: {
          id:size_id,
          inv_id:{{ $data->id }},
          sale_qty:qty
         },
    
        success: function(data){
          console.log(data);
          get_sale_product();
        },
        error: function(respoonse){
          Swal.fire({
            icon: 'info',
            title: respoonse.message
          });
        }
      });
    }
    $('#product_search').change(function (e) { 
                e.preventDefault();
                   document.getElementById("size").innerHTML = ''; 
                    var product_id = $(this).val();
                    let a = '{{ route("getsalesizes","id")}}';
                    var url = a.replace('id',product_id);
                $.ajax({
                    url : url,
                    type : 'GET',
                    data : product_id,
                    contentType : false,
                    processData : false,

                    success : function(data){
                      document.getElementById('product_board').style.display = "";
                        let products = data.sizes; 
                            if(products.length > 0){ 

                                $('#size').append('<option value="">---Select---</option>');   
                                $.each(products, function (key, value) 
                                {
                                   $('#size').append('<option value="'+value.id+'">'+value.size+ ' '+value.unit+'</option>');
                                });
                                $('#size').select2('open');
                            }
                            else
                            {
                              $('#product_search').select2('open');
                              close_box();
                            }
                            
                            
                    },

                    error : function(reject){
                      console.log(reject);
                    }
                });
            });
            /* Sale Price and QTY*/
            $('#size').change(function (e) {
              $('#qty').empty(); 
              $('#up').empty(); 
                e.preventDefault();
                    var id = $(this).val();
                    let a = '{{ route("getsaleprices","id")}}';
                    var url = a.replace('id',id);
                $.ajax({
                    url : url,
                    type : 'GET',
                    data : id,
                    contentType : false,
                    processData : false,

                    success : function(data){
                     
                       $('#qty').append('<h4 class="float-end text-center">Qty: '+data.price.stock+'</h4>');
                      $('#up').append('<h4 class="float-end text-center">UP: '+data.price.sale_price+' PKR</h4>');
                    },

                    error : function(reject){
                      console.log(reject);
                    }
                });
            });
  </script>

             
          
@endsection

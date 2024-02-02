@extends('layouts.app')

@section('content')
<div class="pc-content">

    <div class="row">
      <!-- [ sample-page ] start -->
      
        
            <div class="row">
              <div class="col-xl-12">
                <div class="text-end">
                  <button id="basic" class="btn btn-shadow btn-danger"><i class="fas fa-print"></i> Print</button>
                </div>

                <div class="card shadow mt-2" id="print_area">
                  
                  <div class="card-body border-bottom bg-light">
                    <div class="row">
                        <div class="col-sm-3">
                          <h5>Return Date 
                            <span class="ms-2 f-14 px-2 badge bg-light-secondary rounded-pill">{{ $data->ret_inv_date }}</span>
                          </h5>
                        </div>
                        <div class="col-sm-3">
                          <h5>Ret Inv #: <span class="ms-2 f-14 px-2 badge bg-light-secondary rounded-pill">{{ $data->ret_inv_code }}</span></h5>
                        </div>
                        <div class="col-sm-3">
                          <h5>Ret Item <span class="ms-2 f-14 px-2 badge bg-light-secondary rounded-pill" id="cart_item">0</span></h5>
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
                            <th class="text-center border-secondary">QTY</th>
                            <th class="text-end border-secondary">Total</th>
                          </tr>
                        </thead>
                        <tbody id="products_row">
                          
                          
                        </tbody>
                      </table>
                      <div class="col-sm-12 text text-center center" id="selected_customer">
                            Customer: {{ $data->customer_code }}-{{ $data->name }}
                      </div>
                      
                    </div>
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
  
     $(document).ready(function(){ 
      get_sale_product();
     });
    
    function get_sale_product(){
     
      $('#products_row').empty();
        var id = {{ $data->id }};
        let a = "{{ route('sale.get_return_products','id') }}";
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
                $('#products_row').append('<tr><td> <div class="media align-items-center"> <div class="media-body ms-3"> <h5 class="mb-1">'+product.product_name+'('+product.product_code+')</h5> <p class="text-sm text-muted mb-0">'+product.product_description+'</p> </div> </div> </td><td>'+product.size+' '+product.unit+'</td><td class="text-end"> <h5 class="mb-0">'+product.sale_price+'</h5> </td> <td class="text-center">'+product.sale_qty+'</td> <td class="text-end"> <h5 class="mb-0">'+product.sub_total+'</h5> </td></tr>');
              });
            }
            $('#products_row').append('<tr><td colspan="3">TOTAL</td><td align="right">'+total_qty+'</td><td align="right">'+total_sale.toLocaleString("en-US")+" PKR"+'</td></tr>');
            $('#cart_item').append(cart_items);
           

          },
          error: function(response){
            console.log(response);
          }
        });
    }
    $(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});
    
    
  </script>

             
          
@endsection

@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Print Barcode Label</h4>
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
                  <div class="col-sm-12">
                    
                    <div class="col-sm-12">
                      <div class="card">
                        <div class="card-body p-0">
                          <div class="row">
                            <div class="col-sm-3">
                              Product
                            </div>
                            <div class="col-sm-3">
                              Size
                            </div>
                            <div class="col-sm-3">
                              No. of Labels
                            </div>
                            <div class="col-sm-3">
                              
                            </div>
                            <div class="col-sm-3">
                              <select id="product_search" class="form-control">
                                <option value="">Search Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_code }}-{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-sm-3">
                              <select class="form-control" id="size"></select>
                            </div>
                            <div class="col-sm-3">
                              <input type="number" class="form-control text text-right text-danger" name="sale_qty" id="sale_qty">
                            </div>
                            <div class="col-sm-3">
                            <button type="button" onclick="return print_label()" class="btn btn-success">create Label</button>

                            </div>
                          </div>
                         
                      
                      </div>
                      <script>
                          function close_box(){
                            document.getElementById('product_board').style.display = "none";
                          }
                      </script>
                      <div class="" id="product_board" style="display: block" >
                        
                          <div class="row p-5">
                           
                              
                          <div class="col-sm-6">
                              
                             <div class="row"><h5 id="qty"></h5></div> 
                            <div class="row"><h5 id="up"></h5></div>
                          </div>
                        </div>

                       <button id="basic" class="btn btn-shadow btn-primary float-end mt-2"><i class="fas fa-print"></i> Print</button> 
              <div class="row" id="print_area">
                
              </div>
              
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
            
              
             
            
          </div>
        </div>
             
      </div>
    </div>
    
  </div>
</div>

 <script>
  function print_label(){
    var id = document.getElementById('size').value;
    var label_counter = document.getElementById('sale_qty').value;
    if(id == "" || id == 0 || label_counter == 0 || label_counter == ""){
      $('#qty').empty();
      $('#qty').append('<h4 class="text text-danger">Error! Product Size or Print Labels Qty not Entered</h4>')
    }
    else
    {
      var url = "{{ route('barcode.get_print_label') }}";
      $.ajax({
        url:url,
        type:'POST',
        data:{
          id:id,
        },
        success:function(data){
          $('#print_area').empty();
          console.log(data.barcode);
          for(var i = 1; i<= label_counter; i++){
            
            $('#print_area').append('<div class="col-sm-3" style="border-top:dotted 1px #000"><span style="font-size:10px;">'+data.label.product_name+'</span><small><br></small>'+data.barcode+'<p style="font-size:10px">'+data.label.external_barcode+'<small><br>Rs.'+data.price+'</small></p></div>')
          }
          
        },
        error:function(error){
          console.log(error);
        }
      })
    }
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
                              //$('#product_search').select2('open');
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


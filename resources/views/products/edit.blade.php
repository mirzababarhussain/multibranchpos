@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Edit Product پروڈکٹ میں ترمیم کریں۔</h4>
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
                    <h5>اس سیکشن میں صارف پروڈکٹ کو اپ ڈیٹ کر سکتا ہے۔</h5>
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ route('products') }}" class="btn btn-shadow btn-primary">
                      Back to Products مصنوعات کی فہرست پر واپس                   </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">

              <form method="POST" action="{{ route('products.update') }}">
                @csrf
                <input type="hidden" value="{{ $product->id }}" required name="id">
                <div class="row">
                <div class="row mt-4"><h4>Product's Basic detail پروڈکٹ کی بنیادی تفصیلات</h4></div>

                  <div class="col-sm-12 mt-2">
                    <label>Category مصنوعات کے زمرے کا انتخاب کریں۔ <small class="text text-danger">*</small></label>
                    <select class="select2 form-control" required name="category">
                        <option value="">---Select---</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                              @if($product->cate_id == $category->id)
                                @php
                                  echo "SELECTED"
                                @endphp
                                  
                                @else
                                
                              @endif
                             
                                >{{ $category->cate_name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col-sm-12 mt-3">
                      <label>Enter Product Name پروڈکٹ کا نام درج کریں۔ <small class="text text-danger">*</small></label>
                      <input type="text" value="{{ $product->product_name }}" name="product_name" class="form-control" required placeholder="enter product name">
                  </div>
                  <div class="col-sm-12 mt-3">
                    <label>Enter Product Description پروڈکٹ کی تفصیل درج کریں۔</label>
                    <textarea name="product_desc" class="form-control" placeholder="enter product description">{{ $product->product_description }}</textarea>
                </div>
                </div>
                <div class="row mt-4"><h4>Sizes & Prices پروڈکٹ کا سائز اور قیمتوں کی تفصیلات</h4></div>
                <div class="row deen" id="dyn_row">
                  
                  @foreach ($prices as $price)
                    
                  <div class="row mt-2">
                    <div class="col-sm-2 mt-2"> <label>Unit یونٹ</label> 
                      <select name="unit[]" class="form-control" required> 
                        <option value="">Select</option> 
                        @foreach ($units as $unit) 
                        <option value="{{ $unit->unit }}"
                          @if($price->unit == $unit->unit)
                          @php
                            echo "SELECTED"
                          @endphp
                            
                          @else
                          
                        @endif
                          >{{ $unit->unit }}</option> @endforeach 
                      </select> 
                    </div> 
                    <div class="col-sm-2"> <label>Size مقدار/سائز</label> 
                      <input type="number" name="qty[]" value="{{ $price->size }}" class="form-control" required> 
                    </div> 
                    <div class="col-sm-2"> <label>Pur Price قیمت خرید</label> 
                      <input type="number" name="pur_price[]" value="{{ $price->pur_price }}" class="form-control" required> 
                    </div> 
                    <div class="col-sm-2"> <label>Sale Price  قیمت فروخت</label> 
                      <input type="number" name="sale_price[]" value="{{ $price->sale_price }}" class="form-control" required> 
                    </div> 
                    <div class="col-sm-2"> <label>Disc %  فیصد میں رعایت</label> 
                      <input type="number" name="disc[]" value="{{ $price->disc }}" class="form-control" required> 
                    </div>
                    <div class="col-sm-2"> <label>Stock   اوپننگ اسٹاک </label> 
                      <input type="number" name="stock[]" value="{{ $price->stock }}" class="form-control" required>
                      <a href="#" class="text text-danger float-end remove_price_line">X</a>
                    </div>
            <input type="text" name="barcode[]" value="{{ $price->barcode }}"  onchange="return stop_form(this.value)" placeholder="Enter Barcode if any" class="form-control mt-2">

                  </div>

                  @endforeach
              </div>
              <a href="javascript:add_row()" class="btn btn-danger mt-2">Add More</a>
              <button type="button" onclick="complete_scanning()" class="btn btn-shadow  btn-info mt-4 float-end ">Scanning Completed</button>  
              <button type="submit" disabled style="display: none" id="btn_save" name="btn_Save" class="mr-5 btn btn-shadow btn-success mt-4 float-end">Save Product پروڈکٹ کو محفوظ کریں۔</button>
              </form>
              
            </div>
          </div>
        </div>
      </div>
    </div> 
    
  </div>
<script>
  function complete_scanning(){
      document.getElementById('btn_save').style.display = "";
      document.getElementById('btn_save').disabled  = false;
     }

     function stop_form(barcode){
      
      var id = barcode;
        let a = "{{ route('barcode.verify','id') }}";
        var url = a.replace('id',id);
        $.ajax({
          url:url,
          type:'GET',
          data:{},
          success: function(data){
            console.log(data);
            if(data.result == 0){

              document.getElementById('btn_save').style.display = "";
              
            }
            else
            {
              alert("Barcode already exists");
              var focusedElement = document.activeElement;
              focusedElement.value = "";
              focusedElement.focus();
              document.getElementById('btn_save').style.display = "none";
              
            }
          }
        })
     }
      function add_row(){
         // var getrow = document.getElementById('dyn_row');
            
          $("#dyn_row").append('<div class="row mt-2"><div class="col-sm-2 mt-2"> <label>Unit یونٹ</label> <select name="unit[]" class="form-control" required> <option value="">Select</option> @foreach ($units as $unit) <option value="{{ $unit->unit }}">{{ $unit->unit }}</option> @endforeach </select> </div> <div class="col-sm-2"> <label>Size مقدار/سائز</label> <input type="number" name="qty[]" class="form-control" required> </div> <div class="col-sm-2"> <label>Pur Price قیمت خرید</label> <input type="number" name="pur_price[]" class="form-control" required> </div> <div class="col-sm-2"> <label>Sale Price  قیمت فروخت</label> <input type="number" name="sale_price[]" class="form-control" required> </div> <div class="col-sm-2"> <label>Disc %  فیصد میں رعایت</label> <input type="number" name="disc[]" class="form-control" required> </div><div class="col-sm-2"> <label>Stock   اوپننگ اسٹاک </label> <input type="number" name="stock[]" class="form-control" required><a href="#" class="text text-danger float-end remove_price_line">X</a></div><input type="text" name="barcode[]" onchange="return stop_form(this.value)" placeholder="Enter Barcode if any" class="form-control mt-2"></div>');
          $('select').select2();
          document.getElementById('btn_save').disabled  = true;
          document.getElementById('btn_save').style.display = "none";
        }
      $('.deen').on('click', '.remove_price_line', function(e) {
    e.preventDefault();

    $(this).parent().parent().remove();
});
     
</script>
 
@endsection


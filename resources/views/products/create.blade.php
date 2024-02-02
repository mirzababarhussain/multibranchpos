@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Add New Product  نیا پروڈکٹ شامل کریں۔</h4>
          </div>
          
        </div>
      </div>
    </div>
    <div class="row">
      <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        
        <div class="row shadow">
          <div class="card">
            <div id="sticky-action" class="sticky-action">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col-sm-6">
                    <h5>اس سیکشن میں صارف نئی مصنوعات شامل کر سکتا ہے۔</h5>
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ route('products') }}" class="btn btn-shadow btn-primary">
                      Back to Products مصنوعات کی فہرست پر واپس                   </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">

              <form method="POST" action="{{ route('products.store') }}">
                @csrf
                <div class="row">
                <div class="row mt-4"><h4>Product's Basic detail پروڈکٹ کی بنیادی تفصیلات</h4></div>

                  <div class="col-sm-12 mt-2">
                    <label>Category مصنوعات کے زمرے کا انتخاب کریں۔ <small class="text text-danger">*</small></label>
                    <select class="select2 form-control" required name="category">
                        <option value="">---Select---</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->cate_name }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col-sm-12 mt-3">
                      <label>Enter Product Name پروڈکٹ کا نام درج کریں۔ <small class="text text-danger">*</small></label>
                      <input type="text" name="product_name" class="form-control" required placeholder="enter product name">
                  </div>
                  <div class="col-sm-12 mt-3">
                    <label>Enter Product Description پروڈکٹ کی تفصیل درج کریں۔</label>
                    <textarea name="product_desc" class="form-control" placeholder="enter product description"></textarea>
                </div>
                </div>
                <div class="row mt-4"><h4>Sizes & Prices پروڈکٹ کا سائز اور قیمتوں کی تفصیلات</h4></div>
                <div class="row deen" id="dyn_row">
                  <div class="col-sm-2 mt-2">
                      <label>Unit یونٹ</label>
                      <select name="unit[]" class="form-control" required>
                            <option value="">Select</option>
                            @foreach ($units as $unit)
                              <option value="{{ $unit->unit }}">{{ $unit->unit }}</option>
                            @endforeach
                      </select>
                  </div>
                  <div class="col-sm-2">
                      <label>Size مقدار/سائز </label>
                      <input type="number" name="qty[]" class="form-control" required>
                  </div>
                  <div class="col-sm-2">
                    <label>Pur Price قیمت خرید</label>
                    <input type="number" name="pur_price[]" class="form-control" required>
                </div>
                <div class="col-sm-2">
                  <label>Sale Price  قیمت فروخت</label>
                  <input type="number" name="sale_price[]" class="form-control" required>
              </div>
              <div class="col-sm-2">
                <label> گاہک کا منافع روپے میں</label>
                <input type="number" name="disc[]" class="form-control" required>
            </div>
            <div class="col-sm-2">
              <label>Stock   اوپننگ اسٹاک </label>
              <input type="number" name="stock[]" class="form-control" required>
          </div>
              </div>
              <a href="javascript:add_row()">Add More</a>
                <button type="submit" name="btn_Save" class="btn btn-shadow btn-success mt-4 float-end">Save Product پروڈکٹ کو محفوظ کریں۔</button>
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
          $("#dyn_row").append('<div class="row mt-2"><div class="col-sm-2 mt-2"> <label>Unit یونٹ</label> <select name="unit[]" class="form-control" required> <option value="">Select</option> @foreach ($units as $unit) <option value="{{ $unit->unit }}">{{ $unit->unit }}</option> @endforeach </select> </div> <div class="col-sm-2"> <label>Size مقدار/سائز</label> <input type="number" name="qty[]" class="form-control" required> </div> <div class="col-sm-2"> <label>Pur Price قیمت خرید</label> <input type="number" name="pur_price[]" class="form-control" required> </div> <div class="col-sm-2"> <label>Sale Price  قیمت فروخت</label> <input type="number" name="sale_price[]" class="form-control" required> </div> <div class="col-sm-2"> <label>گاہک کا منافع روپے میں</label> <input type="number" name="disc[]" class="form-control" required> </div><div class="col-sm-2"> <label>Stock   اوپننگ اسٹاک </label> <input type="number" name="stock[]" class="form-control" required><a href="#" class="text text-danger float-end remove_price_line">X</a></div></div>');
          $('select').select2();
        }
      $('.deen').on('click', '.remove_price_line', function(e) {
    e.preventDefault();

    $(this).parent().parent().remove();
});
     
</script>
 
@endsection


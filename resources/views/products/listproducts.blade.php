@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Products  مصنوعات</h4>
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
                    <h5>اس سیکشن میں صارف مصنوعات شامل، حذف، ترمیم کر سکتا ہے۔</h5>
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ url('products/create') }}" class="btn btn-shadow btn-primary">
                      Add New Product نیا پروڈکٹ شامل کریں۔
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive dt-responsive">
                <table id="row-callback" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th style="background-color:#f0e2ae">Sr.No.<br>سیریل نمبر</th>
                      <th style="background-color:#f0e2ae">Products<br>اس زمرے میں مصنوعات</th>
                      <th style="background-color:#f0e2ae">Category<br>قسم</th>
                      <th style="background-color:#f0e2ae">Detail<br>تفصیل</th>
                     <th style="background-color:#f0e2ae">Status<br>حالت</th>
                      <th style="background-color:#f0e2ae">Disable<br> غیر فعال کریں۔</th>
                      <th style="background-color:#f0e2ae">Enable<br>فعال کریں</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $index = 1;
                    @endphp
                    @foreach ($products as $product)
                      
                    <tr>
                      <td>{{ $index++ }}<br>{{ $product->product_code }}</td>
                      <td>
                        {{ $product->product_name }}
                      </td>
                      <td>{{ $product->category->cate_name }}</td>
                      <td class="text text-center"><a href="{{ route('products.edit',$product->id) }}" class="btn btn-secondary">Detail تفصیل</a></td>
                     <td class="text text-center">{{ $product->disable == 0 ? 'Enable فعال' : 'Disabled غیر فعال' }}</td>
                      <td class="text text-center">
                        <form method="POST" action="{{ route('products.delete') }}">
                          @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <button type="submit" onclick="return confirm('Are You Sure کیا آپ واقعی غیر فعال  چاہتے ہیں؟')" class="btn text-danger" title="Diable غیر فعال"><i class="fas fa-times"></i></button>
                        </form>
                      </td>
                      <td class="text text-center">
                        <form method="POST" action="{{ route('products.restore') }}">
                          @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <button type="submit" onclick="return confirm('Are You Sure کیا آپ واقعی  فعال  چاہتے ہیں؟')" class="btn text-success" title="Enable فعال"><i class="fas fa-check"></i></button>
                        </form>
                       
                       
                      </td>
                    </tr>
                    
                    @endforeach
                 
                
                  </tbody>
                 
                </table>
              </div>
            </div>
          </div>
        </div>
             
      </div>
    </div>
    
  </div>

 
@endsection


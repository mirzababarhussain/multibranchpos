@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Stock </h4>
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
                <div class="row align-items-center bg bg-light p-3">
                  <form method="POST" action="{{ route('stock.show') }}">
                    @csrf
                    
                  <label>Branches</label>
                  <select class="form-control" name="branch_id">
                    <option value="">---Select---</option>
                    <option value="0"> Main Store </option>
                    @foreach ($branches as $branch)
                      <option value="{{ $branch->id }}">{{ $branch->branch_name }} {{ $branch->branch_address }}</option>
                    @endforeach
                  </select>
                  <button type="submit" class="btn btn-shadow btn-primary mt-1 float-end">Search</button>
                </form>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive dt-responsive">
                @if(isset($selected_branch))
                  
              
                <h4>{{ $selected_branch->branch_name }} {{ $selected_branch->branch_address }}</h4>
                @else
                  <h4>Main Store</h4>
                @endif
                <table id="row-callback" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Sr.No.</th>
                      <th>Products</th>
                    
                      <th>Stock</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      use App\Http\Controllers\StockController;
                      use \Milon\Barcode\DNS1D;
                      
                      $index = 1;
                      isset($selected_product) ? $products = $selected_product :  '';
                    @endphp
                    
                    @foreach ($products as $product)
                      @php
                        $stocks = StockController::stock($product->id,$product->branch_id)
                      @endphp
                    <tr>
                      <td>{{ $index++ }}<br>{{ $product->product_code }}</td>
                      <td>
                        {{ $product->product_name }}
                      </td>
                      <td>
                        @foreach ($stocks as $stock)
                          <div class="row mt-3">
                            <div class="col-sm-3">{{ $stock->size }} {{ $stock->unit }}</div>
                            <div class="col-sm-3">{{ $stock->stock }}</div>
                            
                            <div class="col-sm-6">{!! DNS1D::getBarcodeSVG("$stock->internal_barcode", 'C128',1,35,'black', false); !!}
                              <small><br>{{ $stock->external_barcode }}</small>
                            </div>
                          </div>
                        @endforeach
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


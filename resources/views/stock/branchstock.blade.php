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
          <div class="text-end">
            <button id="basic" class="btn btn-shadow btn-danger"><i class="fas fa-print"></i> Print</button>
          </div>
          <div class="card shadow mt-2" id="print_area">
            <div id="sticky-action" class="sticky-action">
              <div class="card-header">
                <div class="row align-items-center bg bg-light p-3">
                  {{ $selected_branch->branch_name }} {{ $selected_branch->branch_address }}
                </div>
                <div class="float-end">
                  <form method="POST" action="{{ route('stock.get_stock_by_product') }}">
                  @csrf
                  <select class="form-control" required name="product_id">
                    <option value="">---Select Product---</option>
                    @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->product_code }}-{{ $product->product_name }}</option>
                    @endforeach
                  </select>
                  <button type="submit" class="btn btn-shadow btn-primary">Search</button>
                </form>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive dt-responsive">
               
                <table id="row-callback" class="table table-striped table-bordered">
                  <thead >
                    <tr>
                      <th style="background-color:#f0e2ae">Sr.No.</th>
                      <th style="background-color:#f0e2ae">Products</th>
                    
                      <th style="background-color:#f0e2ae">Stock</th>
                    </tr>
                  </thead>
                  <tbody class="bg bg-white">
                    @php
                      use App\Http\Controllers\StockController;
                      use \Milon\Barcode\DNS1D;
                      $index = 1;
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
                          <div class="row">
                            <div class="col-sm-3">{{ $stock->size }} {{ $stock->unit }}</div>
                            <div class="col-sm-3">{{ $stock->stock }}</div>
                            
                            <div class="col-sm-6">{!! DNS1D::getBarcodeHTML("$stock->internal_barcode", 'UPCA'); !!}
                              <small>{{ $stock->external_barcode }}</small>
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


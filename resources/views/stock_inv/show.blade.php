@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          
          <div class="col-md-12">
            <div class="page-header-title">
              <h4 class="mb-0">Stock Invoice</h4>
              
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <div class="row bg bg-white shadow" id="print_area">
      <div class="col-sm-4"><b>INV Date   اسٹاک انوائس کی تاریخ
      </b> <p> {{ $master->stock_inv_date }} </p>
      </div>
      <div class="col-sm-4"><b>Branch  : </b>
        <p>{{ $master->branch_name }}<br>{{ $master->branch_address }}<br>{{ $master->branch_contact_person }}<br>{{ $master->branch_phone }}</p>
    
    </div>
    <div class="col-sm-4">
      <b>Status: </b>
      <span>{{ $master->inv_status  }}</span>
    </div>
    
   
 
    <div class="col-sm-12 card mt-4">
        <table class="table table-striped table-bordered dataTable">
            <thead>
                <tr>
                  <th style="background-color:#f0e2ae">Sr.No.</th>
                  <th style="background-color:#f0e2ae">Product</th>
                  <th style="background-color:#f0e2ae">Size/Unit</th>
                  <th style="background-color:#f0e2ae">Stock Qty</th>
               
                </tr>
            </thead>
            <tbody>
              @php
                $index = 1;
              @endphp
              @foreach ($details as $detail)
                
              <tr>
                <td>{{ $index++ }}</td>
                <td>{{ $detail->product_code }}-{{ $detail->product_name }}<small><br>{{ $detail->product_description }}</small></td>
                <td>{{ $detail->size }}-{{ $detail->unit }}</td>
                <td>{{ $detail->issued_stock }}</td>
              </tr>
              @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-sm-4">
          <b>Created By:</b><br>
          <span>{{ $created_by->name }}</span>
        </div>
        <div class="col-sm-4">
          <b>Received By:</b><Br>
          <span>{{ isset($received_by->name) ? $received_by->name : '' }}</span>
        </div>
        <div class="col-sm-4">
          <b>Signature (Branch Owner):</b><Br><br><br>
          <span>_____________________________________________</span>
        </div>
    </div>
    </div>
    <div class="d-flex flex-wrap gap-2 float-end">


      <button type="button" id="basic"  class="btn btn-shadow btn-primary mt-3"><i class="fas fa-print"></i> Print Stock Invoice</button>
      @if($master->inv_status != 'Confirm')
        
      <button type="button" onclick="return confirm_purchase({{ $master->id }},'Confirm')"  class="btn btn-shadow btn-success mt-3"><i class="fas fa-tick"></i> Confirm & Update Stock تصدیق شدہ</button>
      @else
        
      @endif
     
    </div>
    <p><br><br><br></p>
    <p><br><br><br></p>
    
  </div>
  <script>
    function confirm_purchase(id,status){
     
      let url = '{{ route("stock_invoice.confirm_status") }}';
      $.ajax({
        url:url,
        type: 'POST',
        data:{
          id:id,
          status:status,
          vendor_id:{{ $master->branch_id }},
          pur_date:{{ $master->stock_inv_date }}
        },
        success: function(data){
          window.location = "{{ url('stock_invoice') }}";
        },
        error: function(response){
          console.log(reponse);
        }
      })
    }
    </script>
    
@endsection

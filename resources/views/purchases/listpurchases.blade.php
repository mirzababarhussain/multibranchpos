@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Purchases  مصنوعات خریداری</h4>
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
                    <h5>اس سیکشن میں صارف خریداری کی رسیدیں بنا سکتا ہے۔</h5>
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ url('purchases/create') }}" class="btn btn-shadow btn-primary">
                      Add New Purchase نیا خریداری شامل کریں۔
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive dt-responsive">
                <table id="row-callback" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th style="background-color:#f0e2ae">Sr.No.<br>سیریل نمبر</th>
                      <th style="background-color:#f0e2ae">Pur Date</th>
                      <th style="background-color:#f0e2ae">Total Purchase<br>خریداری کی کل رقم   </th>
                      <th style="background-color:#f0e2ae">Vendor<br>وینڈر</th>
                      <th style="background-color:#f0e2ae">Status<br>حالت</th>
                      <th style="background-color:#f0e2ae">Detail<br>تفصیل</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $index = 1;
                    
                    @endphp
                    @foreach ($purchases as $purchase)
                      
                   
                   
                   <tr>
                      <td>{{ $index++  }}</td>
                      <td>{{ $purchase->pur_date }}</td>

                      <td>{{ number_format($purchase->total_pur) }}</td>
                      <td>{{ $purchase->v_name }}</td>
                      <td><span class="badge bg-light-{{ $purchase->pur_status == 'Confirm' ? 'success' : 'primary' }}">{{ $purchase->pur_status }}</span></td>
                      <td><a href="{{ route('purchases.show',$purchase->id) }}" class="btn btn-secondary">Detail تفصیل</a></td>

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


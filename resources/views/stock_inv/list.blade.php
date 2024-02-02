@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Stock Invoices   اسٹاک رسیدیں</h4>
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
                    <h5>اس سیکشن میں صارف اسٹاک رسیدیں بنا سکتا ہے۔</h5>
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ route('stock_invoice.create') }}" class="btn btn-shadow btn-primary">
                      Add New Stock Invoice نیا اسٹاک رسیدیں شامل کریں۔
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
                      <th style="background-color:#f0e2ae">Inv Date<br>رسید کی تاریخ</th>
                      <th style="background-color:#f0e2ae">Branch<br>برانچ   </th>
                      <th style="background-color:#f0e2ae">Received by<br>وصول کنندہ</th>
                      <th style="background-color:#f0e2ae">Status<br>حالت</th>
                      <th style="background-color:#f0e2ae">Detail<br>تفصیل</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $index = 1;
                    
                    @endphp
                    @foreach ($stock_invoices as $stock_invoice)
                      
                   
                   
                   <tr>
                      <td>{{ $index++  }}</td>
                      <td>{{ $stock_invoice->stock_inv_date }}</td>
                      <td>{{ $stock_invoice->branch_name }}<br>{{ $stock_invoice->branch_address }}</td>
                      <td></td>
                     
                      <td><span class="badge bg-light-{{ $stock_invoice->inv_status == 'Confirm' ? 'success' : 'primary' }}">{{ $stock_invoice->inv_status }}</span></td>
                      <td><a href="{{ route('stock_invoice.show',$stock_invoice->id) }}" class="btn btn-secondary">Detail تفصیل</a></td>

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


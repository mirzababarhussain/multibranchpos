@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          
          <div class="col-md-12">
            <div class="page-header-title">
              <h4 class="mb-0">Sale Return Invoices     سیل انوائس </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="card shadow">
        <div id="sticky-action" class="sticky-action">
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col-sm-6">
                <h5>اس سیکشن میں صارف سیل انوائس  شامل، حذف، ترمیم کر سکتا ہے۔</h5>
              </div>
              <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">

                <a href="{{ route('sale.sale_return') }}" class="btn btn-shadow btn-primary">
                  New Sale Return نیا سیل انوائس  شامل کریں۔
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
                  <th style="background-color:#f0e2ae">Sr.No. <br> سیریل نمبر</th>
                  <th style="background-color:#f0e2ae">Ret Invoice <br>         واپسی کی رسید نمبر   </th>
                  <th style="background-color:#f0e2ae">Date <br>   واپسی کی تاریخ   </th>
                  <th style="background-color:#f0e2ae">Name <br> کسٹمر </th>
                  <th style="background-color:#f0e2ae">Total <br>  کل رقم</th>
                  <th style="background-color:#f0e2ae">Detail <br>  تفصیل</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $index = 1;
                @endphp
                @foreach ($invoices as $invoice)
                  
                <tr>
                  <td>{{ $index++ }}</td>
                  <td>{{ $invoice->ret_inv_code }}</td>
                  <td>{{ $invoice->ret_inv_date }}</td>
                  <td>
                    {{ $invoice->customer_code }}-{{ $invoice->name }}<br>
                  </td>
                  <td align="right">{{ number_format($invoice->total_sale_return) }}</td>
                 
                  <td class="text text-center center">
                      <a href="{{ route('sale.get_return_view',$invoice->id) }}" class="text text-primary" title="Print پرنٹ کریں"><i class="fas fa-print"></i></a>
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
  
@endsection

@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Customer Finanical Statement    گاہک کے فنانس </h4>
          </div>
          
        </div>
      </div>
    </div>
    <div class="row">
      <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        
        <div class="row">
          <div class="card shadow" id="print_area">
            <div id="sticky-action" class="sticky-action">
              <div class="card-header">
                @if(!isset($datas))
                <div class="row align-items-center">
                  <div class="col-sm-5">
                    <div class="card shadow">
                      <div class="card-header">
                        <h5>Customer's Statement</h5>
                      </div>
                      <form method="POST" action="{{ route('reports.get_customer_report') }}">
                        @csrf
                      
                          <div class="card-body">
                            <label>Customer</label>
                            <select class="form-control" required name="selected_customer">
                                <option value="0"> All Customers </option>
                                @foreach ($customers as $customer)
                                  <option value="{{ $customer->id }}">{{ $customer->customer_code }}-{{ $customer->name }}-{{ $customer->address }}</option>
                                @endforeach
                            </select>
                            <div class="input-daterange input-group" id="datepicker_range">
                              
                              <input type="date" class="form-control" required name="start_date">
                              <input type="date" class="form-control" required name="end_date">
                            </div>
                            <div class="d-grid gap-2 mt-2">
                              <button class="btn btn-success btn-shadow" type="submit">Search Report تلاش کریں</button>
                            </div>
                          </div>
                    </form>
                    </div>
                  </div>
                  
                </div>
                @else
                <h5>{{ $report_heading }}
                  <button class="btn btn-danger float-end" id="basic"><i class="fas fa-print"></i> Print</button>
                  <a href="{{ route('reports.purchase_report') }}" class="btn btn-primary float-end mr-3"><i class="fas fa-backward"></i> Back</a>
                
                </h5>
                <h5>{{ $vendor }}</h5>
                @endif
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive dt-responsive">
                <table  class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th style="background-color:#f0e2ae">Sr #<br>سیریل نمبر</th>
                      <th style="background-color:#f0e2ae">Trans-Date<br>      لین دین کی تاریخ</th>
                      <th style="background-color:#f0e2ae">Customer<br>صارف</th>
                      <th style="background-color:#f0e2ae">Debit<br>ڈیبٹ</th>
                      <th style="background-color:#f0e2ae">Credit<br>کریڈٹ</th>
                      <th style="background-color:#f0e2ae">Balance<br> </th>
                     
                      
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $g_total = 0;
                      $g_profit = 0;
                    @endphp
                    @if(isset($datas))
                    @foreach ( $datas as $data)
                      <tr>
                        <td>P-{{ $data->id }}</td>
                        <td>{{ $data->pur_date }}</td>
                        <td>{{ $data->v_code }}-{{ $data->v_name }}<small><br>{{ $data->v_address }}</small></td>
                        <td>{{ $data->pur_status }}</td>
                        <td>{{ number_format($data->total_pur) }}</td>
                        
                      </tr>
                      @php
                        $g_total = $g_total + $data->total_pur;
                      @endphp
                    @endforeach
                    <tr>
                      <th colspan="4">TOTAL</th>
                      <th>{{ number_format($g_total) }}</th>

                    </tr>
                    @endif
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


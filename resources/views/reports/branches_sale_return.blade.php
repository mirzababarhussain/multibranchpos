@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Sale Return Report        فروخت کی واپسی کی رپورٹ</h4>
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
                        <h5>Branch Sale Return Report</h5>
                      </div>
                      <form method="POST" action="{{ route('reports.get_sale_return_report') }}">
                        @csrf
                      
                          <div class="card-body">
                            <label>Branch</label>
                            <select class="form-control" required name="selected_branch">
                                <option value="0"> All Branches </option>
                                @foreach ($branches as $branch)
                                  <option value="{{ $branch->id }}">{{ $branch->branch_code }}-{{ $branch->branch_name }}</option>
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
                  <a href="{{ route('reports.sale_return_report') }}" class="btn btn-primary float-end mr-3"><i class="fas fa-backward"></i> Back</a>
                
                </h5>
                <h5>{{ $branch }}</h5>
                @endif
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive dt-responsive">
                <table  class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th style="background-color:#f0e2ae">Ret Inv #<br>رسید نمبر</th>
                      <th style="background-color:#f0e2ae">Ret Inv Date<br>  رسید کی تاریخ</th>
                      <th style="background-color:#f0e2ae">Branch<br>برانچ</th>
                      <th style="background-color:#f0e2ae">Customer<br>خریدار</th>
                      <th style="background-color:#f0e2ae">Total<br>کل رقم</th>
                      
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
                        <td>{{ $data->ret_inv_code }}</td>
                        <td>{{ $data->ret_inv_date }}</td>
                        <td>{{ $data->branch_code }}-{{ $data->branch_name }}<small><br>{{ $data->branch_address }}</small></td>
                        <td>{{ $data->customer_code }}-{{ $data->name }}</td>
                        <td>{{ number_format($data->total_sale_return) }}</td>
                      </tr>
                      @php
                        $g_total = $g_total + $data->total_sale_return;
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


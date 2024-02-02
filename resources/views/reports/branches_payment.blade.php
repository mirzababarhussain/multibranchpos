@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Ledger Report     لیجر رپورٹ </h4>
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
                        <h5>Ledger Report</h5>
                      </div>
                      <form method="POST" action="{{ route('reports.get_payment_report') }}">
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
                    <a href="{{ route('reports.payment_report') }}" class="btn btn-primary float-end mr-3"><i class="fas fa-backward"></i> Back</a>
                  
                  </h5>
                  <h5>{{ $branch }}</h5>
                  
                @endif
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive dt-responsive">
                <table id="print_area" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th style="background-color:#f0e2ae">Date<br>    تاریخ</th>
                      <th style="background-color:#f0e2ae">Account Type<br>    اکاؤنٹ کی اقسام</th>
                      <th style="background-color:#f0e2ae">Account<br>   اکاؤنٹ </th>
                      <th style="background-color:#f0e2ae">Detail<br>  تفصیل</th>
                      <th style="background-color:#f0e2ae">Debit<br>کل رقم</th>
                      <th style="background-color:#f0e2ae">Credit<br>خریدار</th>
                      <th style="background-color:#f0e2ae">Balance<br></th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      use  app\Http\Controllers\ReportsController;
                    @endphp
                    @if(isset($datas))
                    @php
                     
                      $total_debit = 0;
                      $total_credit = 0;
                    @endphp
                    @foreach ( $datas as $data)
                      <tr>
                        <td>{{ $data->paid_date }}</td>
                        <td>{{ $data->account_type }}</td>
                        <td>{{ ReportsController::account_info($data->account_id,$data->account_type) }}</td>
                        <td>{{ $data->trans_detail }}</small></td>
                        <td>{{ number_format($data->debit) }}</td>
                        <td>{{ number_format($data->credit) }}</td>
                        <td>{{ number_format($data->balance) }}</td>
                      </tr>
                      @php
                        $total_debit = $total_debit + $data->debit;
                        $total_credit = $total_credit + $data->credit;
                      @endphp

                    @endforeach
                    <tr style="font-weight: bold">
                      <td align="right" colspan="4">TOTAL</td>
                      <td>{{ number_format($total_debit) }}</td>
                      <td>{{ number_format($total_credit) }}</td>
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


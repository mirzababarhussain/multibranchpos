@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          
          <div class="col-md-12">
            <div class="page-header-title">
              <h4 class="mb-0">Payments (Ledger Date: @php
                echo date('d/m/Y')
              @endphp)</h4>
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
              
              <div class="col-sm-12 text-sm-end mt-3 mt-sm-0">

                <a href="{{ route('ledger.create',1) }}" class="btn btn-shadow btn-primary">
                  Pay to Vendor
                </a>
                <a href="{{ route('ledger.create',2) }}" class="btn btn-shadow btn-primary">
                 Branch to Bank
                </a>
                <a href="{{ route('ledger.create',3) }}" class="btn btn-shadow btn-primary">
                  Bank to Bank
                </a>
                <a href="{{ route('ledger.create',4) }}" class="btn btn-shadow btn-primary">
                  Branch to Cash Sale
                 </a>
                <a href="{{ route('ledger.create',5) }}" class="btn btn-shadow btn-primary">
                  Cash Sale to Bank
                </a>

                <a href="#" class="btn btn-shadow btn-danger">
                  Pay Customer Profit
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
                  <th style="background-color:#f0e2ae">Sr.No.</th>
                  <th  style="background-color:#f0e2ae">Entry<br>Date</th>
                  <th  style="background-color:#f0e2ae">Payment<br>Date</th>
                  <th  style="background-color:#f0e2ae">Account Type </th>
                  <th  style="background-color:#f0e2ae">Debit</th>
                  <th  style="background-color:#f0e2ae">Credit</th>
                  <th  style="background-color:#f0e2ae">Balance</th>
                </tr>
              </thead>
              <tbody>
                @php
                use App\Http\Controllers\LedgerController;
                  $index = 1;
                @endphp
                  @foreach ($ledgers as $ledger)
                    
                  <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ ($ledger->created_at)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($ledger->paid_date)->format('d/m/Y')}}</td>
                    <td>{{ $ledger->account_type }} {{ LedgerController::account_detail($ledger->account_id,$ledger->account_type) }}</td>
                    <td>{{ $ledger->debit }}</td>
                    <td>{{ $ledger->credit }}</td>
                    <td>{{ $ledger->balance }}</td>
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

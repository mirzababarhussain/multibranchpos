@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          
          <div class="col-md-12">
            <div class="page-header-title">
              <h4 class="mb-0">Branch Detail برانچ کی تفصیل </h4>
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
                <h4><b>{{ $branch->branch_name }}</b></h4>
                <h5>{{ $branch->branch_address }}<br>{{ $branch->branch_contact_person }}<br>{{ $branch->branch_phone }}<br>{{ $branch->branch_email }}</h5>
                         
               
              </div>
              <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">

                <a href="{{ route('branches') }}" class="btn btn-shadow btn-primary">
                  Branchses List واپس برانچ فہرست 
                </a>
              </div>
              <div class="row mt-4">
                  <div class="col-sm-12">
                    
                    <h4 class="float-end">Branch Cash : <span class="text text-danger">{{ number_format($balance->balance) }}</span>  قابل موصول</h4>

                  </div>
                
              </div>
            </div>
          </div>
        </div>
        
        <div class="card-body">
          <div class="table-responsive dt-responsive">
            <table id="row-callback" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="background-color:#f0e2ae">Sr.No. </th>
                  <th style="background-color:#f0e2ae">Date   </th>
                  <th style="background-color:#f0e2ae">Description     </th>
                  <th style="background-color:#f0e2ae">Debit      </th>
                  <th style="background-color:#f0e2ae">Credit  </th>
                  <th style="background-color:#f0e2ae">Balance   </th>
                </tr>
              </thead>
              <tbody>
                @php
                  $index = 1;
                @endphp
                @foreach ($transactions as $transaction)
                  
                <tr>
                  <td>{{ $index++ }}</td>
                  <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                  <td>{{ $transaction->trans_detail }}</td>
                  <td>{{ $transaction->debit }}</td>
                  <td>{{ $transaction->credit }}</td>
                  <td>{{ number_format($transaction->balance) }}</td>
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

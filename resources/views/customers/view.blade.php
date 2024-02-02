@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          
          <div class="col-md-12">
            <div class="page-header-title">
              <h4 class="mb-0">Customer گاہک کے اکاؤنٹ کی تفصیل </h4>
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
                <h4><b>{{ $customer->customer_code }} - {{ $customer->name }}</b></h4>
                   
              </div>
              <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">

                <a href="{{ route('customers') }}" class="btn btn-shadow btn-primary">
                  Customers List واپس فہرست 
                </a>
              </div>
            </div>
          </div>
        </div>
        
        <div class="card-body">
          <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body py-0">
                  <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" id="profile-tab-1" data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="true">
                        <i class="ti ti-user me-2"></i>Profile
                      </a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="profile-tab-2" data-bs-toggle="tab" href="#profile-2" role="tab" aria-selected="false" tabindex="-1">
                        <i class="ti ti-file-text me-2"></i>Sale Statement
                      </a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="profile-tab-3" data-bs-toggle="tab" href="#profile-3" role="tab" aria-selected="false" tabindex="-1">
                        <i class="ti ti-id me-2"></i>Investment 
                      </a>
                    </li>
                   
                  </ul>
                </div>
              </div>
              <div class="tab-content">
                <div class="tab-pane active show" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                  <div class="row">
                    <div class="col-lg-4 col-xxl-3">
                      <div class="card">
                        <div class="card-body position-relative">
                          <div class="position-absolute end-0 top-0 p-3">
                            <span class="float-end badge bg-{{ $customer->disable == 1 ? 'danger' : 'success' }}">{{ $customer->disable == 1 ? 'disabled غیر فعال' : 'enabled فعال' }}</span>
                          </div>
                          <div class="text-center mt-3">
                           
                            <h5 class="mb-0">{{ $customer->name }}</h5>
                            <p class="text-muted text-sm">{{ $customer->customer_code }}</p>
                            <hr class="my-3 border border-secondary-subtle">
                            <div class="row g-3">
                              
                            </div>
                            <hr class="my-3 border border-secondary-subtle">
                            <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                              <i class="ti ti-mail me-2"></i>
                              <p class="mb-0">{{ $customer->email }}</p>
                            </div>
                            <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                              <i class="ti ti-phone me-2"></i>
                              <p class="mb-0">(+92) {{ $customer->phone }}</p>
                            </div>
                            <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                              <i class="ti ti-map-pin me-2"></i>
                              <p class="mb-0">{{ $customer->address }}</p>
                            </div>
                            
                          </div>
                        </div>
                      </div>
                      
                    </div>
                    <div class="col-lg-8 col-xxl-9">
                      
                      <div class="card">
                        <div class="card-header">
                          <h5>Investment Details</h5>
                        </div>
                        <div class="card-body">
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 pt-0">
                              <div class="row">
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Invested Amount</p>
                                  <p class="mb-0">{{ number_format($investment->amount) }}</p>
                                </div>
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Profit Percentage</p>
                                  <p class="mb-0">{{ $investment->profit_percentage }}%</p>
                                </div>
                              </div>
                            </li>
                            <li class="list-group-item px-0">
                              <div class="row">
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Start Date</p>
                                  <p class="mb-0">{{ $investment->start_date }}</p>
                                </div>
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">End Date</p>
                                  <p class="mb-0">{{ $investment->end_date }}</p>
                                </div>
                              </div>
                            </li>
                            
                           
                          </ul>
                        </div>
                      </div>
                      
                      
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="card">
                        <div class="card-header">
                          <h5>Sale Statement</h5>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            
                              <table class="table">
                                <thead>
                                    <tr>
                                      <th>Date</th>
                                      <td>Detail</td>
                                      <th>Debit</th>
                                      <th>Credit</th>
                                      <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach ($sale_profits as $sale_profit)
                                      <tr>
                                        <td>{{ $sale_profit->paid_date }}</td>
                                        <td>{{ $sale_profit->trans_detail }}</td>
                                        <td>{{ $sale_profit->debit }}</td>
                                        <td>{{ $sale_profit->credit }}</td>
                                        <td>{{ $sale_profit->balance }}</td>
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
                <div class="tab-pane" id="profile-3" role="tabpanel" aria-labelledby="profile-tab-3">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h5>Investment Statement</h5>
                        </div>
                        <div class="card-body">
                          
                        </div>
                      </div>
                    </div>
                    
                    
                    
                    
                  </div>
                </div>
                
                
                
              </div>
            </div>
            <!-- [ sample-page ] end -->
          </div>
          
        </div>
      </div>
    </div>
        
  </div>
  
@endsection

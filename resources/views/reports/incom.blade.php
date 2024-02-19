@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Monthly Income </h4>
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
                <div class="row align-items-center">
                  <div class="card">
                    
                    <div class="card-body">
                      <form class="row row-cols-md-auto g-3 align-items-center">
                        <div class="col-12">
                          <label class="sr-only" for="inlineFormInputName">Name</label>
                          <input type="month" class="form-control" id="inlineFormInputName">
                        </div>
                        
                        
                        <div class="col-12">
                          <button type="submit" class="btn btn-primary">Get Income Report</button>
                        </div>
                        <div class="col-12">
                          <button type="submit" class="btn btn-primary">Get Ledger Report</button>
                        </div>
                      </form>
                      
                    </div>
                  </div>
                  
                </div>
                
                
              </div>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive dt-responsive">
                <table  class="table datatable-table" id="pc-dt-simple">
                  
                    <tr class="border border-dark">
                        <th width="60%" class="border border-dark">Title-Description</th>
                        <th width="20%" class="border border-dark">Payment Sent</th>
                        <th width="20%" class="border border-dark">Payment Received</th>
                    </tr>
                    <tr class="border border-dark">
                      <td align="right" width="60%" style="text-align: center" class="border border-dark">Branches</td>
                      <td align="center" width="20%" style="text-align: right" class="border border-dark">0.00</td>
                      <td align="center" width="20%" style="text-align: right" class="border border-dark">0.00</td>
                  </tr>
                  <tr class="border border-dark">
                    <td align="right" width="60%" style="text-align: center" class="border border-dark">Vendors</td>
                    <td align="center" width="20%" style="text-align: right" class="border border-dark">0.00</td>
                    <td align="center" width="20%" style="text-align: right" class="border border-dark">0.00</td>
                </tr>
                <tr class="border border-dark">
                  <td align="right" width="60%" style="text-align: center" class="border border-dark">Purchases</td>
                  <td align="center" width="20%" style="text-align: right" class="border border-dark">0.00</td>
                  <td align="center" width="20%" style="text-align: right" class="border border-dark">0.00</td>
              </tr>
              <tr class="border border-dark">
                <td align="right" width="60%" style="text-align: center" class="border border-dark">Customers</td>
                <td align="center" width="20%" style="text-align: right" class="border border-dark">0.00</td>
                <td align="center" width="20%" style="text-align: right" class="border border-dark">0.00</td>
            </tr>
                 
                </table>
              </div>
            </div>
          </div>
        </div>
             
      </div>
    </div>
    
  </div>

 
@endsection


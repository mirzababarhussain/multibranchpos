<div class="row">
    <div class="col-sm-9">
        <div class="row">

        
    <div class="col-sm-4">
        <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              
            </div>
            <div class="flex-grow-1 ms-3">
              <h5 class="mb-0">Payments ادائیگیاں</h5>
              <small class="text-muted">         ادائیگی درج کریں</small>
            </div>
            <div class="dropdown">
              <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical f-18"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ route('ledger.create',1) }}">Pay to Vendor</a>
                <a class="dropdown-item" href="{{ route('ledger.create',2) }}">Branch to Bank</a>
                <a class="dropdown-item" href="{{ route('ledger.create',3) }}">Bank to Bank</a>
                <a class="dropdown-item" href="{{ route('ledger.create',4) }}">Branch to Cash Sale</a>
                <a class="dropdown-item" href="{{ route('ledger.create',5) }}">Cash Sale to Bank</a>
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-4">
            <div class="user-group able-user-group">
              
            </div>
            <a href="{{ route('ledger.payments') }}" class="btn btn-light-primary" title="Go to">
                Go to Payments<i class="fas fa-arrow-alt-circle-right f-20"></i> 
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              
            </div>
            <div class="flex-grow-1 ms-3">
              <h5 class="mb-0">Stock اسٹاک</h5>
              <small class="text-muted">    اسٹاک اور ایشو اسٹاک انوائس   </small>
            </div>
            <div class="dropdown">
              <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical f-18"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ route('stock') }}">View Stock</a>
                <a class="dropdown-item" href="{{ route('stock_invoice.index') }}">List Stock Invoices</a>
                <a class="dropdown-item" href="{{ route('stock_invoice.create') }}">Create Stock Invoices</a>
               
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-4">
            <div class="user-group able-user-group">
              
            </div>
            <a href="{{ route('stock') }}" class="btn btn-light-primary" title="Go to">
                Go To Stock <i class="fas fa-arrow-alt-circle-right f-20"></i> 
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              
            </div>
            <div class="flex-grow-1 ms-3">
              <h5 class="mb-0">Customers گاہک</h5>
              <small class="text-muted">کسٹمر مینجمنٹ</small>
            </div>
            <div class="dropdown">
              <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical f-18"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ route('customers') }}">View Customers</a>
                <a class="dropdown-item" href="{{ route('customers.create') }}">Add New Customer</a>
               
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-4">
            <div class="user-group able-user-group">
              
            </div>
            <a href="{{ route('customers') }}" class="btn btn-light-primary" title="Go to">
                Go To Customers <i class="fas fa-arrow-alt-circle-right f-20"></i> 
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              
            </div>
            <div class="flex-grow-1 ms-3">
              <h5 class="mb-0">Purchases خریداری</h5>
              <small class="text-muted">خریداری مینجمنٹ</small>
            </div>
            <div class="dropdown">
              <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical f-18"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ route('purchases') }}">View Purchases</a>
                <a class="dropdown-item" href="{{ route('purchases.create') }}">Add New Purchase</a>
               
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-4">
            <div class="user-group able-user-group">
              
            </div>
            <a href="{{ route('purchases') }}" class="btn btn-light-primary" title="Go to">
                Go To Purchases <i class="fas fa-arrow-alt-circle-right f-20"></i> 
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              
            </div>
            <div class="flex-grow-1 ms-3">
              <h5 class="mb-0">Vendors  سپلائرز</h5>
              <small class="text-muted">سپلائرز / فروش مینجمنٹ</small>
            </div>
            <div class="dropdown">
              <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical f-18"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ route('vendors') }}">View Vendors</a>
                <a class="dropdown-item" href="{{ route('vendors.create') }}">Add New Vendor</a>
               
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-4">
            <div class="user-group able-user-group">
              
            </div>
            <a href="{{ route('vendors') }}" class="btn btn-light-primary" title="Go to">
                Go To Vendors <i class="fas fa-arrow-alt-circle-right f-20"></i> 
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              
            </div>
            <div class="flex-grow-1 ms-3">
              <h5 class="mb-0">Products  مصنوعات</h5>
              <small class="text-muted">  مصنوعات مینجمنٹ</small>
            </div>
            <div class="dropdown">
              <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical f-18"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ route('products') }}">View Products</a>
                <a class="dropdown-item" href="{{ route('products.create') }}">Add New Product</a>
               
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-4">
            <div class="user-group able-user-group">
              
            </div>
            <a href="{{ route('products') }}" class="btn btn-light-primary" title="Go to">
                Go To products <i class="fas fa-arrow-alt-circle-right f-20"></i> 
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              
            </div>
            <div class="flex-grow-1 ms-3">
              <h5 class="mb-0">Branches  شاخیں</h5>
              <small class="text-muted">  شاخیں مینجمنٹ</small>
            </div>
            <div class="dropdown">
              <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical f-18"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ route('branches') }}">View Brancnes</a>
                <a class="dropdown-item" href="{{ route('branches.create') }}">Add New Branch</a>
               
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-4">
            <div class="user-group able-user-group">
              
            </div>
            <a href="{{ route('branches') }}" class="btn btn-light-primary" title="Go to">
                Go To Branches <i class="fas fa-arrow-alt-circle-right f-20"></i> 
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              
            </div>
            <div class="flex-grow-1 ms-3">
              <h5 class="mb-0">Banks  بینک</h5>
              <small class="text-muted">  بینک مینجمنٹ</small>
            </div>
            <div class="dropdown">
              <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical f-18"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ route('banks') }}">View Banks</a>
                <a class="dropdown-item" href="{{ route('banks.create') }}">Add New Banks</a>
               
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-4">
            <div class="user-group able-user-group">
              
            </div>
            <a href="{{ route('banks') }}" class="btn btn-light-primary" title="Go to">
                Go To Banks <i class="fas fa-arrow-alt-circle-right f-20"></i> 
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
        <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              
            </div>
            <div class="flex-grow-1 ms-3">
              <h5 class="mb-0">Users  برانچ صارفین</h5>
              <small class="text-muted">  برانچ صارفین مینجمنٹ</small>
            </div>
            <div class="dropdown">
              <a class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical f-18"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{ route('branches.branch_user_list') }}">View Branch User</a>
                <a class="dropdown-item" href="{{ route('branches.create_branch_user') }}">Add New User</a>
               
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between mt-4">
            <div class="user-group able-user-group">
              
            </div>
            <a href="{{ route('branches.branch_user_list') }}" class="btn btn-light-primary" title="Go to">
                Go To Branch Users <i class="fas fa-arrow-alt-circle-right f-20"></i> 
            </a>
          </div>
        </div>
      </div>
    </div>
</div>
</div>
<div class="col-sm-3">
    @include('reportsection')
</div>
</div>

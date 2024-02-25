    <!DOCTYPE html>
    <html lang="en">
      <!-- [Head] start -->
    
      <head>
        <title>Sajjad</title>
        <!-- [Meta] -->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="Phoenixcoded">
    
        <!-- [Favicon] icon -->
        <link rel="icon" href="{{ asset('assets/images/favicon.svg')}}" type="image/x-icon">
     <!-- [Font] Family -->
     <link href="{{ asset('assets/css/plugins/animate.min.css" rel="stylesheet" type="text/css')}}">
     <link rel="stylesheet" href="{{ asset('assets/css/plugins/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css')}}" id="main-font-link" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css')}}" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css')}}" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css')}}" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css')}}" />
    
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/uikit.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datepicker-bs5.min.css')}}">
    
      </head>
      <!-- [Head] end -->
      <!-- [Body] Start -->
    
      <body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">
        <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
      <div class="loader-track">
        <div class="loader-fill">
        </div>
      </div>
    </div>
    <!-- [ Pre-loader ] End -->
     <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar {{ auth()->user()->branch_id > 0 ? 'pc-sidebar-hide' : '' }}" style="background-color: #fff">
      <div class="navbar-wrapper">
        <div class="m-header">
          <a href="#" class="b-brand text-primary">
            <!-- ========   Change your logo from here   ============ -->
            <img src="{{ asset('assets/images/logo.png')}}" class="img-fluid w-50 mt-1" />
            <span class="badge bg-light-success rounded-pill ms-2 theme-version">v 1.0</span>
          </a>
        </div>
        <div class="navbar-content">
          <div class="card pc-user-card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                  <img src="{{ asset('assets/images/user/avatar-1.jpg')}}" alt="user-image" class="user-avtar wid-45 rounded-circle" />
                </div>
                <div class="flex-grow-1 ms-3 me-2">
                  <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                  <small>{{ auth()->user()->branch_id == 0 ? 'Administrator' : 'Branch USer' }}</small>
                </div>
                <a class="btn btn-icon btn-link-secondary avtar" data-bs-toggle="collapse" href="#pc_sidebar_userlink">
                  <svg class="pc-icon">
                    <use xlink:href="#custom-sort-outline"></use>
                  </svg>
                </a>
              </div>
              <div class="collapse pc-user-links" id="pc_sidebar_userlink">
                <div class="pt-3">
                 
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ti ti-power"></i>
                    <span>
                       Logout
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </span>
                  </a>
                </div>
              </div>
            </div>
          </div>
    
          <ul class="pc-navbar">
            @if(auth()->user()->branch_id == 0)
              
          
            <li class="pc-item pc-caption">
              <label>Admin Navigation</label>
            </li>
            <li class="pc-item">
                <a href="{{ route('ledger.payments') }}" class="pc-link">
                  <span class="pc-micon">
                    <svg class="pc-icon">
                      <use xlink:href="#custom-story"></use>
                    </svg>
                  </span>
                  <span class="pc-mtext">Payments</span>
                </a>
            </li>
            <li class="pc-item">
              <a href="{{ route('stock') }}" class="pc-link">
                <span class="pc-micon">
                  <svg class="pc-icon">
                    <use xlink:href="#custom-story"></use>
                  </svg>
                </span>
                <span class="pc-mtext">Stock</span>
              </a>
          </li>
          <li class="pc-item">
            <a href="{{ route('stock_invoice.index') }}" class="pc-link">
              <span class="pc-micon">
                <svg class="pc-icon">
                  <use xlink:href="#custom-story"></use>
                </svg>
              </span>
              <span class="pc-mtext">Stock Issuance</span>
            </a>
        </li>
            <li class="pc-item">
                <a href="{{ route('purchases') }}" class="pc-link">
                  <span class="pc-micon">
                    <svg class="pc-icon">
                      <use xlink:href="#custom-story"></use>
                    </svg>
                  </span>
                  <span class="pc-mtext">Purchases</span>
                </a>
            </li>
            <li class="pc-item">
                <a href="{{ route('products') }}" class="pc-link">
                  <span class="pc-micon">
                    <svg class="pc-icon">
                      <use xlink:href="#custom-story"></use>
                    </svg>
                  </span>
                  <span class="pc-mtext">Products</span>
                </a>
            </li>
            <li class="pc-item">
                <a href="{{ route('categories') }}" class="pc-link">
                  <span class="pc-micon">
                    <svg class="pc-icon">
                      <use xlink:href="#custom-story"></use>
                    </svg>
                  </span>
                  <span class="pc-mtext">Categories</span>
                </a>
            </li>
            <li class="pc-item">
                <a href="{{ route('vendors') }}" class="pc-link">
                  <span class="pc-micon">
                    <svg class="pc-icon">
                      <use xlink:href="#custom-story"></use>
                    </svg>
                  </span>
                  <span class="pc-mtext">Vendors</span>
                </a>
            </li>
            <li class="pc-item">
                <a href="{{ route('branches') }}" class="pc-link">
                  <span class="pc-micon">
                    <svg class="pc-icon">
                      <use xlink:href="#custom-story"></use>
                    </svg>
                  </span>
                  <span class="pc-mtext">Branches</span>
                </a>
            </li>
            <li class="pc-item">
              <a href="{{ route('branches.branch_user_list') }}" class="pc-link">
                <span class="pc-micon">
                  <svg class="pc-icon">
                    <use xlink:href="#custom-story"></use>
                  </svg>
                </span>
                <span class="pc-mtext">Branch Users</span>
              </a>
          </li>
            <li class="pc-item">
              <a href="{{ route('banks') }}" class="pc-link">
                <span class="pc-micon">
                  <svg class="pc-icon">
                    <use xlink:href="#custom-story"></use>
                  </svg>
                </span>
                <span class="pc-mtext">Banks</span>
              </a>
          </li>
          @else
              
          <li class="pc-item">
            <a href="{{ route('home') }}" class="pc-link">
              <span class="pc-micon">
                <svg class="pc-icon">
                  <use xlink:href="#custom-story"></use>
                </svg>
              </span>
              <span class="pc-mtext">Sale</span>
            </a>
        </li>
          
        <li class="pc-item">
          <a href="{{ route('stock.branch_stock',auth()->user()->branch_id) }}" class="pc-link">
            <span class="pc-micon">
              <svg class="pc-icon">
                <use xlink:href="#custom-story"></use>
              </svg>
            </span>
            <span class="pc-mtext">Stock</span>
          </a>
      </li>
      <li class="pc-item">
        <a href="{{ route('barcode.print_label') }}" class="pc-link">
          <span class="pc-micon">
            <svg class="pc-icon">
              <use xlink:href="#custom-story"></use>
            </svg>
          </span>
          <span class="pc-mtext">Print Label</span>
        </a>
    </li>
      <li class="pc-item">
        <a href="{{ route('stock_invoice.index') }}" class="pc-link">
          <span class="pc-micon">
            <svg class="pc-icon">
              <use xlink:href="#custom-story"></use>
            </svg>
          </span>
          <span class="pc-mtext">Stock Receiving</span>
        </a>
    </li>
      <li class="pc-item">
        <a href="{{ route('sale.get_sale_returns') }}" class="pc-link">
          <span class="pc-micon">
            <svg class="pc-icon">
              <use xlink:href="#custom-story"></use>
            </svg>
          </span>
          <span class="pc-mtext text text-danger">Sale Return</span>
        </a>
    </li>
            @endif

            
           
            <li class="pc-item">
              <a href="{{ route('customers') }}" class="pc-link">
                <span class="pc-micon">
                  <svg class="pc-icon">
                    <use xlink:href="#custom-story"></use>
                  </svg>
                </span>
                <span class="pc-mtext">Customers</span>
              </a>
          </li>
          
           
          <li class="pc-item pc-hasmenu">
            <a href="#!" class="pc-link">
              <span class="pc-micon">
                <svg class="pc-icon">
                  <use xlink:href="#custom-graph"></use>
                </svg>
              </span>
              <span class="pc-mtext">Reports</span><span class="pc-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></a>
            <ul class="pc-submenu" style="display: none;">
              @if(auth()->user()->branch_id == 0)
                
              <li class="pc-item"><a class="pc-link" href="{{ route('reports.payment_report') }}">Branch Payment</a></li>
              <li class="pc-item"><a class="pc-link" href="{{ route('reports.purchase_report') }}">Purchase</a></li>
              <li class="pc-item"><a class="pc-link" href="{{ route('reports.vendor_report') }}">Vendor Statement</a></li>
              @else
              
              <li class="pc-item"><a class="pc-link" href="{{ route('reports.sale_report') }}">Sale</a></li>
              <li class="pc-item"><a class="pc-link" href="{{ route('reports.sale_return_report') }}">Sale Return</a></li>
              @endif
              <li class="pc-item"><a class="pc-link" href="{{ route('reports.customer_report') }}">Customer Statement</a></li>
            </ul>
          </li>
    
          </ul>
        </div>
      </div>
    </nav>
    <!-- [ Sidebar Menu ] end -->
     <!-- [ Header Topbar ] start -->
    <header class="pc-header" style="background-color: rgb(58, 93, 171); color:rgb(207, 224, 236)">
      <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
    <div class="me-auto pc-mob-drp">
      <ul class="list-unstyled">
        <!-- ======= Menu collapse Icon ===== -->
        @if(auth()->user()->branch_id > 0)
            
       
        <li class="pc-h-item pc-sidebar-collapse">
         
          <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
            <i class="ti ti-menu-2" style="color:#ffef9e"></i>
          </a>
        </li>
        <li class="pc-h-item pc-sidebar-popup">
          <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
        @else
          
        @endif
        <li class="dropdown pc-h-item">
          <a
            class="pc-head-link dropdown-toggle arrow-none m-0 trig-drp-search"
            data-bs-toggle="dropdown"
            href="#"
            role="button"
            aria-haspopup="false"
            aria-expanded="false"
            
          >
            <svg class="pc-icon">
              <use xlink:href="#custom-search-normal-1"></use>
            </svg>
          </a>
          <div class="dropdown-menu pc-h-dropdown drp-search">
            <form class="px-3 py-2">
              <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . ." />
            </form>
          </div>
        </li>
      </ul>
      @php
        use App\Http\Controllers\BranchesController;
      @endphp
      @if(auth()->user()->branch_id > 0)
      @php
        
      
      
      $branchdata = BranchesController::get_branch_data(auth()->user()->branch_id);
     // dd($branchdata)
     @endphp
     <span class="text text-center">{{ $branchdata->branch_code }} {{ $branchdata->branch_name }} {{ $branchdata->branch_address }}</span>
      @else
      <span class="text text-center">Main Store / Ware House</span>
      @endif
     
     
      @if(Session::get('message'))
        <div class="alert alert-success float-end mt-5">{{ Session::get('message') }}</div>
      @else
        
      @endif
       
    </div>
    <!-- [Mobile Media Block end] -->
    <div class="ms-auto">
      @if(auth()->user()->branch_id > 0)
        
     
      <div class="btn-group" role="group" aria-label="Basic example">
        <a href="{{ route('home') }}" class="btn btn-shadow btn-primary"><i class="fas fa-file-invoice"></i> New Sale</a>
        <a href="{{ route('home.get_sale_ivoices') }}" class="btn btn-primary btn-shadow"><i class="fas fa-search"></i> Search Sale</a>
        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-shadow"><i class="fas fa-user-plus"></i> New Customer</a>
        <a href="{{ route('customers') }}" class="btn btn-primary btn-shadow"><i class="fas fa-users"></i> Find Customer</a>
      </div>
      @else
        
      @endif
      <ul class="list-unstyled">
        <li class="dropdown pc-h-item">
          <a
           
            href="{{ route('home') }}"
          
          >
            <i class="fas fa-tachometer-alt text text-warning"></i>
          </a>
          
        </li>
        
        
        
        <li class="dropdown pc-h-item header-user-profile">
          <a
            class="pc-head-link dropdown-toggle arrow-none me-0"
            data-bs-toggle="dropdown"
            href="#"
            role="button"
            aria-haspopup="false"
            data-bs-auto-close="outside"
            aria-expanded="false"
          >
            <img src="{{ asset('assets/images/user/avatar-2.jpg')}}" alt="user-image" class="user-avtar" />
          </a>
          <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
            <div class="dropdown-header d-flex align-items-center justify-content-between">
              <h5 class="m-0">Profile</h5>
            </div>
            <div class="dropdown-body">
              <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
                <div class="d-flex mb-1">
                  <div class="flex-shrink-0">
                    <img src="{{ asset('assets/images/user/avatar-2.jpg')}}" alt="user-image" class="user-avtar wid-35" />
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Carson Darrin 🖖</h6>
                    <span>carson.darrin@company.io</span>
                  </div>
                </div>
                <hr class="border-secondary border-opacity-50" />
                <div class="card">
                  <div class="card-body py-3">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="mb-0 d-inline-flex align-items-center"
                        ><svg class="pc-icon text-muted me-2">
                          <use xlink:href="#custom-notification-outline"></use></svg
                        >Notification</h5
                      >
                      <div class="form-check form-switch form-check-reverse m-0">
                        <input class="form-check-input f-18" type="checkbox" role="switch" />
                      </div>
                    </div>
                  </div>
                </div>
                <p class="text-span">Manage</p>
                <a href="#" class="dropdown-item">
                  <span>
                    <svg class="pc-icon text-muted me-2">
                      <use xlink:href="#custom-setting-outline"></use>
                    </svg>
                    <span>Settings</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span>
                    <svg class="pc-icon text-muted me-2">
                      <use xlink:href="#custom-share-bold"></use>
                    </svg>
                    <span>Share</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span>
                    <svg class="pc-icon text-muted me-2">
                      <use xlink:href="#custom-lock-outline"></use>
                    </svg>
                    <span>Change Password</span>
                  </span>
                </a>
                <hr class="border-secondary border-opacity-50" />
                <p class="text-span">Team</p>
                <a href="#" class="dropdown-item">
                  <span>
                    <svg class="pc-icon text-muted me-2">
                      <use xlink:href="#custom-profile-2user-outline"></use>
                    </svg>
                    <span>UI Design team</span>
                  </span>
                  <div class="user-group">
                    <img src="{{ asset('assets/images/user/avatar-1.jpg')}}" alt="user-image" class="avtar" />
                    <span class="avtar bg-danger text-white">K</span>
                    <span class="avtar bg-success text-white">
                      <svg class="pc-icon m-0">
                        <use xlink:href="#custom-user"></use>
                      </svg>
                    </span>
                    <span class="avtar bg-light-primary text-primary">+2</span>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <span>
                    <svg class="pc-icon text-muted me-2">
                      <use xlink:href="#custom-profile-2user-outline"></use>
                    </svg>
                    <span>Friends Groups</span>
                  </span>
                  <div class="user-group">
                    <img src="{{ asset('assets/images/user/avatar-1.jpg')}}" alt="user-image" class="avtar" />
                    <span class="avtar bg-danger text-white">K</span>
                    <span class="avtar bg-success text-white">
                      <svg class="pc-icon m-0">
                        <use xlink:href="#custom-user"></use>
                      </svg>
                    </span>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <span>
                    <svg class="pc-icon text-muted me-2">
                      <use xlink:href="#custom-add-outline"></use>
                    </svg>
                    <span>Add new</span>
                  </span>
                  <div class="user-group">
                    <span class="avtar bg-primary text-white">
                      <svg class="pc-icon m-0">
                        <use xlink:href="#custom-add-outline"></use>
                      </svg>
                    </span>
                  </div>
                </a>
                <hr class="border-secondary border-opacity-50" />
                <div class="d-grid mb-3">
                  <button class="btn btn-primary">
                    <svg class="pc-icon me-2">
                      <use xlink:href="#custom-logout-1-outline"></use></svg
                    >Logout
                  </button>
                </div>
                <div
                  class="card border-0 shadow-none drp-upgrade-card mb-0"
                  style="background-image: url({{ asset('assets/images/layout/img-profile-card.jpg')}}"
                >
                  <div class="card-body">
                    <div class="user-group">
                      <img src="{{ asset('assets/images/user/avatar-1.jpg')}}" alt="user-image" class="avtar" />
                      <img src="{{ asset('assets/images/user/avatar-2.jpg')}}" alt="user-image" class="avtar" />
                      <img src="{{ asset('assets/images/user/avatar-3.jpg')}}" alt="user-image" class="avtar" />
                      <img src="{{ asset('assets/images/user/avatar-4.jpg')}}" alt="user-image" class="avtar" />
                      <img src="{{ asset('assets/images/user/avatar-5.jpg')}}" alt="user-image" class="avtar" />
                      <span class="avtar bg-light-primary text-primary">+20</span>
                    </div>
                    <h3 class="my-3 text-dark">245.3k <small class="text-muted">Followers</small></h3>
                    <div class="btn btn btn-warning">
                      <svg class="pc-icon me-2">
                        <use xlink:href="#custom-logout-1-outline"></use>
                      </svg>
                      Upgrade to Business
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
     </div>
    </header>
    <div class="offcanvas pc-announcement-offcanvas offcanvas-end" tabindex="-1" id="announcement" aria-labelledby="announcementLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="announcementLabel">What’s new announcement?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <p class="text-span">Today</p>
        <div class="card mb-3">
          <div class="card-body">
            <div class="align-items-center d-flex flex-wrap gap-2 mb-3">
              <div class="badge bg-light-success f-12">Big News</div>
              <p class="mb-0 text-muted">2 min ago</p>
              <span class="badge dot bg-warning"></span>
            </div>
            <h5 class="mb-3">Able Pro is Redesigned</h5>
            <p class="text-muted">Able Pro is completely renowed with high aesthetics User Interface.</p>
            <img src="{{ asset('assets/images/layout/img-announcement-1.png')}}" alt="img" class="img-fluid mb-3" />
            <div class="row">
              <div class="col-12">
                <div class="d-grid"
                  ><a
                    class="btn btn-outline-secondary"
                    href="https://1.envato.market/c/1289604/275988/4415?subId1=phoenixcoded&u=https%3A%2F%2Fthemeforest.net%2Fitem%2Fable-pro-responsive-bootstrap-4-admin-template%2F19300403"
                    target="_blank"
                    >Check Now</a
                  ></div
                >
              </div>
            </div>
          </div>
        </div>
        <div class="card mb-3">
          <div class="card-body">
            <div class="align-items-center d-flex flex-wrap gap-2 mb-3">
              <div class="badge bg-light-warning f-12">Offer</div>
              <p class="mb-0 text-muted">2 hour ago</p>
              <span class="badge dot bg-warning"></span>
            </div>
            <h5 class="mb-3">Able Pro is in best offer price</h5>
            <p class="text-muted">Download Able Pro exclusive on themeforest with best price. </p>
            <a
              href="https://1.envato.market/c/1289604/275988/4415?subId1=phoenixcoded&u=https%3A%2F%2Fthemeforest.net%2Fitem%2Fable-pro-responsive-bootstrap-4-admin-template%2F19300403"
              target="_blank"
              ><img src="{{ asset('assets/images/layout/img-announcement-2.png')}}" alt="img" class="img-fluid"
            /></a>
          </div>
        </div>
    
        <p class="text-span mt-4">Yesterday</p>
        <div class="card mb-3">
          <div class="card-body">
            <div class="align-items-center d-flex flex-wrap gap-2 mb-3">
              <div class="badge bg-light-primary f-12">Blog</div>
              <p class="mb-0 text-muted">12 hour ago</p>
              <span class="badge dot bg-warning"></span>
            </div>
            <h5 class="mb-3">Featured Dashboard Template</h5>
            <p class="text-muted">Do you know Able Pro is one of the featured dashboard template selected by Themeforest team.?</p>
            <img src="{{ asset('assets/images/layout/img-announcement-3.png')}}" alt="img" class="img-fluid" />
          </div>
        </div>
        <div class="card mb-3">
          <div class="card-body">
            <div class="align-items-center d-flex flex-wrap gap-2 mb-3">
              <div class="badge bg-light-primary f-12">Announcement</div>
              <p class="mb-0 text-muted">12 hour ago</p>
              <span class="badge dot bg-warning"></span>
            </div>
            <h5 class="mb-3">Buy Once - Get Free Updated lifetime</h5>
            <p class="text-muted">Get the lifetime free updates once you purchase the Able Pro.</p>
            <img src="{{ asset('assets/images/layout/img-announcement-4.png')}}" alt="img" class="img-fluid" />
          </div>
        </div>
      </div>
    </div>
    <!-- [ Header ] end -->
    
        <div class="pc-container" style="background-color: #cbdbec">
            
            @yield('content')
          </div>
          <!-- [ Main Content ] end -->
          <footer class="pc-footer" style="background-color: #a3c1e5">
            <div class="footer-wrapper container-fluid">
              <div class="row">
                <div class="col my-1">
                  <p class="m-0">Crafted by <a href="#" target="_blank">Babar Hussain Mughal</a> | 0300-6909242 | mirzababarhussain@gmail.com</p>
                </div>
                <div class="col-auto my-1">
                 
                </div>
              </div>
            </div>
          </footer>
       
     
          
      
          <!-- [Page Specific JS] start -->
          <script src="{{ asset('assets/js/plugins/apexcharts.min.js')}}"></script>
          <script src="{{ asset('assets/js/pages/dashboard-default.js')}}"></script>
          <!-- [Page Specific JS] end -->
          <!-- Required Js -->
          <script src="{{ asset('assets/js/plugins/popper.min.js')}}"></script>
          <script src="{{ asset('assets/js/plugins/simplebar.min.js')}}"></script>
          <script src="{{ asset('assets/js/plugins/bootstrap.min.js')}}"></script>
          <script src="{{ asset('assets/js/fonts/custom-font.js')}}"></script>
          <script src="{{ asset('assets/js/pcoded.js')}}"></script>
          <script src="{{ asset('assets/js/plugins/feather.min.js')}}"></script>
      
          <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
          <script src="{{ asset('assets/js/plugins/clipboard.min.js')}}"></script>
          <script src="{{ asset('assets/js/component.js')}}"></script>
          <script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js')}}"></script>
          <script src="{{ asset('assets/js/pages/ac-alert.js')}}"></script>
         
          <script>
            var animateModal = document.getElementById('animateModal');
            animateModal.addEventListener('show.bs.modal', function (event) {
              var button = event.relatedTarget;
              var recipient = button.getAttribute('data-pc-animate');
             <!-- var modalTitle = animateModal.querySelector('.modal-title');
              modalTitle.textContent = 'Animate Modal : ' + recipient;-->
              animateModal.classList.add('anim-' + recipient);
              if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
                document.body.classList.add('anim-' + recipient);
              }
            });
            animateModal.addEventListener('hidden.bs.modal', function (event) {
              removeClassByPrefix(animateModal, 'anim-');
              removeClassByPrefix(document.body, 'anim-');
            });
        
            function removeClassByPrefix(node, prefix) {
              for (let i = 0; i < node.classList.length; i++) {
                let value = node.classList[i];
                if (value.startsWith(prefix)) {
                  node.classList.remove(value);
                }
              }
            }
          </script>
          
          <script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js')}}"></script>
          <script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js')}}"></script>
         
           <script>
      // [ DOM/jquery ]
      var total, pageTotal;
      var table = $('#dom-jqry').DataTable();
      // [ column Rendering ]
      $('#colum-render').DataTable({
        columnDefs: [
          {
            render: function (data, type, row) {
              return data + ' (' + row[3] + ')';
            },
            targets: 0
          },
          {
            visible: false,
            targets: [3]
          }
        ]
      });
      // [ Multiple Table Control Elements ]
      $('#multi-table').DataTable({
        dom: '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
      });
      // [ Complex Headers With Column Visibility ]
      $('#complex-header').DataTable({
        columnDefs: [
          {
            visible: false,
            targets: -1
          }
        ]
      });
      // [ Language file ]
      $('#lang-file').DataTable({
        language: {
          url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json'
        }
      });
      // [ Setting Defaults ]
      $('#setting-default').DataTable();
      // [ Row Grouping ]
      var table1 = $('#row-grouping').DataTable({
        columnDefs: [
          {
            visible: false,
            targets: 2
          }
        ],
        order: [[2, 'asc']],
        displayLength: 25,
        drawCallback: function (settings) {
          var api = this.api();
          var rows = api
            .rows({
              page: 'current'
            })
            .nodes();
          var last = null;

          api
            .column(2, {
              page: 'current'
            })
            .data()
            .each(function (group, i) {
              if (last !== group) {
                $(rows)
                  .eq(i)
                  .before('<tr class="group"><td colspan="5">' + group + '</td></tr>');

                last = group;
              }
            });
        }
      });
      // [ Order by the grouping ]
      $('#row-grouping tbody').on('click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
          table.order([2, 'desc']).draw();
        } else {
          table.order([2, 'asc']).draw();
        }
      });
      // [ Footer callback ]
      $('#footer-callback').DataTable({
        footerCallback: function (row, data, start, end, display) {
          var api = this.api(),
            data;

          // Remove the formatting to get integer data for summation
          var intVal = function (i) {
            return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
          };

          // Total over all pages
          total = api
            .column(4)
            .data()
            .reduce(function (a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Total over this page
          pageTotal = api
            .column(4, {
              page: 'current'
            })
            .data()
            .reduce(function (a, b) {
              return intVal(a) + intVal(b);
            }, 0);

          // Update footer
          $(api.column(4).footer()).html('$' + pageTotal + ' ( $' + total + ' total)');
        }
      });
      // [ Custom Toolbar Elements ]
      $('#c-tool-ele').DataTable({
        dom: '<"toolbar">frtip'
      });
      // [ Custom Toolbar Elements ]
      $('div.toolbar').html('<b>Custom tool bar! Text/images etc.</b>');
      // [ custom callback ]
      $('#row-callback').DataTable({
        createdRow: function (row, data, index) {
          if (data[5].replace(/[\$,]/g, '') * 1 > 150000) {
            $('td', row).eq(5).addClass('highlight');
          }
        }
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
      $(document).ready(function() {
        $('select').select2();
    });
 
    </script>
    <script>
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      baseUrl = {!! json_encode(url('/')) !!}


      function loading_msg(){
        let timerInterval;
    Swal.fire({
      title: 'Please Wait',
      showConfirmButton: false,
      html: 'برائے مہربانی انتظار کریں',
      timer: 1000,
      timerProgressBar: true,
      willOpen: () => {
        Swal.showLoading();
        timerInterval = setInterval(() => {
          const content = Swal.getContent();
          if (content) {
            const b = content.querySelector('b');
            if (b) {
              b.textContent = Swal.getTimerLeft();
            }
          }
        }, 100);
      },
      onClose: () => {
        clearInterval(timerInterval);
      }
    }).then((result) => {
      if (result.dismiss === Swal.DismissReason.timer) {
      }
    });
      }
      function error_msg(icon,title){
        Swal.fire({
          position: 'top',
          icon: icon,
          title: title,
          showConfirmButton: false,
          timer: 1500
    });
      }
  </script>
  <script>
    $('#basic').on("click", function () {
      $('#print_area').printThis({
        base: "https://jasonday.github.io/printThis/"
      });
    });
  </script>
  
  <script src="{{ asset('assets/js/print.js')}}"></script>
  <script src="{{ asset('assets/js/plugins/datepicker-full.min.js')}}"></script>
  <script src="{{ asset('assets/js/pages/ac-datepicker.js')}}"></script>
        </body>
        <!-- [Body] end -->
      </html>


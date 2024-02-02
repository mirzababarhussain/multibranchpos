@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          
          <div class="col-md-12">
            <div class="page-header-title">
              <h4 class="mb-0">User  برانچ کے صارفین</h4>
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
                <h5>اس سیکشن میں صارف برانچ کے صارفین شامل، حذف، ترمیم کر سکتا ہے۔</h5>
              </div>
              <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">

                <a href="{{ route('branches.create_branch_user') }}" class="btn btn-shadow btn-primary">
                  Add New User نیا صارف شامل کریں۔    
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
                  <th style="background-color:#f0e2ae">Name <br> صارف کا نام</th>
                  <th style="background-color:#f0e2ae">Email <br> لاگ ان ID</th>
                  <th style="background-color:#f0e2ae">Branch <Br>  برانچ</th>
                    <th style="background-color:#f0e2ae">status</th>
                    <th style="background-color:#f0e2ae">Disable</th>
                    <th style="background-color:#f0e2ae">Enable</th>
                  <th style="background-color:#f0e2ae">Edit</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $index = 1;
                @endphp
                @foreach ($users as $user)
                  
                <tr>
                  <td>{{ $index++ }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->branch_name ? $user->branch_name : 'Main Store User' }}</td>
                  <td class="text text-{{ $user->disable == 0 ? 'primary' : 'danger' }}">{{ $user->disable == 0 ? 'enabled' : 'disabled' }}</td>
                  <td class="text text-center">
                    <form method="POST" action="{{ route('branches.delete_branch_user') }}">
                      @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <button type="submit" onclick="return confirm('Are You Sure کیا آپ واقعی حذف کرنا چاہتے ہیں؟')" class="btn text-danger" title="Delete / حذف کریں۔"><i class="fas fa-times"></i></button>
                    </form>
                  </td>
                  <td class="text text-center">
                    <form method="POST" action="{{ route('branches.restore_branch_user') }}">
                      @csrf
                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <button type="submit" onclick="return confirm('Are You Sure کیا آپ واقعی بحال کرنا چاہتے ہیں؟')" class="btn text-success" title="Delete / حذف کریں۔"><i class="fas fa-check"></i></button>
                    </form>
                  </td>
                  <td class="text text-center">
                    <a href="{{ route('branches.edit_branch_user',$user->id) }}" title="Edit / ترمیم"><i class="fas fa-pen"></i></a>
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

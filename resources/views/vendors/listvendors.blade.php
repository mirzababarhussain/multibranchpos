@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          
          <div class="col-md-12">
            <div class="page-header-title">
              <h4 class="mb-0">Vendors /  وینڈر کی فہرست </h4>
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
                <h5>اس سیکشن میں صارف وینڈر شامل، حذف، ترمیم کر سکتا ہے۔</h5>
              </div>
              <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">

                <a href="{{ route('vendors.create') }}" class="btn btn-shadow btn-primary">
                  Add New Vendor نیا وینڈر شامل کریں۔
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
                  <th style="background-color:#f0e2ae">Vendor <br> وینڈر </th>
                  <th style="background-color:#f0e2ae">Contact <br> رابطہ کی تفصیل  </th>
                  <th style="background-color:#f0e2ae">Detail <br>   تفصیل  </th>
                  <th style="background-color:#f0e2ae">Disable <Br> غیر فعال</th>
                    <th style="background-color:#f0e2ae">Enable <br>  فعال</th>
                    <th style="background-color:#f0e2ae">Edit <br>  ترمیم</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $index = 1;
                @endphp
                @foreach ($vendors as $vendor)
                  
                <tr>
                  <td>{{ $index++ }}</td>
                  <td>
                    {{ $vendor->v_name }}<br>
                    <span class="float-end badge bg-{{ $vendor->v_disable == 1 ? 'danger' : 'success' }}">{{ $vendor->v_disable == 1 ? 'disabled غیر فعال' : 'enabled فعال' }}</span>
                  </td>
                  <td>{{ $vendor->v_address }} <br>{{ $vendor->v_phone }}<br>{{ $vendor->v_email }}</td>
                  <td><a href="{{ route('vendors.show',$vendor->id) }}" class="btn btn-shadow btn-secondary">Details تفصیلات</a></td>
                  <td class="text text-center">
                    <form method="POST" action="{{ route('vendors.delete') }}">
                      @csrf
                        <input type="hidden" name="id" value="{{ $vendor->id }}">
                        <button type="submit" onclick="return confirm('Are You Sure کیا آپ واقعی غیر فعال کرنا چاہتے ہیں؟')" class="btn text-danger" title="Disable غیر فعال "><i class="fas fa-times"></i></button>
                    </form>
                  </td>
                  <td class="text text-center">
                    <form method="POST" action="{{ route('vendors.restore') }}">
                      @csrf
                        <input type="hidden" name="id" value="{{ $vendor->id }}">
                        <button type="submit" onclick="return confirm('Are You Sure کیا آپ واقعی  فعال کرنا چاہتے ہیں؟')" class="btn text-success" title="Enable فعال کریں۔"><i class="fas fa-check"></i></button>
                    </form>
                  </td>
                  <td>
                      <a href="{{ route('vendors.edit',$vendor->id) }}" class="text text-primary" title="edit ترمیم"><i class="fas fa-edit"></i></a>
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

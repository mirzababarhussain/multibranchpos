@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Branches  برانچ</h4>
          </div>
          
        </div>
      </div>
    </div>
    <div class="row">
      <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        
        <div class="row">
          <div class="card shadow">
            <div id="sticky-action" class="sticky-action">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col-sm-6">
                    <h5>اس سیکشن میں صارف برانچ شامل، حذف، ترمیم کر سکتا ہے۔</h5>
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ url('branches/create') }}" class="btn btn-shadow btn-primary">
                      Add New Branch نیا برانچ شامل کریں۔
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
                      <th style="background-color:#f0e2ae">Sr.No.<br>سیریل نمبر</th>
                      <th style="background-color:#f0e2ae">Branch<br>برانچ</th>
                      <th style="background-color:#f0e2ae">Address<br>برانچ کا پتہ</th>
                      <th style="background-color:#f0e2ae">Detail<br>تفصیل</th>
                      <th style="background-color:#f0e2ae">Status<br>حالت</th>
                      <th style="background-color:#f0e2ae">Disable<br> غیر فعال کریں۔</th>
                      <th style="background-color:#f0e2ae">Enable<br>فعال کریں</th>
                      <th style="background-color:#f0e2ae">Edit<br>ترمیم کریں</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $index = 1;
                    @endphp
                    @foreach ($branches as $branch)
                      
                    <tr>
                      <td>{{ $index++ }}<br>{{ $branch->branch_code }}</td>
                      <td>
                        {{ $branch->branch_name }}
                      </td>
                      <td>{{ $branch->branch_address }} </td>
                      <td class="text text-center"><a href="{{ route('branches.show',$branch->id) }}" class="btn btn-secondary">Detail تفصیل</a></td>
                     <td class="text text-center">{{ $branch->disable == 0 ? 'Enable فعال' : 'Disabled غیر فعال' }}</td>
                      <td class="text text-center">
                        <form method="POST" action="{{ route('branches.delete') }}">
                          @csrf
                            <input type="hidden" name="id" value="{{ $branch->id }}">
                            <button type="submit" onclick="return confirm('Are You Sure کیا آپ واقعی غیر فعال  چاہتے ہیں؟')" class="btn text-danger" title="Diable غیر فعال"><i class="fas fa-times"></i></button>
                        </form>
                      </td>
                      <td class="text text-center">
                        <form method="POST" action="{{ route('branches.restore') }}">
                          @csrf
                            <input type="hidden" name="id" value="{{ $branch->id }}">
                            <button type="submit" onclick="return confirm('Are You Sure کیا آپ واقعی  فعال  چاہتے ہیں؟')" class="btn text-success" title="Enable فعال"><i class="fas fa-check"></i></button>
                        </form>
                       
                       
                      </td>
                      <td>
                        <a href="{{ route('branches.edit',$branch->id) }}"><i class="fas fa-edit"></i></a>
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
    </div>
    
  </div>

 
@endsection


@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h4 class="mb-0">Edit User  صارف  ترمیم کریں۔</h4>
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
                    <h5>اس سیکشن میں صارف ترمیم کر سکتا ہے۔</h5> 
                  </div>
                  <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
    
                    <a href="{{ route('branches.branch_user_list') }}" class="btn btn-shadow btn-primary">
                      Back to User صارف  کی فہرست پر واپس                   </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <form method="POST" action="{{ route('branches.update_branch_user') }}" >
                    @csrf
                    <input type="hidden" name="update_password" value="no">
                    <input type="hidden" name="id" value="{{ $user->id }}">
                  <div class="modal-body">
                    <div>
                      <label>Branch </label>
                     
                      <select class="form-control" required name="branch_id" id="mySelect2">
                          <option value="">---Select---</option>
                          <option value="0"
                          @if($user->branch_id == 0)
                                    @php
                                        echo "selected"
                                  @endphp
                              @else
                                
                              @endif
                          >Main Store</option>
                          @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}"
                              @if($branch->id == $user->branch_id)
                                    @php
                                        echo "selected"
                                  @endphp
                              @else
                                
                              @endif
                              
                              >{{ $branch->branch_name }} {{ $branch->branch_address }}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="mt-3">
                      <label>Enter User's Name  باکس میں صارف کا نام درج کریں۔</label>
                      <input type="text" value="{{ $user->name }}" name="user_name" class="form-control" required>
                    </div>
               
                    <div class="mt-3">
                      <label>Enter Login ID (email)  باکس میں صارف کا ای میل درج کریں۔</label>
                      <input type="email" value="{{ $user->email }}" name="email" class="form-control" required>
                    </div>

                    <div class="mt-3">
                      <label>Status</label>
                      <select class="form-control" name="user_status" required>
                          <option value="">---Select---</option>
                          <option value="0" 
                          @if($user->disable == 0)
                            @php
                                echo "selected"
                          @endphp
                      @else
                        
                      @endif>Enable</option>
                          <option value="1"
                          @if($user->disable == 1)
                          @php
                              echo "selected"
                        @endphp
                    @else
                      
                    @endif
                          >Disable</option>
                      </select>
                    </div>

    
                   
                   
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success shadow mt-2">Save   محفوظ کریں</button>
                  </div>
                </form>
                </div>
                <div class="col-sm-6">
                  <form method="POST" action="{{ route('branches.update_branch_user') }}" >
                   @csrf
                      <input type="hidden" name="update_password" value="yes">
                      <input type="hidden" name="id" value="{{ $user->id }}">
                      <div class="mt-3">
                        <label>Enter New Login Password  باکس میں صارف کا پاس ورڈ درج کریں۔</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                      </div>
                      <div class="mt-3">
                        <label>Enter Confirm Login Password  باکس میں صارف کا پاس ورڈ درج کریں۔</label>
                        <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
                      </div>
                      <button type="submit" onclick="return confirm_password()" class="btn btn-success btn-shadow mt-2 float-end">Save   محفوظ کریں</button>
                    </form>
                </div>
              </div>
              
              
            </div>
          </div>
        </div>
      </div>
    </div> 
    
  </div>
<script>
    function confirm_password(){
      if(document.getElementById('password').value != document.getElementById('password_confirm').value)
      {
        alert('New Password and Confirm Password should same');
        return false;
      }
    }
</script>
  
@endsection


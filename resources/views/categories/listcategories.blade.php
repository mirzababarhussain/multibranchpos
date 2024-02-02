@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          
          <div class="col-md-12">
            <div class="page-header-title">
              <h4 class="mb-0">Categories / مصنوعات کی اقسام</h4>
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
                <h5>اس سیکشن میں صارف زمرے شامل، حذف، ترمیم کر سکتا ہے۔</h5>
              </div>
              <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">

                <button data-pc-animate="blur" type="button"  class="btn btn-shadow btn-primary" data-bs-toggle="modal" data-bs-target="#animateModal">
                  Add New Category / نیا زمرہ شامل کریں۔
                </button>
              </div>
            </div>
          </div>
        </div>
        @php
          use App\Http\Controllers\CategoriesController;
        @endphp
        <div class="card-body">
          <div class="table-responsive dt-responsive">
            <table id="row-callback" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th style="background-color:#f0e2ae">Sr.No. <br> سیریل نمبر</th>
                  <th style="background-color:#f0e2ae">Category <br> قسم</th>
                  <th style="background-color:#f0e2ae">Products <br> اس زمرے میں مصنوعات</th>
                  <th style="background-color:#f0e2ae">Delete <Br> حذف کریں۔</th>
                  <th style="background-color:#f0e2ae">Edit <br> ترمیم</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $index = 1;
                @endphp
                @foreach ($categories as $category)
                  
                <tr>
                  <td>{{ $index++ }}</td>
                  <td>{{ $category->cate_name }}</td>
                  <td>{{ CategoriesController::product_counter($category->id) }}</td>
                  <td class="text text-center">
                    <form method="POST" action="{{ route('categories.delete') }}">
                      @csrf
                        <input type="hidden" name="id" value="{{ $category->id }}">
                        <button type="submit" onclick="return confirm('Are You Sure کیا آپ واقعی حذف کرنا چاہتے ہیں؟')" class="btn text-danger" title="Delete / حذف کریں۔"><i class="fas fa-times"></i></button>
                    </form>
                  </td>
                  <td class="text text-center">
                    <a href="" title="Edit / ترمیم" data-bs-toggle="modal" data-bs-target="#animateModal{{ $category->id }}"><i class="fas fa-pen"></i></a>
                    @include('categories.edit')
                  </td>
                </tr>
                
                @endforeach
             
            
              </tbody>
             
            </table>
          </div>
        </div>
      </div>
    </div>
         <div class="modal fade modal-animate" id="animateModal" tabindex="-1"
            aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">New Category Form   نیا زمرہ فارم</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form method="POST" action="{{ route('categories.store') }}" >
                  @csrf
                
                <div class="modal-body">
                  <label>Enter Category Name  باکس میں زمرہ کا نام درج کریں۔</label>
                  <input type="text" name="cate_name" class="form-control" required>
               
                 
                </div>
                <div class="modal-footer">
                  <h5 class="text text-danger float-start">Category's name is mandatory <br>محفوظ کرنے سے پہلے زمرہ کا نام لازمی ہے۔</h5>
                  <button type="submit" class="btn btn-success shadow">Save   محفوظ کریں</button>
                </div>
              </form>
              </div>
            </div>
          </div>
  </div>
  
@endsection

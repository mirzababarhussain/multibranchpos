<div class="modal fade modal-animate" id="animateModal{{  $category->id }}" tabindex="-1"
            aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Category Form   زمرہ میں ترمیم کریں۔</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form method="POST" action="{{ route('categories.update') }}" >
                  @csrf
                <input type="hidden" value="{{ $category->id }}" name="id" >
                <div class="modal-body">
                  <label>Enter Category Name  باکس میں زمرہ کا نام درج کریں۔</label>
                  <input type="text" value="{{ $category->cate_name }}" name="cate_name" class="form-control" required>
               
                 
                </div>
                <div class="modal-footer">
                  <h5 class="text text-danger float-start">Category's name is mandatory <br>محفوظ کرنے سے پہلے زمرہ کا نام لازمی ہے۔</h5>
                  <button type="submit" class="btn btn-success shadow">Save   محفوظ کریں</button>
                </div>
              </form>
              </div>
            </div>
          </div>
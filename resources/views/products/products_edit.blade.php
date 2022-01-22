<div class="modal fade" id="productEditModal" tabindex="-1" role="dialog" aria-labelledby="productEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-edit-product" method="post">
                @method('PUT')
                @csrf
                {{-- <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
                <div class="modal-header mx-lg-3">
                    <h5 class="modal-title" id="productEditModalLabel">Edit Product <span class="product-getname"></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mx-lg-3">
                    <div class="form-group">
                        <label class="font-weight-bold" for="inputAddress">Product Name</label>
                        <input type="text" name="name" class="form-control product-name">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="inputAddress">Brand</label>
                        <input type="text" name="brand" class="form-control product-brand">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="inputAddress">Price</label>
                        <input type="number" name="price" class="form-control product-price"  min="0">
                    </div>
                </div>
                <div class="modal-footer mx-lg-3">
                    <button class="btn btn-sm btn-light" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt fa-xs fa-fw"></i> Submit Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="productAddModal" tabindex="-1" role="dialog" aria-labelledby="productModalAddLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-add-product" method="">
                <div class="modal-header mx-lg-3">
                    <h5 class="modal-title text-primary" id="productModalAddLabel">Add a product</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mx-lg-3">

                    <div class="form-group">
                        <label class="font-weight-bold" for="inputName">Product Name</label>
                        <input type="text" name="name" class="form-control" id="inputName"
                            placeholder="Input Products Name">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="inputBrand">Brand</label>
                        <input type="text" name="brand" class="form-control" id="inputBrand"
                            placeholder="Selected Brand">
                    </div>
                    <div class="form-row ">
                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold" for="inputPrice">Price</label>
                            <input type="number" name="price" class="form-control" id="inputPrice" min="0">
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="font-weight-bold" for="inputStock">Stock</label>
                            <input type="number" name="stock" class="form-control" id="inputStock" value="1" min="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer mx-lg-3">
                    <button class="btn btn-light btn-sm" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-check fa-sm fa-fw mr-2 text-whtie"></i>
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

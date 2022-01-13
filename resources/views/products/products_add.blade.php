<div class="modal fade" id="productAddModal" tabindex="-1" role="dialog" aria-labelledby="productModalAddLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-add-product" method="">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="productModalAddLabel">Add a product</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="inputAddress">Product Name</label>
                        <input type="text" name="name" class="form-control" id="inputAddress" placeholder="Input Products Name">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Brand</label>
                        <input type="text" name="brand" class="form-control" id="inputAddress" placeholder="Selected Brand">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Price</label>
                        <input type="number" name="price" class="form-control" id="inputAddress" min="0">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Stock</label>
                        <input type="number" name="stock" class="form-control" id="inputAddress" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

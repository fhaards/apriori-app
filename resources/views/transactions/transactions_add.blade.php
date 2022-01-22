<div class="modal fade" id="transactionAddModal" tabindex="-1" role="dialog"
    aria-labelledby="transactionAddModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <form class="form-add-transactions" method="">
                <div class="modal-header mx-lg-3">
                    <h5 class="modal-title text-primary" id="transactionAddModalLabel">
                        Input Transaction
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mx-lg-3">
                    <div class="form-row border-bottom">
                        <div class="form-group col-sm-8">
                            <label class="font-weight-bold" for="customerName">Customer Name</label>
                            <input type="text" name="customer_name" class="form-control"
                                placeholder="Input Customer Name" required>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="font-weight-bold" for="productNumber">Product Count</label>
                            <input type="number" name="product_number" class="form-control product-number" required min="0"/>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-12 py-2 my-2 border-bottom">
                            <label class="font-weight-bold">Product List</label>
                        </div>
                    </div>
                    <div class="px-4" style="max-height: 400px;overflow-x: hidden;overflow-y: scroll;">
                        <div id="select-product"></div>
                    </div>
                </div>
                <div class="modal-footer mx-lg-3">
                    <button class="btn btn-light btn-sm" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm px-3">
                        <i class="fas fa-check fa-sm fa-fw mr-2 text-whtie"></i>
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

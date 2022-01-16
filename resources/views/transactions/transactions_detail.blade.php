<div class="modal fade" id="transactionDetailModal" tabindex="-1" role="dialog"
    aria-labelledby="transactionDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <form class="form-add-transactions" method="">
                <div class="modal-header d-flex">
                    <h5 class="modal-title text-primary" id="transactionDetailModalLabel">
                        Transaction Detail
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row border border-primary mb-3 mx-1 px-3 rounded bg-light  text-dark align-items-center d-flex px-2 py-2">
                        <strong><span>Transaction ID :</span></strong>
                        <span class="transaction-id ml-sm-3"></span>
                    </div>

                    <div class="form-row border border-primary mb-3 mx-1 rounded py-2 px-3">
                        <div class="col-sm-8 d-flex flex-column text-dark ">
                            <strong><span>Customer Name</span></strong>
                            <p class="transaction-name"></p>
                        </div>
                        <div class="col-sm-4 d-flex flex-column text-dark ">
                            <strong><span>Total Product</span></strong>
                            <p class="transaction-prodnumber"></p>
                        </div>
                    </div>

                    <div class="mx-0" style="max-height: 400px;overflow-x: hidden;overflow-y: scroll;">
                        <div class="table-responsive">
                            <table id="" class="detail-product-table table-boderdered table">
                                <thead>
                                    <tr>
                                        <th colspan="4"> Product List</th>
                                    </tr>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Subtotal Qty</th>
                                        <th>Subtotal Price</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr class="bg-light text-dark">
                                        <th colspan="3">Total Qty</th>
                                        <th><span class="total-qty"></span></th>
                                    </tr>
                                    <tr class="bg-dark text-white">
                                        <th colspan="3">Total</th>
                                        <th><span class="total-price"></span></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

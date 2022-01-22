<div class="modal fade" id="transactionDetailModal" tabindex="-1" role="dialog"
    aria-labelledby="transactionDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="form-detail-transactions" method="">
                <div class="modal-header d-flex">
                    <h5 class="modal-title text-primary" id="transactionDetailModalLabel">
                        Transaction Detail
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-row justify-content-between bg-slate-100 rounded-xl align-items-center mx-0 py-3 px-3 mb-3">
                        <div class="d-flex flex-md-row flex-column">
                            <span class="">Transaction ID :</span>
                            <span class="transaction-id ml-sm-3 text-dark font-weight-bold"></span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-primary print-transaction">
                                <i class="fa fa-print"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-row bg-slate-100 rounded-xl align-items-center mx-0 py-3 px-3 mb-3">
                        <div class="col-sm-8 d-flex flex-column text-dark">
                            <span>Customer Name</span>
                            <p class="mb-0 pb-0 transaction-name text-dark font-weight-bold"></p>
                        </div>
                        <div class="col-sm-4 d-flex flex-column text-dark">
                            <span>Total Product</span>
                            <p class="mb-0 pb-0 transaction-prodnumber text-dark font-weight-bold"></p>
                        </div>
                    </div>
                    <div>
                        <h5 class="text-primary mb-3 border-top pt-4 pb-2"> Product List</h5>
                    </div>

                    <div class="mx-0" style="max-height: 400px;overflow-x: hidden;overflow-y: scroll;">
                        <div class="table-responsive">
                            <table id="" class="detail-product-table table-striped table-boderdered table">
                                <thead>
                                    <tr>
                                        <th width="2%">No</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Subtotal Qty</th>
                                        <th>Subtotal Price</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr class="bg-slate-500 text-white font-weight-bold">
                                        <th colspan="4">Total Qty</th>
                                        <th><span class="total-qty"></span></th>
                                    </tr>
                                    <tr class="bg-slate-600 text-white font-weight-bold">
                                        <th colspan="4">Total</th>
                                        <th><span class="total-price"></span></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light btn-sm" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

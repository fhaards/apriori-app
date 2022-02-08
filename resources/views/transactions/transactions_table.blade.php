@extends('layouts.app')

@section('content')
    @include('layouts.header-pages')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-sm-row flex-column justify-content-between align-items-center"
            id="header-transaction">
            <h6 class="m-0 font-weight-bold text-primary">Data {{ $headerpages }}</h6>
            <div class="d-flex flex-row mt-sm-0 mt-3">
                <button class="btn btn-sm btn-primary mr-2 open-filter">
                    <i class="fas fa-filter fa-sm fa-fw text-whtie"></i>
                </button>
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#transactionAddModal">
                    <i class="fas fa-plus fa-sm fa-fw mr-2 text-whtie"></i>
                    Add {{ $headerpages }}
                </button>
            </div>
        </div>
        <div class="card-body px-0 py-0">
            <div id="filter-transaction" class="d-none mt-0 border-bottom">
                <div class="d-flex flex-sm-row flex-column justify-content-end bg-slate-300 px-2 pt-3 w-100">
                    <div class="filter-range">
                        <div class="form-group d-flex flex-sm-row flex-column align-items-center">
                            <span class="mr-sm-3 my-2 my-sm-0 col-sm-5  text-gray-900"><strong>Filter Date
                                    Range</strong></span>
                            <input type="text" class="form-control pull-right" id="datesearch"
                                placeholder="Search by date range..">
                            {{-- <input type="text" name="daterange" value="01/01/2022 - 01/15/2022" /> --}}
                            {{-- <input type="date" class="filter-trans-from form-control mr-sm-2" >
                            <i class="fas fa-arrow-right fa-sm fa-fw mr-sm-2 d-sm-block d-none"></i>
                            <i class="fas fa-arrow-down fa-sm fa-fw mr-sm-2 d-sm-none my-2"></i>
                            <input type="date" class="filter-trans-to form-control"> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive px-3 mt-3 mb-3 py-4">
                <table class="table table-striped table-hover" id="table-transactions" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Transaction Id</th>
                            <th>Customer Name </th>
                            <th>Date Fake</th>
                            <th width="20%">Date Created</th>
                            <th width="5%">Qty</th>
                            <th>Total Price</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include('transactions.transactions_detail')
    @include('transactions.transactions_add')
    {{-- @include('products.products_edit') --}}
@endpush

@push('js-app')
    <script src="{{ asset('js-app/app-transaction.js') }}"></script>
@endpush

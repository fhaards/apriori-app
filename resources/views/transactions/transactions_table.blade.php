@extends('layouts.app')

@section('content')
    @include('layouts.header-pages')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data {{ $headerpages }}</h6>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#transactionAddModal">
                <i class="fas fa-plus fa-sm fa-fw mr-2 text-whtie"></i>
                Add {{ $headerpages }}
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table-transactions" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Transaction Id</th>
                            <th>Customer Name </th>
                            <th>Date </th>
                            <th width="5">Qty(Total) </th>
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
    @include('transactions.transactions_add')
    @include('transactions.transactions_detail')
    {{-- @include('products.products_edit') --}}
@endpush

@push('js-app')
    <script src="{{ asset('js-app/app-transaction.js') }}"></script>
@endpush

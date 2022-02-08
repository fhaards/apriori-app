@extends('layouts.app')

@section('content')
    @include('layouts.header-pages')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data {{ $headerpages }}</h6>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#productAddModal">
                <i class="fas fa-plus fa-sm fa-fw mr-2 text-whtie"></i>
                Add Products
            </button>
        </div>
        <div class="card-body text-sm">
            <div class="table-responsive py-4">
                <table class="table table-striped table-hover" id="table-products" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20%">Name</th>
                            <th width="20%">Type</th>
                            <th width="15%">Price</th>
                            <th width="10%">Stock</th>
                            <th>Date Fake</th>
                            <th width="15%">Date Created</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    @include('products.products_add')
    @include('products.products_edit')
@endpush

@push('js-app')
    <script src="{{ asset('js-app/app-products.js') }}"></script>
@endpush

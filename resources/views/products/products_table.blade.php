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
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="table-products" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Date Fake</th>
                            <th>Date Created</th>
                            <th></th>
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

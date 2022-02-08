@extends('layouts.app')

@section('content')
    @include('layouts.header-pages')
    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-12">
            <div class="card mb-4">
                {{-- <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Transaction Reports</h6>
                </div> --}}
                <div class="card-body text-sm">
                    <div class="table-responsive py-0">
                        <table class="table table-striped table-hover table-borderless" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th colspan="2">Transaction Reports</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="rounded-xl py-0">
                                        <div id="trans-report-day"
                                            class="form-group-row my-0 px-4 py-3 d-flex flex-sm-row align-items-center">
                                            <label class="col-md-4 col-4">Current Date / Select Date</label>
                                            <div class="col-md-6 col-6">
                                                <input type="date" name="reportByDay"
                                                    class="report-trans-cal w-100 form-control" />
                                            </div>
                                            <div class="col-md-2 d-flex align-items-center justify-content-end h-full">
                                                <button type="button" class="submit-report-day btn btn-danger">
                                                    <i class="fa fa-file-pdf"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="rounded-xl py-0">
                                        <div class="form-group-row my-0 px-4 py-3 d-flex flex-sm-row align-items-center">
                                            <label class="col-md-4 col-4">By Month</label>
                                            <div class="col-md-6 col-6">
                                                <select name="reportByMonth" class="w-100 form-control">
                                                    <option>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-center justify-content-end h-full">
                                                <button type="button" class="btn  btn-danger">
                                                    <i class="fa fa-file-pdf"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- @push('modal')
    @include('products.products_add')
    @include('products.products_edit')
@endpush --}}

@push('js-app')
    <script src="{{ asset('js-app/app-reports.js') }}"></script>
@endpush

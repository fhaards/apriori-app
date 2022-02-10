@extends('layouts.app')

@section('content')
    @include('layouts.header-pages')
    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex justify-content-center align-items-center">
                    <p class="h3">Transaction Reports</p>
                </div>
                <div class="card-body text-sm">
                    <div class="table-responsive py-0">
                        <table class="table table-striped table-hover table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td class=" py-0">
                                        <div id="trans-report-day"
                                            class="form-group-row my-0 px-4 py-3 d-flex flex-sm-row align-items-center">
                                            <label class="col-md-4 col-4">Current Date / Select Date</label>
                                            <div class="col-md-4 col-6">
                                                <input type="date" name="reportByDay"
                                                    class="report-trans-cal w-100 form-control" />
                                            </div>
                                            <div class="col-md-4 d-flex align-items-center justify-content-end h-full">
                                                <button type="button" class="submit-report-day btn btn-danger">
                                                    <i class="fa fa-file-pdf mr-2"></i> Get Reports
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-0">
                                        <div id="trans-report-month"
                                            class="form-group-row my-0 px-4 py-3 d-flex flex-sm-row align-items-center">
                                            <label class="col-md-4 col-4">By Month</label>
                                            <div class="col-md-4 col-6">
                                                <?php
                                                $months = [1 => 'Januari', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August.', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
                                                // $transposed = array_slice($months, date('n'), 12, true) + array_slice($months, 0, date('n'), true);
                                                // $last8 = array_reverse(array_slice($transposed, -8, 12, true), true);
                                                ?>
                                                <select name="reportByMonth" class="report-trans-month w-100 form-control">
                                                    <option value="">-- SELECT MONTH --</option>
                                                    <?php foreach ($months as $key => $name) : ?>
                                                    <option value="{{ $key }}">{{ $name }}</option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 d-flex align-items-center justify-content-end h-full">
                                                <button type="button" class="submit-report-month btn btn-danger">
                                                    <i class="fa fa-file-pdf mr-2"></i> Get Reports
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-0">
                                        <div id="trans-report-year"
                                            class="form-group-row my-0 px-4 py-3 d-flex flex-sm-row align-items-center">
                                            <label class="col-md-4 col-4">By Year</label>
                                            <div class="col-md-4 col-6">
                                                <?php
                                                $year = [2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030];
                                                // $transposed = array_slice($months, date('n'), 12, true) + array_slice($months, 0, date('n'), true);
                                                // $last8 = array_reverse(array_slice($transposed, -8, 12, true), true);
                                                ?>
                                                <select name="reportByYear" class="report-trans-year w-100 form-control">
                                                    <option value="">-- SELECT YEAR --</option>
                                                    <?php foreach ($year as $name) : ?>
                                                    <option value="{{ $name }}">{{ $name }}</option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 d-flex align-items-center justify-content-end h-full">
                                                <button type="button" class="submit-report-year btn btn-danger">
                                                    <i class="fa fa-file-pdf mr-2"></i> Get Reports
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

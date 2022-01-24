@extends('layouts.app')

@section('content')
    @include('layouts.header-pages')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Analyzing using Data Mining with Market Basket Analysis Methods</h6>
        </div>
        <div class="card-body text-sm">
            <a class="btn btn-sm btn-primary" href="{{route('apriori-analysis.show',4)}}"> PROCESS </a>
        </div>
    </div>
@endsection


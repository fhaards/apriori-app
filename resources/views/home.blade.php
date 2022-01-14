@extends('layouts.app')

@section('content')
    <div class="jumbotron py-3 px-3 bg-light border text-dark">
        <h1 class="display-6">Hello, {{ $user->name }}</h1>
        <hr class="my-2">
        <p>Welcome Back to {{ config('app.name', 'Laravel') }}</p>
    </div>
    @include('dashboard.dashboard_cart')
@endsection

@push('js-app')
    <!-- Page level custom scripts -->
    <script src="{{ asset('js-chart/dash-area.js') }}"></script>
    <script src="{{ asset('js-chart/dash-pie.js') }}"></script>
@endpush


{{-- <div class="card">
    <div class="card-header">{{ __('Dashboard') }}</div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        {{ __('You are logged in!') }}
    </div>
</div> --}}

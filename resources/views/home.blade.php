@extends('layouts.app')

@section('content')
    <div class="jumbotron py-sm-3 py-md-5 py-4 px-4 border text-dark rounded-xl" data-aos="fade-up" data-aos-anchor-placement="center-bottom">
        <h1 class="display-6 text-white" data-aos="fade-down" data-aos-delay="300">Hello, {{ $user->name }}</h1>
        <p class="mb-0 pb-0 text-gray-100" data-aos="fade-up" data-aos-delay="400">Welcome Back to {{ config('app.name', 'Laravel') }}</p>
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

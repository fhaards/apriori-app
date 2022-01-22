@php 
   $currentUrl    = Request::segment(1); 
//    $currentUrlCls = 'bg-slate-700 rounded-xl'; 
   $currentUrlCls = 'active'; 
@endphp

<ul class="navbar-nav bg-slate-600 sidebar sidebar-dark accordion font-weight-bold toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
        <div class="sidebar-brand-text mx-3"> {{ config('app.name', 'Laravel') }} <sup>v1</sup></div>
    </a>

    <!-- Divider -->
    {{-- <hr class="sidebar-divider my-0"> --}}

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{$currentUrl == 'home' ? $currentUrlCls : ''}}"   
        data-toggle="tooltip" data-placement="right" title="Home">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    {{-- <hr class="sidebar-divider"> --}}
    <li class="nav-item {{$currentUrl == 'products' ? $currentUrlCls : ''}}"
        data-toggle="tooltip" data-placement="right" title="Products">
        <a class="nav-link" href="{{ route('products.index')}}">
            <i class="fas fa-fw fa-box"></i>
            <span>Product</span></a>
    </li>
    {{-- <li class="nav-item {{$currentUrl == 'transactions' ? $currentUrlCls : ''}}"
        data-toggle="tooltip" data-placement="right" title="Transactions">
        <a class="nav-link" href="{{ route('transactions.index')}}">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Transaction</span></a>
    </li> --}}
    <li class="nav-item {{$currentUrl == 'transactions' ? $currentUrlCls : ''}}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Transaction</span></a>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu :</h6>
                <a class="collapse-item" href="javascript:void(0)" data-toggle="modal" data-target="#transactionAddModal"> 
                    <i class="fas fa-fd fa-plus mr-1"></i>
                    Input Data 
                </a>
                <a class="collapse-item" href="{{ route('transactions.index')}}">
                    <i class="fas fa-fd fa-table mr-1"></i>
                    Table</a>
            </div>
        </div>
    </li>
    {{-- <hr class="sidebar-divider"> --}}
    <li class="nav-item {{$currentUrl == 'apriori' ? $currentUrlCls : ''}}"
        data-toggle="tooltip" data-placement="right" title="Apriori Analytics">
        <a class="nav-link" href="{{ route('apriori.index') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Apriori Analytics</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>


{{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav> --}}

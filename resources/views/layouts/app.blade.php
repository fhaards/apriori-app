<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('assets/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/sweetalert2/sweetalert2.material-ui.min.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/daterangepicker.css') }}" media="all" rel="stylesheet" type="text/css" />
    <!-- Custom -->
    <link href="{{ asset('assets/css/custom-color.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom-style.css') }}" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper" class="">
        @guest
            @yield('content')
        @else
            @include('layouts.sidebar')
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column bg-white px-0">
                <div id="content">
                    @include('layouts.topbar')
                    <!-- Main Content -->
                    <div class="container-fluid py-0 py-5 main-contents" >
                        @yield('content')
                    </div>
                </div>
            </div>
        @endguest
    </div>

    @stack('modal')

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.js') }}"></script>
    <!-- Scripts -->
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('assets/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Carts -->
    <script src="{{ asset('assets/chart.js/Chart.min.js') }}"></script>

    <!-- Sweetalert -->
    <script src="{{ asset('assets/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        var APP_URL = {!! json_encode(url('/')) !!}
        var url = $(location).attr('href'),
            parts = url.split("/"),
            firstPart = parts[3];
        var WEB_URL = APP_URL + "/" + firstPart;
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
        });
        // $(document).ready(function() {
        //     $('#dataTable').DataTable();
        // });
    </script>
    @stack('js-app')
</body>

</html>

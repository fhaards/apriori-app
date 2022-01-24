@extends('layouts.app')

@section('content')
    @include('layouts.header-pages')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Analyzing using Data Mining with Market Basket Analysis Methods
            </h6>
        </div>
        <div class="card-body text-sm px-0 py-0">
            <div class="table-responsive px-0 mx-0">
                <table class="table table-striped table-hover" id="table-apriori" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            @foreach ($prodlist as $names)
                                <th>{{ $names->type }} </th>
                            @endforeach
                        </tr>
                        @foreach ($trans as $tr)
                            <tr>
                                @foreach ($translist as $trlist)
                                    <th>{{ $trlist->subtotal_qty }} </th>
                                @endforeach
                            </tr>
                        @endforeach
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

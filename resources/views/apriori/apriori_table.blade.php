@extends('layouts.app')

@section('content')

    @include('layouts.header-pages')
    {{-- {{ $headerpages }} --}}

    <div class="card py-0">
        <div class="card-header bg-green-700 py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-white">Analyzing using Data Mining with Market Basket Analysis Methods
            </h6>
        </div>
        <div class="card-body text-sm">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" id="table-apriori" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            @foreach ($prod as $pitem)
                                <th class="text-center">{{ $pitem->type }} </th>
                            @endforeach
                        </tr>
                        @foreach ($getArray as $key => $list)
                            @foreach ($list as $keyList => $trans)
                                <tr>
                                    @foreach ($trans as $key2 => $translist)
                                        <td class="text-center">
                                            {{ $translist }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @php $countTrans; @endphp

    <div id="apriori-results">
        @include('apriori.apriori_combine_1')
    </div>

@endsection

{{-- @push('js-app')
    <script src="{{ asset('js-app/app-apriori-comb.js') }}"></script>
@endpush --}}

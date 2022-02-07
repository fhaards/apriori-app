@extends('layouts.app')

@section('content')

    @include('layouts.header-pages')

    {{-- {{ $headerpages }} --}}
    <input type="hidden" id="get-support-1" value="{{ $ts1 }}">
    <input type="hidden" id="get-supxcon-1" value="{{ $tc1 }}">
    <input type="hidden" id="get-support-2" value="{{ $ts2 }}">
    <input type="hidden" id="get-supxcon-2" value="{{ $tc2 }}">
    <div class="mb-5">
        <p class="h5">
            Analyzing using Data Mining with Market Basket Analysis Methods
        </p>
    </div>
    <div class="card py-0">
        <div class="card-header bg-green-700 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white font-weight-bold text-uppercase text-center tracking-widest">
                Transaction Count
            </h5>
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
        @include('apriori.apriori_combine_2')
    </div>

@endsection

@push('js-app')
    <script src="{{ asset('js-app/app-apriori-comb.js') }}"></script>
@endpush

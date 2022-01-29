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
                                        <td>
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

    @foreach ($combineResults as $getkeyCr => $cr)
        @php $getkeyCr++;@endphp
        @foreach ($cr as $kcr => $crItems)
            <div class="accordion my-3" id="@php print_r($crItems); @endphp">
                <div class="card">
                    <div class="card-header bg-gray-900" type="button" id="heading{{ $getkeyCr }}" data-toggle="collapse"
                        data-target="#collapse{{ $getkeyCr }}" aria-expanded="true" aria-controls="collapseOne">
                        <h5 class="mb-0 text-white font-weight-bold">
                            Combination {{ $getkeyCr }}
                        </h5>
                    </div>

                    <div id="collapse{{ $getkeyCr }}" class="collapse show"
                        aria-labelledby="heading{{ $getkeyCr }}" data-parent="#@php print_r($crItems); @endphp">
                        <div class="card-body">
                            Some placeholder content for the first accordion panel. This panel is shown by default, thanks
                            to
                            the
                            <code>.show</code> class.
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach


@endsection

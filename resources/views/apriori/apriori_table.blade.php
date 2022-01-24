@extends('layouts.app')

@section('content')
    {{-- @include('layouts.header-pages') --}}
    {{ $data['headerpages'] }}

    <div class="card py-0">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Analyzing using Data Mining with Market Basket Analysis Methods
            </h6>
        </div>
        <div class="card-body text-sm p-0 m-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered" id="table-apriori" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            @php
                                $prod = $data['prod'];
                                $transact = $data['transact'];
                                $datalist = $data['datalist'];
                                // $arrPrd   = $data['arrPrd'];
                            @endphp
                            @foreach ($prod as $names)
                                <th>{{ $names->type }} </th>
                            @endforeach
                        </tr>

                        @foreach ($transact as $tr)
                            <tr>
                                @foreach ($prod as $ptt)
                                    @php $prodId = $ptt->id; @endphp
                                    <td>
                                        @php
                                            echo $datalist;
                                        @endphp
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

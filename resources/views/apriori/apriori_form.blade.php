@extends('layouts.app')

@section('content')
    {{-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}"><i class="fa fa-home"></i></a>
                <a href="{{ route('home') }}"><i class="fa fa-angle-right"></i></a>
            </li>
            @for ($i = 0; $i <= count(Request::segments()); $i++)
                <li class="breadcrumb-item">
                    <a href=""> {{ Request::segment($i) }} </a>
                </li>
                @if (($i < count(Request::segments())) & ($i> 0))
                    <li class="breadcrumb-item">
                        {!! '<i class="fa fa-angle-right"></i>' !!}
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="">
                            Data
                        </a>
                    </li>
            @endif

            @endfor
        </ol>
    </nav> --}}

    @include('layouts.header-pages')
    <form method="post" action="{{route('apriori-analysis.store')}}" id="form-apriori">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Analyzing using Data Mining with Market Basket Analysis Methods
                </h6>
            </div>
            <div class="card-body text-sm">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="table-apriori" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox" id="checkall-checkbox"></th>
                                <th>Combination Count</th>
                                <th>Threshold Support</th>
                                <th>Threshold Support x Confidence</th>
                            </tr>
                            <?php
                            $arrSupport = [
                                '1 Produk' => [
                                    'th' => '0.2',
                                    'thc' => '0.1',
                                ],
                                '2 Produk' => [
                                    'th' => '0.1',
                                    'thc' => '0.0',
                                ],
                                '3 Produk' => [
                                    'th' => '0.0',
                                    'thc' => '0.0',
                                ],
                                '4 Produk' => [
                                    'th' => '0.0',
                                    'thc' => '0.0',
                                ],
                            ];
                            $numb = 0;
                            ?>
                            @foreach ($arrSupport as $kArr => $gArr)
                                <?php $numb++; ?>
                                <tr>
                                    <td class="text-center">
                                        <input class="count-combination" type="checkbox" name="comb[]" value="apriori_combine_{{ $numb }}" id="count-combination">
                                    </td>
                                    <td width="40%">{{ $kArr }}</td>
                                    <td width="25%">{{ $gArr['th'] }}</td>
                                    <td width="25%">{{ $gArr['thc'] }}</td>
                                </tr>
                            @endforeach
                        </thead>
                    </table>
                </div>

            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="submit" class="submit-form-apriori btn btn-primary"> <i class="fas fa-save mr-2"></i> PROCESS</button>
                {{-- <a class="btn btn-primary" href="{{ route('apriori-analysis.show', 4) }}">
                <i class="fas fa-save mr-2"></i> PROCESS
            </a> --}}
            </div>
        </div>
    </form>
@endsection

@push('js-app')
    <script src="{{ asset('js-app/app-apriori.js') }}"></script>
@endpush

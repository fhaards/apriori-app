<div class="accordion my-3" id="combine-1">
    <div class="card">
        <div class="card-header bg-gray-900" type="button" id="heading-1" data-toggle="collapse"
            data-target="#collapse-1" aria-expanded="true" aria-controls="collapseOne">
            <h5 class="mb-0 text-white font-weight-bold">
                1 Product Combination
            </h5>
        </div>

        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#combine-1">
            <div class="card-body">
                <div class="mt-3">
                    <p>
                        Threshold Support = {{ $ts1 }} <br>
                        Threshold Support x Confidence = {{ $tc1 }}
                    </p>
                </div>
                <div class="table-responsive">
                    <table id="comb-1-proccess" class="mx-0 mb-0 py-0 table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Support </th>
                                <th class="text-center">Confidence </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($combineFirst as $proccess1)
                                @php
                                    $countPrd = (float) $proccess1->count;
                                    $gsupport = $countPrd / $countTrans;
                                    $gconfide = $countPrd / $countPrd;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            {{ $proccess1->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            Support = {{ $countPrd }} / {{ $countTrans }} = {{ number_format((float)$gsupport, 2, '.', '') }} 
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            Confidence = {{ $countPrd }} / {{ $countPrd }} = {{ $gconfide }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center w-100 py-3 my-3">
                    <div class="my-0 py-0 h3"> COMBINATION RULES </div>
                </div>
                <div class="table-responsive">
                    <table id="comb-1-rules" class="mx-0 table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Rules</th>
                                <th class="text-center">Support</th>
                                <th class="text-center">Confidence</th>
                                <th class="text-center">Support x Confidence</th>
                                <th class="text-center">Threshold Support</th>
                                <th class="text-center">Threshold Confidence</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($combineFirst as $rules1)
                                @php
                                    $prodname = $rules1->name;
                                    $countPrd = (float) $rules1->count;
                                    $gsupport = (float) $countPrd / $countTrans;
                                    $gconfide = (float) $countPrd / $countPrd;
                                    $supxconf = (float) $gsupport * $gconfide;
                                    if ($gsupport > $ts1) :
                                        $tsup = "YES";
                                    else :
                                        $tsup = "NO";
                                    endif;
                                    
                                    if ($gconfide > $tc1) :
                                        $tconf = "YES";
                                    else :
                                        $tconf = "NO";
                                    endif;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            If buy {{ $prodname }} Then buy {{ $prodname }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">{{ number_format((float)$gsupport, 2, '.', '') }} </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center"> {{ $gconfide }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">{{ number_format((float)$supxconf, 2, '.', '') }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center"> {{ $tsup }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center"> {{ $tconf }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="accordion my-3" id="combine-1">
    <div class="card">
        <div class="card-header bg-gray-900" type="button" id="heading-1" data-toggle="collapse"
            data-target="#collapse-1" aria-expanded="true" aria-controls="collapseOne">
            <h5 class="mb-0 text-white font-weight-bold">
                1 Product Combination
            </h5>
        </div>

        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#combine-1">
            <div class="card-body">
                <div class="mt-3">
                    <p>
                        Threshold Support = 0.2 <br>
                        Threshold Support x Confidence = 0.1
                    </p>
                </div>
                <div class="table-responsive">
                    <table id="comb-1-proccess"
                        class="mx-0 mb-0 py-0 table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Support </th>
                                <th class="text-center">Confidence </th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="text-center w-100 py-0 my-0">
                    <div class="my-0 py-0 h3"> COMBINATION RULES </div>
                </div>
                <div class="table-responsive">
                    <table id="comb-1-rules" class="mx-0 table table-striped table-bordered"
                        width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">Rules</th>
                                <th class="text-center">Support</th>
                                <th class="text-center">Confidence</th>
                                <th class="text-center">Support x Confidence</th>
                                <th class="text-center">Threshold Support</th>
                                <th class="text-center">Threshold Confidence</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}

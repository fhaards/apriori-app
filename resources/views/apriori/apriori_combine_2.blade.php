<div class="accordion my-3" id="combine-2">
    <div class="card">
        <div class="card-header bg-slate-500" type="button" id="heading-2" data-toggle="collapse"
            data-target="#collapse-2" aria-expanded="true" aria-controls="collapseTwo">
            <h5 class="mb-0 text-white font-weight-bold text-uppercase text-center tracking-widest">
                Second Combination
            </h5>
        </div>

        <div id="collapse-2" class="collapse hidden" aria-labelledby="heading-2" data-parent="#combine-2">
            <div class="card-body">
                <div class="mt-3">
                    <p>
                        Threshold Support = {{ $ts2 }} <br>
                        Threshold Support x Confidence = {{ $tc2 }}
                    </p>
                </div>
                <div class="table-responsive py-0 my-0">
                    <table id="comb-2-proccess" class="mx-0 mb-0 py-0 table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th class="bg-slate-100 text-gray-800" colspan="3">
                                    <p class="text-center my-0 py-0 h5 tracking-widest font-weight-bold"> COMBINATION 2 RANK </p>
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center w-30">Product Name</th>
                                <th class="text-center">Support </th>
                                <th class="text-center">Confidence </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="table-responsive py-0 my-0">
                    <table id="comb-2-rules" class="mx-0 my-0 table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th class="bg-slate-100 text-gray-800" colspan="6">
                                    <p class="text-center my-0 py-0 h5 tracking-widest font-weight-bold"> COMBINATION 2 RULES </p>
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center w-30">Rules</th>
                                <th class="text-center w-10">Support</th>
                                <th class="text-center w-10">Confidence</th>
                                <th class="text-center w-10">Support x Confidence</th>
                                <th class="text-center w-10">Threshold Support</th>
                                <th class="text-center w-10">Threshold Confidence</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

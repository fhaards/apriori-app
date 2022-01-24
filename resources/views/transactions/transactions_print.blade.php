<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $headerpages }}</title>
</head>
<style>
    header {
        position: relative;
        display: flex;
        flex-direction: row-reverse;
        width: 100%;
        height: 50px;
        font-family: Arial, Helvetica, sans-serif;
    }

    header .c1 {
        float: left;
        width: 60%;
        height: 100%;
    }

    header .c2 {
        float: right;
        width: 40%;
        height: 100%;
    }

    header .c2 span {
        float: right;
        font-size: 40px;
        color: #0f172a;
        letter-spacing: 10px;
        font-weight: 500;
    }

    main {
        margin-top: 20px;
        position: relative;
        font-family: Arial, Helvetica, sans-serif;
    }

    main .trans-info {
        width: 100%;
    }

    main .trans-info .right .c1,
    main .trans-info .right .c2,
    main .trans-info .right .c3 {
        text-align: left;
    }

    main table {
        font-size: 12px;
        margin-top: 80px;
    }

    main table tr td {
        padding: 10px;
    }

    main table h4 {
        font-size: 15px;
        color: #1F2937;
        padding: 0px 0px;
        margin: 6px 0px;
    }

    main table tr td strong {
        color: #374151;
    }

    main table tr td {
        color: #111827;
    }

    /* PAYMENT TABLE */

    .payment-table {
        border-collapse: collapse;
        border: 1px solid #9CA3AF;
    }

    .payment-table tr th {
        background-color: #374151;
        padding: 10px;
        border: 1px solid #9CA3AF;
        color: #F9FAFB;
    }

    .payment-table tr td {
        border: 1px solid #9CA3AF;
        padding-left: 20px;
    }


    .payment-table .data {
        background-color: #F9FAFB;
    }

    .payment-table .total {
        background: #34D399;
    }

    .payment-table tfoot .total-1 {
        background-color: #64748b;
    }

    .payment-table tfoot .total-2 {
        background-color: #475569;
    }

    .payment-table tfoot tr td {
        color: #fff;
    }


    /* TRANS TABLE */

    .trans-table {
        padding: 0px;
        margin: 5rem 0 0 0;
    }

    .trans-table tr td .title {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
        width: 80%;
        padding: 5px 0px;
        text-transform: uppercase;
        letter-spacing: 0.1rem;
    }

    .trans-table tr td span {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
    }

    .trans-table tr td p {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 15px;
        letter-spacing: 0.05rem;
    }

    .comp-table {
        font-family: Arial, Helvetica, sans-serif;
        margin-top: 100px;
        font-size: 10px;
        text-align: justify;
    }

    .comp-table tr td {
        text-align: left;
        align-items: flex-start;
        justify-content: start;
        color: #1F2937;
    }

    .comp-table tr td div {
        margin-top: 20px;
    }

    .hr1 {
        color: #64748b;
        border: 1px solid #64748b;
    }

    .hr2 {
        color: #A7F3D0;
        border: 1px solid #A7F3D0;
    }

    .hr3 {
        color: #6EE7B7;
        border: 1px solid #6EE7B7;
    }

</style>

<body>

    <header>
        {{-- <div class="c1">
                <img src="{{ public_path('img/app-img/logo.png') }}" height="40px">
            </div> --}}
        <div class="c2">
            <span>INVOICE</span>
        </div>
    </header>
    <main>
        {{-- <hr class="hr1"> --}}
        <table width="100%" class="trans-table">
            <tr>
                <td width="25%">
                    <strong><span class="title">Invoice No.</span></strong>
                    <br>
                    <p>{{ $transaction->transaction_id }} </p>
                </td>
            </tr>
            <tr>
                <td>
                    <strong><span class="title">Customer Name</span></strong>
                    <br>
                    <p>{{ $transaction->customer_name }} </p>
                </td>
            </tr>
            <tr>
                <td>
                    <strong><span class="title">Date</span></strong>
                    <br>
                    <p>{{ date('d/m/Y', strtotime($transaction->created_at)) }} </p>
                </td>
            </tr>
        </table>


        <table class="payment-table" width="100%" border="1">
            <thead>
                <tr>
                    <th width="40%">Items</th>
                    <th width="40%">Type</th>
                    <th width="20%">Qty</th>
                    <th width="40%">Price / pcs</th>
                    <th width="40%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction_list as $item)
                    <tr class="data">
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->type }}</td>
                        <td style="text-align:center;">{{ $item->subtotal_qty }} pcs</td>
                        <td style="text-align:right;"> Rp {{ number_format($item->price) }}</td>
                        <td style="text-align:right;"> Rp {{ number_format($item->subtotal_price) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-1">
                    <td colspan="4">Total Qty</td>
                    <td colspan="1" style="text-align:right;">
                        {{ number_format($transaction->total_qty) }} pcs
                    </td>
                </tr>
                <tr class="total-2">
                    <td colspan="4">Total</td>
                    <td colspan="1" style="text-align:right;">
                        Rp {{ number_format($transaction->total_price) }}
                    </td>
                </tr>

            </tfoot>
        </table>


    </main>


    {{-- <table width="100%" class="comp-table">
        <tbody>
            <tr>
                <td width="30%">
                    <img src="{{ public_path('img/app-img/logo.png') }}" height="40px"> <br>
                    {{ $comp->comp_name }}<br>
                    <div class="">
                        <strong> Phone </strong> <br>
                        {{ $comp->comp_phone }}
                    </div>
                    <div class="">
                        <strong> Email </strong> <br>
                        {{ $comp->comp_email }}
                    </div>
                    <div class="">
                        <strong> Address </strong>
                        <br>
                        {{ $comp->comp_address }}
                    </div>
                </td>
                <td width="30%">

                </td>
                <td width="30%">
                </td>
            </tr>
        </tbody>
    </table> --}}
</body>

</html>

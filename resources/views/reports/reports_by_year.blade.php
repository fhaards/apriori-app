<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>
</head>
<style>
    @page {
        margin: 70px 2cm 50px 2cm;
    }

    header {
        position: fixed;
        top: -60px;
        left: 0px;
        right: 0px;
        height: 50px;
        font-size: 10px;

    }

    main {
        font-size: 9px;
    }

    .title {
        text-transform: uppercase;
        font-size: 17px;
        text-align: right;
    }

    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
    }

    table {
        width: 100%;
    }

    .table_data {
        margin-top: 12px;
    }

    .table_data_content {
        border-collapse: collapse;
    }

    .table_data_content th,
    .table_data_content td {
        border: 1px solid #9e9e9e;
        font-size: 10px;
    }

    .table_data_content tbody tr .tdTitle {
        background: #ebf1de;
    }

    .table_data_content tbody .tdLoop {
        padding: 5px;
        /* border-bottom:1px solid #9e9e9e; */
    }

    .table_data_content tfoot .total {
        font-size: 12px;
    }

    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgb(241, 245, 249);
    }

    .table-striped tfoot tr:nth-of-type(odd) {
        /* background-color: rgba(0, 0, 0, 0.05); */
        background-color: #cbd5e1;
    }

    .table-striped tfoot tr:nth-of-type(even) {
        /* background-color: rgba(0, 0, 0, 0.05); */
        background-color: rgb(241, 245, 249);
    }

    table tr th {
        padding: 5px
    }

    table tr td {
        padding: 4px;
    }

    table tr .text-center {
        text-align: center
    }

    table tr .w-5 {
        width: 5%;
    }

    input[type="checkbox"] {
        display: none;
    }

    input[type="checkbox"]:checked {
        display: block;
    }

    .check {
        width: 20px;
        height: 20px;
    }

    .check::after {
        content: "c";
        background-color: #39cccc;
        background-size: cover;
        clip-path: polygon(0% 100%, 100% 100%, 0% 0%);
    }

    .d-none {
        display: none;
    }

    .page_break {
        page-break-before: always;
    }

</style>

<body>
    @php $setNumber = 0; @endphp
    <header>

    </header>

    <main>
        <table width="100%" class="table_header">
            <tr>
                <td>
                    <img src="{{ public_path('app-img/logo-dalasta.png') }}" height="50px">
                </td>
                <td>
                    <div class="title">
                        TRANSACTION REPORTS<br>
                        BY : {{ $date }} <br>
                    </div>
                </td>
            </tr>
        </table>
        <div class="table_data">
            <table class="table_data_content table-striped" style="margin-top:20px;" width="100%">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>ID</th>
                        <th>SUBTOTAL QTY</th>
                        <th>SUBTOTAL PRICE</th>
                    </tr>
                </thead>
                <tbody>
                    {{ $no = 0 }}
                    @foreach ($data as $item)
                        {{ $no++ }}
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $item->transaction_id }}</td>
                            <td class="text-center">{{ $item->total_qty }}  </td>
                            <td class="text-center">{{ 'Rp ' . number_format($item->total_price, 0) }} </td>
                        </tr>
                    @endforeach
                </tbody>
                <tr>
                    <td colspan="4"></td>
                </tr>
                <tfoot>

                    <tr class="total">
                        <td colspan="2"></td>
                        <td>Total QTY</td>
                        <td class="text-center">{{ $transact->totqty }}</td>
                    </tr>
                    <tr class="total">
                        <td colspan="2"></td>
                        <td>Total</td>
                        <td class="text-center">{{ 'Rp ' . number_format($transact->totprice, 0) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </main>
</body>

</html>

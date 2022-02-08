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
    }

    .table_data_content tbody tr .tdTitle {
        background: #ebf1de;
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

    .hasil_pemeriksaan {
        text-align: center;
    }

    .keterangan .keterangan-content {
        height: 50px;
        padding: 5px;
    }

    .other .ket {
        padding: 15px 0 0 0;
        vertical-align: top;
    }

    .other .ttd {
        margin-top: 15px;
        text-align: center;
        vertical-align: top;
    }

    .other .ttd .ttd-head {
        height: 15px;
        margin-top: 10px;
    }

    .other .ttd .ttd-name {
        padding-left: 20px;
        padding-right: 20px;
    }

    .other .ttd .ttd-name .ttd-nip {
        padding-bottom: 20px;
        padding-top: 5px;
        height: 15px;
    }

    .other .ttd .ttd-name .ttd-names {
        border-bottom: 0.5px solid #000;
        height: 15px;
    }

    .other .ttd .ttd-img {
        width: 150px;
        height: 100px;
        margin: 0 auto;
        object-fit: cover;
    }

    .other .ttd .ttd-img img {
        width: 100%;
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
        <table width="100%">
            <tr>
                <th class="">
                    {{-- <img src="{{ public_path('images/apps_img/png/logo_kemenhub.png') }}" width="40px"> --}}
                </th>
                <th>
                    <div class="title">
                        TRANSACTION REPORT<br>
                        DATE : <br>
                    </div>
                </th>
                <th class="">
                    {{-- <img src="{{ public_path('images/apps_img/png/logo_bpp.png') }}" width="40px"> --}}
                </th>
            </tr>
        </table>
    </header>

    <main>
        <div class="table_data">
            <table class="table_data_content" style="margin-top:20px;" border="1" width="100%">

            </table>
        </div>
    </main>
</body>

</html>

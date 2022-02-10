// COMBINATION 2
var getSupport3 = $("#get-support-3").val();
var getSupxCon3 = $("#get-supxcon-3").val();

var combine3Process = $("#comb-3-proccess").DataTable({
    processing: true,
    serverside: true,
    ajax: {
        url: WEB_URL + "/combine3/proccess",
        type: "GET",
    },
    columns: [
        { data: "name", name: "name" },
        { data: "support", name: "support" },
        { data: "confidence", name: "confidence" },
    ],
    columnDefs: [
        {
            targets: [0, 1, 2],
            render: function (data, type, row, meta) {
                return (
                    '<div class="d-flex justify-content-center">' +
                    data +
                    "</div>"
                );
            },
        },
    ],
    ordering: false,
    searching: false,
    bLengthChange: false,
    bInfo: false,
    paging: false,
});

if (getSupport2.length > 1) {
    loadCombine3Rules(getSupport3, getSupxCon3);
}


function loadCombine3Rules(getsup3, getsupxconf3) {
    var combine3Rules = $("#comb-3-rules").DataTable({
        processing: true,
        serverside: true,
        ajax: {
            url: WEB_URL + "/combine3/rules",
            type: "GET",
            data: { setSup3: getsup3, setSupxConf3: getsupxconf3 },
        },
        columns: [
            { data: "rules", name: "rules" },
            { data: "support", name: "support" },
            { data: "confidence", name: "confidence" },
            { data: "supxconf", name: "supxconf" },
            { data: "tsup", name: "tsup" },
            { data: "tconf", name: "tconf" },
        ],
        columnDefs: [
            {
                orderable: false,
                targets: [0, 1, 2, 3, 4, 5],
                render: function (data, type, row, meta) {
                    return (
                        '<div class="d-flex justify-content-center">' +
                        data +
                        "</div>"
                    );
                },
            },
        ],
        order: [[1, "desc"]],
        searching: false,
        bLengthChange: false,
        bInfo: false,
        paging: false,
    });
}
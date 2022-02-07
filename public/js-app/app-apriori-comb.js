// COMBINATION 2
var getSupport2 = $("#get-support-2").val();
var getSupxCon2 = $("#get-supxcon-2").val();

var combine1Process = $("#comb-2-proccess").DataTable({
    processing: true,
    serverside: true,
    ajax: {
        url: WEB_URL + "/combine2/proccess",
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
    loadCombine2Rules(getSupport2, getSupxCon2);
}

function loadCombine2Rules(getsup2, getsupxconf2) {
    var combine2Rules = $("#comb-2-rules").DataTable({
        processing: true,
        serverside: true,
        ajax: {
            url: WEB_URL + "/combine2/rules",
            type: "GET",
            data: { setSup2: getsup2, setSupxConf2: getsupxconf2 },
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
        // bSort: false,
        // ordering: false,
        searching: false,
        bLengthChange: false,
        bInfo: false,
        paging: false,
        // aaSorting: [1],
        // order: [1, "desc"],
    });
    // combine1Rules.order.fixed({pre: [1, "desc"],});
    // combine2Rules.order([1, "desc"]).draw();
    // return combine1Rules;
}

// var combine1Process = $("#comb-1-proccess").DataTable({
//     processing: true,
//     serverside: true,
//     ajax: {
//         url: WEB_URL + "/combine1/proccess",
//         type: "GET",
//     },
//     columns: [
//         { data: "name", name: "name" },
//         { data: "support", name: "support" },
//         { data: "confidence", name: "confidence" },
//     ],
//     ordering: false,
//     searching: false,
//     bLengthChange: false,
//     bInfo: false,
//     paging: false,
// });

// var combine1Rules = $("#comb-1-rules").DataTable({
//     processing: true,
//     serverside: true,
//     ajax: {
//         url: WEB_URL + "/combine1/rules",
//         type: "GET",
//     },
//     columns: [
//         { data: "rules", name: "rules" },
//         { data: "support", name: "support" },
//         { data: "confidence", name: "confidence" },
//         { data: "supxconf", name: "supxconf" },
//         { data: "tsup", name: "tsup" },
//         { data: "tconf", name: "tconf" },
//     ],
//     ordering: false,
//     searching: false,
//     bLengthChange: false,
//     bInfo: false,
//     paging: false,
// });

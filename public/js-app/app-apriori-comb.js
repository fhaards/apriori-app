var combine1Process = $("#comb-1-proccess").DataTable({
    processing: true,
    serverside: true,
    ajax: {
        url: WEB_URL + "/combine1/proccess",
        type: "GET",
    },
    columns: [
        { data: "name", name: "name" },
        { data: "support", name: "support" },
        { data: "confidence", name: "confidence" },
    ],
    ordering: false,
    searching: false,
    bLengthChange: false,
    bInfo: false,
    paging: false,
});

var combine1Rules = $("#comb-1-rules").DataTable({
    processing: true,
    serverside: true,
    ajax: {
        url: WEB_URL + "/combine1/rules",
        type: "GET",
    },
    columns: [
        { data: "rules", name: "rules" },
        { data: "support", name: "support" },
        { data: "confidence", name: "confidence" },
        { data: "supxconf", name: "supxconf" },
        { data: "tsup", name: "tsup" },
        { data: "tconf", name: "tconf" },
    ],
    ordering: false,
    searching: false,
    bLengthChange: false,
    bInfo: false,
    paging: false,
});

var thisTablesUses = $("#table-products").DataTable({
    processing: true,
    serverside: true,
    ajax: {
        url: WEB_URL + "/data/all",
        type: "GET",
    },
    columns: [
        { data: "name", name: "name" },
        { data: "type", name: "type" },
        { data: "price", name: "price" },
        { data: "stock", name: "stock" },
        { data: "created", name: "created" },
        { data: "created_str", name: "created_str" },
        { data: " ", name: " " },
    ],
    columnDefs: [
        {
            targets : 4,
            visible : false
        },
        {
            targets : 5,
            render: function (data, type, row, meta) {
                return (
                    '<span class="d-none">'+row.created+'</span>'+
                    '<span class="">'+row.created_str+'</span>'
                );
            },
        },
        {
            targets: 6,
            orderable: false,
            render: function (data, type, row, meta) {
                return (
                '<div class="dropdown no-arrow text-right">'+
                    '<button class="btn btn-sm bg-slate-600 rounded-lg dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                        '<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-100"></i>'+
                    '</button>'+
                    '<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">'+
                        '<a type="button" class="dropdown-item text-success add-stock"' + '" product-id="' + row.id + '"/><i class="fas fa-plus fa-xs mr-1"></i> Change Stock</a>'+
                        '<a type="button" class="dropdown-item text-warning edit"' + '" product-id="' + row.id + '" value="Edit"/><i class="fas fa-pencil-alt fa-xs mr-1"></i> Edit </a>'+
                        '<div class="dropdown-divider"></div>'+
                        '<a type="button" class="dropdown-item text-danger delete"' + '" product-name="'+row.name+' ('+row.type+')'+'" product-id="' + row.id + '" value="Edit"/><i class="fas fa-trash fa-xs mr-1"></i> Delete </a>'+
                    '</div>'+
                '</div>'
                );
                // return (
                //     '<div class="d-flex justify-content-around">' +
                //     '<button class="btn btn-success btn-sm add-stock"' + '" product-id="' + row.id + '"/><i class="fas fa-plus fa-sm fa-fw"></i></button>' + 
                //     '<button class="btn btn-warning btn-sm edit"' + '" product-id="' + row.id + '" value="Edit"/><i class="fas fa-pencil-alt fa-sm fa-fw"></i></button>' + 
                //     '<button class="btn btn-danger btn-sm delete"' + '" product-id="' + row.id + '"/><i class="fas fa-trash fa-sm fa-fw"></i></button>' +
                //     '</div>'
                // );
            },
        },
    ],
    order: [[4, "desc"]],
    pageLength: 5,
});

//PRODUCT ADD

$("#productAddModal .form-add-product").on("submit", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: WEB_URL,
        data: formData,
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            var succMessages = response.message;
            console.log(response.data);
            if (response.status == 200) {
                swal.fire({
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 1000,
                    didOpen: () => {
                        swal.showLoading();
                    },
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        swal.fire({
                            icon: "success",
                            title: "Success",
                            text: succMessages,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 1000,
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                $("#table-products").DataTable().ajax.reload();
                                $("#productAddModal .form-add-product").trigger(
                                    "reset"
                                );
                                $("#productAddModal").modal("hide");
                            }
                        });
                    }
                });
            } else {
                alert(response.message);
            }
        },
        error: function (response) {
            console.log(response.message);
        },
    });
});

//PRODUCT ADD STOCK

$("#table-products tbody").on("click", ".add-stock", function () {
    var productAddStock = $(this).attr("product-id");
    console.log(productAddStock);
    Swal.fire({
        html: `<div class="d-flex flex-column align-items-center w-100 p-2">
                    <label>+ Change Stock Number Value</label>
                    <input id="stock-count" type="number" class="border-top py-2 swal2-input form-control w-100">
               </div>`,
        confirmButtonText: "Submit",
        confirmButtonColor: "#4E73DF",
        focusConfirm: false,
        preConfirm: () => {
            const stockadd = Swal.getPopup().querySelector("#stock-count").value;
            if (!stockadd) {
                Swal.showValidationMessage(`Please Input a New Stock`);
            }
            return {
                stockadd: stockadd,
            };
        },
    }).then((result) => {
        var stockVal = result.value.stockadd;
        $.ajax({
            type: "POST",
            url: WEB_URL  + "/" + productAddStock + "/add-stock",
            dataType: "JSON",
            data: {
                stockVal : stockVal,
            },
            success: function (response) {
                var succMessages = response.message;
                if (response.status == 200) {
                    return swal
                        .fire({
                            icon: "success",
                            text: succMessages,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 2000,
                        })
                        .then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                $("#table-products")
                                .DataTable()
                                .ajax.reload();
                            }
                        });
                } else {
                    swal.fire("Something Wrong", "", "error");
                }
            },
            error: function (response) {
                console.log(response.status);
            },
        });
    });
});

//PRODUCT DETAIL & EDIT

$("#table-products tbody").on("click", ".edit", function (e) {
    e.preventDefault();
    var productEditId = $(this).attr("product-id");
    $("#productEditModal").modal("show");
    $.ajax({
        type: "GET",
        url: WEB_URL + "/" + productEditId + "/edit",
        dataType: "JSON",
        success: function (response) {
            var action = WEB_URL + "/" + productEditId;
            $("#productEditModal .form-edit-product").attr("action",action);
            $("#productEditModal .product-name").val(response.data[0].name);
            $("#productEditModal .product-type").val(response.data[0].type);
            $("#productEditModal .product-price").val(response.data[0].price);
        },
        error: function (response) {
            console.log(response.message);
        },
    });
});


//PRODUCT DELETE

$("#table-products tbody").on("click", ".delete", function (e) {
    e.preventDefault();
    var productDeleteId = $(this).attr("product-id");
    var productDeleteNm = $(this).attr("product-name");
    Swal.fire({
        title: "Are you sure?",
        text: "Delete : "+productDeleteNm+ " , You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#333",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: WEB_URL + "/" + productDeleteId,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    var succMessages = response.message;
                    if (response.status == 200) {
                        swal.fire({
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 1000,
                            didOpen: () => {
                                swal.showLoading();
                            },
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                swal.fire({
                                    icon: "success",
                                    title: "Deleted!",
                                    text: succMessages,
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    timer: 1000,
                                }).then((result) => {
                                    if (
                                        result.dismiss ===
                                        Swal.DismissReason.timer
                                    ) {
                                        $("#table-products")
                                            .DataTable()
                                            .ajax.reload();
                                    }
                                });
                            }
                        });
                    } else {
                        alert(response.message);
                    }
                },
                error: function (response) {
                    console.log(response.message);
                },
            });
        }
    });
});


// $("#productEditModal .form-edit-product").on("submit", function(e){
//     e.preventDefault();
//     var productName  = $("#productEditModal .product-name").val();
//     var productBrand = $("#productEditModal .product-type").val();
//     var productPrice = $("#productEditModal .product-price").val();
//     $.ajax({
//         type: "POST",
//         url: WEB_URL,
//         data: {
//             _method : 'PUT',
//             name  : productName,
//             type : productBrand,
//             price : productPrice,
//         },
//         dataType: "JSON",
//         success: function (response) {
//             var succMessages = response.message;
//             console.log(response.data);
//             if (response.status == 200) {
//                 swal.fire({
//                     allowEscapeKey: false,
//                     allowOutsideClick: false,
//                     timer: 1000,
//                     didOpen: () => {
//                         swal.showLoading();
//                     },
//                 }).then((result) => {
//                     if (result.dismiss === Swal.DismissReason.timer) {
//                         swal.fire({
//                             icon: "success",
//                             title: "Success",
//                             text: succMessages,
//                             showConfirmButton: false,
//                             allowOutsideClick: false,
//                             timer: 1000,
//                         }).then((result) => {
//                             if (result.dismiss === Swal.DismissReason.timer) {
//                                 $("#table-products").DataTable().ajax.reload();
//                                 $("#productEditModal").modal("hide");
//                             }
//                         });
//                     }
//                 });
//             } else {
//                 alert(response.message);
//             }
//         },
//         error: function (response) {
//             console.log(response.message);
//         },
//     });
// });
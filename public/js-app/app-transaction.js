loadProducts();
var start_date;
var end_date;
var DateFilterFunction = function (oSettings, aData, iDataIndex) {
  var dateStart = parseDateValue(start_date);
  var dateEnd = parseDateValue(end_date);
  //Kolom tanggal yang akan kita gunakan berada dalam urutan 2, karena dihitung mulai dari 0
  //nama depan = 0
  //nama belakang = 1
  //tanggal terdaftar =2
  var evalDate = parseDateValue(aData[2]);
  if (
    (isNaN(dateStart) && isNaN(dateEnd)) ||
    (isNaN(dateStart) && evalDate <= dateEnd) ||
    (dateStart <= evalDate && isNaN(dateEnd)) ||
    (dateStart <= evalDate && evalDate <= dateEnd)
  ) {
    return true;
  }
  return false;
};

// fungsi untuk converting format tanggal dd/mm/yyyy menjadi format tanggal javascript menggunakan zona aktubrowser
function parseDateValue(rawDate) {
    var dateArray = rawDate.split("/");
    var parsedDate = new Date(
      dateArray[2],
      parseInt(dateArray[1]) - 1,
      dateArray[0]
    ); // -1 because months are from 0 to 11
    return parsedDate;
}

var openFilterBtn  = $("#header-transaction").find(".open-filter");
var openFilterMenu = $("#filter-transaction");
openFilterBtn.on("click",function (e) {
    e.preventDefault();
    openFilterMenu.toggleClass("d-none");
});

var $thisTablesUses = $("#table-transactions").DataTable({
    processing: true,
    serverside: true,
    ajax: {
        url: WEB_URL + "/data/all",
        type: "GET",
    },
    columns: [     
        { data: "transaction_id", name: "transaction_id" },
        { data: "customer_name", name: "customer_name" },
        { data: "created", name: "created" },
        { data: "created_str", name: "created_str" },
        { data: "total_qty", name: "total_qty" },
        { data: "total_price", name: "total_price" },
        { data: " ", name: " " },
    ],
    columnDefs: [
        {
            targets : [2],
            visible : false
        },
        {
            targets: 6,
            render: function (data, type, row, meta) {
                return (
                    '<div class="dropdown no-arrow text-right">'+
                        '<button class="btn btn-sm btn-light rounded-full dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                            '<i class="fas fa-caret-down fa-sm fa-fw text-gray-800"></i>'+
                        '</button>'+
                        '<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">'+
                            '<a type="button" href="javascript:void(0)" class="dropdown-item text-info detail"' + '" transaction-id="' + row.transaction_id + '"/><i class="fas fa-eye fa-xs mr-1"></i> Detail</a>'+
                            '<div class="dropdown-divider"></div>'+
                            '<a type="button" href="javascript:void(0)" class="dropdown-item text-danger delete"' + '" transaction-id="' + row.transaction_id + '" value="Edit"/><i class="fas fa-trash fa-xs mr-1"></i> Delete </a>'+
                        '</div>'+
                    '</div>'
                    );
                // return (
                    // '<div class="d-flex justify-content-around">' +
                    // '<button class="btn btn-info btn-sm detail"' + '" transaction-id="' + row.transaction_id + '"/><i class="fas fa-eye fa-sm fa-fw"></i></button>' +
                    // '<button class="btn btn-danger btn-sm delete"' + '" transaction-id="' + row.transaction_id + '"/><i class="fas fa-trash fa-sm fa-fw"></i></button>' +
                    // '<button class="btn btn-warning btn-sm edit"' + '" transaction-id="' + row.transaction_id + '"/><i class="fas fa-pencil-alt fa-sm fa-fw"></i></button>' +
                    // '</div>'
                // );
            },
        },
    ],
    order: [[0, "desc"]],
    pageLength: 10,
});

var filterTransFrom = openFilterMenu.find(".filter-trans-from");
filterTransFrom.on("change", function(e) {
    e.preventDefault()
    var filterFrom = $(this).val().toString();
});

$("#datesearch").daterangepicker({
    autoUpdateInput: false,
  });

$("#datesearch").on("apply.daterangepicker", function (ev, picker) {
    $(this).val(picker.startDate.format("DD/MM/YYYY") + " - " + picker.endDate.format("DD/MM/YYYY"));
    start_date = picker.startDate.format("DD/MM/YYYY");
    end_date = picker.endDate.format("DD/MM/YYYY");
    console.log(start_date+end_date);
    $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
    $thisTablesUses.draw();
});

$("#datesearch").on("cancel.daterangepicker", function (ev, picker) {
    $(this).val("");
    start_date = "";
    end_date = "";
    $.fn.dataTable.ext.search.splice(
      $.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1)
    );
    $thisTablesUses.draw();
});

// LOAD PRODUCTS

function loadProducts(getCountProduct){
    var selectProduct     = $("#select-product");
    var setHtmlSelProduct = "";
  
    // Looping for product
    for (let i = 0; i < getCountProduct; i++) {
        setHtmlSelProduct += '<div class="form-row">';
        setHtmlSelProduct += '<div class="form-group col-9 col-sm-8">';
        setHtmlSelProduct += '<label for="productId">Product</label>';
        setHtmlSelProduct += '<select name="product_id_'+ i +'" class="form-control pick-product">';
        setHtmlSelProduct += '</select>';
        setHtmlSelProduct += '</div>';
        setHtmlSelProduct += '<div class="form-group col-3 col-sm-4">';
        setHtmlSelProduct += '<label for="subQty">Qty</label>';
        setHtmlSelProduct += '<input name="qty_product_'+ i +'" class="form-control stockready'+i+'" type="number">';
        setHtmlSelProduct += '</div>';
        setHtmlSelProduct += '</div>';
    }
    selectProduct.html(setHtmlSelProduct);

    // Looping for product list
    $.ajax({
        type: "GET",
        url: APP_URL + "/products/data/all",
        dataType: "JSON",
        success: function (response) {
            for (let x = 0; x < response.recordsTotal; x++) { 
                var stockready = response.data[x].stock;
                $("#select-product .pick-product").append('<option data-stock="'+stockready+'" value="'+response.data[x].product_id+'">'+response.data[x].name+' | '+response.data[x].price+ ' | Stock : '+response.data[x].stock +'</option>');
                

                // $("#select-product .stockready").attr("max",stockready);
                // $("#select-product .pick-product").on("change",function(b) {
                //     b.preventDefault();
                //     var getvalueProduct = $("#select-product .pick-product").val();
                //     console.log(getvalueProduct);
                // });
            }
         
      
        }
    });

    // for (let d = 0; d < getCountProduct; d++) {
    //     $("#select-product .pick-product").change(function() {
    //         var selectedItem = $(this).val();
    //         var abc = $('option:selected',this).data("stock");
    //         console.log(abc);
    //         $('#select-product .stockready').attr("max",stockready);
    //     });
    // }

    // $('input[type=number][max]:not([max=""])').on('input', function(ev) {
    //     var $this = $(this);
    //     var maxlength = $this.attr('max').length;
    //     var value = $this.val();
    //     if (value && value.length >= maxlength) {
    //       $this.val(value.substr(0, maxlength));
    //     }
    // });
    
}


// TRANSACTION ADD

$("#transactionAddModal .product-number").on("change", function(e){
    e.preventDefault();
    var setCountProduct = $(this).val();
    loadProducts(setCountProduct);
});

$("#transactionAddModal .form-add-transactions").on("submit", function(e){
    e.preventDefault();
    var getForm = new FormData(this);
    $.ajax({
        type: "POST",
        url: WEB_URL,
        data: getForm,
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
                            title: "Success",
                            text: succMessages,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 1000,
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                $("#table-transactions").DataTable().ajax.reload();
                                $("#transactionAddModal .form-add-transactions").trigger("reset");
                                loadProducts(0);
                                $("#transactionAddModal").modal("hide");
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


//TRANSACTION DETAIL

$("#table-transactions tbody").on("click", ".detail", function (e) {
    e.preventDefault();
    // GET THE ID
    var getTrId = $(this).attr("transaction-id");

    // DEFINE THE MODAL
    var transDetModal = $("#transactionDetailModal");
    transDetModal.modal("show");

    // DECLARE JSON
    var trId       = transDetModal.find('.transaction-id');
    var trName     = transDetModal.find('.transaction-name');
    var trPrdN     = transDetModal.find('.transaction-prodnumber');
    var detailProd = transDetModal.find('.detail-product-table tbody');
    var htmlDetProd = "";
    var trTotalQty = transDetModal.find('.total-qty');
    var trTotalAll = transDetModal.find('.total-price');

    $.ajax({
        type: "GET",
        url: WEB_URL + "/" + getTrId,
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            trId.html(response.data[0].transaction_id);
            trTotalQty.html(response.data[0].total_qty);
            trTotalAll.html(response.data[0].total_price);
            trName.html(response.data[0].customer_name);
            trPrdN.html(response.list_total);

            for (let i = 0; i < response.list_total; i++) {
                htmlDetProd += '<tr>';
                htmlDetProd += '<td>'+response.list[i].product_name+'</td>';
                htmlDetProd += '<td>'+response.list[i].product_price+'</td>';
                htmlDetProd += '<td>'+response.list[i].subtotal_qty+'</td>';
                htmlDetProd += '<td>'+response.list[i].subtotal_price+'</td>';
                htmlDetProd += '</tr>';
                detailProd.html(htmlDetProd);
            }
          
        },
        error: function (response) {
            console.log(response.message);
        },
    });

});


//TRANSACTION DELETE

$("#table-transactions tbody").on("click", ".delete", function (e) {
    e.preventDefault();
    var transDelId = $(this).attr("transaction-id");
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#333",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "DELETE",
                url: WEB_URL + "/" + transDelId,
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
                                        $("#table-transactions").DataTable().ajax.reload();
                                        loadProducts(0);
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


//TRANSACTION EDIT

// $("#table-transactions tbody").on("click", ".edit", function (e) {
//     e.preventDefault();
//     var getTrId = $(this).attr("transaction-id");

//     var transEdtModal = $("#transactionDetailModal");
//     transEdtModal.modal("show");

//     var trId       = transEdtModal.find('.transaction-id');
//     var trName     = transEdtModal.find('.transaction-name');
//     var trPrdN     = transEdtModal.find('.transaction-prodnumber');
//     var detailProd = $("#detail-product");
//     var setHtmlEditProd = "";

//     $.ajax({
//         type: "GET",
//         url: WEB_URL + "/" + getTrId,
//         dataType: "JSON",
//         success: function (response) {
//             trId.html(response.data[0].transaction_id);
//             trName.val(response.data[0].customer_name);
//             trPrdN.val(response.list_total);
//             for (let i = 0; i < trPrdN.val(); i++) {
//                 var subTotalQty = response.list[i].subtotal_qty;
//                 setHtmlEditProd += '<div class="form-row mx-0">';
//                 setHtmlEditProd += '<div class="form-group col-9 col-sm-8">';
//                 setHtmlEditProd += '<label for="productId">Product</label>';
//                 setHtmlEditProd += '<select name="product_id_'+ i +'" class="form-control edit-product">';
//                 setHtmlEditProd += '</select>';
//                 setHtmlEditProd += '</div>';
//                 setHtmlEditProd += '<div class="form-group col-3 col-sm-4">';
//                 setHtmlEditProd += '<label for="subQty">Qty</label>';
//                 setHtmlEditProd += '<input name="qty_product_'+ i +'" type="text" value="'+ subTotalQty +'" class="form-control" min="0">';
//                 setHtmlEditProd += '</div>';
//                 setHtmlEditProd += '</div>';
//             }
//             detailProd.html(setHtmlEditProd);
//             // Looping for product list
//             $.ajax({
//                 type: "GET",
//                 url: APP_URL + "/products/data/all",
//                 dataType: "JSON",
//                 success: function (response) {
//                     for (let x = 0; x < response.recordsTotal; x++) { 
//                         $("#detail-product .edit-product").append('<option  value="'+response.data[x].product_id+'">'+response.data[x].name+'</option>');
//                     }
//                 }
//             });
//         },
//         error: function (response) {
//             console.log(response.message);
//         },
//     });

// });

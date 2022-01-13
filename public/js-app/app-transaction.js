loadProducts();

var thisTablesUses = $("#table-transactions").DataTable({
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
        { data: "total_qty", name: "total_qty" },
        { data: "total_price", name: "total_price" },
        { data: " ", name: " " },
    ],
    columnDefs: [
        {
            targets: 5,
            render: function (data, type, row, meta) {
                return (
                    '<div class="d-flex justify-content-around">' +
                    '<button class="btn btn-danger btn-sm delete"' + '" transaction-id="' + row.transaction_id + '"/><i class="fas fa-trash fa-sm fa-fw"></i></button>' +
                    '</div>'
                );
            },
        },
    ],
    order: [[0, "desc"]],
    pageLength: 5,
});

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
        setHtmlSelProduct += '<input name="qty_product_'+ i +'" type="number" class="form-control" min="0">';
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
                $("#select-product .pick-product").append('<option value="'+response.data[x].product_id+'">'+response.data[x].name+'</option>');
            }
        }
    });
}

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
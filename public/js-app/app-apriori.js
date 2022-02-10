// var formApriori = $("#form-apriori");
// var checkComb = formApriori.find("#count-combination");
// var checkAll = formApriori.find("#checkall-checkbox");
// var sumbitApriori = formApriori.find(".submit-form-apriori");

var thisApriori = $("#apriori-results");
var loadApriori = thisApriori.find(".combination-load");
var resultApri1 = thisApriori.find(".combination-results-1");
var resultApri2 = thisApriori.find(".combination-results-2");
var resultApri3 = thisApriori.find(".combination-results-3");

setTimeout(function () {
    resultApri1.fadeIn(200).removeClass("d-none");
    setTimeout(function () {
        resultApri2.fadeIn(200).removeClass("d-none");
        setTimeout(function () {
            loadApriori.addClass("d-none");
            resultApri3.fadeIn(200).removeClass("d-none");
        }, 2000);
    }, 2000);
}, 4000);

// sumbitApriori.prop("disabled", true);

// $("#form-apriori :checkbox").change(function () {
//     $(this).each(function () {
//         if ($(this).is(":checked")) {
//             if ($(this).length == 0) {
//                 sumbitApriori.prop("disabled", true);
//             } else {
//                 sumbitApriori.prop("disabled", false);
//             }
//         } else {
//             sumbitApriori.prop("disabled", true);
//         }
//     });
// });

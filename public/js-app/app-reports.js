var transactionReportDay = $("#trans-report-day");
var reportDayCalendar = transactionReportDay.find(".report-trans-cal");
var btnReportDay = transactionReportDay.find(".submit-report-day");
var valueReportDay = "";

// reportDayCalendar.val(moment().format("YYYY-MM-DD"));
reportDayCalendar.change(function (e) {
    e.preventDefault();
    valueReportDay = this.value;
    // submitReportsDay(valueReportDay);
});

btnReportDay.on("click", function (e) {
    e.preventDefault();
    var getMomentDay = moment(valueReportDay).format("YYYY-MM-DD");
    // window.location.href = WEB_URL + "/trans/day/" + getMomentDay;
    window.open(WEB_URL + "/trans/day/" + getMomentDay);
});

// function submitReportsDay(getDayValue) {
//     var getNewDateValue = getDayValue;
//     btnReportDay.on("click", function (e) {
//         e.preventDefault();
//         // var getMomentDay = moment(getDayValue).format("DD/MM/YYYY");
//         var getMomentDay = moment(getNewDateValue).format("DD/MM/YYYY");
//         console.log(getMomentDay);
//     });
// }

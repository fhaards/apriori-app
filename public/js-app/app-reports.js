// REPORT BY DAY
var transactionReportDay = $("#trans-report-day");
var reportDayCalendar = transactionReportDay.find(".report-trans-cal");
var btnReportDay = transactionReportDay.find(".submit-report-day");
var valueReportDay = "";

// REPORT BY MONTH
var transactionReportMonth = $("#trans-report-month");
var reportMontCalendar = transactionReportMonth.find(".report-trans-month");
var btnReportMonth = transactionReportMonth.find(".submit-report-month");
var valueReportMonth = null;

// REPORT BY YEAR
var transactionReportYear = $("#trans-report-year");
var reportYearCalendar = transactionReportYear.find(".report-trans-year");
var btnReportYear = transactionReportYear.find(".submit-report-year");
var valueReportYear = null;

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

reportMontCalendar.change(function (e) {
    e.preventDefault();
    valueReportMonth = this.value;
});

btnReportMonth.on("click", function (e) {
    e.preventDefault();
    // console.log(reportMontCalendar.val());
    window.open(WEB_URL + "/trans/month/" + valueReportMonth);
});

reportYearCalendar.change(function (e) {
    e.preventDefault();
    valueReportYear = this.value;
});

btnReportYear.on("click", function (e) {
    e.preventDefault();
    // console.log(reportMontCalendar.val());
    window.open(WEB_URL + "/trans/year/" + valueReportYear);
});

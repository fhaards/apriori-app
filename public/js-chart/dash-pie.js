// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

var dashPieLabel = $('#pie-chart-dashboard');
var dashPieLabelName1 = dashPieLabel.find('.name_1');
var dashPieLabelName2 = dashPieLabel.find('.name_2');
var dashPieLabelName3 = dashPieLabel.find('.name_3');

$.ajax({
    type: "get",
    url: APP_URL + "/count/revenue-sources",
    dataType: "JSON",
    success: function (response) {

        var pieProdName1 = response.data[0].product_name;
        var pieProdName2 = response.data[1].product_name;
        var pieProdName3 = response.data[2].product_name;

        var pieQty1 = response.data[0].total_qty;
        var pieQty2 = response.data[1].total_qty;
        var pieQty3 = response.data[2].total_qty;

        var piePrice1 = response.data[0].total_price;
        var piePrice2 = response.data[1].total_price;
        var piePrice3 = response.data[2].total_price;

        dashPieLabelName1.html(pieProdName1);
        dashPieLabelName2.html(pieProdName2);
        dashPieLabelName3.html(pieProdName3);

        // Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        
        var myPieChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: [pieProdName1 + ' | Qty : ' + pieQty1, pieProdName2 + ' | Qty : ' + pieQty2,pieProdName3 + ' | Qty : ' + pieQty3],
                datasets: [
                    {
                        data: [piePrice1, piePrice2, piePrice3],
                        backgroundColor: ["#22c55e", "#f59e0b", "#3b82f6"],
                        hoverBackgroundColor: ["#16a34a", "#d97706", "#2563eb"],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                  enabled: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false,
                },
                cutoutPercentage: 70,
            },
        });
    },
});

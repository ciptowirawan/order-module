// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

var total = document.querySelector('input[name="totalReg"]').value;
var paid = document.querySelector('input[name="paidReg"]').value;
var unpaid = document.querySelector('input[name="unpaidReg"]').value;
var unidentified = document.querySelector('input[name="unidentifiedReg"]').value;

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Unidentified", "Paid", "Unpaid"],
    datasets: [{
      data: [unidentified, paid, unpaid],
      // backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
      backgroundColor: ['#858796', '#1cc88a', '#e74a3b'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
      // hoverBackgroundColor: ['#4c076b', '#17a673', '#1a45c1'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});

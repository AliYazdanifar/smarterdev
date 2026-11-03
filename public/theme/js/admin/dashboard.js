(function () {
  var source = document.getElementById("admin-dashboard-charts");
  if (!source || typeof ApexCharts === "undefined") {
    return;
  }

  var data;
  try {
    data = JSON.parse(source.textContent || "{}");
  } catch (e) {
    return;
  }

  var months = data.months || [];
  var revenue = data.revenue || [];
  var orders = data.orders || [];
  var statusLabels = data.order_status_labels || [];
  var statusValues = data.order_status_values || [];

  function formatFa(value) {
    return new Intl.NumberFormat("fa-IR").format(Math.round(Number(value) || 0));
  }

  var revenueEl = document.querySelector("#chart-revenue-12m");
  if (revenueEl) {
    var revenueChart = new ApexCharts(revenueEl, {
      series: [
        {
          name: "درآمد",
          type: "area",
          data: revenue,
        },
        {
          name: "سفارش پرداخت‌شده",
          type: "line",
          data: orders,
        },
      ],
      chart: {
        height: 320,
        type: "line",
        stacked: false,
        toolbar: { show: false },
        dropShadow: {
          enabled: true,
          top: 4,
          left: 0,
          blur: 2,
          color: "#7366FF",
          opacity: 0.08,
        },
      },
      stroke: {
        width: [3, 3],
        curve: "smooth",
      },
      colors: ["#54BA4A", "#7366FF"],
      fill: {
        type: ["gradient", "solid"],
        gradient: {
          type: "vertical",
          shadeIntensity: 0.4,
          opacityFrom: 0.4,
          opacityTo: 0,
          stops: [0, 90, 100],
        },
      },
      dataLabels: { enabled: false },
      grid: {
        borderColor: "var(--chart-border)",
        strokeDashArray: 0,
      },
      markers: { size: 3 },
      xaxis: {
        categories: months,
        labels: {
          rotate: -45,
          rotateAlways: false,
        },
      },
      yaxis: [
        {
          title: { text: "درآمد" },
          labels: {
            formatter: formatFa,
          },
        },
        {
          opposite: true,
          title: { text: "سفارش" },
          labels: {
            formatter: formatFa,
          },
        },
      ],
      legend: {
        position: "top",
        horizontalAlign: "right",
      },
      tooltip: {
        shared: true,
        intersect: false,
        y: {
          formatter: formatFa,
        },
      },
    });
    revenueChart.render();
  }

  var statusEl = document.querySelector("#chart-order-status");
  if (statusEl && statusValues.length) {
    var statusChart = new ApexCharts(statusEl, {
      labels: statusLabels,
      series: statusValues.map(function (value) {
        return Number(value) || 0;
      }),
      chart: {
        type: "donut",
        height: 320,
      },
      dataLabels: { enabled: false },
      legend: {
        position: "bottom",
        fontSize: "14px",
      },
      stroke: {
        width: 8,
        colors: ["var(--light2)"],
      },
      plotOptions: {
        pie: {
          expandOnClick: false,
          donut: {
            size: "78%",
            labels: {
              show: true,
              total: {
                show: true,
                label: "سفارش‌ها",
                fontSize: "16px",
                formatter: function (w) {
                  var total = w.globals.seriesTotals.reduce(function (a, b) {
                    return a + b;
                  }, 0);
                  return formatFa(total);
                },
              },
            },
          },
        },
      },
      colors: ["#FFA941", "#7366FF", "#54BA4A", "#FC4438", "#838383", "#FF3364"],
      tooltip: {
        y: {
          formatter: formatFa,
        },
      },
    });
    statusChart.render();
  }
})();

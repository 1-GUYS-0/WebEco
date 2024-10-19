'use strict';

/* Chart.js docs: https://www.chartjs.org/ */

window.chartColors = {
    purple: '#8D7ECD',
    blue: '#7EACCD',
    red: '#FF6384',
    orange: '#FF9F40',
    yellow: '#FFCD56',
    green: '#4BC0C0',
    text: '#252930',
    border: '#e7e9ed'
};

function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// Hàm tạo mảng màu sắc dựa trên số lượng nhãn
function generateColors(labels) {
    const colors = [];
    for (let i = 0; i < labels.length; i++) {
        colors.push(getRandomColor());
    }
    return colors;
}

document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Hàm để lấy dữ liệu từ server và cập nhật biểu đồ
    function fetchAndUpdateCharts() {
        fetch('/admin/dashboard/datachart', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật BarChart với dữ liệu mới
                barChartConfig.data.labels = data.barChart.labels;
                barChartConfig.data.datasets[0].data = data.barChart.data;
                barChartConfig.data.datasets[1].data = data.barChart.lineData; // Cập nhật dữ liệu line
                window.myBar.update();

                // Cập nhật PieChart với dữ liệu mới
                pieChartConfig.data.labels = data.pieChart.labels;
                pieChartConfig.data.datasets[0].data = data.pieChart.data;
                pieChartConfig.data.datasets[0].backgroundColor = generateColors(data.pieChart.labels);
                window.myPie.update();
            } else {
                alert('Không tìm thấy dữ liệu.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Khởi tạo biểu đồ khi trang được tải xong
    fetchAndUpdateCharts();
});

// Cấu hình biểu đồ thanh (BarChart)
var barChartConfig = {
    type: 'bar',
    data: {
        labels: [], // Sẽ được cập nhật với dữ liệu từ server
        datasets: [
        {
            label: 'Số lượng đơn hàng',
            type: 'line', // Loại biểu đồ là line
            backgroundColor: window.chartColors.blue,
            borderColor: window.chartColors.blue,
            fill: false,
            data: [], // Sẽ được cập nhật với dữ liệu từ server
            yAxisID: 'y-axis-2' // Sử dụng trục Y thứ hai
        },
        {
            label: 'Doanh thu',
            backgroundColor: window.chartColors.purple,
            borderColor: window.chartColors.purple,
            borderWidth: 1,
            maxBarThickness: 16,
            data: [], // Sẽ được cập nhật với dữ liệu từ server
            yAxisID: 'y-axis-1' // Sử dụng trục Y đầu tiên
        },
    ]
    },
    options: {
        responsive: true,
        aspectRatio: 1.5,
        legend: {
            position: 'bottom',
            align: 'end',
        },
        title: {
            display: false,
            text: 'Monthly Orders and Revenue'
        },
        tooltips: {
            mode: 'index',
            intersect: false,
            titleMarginBottom: 10,
            bodySpacing: 10,
            xPadding: 16,
            yPadding: 16,
            borderColor: window.chartColors.border,
            borderWidth: 1,
            backgroundColor: '#fff',
            bodyFontColor: window.chartColors.text,
            titleFontColor: window.chartColors.text,
        },
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    drawBorder: false,
                    color: window.chartColors.border,
                },
            }],
            yAxes: [{
                id: 'y-axis-1', // Trục Y đầu tiên
                type: 'linear',
                position: 'left',
                display: true,
                gridLines: {
                    drawBorder: false,
                    color: window.chartColors.border,
                },
                ticks: {
                    beginAtZero: true
                }
            }, {
                id: 'y-axis-2', // Trục Y thứ hai
                type: 'linear',
                position: 'right',
                display: true,
                gridLines: {
                    drawBorder: false,
                    color: window.chartColors.border,
                },
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
};

// Cấu hình biểu đồ tròn (PieChart)
var pieChartConfig = {
    type: 'pie',
    data: {
        labels: [], // Sẽ được cập nhật với dữ liệu từ server
        datasets: [{
            label: 'Sales',
            backgroundColor: [],
            borderColor: '#fff',
            borderWidth: 1,
            data: [] // Sẽ được cập nhật với dữ liệu từ server
        }]
    },
    options: {
        responsive: true,
        legend: {
            position: 'bottom',
            align: 'end',
        },
        title: {
            display: false,
            text: 'Sales by Category'
        },
        tooltips: {
            mode: 'index',
            intersect: false,
            titleMarginBottom: 10,
            bodySpacing: 10,
            xPadding: 16,
            yPadding: 16,
            borderColor: window.chartColors.border,
            borderWidth: 1,
            backgroundColor: '#fff',
            bodyFontColor: window.chartColors.text,
            titleFontColor: window.chartColors.text,
        }
    }
};

// var barChartConfig = {
//     type: 'bar',
//     data: {
//         labels: ['January'], // Dữ liệu mẫu cho nhãn trục X
//         datasets: [{
//             label: 'Orders',
//             backgroundColor: window.chartColors.purple,
//             borderColor: window.chartColors.purple,
//             borderWidth: 1,
//             maxBarThickness: 16,
//             data: [10, 20, 30, 40, 50, 60, 70] // Dữ liệu mẫu cho số lượng đơn hàng
//         },
//         {
//             label: 'Revenue',
//             type: 'line', // Loại biểu đồ là line
//             backgroundColor: window.chartColors.blue,
//             borderColor: window.chartColors.blue,
//             fill: false,
//             data: [100] // Dữ liệu mẫu cho doanh thu
//         }]
//     },
//     options: {
//         responsive: true,
//         aspectRatio: 1.5,
//         legend: {
//             position: 'bottom',
//             align: 'end',
//         },
//         title: {
//             display: false,
//             text: 'Monthly Orders and Revenue'
//         },
//         tooltips: {
//             mode: 'index',
//             intersect: false,
//             titleMarginBottom: 10,
//             bodySpacing: 10,
//             xPadding: 16,
//             yPadding: 16,
//             borderColor: window.chartColors.border,
//             borderWidth: 1,
//             backgroundColor: '#fff',
//             bodyFontColor: window.chartColors.text,
//             titleFontColor: window.chartColors.text,
//         },
//         scales: {
//             xAxes: [{
//                 display: true,
//                 gridLines: {
//                     drawBorder: false,
//                     color: window.chartColors.border,
//                 },
//             }],
//             yAxes: [{
//                 display: true,
//                 gridLines: {
//                     drawBorder: false,
//                     color: window.chartColors.border,
//                 },
//                 ticks: {
//                     beginAtZero: true
//                 }
//             }]
//         }
//     }
// };
// Khởi tạo biểu đồ khi trang được tải xong
window.addEventListener('load', function () {
    var barChart = document.getElementById('canvas-barchart').getContext('2d');
    window.myBar = new Chart(barChart, barChartConfig);

    var pieChart = document.getElementById('canvas-piechart').getContext('2d');
    window.myPie = new Chart(pieChart, pieChartConfig);
});
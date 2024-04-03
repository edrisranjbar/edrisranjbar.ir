import Chart from 'chart.js/auto';

const labels = ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'];
const data = {
    labels: labels,
    datasets: [
        {
            label: 'بازدیدکننده',
            data: viewersData,
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            tension: 0.2
        },
        {
            label: 'بازدید',
            data: viewsData,
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            tension: 0.3
        }
    ]
};

// Configure chart options
const options = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom',
            labels: {
                font: {
                    family: "Vazirmatn FD",
                    size: 10
                }
            }
        },
    }
};

// Render the line chart
const ctx = document.getElementById('viewsChart');
const myChart = new Chart(ctx, {
    type: 'line',
    data: data,
    options: options
});
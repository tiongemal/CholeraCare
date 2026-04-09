@include('components.header')

<style>
    .chart {
        max-width: 100%; /* Ensure charts fit within the column */
        height: 200px; /* Set a fixed height for the charts */
        display: none; /* Hide all charts by default */
        margin: 0 auto; /* Center the chart */
    }

    .chart.active {
        display: block; /* Show the active chart */
    }

    .chart-container {
        text-align: center; /* Center the charts horizontally */
    }
</style>

<div class="container mt-5">
    <h1 class="text-center">Cholera Reports Dashboard</h1>

    <!-- Toggle Buttons for Charts -->
    <div class="text-center mb-4">
        <button class="btn btn-primary toggle-btn" data-target="#confirmedCasesByMonthChart">Confirmed Cases by Month</button>
        <button class="btn btn-secondary toggle-btn" data-target="#casesByLocationChart">Cases by Location</button>
        <button class="btn btn-success toggle-btn" data-target="#suspectedVsConfirmedChart">Suspected vs Confirmed Cases</button>
        <button class="btn btn-info toggle-btn" data-target="#casesOverTimeChart">Cases Over Time</button>
        <button class="btn btn-warning toggle-btn" data-target="#casesByGenderChart">Confirmed Cases by Gender</button>
        <button class="btn btn-danger toggle-btn" data-target="#casesByAgeChart">Confirmed Cases by Age</button>
    </div>

    <!-- Chart Containers -->
    <div class="row chart-container">
        <div class="col-md-6 mb-4">
            <canvas id="confirmedCasesByMonthChart" class="chart active" width="400" height="200"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="casesByLocationChart" class="chart" width="400" height="200"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="suspectedVsConfirmedChart" class="chart" width="400" height="200"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="casesOverTimeChart" class="chart" width="400" height="200"></canvas>
        </div>
        <!-- New Chart Containers -->
        <div class="col-md-6 mb-4">
            <canvas id="casesByGenderChart" class="chart" width="400" height="200"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="casesByAgeChart" class="chart" width="400" height="200"></canvas>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h3>Total Cases: {{ $totalCases }}</h3>
        </div>
    </div>
</div>

<!-- ChartJS and Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.toggle-btn');
        const charts = document.querySelectorAll('.chart');

        // Ensure the first chart is displayed by default
        charts[0].classList.add('active');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove 'active' class from all charts
                charts.forEach(chart => {
                    chart.classList.remove('active');
                });

                // Add 'active' class to the target chart
                const target = this.getAttribute('data-target');
                document.querySelector(target).classList.add('active');
            });
        });
    });

    // Confirmed Cases by Month Chart
    var ctx1 = document.getElementById('confirmedCasesByMonthChart').getContext('2d');
    var confirmedCasesByMonthChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: @json($confirmedCasesByMonthData['labels']),
            datasets: [{
                label: 'Confirmed Cases',
                data: @json($confirmedCasesByMonthData['data']),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Cases by Location Chart
    var ctx2 = document.getElementById('casesByLocationChart').getContext('2d');
    var casesByLocationChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: @json($casesByLocationData['labels']),
            datasets: [{
                label: 'Cases by Location',
                data: @json($casesByLocationData['data']),
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Suspected vs Confirmed Cases Chart
    var ctx3 = document.getElementById('suspectedVsConfirmedChart').getContext('2d');
    var suspectedVsConfirmedChart = new Chart(ctx3, {
        type: 'pie',
        data: {
            labels: @json($suspectedVsConfirmedCasesData['labels']),
            datasets: [{
                label: 'Suspected vs Confirmed Cases',
                data: @json($suspectedVsConfirmedCasesData['data']),
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        }
    });

    // Cases Over Time Chart
    var ctx4 = document.getElementById('casesOverTimeChart').getContext('2d');
    var casesOverTimeChart = new Chart(ctx4, {
        type: 'line',
        data: {
            labels: @json($casesOverTimeData['labels']),
            datasets: [{
                label: 'Cases Over Time',
                data: @json($casesOverTimeData['data']),
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Confirmed Cases by Gender Chart
    var ctx5 = document.getElementById('casesByGenderChart').getContext('2d');
    var casesByGenderChart = new Chart(ctx5, {
        type: 'doughnut',
        data: {
            labels: @json($casesByGenderData['labels']),
            datasets: [{
                label: 'Confirmed Cases by Gender',
                data: @json($casesByGenderData['data']),
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                borderWidth: 1
            }]
        }
    });

    // Confirmed Cases by Age Chart
    var ctx6 = document.getElementById('casesByAgeChart').getContext('2d');
    var casesByAgeChart = new Chart(ctx6, {
        type: 'bar',
        data: {
            labels: @json($casesByAgeData['labels']),
            datasets: [{
                label: 'Confirmed Cases by Age',
                data: @json($casesByAgeData['data']),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@include('components.footer')

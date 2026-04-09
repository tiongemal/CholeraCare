@include('components.header')

<div class="container">
    <h1 class="text-center">Cholera Cases Bar Chart</h1>
    <canvas id="barChart" width="400" height="200"></canvas>
</div>

<script>
    var ctx = document.getElementById('barChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),  // Months as labels
            datasets: [{
                label: 'Confirmed Cholera Cases',
                data: @json($data),  // Cholera case counts
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

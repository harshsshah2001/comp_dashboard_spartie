@include('admin.includes.header')
@include('admin.includes.sidebar')

<div class="app-content">

    <div class="row">

        <!-- CHART COLUMN (8) -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Category Chart</h4>
                </div>

                <div class="card-body">
                    <canvas id="categoryChart" height="180"></canvas>
                </div>
            </div>
        </div>

        <!-- EXTRA INFO COLUMN (4) -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Total Categories</h4>
                </div>
                <div class="card-body text-center">
                    <h1 style="font-size:50px; font-weight:700; color:#4e73df;">
                        {{ $chartData->sum('total') }}
                    </h1>
                    <p class="mt-2">Total categories stored in system.</p>
                </div>
            </div>
        </div>
<!-- DONUT CHART COLUMN (4) -->
<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <h4>Parent Category Distribution</h4>
        </div>

        <div class="card-body">
            <canvas id="parentDonutChart" height="250"></canvas>
        </div>
    </div>
</div>


    </div>

</div>

@include('admin.includes.footer')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let labels = [
        @foreach($chartData as $data)
            "{{ $data->parentCategory ?? 'No Parent' }}",
        @endforeach
    ];

    let totals = [
        @foreach($chartData as $data)
            {{ $data->total }},
        @endforeach
    ];

    const ctx = document.getElementById('categoryChart').getContext('2d');

    new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Category Count',
            data: totals,
            backgroundColor: [
                '#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b'
            ],
            barPercentage: 0.1,     // makes bar thin
            categoryPercentage: 0.4 // spacing between bars
        }]
    },
    options: {
        scales: {
            x: {
                barPercentage: 0.3,
                categoryPercentage: 0.4
            }
        }
    }
});

</script>

<script>
    const donutCtx = document.getElementById('parentDonutChart').getContext('2d');

    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach($chartData as $data)
                    "{{ $data->parentCategory ?? 'No Parent' }}",
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($chartData as $data)
                        {{ $data->total }},
                    @endforeach
                ],
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e',
                    '#e74a3b',
                    '#858796',
                    '#5a5c69'
                ],
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            cutout: '65%', // makes donut shape
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>


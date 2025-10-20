@extends('base')

@section('styles')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
.dashboard-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    padding: 20px;
}

.card {
    background-color: #f8f9fa;
    border-left: 6px solid #007bff;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    border-radius: 12px;
    transition: transform 0.2s ease;
}

.card:hover { transform: translateY(-5px); }

.card h3 { margin-bottom: 10px; font-size: 1.25rem; color: #333; }

.card p { font-size: 1.5rem; font-weight: bold; color: #007bff; }

.chart-container {
    padding: 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.chart-container h4 {
    text-align: center;
    margin-bottom: 20px;
    color: #0c337c;
}

#productSelect {
    display: block;
    margin: 10px auto 20px;
    max-width: 300px;
}
</style>
@endsection

@section('content')

<div class="dashboard-container">
    <div class="card">
        <h3>Total Users</h3>
        <p>{{ $totalUsers }}</p>
    </div>
    <div class="card">
        <h3>Total Sales</h3>
        <p>NPR. {{ round($totalSales, 2) }}</p>
    </div>
    <div class="card">
        <h3>Total Purchase</h3>
        <p>NPR. {{ round($totalPurchase, 2) }}</p>
    </div>
    <div class="card">
        <h3>Reports</h3>
        <p>{{ $totalReports }}</p>
    </div>
</div>

<!-- Charts Side by Side -->
<div class="row">
    <!-- Line Chart (9 cols) -->
    <div class="col-md-9">
        <div class="chart-container">
            <h4>Sales Predictions (Next 3 Months)</h4>
            <select id="productSelect" class="form-control">
                @foreach($reportData as $product)
                    <option value="{{ $product['item_code'] }}">{{ $product['product_name'] }}</option>
                @endforeach
            </select>
            <canvas id="predictionChart" style="max-width: 100%; height: 400px;"></canvas>
        </div>
    </div>

    <!-- Pie/Doughnut Chart (3 cols) -->
    <div class="col-md-3">
        <div class="chart-container">
            <h4>Sales Clustering (Last 90 Days)</h4>
            <canvas id="clusterDonutChart" style="max-width: 100%; height: 400px;"></canvas>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- Clustering Donut Chart ---
    const clusterCounts = {};
    @foreach($clusters as $sale)
        clusterCounts['{{ $sale->cluster ?? "Unknown" }}'] = (clusterCounts['{{ $sale->cluster ?? "Unknown" }}'] || 0) + 1;
    @endforeach

    const ctxCluster = document.getElementById('clusterDonutChart').getContext('2d');
    new Chart(ctxCluster, {
        type: 'doughnut',
        data: {
            labels: Object.keys(clusterCounts),
            datasets: [{
                label: 'Sales Clusters',
                data: Object.values(clusterCounts),
                backgroundColor: ['#28a745', '#dc3545', '#007bff'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: true, text: 'Cluster Distribution' }
            }
        }
    });

    // --- Prediction Chart ---
    const reportData = @json($reportData);
    const ctxPred = document.getElementById('predictionChart').getContext('2d');
    let predictionChart = null;

    function updateChart(itemCode) {
        const product = reportData.find(p => p.item_code == itemCode);
        if (!product) return;

        const labels = product.predictions.map(p => p.date);
        const data = product.predictions.map(p => p.predicted_quantity ?? 0);

        if (predictionChart) {
            predictionChart.data.labels = labels;
            predictionChart.data.datasets[0].data = data;
            predictionChart.options.plugins.title.text = product.product_name + " - Total Predicted: " + Math.round(product.total_predicted_sales);
            predictionChart.update();
        } else {
            predictionChart = new Chart(ctxPred, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Predicted Quantity',
                        data: data,
                        fill: false,
                        borderColor: '#007bff',
                        tension: 0.2,
                        pointRadius: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: product.product_name + " - Total Predicted: " + Math.round(product.total_predicted_sales)
                        }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        }
    }

    // Initialize chart with first product
    updateChart(document.getElementById('productSelect').value);

    // Change chart when dropdown changes
    document.getElementById('productSelect').addEventListener('change', function() {
        updateChart(this.value);
    });
</script>
@endsection

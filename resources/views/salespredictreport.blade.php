<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>3-Month Sales Prediction Report</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<style>
.a4-report {
  width: 210mm;
  min-height: 160mm;
  margin: auto;
  padding: 20mm;
  background: white;
  box-shadow: 0 0 5px 10px rgba(5, 4, 4, 0.1);
  font-family: 'Segoe UI', sans-serif;
  position: relative;
}
.report-title { font-size: 32px; color: #0c337c; font-weight: 700; }
.date-range { font-size: 16px; margin: 10px 0 20px; }
.report-table { font-size: 14px; width: 100%; margin-bottom: 30px; }
.report-table thead { background-color: #1f4870ff; color: white; }
.report-table th, .report-table td { text-align: center; padding: 8px; border: 1px solid #ccc; }
.export-icon { position: absolute; top: 20px; right: 20px; font-size: 28px; color: #dc3545; }
.export-icon:hover { color: #a71d2a; }
@media print {
  body * { visibility: hidden; }
  .a4-report, .a4-report * { visibility: visible; }
  .a4-report { position: absolute; left: 0; top: 0; width: 100%; margin: 0; padding: 0; box-shadow: none; }
  .export-icon { display: none; }
}
</style>

<body>
<div class="container mt-5 a4-report">

  <!-- Export PDF button -->
  <a href="/sales-predict-report/pdf" target="_blank" class="export-icon" title="Export to PDF">
    <i class="fas fa-file-pdf"></i>
  </a>

  <div class="text-center mb-4">
    <h1 class="report-title">3-Month Sales Prediction Report</h1>
    <p class="date-range">
      From: <strong>{{ \Carbon\Carbon::today()->format('Y-m-d') }}</strong>
      To: <strong>{{ \Carbon\Carbon::today()->addDays(89)->format('Y-m-d') }}</strong>
    </p>
  </div>

  <!-- Dropdown -->
  <div class="form-group">
    <label for="productSelect"><strong>Select Item:</strong></label>
    <select class="form-control" id="productSelect">
      <option value="">-- Choose Item --</option>
      @foreach ($reportData as $product)
        <option value="{{ $product['item_code'] }}">{{ $product['product_name'] }} ({{ $product['item_code'] }})</option>
      @endforeach
    </select>
  </div>

  <!-- Prediction Sections -->
  @foreach ($reportData as $product)
  <div class="prediction-section d-none" id="section-{{ $product['item_code'] }}">
    <div class="card mb-4 shadow-sm">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $product['product_name'] }} (Item Code: {{ $product['item_code'] }})</h5>
        <span class="badge badge-light text-dark">
          Total 3-Month Sales: {{ round($product['total_predicted_sales']) }}
        </span>
      </div>
      <div class="card-body p-0">
        <div class="mb-3" style="max-width: 100%; overflow-x:auto;">
          <canvas id="chart-{{ $product['item_code'] }}"></canvas>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped report-table">
            <thead>
              <tr>
                <th>Month</th>
                <th>Total Predicted Quantity</th>
              </tr>
            </thead>
            <tbody>
              @php
                $monthlyTotals = collect($product['predictions'])
                  ->groupBy(function($p) {
                      return \Carbon\Carbon::parse($p['date'])->format('Y-m');
                  })
                  ->map(function($group) {
                      return [
                          'month' => \Carbon\Carbon::parse($group->last()['date'])->format('F Y'),
                          'total' => round($group->sum('predicted_quantity'))
                      ];
                  });
              @endphp

              @foreach ($monthlyTotals as $monthData)
                <tr>
                  <td>{{ $monthData['month'] }}</td>
                  <td>{{ $monthData['total'] }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @endforeach

</div>

<script>
  // Initialize charts (round data values)
  const charts = {};

  @foreach ($reportData as $product)
    const ctx{{ $product['item_code'] }} = document
      .getElementById('chart-{{ $product['item_code'] }}')
      .getContext('2d');

    charts["{{ $product['item_code'] }}"] = new Chart(ctx{{ $product['item_code'] }}, {
      type: 'line',
      data: {
        labels: [
          @foreach($product['predictions'] as $prediction)
            '{{ \Carbon\Carbon::parse($prediction['date'])->format('d M') }}',
          @endforeach
        ],
        datasets: [{
          label: 'Predicted Quantity',
          data: [
            @foreach($product['predictions'] as $prediction)
              {{ $prediction['predicted_quantity'] !== null ? round($prediction['predicted_quantity']) : 'null' }},
            @endforeach
          ],
          borderColor: '#007bff',
          backgroundColor: 'rgba(0,123,255,0.2)',
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: true },
          title: { display: true, text: '90-Day Predicted Sales' }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                // ✅ Show only whole numbers on Y-axis
                return Number.isInteger(value) ? value : null;
              }
            }
          }
        }
      }
    });
  @endforeach

  // Show/Hide prediction sections based on dropdown
  document.getElementById('productSelect').addEventListener('change', function() {
    const selected = this.value;
    document.querySelectorAll('.prediction-section').forEach(sec => sec.classList.add('d-none'));
    if (selected) {
      document.getElementById('section-' + selected).classList.remove('d-none');
    }
  });
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sales Prediction Report</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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

  .report-title {
    font-size: 32px;
    color: #0c337c;
    font-weight: 700;
  }

  .date-range {
    font-size: 16px;
    color: #333;
    margin-top: 25px;
    margin-bottom: 20px;
  }

  .report-table {
    font-size: 14px;
    width: 100%;
  }

  .report-table thead {
    background-color: #1f4870ff;
    color: white;
  }

  .report-table th,
  .report-table td {
    text-align: center;
    vertical-align: middle;
    padding: 8px;
    border: 1px solid #ccc;
  }

  .export-icon {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 28px;
    color: #dc3545;
    text-decoration: none;
    transition: color 0.2s ease;
  }

  .export-icon:hover {
    color: #a71d2a;
    text-decoration: none;
  }

  @media print {
    body * {
      visibility: hidden;
    }

    .a4-report,
    .a4-report * {
      visibility: visible;
    }

    .a4-report {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      margin: 0;
      padding: 0;
      box-shadow: none;
    }

    .export-icon {
      display: none;
    }
  }
</style>

<body>
  <div class="container mt-5 a4-report">

    <!-- PDF Export Button (Optional: update the link route later if needed) -->
    <a href="#" class="export-icon" title="Export to PDF">
      <i class="fas fa-file-pdf"></i>
    </a>

    <div class="text-center mb-4">
      <h1 class="report-title">Sales Prediction Report</h1>
      <p class="date-range">
        Predicting For: 
        <strong>{{ $predictMonth ?? 'N/A' }}/{{ $predictYear ?? 'N/A' }}</strong>
      </p>
    </div>

    <table class="table table-bordered table-striped report-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Product Name</th>
          <th>Item Code</th>
          <th>Predicted Quantity</th>
        </tr>
      </thead>
      <tbody>
        @if (isset($reportData) && count($reportData) > 0)
          @foreach ($reportData as $index => $item)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $item['product_name'] }}</td>
              <td>{{ $item['item_code'] }}</td>
              <td>
                @if(is_numeric($item['prediction']))
                  {{ round($item['prediction'], 2) }}
                @else
                  <span class="text-danger">{{ $item['prediction'] }}</span>
                @endif
              </td>
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="4" class="text-center text-danger">No sales data available for prediction.</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</body>
</html>

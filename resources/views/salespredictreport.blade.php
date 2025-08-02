<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sales Report</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<style>
/* A4 Report Styling */
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

/* Title */
.report-title {
  font-size: 32px;
  color: #0c337c;
  font-weight: 700;
}

/* Date Centering */
.date-range {
  font-size: 16px;
  color: #333;
  margin-top: 25px;
  margin-bottom: 20px;
}

/* Report Table */
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

/* Export Button */
.export-btn {
  position: absolute;
  top: 20px;
  right: 20px;
  background-color: #dc3545;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  font-weight: 500;
  text-decoration: none;
}

.export-btn:hover {
  background-color: #a71d2a;
  text-decoration: none;
  color: white;
}

/* Print Optimization */
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

  .export-btn {
    display: none;
  }
}
.export-icon {
  position: absolute;
  top: 20px;
  right: 20px;
  font-size: 28px; /* Increase icon size */
  color: #dc3545;
  text-decoration: none;
  transition: color 0.2s ease;
}

.export-icon:hover {
  color: #a71d2a;
  text-decoration: none;
}

</style>

<body>
  <div class="container mt-5 a4-report">

    <!-- Export to PDF Button -->
   <a href="/purchase-report/pdf" target="_blank" class="export-icon" title="Export to PDF">
  <i class="fas fa-file-pdf"></i>
</a>

    <div class="text-center mb-4">
      <h1 class="report-title">Sales Prediction Report</h1>
      <p class="date-range">
        From: <strong>2025-07-01</strong> &nbsp;&nbsp;&nbsp;
        To: <strong>2025-07-31</strong>
      </p>
    </div>

    <table class="table table-bordered table-striped report-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Product Name</th>
          <th>Item Code</th>
          <th>Prediction</th>
        
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
        
         
          <td>ABC Traders</td>
            <td>INV-001</td>
          <td>20</td>
       
        </tr>
        <tr>
          <td>2</td>
          <td>XYZ Suppliers</td>
            <td>INV-002</td>
            <td>60</td>
            <td
         
        </tr>
        <!-- Add more rows dynamically -->
      </tbody>
    </table>
  </div>
</body>
</html>

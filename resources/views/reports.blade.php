@extends('base')

@section('styles')
<!-- Bootstrap 4 CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
@endsection

@section('content')
<style>
  .report-container {
    background: #fff;
    padding: 30px;
    margin-top: 40px;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    width: 70%;
  }

  .report-container h3 {
    color: #0c337c;
    font-size: 26px;
    font-weight: 600;
    margin-bottom: 25px;
    text-align: center;
  }

  .form-group label {
    font-weight: 500;
    color: #333;
  }

  .form-control {
    border-radius: 6px;
    box-shadow: none;
    transition: border-color 0.3s ease-in-out;
  }

  .form-control:focus {
    border-color: #0c337c;
    box-shadow: none;
  }

  .btn-generate {
    background-color: #0c337c;
    color: white;
    font-weight: 500;
    padding: 10px 24px;
    border-radius: 6px;
    transition: background-color 0.2s;
  }

  .btn-generate:hover {
    background-color: #8496b1ff;
  }

</style>

<div class="container pt-4 d-flex justify-content-center">
  <div class="report-container">
    <h3>Generate Report</h3>
    <form id="reportForm" onsubmit="return redirectToReport(event)">
      @csrf
      <!-- First row: From Date & To Date -->
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="from_date">From Date</label>
       <input type="date" id="from_date" name="from_date" class="form-control" required
         max="{{ \Carbon\Carbon::now()->toDateString() }}">
        </div>
        
        <div class="form-group col-md-6">
          <label for="to_date">To Date</label>
           <input type="date" id="to_date" name="to_date" class="form-control" required
         max="{{ \Carbon\Carbon::now()->toDateString() }}">
        </div>
      </div>

      <!-- Second row: Report Type (full width) -->
      <div class="form-group">
        <label for="report_type">Report Type</label>
        <select id="report_type" name="report_type" class="form-control" required>
          <option value="">-- Select Report Type --</option>
          <option value="sales">Sales Report</option>
          <option value="purchase">Purchase Report</option>
          <option value="inventory">Inventory Report</option>
          <!-- <option value="salesanalysis1">Sales Prediction Report</option> -->
           <option value="salesanalysis2">Sales Clustering Report</option>
        </select>
      </div>

      <!-- Button: Centered -->
      <div class="text-center mt-3">
        <button type="submit" class="btn btn-generate">Generate Report</button>
      </div>
    </form>
  </div>
</div>
<!-- JavaScript to handle redirection -->
<script>
  function redirectToReport(event) {
    event.preventDefault();

    const reportType = document.getElementById('report_type').value;
    const fromDate = document.getElementById('from_date').value;
    const toDate = document.getElementById('to_date').value;

    if (!reportType || !fromDate || !toDate) {
      alert("Please fill all fields before generating the report.");
      return false;
    }

    let routeUrl = "";

    switch (reportType) {
      case "sales":
        routeUrl = `/salesreport?from=${fromDate}&to=${toDate}`;
        break;
      case "purchase":
        routeUrl = `/purchasereport?from=${fromDate}&to=${toDate}`;
        break;
      case "inventory":
        routeUrl = `/inventoryreport?from=${fromDate}&to=${toDate}`;
        break;
      case "salesanalysis1":
        routeUrl = `/salespredictreport?from=${fromDate}&to=${toDate}`;
        break;
      case "salesanalysis2":
        routeUrl = `/sales-report?from=${fromDate}&to=${toDate}`;
        break;
      default:
        alert("Invalid report type selected.");
        return false;
    }

    window.location.href = routeUrl;
    return false;
  }
</script>
@endsection

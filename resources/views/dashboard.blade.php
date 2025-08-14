@extends('base')

@section('styles')
  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  
  <!-- AdminLTE CSS (optional) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">

@endsection
@section('content')

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

.card:hover {
  transform: translateY(-5px);
}

.card h3 {
  margin-bottom: 10px;
  font-size: 1.25rem;
  color: #333;
}

.card p {
  font-size: 1.5rem;
  font-weight: bold;
  color: #007bff;
}

</style>
<div class="dashboard-container">
  <div class="card">
    <h3>Total Users</h3>
    <p>{{ $totalUsers }}</p>
  </div>
  <div class="card">
    <h3>Total Sales</h3>
    <p>NPR . {{ round($totalSales,2) }}</p>
  </div>
  <div class="card">
    <h3>Total Purchase</h3>
    <p>NPR. {{ round($totalPurchase,2 )}}</p>
  </div>
  <div class="card">
    <h3>Reports</h3>
    <p>{{$totalReports}}</p>
  </div>
</div>
@endsection

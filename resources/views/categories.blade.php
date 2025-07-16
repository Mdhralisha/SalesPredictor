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
  <!-- Bootstrap 4 integration -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
  <!-- AdminLTE CSS (optional) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
  <style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
      padding: 0.25em 0.75em;
    }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_processing,
    .dataTables_wrapper .dataTables_paginate {
      color: #333;
    }
    .dataTables_wrapper .dataTables_filter input {
      margin-left: 0.5em;
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 5px;
    }
  </style>
@endsection

@section('content')
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="alert alert-success">
            <i class="fas fa-check-circle mr-2"></i> Welcome to AdminLTE with enhanced static DataTable!
          </div>

          <!-- Enhanced Static DataTable -->
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-users mr-2"></i> Employees
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body table-responsive p-0">
              <table id="employeesTable" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>john@example.com</td>
                    <td>(123) 456-7890</td>
                    <td>Marketing</td>
                    <td><span class="badge badge-success">Active</span></td>
                    <td>
                      <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Jane Smith</td>
                    <td>jane@example.com</td>
                    <td>(234) 567-8901</td>
                    <td>Sales</td>
                    <td><span class="badge badge-success">Active</span></td>
                    <td>
                      <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Robert Johnson</td>
                    <td>robert@example.com</td>
                    <td>(345) 678-9012</td>
                    <td>IT</td>
                    <td><span class="badge badge-warning">On Leave</span></td>
                    <td>
                      <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Sarah Williams</td>
                    <td>sarah@example.com</td>
                    <td>(456) 789-0123</td>
                    <td>HR</td>
                    <td><span class="badge badge-success">Active</span></td>
                    <td>
                      <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Michael Brown</td>
                    <td>michael@example.com</td>
                    <td>(567) 890-1234</td>
                    <td>Finance</td>
                    <td><span class="badge badge-danger">Inactive</span></td>
                    <td>
                      <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap 4 JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
  <!-- Buttons -->
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
  <!-- Button exports -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
  <!-- AdminLTE App (optional) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#employeesTable').DataTable({
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
             "<'row'<'col-sm-12 col-md-6'B>>",
        buttons: [
          {
            extend: 'copy',
            className: 'btn btn-sm btn-outline-secondary',
            text: '<i class="fas fa-copy"></i> Copy'
          },
          {
            extend: 'csv',
            className: 'btn btn-sm btn-outline-primary',
            text: '<i class="fas fa-file-csv"></i> CSV'
          },
          {
            extend: 'excel',
            className: 'btn btn-sm btn-outline-success',
            text: '<i class="fas fa-file-excel"></i> Excel'
          },
          {
            extend: 'pdf',
            className: 'btn btn-sm btn-outline-danger',
            text: '<i class="fas fa-file-pdf"></i> PDF'
          },
          {
            extend: 'print',
            className: 'btn btn-sm btn-outline-info',
            text: '<i class="fas fa-print"></i> Print'
          }
        ],
        responsive: true,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        pageLength: 10,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search...",
          lengthMenu: "Show _MENU_ entries",
          info: "Showing _START_ to _END_ of _TOTAL_ entries",
          infoEmpty: "Showing 0 to 0 of 0 entries",
          infoFiltered: "(filtered from _MAX_ total entries)",
          paginate: {
            first: "First",
            last: "Last",
            next: "Next",
            previous: "Previous"
          }
        },
        initComplete: function() {
          // Add custom styling after initialization
          $('.dataTables_filter input').addClass('form-control form-control-sm');
          $('.dataTables_length select').addClass('form-control form-control-sm');
        }
      });
    });
  </script>
@endsection
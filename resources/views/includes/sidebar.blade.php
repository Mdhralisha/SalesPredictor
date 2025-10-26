  <!-- Main Sidebar -->



  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="../dashboard" class="brand-link text-decoration-none">
      <span class="brand-text font-weight-light">Sales Prediction System</span>
    </a>

    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
          <li class="nav-item">
            <a href="../dashboard" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          @if(Auth::user()->user_role === 'admin')
          <li class="nav-item">
            <a href="../users" class="nav-link">
              <i class="fa-solid fa-circle-user mt-2"></i>
              <p>User Management</p>
            </a>

          </li>
             <li class="nav-item">
            <a href="../vendor" class="nav-link">
              <i class="fa-solid fa-truck-field"></i>
              <p>Vendors Management</p>
            </a>

          </li>
          <li class="nav-item">
            <a href="../category" class="nav-link">
              <i class="fa-solid fa-table-cells-large mt-2"></i>
              <p>Category Management</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../product" class="nav-link">
              <i class="fa-brands fa-product-hunt"></i>
              <p> Product Management</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../customer" class="nav-link">
              <i class="fa-solid fa-users" mt-2></i>
              <p> Customer Management</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../purchase" class="nav-link">
              <i class="fa-solid fa-cart-shopping"></i>
              <p> Purchase Management</p>
            </a>
          </li>
          @endif

       
          <li class="nav-item">
            <a href="../sales" class="nav-link">
              <i class="fas fa-chart-line"></i>
              <p> Sales Management</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../report" class="nav-link">
              <i class="fas fa-chart-bar"></i>
              <p> Report Management</p>
            </a>
          </li>
          <li class="nav-item">
              <a href="../sales-prediction-report" class="nav-link">
                <i class="fas fa-file-alt"></i>
                <p> Sales Prediction Report</p>
              </a>
            </li>
                      <li class="nav-item">
              <a href="../sales-report" class="nav-link">
                <i class="fas fa-file-alt"></i>
                <p> Sales Clustering Report</p>
              </a>
            </li>
        </ul>
      </nav>
    </div>
  </aside>
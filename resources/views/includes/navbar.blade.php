</style>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="../dashboard" class="nav-link">Home</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- User Dropdown Menu -->
    <li class="nav-item dropdown cursor-pointer">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
        <i class="fas fa-user"></i> 
      </a>
      <!-- <div class="dropdown-menu dropdown-menu-right cursor-pointer" aria-labelledby="userDropdown">
        <a class="dropdown-item" style="cursor: pointer;";
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          Logout
        </a>
          <a href="{{ route("changepw") }}" class="dropdown-item " style="cursor: pointer;"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          Change Password
        </a>
        <form id="logout-form" method="POST" style="display: none;">
          @csrf
        </form>
      </div> -->
      <div class="dropdown-menu dropdown-menu-right cursor-pointer" aria-labelledby="userDropdown">
  <!-- Logout -->
  <a class="dropdown-item" href="{{ route('logout') }}"
     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Logout
  </a>

  <!-- Change Password -->
  <a class="dropdown-item" href="{{ route('changepw') }}">
    Change Password
  </a>

  <!-- Hidden Logout Form -->
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
</div>

    </li>
  </ul>
</nav>

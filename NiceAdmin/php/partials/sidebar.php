<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link collapsed" href="dashboard.php">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="view_insights.php">
    <i class="bi bi-bar-chart"></i>
    <span>Insights</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Records</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>

    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="./depenses_view.php">
          <i class="bi bi-circle"></i><span>Expenses</span>
        </a>
      </li>
      <li>
        <a href="./budget_view.php">
          <i class="bi bi-circle"></i><span>Budget</span>
        </a>
      </li>
    </ul>

  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-text"></i><span>Declaration</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="b_salsaire_input.php">
          <i class="bi bi-circle"></i><span>Income</span>
        </a>
      </li>
      <li>
        <a href="./depenses_add.php">
          <i class="bi bi-circle"></i><span>expenses</span>
        </a>
      </li>
      <li>
        <a href="./b_epargne_input.php">
          <i class="bi bi-circle"></i><span>Savings</span>
        </a>
      </li>
    </ul>

  </li>

</ul>

</aside>

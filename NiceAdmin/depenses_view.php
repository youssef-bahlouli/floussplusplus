<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username = $_SESSION["username"];
  
  $pageTitle = 'Expenses';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';

  require 'php/get_tables.php';
  require 'php/get_info.php';
  require 'php/components/helpers.php';
  $connexion = get_con_var();
  $rows = iterator_to_array(get_depenses_table($connexion, $username));

  $sort = $_GET['sort'] ?? 'asc';

  // Collect paycheck event timestamps to group records by period
  $salaryTimes = [];
  $salaryCursor = $connexion->logs->find(
    ['username' => $username, 'action' => ['$in' => ['receive_salary', 'add_salaire']]],
    ['sort' => ['_id' => 1]]
  );
  foreach ($salaryCursor as $ev) {
    if ($ev['created_at'] instanceof MongoDB\BSON\UTCDateTime) {
      $salaryTimes[] = $ev['created_at']->toDateTime()->getTimestamp();
    }
  }

  // For each expense row, determine its period group index
  $rowPeriod = [];
  foreach ($rows as $r) {
    $rTime = strtotime($r['ddate'] ?? '');
    $group = 0;
    foreach ($salaryTimes as $st) {
      if ($rTime && $rTime >= $st) $group++;
    }
    $rowPeriod[] = $group;
  }

  if ($sort === 'desc') {
    $rows = array_reverse($rows);
    $rowPeriod = array_reverse($rowPeriod);
  }
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Expenses</h1>
      <?= ui_breadcrumb([
        ['label' => 'Home', 'url' => 'dashboard.php'],
        ['label' => 'Expenses'],
        ['label' => 'Expenses', 'active' => true],
      ]) ?>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-12">
          <?= new Card([
            'title' => 'Expense Overview',
            'slot' =>
              '<div class="d-flex align-items-center justify-content-between mb-2">
                <span></span>
                <a href="?sort=' . ($sort === 'asc' ? 'desc' : 'asc') . '" class="btn btn-sm btn-outline-secondary">
                  <i class="bi bi-arrow-up-short"></i>
                  ' . ($sort === 'asc' ? 'Oldest first' : 'Newest first') . '
                  <i class="bi bi-arrow-down-short"></i>
                </a>
              </div>
              <div class="table-responsive">' .
              new Table([
                'class' => 'table-sm align-middle mb-0',
                'columns' => [
                  ['key' => '_id', 'label' => '#'],
                  ['key' => 'nom', 'label' => 'Name'],
                  ['key' => 'description', 'label' => 'Description'],
                  ['key' => 'type', 'label' => 'Type'],
                  ['key' => 'prix', 'label' => 'Price'],
                  ['key' => 'quantite', 'label' => 'Qty'],
                  ['key' => 'ddate', 'label' => 'Date'],
                ],
                'rows' => $rows,
                'rowAttr' => fn($row, $idx) =>
                  ($idx > 0 && $rowPeriod[$idx] !== $rowPeriod[$idx - 1])
                    ? ['style' => 'border-top: 3px solid rgba(33,37,41,0.75);']
                    : [],
                'renderers' => [
                  '_id' => fn($v) => '<span class="text-muted small">' . htmlspecialchars(substr((string)$v, -6), ENT_QUOTES) . '</span>',
                  'nom' => fn($v) => '<span class="fw-medium" style="max-width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; display:inline-block;">' . htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8') . '</span>',
                  'description' => fn($v) => '<span class="text-secondary">' . htmlspecialchars(mb_substr($v ?? '', 0, 8), ENT_QUOTES, 'UTF-8') . (mb_strlen($v ?? '') > 8 ? '…' : '') . '</span>',
                  'type' => fn($v) => match ($v) {
                    'produits' => '<span class="badge bg-info-subtle text-info-emphasis">Products</span>',
                    'services' => '<span class="badge bg-primary-subtle text-primary-emphasis">Services</span>',
                    'taxes' => '<span class="badge bg-warning-subtle text-warning-emphasis">Taxes</span>',
                    default => '<span class="badge bg-secondary-subtle text-secondary-emphasis">' . htmlspecialchars($v ?? '', ENT_QUOTES) . '</span>',
                  },
                  'prix' => fn($v) => '<span class="fw-semibold">' . format_money((float)$v) . '</span>',
                  'quantite' => fn($v) => '<span class="badge bg-dark-subtle text-dark-emphasis rounded-pill">x' . (int)$v . '</span>',
                  'ddate' => fn($v) => '<span class="text-nowrap small">' . htmlspecialchars(date('d/m/Y H:i', strtotime($v ?? '')), ENT_QUOTES) . '</span>',
                ],
              ]) .
              '</div>',
          ]) ?>
        </div>
      </div>
    </section>

  </main>

  <?php require 'php/partials/footer.php'; ?>

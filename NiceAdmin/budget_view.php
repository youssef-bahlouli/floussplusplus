<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username = $_SESSION["username"];
  
  $pageTitle = 'Budget';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';

  require 'php/get_tables.php';
  require 'php/get_info.php';
  require 'php/components/helpers.php';
  $connexion = get_con_var();
  $rows = get_budget_table($connexion, $username);

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

  // For each budget row, determine its period group index
  $rowPeriod = [];
  foreach ($rows as $r) {
    $rTime = 0;
    if (isset($r['created_at']) && $r['created_at'] instanceof MongoDB\BSON\UTCDateTime) {
      $rTime = $r['created_at']->toDateTime()->getTimestamp();
    }
    $group = 0;
    foreach ($salaryTimes as $st) {
      if ($rTime >= $st) $group++;
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
      <h1>Budget</h1>
      <?= ui_breadcrumb([
        ['label' => 'Home', 'url' => 'dashboard.php'],
        ['label' => 'Records'],
        ['label' => 'Budget', 'active' => true],
      ]) ?>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-12">
          <?= new Card([
            'title' => 'Budget Overview',
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
                  ['key' => 'salaire', 'label' => 'Salary'],
                  ['key' => 'rest_du_cheque_final', 'label' => 'Rest'],
                  ['key' => 'epargne', 'label' => 'Savings'],
                  ['key' => 'Budget', 'label' => 'Budget'],
                  ['key' => 'created_at', 'label' => 'Date'],
                ],
                'rows' => $rows,
                'rowAttr' => fn($row, $idx) =>
                  ($idx > 0 && $rowPeriod[$idx] !== $rowPeriod[$idx - 1])
                    ? ['style' => 'border-top: 3px solid rgba(33,37,41,0.75);']
                    : [],
                'renderers' => [
                  'salaire' => function($v, $row, $idx) use ($rows) {
                    $prev = $idx > 0 ? ($rows[$idx - 1]['salaire'] ?? 0) : null;
                    $html = '<span class="fw-semibold">' . format_money((float)$v) . '</span>';
                    if ($prev !== null) {
                      $d = (float)$v - (float)$prev;
                      if ($d > 0) $html .= ' <span class="badge bg-success-subtle text-success-emphasis rounded-pill" title="+' . number_format($d, 2) . '">↑</span>';
                      elseif ($d < 0) $html .= ' <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill" title="' . number_format($d, 2) . '">↓</span>';
                      else $html .= ' <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill">—</span>';
                    }
                    return $html;
                  },
                  'rest_du_cheque_final' => function($v, $row, $idx) use ($rows) {
                    $prev = $idx > 0 ? ($rows[$idx - 1]['rest_du_cheque_final'] ?? 0) : null;
                    $html = '<span class="text-primary fw-medium">' . format_money((float)$v) . '</span>';
                    if ($prev !== null) {
                      $d = (float)$v - (float)$prev;
                      if ($d > 0) $html .= ' <span class="badge bg-success-subtle text-success-emphasis rounded-pill" title="+' . number_format($d, 2) . '">↑</span>';
                      elseif ($d < 0) $html .= ' <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill" title="' . number_format($d, 2) . '">↓</span>';
                      else $html .= ' <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill">—</span>';
                    }
                    return $html;
                  },
                  'epargne' => function($v, $row, $idx) use ($rows) {
                    $prev = $idx > 0 ? ($rows[$idx - 1]['epargne'] ?? 0) : null;
                    $html = '<span class="text-warning fw-medium">' . format_money((float)$v) . '</span>';
                    if ($prev !== null) {
                      $d = (float)$v - (float)$prev;
                      if ($d > 0) $html .= ' <span class="badge bg-success-subtle text-success-emphasis rounded-pill" title="+' . number_format($d, 2) . '">↑</span>';
                      elseif ($d < 0) $html .= ' <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill" title="' . number_format($d, 2) . '">↓</span>';
                      else $html .= ' <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill">—</span>';
                    }
                    return $html;
                  },
                  'Budget' => function($v, $row, $idx) use ($rows) {
                    $prev = $idx > 0 ? ((float)($rows[$idx - 1]['rest_du_cheque_final'] ?? 0) + (float)($rows[$idx - 1]['epargne'] ?? 0)) : null;
                    $now = (float)$v;
                    $html = '<span class="badge bg-success fs-6 px-2 py-1">' . format_money($now, 0) . '</span>';
                    if ($prev !== null) {
                      $d = $now - $prev;
                      if ($d > 0) $html .= ' <span class="badge bg-success-subtle text-success-emphasis rounded-pill" title="+' . number_format($d, 2) . '">↑</span>';
                      elseif ($d < 0) $html .= ' <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill" title="' . number_format($d, 2) . '">↓</span>';
                      else $html .= ' <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill">—</span>';
                    }
                    return $html;
                  },
                  'created_at' => fn($v) => $v instanceof MongoDB\BSON\UTCDateTime
                    ? '<span class="text-nowrap small text-muted">' . $v->toDateTime()->format('d/m/Y H:i') . '</span>'
                    : '<span class="text-muted small">—</span>',
                ],
              ]) .
              '</div>',
          ]) ?>
        </div>
      </div>
    </section>

  </main>

  <?php require 'php/partials/footer.php'; ?>

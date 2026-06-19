<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];
  require 'php/get_tables.php';
  require 'php/get_info.php';
  require 'php/analyse.php';
  require 'php/services/LogService.php';
  require 'php/components/helpers.php';
  $connexion = get_con_var();
  $pageTitle = 'Insights';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';

  $budgetData = get_budget_table($connexion, $username);
  $numBudget = count($budgetData);
  $depensesByOccurrence = iterator_to_array(get_depenses_table_ord_occurr($connexion, $username));
  $allDepenses = iterator_to_array(get_depenses_table($connexion, $username));
  $topExpenses = get_top_expenses($connexion, $username);
  $analyse = new Analyse();
  $analyse->set_depenses_statistics($username, $allDepenses);

  $topNames = array_column($topExpenses, 'nom');
  $topTotals = array_column($topExpenses, 'total');

  $savingsRate = 0;
  if ($numBudget > 0) {
    $latest = $budgetData[$numBudget - 1];
    if ((float)$latest['salaire'] > 0) {
      $savingsRate = round((float)$latest['epargne'] / (float)$latest['salaire'] * 100, 1);
    }
  }

  $incomeLogs = iterator_to_array(get_logs_by_type($username, 'income'));
  $numIncome = count($incomeLogs);

  $selectedPeriod = $_GET['period'] ?? '';
  $periods = [];
  $periodBreakdown = [];

  $salaryEventsCursor = $connexion->logs->find(
    ['username' => $username, 'action' => ['$in' => ['receive_salary', 'add_salaire']]],
    ['sort' => ['_id' => 1]]
  );
  $salaryEvents = iterator_to_array($salaryEventsCursor);

  $periodBoundaries = [];
  foreach ($salaryEvents as $ev) {
    if ($ev['created_at'] instanceof MongoDB\BSON\UTCDateTime) {
      $periodBoundaries[] = $ev['created_at']->toDateTime();
    }
  }

  if (empty($periodBoundaries)) {
    $periods['all'] = ['label' => 'All time', 'total' => 0.0];
    foreach ($allDepenses as $exp) {
      $periods['all']['total'] += (float)$exp['prix'] * (int)($exp['quantite'] ?? 1);
    }
    $selectedPeriod = 'all';
    foreach ($allDepenses as $exp) {
      $name = $exp['nom'] ?? 'Unknown';
      if (!isset($periodBreakdown[$name])) {
        $periodBreakdown[$name] = ['count' => 0, 'total' => 0.0];
      }
      $periodBreakdown[$name]['count'] += (int)($exp['quantite'] ?? 1);
      $periodBreakdown[$name]['total'] += (float)$exp['prix'] * (int)($exp['quantite'] ?? 1);
    }
  } else {
    $now = new DateTime();
    $first = $periodBoundaries[0];
    $periods['pre_' . $first->format('Ymd_His')] = [
      'start' => null, 'end' => $first,
      'label' => 'Before ' . $first->format('d/m/Y H:i'), 'total' => 0.0
    ];
    for ($i = 0; $i < count($periodBoundaries); $i++) {
      $start = $periodBoundaries[$i];
      $end = ($i + 1 < count($periodBoundaries)) ? $periodBoundaries[$i + 1] : $now;
      $periods['p_' . $start->format('Ymd_His')] = [
        'start' => $start, 'end' => $end,
        'label' => $start->format('d/m/Y H:i'), 'total' => 0.0
      ];
    }

    foreach ($allDepenses as $exp) {
      $expTime = strtotime($exp['ddate'] ?? '');
      if (!$expTime) continue;
      $expDt = (new DateTime())->setTimestamp($expTime);
      foreach ($periods as $key => &$p) {
        if ($p['start'] === null && $expDt < $p['end']) {
          $p['total'] += (float)$exp['prix'] * (int)($exp['quantite'] ?? 1);
          break;
        } elseif ($p['start'] !== null && $expDt >= $p['start'] && $expDt < $p['end']) {
          $p['total'] += (float)$exp['prix'] * (int)($exp['quantite'] ?? 1);
          break;
        }
      }
      unset($p);
  }

  if ($selectedPeriod && isset($periods[$selectedPeriod])) {
      // user's selection — keep it
    } else {
      // default to the last period with expenses
      $keys = array_keys($periods);
      $selectedPeriod = array_key_last($periods);
      for ($i = count($keys) - 1; $i >= 0; $i--) {
        if (($periods[$keys[$i]]['total'] ?? 0) > 0) {
          $selectedPeriod = $keys[$i];
          break;
        }
      }
    }

    if (isset($periods[$selectedPeriod])) {
      $sel = $periods[$selectedPeriod];
      foreach ($allDepenses as $exp) {
        $expTime = strtotime($exp['ddate'] ?? '');
        if (!$expTime) continue;
        $expDt = (new DateTime())->setTimestamp($expTime);
        $inPeriod = false;
        if ($sel['start'] === null && $expDt < $sel['end']) $inPeriod = true;
        elseif ($sel['start'] !== null && $expDt >= $sel['start'] && $expDt < $sel['end']) $inPeriod = true;
        if (!$inPeriod) continue;
        $name = $exp['nom'] ?? 'Unknown';
        if (!isset($periodBreakdown[$name])) {
          $periodBreakdown[$name] = ['count' => 0, 'total' => 0.0];
        }
        $periodBreakdown[$name]['count'] += (int)($exp['quantite'] ?? 1);
        $periodBreakdown[$name]['total'] += (float)$exp['prix'] * (int)($exp['quantite'] ?? 1);
      }
      uasort($periodBreakdown, fn($a, $b) => $b['total'] <=> $a['total']);
    }
  }

  // Build per-paycheck expense data for the trend chart.
  // Uses the same $periods totals (already computed) filtered to non-zero,
  // then reversed to show newest first (matching Reserved Amount chart).
  $expensePeriodLabels = [];
  $expensePeriodTotals = [];
  foreach ($periods as $key => $p) {
    $total = is_array($p) ? ($p['total'] ?? 0) : (float)$p;
    if ($total <= 0) continue;
    $label = is_array($p) ? ($p['label'] ?? $key) : $key;
    // Strip time from label for chart x-axis brevity
    $short = explode(' ', $label)[0] ?? $label;
    $expensePeriodLabels[] = $short;
    $expensePeriodTotals[] = $total;
  }
  $expensePeriodLabels = array_reverse($expensePeriodLabels);
  $expensePeriodTotals = array_reverse($expensePeriodTotals);
?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Insights</h1>
      <?= ui_breadcrumb([
        ['label' => 'Home', 'url' => 'dashboard.php'],
        ['label' => 'Insights', 'active' => true],
      ]) ?>
    </div>

    <ul class="nav nav-tabs mb-4" id="insightsTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
          <i class="bi bi-graph-up me-1"></i> All
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="advanced-tab" data-bs-toggle="tab" data-bs-target="#advanced" type="button" role="tab" aria-controls="advanced" aria-selected="false">
          <i class="bi bi-table me-1"></i> Advanced
        </button>
      </li>
    </ul>

    <div class="tab-content" id="insightsTabsContent">

      <!-- ==================== ALL TAB ==================== -->
      <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
        <section class="section dashboard">
          <div class="row">

            <div class="col-lg-8">
              <div class="row">

                <div class="col-12">
                  <?php
                    $savingsChanges = [];
                    $savingsLabels = [];
                    $salaryBudgetIdxs = [];
                    foreach ($salaryEvents as $log) {
                      $logTime = isset($log['created_at']) && $log['created_at'] instanceof MongoDB\BSON\UTCDateTime
                        ? $log['created_at']->toDateTime()->getTimestamp() : 0;
                      $matchIdx = -1;
                      foreach ($budgetData as $j => $b) {
                        $bTime = isset($b['created_at']) && $b['created_at'] instanceof MongoDB\BSON\UTCDateTime
                          ? $b['created_at']->toDateTime()->getTimestamp() : 0;
                        if ($bTime <= $logTime) {
                          $matchIdx = $j;
                        }
                      }
                      if ($matchIdx < 0) continue;
                      $salaryBudgetIdxs[] = $matchIdx;
                      $savingsLabels[] = $logTime > 0 ? date('d/m', $logTime) : '?';
                    }

                    for ($i = 0; $i < count($salaryBudgetIdxs); $i++) {
                      $curEpargne = (float)($budgetData[$salaryBudgetIdxs[$i]]['epargne'] ?? 0);
                      if ($i === 0) {
                        $prevIdx = $salaryBudgetIdxs[$i] > 0 ? $salaryBudgetIdxs[$i] - 1 : 0;
                        $savingsChanges[] = $curEpargne - (float)($budgetData[$prevIdx]['epargne'] ?? 0);
                      } else {
                        $prevEpargne = (float)($budgetData[$salaryBudgetIdxs[$i - 1]]['epargne'] ?? 0);
                        $savingsChanges[] = $curEpargne - $prevEpargne;
                      }
                    }

                    $savingsChanges = array_reverse($savingsChanges);
                    $savingsLabels = array_reverse($savingsLabels);

                    $numPayments = count($salaryEvents);
                    echo new Card([
                      'title' => 'Per-Paycheck Net Result (' . $numPayments . ' payments) — green = saved, red = from savings',
                      'slot' => '<div id="savingsChangeChart">' .
                        ($numPayments === 0
                          ? '<div class="alert alert-info mb-0"><i class="bi bi-info-circle me-1"></i> No payments recorded yet.</div>'
                          : '<script>
                            document.addEventListener("DOMContentLoaded", () => {
                              new ApexCharts(document.querySelector("#savingsChangeChart"), {
                                series: [{
                                  name: "Savings change",
                                  data: [' . implode(',', $savingsChanges) . ']
                                }],
                                chart: { height: 350, type: "bar", zoom: { enabled: true } },
                                plotOptions: { bar: { borderRadius: 4, columnWidth: "60%" } },
                                dataLabels: { enabled: true,
                                  formatter: v => v + " ' . currency_symbol() . '",
                                  style: { colors: ["#333"] }
                                },
                                colors: [function({ value }) { return value >= 0 ? "#2eca6a" : "#e74c3c"; }],
                                xaxis: { categories: ' . json_encode($savingsLabels) . ' },
                                yaxis: { title: { text: "Change (' . currency_symbol() . ')" } },
                                tooltip: { y: { formatter: v => v + " ' . currency_symbol() . '" } }
                              }).render();
                            });
                          </script>') .
                        '</div>',
                    ]);
                  ?>
                </div>

                <div class="col-12">
                  <?php
                    $hasExpensePeriods = count(array_filter($expensePeriodTotals, fn($v) => $v > 0)) > 0;
                    echo new Card([
                      'title' => 'Expenses Per Paycheck',
                      'slot' => '<div id="expensePerPeriodChart"><br><br>' .
                        (!$hasExpensePeriods
                          ? 'No expenses recorded yet.'
                          : '<script>
                            document.addEventListener("DOMContentLoaded", () => {
                              new ApexCharts(document.querySelector("#expensePerPeriodChart"), {
                                series: [{
                                  name: "Total spent",
                                  data: [' . implode(',', $expensePeriodTotals) . ']
                                }],
                                chart: { height: 350, type: "bar", toolbar: { show: true } },
                                plotOptions: { bar: { borderRadius: 4, columnWidth: "60%" } },
                                colors: ["#e74c3c"],
                                xaxis: { categories: ' . json_encode($expensePeriodLabels) . ' },
                                yaxis: { title: { text: "Amount (' . currency_symbol() . ')" } },
                                tooltip: { y: { formatter: v => v + " ' . currency_symbol() . '" } }
                              }).render();
                            });
                          </script>'),
                    ]);
                  ?>
                </div>

                <div class="col-12">
                  <?= new Card([
                    'title' => 'Budget Report',
                    'slot' => '<br>' .
                      ($numBudget === 0
                        ? $numBudget . ' entries recorded.'
                        : '<div id="reportsChart"></div>
                          <script>
                            document.addEventListener("DOMContentLoaded", () => {
                              new ApexCharts(document.querySelector("#reportsChart"), {
                                series: [{
                                  name: "Final check balance",
                                  data: [' . implode(',', array_map(fn($a) => $a['rest_du_cheque_final'], array_slice($budgetData, 1))) . ']
                                }, {
                                  name: "Savings",
                                  data: [' . implode(',', array_map(fn($a) => $a['epargne'], array_slice($budgetData, 1))) . ']
                                }, {
                                  name: "Salary",
                                  data: [' . implode(',', array_map(fn($a) => $a['salaire'], array_slice($budgetData, 1))) . ']
                                }],
                                chart: { height: 500, type: "area", toolbar: { show: true } },
                                markers: { size: 4 },
                                colors: ["#4154f1", "#2eca6a", "#ff771d"],
                                fill: { type: "gradient", gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.4, stops: [0, 90, 100] } },
                                dataLabels: { enabled: false },
                                stroke: { curve: "smooth", width: 2 },
                                xaxis: { type: "number", categories: ' . json_encode(range(1, $numBudget - 1)) . ' },
                                tooltip: { x: { format: "dd/MM/yy HH:mm" } }
                              }).render();
                            });
                          </script>'),
                  ]) ?>
                </div>

                <div class="col-12">
                  <?= new Card([
                    'title' => 'Top Expenses by Total Cost | ' . htmlspecialchars(get_fullname($username), ENT_QUOTES, 'UTF-8'),
                    'slot' => '<div id="topExpensesChart"><br><br>' .
                      (count($topExpenses) === 0
                        ? 'No expenses recorded yet.'
                        : '<script>
                          document.addEventListener("DOMContentLoaded", () => {
                            new ApexCharts(document.querySelector("#topExpensesChart"), {
                              series: [{
                                name: "Total cost",
                                data: [' . implode(',', $topTotals) . ']
                              }],
                              chart: { height: 350, type: "bar", toolbar: { show: true } },
                              plotOptions: { bar: { horizontal: true, borderRadius: 4 } },
                              colors: ["#4154f1"],
                              xaxis: { categories: ' . json_encode($topNames) . ' },
                              yaxis: { title: { text: "Amount (' . currency_symbol() . ')" } },
                              tooltip: { y: { formatter: v => v + " ' . currency_symbol() . '" } }
                            }).render();
                          });
                        </script>'),
                  ]) ?>
                </div>

                <div class="col-12">
                  <?php
                    echo new Card([
                      'title' => 'Most frequent expenses. | of ' . htmlspecialchars(get_fullname($username), ENT_QUOTES, 'UTF-8'),
                      'slot' => new Table([
                        'columns' => [
                          ['key' => 'nom', 'label' => 'Name'],
                          ['key' => 'occurrences', 'label' => 'Occurrences'],
                        ],
                        'rows' => $depensesByOccurrence,
                        'striped' => false,
                      ]),
                    ]);
                  ?>
                </div>

              </div>
            </div>

            <div class="col-lg-4">

              <?php if ($numBudget > 0): ?>
              <?= new Card([
                'title' => 'Savings Rate',
                'slot' => '<div class="text-center py-2">
                  <h2 class="fw-bold text-success">' . $savingsRate . '%</h2>
                  <p class="text-muted mb-0"><small>of income saved</small></p>
                  <hr class="my-2">
                  <div class="row g-1">
                    <div class="col-6">
                      <small class="text-muted">Income</small>
                      <h6>' . format_money((float)$latest['salaire'], 0) . '</h6>
                    </div>
                    <div class="col-6">
                      <small class="text-muted">Saved</small>
                      <h6>' . format_money((float)$latest['epargne'], 0) . '</h6>
                    </div>
                  </div>
                </div>',
              ]) ?>
              <?php endif; ?>

              <?= new Card([
                'title' => 'Expense Statistics',
                'slot' => '<div id="trafficChart" style="min-height:250px" class="echart"></div>
                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      echarts.init(document.querySelector("#trafficChart")).setOption({
                        tooltip: { trigger: "item" },
                        legend: { top: "5%", left: "center" },
                        series: [{
                          name: "Expenses",
                          type: "pie",
                          radius: ["40%", "70%"],
                          avoidLabelOverlap: false,
                          label: { show: false, position: "center" },
                          emphasis: { label: { show: true, fontSize: "14", fontWeight: "bold" } },
                          labelLine: { show: false },
                          data: [
                            { value: ' . $analyse->get_nbr_of_products() . ', name: "Products" },
                            { value: ' . $analyse->get_nbr_of_services() . ', name: "Services" },
                            { value: ' . $analyse->get_nbr_of_taxes() . ', name: "Taxes" },
                          ]
                        }]
                      });
                    });
                  </script>',
              ]) ?>

              <?= new ActivityLog([
                'logs' => get_logs($username),
                'title' => 'Recent Activity',
              ]) ?>

            </div>

          </div>
        </section>
      <!-- ==================== ADVANCED TAB ==================== -->
      <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
        <section class="section">
          <div class="row">
            <div class="col-12">

              <?php
                $hasPeriodExpenses = false;
                foreach ($periods as $p) {
                  $t = is_array($p) ? ($p['total'] ?? 0) : (float)$p;
                  if ($t > 0) { $hasPeriodExpenses = true; break; }
                }
              ?>
              <?php if (empty($periods) || !$hasPeriodExpenses): ?>
                <div class="alert alert-info">
                  <i class="bi bi-info-circle me-1"></i> No expenses recorded yet.
                </div>
              <?php else: ?>
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Expense Breakdown by Pay Period</h5>
                    <p class="text-muted small">Periods are defined by each salary receipt. Select a period to see what was spent.</p>

                    <form method="get" action="" class="row g-3 mb-3">
                      <div class="col-auto">
                        <label for="periodSelect" class="col-form-label">Period:</label>
                      </div>
                      <div class="col-auto">
                        <select class="form-select" name="period" id="periodSelect">
                          <?php foreach ($periods as $p => $data): ?>
                            <?php $total = is_array($data) ? ($data['total'] ?? 0) : (float)$data; ?>
                            <?php if ($total == 0) continue; ?>
                            <?php $label = is_array($data) ? ($data['label'] ?? $p) : 'All time'; ?>
                            <option value="<?= htmlspecialchars($p, ENT_QUOTES) ?>"<?= $p === $selectedPeriod ? ' selected' : '' ?>>
                              <?= htmlspecialchars($label, ENT_QUOTES) ?>
                              — <?= format_money((float)$total) ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col-auto">
                        <noscript><button type="submit" class="btn btn-primary">Go</button></noscript>
                      </div>
                    </form>

                    <div id="periodBreakdownContainer">
                      <?php if (!empty($periodBreakdown)): ?>
                        <div class="table-responsive">
                          <table class="table table-sm align-middle mb-0">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Expense</th>
                                <th>Times Bought</th>
                                <th>Total Cost</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $idx = 1; ?>
                              <?php foreach ($periodBreakdown as $name => $data): ?>
                                <tr>
                                  <td class="text-muted small"><?= $idx++ ?></td>
                                  <td class="fw-medium"><?= htmlspecialchars($name, ENT_QUOTES) ?></td>
                                  <td>
                                    <span class="badge bg-dark-subtle text-dark-emphasis rounded-pill">x<?= $data['count'] ?></span>
                                  </td>
                                  <td class="fw-semibold"><?= format_money((float)$data['total']) ?></td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                              <tr class="table-active">
                                <td></td>
                                <td class="fw-bold">Total</td>
                                <td class="fw-bold"><?= array_sum(array_column($periodBreakdown, 'count')) ?> items</td>
                                <td class="fw-bold"><?= format_money((float)array_sum(array_column($periodBreakdown, 'total'))) ?></td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      <?php else: ?>
                        <div class="alert alert-info mb-0">
                          <i class="bi bi-info-circle me-1"></i> No expenses found for this period.
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

            </div>
          </div>
        </section>
      </div>

    </div>

  </main>

  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll('#insightsTabs .nav-link');
    const hash = location.hash.replace('#', '');

    // Restore active tab from hash
    if (hash) {
      const target = document.querySelector(`[data-bs-target="${hash}"]`);
      if (target) {
        bootstrap.Tab.getOrCreateInstance(target).show();
      }
    }

    // Save active tab to hash on change
    tabs.forEach(t => {
      t.addEventListener('shown.bs.tab', () => {
        location.hash = t.getAttribute('data-bs-target');
      });
    });

    // Period select -> live AJAX update
    const sel = document.getElementById('periodSelect');
    const container = document.getElementById('periodBreakdownContainer');
    if (sel && container) {
      sel.addEventListener('change', () => {
        const url = new URL(window.location.href);
        url.searchParams.set('period', sel.value);
        fetch(url.toString())
          .then(r => r.text())
          .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContent = doc.getElementById('periodBreakdownContainer');
            if (newContent) {
              container.innerHTML = newContent.innerHTML;
            }
          });
      });
    }
  });
  </script>

  <?php require 'php/partials/footer.php'; ?>

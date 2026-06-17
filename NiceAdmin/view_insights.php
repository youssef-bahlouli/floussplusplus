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

  $bagData = iterator_to_array(get_bag_table($connexion, $username));
  $numBag = count($bagData);
  $budgetData = get_budget_table($connexion, $username);
  $numBudget = count($budgetData);
  $depensesByOccurrence = iterator_to_array(get_depenses_table_ord_occurr($connexion, $username));
  $allDepenses = iterator_to_array(get_depenses_table($connexion, $username));
  $monthlyExpenses = get_monthly_expenses($connexion, $username);
  $topExpenses = get_top_expenses($connexion, $username);
  $analyse = new Analyse();
  $analyse->set_depenses_statistics($username, $allDepenses);

  $monthLabels = array_column($monthlyExpenses, '_id');
  $monthTotals = array_column($monthlyExpenses, 'total');
  $topNames = array_column($topExpenses, 'nom');
  $topTotals = array_column($topExpenses, 'total');

  $savingsRate = 0;
  if ($numBudget > 0) {
    $latest = $budgetData[$numBudget - 1];
    if ((float)$latest['salaire'] > 0) {
      $savingsRate = round((float)$latest['epargne'] / (float)$latest['salaire'] * 100, 1);
    }
  }
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Insights</h1>
      <?= ui_breadcrumb([
        ['label' => 'Home', 'url' => 'dashboard.php'],
        ['label' => 'Insights', 'active' => true],
      ]) ?>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="col-lg-8">
          <div class="row">

            <div class="col-12">
              <?= new Card([
                'title' => 'Reserved Amount Per Payment',
                'slot' => '<div id="lineChart"><br><br>' .
                  ($numBag === 0
                    ? $numBag . ' payments processed.'
                    : '<script>
                      document.addEventListener("DOMContentLoaded", () => {
                        new ApexCharts(document.querySelector("#lineChart"), {
                          series: [{
                            name: "Reserved amount at each payment",
                            data: [' . implode(',', array_map(fn($a) => $a['value'], $bagData)) . ']
                          }],
                          chart: { height: 350, type: "bar", zoom: { enabled: true } },
                          dataLabels: { enabled: true },
                          stroke: { curve: "straight" },
                          grid: { row: { colors: ["#f3f3f3", "transparent"], opacity: 0.5 } },
                          xaxis: { categories: ' . json_encode(range(1, $numBag)) . ' }
                        }).render();
                      });
                    </script>') . '</div>',
              ]) ?>
            </div>

            <div class="col-12">
              <?= new Card([
                'title' => 'Monthly Expense Trend',
                'slot' => '<div id="monthlyExpenseChart"><br><br>' .
                  (count($monthlyExpenses) === 0
                    ? 'No expenses recorded yet.'
                    : '<script>
                      document.addEventListener("DOMContentLoaded", () => {
                        new ApexCharts(document.querySelector("#monthlyExpenseChart"), {
                          series: [{
                            name: "Total spent",
                            data: [' . implode(',', $monthTotals) . ']
                          }],
                          chart: { height: 350, type: "line", toolbar: { show: true } },
                          stroke: { curve: "smooth", width: 2 },
                          markers: { size: 4 },
                          colors: ["#e74c3c"],
                          xaxis: { categories: ' . json_encode($monthLabels) . ' },
                          yaxis: { title: { text: "Amount (MAD)" } },
                          tooltip: { y: { formatter: v => v + " MAD" } }
                        }).render();
                      });
                    </script>'),
              ]) ?>
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
                              data: [' . implode(',', array_map(fn($a) => $a['rest_du_cheque_final'], $budgetData)) . ']
                            }, {
                              name: "Savings",
                              data: [' . implode(',', array_map(fn($a) => $a['epargne'], $budgetData)) . ']
                            }, {
                              name: "Salary",
                              data: [' . implode(',', array_map(fn($a) => $a['salaire'], $budgetData)) . ']
                            }],
                            chart: { height: 500, type: "area", toolbar: { show: true } },
                            markers: { size: 4 },
                            colors: ["#4154f1", "#2eca6a", "#ff771d"],
                            fill: { type: "gradient", gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.4, stops: [0, 90, 100] } },
                            dataLabels: { enabled: false },
                            stroke: { curve: "smooth", width: 2 },
                            xaxis: { type: "number", categories: ' . json_encode(range(1, $numBudget)) . ' },
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
                          yaxis: { title: { text: "Amount (MAD)" } },
                          tooltip: { y: { formatter: v => v + " MAD" } }
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
                  <h6>' . number_format((float)$latest['salaire'], 0) . ' MAD</h6>
                </div>
                <div class="col-6">
                  <small class="text-muted">Saved</small>
                  <h6>' . number_format((float)$latest['epargne'], 0) . ' MAD</h6>
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

  </main>

  <?php require 'php/partials/footer.php'; ?>

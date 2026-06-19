<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];
  require 'php/get_tables.php';
  require 'php/get_info.php';
  require 'php/analyse.php';
  require 'php/components/helpers.php';
  $pageTitle = 'Dashboard';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';

  $l = get_budget($username);
  $salaire = $l ? $l['salaire'] : 0;
  $reste = $l ? $l['rest_du_cheque_final'] : 0;
  $epargne = $l ? $l['epargne'] : 0;
  $pct = ($salaire > 0) ? number_format(($reste / $salaire) * 100, 2) : 0;
  $connexion = get_con_var();
  $depenses = iterator_to_array(get_depenses_table($connexion, $username));
  $analyse = new Analyse();
  $analyse->set_depenses_statistics($username, $depenses);
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <?= ui_breadcrumb([
        ['label' => 'Home', 'url' => 'dashboard.php'],
        ['label' => 'Dashboard', 'active' => true],
      ]) ?>
    </div>

    <section class="section dashboard">
      <div class="row">

        <div class="col-lg-8">
          <div class="row">

            <?= ui_statsgrid([
              'salaire' => $salaire,
              'reste' => $reste,
              'epargne' => $epargne,
              'pct' => $pct,
            ]) ?>

            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Latest Expenses <span>| Today</span></h5>
                  <?php
                    $rows = array_slice($depenses, 0, 5);
                    echo new Table([
                      'columns' => [
                        ['key' => '_idx', 'label' => '#'],
                        ['key' => 'nom', 'label' => 'Name'],
                        ['key' => 'type', 'label' => 'Type'],
                        ['key' => 'prix', 'label' => 'Price'],
                        ['key' => 'quantite', 'label' => 'Quantity'],
                      ],
                      'rows' => $rows,
                      'renderers' => [
                        '_idx' => fn($v, $row, $idx) => $idx + 1,
                        'prix' => fn($v) => format_money((float)$v),
                        'quantite' => fn($v) => '<span class="badge bg-primary">' . (int)$v . '</span>',
                      ],
                    ]);
                  ?>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-lg-4">

          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title">Budget Report <span>| of <?= htmlspecialchars(get_fullname($username), ENT_QUOTES, 'UTF-8') ?></span></h5>
              <div id="budgetChart" style="min-height: 400px;" class="echart"></div>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#budgetChart")).setOption({
                    legend: { data: ['Revenue', 'Savings'] },
                    radar: {
                      indicator: [
                        { name: 'Amount', max: <?= give_max($l) ?> },
                        { name: 'Administration', max: 16000 },
                        { name: 'Information Technology', max: 30000 },
                        { name: 'Customer Support', max: 38000 },
                        { name: 'Development', max: 52000 },
                        { name: 'Marketing', max: 25000 },
                      ]
                    },
                    series: [{
                      name: 'Budget vs spending',
                      type: 'radar',
                      data: [
                        { value: [<?= $reste ?>, 3000, 20000, 35000, 50000, 18000], name: 'Revenue' },
                        { value: [<?= $epargne ?>, 14000, 28000, 26000, 42000, 21000], name: 'Savings' },
                      ]
                    }]
                  });
                });
              </script>
            </div>
          </div>

          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title">Expense Statistics <span>| ...</span></h5>
              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: { trigger: 'item' },
                    legend: { top: '5%', left: 'center' },
                    series: [{
                      name: 'Expenses',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: false,
                      label: { show: false, position: 'center' },
                      emphasis: { label: { show: true, fontSize: '18', fontWeight: 'bold' } },
                      labelLine: { show: false },
                      data: [
                        { value: <?= $analyse->get_nbr_of_products() ?>, name: 'Products' },
                        { value: <?= $analyse->get_nbr_of_services() ?>, name: 'Services' },
                        { value: <?= $analyse->get_nbr_of_taxes() ?>, name: 'Taxes' },
                      ]
                    }]
                  });
                });
              </script>
            </div>
          </div>

          <?php
            require 'php/services/LogService.php';
            echo new ActivityLog([
              'logs' => get_logs($username),
              'title' => 'Recent Activity',
            ]);
          ?>

        </div>

      </div>
    </section>

  </main>

  <?php require 'php/partials/footer.php'; ?>

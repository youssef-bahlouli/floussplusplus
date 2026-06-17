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
        <div class="col-lg-6">
          <?= new Card([
            'title' => 'Budget Overview',
            'slot' => new Table([
              'columns' => ['username', 'first_name', 'last_name', 'salaire', 'rest_du_cheque_final', 'epargne', 'Budget'],
              'rows' => $rows,
              'renderers' => [
                'username' => fn($v) => htmlspecialchars($v, ENT_QUOTES, 'UTF-8'),
                'first_name' => fn($v) => htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'),
                'last_name' => fn($v) => htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'),
                'salaire' => fn($v) => number_format((float)$v, 1) . ' MAD',
                'rest_du_cheque_final' => fn($v) => number_format((float)$v, 1) . ' MAD',
                'epargne' => fn($v) => number_format((float)$v, 1) . ' MAD',
                'Budget' => fn($v) => '<span class="text-primary fw-bold">' . number_format((float)$v, 2) . ' MAD</span>',
              ],
            ]),
          ]) ?>
        </div>
      </div>
    </section>

  </main>

  <?php require 'php/partials/footer.php'; ?>

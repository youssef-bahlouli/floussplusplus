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
        <div class="col-lg-6">
          <?= new Card([
            'title' => 'Expense Overview',
            'slot' => new Table([
              'columns' => ['_id', 'nom', 'description', 'type', 'prix', 'quantite', 'ddate'],
              'rows' => $rows,
              'renderers' => [
                '_id' => fn($v) => (string)$v,
                'nom' => fn($v) => '<span class="text-primary fw-bold">' . htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8') . '</span>',
                'prix' => fn($v) => number_format((float)$v, 2) . ' MAD',
                'quantite' => fn($v) => (int)$v,
              ],
            ]),
          ]) ?>
        </div>
      </div>
    </section>

  </main>

  <?php require 'php/partials/footer.php'; ?>

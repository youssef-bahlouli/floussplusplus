<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];
  require 'php/get_info.php';
  require 'php/components/helpers.php';
  
  $pageTitle = 'Add Expense';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Add an Expense</h1>
      <?= ui_breadcrumb([
        ['label' => 'Home', 'url' => 'dashboard.php'],
        ['label' => 'Pages'],
        ['label' => 'Add Expense', 'active' => true],
      ]) ?>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-6">
          <?= new Card([
            'title' => 'Please fill in the information',
            'slot' => '<form action="./depenses_add_done.php" method="post">
              ' . new Input(['name' => 'nom', 'type' => 'text', 'placeholder' => 'Expense name', 'inputAttrs' => ['required' => true]]) . '
              ' . new Textarea(['name' => 'description', 'placeholder' => 'Description', 'inputAttrs' => ['style' => 'height:100px']]) . '
              ' . new Select(['name' => 'type', 'options' => [
                  ['value' => '', 'label' => 'Select type'],
                  ['value' => 'produits', 'label' => 'Products'],
                  ['value' => 'services', 'label' => 'Services'],
                  ['value' => 'taxes', 'label' => 'Taxes'],
                ], 'placeholder' => 'Choose type']) . '
              ' . new Input(['name' => 'prix', 'type' => 'number', 'placeholder' => 'Price', 'inputAttrs' => ['required' => true]]) . '
              ' . new Input(['name' => 'quantite', 'type' => 'number', 'placeholder' => 'Quantity (optional)', 'inputAttrs' => ['value' => '1']]) . '
              <div class="text-center">
                ' . new Button(['type' => 'submit', 'label' => 'Submit']) . '
                ' . new Button(['type' => 'reset', 'variant' => 'secondary', 'label' => 'Reset']) . '
              </div>
            </form>',
          ]) ?>
        </div>
      </div>
    </section>

  </main>

  <?php require 'php/partials/footer.php'; ?>

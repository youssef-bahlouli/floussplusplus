<?php
  require './php/input.php';
  require './php/components/helpers.php';

  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];
  
  $pageTitle = 'Salary';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Record Income Information</h1>
      <?= ui_breadcrumb([
        ['label' => 'Home', 'url' => 'dashboard.php'],
        ['label' => 'Declaration'],
        ['label' => 'Income Declaration', 'active' => true],
      ]) ?>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-6">
          <?= new Card([
            'title' => 'Please fill in the information',
            'slot' => '<form action="./b_salsaire_input_done.php" method="post">
              <div class="form-floating mb-3">
                <input type="number" class="form-control" id="floatingInput" name="salaire" placeholder="Salary">
                <label for="floatingInput">Salary</label>
              </div>
              <p>Did you spend part of it?</p>
              <fieldset class="row mb-3">
                <legend class="col-form-label col-sm-2 pt-0">Answer:</legend>
                <div class="col-sm-10">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="condition" id="condition1" value="yes" onclick="handleClick_salaire(this)" checked>
                    <label class="form-check-label" for="condition1">Yes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="condition" id="condition2" value="no" onclick="handleClick_salaire(this)">
                    <label class="form-check-label" for="condition2">No</label>
                  </div>
                </div>
              </fieldset>
              <hr>
              ' . new Input(['name' => 'reste', 'placeholder' => 'Balance']) . '
              <div class="text-center">
                ' . new Button(['type' => 'submit', 'label' => 'Submit']) . '
                ' . new Button(['type' => 'submit', 'variant' => 'success', 'label' => 'Receive Salary', 'attrs' => ['name' => 'action', 'value' => 'receive']]) . '
                ' . new Button(['type' => 'reset', 'variant' => 'secondary', 'label' => 'Reset']) . '
              </div>
              <div class="text-center mt-2">
                <small class="text-muted">"Receive Salary" moves previous balance to savings and starts fresh.</small>
              </div>
            </form>',
          ]) ?>
        </div>
      </div>
    </section>

  </main>

  <?php require 'php/partials/footer.php'; ?>

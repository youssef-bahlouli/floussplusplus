<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];
  require 'php/get_info.php';
  require 'php/components/helpers.php';

  $pageTitle = 'Savings';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';
?>  

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Record Savings Information</h1>
      <?= ui_breadcrumb([
        ['label' => 'Home', 'url' => 'dashboard.php'],
        ['label' => 'Declaration'],
        ['label' => "Savings Declaration", 'active' => true],
      ]) ?>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-6">
          <?= new Card([
            'title' => "Please fill in the information",
            'slot' => '<form action="./b_epargne_input_done.php" method="post">
              ' . new Input(['name' => 'epargne', 'type' => 'number', 'placeholder' => 'Savings amount']) . '
              <p style="width:550px; margin:20px;">Is this added value?</p>
              <fieldset class="row mb-3">
                <legend class="col-form-label col-sm-2 pt-0">Answer:</legend>
                <div class="col-sm-10">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="reponse" id="reponse1" value="yes" checked>
                    <label class="form-check-label" for="reponse1">Yes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="reponse" id="reponse2" value="no">
                    <label class="form-check-label" for="reponse2">No</label>
                  </div>
                </div>
              </fieldset>
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

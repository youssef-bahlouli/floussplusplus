<?php
  require './php/input.php';

  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];

  if(isset($_POST['salaire'])){
    $salaire=$_POST['salaire'];
    $condition=$_POST['condition'] ?? 'no';
    if($condition == 'yes'){
      $reste=$_POST['reste'] ?? $salaire;
      input_salaire($username,$salaire,$reste,$condition);
    }else {
      input_salaire($username,$salaire,$salaire,$condition);
    }
    header('Location: dashboard.php');
    exit;
  }

$pageTitle = 'Salaire Done';
require 'php/partials/head.php';
require 'php/partials/header.php';
require 'php/partials/sidebar.php';
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Enregister les information de revenue</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Déclaration</li>
          <li class="breadcrumb-item active">Déclaration du revenue</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-6">

            <div class="card" style="width :700px">
              <div class="card-body" >
                <h5 class="card-title">Enregistré</h5>


                <!-- General Form Elements -->


</div>
            </div>

          </div>

        </div>
      </section>

  </main><!-- End #main -->

  <?php require 'php/partials/footer.php'; ?>

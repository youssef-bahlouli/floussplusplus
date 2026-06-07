<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];

  if(isset($_POST['epargne'])){
    require './php/input.php';
    $reponse=$_POST['reponse'] ?? 'no';
    input_epargne($username,$_POST['epargne'],$reponse);
    header('Location: dashboard.php');
    exit;
  }
  header('Location: b_epargne_input.php');
  exit;

  $pageTitle = 'Epargne Done';
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
          <li class="breadcrumb-item active">Déclaration d'épargne</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-6">
  
            <div class="card" style="width :700px">
              <div class="card-body" >
                <h5 class="card-title">Veuillez saisir les informations</h5>
  
                <!-- General Form Elements -->
</div>
            </div>
  
          </div>

        </div>
      </section>

  </main><!-- End #main -->

  <?php require 'php/partials/footer.php'; ?>
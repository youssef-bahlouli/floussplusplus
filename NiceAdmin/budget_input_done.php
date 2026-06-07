<?php
  require "./php/get_info.php";
  require "./php/set_info.php";
  $connexion=get_con_var();
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];

  if(isset($_POST['salaire'],$_POST['reste'],$_POST['epargne'])){
    set_budget($connexion,$_POST['salaire'],$_POST['reste'],$_POST['epargne'],$username);
    header('Location: dashboard.php');
    exit;
  }
  header('Location: budget_input.php');
  exit;

  $pageTitle = 'Budget Done';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Fin de création de compte</h1>
      
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-6">
  
            <div class="card" style="width :700px">
              <div class="card-body" >
                <h5 class="card-title">Tous est complète</h5>
              </div>

              
            </div>
  
          </div>

        </div>
      </section>

  </main><!-- End #main -->

  <?php require 'php/partials/footer.php'; ?>
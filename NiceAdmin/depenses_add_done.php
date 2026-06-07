<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];

  if(isset($_POST['nom'],$_POST['description'],$_POST['type'],$_POST['prix'])){
    $q=1;
    $type=$_POST['type'];
    if(!$type || $type==='3 types'){ header('Location: depenses_add.php'); exit; }
    if($type!="taxes" && $type!="services"){
      $q=$_POST['quantite'] ?? 1;
    }
    require 'php/get_info.php';
    require 'php/input.php';
    $dbconn=get_con_var();
    input_depenses($dbconn,$username,$_POST['nom'],$_POST['description'],$type,$_POST['prix'],$q);
    header('Location: dashboard.php');
    exit;
  }
  header('Location: depenses_add.php');
  exit;
  
  $pageTitle = 'Depense Done';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';
?>




  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Blank Page</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">Add Depenses</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-6">
  
            <div class="card" style="width :600px">
              <div class="card-body" >
                <h5 class="card-title">les informations sont enregistré</h5>


 
  
              </div>
            </div>
  
          </div>

        </div>
      </section>

  </main><!-- End #main -->

  <?php require 'php/partials/footer.php'; ?>
<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];
  require './php/input.php';

  if(isset($_POST['salaire'])){
    $salaire=$_POST['salaire'];
    if(isset($_POST['action']) && $_POST['action'] === 'receive'){
      input_receive_salary($username, $salaire);
      header('Location: dashboard.php');
      exit;
    }
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
  header('Location: b_salsaire_input.php');
  exit;

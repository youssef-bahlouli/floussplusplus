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

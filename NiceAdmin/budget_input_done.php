<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];

  require "./php/get_info.php";
  require "./php/set_info.php";
  $connexion=get_con_var();

  if(isset($_POST['salaire'],$_POST['reste'],$_POST['epargne'])){
    set_budget($connexion,$_POST['salaire'],$_POST['reste'],$_POST['epargne'],$username);
    header('Location: dashboard.php');
    exit;
  }
  header('Location: declarations.php');
  exit;

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

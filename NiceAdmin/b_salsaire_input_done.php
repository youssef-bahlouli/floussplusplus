<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];
  require './php/input.php';

  $condition = $_POST['condition'] ?? 'no';

  if (isset($_POST['action']) && $_POST['action'] === 'receive') {
    $spent = ($condition === 'yes') ? (float)($_POST['reste'] ?? 0) : 0;
    $result = input_receive_salary($username, $spent);
    if (!$result) {
      $_SESSION['error'] = 'No budget record found. Set up your budget first.';
      header('Location: declarations.php');
      exit;
    }
    header('Location: dashboard.php');
    exit;
  }

  if (isset($_POST['salaire'])){
    $salaire = (float)$_POST['salaire'];
    if ($condition === 'yes') {
      $reste = (float)($_POST['reste'] ?? $salaire);
      input_salaire($username, $salaire, $reste, $condition);
    } else {
      input_salaire($username, $salaire, $salaire, $condition);
    }
    header('Location: dashboard.php');
    exit;
  }
  header('Location: declarations.php');
  exit;

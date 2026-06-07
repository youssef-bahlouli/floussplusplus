<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username = $_SESSION["username"];
  
  $pageTitle = 'Budget';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';
?>







  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Le budget</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Enregistrements</li>
          <li class="breadcrumb-item active">Le budget</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-6">
  
            <div class="card" style="width :1000px">
              
              <div class="card-body" >
                <?php //echo $_SESSION['username'];?>
                <h5 class="card-title">Suivi de budget</h5>
                <?php
                //echo $username;
                  require 'php/get_tables.php';
                  require 'php/get_info.php';
                  $connexion=get_con_var();
                  $listeemploye = get_budget_table($connexion,$username); 
                ?>
                <table class="table datatable">
                <thead>
                  <tr>                    
                    <th >
                      <b>Username</b>
                    </th>
                    <th style="width : 60 px;" class="little_wider">prénom </th>
                    <th style="width : 60 px;" class="little_wider">nom </th>
                    <th>salaire</th>
                    <th>reste</th>
                    <th>epargne</th>
                    <th>Budget</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                    foreach($listeemploye as $ligne){
                        ?>
                        <tr>
                        <td class="little_wider">
                        <?php echo $ligne['username']; ?>
                        </td>
                        <td class =" little_wider"> <?php echo $ligne['first_name'] ; ?></td>
                        <td class =" little_wider"> <?php echo  $ligne['last_name']; ?></td>
                        <td class="wide"> <?php echo number_format($ligne['salaire']             ,1)." MAD" ; ?> </td>
                        <td class="wide"> <?php echo number_format($ligne['rest_du_cheque_final'],1)." MAD" ; ?> </td>
                        <td class="wide"> <?php echo number_format($ligne['epargne']             ,1)." MAD" ; ?> </td>
                        <td class="text-primary fw-bold wider"><?php echo number_format($ligne['Budget'],2)." MAD"; ?> </td>
                        
                      </tr>
                        <?php
                    }
                ?>  
                </tbody>
                  </table>               
              </div>
              
            </div>
  
          </div>

        </div>
      </section>

  </main><!-- End #main -->

  <?php require 'php/partials/footer.php'; ?>
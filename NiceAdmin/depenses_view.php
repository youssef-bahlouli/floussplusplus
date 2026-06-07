<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username = $_SESSION["username"];
  
  $pageTitle = 'Depenses';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';
?>






  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Les dépenses</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Dépenses</li>
          <li class="breadcrumb-item active">Les dépenses</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-6">
  
            <div class="card" style="width :800px">
              
              <div class="card-body" >
                <?php //echo $_SESSION['username'];?>
                <h5 class="card-title">Suivi des dépenses</h5>
                <?php
                //echo $username;
                  require 'php/get_tables.php';
                  require 'php/get_info.php';
                  $connexion=get_con_var();
                  $listeemploye = get_depenses_table($connexion,$username); 
                ?>
                <table class="table datatable">
                <thead>
                  <tr>                    
                    <th >
                      <b>I</b>D
                    </th>
                    <th>nom   </th>
                    <th>description</th>
                    <th>type</th>
                    <th>prix</th>
                    <th>quantité</th>
                    <th>date</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                    foreach($listeemploye as $ligne){
                        ?>
                        <tr>
                        <td >
                        <?php echo (string)$ligne['_id']; ?>
                        </td>
                        <td class ="text-primary fw-bold" >
                          <?php echo $ligne['nom']; ?>
                        </td>
                        <td>
                        <?php
                        echo $ligne['description'];
                        ?>
                        </td>
                        <td>
                        <?php
                        echo $ligne['type'];
                        ?>
                        </td>
                        <td>
                        <?php
                        echo $ligne['prix'];
                        ?>
                        </td>
                        <td>
                        <?php
                        echo $ligne['quantite'];
                        ?>
                        </td>
                        <td>
                        <?php
                        echo $ligne['ddate'];
                        ?>
                        </td>
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
<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];
  require 'php/get_info.php';
  require 'php/analyse.php';
  
  $pageTitle = 'Add Depense';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';
?>





  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Déclaration d'une dépense</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Déclaration</li>
          <li class="breadcrumb-item active">Déclaration d'une dépense</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-6">
  
            <div class="card" >
              <div class="card-body" >
                <h5 class="card-title">Veuillez saisir les informations</h5>
  
                <!-- General Form Elements -->
                <form action="./depenses_add_done.php" method="post">
                  
                  <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="floatingInput" name="nom">
                      <label for="floatingInput" name="nom">Nom</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" 
                        id="floatingTextarea" style="height: 100px;"
                        name="description"></textarea>
                        <label for="floatingTextarea" name="description">Description</label>
                    </div>


                    <hr>
                    <div class="row mb-3" style="margin-top : 20px">
                        <label class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-10">
                          <select class="form-select" aria-label="Default select example"
                          onchange="checkSelect()" id="depenses_type-id" name="type">
                            <option selected disabled value="">Select a type</option>
                            <option value="produits">Produits</option>
                            <option value="taxes">Taxes</option>
                            <option value="services">Services</option>
                          </select>
                        </div>
                      </div>
                      <hr>

                  <div class="row mb-3" style="margin-top : 7px">
                    <label for="inputEmail" class="col-sm-2 col-form-label"
                    name="prix">Prix</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" name="prix" step="0.00001">
                    </div>
                  </div>

                  <div class="row mb-3" style="margin-top : 7px">
                    <label for="inputEmail" class="col-sm-2 col-form-label">
                        Quantite
                    </label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" name="quantite"
                      value="1" id="quantite-id" >
                    </div>
                  </div>
                  <!--
                  <div class="row mb-3">
                    <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                    <div class="col-sm-10">
                      <input type="date" class="form-control" name="date">
                    </div>
                  </div>
                  -->
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                  </div>
  
                </form><!-- End General Form Elements -->
  
              </div>
            </div>
  
          </div>

        </div>
      </section>

  </main><!-- End #main -->

  <?php require 'php/partials/footer.php'; ?>
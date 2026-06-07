<?php
  require './php/input.php';

  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];
  
  $pageTitle = 'Salaire';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';
?>




  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Enregister les information de revenue</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Déclaration</li>
          <li class="breadcrumb-item active">Déclaration du revenue</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
          <div class="col-lg-6">
  
            <div class="card" style="width :700px">
              <div class="card-body" >
                <h5 class="card-title">Veuillez saisir les informations</h5>
  
                <!-- General Form Elements -->
                <form action="./b_salsaire_input_done.php" method="post">
                  
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" name="salaire">
                        <label for="floatingInput" name="salaire">Salaire</label>
                    </div>
                    <p>As-tu dépensé une partie de cela ?</p>
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-2 pt-0">Réponse :</legend>
                        <div class="col-sm-10">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="condition" 
                            id="condition1" value="yes" onclick="handleClick_salaire(this)" checked>
                            <label class="form-check-label" for="condition1">
                              Yes
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="condition" 
                            id="condition2" value="no" onclick="handleClick_salaire(this)">
                            <label class="form-check-label" for="condition2">
                              No
                            </label>
                          </div> 
                        </div>
                      </fieldset>
                      <hr>

                      <div class="row mb-3" style="margin-top : 7px" >
                        <label for="inputEmail" class="col-sm-2 col-form-label">
                            reste  :
                        </label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" name="reste"
                           id="reste-id" >
                        </div>
                      </div>
                    

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
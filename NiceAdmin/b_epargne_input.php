<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];
  require 'php/get_info.php';

  $pageTitle = 'Epargne';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';
?>  

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Enregister les information d'épargne</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Déclaration</li>
          <li class="breadcrumb-item active">Déclaration d'épargne</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row align-items-top">
          <div class="col-lg-6">
  
            <div class="card" style="">
              <div class="card-body "  >
                <h5 class="card-title">Veuillez saisir les informations</h5>
  
                <!-- General Form Elements -->
                <form action="./b_epargne_input_done.php" method="post">
                  
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" name="epargne">
                        <label for="floatingInput" name="epargne">Epargne</label>
                    </div>
                    <p style="width :550px; margin : 20px;">Est-ce une valeur ajoutée ou non ?</p>
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-2 pt-0">Réponse</legend>
                        <div class="col-sm-10">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="reponse" 
                            id="condition1" value="yes" onclick="handleClick_epargne(this)" checked>
                            <label class="form-check-label" for="condition1">
                              Yes
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="reponse" 
                            id="condition2" value="no" onclick="handleClick_epargne(this)">
                            <label class="form-check-label" for="condition2">
                              No
                            </label>
                          </div> 
                        </div>
                      </fieldset>


                    
                      <br>
                      <br>
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                      </div>
                      <br>
                      <br>
                </form><!-- End General Form Elements -->
  
              </div>
            </div>
  
          </div>

          <div class="col-lg-3">
          <div class="card">
            <img src="assets/img/card-2.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Voulez-vous transférer le montant du dernier chèque de paie vers les épargnes ?</h5>
              
              <center>
                
                  <button id="myButton" class="btn btn-primary">Click me</button>
                  <div id="result">...</div>
    
                  <script>
                  $(document).ready(function() {
                  $('#myButton').click(function() {
                    var username = <?php echo json_encode($username, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT); ?>;
                    $.ajax({
                      url: './php/bag_algorithm.php',  // The PHP script that processes the request
                      type: 'POST',        // The method used to send data
                      data: { 
                        action: 'bag_algorithm',                     
                        username1 :username  
                       },  // Data sent to the server
                      success: function(response) {
                        $('#result').html(response); // Display the response in the 'result' div
                      },
                      error: function() {
                      $('#result').html('Error: Unable to execute PHP function.');
                      }
                    });
                  });
                  });
                  </script>


              </center>
              <br>
            </div>
          </div>
          </div>

        </div>
      </section>

  </main><!-- End #main -->

  <?php require 'php/partials/footer.php'; ?>
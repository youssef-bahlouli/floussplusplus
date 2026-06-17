<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Register - FLouss++</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- NiceAdmin Template by BootstrapMade -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="./budget_input.php" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">FLouss++</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

              <?php
                require   './php/set_info.php';
                require   './php/get_info.php';
                require_once './php/services/LogService.php';
                $connexion = get_con_var();
                if(!isset($_POST['username'],$_POST['first_name'],$_POST['last_name'],$_POST['passwrd'],$_POST['age'])){ header('Location: pages-register.html'); exit; }
                $username=$_POST['username'];
                $first_name=$_POST['first_name'];
                $last_name=$_POST['last_name'];
                $passwrd=$_POST['passwrd'];
                $age=$_POST['age'];

                if($connexion->users->findOne(['_id' => $username])){
                    echo '<div class="alert alert-danger text-center">Username already exists</div>';
                    echo '<div class="text-center"><a href="pages-register.html" class="btn btn-primary">Go Back</a></div>';
                    exit;
                }

                $date = new DateTime();
                $date_payment = $date->format("Y-m-d H:i:s"); 
                insert_users($connexion, $username ,$first_name,$last_name,$age,$passwrd,$date_payment);
                session_start();
                $_SESSION["username"] = $username;
                $_SESSION["user"] = $username;
                
                $connexion->budgets->insertOne([
                    'username' => $username,
                    'salaire' => 0.0,
                    'rest_du_cheque_final' => 0.0,
                    'epargne' => 0.0,
                    'created_at' => new MongoDB\BSON\UTCDateTime()
                ]);
                $connexion->depenses->insertOne([
                    'username' => $username,
                    'nom' => 'begin',
                    'description' => 'begin',
                    'prix' => 0.0,
                    'quantite' => 1,
                    'ddate' => $date_payment,
                    'type' => 'services'
                ]);
                log_action($username, 'register', "$first_name $last_name registered");
                ?>
              </div>

              <div class="credits">
                <a href="https://bootstrapmade.com/">NiceAdmin</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];
  require 'php/get_tables.php';
  require 'php/get_info.php';
  require 'php/analyse.php';
  $connexion = get_con_var();
  $pageTitle = 'Insights';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';

?>





  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Insights</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Insights</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">
            
          <div class=" col-12">
            <div class="card-body card" >
              <h5 class="card-title">Le Montant reservé au chaque payment   
              <span class="grey"> les lignes sont classés progressivement</span></h5>

              <!-- Line Chart -->
              <div id="lineChart"> 
                <br>
                <br>
                <?php 
                $resCursor=get_bag_table($connexion,$username);
                $res=iterator_to_array($resCursor);
                $analyse = new Analyse();
                $num = count($res);
                if ($num==0)echo $num." payments passé.";
                ?>
              </div>
              <?php if($num>0){ ?>
              <script>  
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#lineChart"), {
                    series: [{
                      name: "le Montant reservé au moment de chaque payment",
                      data: [
                        <?php
                          $c=1;
                          foreach($res as $a){
                            echo $a['value'];
                            if($c != $num) echo ' ,';
                            $c++;
                          }
                        ?>
                      ]
                    }],
                    chart: {
                      height: 350, type: 'bar',
                      zoom: {enabled: true}
                    },
                    dataLabels: {enabled: true},
                    stroke: {curve: 'straight'},
                    grid: {
                      row: {colors: ['#f3f3f3', 'transparent'],opacity: 0.5}
                      ,
                    },
                    xaxis: {
                      categories: [
                        <?php
                        for($i=1 ; $i<=$num ; $i++) 
                        {
                          echo " ' ".$i." ' ";
                          if($i !=$num) echo ' ,';
                        }
                        ?>
                      ],
                    }
                  }).render();
                });
              </script>
              <?php } ?>
              <!-- End Line Chart -->

            </div>
          </div>
            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Rapport de budget <span> les lignes sont classés progressivement</span></h5>
                  <br>
                  <?php
                    //echo $_SESSION['username'];
                  ?>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>
                  <?php 
                    $resCursor=get_budget_table($connexion,$username);
                    $res=iterator_to_array($resCursor);
                    $num = count($res);
                    if ($num==0)echo $num." ligne enregistré.";
                  ?>
                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Reste du chèque fnal',
                          data: [
                            <?php
                            $c=1;
                            foreach($res as $a){
                              echo $a['rest_du_cheque_final'];
                              if($c != $num) echo ' ,';
                              $c++;
                            }
                            ?>
                          ],
                        }, {
                          name: 'Epargne',
                          data: [
                            <?php
                            $c=1;
                            foreach($res as $a){
                              echo $a['epargne'];
                              if($c != $num) echo ' ,';
                              $c++;
                            }
                            ?>                            
                          ]
                        }, {
                          name: 'Salaire',
                          data: [
                            <?php
                            $c=1;
                            foreach($res as $a){
                              echo $a['salaire'];
                              if($c != $num) echo ' ,';
                              $c++;
                            }
                            ?>                          ]
                        }],
                        chart: {
                          height: 500,
                          type: 'area',
                          toolbar: {
                            show: true
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'number',
                          categories: [
                            <?php
                            for($i=1; $i<=$num; $i++){
                              echo " ' ".$i." ' ";
                              if($i != $num) echo ' ,';
                            }
                            ?> 
                          ]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">la plupart des dépenses payées.<span> | de <?php echo get_fullname($username); ?></span></h5>
                  <?php $res= get_depenses_table_ord_occurr($connexion, $username);?>
                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Occurrence</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($res as $l){ ?>
                      <tr>
                        <td><?php echo $l['nom']; ?></td>
                        <td><?php echo $l['occurrences']; ?></td>
                        <!--
                        <td><?php
                          if($l->type == "services" ||$l->type == "taxes" )
                         echo "<span class='badge bg-success'>".$l->type."</span>";
                        else echo "<span class='badge bg-warning'>".$l->type."</span>";
                         ?>
                         </td>
                      -->
                      </tr>
                      <?php } ?>
                      <!--
                      <tr>
                        <th scope="row"><a href="#">#2147</a></th>
                        <td>Bridie Kessler</td>
                        <td><a href="#" class="text-primary">Blanditiis dolor omnis similique</a></td>
                        <td>$47</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2049</a></th>
                        <td>Ashleigh Langosh</td>
                        <td><a href="#" class="text-primary">At recusandae consectetur</a></td>
                        <td>$147</td>
                        <td><span class="badge bg-success">Approved</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2644</a></th>
                        <td>Angus Grady</td>
                        <td><a href="#" class="text-primar">Ut voluptatem id earum et</a></td>
                        <td>$67</td>
                        <td><span class="badge bg-danger">Rejected</span></td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#">#2644</a></th>
                        <td>Raheem Lehner</td>
                        <td><a href="#" class="text-primary">Sunt similique distinctio</a></td>
                        <td>$165</td>
                        <td><span class="badge bg-success">Approved</span></td>
                      </tr>
                      -->
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->

            <!-- Top Selling -->
            <!--
            <div class="col-12">
              <div class="card top-selling overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body pb-0">
                  <h5 class="card-title">Top Selling <span>| Today</span></h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Preview</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Sold</th>
                        <th scope="col">Revenue</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-1.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Ut inventore ipsa voluptas nulla</a></td>
                        <td>$64</td>
                        <td class="fw-bold">124</td>
                        <td>$5,828</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-2.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Exercitationem similique doloremque</a></td>
                        <td>$46</td>
                        <td class="fw-bold">98</td>
                        <td>$4,508</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-3.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Doloribus nisi exercitationem</a></td>
                        <td>$59</td>
                        <td class="fw-bold">74</td>
                        <td>$4,366</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-4.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Officiis quaerat sint rerum error</a></td>
                        <td>$32</td>
                        <td class="fw-bold">63</td>
                        <td>$2,016</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="assets/img/product-5.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Sit unde debitis delectus repellendus</a></td>
                        <td>$79</td>
                        <td class="fw-bold">41</td>
                        <td>$3,239</td>
                      </tr>
                    </tbody>
                  </table>

                </div>

              </div>
            </div>
            -->
            <!-- End Top Selling -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
          <!-- Budget Report -->
          
          <!-- End Budget Report -->

          <!-- Website Traffic -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">Statisique de dépenses <span>| ...</span></h5>

              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
              
              <script>
              <?php
                $connexion = get_con_var();
                $array = get_depenses_table($connexion,$username);
                $analyse = new Analyse();
                $analyse->set_depenses_statistics($username,$array);
              ?>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      top: '5%',
                      left: 'center'
                    },
                    series: [{
                      name: 'Access From',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: false,
                      label: {
                        show: false,
                        position: 'center'
                      },
                      emphasis: {
                        label: {
                          show: true,
                          fontSize: '18',
                          fontWeight: 'bold'
                        }
                      },
                      labelLine: {
                        show: false
                      },
                      data: [{
                          value: <?php echo $analyse->get_nbr_of_products();?>,
                          name: 'products'
                        },
                        {
                          value  : <?php echo $analyse->get_nbr_of_services(); ?> ,
                          name : 'services'
                        }
                        ,
                        {
                          value  : <?php echo $analyse->get_nbr_of_taxes(); ?> ,
                          name : 'taxes'
                        }


                      ]
                    }]
                  });
                });
              </script>

              <?php //echo $analyse->get_max_value_bag($connexion,$username);?>

            </div>
          </div><!-- End Website Traffic -->

          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title">Activit&eacute; r&eacute;cente</h5>
              <div class="news">
                <?php
                  require 'php/services/LogService.php';
                  render_log($username);
                ?>
              </div>
            </div>
          </div>

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <?php require 'php/partials/footer.php'; ?>
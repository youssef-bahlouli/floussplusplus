<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>FLouss++ - Personal Budget Management & Finance Tracker</title>
  <meta content="FLouss++ is a modern budget management application for tracking income, expenses, and savings with interactive charts and insights." name="description">
  <meta content="budget, finance, expense tracker, savings, personal finance, money management" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style2.css" rel="stylesheet">

  <!-- =======================================================
  * FLouss++ - Personal Budget Management Application
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span>FLouss++</span>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#features">Features</a></li>
          <li><a class="nav-link scrollto" href="#team">Team</a></li>
          <li><a class="nav-link scrollto" href="#faq">FAQ</a></li>
          <li><a class="getstarted scrollto" href="NiceAdmin/dashboard.php">Dashboard</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center">
          <h1 data-aos="fade-up">Nous proposons une solution moderne pour suivre votre budget de manière efficace.</h1>
          <h2 data-aos="fade-up" data-aos-delay="400">
            Notre application fournit des mises à jour et des analyses approfondies, 
            vous permettant de garder le contrôle de vos finances en toute simplicité</h2>
          <div data-aos="fade-up" data-aos-delay="600">
            <div class="text-center text-lg-start">
              <a href="NiceAdmin/pages-login.html" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                <span>Log In</span>
                <i class="bi bi-arrow-right"></i>
              </a>
              <a href="NiceAdmin/pages-register.html" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                <span>Register</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
          <img src="assets/img/hero-img.png" class="img-fluid" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">
    <!-- ======= About Section ======= -->
    <section id="about" class="about">

      <div class="container" data-aos="fade-up">
        <div class="row gx-0">

          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="content">
              <h3>About FLouss++</h3>
              <h2>Take control of your personal finances with powerful tracking and insights.</h2>
              <p>
                FLouss++ is a modern budget management application designed to help you track your income, 
                expenses, and savings effortlessly. With real-time analytics and intuitive dashboards, 
                you can make informed financial decisions and achieve your savings goals faster.
              </p>
              <div class="text-center text-lg-start">
                <a href="NiceAdmin/pages-register.html" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                  <span>Get Started Free</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
            <img src="assets/img/about.jpg" class="img-fluid" alt="">
          </div>

        </div>
      </div>

    </section><!-- End About Section -->

    <!-- ======= Values Section ======= -->
    <section id="values" class="values">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Our Values</h2>
          <p>What drives us every day</p>
        </header>

        <div class="row">

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="box">
              <img src="assets/img/values-1.png" class="img-fluid" alt="">
              <h3>Transparency</h3>
              <p>We believe in clear, honest financial tracking. No hidden fees, no surprises — just a complete view of where your money goes.</p>
            </div>
          </div>

          <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="400">
            <div class="box">
              <img src="assets/img/values-2.png" class="img-fluid" alt="">
              <h3>Simplicity</h3>
              <p>Finance management shouldn't be complicated. Our intuitive interface makes budgeting accessible to everyone, regardless of experience.</p>
            </div>
          </div>

          <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="600">
            <div class="box">
              <img src="assets/img/values-3.png" class="img-fluid" alt="">
              <h3>Empowerment</h3>
              <p>Knowledge is power. We provide actionable insights and analytics so you can make smarter financial decisions every day.</p>
            </div>
          </div>

        </div>

      </div>

    </section><!-- End Values Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
      <div class="container" data-aos="fade-up">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="bi bi-wallet2"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="3" data-purecounter-duration="1" class="purecounter"></span>
                <p>Budget Tiers</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="bi bi-bar-chart" style="color: #ee6c20;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="4" data-purecounter-duration="1" class="purecounter"></span>
                <p>Chart Types</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="bi bi-coin" style="color: #15be56;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="3" data-purecounter-duration="1" class="purecounter"></span>
                <p>Expense Categories</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="bi bi-shield-check" style="color: #bb0852;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1" class="purecounter"></span>
                <p>Data Privacy</p>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Features</h2>
          <p>Everything you need to manage your finances</p>
        </header>

        <div class="row">

          <div class="col-lg-6">
            <img src="assets/img/features.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 mt-5 mt-lg-0 d-flex">
            <div class="row align-self-center gy-4">

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="200">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Income Tracking</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="300">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Expense Management</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="400">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Savings Goals</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="500">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Budget Reports</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="600">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Visual Analytics</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="700">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Activity Logs</h3>
                </div>
              </div>

            </div>
          </div>

        </div>

        <!-- Feature Tabs -->
        <div class="row feture-tabs" data-aos="fade-up">
          <div class="col-lg-6">
            <h3>Comprehensive financial tools designed for everyone</h3>

            <ul class="nav nav-pills mb-3">
              <li>
                <a class="nav-link active" data-bs-toggle="pill" href="#tab1">Budget</a>
              </li>
              <li>
                <a class="nav-link" data-bs-toggle="pill" href="#tab2">Expenses</a>
              </li>
              <li>
                <a class="nav-link" data-bs-toggle="pill" href="#tab3">Insights</a>
              </li>
            </ul>

            <div class="tab-content">

              <div class="tab-pane fade show active" id="tab1">
                <p>Set your monthly budget, track your salary, and monitor your remaining balance at a glance. Our budget system helps you stay on top of your financial limits.</p>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <h4>Salary & balance tracking</h4>
                </div>
                <p>Record your income and see how much you have left after expenses. The system automatically calculates your remaining budget.</p>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <h4>Savings integration</h4>
                </div>
                <p>Set aside savings from each paycheck. Watch your savings grow over time with automatic rollover between pay periods.</p>
              </div>

              <div class="tab-pane fade show" id="tab2">
                <p>Log every expense with detailed descriptions, categories, and quantities. Categorize spending into Products, Services, and Taxes for better analysis.</p>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <h4>Detailed expense entries</h4>
                </div>
                <p>Add name, description, type, price, and quantity for each expense. Everything is stored with timestamps for accurate history.</p>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <h4>Category management</h4>
                </div>
                <p>Organize spending into Products, Services, and Taxes to understand where your money goes each month.</p>
              </div>

              <div class="tab-pane fade show" id="tab3">
                <p>Gain deep insights into your financial habits with interactive charts and detailed statistics. Make data-driven decisions about your spending.</p>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <h4>Interactive charts & reports</h4>
                </div>
                <p>Visualize your expense distribution, monthly trends, and top spending categories with beautiful, interactive charts.</p>
                <div class="d-flex align-items-center mb-2">
                  <i class="bi bi-check2"></i>
                  <h4>Expense frequency analysis</h4>
                </div>
                <p>Identify recurring expenses and spending patterns. See which items you purchase most frequently to optimize your budget.</p>
              </div>

            </div>

          </div>

          <div class="col-lg-6">
            <img src="assets/img/features-2.png" class="img-fluid" alt="">
          </div>

        </div><!-- End Feature Tabs -->

        <!-- Feature Icons -->
        <div class="row feature-icons" data-aos="fade-up">
          <h3>Why choose FLouss++ for your financial journey</h3>

          <div class="row">

            <div class="col-xl-4 text-center" data-aos="fade-right" data-aos-delay="100">
              <img src="assets/img/features-3.png" class="img-fluid p-4" alt="">
            </div>

            <div class="col-xl-8 d-flex content">
              <div class="row align-self-center gy-4">

                <div class="col-md-6 icon-box" data-aos="fade-up">
                  <i class="ri-line-chart-line"></i>
                  <div>
                    <h4>Real-time Analytics</h4>
                    <p>Live updates on your financial status with beautiful charts and visual indicators.</p>
                  </div>
                </div>

                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                  <i class="ri-stack-line"></i>
                  <div>
                    <h4>Secure & Private</h4>
                    <p>Your financial data is stored securely with encrypted passwords and private accounts.</p>
                  </div>
                </div>

                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                  <i class="ri-brush-4-line"></i>
                  <div>
                    <h4>Clean Interface</h4>
                    <p>Intuitive and clutter-free design makes financial management a breeze.</p>
                  </div>
                </div>

                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                  <i class="ri-magic-line"></i>
                  <div>
                    <h4>Smart Insights</h4>
                    <p>Automatic analysis of your spending patterns highlights opportunities to save.</p>
                  </div>
                </div>

                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                  <i class="ri-command-line"></i>
                  <div>
                    <h4>Easy Setup</h4>
                    <p>Get started in minutes. Register, set your first budget, and start tracking immediately.</p>
                  </div>
                </div>

                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                  <i class="ri-radar-line"></i>
                  <div>
                    <h4>Full Control</h4>
                    <p>Complete visibility into your income, expenses, and savings in one centralized dashboard.</p>
                  </div>
                </div>

              </div>
            </div>

          </div>

        </div><!-- End Feature Icons -->

      </div>

    </section><!-- End Features Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Services</h2>
          <p>How FLouss++ helps you manage your money</p>
        </header>

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-box blue">
              <i class="bi bi-wallet2"></i>
              <h3>Budget Management</h3>
              <p>Set up monthly budgets, track your salary, and monitor spending limits. Know exactly how much you have left at any time.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-box orange">
              <i class="bi bi-cart3"></i>
              <h3>Expense Tracking</h3>
              <p>Log every purchase with categories, quantities, and descriptions. Keep a complete history of all your spending.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-box green">
              <i class="bi bi-piggy-bank"></i>
              <h3>Savings Goals</h3>
              <p>Set aside money for the future. Our savings tracker helps you build towards your financial goals one paycheck at a time.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-box red">
              <i class="bi bi-graph-up"></i>
              <h3>Visual Analytics</h3>
              <p>Interactive charts and graphs provide a clear picture of your financial health. Spot trends and adjust your habits.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="service-box purple">
              <i class="bi bi-file-earmark-text"></i>
              <h3>Detailed Reports</h3>
              <p>Generate comprehensive reports on income, expenses, and savings. Export-ready data for your personal records.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="700">
            <div class="service-box pink">
              <i class="bi bi-clock-history"></i>
              <h3>Activity History</h3>
              <p>Every financial action is logged and timestamped. Review your complete transaction history at any time.</p>
            </div>
          </div>

        </div>

      </div>

    </section><!-- End Services Section -->



    <!-- ======= F.A.Q Section ======= -->
    <section id="faq" class="faq">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>F.A.Q</h2>
          <p>Frequently Asked Questions</p>
        </header>

        <div class="row">
          <div class="col-lg-6">
            <div class="accordion accordion-flush" id="faqlist1">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-1">
                    How do I create an account?
                  </button>
                </h2>
                <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                  <div class="accordion-body">
                    Click the "Register" button on the homepage or navigate to the registration page. Fill in your username, name, age, and password to create your free account instantly.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-2">
                    Is my financial data secure?
                  </button>
                </h2>
                <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                  <div class="accordion-body">
                    Yes. Passwords are encrypted using industry-standard hashing algorithms. Your data is stored in a secure MongoDB database accessible only by your authenticated account. We never share your financial information with third parties.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-3">
                    How do I set up a monthly budget?
                  </button>
                </h2>
                <div id="faq-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                  <div class="accordion-body">
                    After logging in, navigate to the "Declaration" section and select "Income". Enter your salary and remaining balance. You can also allocate savings directly from the "Savings" section. The budget is automatically updated with each entry.
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="col-lg-6">

            <div class="accordion accordion-flush" id="faqlist2">

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-1">
                    What types of expenses can I track?
                  </button>
                </h2>
                <div id="faq2-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                  <div class="accordion-body">
                    You can track three main categories: Products (physical goods), Services (subscriptions, fees, etc.), and Taxes. Each expense can include a name, description, price, and quantity for detailed tracking.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-2">
                    How do I view insights and reports?
                  </button>
                </h2>
                <div id="faq2-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                  <div class="accordion-body">
                    The "Insights" section provides interactive charts showing your monthly expense trends, top expenses by total cost, expense distribution by category, and your savings rate over time. The dashboard gives you a quick overview of your current financial status.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-3">
                    Is FLouss++ free to use?
                  </button>
                </h2>
                <div id="faq2-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                  <div class="accordion-body">
                    Yes! FLouss++ offers a free tier with core features including one budget per month and up to 20 expenses. For unlimited usage, insights, and advanced features, check our Starter and Pro plans.
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>

      </div>

    </section><!-- End F.A.Q Section -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Screenshots</h2>
          <p>See FLouss++ in action</p>
        </header>

        <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="../Screens/home.png" class="img-fluid" alt="Dashboard Screenshot">
              <div class="portfolio-info">
                <h4>Log in</h4>
                <p>Overview of your finances</p>
                <div class="portfolio-links">
                  <a href="../Screens/home.png" data-gallery="portfolioGallery" class="portfokio-lightbox" title="Dashboard"><i class="bi bi-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="../Screens/code%20source.png" class="img-fluid" alt="Code Screenshot">
              <div class="portfolio-info">
                <h4>Revenue & Savings</h4>
                <p>Track income and savings goals</p>
                <div class="portfolio-links">
                  <a href="../Screens/code%20source.png" data-gallery="portfolioGallery" class="portfokio-lightbox" title="Revenue & Savings"><i class="bi bi-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-9.jpg" class="img-fluid" alt="Expenses Screenshot">
              <div class="portfolio-info">
                <h4>Expense Tracking</h4>
                <p>Detailed expense management</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-9.jpg" data-gallery="portfolioGallery" class="portfokio-lightbox" title="Expense Tracking"><i class="bi bi-plus"></i></a>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

    </section><!-- End Portfolio Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Testimonials</h2>
          <p>What our users say</p>
        </header>

        <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="200">
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  FLouss++ helped me get my spending under control in just one month. The insights feature showed me exactly where my money was going.
                </p>
                <div class="profile mt-auto">
                  <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                  <h3>Ahmed R.</h3>
                  <h4>Software Engineer</h4>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  The budget tracking system is exactly what I needed. I can track my salary, expenses, and savings all in one place. Highly recommend!
                </p>
                <div class="profile mt-auto">
                  <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                  <h4>Freelancer</h4>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  I love the charts and analytics. Seeing my expense breakdown as a pie chart made me realize how much I was spending on eating out. Game changer!
                </p>
                <div class="profile mt-auto">
                  <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                  <h4>Store Owner</h4>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Simple, effective, and free. FLouss++ has everything I need to manage my monthly budget without any unnecessary complexity.
                </p>
                <div class="profile mt-auto">
                  <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                  <h4>Student</h4>
                </div>
              </div>
            </div>

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- End Testimonials Section -->

    <!-- ======= Team Section ======= -->
    <section id="team" class="team">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Team</h2>
          <p>Built with passion by</p>
        </header>

        <div class="row gy-4 justify-content-center">

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <div class="member-img">
                <img src="assets/img/team/team-11.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="bi bi-github"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Youssef Bahlouli</h4>
                <span>Developer</span>
                <p>Software engineering student passionate about building tools that make financial management accessible to everyone.</p>
              </div>
            </div>
          </div>

        </div>

      </div>

    </section><!-- End Team Section -->





  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-5 col-md-12 footer-info">
            <a href="index.php" class="logo d-flex align-items-center">
              <img src="assets/img/logo.png" alt="">
              <span>FLouss++</span>
            </a>
            <p>Modern budget management application designed to help you track your income, expenses, and savings effortlessly. Take control of your finances today.</p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Quick Links</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="#hero">Home</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#about">About</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#features">Features</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#pricing">Pricing</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="NiceAdmin/pages-register.html">Register</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Application</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="NiceAdmin/dashboard.php">Dashboard</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="NiceAdmin/b_salsaire_input.php">Income</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="NiceAdmin/depenses_add.php">Expenses</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="NiceAdmin/b_epargne_input.php">Savings</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="NiceAdmin/view_insights.php">Insights</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
            <h4>Contact Us</h4>
            <p>
              <strong>Email:</strong> contact@floussplusplus.com<br>
            </p>
          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>FLouss++</span></strong>. All rights reserved.
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
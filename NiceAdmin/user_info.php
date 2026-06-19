<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username = $_SESSION['username'];
  $pageTitle = 'My Info';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';
  require 'php/get_info.php';
  require 'php/components/helpers.php';
  require_once 'php/user_info.php';
  $connexion = get_con_var();
  $user = (new UserRepository())->findByUsername($username);

  $updated = false;
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['currency'])) {
    $newCurrency = trim($_POST['currency']);
    (new UserRepository())->updateCurrency($username, $newCurrency);
    $_SESSION['currency'] = $newCurrency;
    $user['currency'] = $newCurrency;
    $updated = true;
  }

  $currencies = [
    'MAD' => 'Moroccan Dirham',
    'USD' => 'US Dollar',
    'EUR' => 'Euro',
    'GBP' => 'British Pound',
    'JPY' => 'Japanese Yen',
    'CNY' => 'Chinese Yuan',
    'CAD' => 'Canadian Dollar',
    'AUD' => 'Australian Dollar',
    'CHF' => 'Swiss Franc',
    'SEK' => 'Swedish Krona',
    'NOK' => 'Norwegian Krone',
    'DKK' => 'Danish Krone',
    'INR' => 'Indian Rupee',
    'BRL' => 'Brazilian Real',
    'ZAR' => 'South African Rand',
    'RUB' => 'Russian Ruble',
    'KRW' => 'South Korean Won',
    'SGD' => 'Singapore Dollar',
    'HKD' => 'Hong Kong Dollar',
    'TRY' => 'Turkish Lira',
    'MXN' => 'Mexican Peso',
    'TWD' => 'Taiwan Dollar',
    'PLN' => 'Polish Zloty',
    'THB' => 'Thai Baht',
    'IDR' => 'Indonesian Rupiah',
    'MYR' => 'Malaysian Ringgit',
    'PHP' => 'Philippine Peso',
    'CZK' => 'Czech Koruna',
    'ILS' => 'Israeli Shekel',
    'AED' => 'UAE Dirham',
    'SAR' => 'Saudi Riyal',
    'EGP' => 'Egyptian Pound',
    'QAR' => 'Qatari Riyal',
    'OMR' => 'Omani Rial',
    'BHD' => 'Bahraini Dinar',
    'KWD' => 'Kuwaiti Dinar',
    'TND' => 'Tunisian Dinar',
    'DZD' => 'Algerian Dinar',
    'LYD' => 'Libyan Dinar',
    'SDG' => 'Sudanese Pound',
    'NGN' => 'Nigerian Naira',
    'GHS' => 'Ghanaian Cedi',
    'KES' => 'Kenyan Shilling',
    'XAF' => 'CFA Franc BEAC',
    'XOF' => 'CFA Franc BCEAO',
  ];
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>My Info</h1>
      <?= ui_breadcrumb([
        ['label' => 'Home', 'url' => 'dashboard.php'],
        ['label' => 'My Info', 'active' => true],
      ]) ?>
    </div>

    <section class="section profile">
      <div class="row">
        <div class="col-xl-6">

          <div class="card">
            <div class="card-body pt-3">

              <?php if ($updated): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <i class="bi bi-check-circle me-1"></i> Currency updated to <strong><?= htmlspecialchars($newCurrency, ENT_QUOTES) ?></strong>.
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
              <?php endif; ?>

              <h5 class="card-title">Account Details</h5>

              <div class="row mb-3">
                <label class="col-md-4 col-lg-3 col-form-label">Username</label>
                <div class="col-md-8 col-lg-9">
                  <p class="form-control-plaintext"><?= htmlspecialchars($username, ENT_QUOTES) ?></p>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-md-4 col-lg-3 col-form-label">Name</label>
                <div class="col-md-8 col-lg-9">
                  <p class="form-control-plaintext"><?= htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''), ENT_QUOTES) ?></p>
                </div>
              </div>

              <form method="post" action="">
                <div class="row mb-3">
                  <label for="currency" class="col-md-4 col-lg-3 col-form-label">Currency</label>
                  <div class="col-md-8 col-lg-9">
                    <select class="form-select" name="currency" id="currency">
                      <?php foreach ($currencies as $code => $name): ?>
                        <option value="<?= $code ?>"<?= ($user['currency'] ?? 'MAD') === $code ? ' selected' : '' ?>>
                          <?= $code ?> — <?= htmlspecialchars($name, ENT_QUOTES) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    <div class="form-text">All monetary values will display with this currency symbol.</div>
                  </div>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
              </form>

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>

  <?php require 'php/partials/footer.php'; ?>

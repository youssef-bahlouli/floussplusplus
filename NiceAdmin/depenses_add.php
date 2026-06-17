<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];
  require 'php/get_info.php';
  require 'php/components/helpers.php';
  require 'php/repositories/DepenseRepository.php';

  $depenseRepo = new DepenseRepository();
  $lastExpense = $depenseRepo->getLatest($username);
  $historyNames = $depenseRepo->getAllOrderedByOccurrence($username);
  $allExpenses = iterator_to_array($depenseRepo->getAll($username));

  $expenseMap = [];
  foreach ($allExpenses as $exp) {
    $expenseMap[$exp['nom']] = $exp;
  }

  $default = $lastExpense ?: [];

  $pageTitle = 'Add Expense';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Add an Expense</h1>
      <?= ui_breadcrumb([
        ['label' => 'Home', 'url' => 'dashboard.php'],
        ['label' => 'Pages'],
        ['label' => 'Add Expense', 'active' => true],
      ]) ?>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-8">

          <ul class="nav nav-tabs" id="expenseTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab" aria-controls="manual" aria-selected="true">
                <i class="bi bi-pencil-square me-1"></i> Manual
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="quick-tab" data-bs-toggle="tab" data-bs-target="#quick" type="button" role="tab" aria-controls="quick" aria-selected="false">
                <i class="bi bi-clock-history me-1"></i> Quick
              </button>
            </li>
          </ul>

          <div class="tab-content" id="expenseTabsContent">

            <!-- Tab 1: Manual Entry -->
            <div class="tab-pane fade show active" id="manual" role="tabpanel" aria-labelledby="manual-tab">
              <?= new Card([
                'title' => 'Please fill in the information',
                'slot' => '<form action="./depenses_add_done.php" method="post">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nomManual" name="nom" placeholder="Expense name" value="' . htmlspecialchars($default['nom'] ?? '', ENT_QUOTES) . '" required>
                    <label for="nomManual">Expense name</label>
                  </div>
                  <div class="form-floating mb-3">
                    <textarea class="form-control" id="descManual" name="description" placeholder="Description" style="height:100px">' . htmlspecialchars($default['description'] ?? '', ENT_QUOTES) . '</textarea>
                    <label for="descManual">Description</label>
                  </div>
                  <div class="form-floating mb-3">
                    <select class="form-select" id="typeManual" name="type">
                      <option value="" disabled>Select type</option>
                      <option value="produits"' . (($default['type'] ?? '') === 'produits' ? ' selected' : '') . '>Products</option>
                      <option value="services"' . (($default['type'] ?? '') === 'services' ? ' selected' : '') . '>Services</option>
                      <option value="taxes"' . (($default['type'] ?? '') === 'taxes' ? ' selected' : '') . '>Taxes</option>
                    </select>
                    <label for="typeManual">Type</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="prixManual" name="prix" placeholder="Price" value="' . htmlspecialchars($default['prix'] ?? '', ENT_QUOTES) . '" required>
                    <label for="prixManual">Price</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="quantiteManual" name="quantite" placeholder="Quantity" value="' . htmlspecialchars($default['quantite'] ?? '1', ENT_QUOTES) . '">
                    <label for="quantiteManual">Quantity (optional)</label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary" onclick="document.querySelectorAll(\'#manual input, #manual select, #manual textarea\').forEach(e => { if(e.type !== \'hidden\') e.value = \'\'; }); return true;">Reset</button>
                  </div>
                </form>',
              ]) ?>
            </div>

            <!-- Tab 2: Quick Entry -->
            <div class="tab-pane fade" id="quick" role="tabpanel" aria-labelledby="quick-tab">
              <?php
                $historyOptions = [];
                foreach ($historyNames as $h) {
                  $historyOptions[] = ['value' => htmlspecialchars($h['nom'], ENT_QUOTES), 'label' => $h['nom'] . ' (' . $h['occurrences'] . 'x)'];
                }

                echo new Card([
                  'title' => 'Select from history',
                  'slot' => ($historyOptions
                    ? '<form action="./depenses_add_done.php" method="post">
                        <div class="form-floating mb-3">
                          <select class="form-select" id="historySelect" name="nom" onchange="fillFromHistory(this)">
                            <option value="" disabled selected>Choose an expense...</option>
                            ' . implode('', array_map(fn($o) => '<option value="' . $o['value'] . '">' . $o['label'] . '</option>', $historyOptions)) . '
                          </select>
                          <label for="historySelect">Recent Expenses</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" id="nomQuick" name="nom" placeholder="Expense name" required>
                          <label for="nomQuick">Expense name</label>
                        </div>
                        <div class="form-floating mb-3">
                          <textarea class="form-control" id="descQuick" name="description" placeholder="Description" style="height:100px"></textarea>
                          <label for="descQuick">Description</label>
                        </div>
                        <div class="form-floating mb-3">
                          <select class="form-select" id="typeQuick" name="type">
                            <option value="" disabled selected>Select type</option>
                            <option value="produits">Products</option>
                            <option value="services">Services</option>
                            <option value="taxes">Taxes</option>
                          </select>
                          <label for="typeQuick">Type</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="number" class="form-control" id="prixQuick" name="prix" placeholder="Price" required>
                          <label for="prixQuick">Price</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input type="number" class="form-control" id="quantiteQuick" name="quantite" placeholder="Quantity" value="1">
                          <label for="quantiteQuick">Quantity (optional)</label>
                        </div>
                        <div class="text-center">
                          <button type="submit" class="btn btn-primary">Submit</button>
                          <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                      </form>'
                    : '<p class="text-muted text-center">No previous expenses found.</p>'),
                ]);
              ?>
            </div>

          </div>

        </div>
      </div>
    </section>

  </main>

  <script>
    const expenseMap = <?= json_encode($expenseMap) ?>;

    function fillFromHistory(select) {
      const name = select.value;
      const exp = expenseMap[name];
      if (!exp) return;

      document.getElementById('nomQuick').value = exp.nom || '';
      document.getElementById('descQuick').value = exp.description || '';
      document.getElementById('typeQuick').value = exp.type || '';
      document.getElementById('prixQuick').value = exp.prix || '';
      document.getElementById('quantiteQuick').value = exp.quantite || '1';
    }

    <?php if ($historyOptions): ?>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('historySelect').value = '';
    });
    <?php endif; ?>
  </script>

  <?php require 'php/partials/footer.php'; ?>

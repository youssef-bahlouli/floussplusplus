<?php
  session_start();
  if(!isset($_SESSION['username'])){ header('Location: pages-login.html'); exit; }
  $username=$_SESSION['username'];
  require 'php/components/helpers.php';

  $pageTitle = 'Declarations';
  require 'php/partials/head.php';
  require 'php/partials/header.php';
  require 'php/partials/sidebar.php';
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Declarations</h1>
      <?= ui_breadcrumb([
        ['label' => 'Home', 'url' => 'dashboard.php'],
        ['label' => 'Declaration', 'active' => true],
      ]) ?>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i> <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="accordion" id="declarationsAccordion">

            <!-- Section 1: Budget Setup -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingBudget">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBudget" aria-expanded="true" aria-controls="collapseBudget">
                  <i class="bi bi-gear me-2"></i> Budget Setup
                </button>
              </h2>
              <div id="collapseBudget" class="accordion-collapse collapse show" aria-labelledby="headingBudget" data-bs-parent="#declarationsAccordion">
                <div class="accordion-body">
                  <p class="text-muted">Set your initial salary, balance, and savings.</p>
                  <form action="./budget_input_done.php" method="post">
                    <div class="row g-3">
                      <div class="col-md-4">
                        <div class="form-floating">
                          <input type="number" class="form-control" id="budgetSalaire" name="salaire" placeholder="Salary" required>
                          <label for="budgetSalaire">Salary</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-floating">
                          <input type="number" class="form-control" id="budgetReste" name="reste" placeholder="Balance">
                          <label for="budgetReste">Rest of Paycheck</label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-floating">
                          <input type="number" class="form-control" id="budgetEpargne" name="epargne" placeholder="Savings">
                          <label for="budgetEpargne">Savings</label>
                        </div>
                      </div>
                    </div>
                    <div class="text-center mt-3">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Section 2: Income Declaration -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingIncome">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIncome" aria-expanded="false" aria-controls="collapseIncome">
                  <i class="bi bi-cash-stack me-2"></i> Income Declaration
                </button>
              </h2>
              <div id="collapseIncome" class="accordion-collapse collapse" aria-labelledby="headingIncome" data-bs-parent="#declarationsAccordion">
                <div class="accordion-body">
                  <p class="text-muted">Record a new salary or receive your regular paycheck.</p>
                  <form action="./b_salsaire_input_done.php" method="post">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <div class="form-floating">
                          <input type="number" class="form-control" id="incomeSalaire" name="salaire" placeholder="Salary">
                          <label for="incomeSalaire">Salary</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating">
                          <input type="number" class="form-control" id="reste-id" name="reste" placeholder="Amount spent">
                          <label for="reste-id">Amount Spent</label>
                        </div>
                      </div>
                    </div>

                    <fieldset class="row mt-3">
                      <legend class="col-form-label col-sm-3 pt-0">Did you spend some of it?</legend>
                      <div class="col-sm-9">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="condition" id="conditionYes" value="yes" onclick="handleClick_salaire(this)" checked>
                          <label class="form-check-label" for="conditionYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="condition" id="conditionNo" value="no" onclick="handleClick_salaire(this)">
                          <label class="form-check-label" for="conditionNo">No</label>
                        </div>
                      </div>
                    </fieldset>

                    <div class="text-center mt-3">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <button type="submit" class="btn btn-success" name="action" value="receive">Receive Salary</button>
                      <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                    <div class="text-center mt-2">
                      <small class="text-muted">"Receive Salary" moves previous balance to savings and starts fresh.</small>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Section 3: Savings Declaration -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSavings">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSavings" aria-expanded="false" aria-controls="collapseSavings">
                  <i class="bi bi-piggy-bank me-2"></i> Savings Declaration
                </button>
              </h2>
              <div id="collapseSavings" class="accordion-collapse collapse" aria-labelledby="headingSavings" data-bs-parent="#declarationsAccordion">
                <div class="accordion-body">
                  <p class="text-muted">Add to your savings or set a new savings amount.</p>
                  <form action="./b_epargne_input_done.php" method="post">
                    <div class="row g-3">
                      <div class="col-md-6">
                        <div class="form-floating">
                          <input type="number" class="form-control" id="epargneAmount" name="epargne" placeholder="Savings amount" required>
                          <label for="epargneAmount">Savings Amount</label>
                        </div>
                      </div>
                    </div>

                    <fieldset class="row mt-3">
                      <legend class="col-form-label col-sm-3 pt-0">Is this added value?</legend>
                      <div class="col-sm-9">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="reponse" id="reponseYes" value="yes" checked>
                          <label class="form-check-label" for="reponseYes">Yes (add to existing)</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="reponse" id="reponseNo" value="no">
                          <label class="form-check-label" for="reponseNo">No (replace)</label>
                        </div>
                      </div>
                    </fieldset>

                    <div class="text-center mt-3">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
    </section>

  </main>

  <?php require 'php/partials/footer.php'; ?>

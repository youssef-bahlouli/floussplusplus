# Known Bugs

## Unfixed

### 1. No CSRF Protection
- **File:** All form pages (`pages-login.html`, `pages-register.html`, `declarations.php`, `depenses_add.php`, etc.)
- **Issue:** No CSRF tokens on any forms. External sites could submit forms on behalf of authenticated users.

### 2. Registration Success Shows Blank Page
- **File:** `NiceAdmin/pages-register.php`
- **Issue:** After successful registration, page renders an empty card div with no redirect to dashboard.
- **Fix needed:** Add `header('Location: dashboard.php'); exit;` after successful registration.

### 3. Dashboard Radar Chart Hardcoded Data
- **File:** `NiceAdmin/dashboard.php` (lines 90-95)
- **Issue:** Radar chart has hardcoded department names ("Administration: 16000", "Information Technology: 30000", etc.) from the NiceAdmin template. Should show expense categories (produits, services, taxes).

### 4. Pie Chart Uses Count Not Monetary Value
- **File:** `NiceAdmin/dashboard.php`
- **Issue:** Expense distribution pie chart counts number of expenses per type, not their total monetary value. One expensive "taxes" entry counts same as one cheap "produits" entry — misleading.

### 5. input_depenses() Double Deduction
- **File:** `NiceAdmin/php/input.php` (lines 13-18)
- **Issue:** When `reste <= total`, code sets `total = total - reste` then `epargne -= total`. The savings deduction should use only the remaining amount after reste is exhausted, not the adjusted total.

### 6. get_salaire() Returns Wrong Field
- **File:** `NiceAdmin/php/get_info.php` (line 6)
- **Issue:** `get_salaire()` returns `$budget['rest_du_cheque_final']` (remaining balance) instead of `$budget['salaire']` (actual salary). Function name is misleading.

### 7. bag_algorithm.php No Session Check
- **File:** `NiceAdmin/php/bag_algorithm.php`
- **Issue:** Reads `$_POST['username1']` directly without session validation. Potential security issue if accessible.

### 8. Unused Vendor Libraries Loaded
- **File:** `NiceAdmin/php/partials/footer.php`
- **Issue:** Quill, TinyMCE, Chart.js are loaded on every page but never used. Adds significant page weight (~500KB+).

### 9. No Input Validation on Financial Amounts
- **File:** `NiceAdmin/budget_input_done.php`, `NiceAdmin/b_salsaire_input_done.php`, `NiceAdmin/depenses_add_done.php`
- **Issue:** Salary, rest, savings, and expense prices accept negative values. No server-side validation prevents negative budgets or prices.

## Fixed

(none yet)

# Project: FLouss++

**Remote:** https://github.com/youssef-bahlouli/floussplusplus
**Local:** C:\work\my_work\flouss++\FLouss
**Language:** PHP 8 + MongoDB
**Purpose:** Personal budget management web app — paycheck-based expense tracking, savings, and financial insights

## Entry Points

### Landing Page
- `index.php` — Public marketing page (no auth). Links to login/register/dashboard.

### Authentication
- `NiceAdmin/pages-login.html` — Login form (static HTML)
- `NiceAdmin/pages-login.php` — Processes login → redirects to dashboard
- `NiceAdmin/pages-register.html` — Registration form (static HTML)
- `NiceAdmin/pages-register.php` — Creates user + initial budget + seed expense
- `NiceAdmin/pages-logout.php` — Destroys session, redirects to login

### Dashboard & Analytics
- `NiceAdmin/dashboard.php` — Main dashboard: stat cards, charts, expense table, activity log
- `NiceAdmin/view_insights.php` — Analytics: savings trends, expense breakdown, frequency, charts

### Data Entry (Declarations)
- `NiceAdmin/declarations.php` — Accordion form: budget setup, income, savings
- `NiceAdmin/budget_input_done.php` — Processes budget setup
- `NiceAdmin/b_salsaire_input_done.php` — Processes income / "Receive Salary"
- `NiceAdmin/b_epargne_input_done.php` — Processes savings declaration

### Expense Management
- `NiceAdmin/depenses_add.php` — Add expense form (manual + quick entry from history)
- `NiceAdmin/depenses_add_done.php` — Processes expense submission
- `NiceAdmin/depenses_view.php` — All expenses table with sort + period grouping

### Records
- `NiceAdmin/budget_view.php` — Budget history with change indicators (arrows)

### Profile
- `NiceAdmin/user_info.php` — User details + currency change (40+ currencies)

## Architecture

```
FLouss/
├── index.php                        # Landing page
├── config.php                       # MongoDB URI + DB name (gitignored)
├── composer.json                    # mongodb/mongodb dependency
├── assets/                          # Landing page assets (CSS, JS, images)
│   ├── css/style2.css
│   ├── js/main.js
│   ├── img/
│   └── vendor/                      # Bootstrap, AOS, Swiper, GLightbox, etc.
├── NiceAdmin/                       # *** APP ROOT ***
│   ├── *.php                        # Page controllers (12 pages)
│   ├── *.html                       # Static forms (login, register)
│   ├── php/                         # Backend logic
│   │   ├── database_connection.php  # MongoDB singleton connection
│   │   ├── account.php              # Login authentication
│   │   ├── analyse.php              # Expense statistics class
│   │   ├── bag_algorithm.php        # Bag payment processing
│   │   ├── get_info.php             # Data read helpers
│   │   ├── set_info.php             # Data write helpers
│   │   ├── get_tables.php           # Table data retrieval
│   │   ├── input.php                # Business logic for income/expenses/savings
│   │   ├── user_info.php            # User full name helper
│   │   ├── partials/                # Layout: head.php, header.php, sidebar.php, footer.php
│   │   ├── repositories/            # Repository pattern (Base, Budget, Depense, User, Bag)
│   │   ├── services/
│   │   │   └── LogService.php       # Activity logging service
│   │   └── components/              # Atomic design: atoms, molecules, organisms
│   └── assets/                      # Admin template assets (CSS, JS, images, vendor/)
├── vendor/                          # Composer autoload
└── Screens/                         # App screenshots for landing page
```

## Database (MongoDB: `flouss`)

| Collection | Purpose | Key Fields |
|-----------|---------|------------|
| `users` | User accounts | `_id` (username), `passwrd` (bcrypt), `first_name`, `last_name`, `currency` |
| `budgets` | Budget snapshots (append-only) | `username`, `salaire`, `rest_du_cheque_final`, `epargne`, `created_at` |
| `depenses` | Expenses | `username`, `nom`, `type` (produits/services/taxes), `prix`, `quantite`, `ddate` |
| `bag` | Savings jar | `username`, `value`, `jour` |
| `logs` | Activity audit trail | `username`, `action`, `details`, `type`, `created_at` |

## Key Design Decisions

- **Append-only budgets**: Every budget change creates a new record (not in-place update). Latest = highest `_id`.
- **Repository pattern**: Data access via `repositories/` (BaseRepository, BudgetRepository, DepenseRepository, UserRepository, BagRepository).
- **Atomic design components**: Reusable PHP UI components (atoms → molecules → organisms) with `__toString()`.
- **Session-based auth**: `$_SESSION['username']` guards all pages. bcrypt passwords, `session_regenerate_id()` on login.
- **Server-rendered only**: No JSON API endpoints. Traditional form POST/redirect pattern.
- **Mixed French/English**: Variable names and collection fields mix both languages.
- **Multi-currency**: 40+ currencies via `$_SESSION['currency']`.

# FLouss++ — Personal Budget Management

A self-hosted web application for tracking income, expenses, and savings with interactive dashboards and charts. Built with PHP + MongoDB + Bootstrap 5.

## Requirements

- PHP 8.0+
- [MongoDB](https://www.mongodb.com/try/download/community) 5.0+ (running on `localhost:27017`)
- [Composer](https://getcomposer.org/download/) — PHP dependency manager
- Web server: Apache (XAMPP), Nginx, or PHP built-in server

## Quick Start

1. **Clone or download** this repository into your web server's document root (e.g. `htdocs/` for XAMPP).

2. **Install PHP dependencies:**

   ```bash
   cd FlexStart/NiceAdmin
   composer install
   ```

3. **Ensure MongoDB is running** on `localhost:27017`. The app will create a database named `flouss` automatically.

   To customize the MongoDB connection, copy `config.example.php` to `config.php` (one level above `NiceAdmin/`) and edit the values.

4. **Migrate existing plaintext passwords** (only needed if upgrading from an older version):

   ```bash
   cd NiceAdmin
   php scripts/migrate_passwords.php
   ```

5. **Access the app** at `http://localhost/FlexStart/index.php` (or wherever you placed it).

## First Use

1. Click **Get Started** / **Register** to create an account
2. Log in and go to **Declaration → Declarations** to set up your first budget (salary + rest + savings)
3. Add expenses via **Declaration → Expenses**
4. View your dashboard, records, and insights from the sidebar

## Features

- **Dashboard** — overview cards showing Rest (with % of salary), Savings, and Budget (Savings + Rest)
- **Income Tracking** — regular salary entries and "Receive Salary" (rolls over rest + savings)
- **Expense Management** — Products, Services, and Taxes with quick-entry mode
- **Savings Goals** — declare savings with option for added value vs. regular deposit
- **Interactive Charts** — budget vs. expenses breakdown, category distribution, trend analysis
- **Insights & Analytics** — All tab (per-paycheck net result, expense trend, budget report, top expenses) and Advanced tab (period-over-period breakdown with AJAX switching)
- **Activity Logging** — full audit trail of income, expense, savings, and auth events
- **Multi-Currency** — 40+ currencies supported, configurable per user
- **Responsive UI** — Bootstrap 5 with collapsible sidebar, accordion forms, and modern tables

## Tech Stack

- **Backend:** PHP 8, MongoDB PHP driver (`mongodb/mongodb`)
- **Frontend:** Bootstrap 5, ApexCharts, jQuery, Simple DataTables
- **Template:** Based on NiceAdmin (BootstrapMade) — see License section

## Project Structure

```
FlexStart/
├── NiceAdmin/              # Application root
│   ├── scripts/            # Utility scripts (password migration, etc.)
│   ├── php/
│   │   ├── components/     # Reusable UI components (Table, StatCard, etc.)
│   │   ├── partials/       # Layout partials (header, sidebar, footer)
│   │   ├── repositories/   # Data access layer (UserRepository, etc.)
│   │   ├── services/       # Business logic (LogService, etc.)
│   │   ├── account.php     # Login authentication
│   │   ├── input.php       # Budget/income input logic
│   │   ├── set_info.php    # Data write helpers
│   │   └── get_info.php    # Data read helpers
│   ├── *.php               # Page controllers
│   ├── assets/             # Static assets (CSS, JS, images, vendor libs)
│   └── vendor/             # Composer dependencies (generated)
├── config.php              # MongoDB configuration (optional, uses defaults)
├── config.example.php      # Configuration template
├── index.php               # Landing page
└── Readme.md               # This file
```

---

_FLouss++ — because your money deserves a ++ too._

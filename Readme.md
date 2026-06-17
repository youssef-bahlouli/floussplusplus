# FLouss++ — Personal Budget Management Application

A modern web app for tracking personal finances: income, expenses, savings, with interactive dashboards.

## Requirements
- PHP 8.0+
- MongoDB 5.0+
- Composer

## Setup
1. Install dependencies: `composer install`
2. Copy `config.example.php` to `config.php` and update MongoDB settings
3. Ensure MongoDB is running on `localhost:27017` (or configure in `config.php`)
4. Access `index.php` from your web server

## Current Features
- User registration and authentication
- Income/salary tracking
- Expense management (Products, Services, Taxes)
- Savings goals
- Interactive dashboards and charts
- Detailed insights and analytics
- Activity logging

## Implementation Plan

### Feature 1: Dashboard Card — Show Rest + Percentage
**File:** `dashboard.php`
- Display **rest** (rest_du_cheque_final) as the primary stat on the first dashboard card
- Show percentage below: `(rest / salary) * 100%`
- Savings card stays as-is

### Feature 2: Fix "Receive Salary" Logic
**File:** `php/input.php` — `input_receive_salary()`
- Read salary from the **last budget record** instead of from POST
- New record: `salaire = last_salaire`, `rest = salaire`, `epargne = old_epargne + old_rest`
- Edge case: no previous record → show error, don't insert

### Feature 3: Combine Declarations into Single Page (Accordion)
**New file:** `declarations.php`
**Remove:** `budget_input.php`, `b_salsaire_input.php`, `b_epargne_input.php`
Three accordion sections:
1. **Budget Setup** — Salary + Rest + Savings initial setup
2. **Income Declaration** — New salary entry + Receive Salary
3. **Savings Declaration** — Savings entry with "Is this added value?" toggle

### Feature 4: Spending Question on Both Salary & Receive
**File:** `declarations.php` + `b_salsaire_input_done.php`
- Radio: "Did you spend some of this salary?" → Yes / No
- Shown for **both** regular salary submit **and** Receive Salary
- If Yes → show `reste` input; deduct spent amount from rest
- Edge case: spent > salary → clamp to 0, warn in log

### Feature 5: Expense Quick Entry
**File:** `depenses_add.php`
Two tabs:
- **Tab A — Manual:** Auto-fills inputs with last entered expense; includes Reset button
- **Tab B — Quick:** Dropdown listing past expense names; selecting auto-fills all fields
- Edge case: no history → show "No previous expenses" placeholder

### Feature 6: Sidebar & Navigation Updates
**File:** `php/partials/sidebar.php`
- Declaration submenu items point to `declarations.php`
- Update redirects in handler files
- Remove old file references

## Implementation Order
1. Feature 1 (Dashboard card)
2. Feature 2 (Receive Salary fix)
3. Feature 4 (Spending question on both)
4. Feature 3 (Accordion declarations page)
5. Feature 5 (Expense quick entry)
6. Feature 6 (Sidebar + redirects)

## Data Model
| Field | Type | Description |
|---|---|---|
| `salaire` | input | Salary amount |
| `rest_du_cheque_final` | input | Remaining from last paycheck |
| `epargne` | input | Savings amount |
| **Budget** | **calculated** | `salaire + epargne` (sum of savings + rest) |

## Credits
- Built on NiceAdmin template by BootstrapMade

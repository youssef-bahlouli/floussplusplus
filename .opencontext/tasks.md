# Tasks

## Open Tasks

| # | Title | Priority | Status |
|---|-------|----------|--------|
| 1 | Fix CSRF protection on all forms | HIGH | OPEN |
| 2 | Fix registration redirect (blank page after success) | HIGH | OPEN |
| 3 | Fix dashboard radar chart (replace hardcoded IT data) | MEDIUM | OPEN |
| 4 | Fix pie chart to use monetary value instead of count | MEDIUM | OPEN |
| 5 | Fix get_salaire() returning wrong field | MEDIUM | OPEN |
| 6 | Remove unused vendor libs (Quill, TinyMCE, Chart.js) from footer | LOW | OPEN |
| 7 | Add input validation for financial amounts (prevent negatives) | MEDIUM | OPEN |
| 8 | Add session check to bag_algorithm.php | HIGH | OPEN |

## Completed Tasks

### Vendor directories restored ✅ DONE
- Restored `NiceAdmin/assets/vendor/` (Bootstrap, Bootstrap Icons, Boxicons, Quill, Remixicon, ApexCharts, Chart.js, ECharts, Simple DataTables, TinyMCE)
- Restored `assets/vendor/` (AOS, Bootstrap, Bootstrap Icons, GLightbox, Remixicon, Swiper, PureCounter, Isotope)
- **Files:** `NiceAdmin/assets/vendor/*`, `assets/vendor/*`

### Composer dependencies installed ✅ DONE
- Ran `composer install` to generate `vendor/autoload.php`
- Created `config.php` from `config.example.php` (MongoDB URI: localhost:27017, DB: flouss)
- **Files:** `vendor/autoload.php`, `config.php`

### Tab pane CSS fix ✅ DONE
- Removed `show` class from inactive tab panes (tab2, tab3) in index.php
- **Files:** `index.php` (lines 321, 335)

### Opencontext populated ✅ DONE
- Created project.md, bugs.md, tasks.md, sessions.md
- **Files:** `.opencontext/*`

## Remaining Work

- Spring Boot backend: Upgrade MongoDB 4.0 → 4.4+ (required for Spring Boot 4.x driver compatibility)
- Angular frontend: Set up Angular project with proxy to Spring Boot backend
- Implement CORS config and proxy for frontend ↔ backend communication

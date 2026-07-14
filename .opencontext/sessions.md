# Session Log

## 2026-07-14 — Full Setup Session

### What Was Done
- Installed Java 21 (Temurin) at `C:\Program Files\Java\jdk-21`, set JAVA_HOME and PATH
- Created Spring Boot backend project (`C:\work\studying\full-stack-dev\Waffa\backend`) with MongoDB support
- Built REST API endpoints: `/flousplusplus/get-expenses`, `/get-budgets`, `/get-users`, `/get-logs`, `/get-bag`, `/browse/{database}/{collection}`
- Created Expense model, ExpenseRepository, MongoDbService, CorsConfig, ApiController
- Added `@EnableMongoRepositories` to fix Spring Boot 4.x bean detection
- Discovered MongoDB 4.0.6 is too old for Spring Boot 4.x driver (requires 4.2+)
- Reverted driver version override (4.11.1 incompatible with Spring Data MongoDB 4.x)
- PHP app (flouss++): Ran `composer install`, created `config.php`
- Restored all vendor CSS/JS directories (NiceAdmin + landing page)
- Fixed tab pane CSS bug in `index.php` (lines 321, 335)
- Cloned PHP app from GitHub to recover project
- Populated `.opencontext/` with full project context

### Decisions
- Using Spring Boot 4.1.1-SNAPSHOT + Java 21 + MongoDB for backend
- Angular for frontend (separate project at `waffa/frontend/`)
- MongoDB needs upgrade from 4.0 to 4.4+ — blocking Spring Boot backend functionality
- PHP app uses NiceAdmin Bootstrap template with atomic design components
- MongoDB collections: users, budgets, depenses, bag, logs (append-only budget pattern)

### Bugs Found
- No CSRF protection on PHP forms
- Registration doesn't redirect to dashboard
- Dashboard radar chart has hardcoded IT template data
- `get_salaire()` returns wrong field
- `input_depenses()` double deduction logic issue
- Unused vendor libs adding ~500KB page weight

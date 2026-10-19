# EnterpriseHub — Agent instructions

Laravel 12 internal application (PHP 8.2, MySQL, XAMPP). Blade + Tailwind CSS v4 + Vite + Alpine.js + Laravel Breeze.

## Stack & layout
- PHP 8.2 / Laravel 12 — `composer` (PHP), `npm` (frontend)
- Database: MySQL `enterprisehub` (root, no password) locally; tests use SQLite `:memory:` per `phpunit.xml`
- `sc_permission` uses `Name` (not `Code`) as permission identifier — migration `2026_10_19_104350` dropped the `Code` column
- Routes split by area: `routes/web.php`, `dashboard.php`, `security.php`, `master.php`, `transaction.php`, `reporting.php`, `setting.php`, `workflow.php`, `console.php`
- Layering (README): Model → Repository → Service → Controller → Request → Blade View
- Locale `id` (Indonesian); faker `id_ID`
- Live in: `app/Models/{Security,Master,EForm,Workflow}`, `app/Repositories/{...}`, `app/Services/{...}`, `app/Http/Controllers/{Security,Master,EForm,Workflow}`, `resources/views/{security,master,eform,workflow,layouts}`

## Setup
1. `composer install`
2. `npm install` — on this Windows box run npm from `cmd.exe` if PowerShell blocks `npm.ps1`
3. `.env` already exists with `APP_KEY`. Fresh clone: copy `.env.example` → `.env`, then `php artisan key:generate`
4. `php artisan migrate` then `php artisan db:seed` (migrate before seed)
5. Local DB dump: `dump-enterprisehub-202610151338.sql`

## Serving & frontend
- `php artisan serve` — app at http://127.0.0.1:8000
- `npm run dev` — Vite dev server (inputs: `resources/css/app.css`, `resources/js/app.js`)
- `npm run build` — production frontend build
- `composer dev` — `serve` + `queue:listen` + `pail` + `npm run dev` concurrently

## Tests (PHPUnit 11)
- All: `composer test` (runs `php artisan config:clear && php artisan test`)
- One file: `vendor/bin/phpunit tests/Feature/SecurityPermissionTest.php`
- One test: `vendor/bin/phpunit --filter <name>`
- Test DB: SQLite `:memory:`, `BCRYPT_ROUNDS=4`, `APP_ENV=testing`
- Working tree currently has uncommitted changes; test state reflects that.

## Code style
- `.editorconfig`: UTF-8, LF, 4-space indent, trim trailing whitespace, final newline
- PHP: `friendsofphp/php-cs-fixer` (@PSR12, config `.php-cs-fixer.dist.php` over `app/`); `laravel/pint` also installed
- No CI workflows or pre-commit config in repo.

## Git
- Single branch: `master` (tracks `origin/master`)
- README convention: `git status && git add -A && git commit -m "..." && git push origin master`

## Domain notes
- Security permissions: `CanOpen`, `CanAdd`, `CanEdit`, `CanDelete`
- Audit fields: `InputUser`, `InputDate`, `ModifUser`, `ModifDate`, `DeletedBy`, `DeletedDate`; soft delete via `DeletedBy`/`DeletedDate`; default audit user `Admin`
- Employee Equipment ID format: `EQP` + `YYYYMM` + `-` + sequence (e.g. `EQP202609-001`)
- Seeders: `database/seeders/{Security,Master,EForm,...}`
- **User Access (Security > User Access):**
  - Grid shows: Username, Full Name, Email, Job Title, Join Date, Status, Action
  - Grid ordered by Join Date desc, only active users (`IsActive = true`)
  - Job Title & Join Date sourced from `Tr_EmpForm` + `Tr_EmpFormHist` (latest) + `ms_job_title`
  - Button "Lihat Role" opens modal via `GET security/users/{user}/roles` (route `security.users.roles`)
  - Form: UserID readonly (edit), Employee Form ID dropdown (from `Tr_EmpForm`), Email, Phone Number, Roles ordered by `RoleID` ASC
- **Workflow / Approval engine:**
  - `WorkflowResolver::profileByEmpFormId()` does NOT select `h.UserID` (column doesn't exist on `tr_empformhist`)
  - `UniversalWorkflowSeeder` uses string IDs for department/division (`ITI`, `ITD`, `ITR`, `INT`) — not numeric
  - Transaction table `Status` columns are `varchar(50)` to fit values like `WAITING_APPROVAL` (migration `2026_10_19_153510`)
- **Employee ID generation (all EForm modules):**
  - `generateId()` di semua service EForm (EmpEmail, EmpApp, EmpEquip, EmpInfra, EmpITArea, EmpNetwork, EmpSharingFolder, EmpSoftware) menggunakan `withoutGlobalScope(EmployeeVisibilityScope::class)` agar ID unik terlihat di semua user, bukan hanya milik user login. Tanpa ini, duplicate key error akan terjadi saat user berbeda membuat transaksi sekaligus.
- **Employee Email grid:** `ReqUser` menampilkan `Username` dari `sc_user` (join via `EmpFormID`), bukan `EmpFormID` langsung. `EmpEmailController@index` melakukan `leftJoin sc_user` dan `addSelect u.Username as ReqUser`.
- **Grid sorting (4 prioritas) — semua 7 modul EForm + Employee Application:**
  - Prioritas 1: `Status = 'DRAFT'` AND `EmpFormID` = user login (diurutkan InputDate desc, ID desc)
  - Prioritas 2: `Status = 'WAITING_APPROVAL'` (diurutkan InputDate desc, ID desc)
  - Prioritas 3: `Status IN ('APPROVED', 'COMPLETED')` (diurutkan InputDate desc, ID desc)
  - Prioritas 4: `Status IN ('REJECTED', 'CANCELLED')` (diurutkan InputDate desc, ID desc)
  - Implementasi: `orderByRaw()` CASE statement di semua `*Repository::getAll()` + `EmpAppService::getAll()`, parameter `$empFormId` dilempar dari controller via `auth()->user()?->EmpFormId`
- **Visibility (EmployeeVisibilityScope):**
  - User dengan role `Transaction Approver` melihat semua data `Status = 'WAITING_APPROVAL'` lintas divisi/departemen, selain data dalam cakupan organisasinya sendiri
  - Staff hanya melihat data sendiri; Kabag melihat dept-nya; Kadiv melihat divisi-nya
  - Scope diterapkan via global scope `HasEmployeeVisibility` trait pada semua model EForm

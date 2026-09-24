# EnterpriseHub

EnterpriseHub adalah aplikasi internal berbasis **Laravel 12** untuk pengelolaan proses, master data, security, dan berbagai transaksi IT/Employee.

## Technology Stack

- Laravel 12
- PHP 8.2
- MySQL
- Bootstrap 5
- Vite
- Blade
- Alpine.js
- Laravel Breeze
- XAMPP
- Git / GitHub

## Project Structure

EnterpriseHub menggunakan pola aplikasi:

```text
Model
  ↓
Repository
  ↓
Service
  ↓
Controller
  ↓
Request
  ↓
Blade View
```

Routing dipisahkan berdasarkan area:

```text
routes/
├── master.php
├── security.php
└── transaction.php
```

## Modules

### Security

Module security yang sudah dibuat:

- Login / Authentication
- User Management
- Role Management
- Menu Management
- User Role
- Role Menu / Permission
- Forgot Password
- Reset Password
- Remember Me

Permission menggunakan konsep `CanOpen`, `CanAdd`, `CanEdit`, `CanDelete`, dan permission lain sesuai kebutuhan menu.

---

### Master

#### Organization / Regional Master

- Company
- Country
- Province
- City
- District
- Village
- Directorate
- Division
- Department

#### Employee / HR Master

- Religion
- Job Level
- Job Title

#### IT Master

- Email Group
- Code of Conduct (COC)
- Asset Group
- Asset Type
- Currency
- Asset

#### Code of Conduct

COC yang sudah tersedia:

- COC Employee Equipment
- COC Employee VPN Access
- COC Employee Email
- COC Employee Software
- COC Employee Network
- COC Employee Network Drive

---

### Transaction

Transaction yang sudah dibuat / sedang dikembangkan:

#### Employee Form

- Employee Form Request
- Employee Form History
- Employee Form Action

#### Employee IT / Access

- Employee Network
- Employee IT Area
- Employee Email
- Employee Email Detail
- Employee Application
- Employee Equipment
- Employee Infra
- Employee Network Drive
- Employee Software

## Employee Equipment

Module yang sedang dikembangkan menggunakan table `Tr_EmpEquip`.

Konsep utama:

- Satu request dapat memilih lebih dari satu asset.
- Asset dipilih menggunakan checklist.
- Satu asset menghasilkan satu record `Tr_EmpEquip`.
- `EmpEquipID` menggunakan format:

```text
EQP + YYYY + MM + "-" + sequence
```

Contoh:

```text
EQP202609-001
EQP202609-002
EQP202609-003
```

Asset dapat difilter berdasarkan **Asset Type** agar data yang ditampilkan tidak terlalu banyak.

Checklist asset yang sudah dipilih tetap disimpan ketika user berpindah Asset Type.

## UI Standard

EnterpriseHub menggunakan standard tampilan berdasarkan jenis module.

### Master & Security

Menggunakan pola:

- Search
- Pagination
- Action per row
- Edit
- Delete
- Create / Add di bagian atas

### Transaction

Menggunakan pola:

- Search Everything
- Select row
- Pagination
- Create
- Update
- Delete di bagian bawah grid

Transaction menggunakan Employee Form Request sebagai referensi tampilan.

## Audit

Module master menggunakan field audit:

```text
InputUser
InputDate
ModifUser
ModifDate
DeletedBy
DeletedDate
```

Soft delete menggunakan `DeletedBy` dan `DeletedDate`.

Default audit user:

```text
Admin
```

## Database

Database utama:

```text
enterprisehub
```

Database menggunakan MySQL.

## Development

Install dependency:

```bash
composer install
npm install
```

Build frontend:

```bash
npm run build
```

Development:

```bash
npm run dev
```

Laravel:

```bash
php artisan serve
```

Migration:

```bash
php artisan migrate
```

Seed:

```bash
php artisan db:seed
```

## Git

Branch utama:

```text
master
```

Untuk menyimpan seluruh progress project:

```bash
git status
git add -A
git status
git commit -m "Continue EnterpriseHub development"
git push origin master
```

Setelah push:

```bash
git status
```

Target:

```text
nothing to commit, working tree clean
```

## Current Development Status

EnterpriseHub sudah memiliki foundation untuk:

- Authentication & Security
- Role & Permission
- Master Data
- Regional Master Indonesia
- Employee Form
- Employee IT Request
- Code of Conduct
- Asset Management
- Employee Equipment

Development berikutnya akan melanjutkan module transaction dan workflow yang terkait dengan proses Employee / IT.

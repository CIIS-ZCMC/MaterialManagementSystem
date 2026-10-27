<div align="center">

# 🏥 ZCMC Material Management System

### *Enterprise Inventory, Procurement & Supply Logistics Platform*

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![React](https://img.shields.io/badge/React-19.x-61DAFB?style=for-the-badge&logo=react&logoColor=black)](https://react.dev)
[![Inertia.js](https://img.shields.io/badge/Inertia.js-3.x-9553E9?style=for-the-badge&logo=inertia&logoColor=white)](https://inertiajs.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![PHPStan](https://img.shields.io/badge/PHPStan-Strict_Passing-4B5563?style=for-the-badge&logo=php&logoColor=white)](https://phpstan.org)
[![Pest](https://img.shields.io/badge/Pest_Testing-Passed-success?style=for-the-badge&logo=pest&logoColor=white)](https://pestphp.com)

---

**MaterialManagementSystem (MMS)** is the centralized hospital inventory, supply chain, and procurement platform for **Zamboanga City Medical Center (ZCMC)**. It provides real-time tracking of medical and non-medical supplies, stock level monitoring, requisitions, and auditable procurement workflows.

[Architecture Guide](./ARCHITECTURE.md) • [Workflow Guide](./.devin/workflows/implementationguide.md) • [DTRService Reference](file:///D:/ZCMC_SYSTEMS/DTRService)

</div>

---

## 📑 Table of Contents

- [Overview](#-overview)
- [System Architecture](#-system-architecture)
- [Key Features](#-key-features)
- [Tech Stack](#-tech-stack)
- [Project Structure](#-project-structure)
- [Getting Started](#-getting-started)
- [Architecture & Pattern Levels](#-architecture--pattern-levels)
- [Testing & Quality Assurance](#-testing--quality-assurance)
- [Useful Commands](#-useful-commands)
- [ZCMC Systems Ecosystem](#-zcmc-systems-ecosystem)

---

## 🌟 Overview

The **Material Management System** manages hospital materials end-to-end:
- **Central Supply & Property Office**: Real-time asset catalog, batch/lot tracking, expiry alerts, and stock adjustments.
- **Department Requisitions**: Digital Requisition and Issue Slips (RIS), approvals, and item release workflows.
- **Audit & Governance**: Complete stock ledger logs, user authorization, and activity tracking across hospital departments.

It is standardized to share the exact architectural principles, code conventions, and layer separation as [ZCMC DTRService](file:///D:/ZCMC_SYSTEMS/DTRService).

---

## 🏛️ System Architecture

MaterialManagementSystem follows a decoupled **Controller → Service → Repository → Model** architectural pattern with dependency injection:

```
┌─────────────────────────────────────────────────────────────┐
│                    Web & Inertia Routes                     │
│                  (routes/web.php, settings.php)             │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                      HTTP Controllers                       │
│                   (app/Http/Controllers/)                   │
│      Accepts requests, handles FormRequests & Resources     │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                       Services Layer                        │
│                      (app/Services/)                        │
│      Business logic, atomic DB transactions, audit logging  │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                Contracts & Repositories Layer               │
│          (app/Contracts/  ◄──►  app/Repositories/)          │
│      Decoupled interfaces, reusable Eloquent query logic    │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                        Database Layer                       │
│                        (app/Models/)                        │
│      Eloquent entities, relations, scopes, and casts        │
└─────────────────────────────────────────────────────────────┘
```

---

## 🚀 Key Features

| Category | Highlights |
| :--- | :--- |
| **Material Catalog** | Standardized item masterlist, barcode/item code tracking, categories, and unit specifications. |
| **Inventory Control** | Real-time stock on hand, reorder thresholds, batch/lot number tracking, and automated stock adjustment ledgers. |
| **Requisition & Dispatch** | Requisition slip generation, multi-tier approvals, issue tracking, and departmental transfer logs. |
| **Standardized Architecture** | Standard base repositories, service transaction wrappers, resource transformers, and trait helpers. |
| **Security & Auditing** | Laravel Fortify authentication, two-factor authentication (2FA), password security policies, and session controls. |
| **Modern User Experience** | Single-page application (SPA) speed with React and Inertia.js, styled with modern Tailwind CSS and Lucide icons. |

---

## 💻 Tech Stack

### Backend
- **Framework**: Laravel 13
- **Language**: PHP 8.3+
- **Authentication**: Laravel Fortify (with 2FA support)
- **API / Transformation**: Laravel API Resources
- **Routing**: Laravel Wayfinder

### Frontend
- **SPA Bridge**: Inertia.js v3
- **UI Framework**: React 19
- **Styling**: Tailwind CSS v4
- **Components**: Radix UI primitives & Lucide React icons
- **Build Tool**: Vite

### Code Quality & Testing
- **Test Runner**: Pest PHP v5 & PHPUnit
- **Static Analysis**: PHPStan (Strict typing verified)
- **Code Formatter**: Laravel Pint

---

## 📂 Project Structure

```
MaterialManagementSystem/
├── app/
│   ├── Actions/                  # Single-action classes (e.g. Fortify password resets)
│   ├── Concerns/                 # Validation rules and shared concerns
│   ├── Console/Commands/         # Artisan CLI commands
│   ├── Contracts/                # Interface contracts for repositories & services
│   │   ├── BaseRepositoryInterface.php
│   │   └── UserRepositoryInterface.php
│   ├── Http/
│   │   ├── Controllers/          # Lean controllers (Settings, Materials, Users)
│   │   ├── Middleware/           # Inertia, appearance, and auth middleware
│   │   ├── Requests/             # Form validation & authorization rules
│   │   └── Resources/            # API & Inertia resource transformers
│   ├── Models/                   # Eloquent database models (User, Material, etc.)
│   ├── Providers/                # Service providers & dependency injection bindings
│   │   └── AppServiceProvider.php
│   ├── Repositories/             # Data access & Eloquent query implementations
│   │   ├── BaseRepository.php    # Generic CRUD query layer
│   │   └── UserRepository.php
│   ├── Services/                 # Business logic & atomic transactions
│   │   ├── BaseService.php       # DB transaction & error handling helpers
│   │   └── UserService.php
│   └── Traits/                   # Reusable traits (ApiResponseTrait, Filterable)
├── database/
│   ├── factories/                # Model factories for testing
│   ├── migrations/               # Database migration schemas
│   └── seeders/                  # Database seeders
├── resources/
│   ├── js/                       # Inertia React components & pages
│   └── css/                      # Tailwind styling
├── routes/
│   ├── web.php                   # Web application routes
│   ├── settings.php              # User profile & security routes
│   └── console.php               # Scheduled artisan commands
├── tests/
│   ├── Feature/                  # Feature and integration tests (Pest)
│   └── Unit/                     # Unit tests
├── ARCHITECTURE.md               # Detailed architecture guide & specifications
└── README.md                     # Project documentation
```

---

## 🏁 Getting Started

### Prerequisites

Ensure the following tools are installed on your machine:
* **PHP** >= 8.3 with SQLite / MySQL extensions enabled
* **Composer** >= 2.7
* **Node.js** >= 20.x & **npm**

### Installation

1. **Clone or navigate to the project directory**:
   ```bash
   cd D:\ZCMC_SYSTEMS\MaterialManagementSystem
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**:
   ```bash
   npm install
   ```

4. **Setup environment file**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

6. **Start the development servers**:
   ```bash
   composer dev
   ```
   *This starts the Laravel backend, queue worker, and Vite dev server simultaneously.*

---

## 📐 Architecture & Pattern Levels

To balance speed of development with enterprise scalability, developers choose between **three implementation levels** based on feature complexity:

| Level | Pattern | When to Use | Key Files |
| :--- | :--- | :--- | :--- |
| **Level 1** | `Controller → Model` | Simple lookups, static reference tables, read-only listings | Controller, Model |
| **Level 2** | `Controller → Service → Model` | Custom workflows, calculations, notifications, single-entity operations | Controller, Service, Model |
| **Level 3** | `Controller → Service → Repository → Model` | Core enterprise modules (Materials, Requisitions, Purchase Orders, Users) | Controller, Service, Contract, Repository, Model |

👉 **Read the complete guide in [ARCHITECTURE.md](./ARCHITECTURE.md) and [.devin/workflows/implementationguide.md](./.devin/workflows/implementationguide.md).**

---

## 🧪 Testing & Quality Assurance

Maintain strict coding standards across all contributions:

```bash
# Run the automated Pest test suite
php artisan test

# Check code formatting with Laravel Pint
composer lint:check

# Auto-fix code formatting with Laravel Pint
composer lint

# Run strict PHPStan static analysis
composer types:check

# Run full CI check (Types + Pint + Tests + Frontend)
composer ci:check
```

---

## 🔧 Useful Commands

| Command | Description |
| :--- | :--- |
| `composer dev` | Launch Laravel backend, Vite frontend, and log watcher in parallel |
| `php artisan test` | Execute test suite |
| `php artisan migrate:status` | Check applied database migrations |
| `php artisan route:list` | View all registered application routes |
| `npm run build` | Compile and bundle production assets |

---

## 🏥 ZCMC Systems Ecosystem

| System | Role | Path / Reference |
| :--- | :--- | :--- |
| **MaterialManagementSystem** | Hospital Materials, Supply Chain & Inventory | `D:\ZCMC_SYSTEMS\MaterialManagementSystem` |
| **DTRService** | Biometric Terminals, Real-time Attendance & DTR | `D:\ZCMC_SYSTEMS\DTRService` |

---

<div align="center">

**Zamboanga City Medical Center (ZCMC)**  
*Management Information Systems & IMISS*  
© 2026 ZCMC. All rights reserved.

</div>

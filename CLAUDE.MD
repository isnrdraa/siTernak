\# CLAUDE.md



\## Project Name

SiTernak



\## Product Vision

SiTernak adalah platform SaaS multi-tenant untuk manajemen usaha peternakan.

Satu platform dapat digunakan oleh banyak pemilik usaha, dan setiap pemilik usaha memiliki organisasi, admin, dan staffnya sendiri dengan data yang terisolasi.



Fokus awal:

\- peternakan ayam petelur

\- pencatatan operasional harian

\- manajemen user per usaha

\- laporan dan monitoring usaha



Aplikasi harus dirancang agar nantinya bisa dikembangkan ke jenis peternakan lain.



\---



\## Core Product Concept

Bangun aplikasi web modern bernama SiTernak dengan konsep multi-tenant SaaS.



Struktur level user:

1\. Platform Super Admin

&#x20;  - mengelola seluruh tenant/usaha

&#x20;  - mengelola paket/langganan

&#x20;  - memantau statistik global sistem

&#x20;  - tidak ikut operasional harian tenant



2\. Tenant Owner

&#x20;  - pemilik usaha peternakan

&#x20;  - akses penuh untuk tenant miliknya

&#x20;  - membuat dan mengelola admin/staff tenant

&#x20;  - melihat semua laporan tenant



3\. Tenant Admin

&#x20;  - membantu owner mengelola operasional tenant

&#x20;  - mengelola master data

&#x20;  - memantau aktivitas staff

&#x20;  - melihat laporan sesuai izin



4\. Supervisor

&#x20;  - memantau operasional lapangan

&#x20;  - validasi data input staff

&#x20;  - memantau kandang, produksi, pakan, kesehatan



5\. Staff / Operator

&#x20;  - input data harian

&#x20;  - akses terbatas sesuai tugas

&#x20;  - tidak boleh melihat data tenant lain

&#x20;  - tidak boleh mengakses pengaturan penting



\---



\## Mandatory Architecture Rules

\- Gunakan arsitektur multi-tenant.

\- Semua data tenant harus terisolasi dengan jelas.

\- Setiap entitas bisnis harus memiliki `tenant\_id`.

\- Tidak boleh ada kebocoran data antar tenant.

\- Terapkan role-based access control (RBAC).

\- Semua query yang mengambil data tenant harus terfilter berdasarkan `tenant\_id`.

\- Pastikan authorization dicek di backend, bukan hanya di frontend.

\- Tulis kode yang modular, rapi, dan scalable.

\- Gunakan naming yang konsisten dan mudah dipahami.

\- Hindari hardcoded values.

\- Gunakan validasi input di semua endpoint/form.

\- Tambahkan audit log untuk aksi penting jika memungkinkan.



\---



\## MVP Features

Bangun MVP dengan modul berikut:



\### 1. Authentication \& Organization

\- login

\- register tenant baru

\- create organization / usaha

\- invite user ke tenant

\- manajemen profil user

\- ganti password

\- role \& permission per tenant



\### 2. Tenant Management

\- data usaha

\- data kandang

\- data populasi ternak

\- data staff per tenant



\### 3. Daily Operations

\- input produksi harian

\- input konsumsi pakan harian

\- input kesehatan / mortalitas

\- catatan aktivitas harian

\- validasi data oleh supervisor/admin



\### 4. Reporting

\- dashboard ringkasan tenant

\- laporan produksi

\- laporan konsumsi pakan

\- laporan kesehatan / kematian

\- laporan aktivitas harian

\- grafik tren sederhana



\### 5. Platform Super Admin

\- daftar semua tenant

\- status tenant aktif/nonaktif

\- statistik jumlah tenant

\- statistik jumlah user

\- kontrol paket/langganan (basic placeholder)

\- ability suspend tenant jika dibutuhkan



\---



\## Recommended Database Entities

Saat merancang database, minimal siapkan entitas berikut:



\- tenants

\- users

\- tenant\_users

\- roles

\- permissions

\- cages

\- flocks

\- daily\_productions

\- feed\_logs

\- health\_logs

\- mortality\_logs

\- activity\_logs

\- subscriptions

\- audit\_logs



Relasi penting:

\- satu tenant punya banyak user

\- satu tenant punya banyak kandang

\- satu tenant punya banyak data operasional

\- satu user bisa punya role berbeda hanya dalam konteks tenant tertentu jika diperlukan



\---



\## UX / UI Direction

Desain UI harus:

\- modern

\- clean

\- simple

\- business-oriented

\- mudah digunakan pemilik usaha dan staff lapangan



Prioritas UX:

\- dashboard jelas

\- form input harian cepat

\- navigasi sederhana

\- mobile-friendly

\- minim kebingungan bagi pengguna non-teknis



Gunakan pendekatan:

\- sidebar untuk modul utama

\- dashboard cards untuk KPI

\- tabel + filter untuk data

\- form yang ringkas

\- status badge untuk role dan status data



\---



\## Technical Expectations

Saat mengerjakan task:

\- selalu jelaskan struktur folder yang dibuat

\- buat file dan komponen secara terorganisir

\- pecah komponen yang terlalu besar

\- buat reusable components bila masuk akal

\- tulis migration/schema dengan rapi

\- gunakan seed data seperlunya untuk demo

\- jika menambah endpoint, jelaskan request/response shape

\- jika menambah role/permission, pastikan dijelaskan mapping aksesnya



Jika ada asumsi yang perlu diambil:

\- pilih asumsi yang paling aman dan scalable

\- jelaskan asumsi itu secara singkat



\---



\## Coding Behavior

Ketika diminta membuat fitur:

1\. pahami dulu konteks multi-tenant

2\. cek apakah fitur menyentuh tenant isolation

3\. cek apakah perlu permission

4\. implement backend logic dulu bila relevan

5\. lalu implement UI

6\. tambahkan validasi

7\. pastikan edge case dasar ditangani



Jangan membuat solusi yang hanya cocok untuk single-tenant.



\---



\## What to Prioritize First

Jika belum ada arahan lain, kerjakan berurutan:

1\. auth + tenant structure

2\. role \& permission

3\. master data tenant

4\. input operasional harian

5\. dashboard \& laporan

6\. super admin panel



\---



\## Deliverable Style

Setiap selesai mengerjakan task:

\- jelaskan apa yang dibuat

\- file apa saja yang ditambah/diubah

\- alur logika singkat

\- hal yang masih perlu dilanjutkan

\- potensi risiko atau improvement



\---



\## First Build Request

Mulai dengan membangun fondasi project SiTernak untuk MVP multi-tenant SaaS:

\- auth

\- tenant setup

\- role system

\- dashboard basic

\- struktur database inti

\- halaman manajemen user tenant



Gunakan struktur yang siap dikembangkan.

Jangan bangun mockup statis saja; buat fondasi yang realistis untuk produk SaaS.

===

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4
- laravel/framework (LARAVEL) - v13
- laravel/prompts (PROMPTS) - v0
- laravel/boost (BOOST) - v2
- laravel/breeze (BREEZE) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- alpinejs (ALPINEJS) - v3
- tailwindcss (TAILWINDCSS) - v3

## Skills Activation

This project has domain-specific skills available. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

- `laravel-best-practices` — Apply this skill whenever writing, reviewing, or refactoring Laravel PHP code. This includes creating or modifying controllers, models, migrations, form requests, policies, jobs, scheduled commands, service classes, and Eloquent queries. Triggers for N+1 and query performance issues, caching strategies, authorization and security patterns, validation, error handling, queue and job configuration, route definitions, and architectural decisions. Also use for Laravel code reviews and refactoring existing Laravel code to follow best practices. Covers any task involving Laravel backend PHP code patterns.
- `pest-testing` — Use this skill for Pest PHP testing in Laravel projects only. Trigger whenever any test is being written, edited, fixed, or refactored — including fixing tests that broke after a code change, adding assertions, converting PHPUnit to Pest, adding datasets, and TDD workflows. Always activate when the user asks how to write something in Pest, mentions test files or directories (tests/Feature, tests/Unit, tests/Browser), or needs browser testing, smoke testing multiple pages for JS errors, or architecture tests. Covers: test()/it()/expect() syntax, datasets, mocking, browser testing (visit/click/fill), smoke testing, arch(), Livewire component tests, RefreshDatabase, and all Pest 4 features. Do not use for factories, seeders, migrations, controllers, models, or non-test PHP code.
- `tailwindcss-development` — Always invoke when the user's message includes 'tailwind' in any form. Also invoke for: building responsive grid layouts (multi-column card grids, product grids), flex/grid page structures (dashboards with sidebars, fixed topbars, mobile-toggle navs), styling UI components (cards, tables, navbars, pricing sections, forms, inputs, badges), adding dark mode variants, fixing spacing or typography, and Tailwind v3/v4 work. The core use case: writing or fixing Tailwind utility classes in HTML templates (Blade, JSX, Vue). Skip for backend PHP logic, database queries, API routes, JavaScript with no HTML/CSS component, CSS file audits, build tool configuration, and vanilla CSS.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.
- To check environment variables, read the `.env` file directly.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== tests rules ===

# Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

</laravel-boost-guidelines>

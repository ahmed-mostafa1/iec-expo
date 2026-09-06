# Portal Check-In Feature — Implementation Plan (LOCKED)

## Goal
Employees scan a registrant's QR badge (visitor/sponsor/icon/icon-plus/icon-quartet/icon-plus-quartet)
with a mobile camera at the event portal. Each scan is recorded with the registrant's data, the
scanning employee, and the timestamp. Full admins can view/export all check-ins.

## Decisions locked in
- Employee accounts are **fully separate** from Admin: own table, own guard, own login — not a role
  on the existing `admins` table.
- Admins get a full **CRUD screen** to manage the 4 (or more) employee accounts — no seeder/fixed list.
- Duplicate scans: **warn but allow**. Every attempt is logged; if a badge was already scanned, the
  employee sees who/when and can confirm to log it again anyway.
- Check-in records store a **live relation** to the registration (polymorphic), not a frozen data
  snapshot — registrant data is always read fresh from the source registration record.
- Camera scanning must work on mixed devices including iPhone/Safari → use **jsQR** (new lightweight
  npm dependency), not the native `BarcodeDetector` API (Chrome/Android only).
- Admin check-ins page is named **"Check-ins"** (table: `check_ins`, route: `admin.check-ins.*`).

## 1. Employee accounts (separate from Admin, full CRUD)
- New `employees` table + `Employee` model: `name`, `email`, `password`, timestamps.
- New `employee` guard + `employees` provider in `config/auth.php`, alongside the existing `admin` guard.
- **Admin CRUD** (full admins only): `EmployeeController` (`index/create/store/edit/update/destroy`)
  under `/admin/employees`, inline `$request->validate()`, Blade views under
  `resources/views/admin/employees/*` — mirrors `ParticipantController`/`OrganizerController`.
  - Create/edit form sets the password; edit leaves password blank = keep current.
  - New sidebar nav item "Employees" in `resources/views/layouts/admin.blade.php`.
- Separate employee login (not the admin login):
  - `GET/POST /portal/login`, `POST /portal/logout`.
  - Minimal Blade view mirroring the existing admin login.
  - `auth:employee` middleware protects everything under `/portal`.

## 2. Check-in records
- Migration: `check_ins` table — `registrant_type`, `registrant_id` (polymorphic; covers all 6
  registration types), `employee_id` (FK → `employees`), `scanned_at`, timestamps. Index on
  `(registrant_type, registrant_id)` and on `employee_id`.
- `CheckIn` model: `belongsTo(Employee::class)`, `morphTo('registrant')`.
- Extract the type→model map currently duplicated as `BadgeController::TYPE_MODELS` into one shared
  location (used for the morph map and by the scan controller) instead of duplicating it.
- No snapshot columns — registrant data (`full_name`, `email`, `phone`, `company_name`/`organization`,
  etc.) is always read live off the related registration model.

## 3. Scan page (`/portal/scan`, employee-facing)
- Blade view with `<video>` camera feed via `getUserMedia`.
- Client-side JS: **jsQR** decodes frames from a canvas in an animation-frame loop.
- On a successful decode, `fetch` POSTs the raw decoded text (the signed badge URL) to
  `Portal\ScanController@store`.
- Backend validation: reconstruct the URL as a request (`Request::create($url)`) and call
  `hasValidSignature()` — reuses the exact signing logic already in `App\Models\Concerns\HasQrTicket`
  (`URL::signedRoute('public.badge.show', ...)`). Invalid/forged/tampered QR text is rejected with no
  record created.
- Resolve `type` + `registration` id from the validated URL → look up the registrant via the shared
  type→model map.
- Duplicate check: if a `CheckIn` already exists for that registrant, respond with
  `duplicate: true` + the existing check-in's employee name and `scanned_at`. Frontend shows a warning
  banner with a "Scan anyway" confirm button that resubmits with an explicit confirm flag to insert
  another `CheckIn` row.
- On success (first scan or confirmed duplicate): insert `CheckIn` (`employee_id` = authenticated
  employee, `scanned_at` = now), return JSON with the registrant's name/company/badge-type label for
  on-screen confirmation. UI shows a success/warning card for a couple of seconds, then resumes scanning.

## 4. Admin "Check-ins" page (existing `admin` guard, full admins only)
- New sidebar nav item "Check-ins".
- `app/Livewire/Admin/CheckInsTable.php` + Blade view, following the same pattern as
  `VisitorRegistrationsTable`: search (registrant name/email, employee name), filter by registrant
  type and by employee, sort by `scanned_at` desc, paginated.
- `GET /admin/check-ins` → `admin.check-ins.index`.
- `GET /admin/check-ins/export` → `admin.check-ins.export`, CSV via the same `fputcsv` +
  `StreamedResponse` pattern already used in `VisitorRegistrationController::export` (no new library).
  Columns: Scan time, Employee, Registrant type, Full name, Email, Phone, Company/Organization.

## 5. Security / edge cases
- Signed-URL validation blocks forged or edited QR payloads — can't fabricate a scan for a
  nonexistent/arbitrary registration.
- `employees` table/guard is fully isolated from `admins` — a compromised employee login can only hit
  `/portal/*` (camera scan + login/logout), never the rest of the admin dashboard.
- Camera permission denial shows a clear on-page error.

## Out of scope (YAGNI) — add later only if requested
- No self-service password reset for employee accounts (admin resets via the Employees CRUD edit form).
- No offline queueing — scanning requires live connectivity, same as the rest of the site.
- No edit/delete UI for individual `check_ins` rows (it's an attendance log, not editable data).
- No per-employee personal scan-history view (only full admins see the aggregate Check-ins page).

## New dependency
- `jsQR` (npm) — camera QR decoding, cross-browser including iOS Safari.

## Build order (once approved)
1. Migrations: `employees`, `check_ins`. `Employee` model, `employee` guard/provider.
2. Admin Employees CRUD (controller, routes, views, sidebar link).
3. Employee portal login/logout (routes, controller, view, `auth:employee` middleware).
4. Shared registration type→model map (extracted from `BadgeController`). `CheckIn` model + morph map.
5. `Portal\ScanController` (signature validation, duplicate check, check-in creation) + scan Blade view
   + jsQR integration (`npm install jsqr`, wire into Vite entry for the portal scan page).
6. Admin `CheckInsTable` Livewire component + view + routes + CSV export + sidebar link.
7. Tests: signature validation (valid/invalid/tampered), duplicate-scan warn-then-confirm flow,
   employee CRUD, check-ins CSV export, `auth:employee` route protection.

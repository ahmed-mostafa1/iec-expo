# Icon Plus Registration Implementation

## Status

Implemented.

Icon Plus now exists as a separate registration type with its own database table, model, public route, admin page, queued PDF lifecycle, mail notification, landing-page UI, hall-map behavior, and `public/contract-icon-plus.docx` contract template.

## Implemented Scope

### Data Model And Backend

- Added `icon_plus_registrations` table with contact fields, company/location fields, upload paths, PDF lifecycle fields, workflow status, and timestamps.
- Added `App\Models\IconPlusRegistration` with fillable fields, `pdf_generated_at` cast, and persistable-attribute filtering equivalent to `IconRegistration`.
- Added `App\Http\Requests\IconPlusRegistrationRequest` with Icon-equivalent required fields and PDF upload validation.
- Added shared booth logic in `App\Services\HallSpaceService`.
- Added backend booth validation:
  - Icon Plus accepts only `L.W.1` through `L.W.28` and `R.W.1` through `R.W.28`.
  - Icon rejects those Icon Plus spaces.
  - Icon and Icon Plus both reject occupied/manual-held spaces.
- Added `App\Http\Controllers\Public\IconPlusRegistrationController`.
- Added upload storage under `registrations/icon-plus/...`.
- Added `App\Jobs\ProcessIconPlusRegistrationSubmission`.
- Added `App\Mail\NewIconPlusRegistrationMail` and `resources/views/emails/new_icon_plus_registration.blade.php`.

### PDF Generation

- Added `RegistrationPdfService::generateIconPlusPdf(IconPlusRegistration $registration): string`.
- Icon Plus contracts resolve from `public/contract-icon-plus.docx`, with optional `services.contract_templates.icon_plus` config support.
- Generated PDFs are stored under `registrations/icon-plus/{id}.pdf`.
- Contract placeholders currently match Icon:
  - `organization`
  - `name`
  - `cr_copy`
  - `hall`

### Routes And Admin

- Added localized public routes:
  - `POST /{locale}/register/icon-plus` named `public.register.icon-plus`
  - `GET /{locale}/register/icon-plus/{registration}/pdf` named `public.register.icon-plus.pdf`
- Added admin routes under `/admin/icon-plus-registrations`:
  - index
  - export
  - show
  - status update
  - PDF download
  - PDF regenerate
- Added `App\Http\Controllers\Admin\IconPlusRegistrationController`.
- Added `App\Livewire\Admin\IconPlusRegistrationsTable`.
- Added paired admin Blade views under `resources/views/admin/icon-plus-registrations`.
- Added paired Livewire table view under `resources/views/livewire/admin/icon-plus-registrations-table.blade.php`.
- Added an Icon Plus registrations sidebar link.
- Kept existing Visitor admin pages/routes available for historical records.

### Landing Page UI

- Replaced the public Visitor registration UI with Icon Plus on `resources/views/public/landing.blade.php`.
- Added role key and IDs:
  - `icon-plus`
  - `icon-plus-card`
  - `icon-plus-form`
  - `icon-plus-registration-form`
  - `icon-plus-location-selection`
- Added crown icon card.
- Posted Icon Plus form to `public.register.icon-plus`.
- Used Icon-equivalent fields and PDF upload controls.
- Used Icon Plus success/loading/popup translation keys.
- Updated role selection JavaScript for Icon Plus visibility, ordering, clearing, AJAX submit, and hall-map return.
- Added `registration.icon_plus.*` translations in English and Arabic.
- Added `icon_plus_card` and `icon_plus_form` defaults in `config/landing-sections.php`.
- Updated the admin registration-section request/controller/editor to manage Icon Plus card/form content instead of the old public Visitor card/form content.

### Hall Map

- Updated `resources/views/public/hall-design.blade.php` to read `target` from the query string, defaulting to `icon`.
- Added shared Icon Plus reserved-space helper for `L.W.1..28` and `R.W.1..28`.
- Rendered Icon Plus spaces with gold styling and crown markers.
- Enforced target-specific selection:
  - `target=icon-plus`: only Icon Plus spaces are selectable.
  - `target=icon`: Icon Plus spaces are reserved/closed.
  - manual/admin occupied spaces remain unavailable for all targets.
- Returned selected spaces with `hall_target=icon-plus` when opened from Icon Plus.
- Included submitted Icon and Icon Plus registration locations in the occupied set, in addition to `HallSpaceBooking`.

## Tests Added Or Updated

- Added `tests/Feature/IconPlusRegistrationTest.php`.
- Updated `tests/Feature/RegistrationFormLocalizationTest.php` to expect Icon Plus public copy instead of Visitor copy.

Coverage includes:

- successful Icon Plus registration
- upload persistence
- PDF lifecycle success/failure
- customer/admin mail notifications
- Icon Plus allowed spaces
- Icon Plus rejected spaces
- Icon rejection of Icon Plus spaces
- occupied/manual-held space rejection
- Icon Plus PDF template resolution
- admin index/show/export/status update/PDF regenerate
- landing localization copy

## Verification Run

Passed:

```bash
vendor/bin/pint --dirty
php artisan test --compact tests/Feature/IconPlusRegistrationTest.php
php artisan test --compact tests/Feature/RegistrationFormLocalizationTest.php
php artisan test --compact tests/Feature/PublicRegistrationNotificationTest.php
php artisan test --compact tests/Feature/SponsorPdfLifecycleTest.php
```

The full test suite was not run.

## Notes

- Icon Plus has its own admin page and sidebar link.
- Icon Plus is not included in dashboard totals.
- Visitor historical data, routes, and admin pages remain intact.
- Icon Plus uses the same PDF-only upload requirements as the existing Icon flow.
- Icon Plus uses the existing CloudConvert PDF lifecycle.

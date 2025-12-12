# Copilot Instructions for IEC Expo Laravel Project

## Architecture Overview
This is a Laravel application for managing IEC Expo registrations and content. It features a public-facing landing page with sponsor/visitor registration forms, and an admin panel for managing submissions.

**Key Components:**
- **Models**: `SponsorRegistration`, `VisitorRegistration`, `Participant`, `PublicSponsor` - core data entities
- **Controllers**: Public controllers handle form submissions; Admin controllers manage CRUD operations
- **Livewire Components**: Used for dynamic admin tables (e.g., `SponsorRegistrationsTable`) with pagination, search, and filters
- **Services**: `RegistrationPdfService` generates PDFs using DomPDF and stores them in `storage/app/public/`
- **Mails**: Notification emails sent to admins on new registrations, attaching generated PDFs

**Data Flow:**
1. Public users submit registration forms (sponsor/visitor)
2. Controllers validate, store data, generate PDFs via service, send admin emails
3. Admins view/manage registrations via Livewire tables, export data, update statuses

**Localization:** Routes prefixed with `{locale}` (en/ar), using middleware for language switching.

## Key Patterns
- **Dependency Injection**: Controllers inject services (e.g., `RegistrationPdfService`) in constructors
- **File Handling**: Uploads stored in `storage/app/public/` with paths saved in model `document_path`/`pdf_path`
- **Status Management**: Registrations have 'pending' default status, updatable via admin routes
- **Export Functionality**: Admin tables redirect to export routes passing current filters as query params
- **PDF Generation**: Views in `resources/views/pdf/` rendered to PDF and stored on registration

## Developer Workflows
- **Development Server**: Use `composer run dev` for concurrent Laravel server, queue worker, logs, and Vite dev server
- **Testing**: Run `composer run test` (clears config, runs PHPUnit)
- **Setup**: `composer run setup` installs deps, copies .env, migrates DB, builds assets
- **Build**: `npm run build` for production assets via Vite
- **Queue Jobs**: Mails queued; use `php artisan queue:work` for processing

## Conventions
- **Routes**: Public routes under `/{locale}/`, admin under `/admin/` with auth middleware
- **Views**: Blade templates in `resources/views/`, PDFs in `resources/views/pdf/`
- **Storage**: Public disk for user uploads and generated PDFs
- **Config**: Admin emails in `config/admin.php` for notifications
- **Migrations**: Standard Laravel migrations for tables like `sponsor_registrations`, `visitor_registrations`

## External Dependencies
- **DomPDF**: For PDF generation from Blade views
- **Livewire/Volt**: For reactive UI components
- **Tailwind CSS**: Styled with utility classes, built via Vite
- **Axios**: For potential AJAX requests (though minimal in current codebase)

Reference key files: [routes/web.php](routes/web.php), [app/Services/RegistrationPdfService.php](app/Services/RegistrationPdfService.php), [app/Livewire/Admin/SponsorRegistrationsTable.php](app/Livewire/Admin/SponsorRegistrationsTable.php)</content>
<parameter name="filePath">/home/coder/Desktop/iec-expo/.github/copilot-instructions.md
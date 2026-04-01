# ExpertDev CMS

Laravel CMS project with Filament admin, Livewire components, localized routes, and default content seeders for quick environment bootstrap.

## Tech Stack

- PHP 8.4+
- Laravel 13
- Filament 5
- Livewire 4
- Vite 8
- Tailwind CSS 4
- MySQL (default)

## Requirements

- PHP 8.4+ (8.4.1+ recommended for full dev/test tooling)
- Composer 2.x
- Node.js 20.19+ or 22.12+
- npm 10+
- MySQL 8+ (or compatible)

## Quick Start

1. Install dependencies:

```bash
composer install
npm install
```

2. Create environment file:

```bash
cp .env.example .env
```

On Windows CMD:

```cmd
copy .env.example .env
```

3. Configure `.env`:

- Set database credentials (`DB_*`)
- Set Curator token (`CURATOR_GLIDE_TOKEN`) using the command in step 5.
- Optionally set:
   - `SEED_ADMIN_PASSWORD`
   - `SENDGRID_API_KEY`
   - `COMGATE_API_NAME`
   - `COMGATE_API_PASS`

4. Generate app key, run migrations, and seed data:

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

5. Generate Curator Glide token and publish admin assets:

```cmd
php artisan curator:token
php artisan filament:assets
```

6. Build assets:

```bash
npm run build
```

For local development:

```bash
php artisan serve
npm run dev
```

## Admin Access

- Admin panel path: `/admin`
- Default seeded admin email: `nevaril@expert-dev.cz`
- Password behavior:
   - If `SEED_ADMIN_PASSWORD` is set, that password is used.
   - If not set, a random temporary password is generated and printed during seeding.

## Seeder Structure

`DatabaseSeeder` orchestrates modular seeders in this order:

1. `LanguageSeeder`
2. `PageRouteSeeder`
3. `PageSeeder`
4. `HeaderMenuSeeder`
5. `ArticleSeeder`
6. `AdminUserSeeder`
7. `ClearRuntimeCachesSeeder`

This setup creates a default multilingual CMS state (CS/EN), including homepage/blog routes, pages, sample articles, header menu, and admin user.

## Build And Minify Commands

- Build assets:

```bash
npm run build
```

- Build and minify assets:

```bash
npm run build:minify
```

- Minify only:

```bash
npm run minify:only
# or
php artisan assets:minify
```

`assets:minify` command options:

```bash
php artisan assets:minify [--source=path] [--dest=path] [--force]
```

- `--source`: Source directory (default: `public/build/assets`)
- `--dest`: Destination directory (default: same as source)
- `--force`: Overwrite existing `.min.*` files

## Testing

Run tests:

```bash
php artisan test
```

Important: tests currently expect DB connection settings from your environment. Ensure test database credentials are valid before running the full suite.

## Useful Maintenance Commands

```bash
php artisan optimize:clear
php artisan route:clear
php artisan config:clear
```

## Security Notes

- Do not commit real secrets to Git.
- Keep API credentials only in `.env`.
- Use `.env.example` as a template for required variables.

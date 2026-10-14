# Portfolio

My personal developer portfolio: a small content-managed Laravel app. Projects, skills and contact messages live in the database and are edited from a Filament admin panel, so updating the site never means touching code.

<!-- Add a screenshot of the home page here, e.g. ![Home page](docs/home.png) -->

## Features

- **Case studies:** each project has a Markdown write-up, a cover image, a screenshot gallery, and links to the repo and live demo.
- **Filter by technology** on the Work page (`/projects?tech=Laravel`).
- **Previous / next navigation** between case studies.
- **Contact form** with validation, a spam honeypot and rate limiting (5 per minute). Messages are saved to an admin inbox and can also be emailed.
- **Admin panel** at `/admin` (Filament) for projects, skills and messages.
- **SEO:** canonical URLs, Open Graph / Twitter cards, `sitemap.xml`, `robots.txt` and schema.org `Person` data.
- **Accessible:** visible keyboard focus, a skip-to-content link, and form errors announced to screen readers.
- **Light and dark mode** that follows the visitor's system setting.

## Tech stack

Laravel 13 · PHP 8.3+ · Filament 5 · Blade · Tailwind CSS 4 · Vite · SQLite

## Running it locally

Requirements: PHP 8.3+, Composer, Node.js.

```sh
git clone https://github.com/izumixjzl/portfolio.git
cd portfolio
composer setup          # installs dependencies, creates .env, migrates, builds assets
```

Fill in your details in `.env` (see below), including `ADMIN_EMAIL` and `ADMIN_PASSWORD`, then:

```sh
php artisan db:seed     # creates the admin account plus starter projects and skills
php artisan storage:link
composer dev            # starts the app at http://localhost:8000
```

Sign in at `/admin` to replace the starter content with your own.

## Configuration

All personal details come from `.env`, so nothing personal is hard-coded:

| Variable | What it's for |
| --- | --- |
| `PORTFOLIO_NAME`, `PORTFOLIO_ROLE`, `PORTFOLIO_LOCATION` | Shown in the header, hero and page titles |
| `PORTFOLIO_TAGLINE`, `PORTFOLIO_ABOUT` | Hero text and the About section |
| `PORTFOLIO_EMAIL`, `PORTFOLIO_GITHUB`, `PORTFOLIO_LINKEDIN` | Contact links (LinkedIn is hidden if empty) |
| `PORTFOLIO_RESUME_URL` | Shows a Résumé button when set |
| `PORTFOLIO_OG_IMAGE` | Image used when the site is shared, e.g. `images/og.png` in `public/` |
| `PORTFOLIO_NOTIFY_EMAIL` | Where contact-form notifications go (uses the `MAIL_*` settings) |
| `ADMIN_EMAIL`, `ADMIN_PASSWORD` | The only account allowed into `/admin` |

## Tests

```sh
composer test
```

## Deploying

Set `APP_ENV=production`, `APP_DEBUG=false` and the correct `APP_URL` (the sitemap and share links use it). Use a strong `ADMIN_PASSWORD`, run `php artisan storage:link` so uploaded images are served, and build assets with `npm run build`.

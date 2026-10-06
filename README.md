# Right Rudder

Aviation study site built with Laravel 13. Currently includes:

- **PPL Practice Exam**: the Transport Canada sample written exam (100 questions), graded on the server, with per-section results and answer review.
- **Study guides**: standalone study mini sites restyled in the site's cartoon theme (for example the Beech D95A Travel Air guide).

## Requirements

- PHP 8.4+ and Composer ([Laravel Herd](https://herd.laravel.com) provides both)
- Node 22 (`.nvmrc` is included, so `nvm use` picks it up)
- SQLite (built into PHP; no database server needed)

## Install

```sh
git clone git@github.com:splitmango-david/right-rudder.git
cd right-rudder
nvm use
composer setup
```

`composer setup` does the whole install:

1. Installs PHP dependencies.
2. Creates `.env` and an app key.
3. Creates the SQLite database, runs migrations and seeds the exam.
4. Links `public/storage` so the exam's chart images load.
5. Installs JS dependencies and builds the assets.
6. Turns on the git pre-commit hook in `.githooks/` (see [Built assets](#built-assets)).

### Open the site

- **With Herd:** if the project is inside a parked folder (such as `~/Sites`), it's served at **http://right-rudder.test**. Nothing else to run.
- **Without Herd:** run `composer dev` and open http://localhost:8000. Then set `APP_URL=http://localhost:8000` in `.env` so image URLs resolve.

## Day-to-day

| Task | Command |
| --- | --- |
| Rebuild CSS/JS after editing `resources/` | `npm run build` (or `npm run dev` to watch) |
| Run the tests | `composer test` |
| Reset the database and reseed | `php artisan migrate:fresh --seed` |
| Reseed exam content only (keeps attempts) | `php artisan db:seed` |
| Format PHP | `vendor/bin/pint` |

If a page errors with *"Unable to locate file in Vite manifest"*, run `npm run build`.

## Built assets

The compiled CSS/JS in `public/build/` **is committed to git**, so the server never needs Node.

- The pre-commit hook runs `npm run build` and stages `public/build/` whenever a commit touches `resources/`, `vite.config.js` or `package.json`. You don't have to remember to build.
- `npm run dev` does **not** update `public/build/`. The hook covers this at commit time.
- To skip the hook once: `git commit --no-verify`. Only do this if the commit doesn't change front-end sources.
- `public/hot` (created by `npm run dev`) stays git-ignored. Never commit it, or production will try to load assets from your machine.

## Deploying (Laravel Forge)

Deploy script:

```sh
cd $FORGE_SITE_PATH
git pull origin $FORGE_SITE_BRANCH

$FORGE_COMPOSER install --no-dev --no-interaction --prefer-dist --optimize-autoloader

$FORGE_PHP artisan migrate --force
$FORGE_PHP artisan db:seed --force
$FORGE_PHP artisan storage:link --force
$FORGE_PHP artisan optimize

( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service $FORGE_PHP_FPM reload ) 9>/tmp/fpmlock
```

- No `npm` step: assets come from git.
- `db:seed` loads or updates the exam content on each deploy. Past attempts are kept.
- `storage:link` makes the exam's chart images public.
- The server needs PHP 8.3+.

## Adding content

### Exams

Each exam is a folder in `database/data/` containing an `exam.json` (sections, questions, reference material) and an `images/` folder. Running `php artisan db:seed` loads every folder. Exams are matched by `slug`, so re-seeding updates content without losing past attempts.

### Study guides (mini sites)

1. Drop the standalone HTML file into `incoming/`. **That folder is git-ignored**, so originals that contain private details never get committed.
2. Each guide is converted into:
   - an entry in `config/guides.php` (title and summary for the home page)
   - a view at `resources/views/guides/{slug}.blade.php`
   - its script at `resources/js/guides/{slug}.js`, added to `vite.config.js`
3. Guides share the cartoon components in `resources/css/guide.css`, and are served at `/guides/{slug}`.

Strip anything identifying (aircraft registrations, serial numbers, owners or operators) before content leaves `incoming/`.

## Troubleshooting

**Every local site hangs or times out under Herd.** This happened once: Herd's "Dumps" feature sends each PHP request to the Herd desktop app, and if the app wedges, every page hangs. Quit and reopen Herd from the menu bar; `herd restart` alone isn't enough. Disabling Dumps in Herd's settings prevents it.

# ÉCLAT — Hair Atelier

A premium, multi-page salon website. Native PHP + MySQL, no framework. Dark
theme by default with a flicker-free light mode, all content driven from the
database, and pretty URLs.

This is the **client-facing** site. An admin dashboard can be added later — the
database is already designed for it (see *TODO tables*).

---

## 1. Requirements

- PHP 8.1+ with PDO (`pdo_mysql`)
- MySQL 5.7+ / MariaDB
- Apache with `mod_rewrite` **or** nginx (pretty URLs)

## 2. Setup

> `BASE_URL` is preset to `/test` in `config/config.php` for the Hostinger
> deploy below. Serving at a domain root instead? Set it to `''`.

### Deploy to Hostinger (hPanel) at jmep.online/test/

The project keeps its clean structure — a small forwarder makes it work in a
subfolder without moving anything.

1. Create the database in hPanel → **Databases → MySQL Databases**. Note the
   database name, user and password it gives you (Hostinger prefixes them).
2. Import the SQL: open **phpMyAdmin** for that database and run `sql/schema.sql`
   then `sql/seed.sql` (Import tab, one file at a time).
3. Put your DB credentials in `config/config.php` (`DB_NAME`, `DB_USER`,
   `DB_PASS`; `DB_HOST` is usually `localhost` on Hostinger).
4. Upload the **whole project folder's contents** into `public_html/test/`
   via hPanel **File Manager** or FTP. You should end up with
   `public_html/test/app`, `.../config`, `.../public`, `.../sql`, and the
   `.htaccess` at `public_html/test/.htaccess`.
5. Open **https://jmep.online/test/** — done.

The root `.htaccess` forwards every request into `public/`, so the structure is
untouched and `app/`, `config/`, `sql/` aren't reachable in the browser. Using a
folder other than `test`? Change `/test/` in the root `.htaccess` and `BASE_URL`
in `config/config.php` to match.

### Later: your own nginx (the "proper" way)

Delete the root `.htaccess`, set `BASE_URL` to `''`, and point the server root at
the `public/` folder:

```nginx
root /path/to/eclat-salon/public;
index index.php;
location / { try_files $uri $uri/ /index.php?$query_string; }
location ~ \.php$ { include fastcgi_params; fastcgi_pass unix:/run/php/php-fpm.sock; fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; }
```

### Generic / manual

```bash
mysql -u root -p -e "CREATE DATABASE eclat_salon CHARACTER SET utf8mb4;"
mysql -u root -p eclat_salon < sql/schema.sql
mysql -u root -p eclat_salon < sql/seed.sql
# edit config/config.php, point the web root at  public/
```

> **Set `APP_DEBUG` to `0`** in `config/config.php` for production.

### Preview without MySQL (optional)
For a quick local look without setting up MySQL, the project can run on SQLite:

```bash
php sql/make-sqlite.php          # builds sql/eclat.sqlite from the .sql files
DB_DRIVER=sqlite php -S 127.0.0.1:8000 -t public public/router-dev.php
# open http://127.0.0.1:8000
```

---

## 3. How it's organised

Three ideas, nothing more: **models get data, controllers pick what a page
needs, views are the HTML.** No classes per entity, no DI container — just
folders with a job and plain functions.

```
public/            ← the ONLY web-exposed folder
  index.php          front controller (reads the URL, runs a controller)
  .htaccess          pretty-URL rewrite
  assets/css|js      split by concern: base / components / pages · core / pages

app/
  bootstrap.php      loads config + db + helpers + every model (the wiring)
  routes.php         URL path → controller name   ('/about' => 'about')
  database.php       db() — one shared connection + q()/q1() helpers
  helpers.php        e(), url(), css(), js() (versioned), money(), render() …
  models/            get_* functions, one file per topic (settings, services, …)
  controllers/       one file per page: grab data, call render()
  views/
    layout.php       <head> + header + page + footer
    partials/        header, footer, marquee, team-grid, testimonials, cta
    pages/           home, about, services, gallery, book, not_found

config/config.php    all settings + DB credentials
sql/                 schema.sql · seed.sql
```

**A request, start to finish:** browser hits `/about` → `.htaccess` sends it to
`index.php` → router finds `/about` in `routes.php` → runs
`controllers/about.php` → that calls a few `get_*()` model functions → passes
the data to `render('about', [...])` → the view renders inside `layout.php`.

### Add a new page
1. Add a route in `app/routes.php` — e.g. `'/contact' => 'contact'`.
2. Create `app/controllers/contact.php` (copy an existing one).
3. Create `app/views/pages/contact.php`.

### Assets & caching
`css('components/nav')` and `js('core/nav')` output the tag **with a `?v=`
stamp equal to the file's last-modified time.** Edit a CSS/JS file and the
browser fetches the new version automatically — you never bump a version by
hand, and stale caches can't bite you.

---

## 4. Editing content

Everything lives in the database, so there's nothing to hunt for in the markup.

| To change… | Edit table |
|---|---|
| Name, phone, address, social links, hero/about copy | `settings` |
| Opening hours | `opening_hours` |
| Homepage counters | `stats` |
| The service menu + prices | `service_categories`, `services` |
| Stylists | `team` |
| Lookbook images | `gallery` (+ `before_image_url` for the drag-reveal) |
| Reviews | `testimonials` |
| Product brand marquee | `brands` |
| Booking enquiries (submitted by the form) | `booking_requests` |

### Swapping the demo images
Demo images use placeholder CDNs (faces via `i.pravatar.cc`, editorial shots via
`picsum.photos`) so the site renders out of the box. Each image is a single DB
field — replace the value in `team.photo_url` or `gallery.image_url` with a real
Unsplash URL or the salon's own photo. No code changes.

---

## 5. TODO tables (built, not yet wired)

`schema.sql` also creates and lightly seeds: **faq, posts, products,
promotions, newsletter_subscribers, gift_vouchers**. They exist so the future
dashboard and pages have somewhere to read/write — no controllers or views
touch them yet.

## 6. Notes for production
- Turn off `APP_DEBUG`.
- The booking form has a honeypot; add a CSRF token + rate-limiting before launch.
- Consider bundling/minifying the split CSS/JS for fewer requests.
- Booking is an *enquiry* form. To take real-time bookings, point the "Book"
  button at Fresha/Booksy/Square, or build the dashboard + scheduling.

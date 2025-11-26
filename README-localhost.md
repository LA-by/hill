Localhost setup — quick guide

This file explains two ways to run the site locally on Windows: (A) PHP built-in dev server (fast, no extra install if PHP is present), and (B) XAMPP (recommended if you need MySQL/phpMyAdmin).

A — Quick preview using PHP's built-in server (no DB required for `main.php` UI)

1. Open PowerShell.
2. Change directory to the project folder (where `main.php` is):

```powershell
cd "C:\Users\bhara\OneDrive\Desktop\Hill Sagar\hill"
```

3. Start the server (or run the helper script we added):

```powershell
# Option 1: run helper
.\start-server.ps1

# Option 2: run directly
php -S localhost:8000
```

4. Open your browser and visit:

http://localhost:8000/main.php

Notes:
- `main.php` in this project is a standalone page (no DB include). It will render even without MySQL.
- Keep the PowerShell window open while the server runs.

B — Full site (login, packages, admin) using XAMPP (Apache + MySQL + phpMyAdmin)

1. Download and install XAMPP for Windows: https://www.apachefriends.org/
2. Open XAMPP Control Panel and start Apache and MySQL.
3. Copy the project folder into XAMPP's document root. Example:

- Source: `C:\Users\bhara\OneDrive\Desktop\Hill Sagar\hill`
- Destination: `C:\xampp\htdocs\HillSagar`

4. Open browser:

http://localhost/HillSagar/main.php

5. Database setup (so login, bookings, admin features work):

- Open phpMyAdmin: http://localhost/phpmyadmin
- Create a database with the name expected by the app. Check `includes/db.php` for the DB name (default may be `tours_travels` or similar).
- Import `schema.sql` (found in project root) via phpMyAdmin -> Import.

6. Configure DB credentials:
- Edit `includes/db.php` to match your MySQL credentials (default XAMPP user is `root` with no password). Or set env vars if `includes/db.php` reads from TT_DB_* variables.

C — Troubleshooting & notes

- If you get PHP errors complaining about missing `includes/db.php` values, the site expects DB. Either set up MySQL (steps above) or test pages that don't include DB (like `main.php`).
- File path warnings: some files reference `images/backgrounds .mp4` (note the space). If media doesn't load, rename files or fix paths.
- To reset admin credentials, edit `update_admin.php` and run it on the server/CLI (or use phpMyAdmin to update the `admins` table). Make sure MySQL is running.

If you want, I can:
- Create a small script to copy the project into `C:\xampp\htdocs\HillSagar` automatically.
- Prepare a pre-filled `includes/db.php.example` you can rename to `includes/db.php` with local XAMPP defaults.
- Walk you through importing `schema.sql` step-by-step (I can produce the exact phpMyAdmin clicks or CLI commands).

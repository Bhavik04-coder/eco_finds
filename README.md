EcoFinds - Fixed & Improved (PHP + MySQL) - XAMPP Ready
-----------------------------------------------------

How to run locally (XAMPP)
1. Copy the folder `ecofinds_project_fixed` into your XAMPP `htdocs` directory.
   Example (Windows): C:\xampp\htdocs\ecofinds_project_fixed
2. Start Apache and MySQL from XAMPP control panel.
3. Open phpMyAdmin: http://localhost/phpmyadmin
4. Import `ecofinds_db.sql` (file included) to create the `ecofinds_db` database and tables.
5. Open http://localhost/ecofinds_lights/ in your browser.

Important files to check
- includes/config.php  -> Database credentials (default root / no password)
- uploads/             -> Must be writable for image uploads.

Security & improvements included
- Prepared statements for critical queries
- Basic upload checks (extension + size limit)
- Friendly error handling for DB query failures
- Improved navbar, hero section, footer, and logo

Deployment notes
- For production, switch to real hosting (shared host or VPS).
- Use HTTPS, set proper file permissions, and further harden inputs.

If you want I can also convert every remaining query to prepared statements and add CSRF tokens.

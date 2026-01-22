# BBUC WiFi Management (No Docker)

## Quickstart (XAMPP / Lamp)

1. Extract project into your webroot, e.g. `C:/xampp/htdocs/bbuc_wifi_management_nodocker/`.
2. Start Apache & MySQL.
3. Import `sql/wifi_db.sql` into phpMyAdmin (or run via MySQL CLI).
4. Open `http://localhost/bbuc_wifi_management_nodocker/` — you'll be redirected to admin login.
5. Click 'Create admin account' to register your admin credentials.

## Notes
- Passwords are hashed using `password_hash()`.
- Use HTTPS in production and secure the `config/db.php` file.
- Customize `assets/css/theme.css` to adjust colors.

Enjoy!
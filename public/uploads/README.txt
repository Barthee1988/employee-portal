This folder stores user uploads (PDF/JPEG/PNG). It should be writable by the web server user.

Security:
- Direct script execution is blocked via .htaccess.
- Files should be served via a controller to enforce RBAC checks.

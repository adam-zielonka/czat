# Czat

Educational PHP chat application. Requires PHP 8.3+ with mysqli and MariaDB.

## Local development

Create an ignored `.env` containing a newly generated `DB_PASSWORD`, then run
`docker compose up --build -d`. The application listens on loopback port 8001.
Initialize a **new** database with `docker compose exec app php install.php`.
The installer is CLI-only. Existing databases must be backed up before upgrades;
the Compose volume is persistent. Import old data explicitly if migrating an old
Compose setup; the previous unmounted database is not moved automatically.

New passwords use PHP's password hashing API. Existing MD5 hashes are upgraded
after a successful login without changing the user's password. Ask users who
have not logged in to reset old passwords. Registration accepts 12–72 byte passwords.
Old inactive accounts require administrator activation; predictable activation
codes are no longer accepted.

API requests require POST and the session's X-CSRF-Token (provided by the page).
All SQL values use prepared statements and routes use an explicit allowlist.
Before a public deployment, configure HTTPS and operational abuse/rate limits
at the reverse proxy; the bundled PHP development server is for local use.

## Checks

`php tests/security.php` and PHP syntax checks run in GitHub Actions.
Database integration checks also run against a disposable MariaDB CI service.

## License

MIT, see LICENSE.

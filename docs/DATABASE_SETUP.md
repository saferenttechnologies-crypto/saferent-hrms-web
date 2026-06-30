# Database setup

Many shared-hosting MySQL accounts do not have permission to create databases or switch to arbitrary database names. If your host shows an error such as:

```text
#1044 - Access denied for user '_sso_f7850e45'@'%' to database 'saferent_hrms'
```

use the database that your hosting control panel already assigned to your account instead of running `CREATE DATABASE`.

## Import schema and seed data

1. Create or select the allowed database in your hosting panel, such as cPanel, Plesk, DirectAdmin, or phpMyAdmin.
2. Update `.env` so `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` match the exact credentials from the hosting panel.
3. In phpMyAdmin or your MySQL client, select that database first.
4. Import `database/migrations/001_enterprise_hrms_schema.sql`.
5. Import `database/seeders/001_roles_permissions_seed.sql`.

The SQL files intentionally do not include `CREATE DATABASE` or `USE` statements so they can be imported by restricted MySQL users after the target database is selected.

## Local development option

If you control the MySQL server locally, you can still create the database manually before importing:

```sql
CREATE DATABASE saferent_hrms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then select `saferent_hrms` in your client and import the migration and seeder files.

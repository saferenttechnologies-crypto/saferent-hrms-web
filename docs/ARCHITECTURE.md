# SafeRent Enterprise HRMS Architecture

This repository is a PHP 8+ MVC foundation for a commercial HRMS. It separates HTTP controllers, middleware, repositories, services, views, configuration, migrations, seeders, public assets, and storage. The database schema is normalized for RBAC, employees, interns, recruitment, attendance, leave, payroll, documents, letters, certificates, notifications, approvals, and audit logging.

## Security baseline
- Authentication middleware protects dashboards and modules.
- RBAC entities and permissions are database-backed.
- PDO prepared statements are centralized in `App\Core\Database`.
- CSRF tokens, secure session cookies, password hashing, output escaping, audit tables, login history, and restricted upload metadata are included.

## Scalability
Use indexed foreign keys, service-layer workflows, repository abstractions, asynchronous notification/export jobs, object storage for files, read replicas for analytics, and queue workers for PDF/Excel generation when scaling beyond 10,000 employees.

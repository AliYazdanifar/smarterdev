
# Laravel Starter Kit — Packages

This document defines the default package stack.

Always verify PHP and Laravel compatibility before installation.

## 1. Core Packages

### Modular Architecture

```bash
composer require nwidart/laravel-modules
```

For Laravel 12 and 13, verify the compatible package major version.

### Roles and Permissions

```bash
composer require spatie/laravel-permission
```

Used for roles, permissions and access control.

### File Management

```bash
composer require spatie/laravel-medialibrary
```

Used for domain-related files, documents, images and attachments.

### API Authentication

```bash
composer require laravel/sanctum
```

Used for SPA authentication and API tokens.

### Activity Logging

```bash
composer require spatie/laravel-activitylog
```

Used for tracking important application activities.

### Livewire

```bash
composer require livewire/livewire
```

Used for interactive Laravel-driven interfaces.


## 2. Vue.js (Optional)

Install only when a project requires complex client-side interfaces.

```bash
npm install vue
npm install -D @vitejs/plugin-vue
```

Configure Vue in Vite.

Optional:

```bash
npm install pinia vue-router
```

Only install Pinia or Vue Router when needed.

## 3. Optional Packages

| Package | Purpose |
|---|---|
| laravel/horizon | Redis queue dashboard |
| laravel/telescope | Application debugging |
| dedoc/scramble | API documentation |
| maatwebsite/excel | Excel import/export |
| spatie/laravel-backup | Application backups |
| barryvdh/laravel-debugbar | Local debugging |

Install only when required.

## 4. Suggested Installation

```bash
composer require nwidart/laravel-modules
composer require spatie/laravel-permission
composer require spatie/laravel-medialibrary
composer require spatie/laravel-activitylog
composer require laravel/sanctum
composer require livewire/livewire

composer require --dev laravel/pint
composer require --dev larastan/larastan
composer require --dev pestphp/pest
composer require --dev pestphp/pest-plugin-laravel
```

## 6. Package Installation Rules

- Never install a package without checking compatibility.
- Do not install optional packages by default.
- Prefer Laravel native features.
- Avoid overlapping packages.
- Check package maintenance and documentation.
- Do not install Passport unless OAuth2 is genuinely required.

## 7. Important Notes

- Check the current Nwidart major version against Laravel.
- Follow the installed Media Library version's PHP and image processing requirements.
- Configure private media disks when necessary.
- Configure Redis before using Horizon.
- Keep Telescope and Debugbar restricted to development environments.
- Verify backup system requirements before installing Spatie Backup.

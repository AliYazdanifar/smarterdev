
---
description: Laravel Modular Service-Based Engineering Standards
alwaysApply: true
---

# Laravel Engineering Standards

You are a Senior Laravel Backend Engineer. Follow these standards in every task.

## 1. Core Philosophy

Build applications using:

- Modular Monolith Architecture
- Service-Based Business Logic
- Laravel Native Best Practices
- Clean, Readable and Maintainable Code
- Minimal Complexity (Avoid Overengineering)

Always prefer Laravel native features over custom implementations.

Do not introduce abstractions without a real reason.

Before changing code, inspect the existing project structure and follow its conventions.

## 2. Modular Architecture

Use nwidart/laravel-modules.

Organize modules around business domains, such as:

- Users
- Auth
- AdminPanel
- Products
- Orders
- Payments
- Notifications

Each module owns its business logic, models, migrations, routes, requests, resources and tests.

Reference structure:

Modules/Products/
    app/
        Models/
        Services/
        Actions/
        DTOs/
        Http/
            Controllers/
            Requests/
            Resources/
        Jobs/
        Events/
        Listeners/
        Providers/
    database/
        migrations/
        seeders/
        factories/
    routes/
        api.php
        web.php
    tests/

Create folders and classes only when needed.

Avoid circular dependencies between modules.

Modules should communicate through public Services, Actions or explicit contracts.

Do not create modules based on technical file types.

## 3. Service Layer

Controllers must remain thin.

Controllers are responsible for:
- Receiving HTTP requests.
- Calling Services or Actions.
- Returning responses or Resources.

Business logic belongs in Services.

Use Actions for independent operations with a clear responsibility.

Do not create:
- Unnecessary repositories.
- Unnecessary interfaces.
- Managers for simple operations.
- DTOs for trivial data.
- Multiple abstraction layers without justification.

Repository Pattern is optional, not mandatory.

Prefer straightforward Laravel code.

## 4. Laravel Native Best Practices

Use Laravel native functionality whenever appropriate.

Mandatory conventions:

- Route Model Binding
- Dependency Injection
- Service Container
- FormRequest
- JsonResource
- Eloquent Relationships
- Query Scopes
- Middleware
- Authorization
- Events and Listeners
- Jobs and Queues
- Notifications
- Database Transactions
- Cache
- Rate Limiting

Avoid manually querying models in controllers when Route Model Binding is appropriate.

Example:

Route:
Route::get('/products/{product}', [ProductController::class, 'show']);

Controller:
public function show(Product $product): JsonResponse
{
    return ApiResponse::success(
        new ProductResource($product)
    );
}

Use constructor injection for controller-level dependencies and method injection for method-specific dependencies when appropriate.

Never instantiate injectable Services manually using new without a good reason.

## 5. Frontend Standards

Preferred technologies:

- Blade
- Livewire
- Vue.js 3
- Alpine.js when appropriate

Decision rules:

Blade:
- Simple pages.
- Standard forms.
- Server-rendered content.
- Layouts and reusable templates.

Livewire:
- Interactive CRUD.
- Dynamic forms.
- Filtering and pagination.
- Admin interfaces.
- Server-driven interactions.

Vue.js:
- Complex client-side interfaces.
- Advanced dashboards.
- Interactive editors.
- Drag-and-drop functionality.
- Complex state management.
- Features that justify a standalone SPA.

Use Vue 3 Composition API and <script setup>.

Use Pinia only when shared state management is genuinely needed.

Use Vue Router only when client-side routing is required.

Do not build a full SPA for simple CRUD functionality.

Livewire components must delegate business logic to Services.

Do not duplicate business logic between Blade, Livewire and Vue.

Do not mix Livewire and Vue inside the same component without a clear reason.

Use Alpine.js for small interactions when appropriate.

## 6. Database Engineering

Database design must prioritize:

- Performance
- Data integrity
- Scalability
- Query efficiency
- Proper indexing

Migration rules:

- Use appropriate column types.
- Define foreign keys where appropriate.
- Add indexes based on expected query patterns.
- Use composite indexes when appropriate.
- Add unique constraints for business invariants.
- Avoid redundant indexes.
- Avoid unnecessary nullable columns.
- Consider delete behavior carefully.
- Use transactions for critical operations.

Example:

$table->foreignId('user_id')
    ->constrained()
    ->cascadeOnDelete();

$table->index(['user_id', 'status']);

$table->unique(['user_id', 'reference']);

Do not add indexes blindly. Consider query patterns, column order and write overhead.

For frequently used queries:
- Analyze filters and sorting.
- Prevent N+1 queries.
- Use eager loading.
- Select only required columns.
- Use pagination.
- Inspect execution plans for expensive queries.

Never modify an already executed migration to change production schema.

Create new migrations for schema changes.

Never execute destructive migrations or delete production data without explicit approval.

For large tables, consider backward-compatible schema changes and database-specific online migration strategies.

## 7. Eloquent Standards

Prefer Eloquent relationships over manually constructed joins when appropriate.

Use:
- belongsTo
- hasMany
- belongsToMany
- with()
- withCount()
- whereHas()
- Scopes
- Accessors and Mutators

Prevent N+1 queries.

Do not load unnecessary relationships.

Avoid loading entire tables into memory.

Use chunkById or cursor for large datasets when appropriate.

## 8. Package Standards

Use:

- nwidart/laravel-modules
- spatie/laravel-permission
- spatie/laravel-medialibrary
- spatie/laravel-activitylog
- laravel/sanctum
- livewire/livewire

Development tools:

- laravel/pint
- larastan/larastan
- pestphp/pest

Vue dependencies should only be installed when needed.

Do not install optional packages without a clear requirement.

Always verify compatibility with the project's PHP and Laravel versions.

## 9. Authentication and Authorization

Use Sanctum for SPA and API token authentication unless OAuth2 is genuinely required.

Use Spatie Permission for roles and permissions.

Always specify the correct guard.

Check authorization on the server.

Frontend visibility is never a substitute for backend authorization.

Never trust client-provided user IDs for ownership.

Protect authentication, OTP and password reset endpoints with rate limiting.

## 10. File Management

Use Spatie Media Library for domain-related files.

Examples:
- User avatars.
- Product images.
- Documents.
- Attachments.
- Content media.

Define meaningful media collections.

Validate file size and MIME type.

Use private disks for private files.

Authorize downloads.

Storage may still be used for temporary files, cache, locks and infrastructure-related files.

## 11. Jobs, Events and Integrations

Use Jobs for long-running and retryable tasks.

Jobs must be idempotent whenever possible.

Configure retries, timeouts and backoff.

Use Events when independent parts of the application need to react to business events.

Use a dedicated integration client or Service for external providers.

Always configure HTTP timeouts.

Never log passwords, tokens, OTPs or sensitive data.

Use database transactions for critical workflows.

Dispatch external side effects after database commit when appropriate.

## 12. API Standards

- Validate input using FormRequest.
- Use JsonResource for output.
- Use consistent response structures.
- Use correct HTTP status codes.
- Implement pagination.
- Validate filtering and sorting parameters.
- Avoid exposing internal exceptions.
- Never return raw Eloquent models directly as API contracts.

Follow the project's existing API response convention.

## 13. Status Management

When the project follows this convention:

- Use string database columns.
- Define status constants in Models or dedicated Support classes.
- Provide readable labels through a consistent label mapping.
- Avoid introducing PHP Enums without an explicit architectural decision.

## 14. Testing and Code Quality

Use Pest for tests.

Write:
- Feature tests for application workflows.
- Unit tests for isolated business logic.
- Authorization tests.
- Validation tests.
- Edge-case tests.
- Integration failure tests.

Mock external services.

Run:

./vendor/bin/pint --test
php artisan test

Run Larastan when configured.

Never hide or delete failing tests to make the build pass.

## 15. Security

- Prevent mass assignment vulnerabilities.
- Validate all user input.
- Authorize sensitive operations.
- Protect file uploads.
- Use rate limiting.
- Secure webhooks.
- Prevent SQL injection.
- Never expose secrets.
- Avoid sensitive information in logs.
- Use proper password hashing.
- Protect private files and downloads.

## 16. Development Workflow

Before implementation:

1. Inspect the project structure.
2. Inspect composer.json and installed packages.
3. Identify the Laravel and PHP versions.
4. Find existing similar implementations.
5. Understand the relevant module boundaries.
6. Identify required migrations, tests and authorization rules.

Then:

1. Implement the smallest complete solution.
2. Reuse existing Services and conventions.
3. Add necessary tests.
4. Run relevant tests.
5. Run Pint.
6. Review changed files.

At completion, report:
- What changed.
- Main files affected.
- Tests executed.
- Remaining issues.

## 17. Strict Rules

Never:
- Put business logic in controllers.
- Create unnecessary architectural layers.
- Add dependencies without checking compatibility.
- Duplicate business logic.
- Bypass authorization.
- Modify executed migrations for schema changes.
- Perform destructive production operations without approval.
- Add empty classes or folders just to satisfy a structure.
- Introduce complexity without measurable benefit.

The primary principle:

Build clean, modular, service-based Laravel applications using Laravel best practices, without unnecessary complexity.

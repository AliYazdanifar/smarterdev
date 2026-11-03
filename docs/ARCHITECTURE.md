
# Architecture

## Architecture Philosophy

This project follows Modular Monolith architecture with Service-Based business logic.

The goal is to keep the application:

- Modular
- Maintainable
- Testable
- Scalable
- Easy to understand

Avoid unnecessary architectural complexity.

## 1. Modular Monolith

Use nwidart/laravel-modules.

Each module represents a business domain.

Examples:

- Users
- Authentication
- Products
- Orders
- Payments
- Notifications

Each module owns its related business logic and resources.

## 2. Suggested Structure

```text
Modules/
  Products/
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
```

Only create directories when needed.

## 3. Application Layers

### Presentation Layer

Contains:

- Controllers
- FormRequests
- JsonResources
- Livewire Components
- Blade Views
- Vue Components

Responsible for HTTP and UI interactions.

### Business Layer

Contains:

- Services
- Actions
- Domain-specific operations

Responsible for business rules and workflows.

### Data Layer

Contains:

- Eloquent Models
- Relationships
- Query Scopes
- Migrations

Responsible for persistence and data integrity.

## 4. Module Communication

Modules should communicate through public Services, Actions or explicit contracts.

Avoid accessing internal implementation details of another module.

Avoid circular dependencies.

## 5. Dependency Direction

Presentation layers depend on Services.

Services use Models and other required application capabilities.

Models should not depend on Controllers or UI components.

Keep business logic independent from Blade, Livewire and Vue.

## 6. Repository Pattern

Repository Pattern is not mandatory.

Use Eloquent directly for normal application queries.

Introduce repositories only when they solve a real problem, such as multiple data sources or a meaningful persistence abstraction.

## 7. Shared Code

Use app/Support for genuinely shared application utilities.

Do not turn Support into a collection of unrelated business logic.

## 8. Architecture Decision

Prefer the simplest architecture that correctly solves the business problem.

Do not introduce a new layer without a clear benefit.

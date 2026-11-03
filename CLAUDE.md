
# Laravel Project Engineering Standards

This project follows a Modular Monolith and Service-Based Laravel architecture.

## Primary Instructions

Before implementing any task, read:

- `.claude/rules/laravel-engineering.md`
- `docs/ARCHITECTURE.md`
- `docs/CODING-STANDARDS.md`
- `docs/FRONTEND-STANDARDS.md`
- `docs/DATABASE.md`
- `docs/SECURITY.md`
- `docs/TESTING.md`

Read additional documentation when relevant to the task.

## Architecture

- Modular Monolith using nwidart/laravel-modules.
- Service Layer for business logic.
- Thin Controllers.
- FormRequest for validation.
- JsonResource for API responses.
- Spatie Permission for authorization.
- Spatie Media Library for domain files.
- Sanctum for API authentication.
- Livewire for server-driven interactions.
- Vue 3 for complex client-side interfaces.
- Blade as the default rendering solution.

## Important Rules

1. Inspect existing project conventions before changing code.
2. Prefer Laravel native features.
3. Use Route Model Binding.
4. Use Dependency Injection.
5. Design migrations with appropriate indexes and constraints.
6. Avoid N+1 queries.
7. Write tests for important functionality.
8. Do not create unnecessary repositories, interfaces or DTOs.
9. Do not perform destructive operations without approval.
10. Keep business logic independent from presentation layers.

## Development Workflow

Before implementation, identify the relevant modules, existing Services, Models and tests.

Implement the smallest complete solution that follows project conventions.

After implementation:
- Run relevant Pest tests.
- Run Laravel Pint.
- Run static analysis when configured.
- Report changed files and test results.

## Philosophy

Modular. Service-Based. Laravel Native. Testable. Maintainable.

Avoid Overengineering.

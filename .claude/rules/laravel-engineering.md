
# Laravel Engineering Rules

These rules apply to all Laravel development tasks.

## Architecture
- Use Modular Monolith with Nwidart.
- Organize modules by business domain.
- Keep Controllers thin.
- Put business logic in Services.
- Use Actions only for meaningful independent operations.
- Do not enforce Repository Pattern.
- Avoid unnecessary interfaces and DTOs.

## Laravel Best Practices
- Use Route Model Binding.
- Use constructor or method Dependency Injection.
- Use FormRequest for HTTP validation.
- Use JsonResource for API output.
- Use Eloquent relationships and eager loading.
- Use Transactions for critical operations.
- Use Jobs for background processing.
- Use Events for meaningful domain events.

## Frontend
- Blade for standard pages.
- Livewire for server-driven interactions.
- Vue 3 for complex client-side interfaces.
- Alpine.js for small interactions when appropriate.
- Keep business logic in Services.
- Avoid unnecessary SPA architecture.

## Database
- Design migrations for performance and integrity.
- Add appropriate indexes and foreign keys.
- Use composite indexes based on actual queries.
- Avoid redundant indexes.
- Consider deletion constraints.
- Never edit executed migrations.
- Review expensive queries with EXPLAIN when necessary.

## Security
- Enforce backend authorization.
- Validate all inputs.
- Protect file uploads and downloads.
- Apply rate limits.
- Never expose credentials or sensitive information.

## Quality
- Write Pest tests.
- Use Pint.
- Use Larastan when configured.
- Inspect existing conventions before implementation.
- Do not introduce unnecessary dependencies.
- Do not perform destructive operations without approval.

Always prioritize readable, maintainable Laravel code over architectural complexity.

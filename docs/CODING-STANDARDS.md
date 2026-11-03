
# Coding Standards

## 1. General Rules

Follow Laravel conventions and PSR-12 where applicable.

Write code that is:
- Readable
- Predictable
- Testable
- Maintainable

Avoid unnecessary complexity.

## 2. Naming

Use descriptive names.

Good:
- CreateOrder
- CancelBooking
- SyncCustomer
- calculateTotal

Avoid:
- processData
- doAction
- handleThing
- tempFunction

Use consistent Laravel naming conventions.

## 3. Controllers

Controllers should only:
- Receive requests.
- Call Services.
- Return responses.

Do not put business logic or complex queries inside controllers.

## 4. Validation

Use FormRequest for HTTP validation.

Example:

```php
public function rules(): array
{
    return [
        'name' => ['required', 'string', 'max:255'],
        'price' => ['required', 'integer', 'min:0'],
    ];
}
```

Use readable validation messages.

For Persian applications, provide Persian messages and attribute names where appropriate.

## 5. Dependency Injection

Use Laravel's Service Container.

Prefer constructor injection for shared dependencies.

Prefer method injection for method-specific dependencies.

Use Route Model Binding for route-bound models.

Avoid manual dependency construction without a reason.

## 6. API Responses

Use JsonResource.

Maintain a consistent API response contract.

Do not expose internal exceptions or sensitive database fields.

Use correct HTTP status codes.

## 7. Eloquent

Use relationships and scopes.

Avoid duplicated query logic.

Prevent N+1 queries.

Use transactions for critical workflows.

## 8. Status Management

When following the project's string-status convention:

- Define constants.
- Centralize labels.
- Keep allowed values consistent.
- Validate transitions.
- Do not scatter status strings throughout the application.

## 9. Code Formatting

Use:

```bash
./vendor/bin/pint
```

Before delivery:

```bash
./vendor/bin/pint --test
```

## 10. Abstraction Policy

Do not create a new abstraction merely because it is theoretically possible.

Every class must have a clear responsibility.

Prefer simple, direct Laravel implementations.

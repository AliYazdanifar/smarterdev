
# Testing Standards

## 1. Testing Framework

Use Pest.

Install:

```bash
composer require --dev pestphp/pest pestphp/pest-plugin-laravel
```

## 2. Test Types

### Feature Tests

Use for:
- API endpoints
- Authentication
- Authorization
- Business workflows
- Database operations
- Validation
- Livewire interactions

### Unit Tests

Use for:
- Isolated business calculations
- Independent logic
- Complex algorithms
- Pure utility classes

Do not write unit tests for trivial code without meaningful value.

## 3. Feature Test Example

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a product successfully', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson('/api/products', [
            'name' => 'Product A',
            'price' => 100000,
        ])
        ->assertSuccessful()
        ->assertJsonPath('data.name', 'Product A');
});
```

Adjust authentication and permissions according to the project.

## 4. What Must Be Tested

- Successful operations
- Validation failures
- Unauthorized requests
- Forbidden operations
- Duplicate requests
- Boundary conditions
- Database constraints
- External service failures
- Important business rules

## 5. External Integrations

Never depend on real payment, SMS or third-party APIs during automated tests.

Use:
- Http::fake()
- Mockery when appropriate
- Laravel fakes

## 6. Database

Use factories.

Use RefreshDatabase or an appropriate testing strategy.

Do not run tests against production databases.

## 7. Commands

```bash
php artisan test
```

```bash
./vendor/bin/pest
```

```bash
./vendor/bin/pint --test
```

Run Larastan when configured.

## 8. Quality Requirements

Do not ignore failing tests.

Do not remove tests simply to make the test suite pass.

Every important new business workflow should have appropriate coverage.

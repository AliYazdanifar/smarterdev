
# Service Layer Standards

## 1. Purpose

Services contain business logic and application workflows.

Controllers, Livewire components and other presentation layers should delegate business operations to Services.

## 2. Example Structure

```text
Modules/Products/app/Services/
    ProductService.php
```

## 3. Example Service

```php
namespace Modules\Products\App\Services;

use Modules\Products\App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            return Product::create($data);
        });
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product->refresh();
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}
```

Adjust namespaces according to the installed Nwidart module structure.

## 4. Controller Example

```php
public function store(
    StoreProductRequest $request,
    ProductService $productService
): JsonResponse {
    $product = $productService->create(
        $request->validated()
    );

    return ApiResponse::success(
        new ProductResource($product)
    );
}
```

## 5. When to Use Actions

Use an Action when an operation:

- Has a clear independent responsibility.
- Represents a meaningful business command.
- Is reusable across multiple workflows.
- Should be independently tested.

Do not create an Action for every simple method.

## 6. Transactions

Use transactions for operations that must succeed or fail together.

Keep external API requests outside database transactions whenever possible.

Dispatch external side effects after commit when appropriate.

## 7. Important Rules

- Services should not depend on HTTP Requests.
- Services should receive validated data or explicit arguments.
- Services should not return HTTP responses.
- Services should not contain presentation logic.
- Avoid large Services with unrelated responsibilities.
- Keep methods focused and readable.
- Do not create interfaces without a real abstraction requirement.

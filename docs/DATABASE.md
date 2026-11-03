
# Database Engineering Standards

## 1. General Principles

Database design must prioritize:

- Data integrity
- Query performance
- Scalability
- Appropriate indexes
- Efficient storage

Design the database based on actual business requirements and query patterns.

## 2. Migrations

Use Laravel migrations.

Rules:

- Use appropriate column types.
- Avoid unnecessarily large columns.
- Add foreign keys where appropriate.
- Add unique constraints for business invariants.
- Use nullable columns only when necessary.
- Define delete behavior intentionally.
- Never modify migrations that have already been executed in shared environments.

## 3. Indexing

Every important query should be evaluated for indexing requirements.

Example:

```php
$table->index('status');

$table->index(['user_id', 'status']);

$table->unique(['user_id', 'reference']);
```

Indexing decisions must consider:

- WHERE conditions
- JOIN conditions
- ORDER BY
- Composite index column order
- Selectivity
- Write overhead

Do not create an index for every column.

Avoid duplicate indexes.

## 4. Foreign Keys

Example:

```php
$table->foreignId('user_id')
    ->constrained()
    ->restrictOnDelete();
```

Choose the appropriate deletion behavior:

- cascadeOnDelete
- restrictOnDelete
- nullOnDelete

Do not use cascading deletes blindly for financial or historical records.

## 5. Query Optimization

- Prevent N+1 queries.
- Use eager loading.
- Select only required columns.
- Use pagination.
- Use withCount when appropriate.
- Use chunkById for large batch operations.
- Analyze expensive queries using EXPLAIN.
- Avoid loading entire tables into memory.

## 6. Data Integrity

Use database constraints for important business invariants.

Do not rely exclusively on application-level validation for uniqueness or relationships.

Use transactions for multi-step database operations.

## 7. Money and Dates

Store monetary amounts as integer minor units when appropriate.

Document the currency and unit clearly.

Store dates and timestamps consistently, preferably in UTC for applications operating across timezones.

Convert to the application's display timezone at the presentation layer.

## 8. Production Migration Safety

Never:
- Drop important columns without approval.
- Delete production data without approval.
- Rewrite executed migrations.
- Assume a migration is safe because it works on an empty database.

For large tables, consider backward-compatible deployments and database-specific online schema changes.

Always inspect existing data before destructive schema changes.

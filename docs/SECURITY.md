
# Security Standards

## Authentication

Use Laravel Sanctum for SPA and API token authentication unless OAuth2 is required.

Never store plain-text passwords.

Use secure password hashing.

## Authorization

Use Spatie Laravel Permission.

Always verify authorization on the backend.

Never rely on frontend visibility to protect operations.

Check resource ownership.

Use appropriate middleware, Gates or service-level authorization.

## Input Validation

Validate all external inputs.

Use FormRequest for HTTP requests.

Never trust client-provided identifiers or values.

## File Uploads

Use Spatie Media Library for domain files.

Validate MIME types, extensions and file sizes.

Use private storage for sensitive documents.

Authorize file downloads.

Never trust original filenames or client-provided MIME types alone.

## Rate Limiting

Apply rate limiting to:

- Login
- OTP requests
- Password reset
- Expensive API endpoints
- Public forms
- Sensitive operations

## Webhooks

Verify provider signatures.

Protect against replay attacks.

Use idempotency for repeated webhook delivery.

Never trust incoming webhook data without validation.

## Logging

Never log:

- Passwords
- OTPs
- API secrets
- Access tokens
- Payment credentials
- Sensitive personal information

Log meaningful technical errors without exposing secrets.

## Database Security

Use parameter binding.

Avoid unsafe raw SQL.

Protect against mass assignment.

Use least-privilege database credentials.

## Production

- APP_DEBUG must be false.
- Keep secrets outside source control.
- Use HTTPS.
- Protect private files.
- Restrict debugging tools.
- Review permissions and server configuration.

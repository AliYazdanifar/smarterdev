
# Frontend Standards

## 1. Preferred Stack

The preferred frontend technologies are:

- Blade
- Livewire
- Vue.js 3
- Alpine.js
- Vite

Do not force all technologies into every project.

## 2. Blade

Blade is the default rendering solution.

Use it for:

- Standard pages
- Layouts
- Content pages
- Simple forms
- Server-rendered pages

## 3. Livewire

Install:

```bash
composer require livewire/livewire
```

Use Livewire for:

- Dynamic forms
- Interactive CRUD
- Filtering and pagination
- Admin panels
- Server-driven components
- Small and medium interactive features

Rules:

- Keep components focused.
- Delegate business logic to Services.
- Validate public properties.
- Authorize sensitive operations.
- Avoid N+1 queries.
- Use computed properties appropriately.
- Do not trust frontend state.

## 4. Vue.js

Use Vue 3 with Composition API.

Install when needed:

```bash
npm install vue
npm install -D @vitejs/plugin-vue
```

Use Vue for:

- Complex dashboards
- Advanced data visualization
- Interactive builders
- Drag-and-drop interfaces
- Complex client-side state
- Features requiring SPA behavior

Prefer:

```vue
<script setup>
// Component logic
</script>
```

Use Pinia only when shared state management is necessary.

Use Vue Router only when client-side routing is required.

## 5. Alpine.js

Use Alpine.js for lightweight interactions.

It can work alongside Livewire.

Do not use Alpine.js for complex application state.

## 6. Technology Selection

| Requirement | Preferred Technology |
|---|---|
| Simple page | Blade |
| Standard form | Blade |
| Dynamic server-side form | Livewire |
| Interactive table | Livewire |
| Complex dashboard | Vue |
| Advanced editor | Vue |
| Simple dropdown | Alpine.js |
| Full client-side application | Vue SPA |

## 7. Separation of Concerns

Business logic must remain in Services.

Blade, Livewire and Vue are presentation technologies.

Changing the frontend technology must not require rewriting business logic.

Do not duplicate validation and business rules between frontend and backend.

Backend validation and authorization remain mandatory.

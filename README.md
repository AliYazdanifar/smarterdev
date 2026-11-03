
# Laravel Project Standard

A reusable Laravel engineering standard for building modular, service-based and maintainable applications.

## Philosophy

**Modular + Service-Based + Laravel Best Practices + Minimal Complexity**

This repository provides reusable development standards for Cursor and Claude Code.

## Architecture

- Modular Monolith
- Nwidart Laravel Modules
- Service Layer
- Thin Controllers
- FormRequest
- JsonResource
- Eloquent ORM
- Dependency Injection
- Route Model Binding

## Frontend

- Blade as the default rendering engine
- Livewire for server-driven interactions
- Vue.js 3 for complex interfaces
- Alpine.js for lightweight interactions

## Packages

- Spatie Laravel Permission
- Spatie Laravel Media Library
- Spatie Laravel Activitylog
- Laravel Sanctum
- Livewire
- Pest
- Pint
- Larastan

See PACKAGES.md.

## Repository Structure

```text
.cursor/rules/
.claude/rules/
docs/
scripts/
CLAUDE.md
PACKAGES.md
README.md
```

## Installation

### Option 1: Installation Script

```bash
chmod +x scripts/install.sh
./scripts/install.sh /path/to/laravel-project
```

### Option 2: Manual Installation

Copy these files into your Laravel project:

- .cursor/
- .claude/
- CLAUDE.md
- PACKAGES.md
- docs/

For Windows, copy the folders using File Explorer.

## Cursor

Open the Laravel project in Cursor.

The rules under `.cursor/rules/` are automatically applied.

## Claude Code

Place CLAUDE.md in the Laravel project root.

Claude Code will use the project instructions.

## Starting a New Project

1. Create a Laravel project.
2. Install the required packages from PACKAGES.md.
3. Install this standard.
4. Ask Cursor or Claude to inspect the project.
5. Follow the architecture standards during development.

## Important

This repository provides architectural standards, not a forced framework.

Not every project needs Vue, every module needs every directory, or every operation needs an Action class.

Choose the simplest solution that meets the requirements.

## Versioning

Use Semantic Versioning:

- MAJOR: Breaking changes to standards.
- MINOR: New standards or capabilities.
- PATCH: Documentation corrections and improvements.

Maintain a CHANGELOG.md when releasing versions.

## License

MIT
```

## ۱۴. فایل `scripts/install.sh`

این اسکریپت قوانین را وارد پروژه موجود می‌کند و اگر فایلی از قبل وجود داشته باشد، آن را بدون اجازه جایگزین نمی‌کند.

<text color="success" weight="medium" size="sm">FILE 13 — scripts/install.sh</text>

<CodeBlock language="bash" editable>
#!/usr/bin/env bash

set -euo pipefail

SOURCE_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
TARGET_DIR="${1:-}"

if [[ -z "$TARGET_DIR" ]]; then
    echo "Usage: ./scripts/install.sh /path/to/laravel-project"
    exit 1
fi

TARGET_DIR="$(cd "$TARGET_DIR" && pwd)"

if [[ ! -f "$TARGET_DIR/artisan" || ! -f "$TARGET_DIR/composer.json" ]]; then
    echo "Error: Target is not a valid Laravel project."
    exit 1
fi

echo "Installing Laravel Project Standard..."
echo "Target: $TARGET_DIR"

install_file() {
    local source="$1"
    local target="$2"

    if [[ ! -f "$source" ]]; then
        return
    fi

    mkdir -p "$(dirname "$target")"

    if [[ -e "$target" ]]; then
        echo "Skipped existing file: $target"
        return
    fi

    cp "$source" "$target"
    echo "Installed: $target"
}

install_directory() {
    local source="$1"
    local target="$2"

    if [[ ! -d "$source" ]]; then
        return
    fi

    mkdir -p "$target"

    while IFS= read -r -d '' file; do
        local relative="${file#"$source"/}"
        install_file "$file" "$target/$relative"
    done < <(find "$source" -type f -print0)
}

install_directory "$SOURCE_DIR/.cursor" "$TARGET_DIR/.cursor"
install_directory "$SOURCE_DIR/.claude" "$TARGET_DIR/.claude"
install_directory "$SOURCE_DIR/docs" "$TARGET_DIR/docs"

install_file "$SOURCE_DIR/CLAUDE.md" "$TARGET_DIR/CLAUDE.md"
install_file "$SOURCE_DIR/PACKAGES.md" "$TARGET_DIR/PACKAGES.md"

echo ""
echo "Installation completed."
echo "Existing files were preserved."
echo ""
echo "Next steps:"
echo "1. Review PACKAGES.md"
echo "2. Install required dependencies."
echo "3. Open the project in Cursor or Claude Code."

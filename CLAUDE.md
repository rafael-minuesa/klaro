# Klaro WordPress Theme - Project Context

## Overview

Klaro is an accessibility-first WordPress theme with WCAG AAA compliance. The name means "clear/bright" in Spanish/Portuguese.

## Project Structure

```
klaro/                     # Root = theme directory (this gets packaged)
├── .git/                  # Git repository
├── .claude/               # Claude Code settings
├── style.css              # Theme metadata and styles
├── functions.php          # Theme functionality
├── readme.txt             # WordPress.org readme
├── CHANGELOG.md           # Version history
├── header.php             # Header template
├── footer.php             # Footer template
├── sidebar.php            # Sidebar template
├── index.php              # Main template
├── single.php             # Single post template
├── page.php               # Page template
├── archive.php            # Archive template
├── search.php             # Search results template
├── 404.php                # 404 template
├── comments.php           # Comments template
├── searchform.php         # Search form template
├── woocommerce.css        # WooCommerce styles
├── editor-style.css       # Editor styles
├── woocommerce/           # WooCommerce template overrides
├── template-parts/        # Reusable template components
├── js/                    # JavaScript files
├── banners/               # WordPress.org marketing assets
├── README.md              # GitHub readme
└── LICENSE                # GPL-2.0+ license
```

## Key Files

- **Version is defined in**: `style.css`, `readme.txt`
- **Changelog**: `CHANGELOG.md`
- **Widget areas**: `klaro-sidebar-1`, `klaro-footer-1`, `sidebar-shop` (WooCommerce)

## Important Patterns

### Widget Area IDs
All widget area IDs are prefixed with `klaro-` per WordPress.org requirements:
- `klaro-sidebar-1` (Primary Sidebar)
- `klaro-footer-1` (Footer Widgets)
- `sidebar-shop` (WooCommerce Shop Sidebar)

### WooCommerce Functions
All WooCommerce conditional functions (`is_product()`, `is_shop()`, `is_cart()`, etc.) must be wrapped in a `class_exists('WooCommerce')` check to prevent fatal errors when WooCommerce is not installed.

### Theme Check Compliance
- No plugin territory functionality
- All strings use proper i18n with `klaro` text domain
- GPL-2.0+ license required
- All bundled resources declared in readme.txt Resources section
- No shell scripts or zip files in theme directory (build output goes to parent folder)

### WooCommerce Hooks
All WooCommerce hook replacements (wrappers, sidebar, breadcrumbs) are registered on `init`, not `woocommerce_loaded`, because `woocommerce_loaded` fires during `plugins_loaded` before the theme loads.

### Accessibility-Ready Requirements
The theme declares `accessibility-ready` and must comply with all WordPress.org requirements:
- **No `role="menubar"`** on navigation menus — use native `<nav>` + `<ul>` + `<li>` semantics
- **`navigation-widgets`** must be in the `html5` theme support array
- All ARIA roles must follow proper parent-child relationships
- No redundant ARIA roles on semantic elements (e.g., no `role="article"` on `<article>`)
- All interactive elements must be `<button>`, `<input>`, or `<a>` — never clickable `<div>`/`<span>`
- Content links must be underlined (only accepted method)
- "Read more" links must include post title via screen-reader-text
- Full requirements: https://make.wordpress.org/themes/handbook/review/accessibility/required/

### Navigation Menu ARIA
- Navigation uses native HTML semantics only — no ARIA menu roles
- `js/navigation.js` adds `aria-expanded` for submenus via JavaScript
- CSS handles submenu display via `:hover`, `:focus-within`, and `a[aria-expanded="true"]`
- No custom Walker_Nav_Menu — uses WordPress default walker

## Local Development

- WordPress installation: `/srv/http/wordpress/`
- Theme symlink/copy to: `/srv/http/wordpress/wp-content/themes/klaro`
- Local URL: `http://localhost/wordpress/`

## Packaging for WordPress.org

```bash
cd /mnt/data/WebDev/WordPress/Themes/Klaro/klaro
zip -r ../klaro.zip . -x ".git/*" ".claude/*" "banners/*" "README.md" "LICENSE" ".gitignore" "CLAUDE.md" "vendor/*" "composer.*" ".wordpress-org/*" "WP-ORG-SUBMISSION.md" "build-wp-org-zip.*" "*.code-workspace"
```

## Code Quality

Run PHPCS with WordPress-Core standard:
```bash
./vendor/bin/phpcs --standard=WordPress-Core functions.php
./vendor/bin/phpcbf --standard=WordPress-Core functions.php  # Auto-fix
```

## Version Bumping Checklist

When releasing a new version:
1. Update `Version:` in `style.css`
2. Update `Stable tag:` in `readme.txt`
3. Add entry to `CHANGELOG.md`
4. Update version badge in `README.md`
5. Update `Current Version` in `CLAUDE.md`

## Current Version

**v2.1.8** - Fix CTA block pattern button contrast (Apr 2026)

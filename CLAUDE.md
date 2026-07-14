# Klaro WordPress Theme - Project Context

## Overview

Klaro is an accessibility-first WordPress theme with WCAG AAA color contrast (WCAG 2.2 AA conformance overall, per accessibility.txt).

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

#### 2026 requirements (added in v2.3.0, Trac #264262 — see memory `reference_accessibility_2026.md`)
- **Landmark accessible names must NOT contain the landmark type word** ("Primary", not "Primary Navigation")
- **Focus outlines / UI controls need 3:1 contrast.** The focus/accent color is `#C2410C` (5.18:1 on white) via `--color-focus` — do NOT revert to the old `#FF6B00` (2.86:1, fails)
- **`accessibility.txt`** in the theme root is REQUIRED (also gates the "Screen Reader Text Supported" check). Keep it current
- **Core + remote block patterns are disabled ON PURPOSE** in `klaro_setup()` (`remove_theme_support('core-block-patterns')` + `should_load_remote_block_patterns` filter) because they fail contrast and the theme can't fix them. Do NOT re-enable

### Navigation Menu ARIA (v2.3.0+)
- Native HTML semantics only — no ARIA menu roles, no custom Walker
- `js/navigation.js` injects a real `<button class="submenu-toggle" aria-expanded>` per submenu (button disclosure). The parent `<a>` stays a plain link
- Open state is the persistent `.submenu-open` class on the `<li>` (so submenus are Shift+Tab reachable); Esc closes + restores focus to the toggle
- CSS shows submenus via `li:hover` (mouse) and `li.submenu-open` (keyboard) — NOT `:focus-within`/`a[aria-expanded]` anymore
- Accessibility toolbar `<details>`: `js/accessibility.js` adds Esc-close and syncs `aria-expanded` on the `<summary>`

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

**v2.4.0** - Dark mode (toolbar toggle + Customizer contrast mode, `.klaro-dark`, WCAG AAA validated palette); fixed Customizer contrast classes never matching the stylesheet (now mapped to `klaro-`-prefixed classes in `klaro_body_classes()`). (Jul 2026. v2.3.3: pagination layout fixes; v2.3.2: accessibility audit for Trac #264262 re-review; v2.3.1: Tested up to WordPress 7.0; v2.3.0: accessibility-ready 2026 requirements)

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
- Theme COPY at `/srv/http/wordpress/wp-content/themes/klaro`; it does not follow git checkouts by itself. Sync the RELEASE file set, so Theme Check sees what ships: `sudo rsync -a --delete --delete-excluded --chown=http:http --exclude-from=.distignore ./ /srv/http/wordpress/wp-content/themes/klaro/`. `--delete-excluded` matters: plain `--delete` leaves excluded files in place, and a copy with CLAUDE.md and phpcs.xml.dist failed Theme Check with two REQUIRED errors (2026-09-26). To test several open PRs together, build a detached worktree of `origin/main`, merge the PR branches into it, sync from there, then remove the worktree.
- Local URL: `http://localhost/wordpress/` (redirects to /en/); traps (WooCommerce coming-soon mode, wc-multilang hiding shop products, test data IDs) in `.claude/memory/reference_local_test_site.md`
- Theme Check plugin installed locally: run `sudo -u http wp --path=/srv/http/wordpress theme-check run <slug>` on a copy of the release file set before every SVN commit; Theme Check 20260901 rejects "WORDPRESS" anywhere in shipped text, including CSS comments and old changelog lines (that failed the 2.7.2 import)

## Packaging for WordPress.org

`.distignore` is the single list of files kept out of the release. CI (`.github/workflows/ci.yml`) builds `klaro.zip` from it on every push/PR, checks required files are present and dev/prohibited files absent, and uploads it as the `klaro-zip` artifact. The same build locally:

```bash
cd /mnt/data/WebDev/WordPress/Themes/Klaro/klaro
rm -rf ../klaro-build ../klaro.zip && mkdir -p ../klaro-build
rsync -a --exclude-from=.distignore ./ ../klaro-build/
(cd ../klaro-build && zip -rqX ../klaro.zip .)
```

When adding a dev-only file, add it to `.distignore`; when adding a runtime file, check the "Verify package contents" step still lists what must ship.

## Code Quality

CI runs `php -l` on PHP 7.4 to 8.4, PHPCS and `node --check` on `js/*.js`. PHPCS uses `phpcs.xml.dist` (WordPress standard + PHPCompatibilityWP 7.4+, `klaro` text domain and prefix); errors fail the build, warnings don't. Documentation-style sniffs are excluded there on purpose (tracked in issue #23), and `wc_kses_notice` is registered as an escaping function.

```bash
composer install            # dev tooling only, never shipped
./vendor/bin/phpcs          # reads phpcs.xml.dist
./vendor/bin/phpcbf         # auto-fix
```

## Version Bumping Checklist

When releasing a new version:
1. Update `Version:` in `style.css`
2. Update `Stable tag:` in `readme.txt`
3. Add entry to `CHANGELOG.md`
4. Update version badge in `README.md`
5. Update `Current Version` in `CLAUDE.md`

## Current Version

**v2.9.0** - On WordPress.org SVN since 2026-09-26 (r351073): Reset all button in the toolbar (#21, PR #59), commerce assets only where used and inline SVG toolbar icon (#22, PR #58), widget heading and page-end spacing (PR #60), POT regenerated. Previous: **v2.8.2** - On WordPress.org SVN since 2026-09-23 (r350868): the September 2026 review fixes (tracker https://github.com/rafael-minuesa/klaro/issues/26) plus footer spacing and search form fixes from local testing. 2.8.0 and 2.8.1 exist as GitHub tags only. Previous: **v2.8.1** - Two fixes from local testing of 2.8.0 (footer spacing from the `.page` body-class collision, search form in narrow sidebars). NOT yet on SVN. Previous: **v2.8.0** - September 2026 review fixes (tracker https://github.com/rafael-minuesa/klaro/issues/26): 19 issues merged as one PR each (CTA/block contrast + editor styles, focus halo, sidebars rendered, WooCommerce names/skip links/quantity/checkout, toolbar announcements localized, preference resolvers, Customizer live preview + relative text steps, widget IDs, comment form, breadcrumbs, submenus, product-loop hooks; custom-header support removed). NOT yet on SVN, Rafael testing locally first. Previous: **v2.7.3** - Text-only republish of 2.7.2 after the WordPress.org theme check (updated 2026-09-01) rejected the 2.7.2 import for "WORDPRESS" capitalization in a style.css comment and three old CHANGELOG lines. Run `wp theme-check run klaro` on the local site before every SVN commit from now on (Theme Check plugin installed locally 2026-09-23). Previous: **v2.7.2** - Bug-fix release from the September 2026 review (tracking issue https://github.com/rafael-minuesa/klaro/issues/26): featured-image alt preserved, rel tokens preserved, duplicate WooCommerce cart/rating filters removed, localized "Settings saved", Requires at least 6.6, expanded description and corrected README claims. (Sep 2026.) Previous: **v2.7.1** - Maintenance release, code identical to 2.7.0 (verified with `diff -rq` against `svn/2.7.0/`). WordPress.org never created a Trac ticket for the 2.7.0 tag, so the directory kept serving 2.6.0; 2.7.1 republishes the same code under a new version number to force a fresh import. Previous: **v2.7.0** - Reading aids toolbar section: WCAG 1.4.12 text spacing, link highlighting (box-shadow + currentColor, deliberately NOT outline so focus indicators keep winning), large SVG data-URI cursor (interactive elements keep native cursors). (Jul 2026.) Previous: **v2.6.0** - Dyslexia-friendly font toggle (bundled OpenDyslexic woff2 in `fonts/`, SIL OFL 1.1 declared in readme Resources; `body.klaro-dyslexia-font` overrides `--font-base` plus explicit rules for form controls, which never inherit fonts; dashicons untouched). (Jul 2026. v2.5.0: color vision filters, one composed feColorMatrix per type in footer.php applied in linearRGB to `.site-container`, never `body`, to keep the fixed admin bar working; v2.4.0: dark mode toolbar toggle + Customizer contrast mode and the Customizer body-class mapping fix; v2.3.3: pagination layout fixes; v2.3.2: accessibility audit for Trac #264262 re-review; v2.3.1: Tested up to WordPress 7.0; v2.3.0: accessibility-ready 2026 requirements)

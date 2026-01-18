# WordPress.org Theme Submission Guide

This guide explains how to prepare the Klaro theme for submission to the WordPress.org theme directory.

## Quick Start

### Linux/macOS:
```bash
./build-wp-org-zip.sh
```

### Windows:
```cmd
build-wp-org-zip.bat
```

The script will create `klaro.zip` in the parent directory, ready for submission.

## Manual Method

If you prefer to create the ZIP manually:

1. Navigate to the theme directory (`klaro/`)
2. Create a ZIP file excluding:
   - `.gitignore`
   - `CLAUDE.md`
   - `README.md`
   - `CHANGELOG.md`
   - `banners/` folder (entire folder)
   - `woocommerce/single-product/` folder (if empty)
   - `build-wp-org-zip.sh` and `build-wp-org-zip.bat`
   - Any `.DS_Store` files
   - Any IDE files (`.vscode/`, `.idea/`, etc.)

## Files Included in ZIP

✅ **Required Files:**
- `style.css` (with theme header)
- `readme.txt` (WordPress.org format)
- `screenshot.png` (1200x900px)
- `LICENSE` (GPL v2)

✅ **Template Files:**
- All PHP template files (`*.php`)
- `template-parts/` directory
- `woocommerce/` templates (excluding empty directories)

✅ **Assets:**
- `js/` directory (all JavaScript files)
- `assets/` directory (theme icon)
- `editor-style.css`
- `woocommerce.css`

## Files Excluded from ZIP

❌ **Development Files:**
- `.gitignore`
- `CLAUDE.md`
- `README.md`
- `CHANGELOG.md`
- `build-wp-org-zip.sh` / `build-wp-org-zip.bat`
- `WP-ORG-SUBMISSION.md` (this file)

❌ **Not Needed:**
- `banners/` folder (uploaded separately to WordPress.org)
- Empty directories

## WordPress.org Submission Checklist

Before submitting, verify:

- [ ] ZIP file is named `klaro.zip`
- [ ] ZIP contains only the `klaro/` folder contents (not the folder itself)
- [ ] `style.css` has correct theme header with version 2.0.2
- [ ] `readme.txt` is up to date
- [ ] `screenshot.png` is 1200x900px and under 1MB
- [ ] No development files included
- [ ] All PHP files use proper escaping functions
- [ ] No hardcoded URLs or paths
- [ ] Text domain is consistent (`klaro`)
- [ ] All strings are translatable

## Banner Images

The `banners/` folder contains images for the WordPress.org theme directory listing:
- `banner-1544x500.png` - Main banner (1544x500px)
- `banner-772x250.png` - Thumbnail banner (772x250px)

**These are uploaded separately** during the WordPress.org submission process, not included in the ZIP.

## Submission Process

1. Create the ZIP using the script above
2. Go to [WordPress.org Theme Upload](https://wordpress.org/themes/upload/)
3. Upload `klaro.zip`
4. Upload banner images separately when prompted
5. Fill out the submission form
6. Wait for review (typically 2-4 weeks)

## After Submission

- Monitor your email for reviewer feedback
- Respond promptly to any requested changes
- Once approved, the theme will be available in the WordPress.org theme directory

## Resources

- [WordPress Theme Review Handbook](https://make.wordpress.org/themes/handbook/)
- [Theme Review Guidelines](https://make.wordpress.org/themes/handbook/review/)
- [Theme Unit Test Data](https://codex.wordpress.org/Theme_Unit_Test)

---

**Note:** This file (`WP-ORG-SUBMISSION.md`) should NOT be included in the submission ZIP.

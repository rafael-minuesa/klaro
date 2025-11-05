# Git Setup & GitHub Repository Creation

Follow these steps to initialize your GitHub repository and push the Klaro theme.

## Prerequisites

- GitHub account (https://github.com/rafael-minuesa)
- Git installed on your system
- Terminal/command line access

---

## Step 1: Create GitHub Repository

1. **Go to GitHub:**
   - Visit: https://github.com/new
   - Or: https://github.com/rafael-minuesa?tab=repositories → Click "New"

2. **Repository Settings:**
   ```
   Repository name: klaro
   Description: An uncompromisingly accessible WordPress theme (WCAG AAA)
   Visibility: Public

   ✅ Add README file: NO (we already have one)
   ✅ Add .gitignore: NO (we already have one)
   ✅ Choose a license: NO (we already have GPL-2.0)
   ```

3. **Click:** "Create repository"

---

## Step 2: Initialize Local Git Repository

Open terminal and navigate to the project directory:

```bash
cd /mnt/data/WebDev/WordPress/Themes/Klaro/www
```

### Initialize Git

```bash
# Initialize git repository
git init

# Check status
git status
```

### Configure Git (if not already done)

```bash
# Set your name and email
git config user.name "Rafael Minuesa"
git config user.email "your-email@example.com"

# Or set globally (for all repositories)
git config --global user.name "Rafael Minuesa"
git config --global user.email "your-email@example.com"
```

---

## Step 3: Stage and Commit Files

```bash
# Add all files (respects .gitignore)
git add .

# Check what will be committed
git status

# Create first commit
git commit -m "Initial commit: Klaro v1.1.0 - Accessibility-first WordPress theme"
```

---

## Step 4: Connect to GitHub

```bash
# Add remote repository
git remote add origin https://github.com/rafael-minuesa/klaro.git

# Verify remote
git remote -v
```

---

## Step 5: Push to GitHub

```bash
# Push to GitHub (main branch)
git branch -M main
git push -u origin main
```

**You'll be prompted for GitHub credentials:**
- Username: `rafael-minuesa`
- Password: Use a [Personal Access Token](https://github.com/settings/tokens)

---

## Step 6: Create a Release/Tag

```bash
# Create a tag for version 1.1.0
git tag -a v1.1.0 -m "Release v1.1.0 - WordPress.org submission ready"

# Push the tag
git push origin v1.1.0
```

---

## Step 7: Create GitHub Release (Optional)

1. Go to: https://github.com/rafael-minuesa/klaro/releases
2. Click "Create a new release"
3. Choose tag: `v1.1.0`
4. Release title: `Klaro v1.1.0 - Initial Release`
5. Description:
   ```markdown
   ## Klaro v1.1.0 - Initial Release

   First public release of Klaro, an accessibility-first WordPress theme.

   ### Features
   - WCAG AAA compliance (7:1 contrast ratios)
   - Full keyboard navigation
   - Screen reader optimized
   - User-adjustable text sizes and color modes
   - Admin accessibility enhancements
   - Comprehensive ARIA implementation

   ### Installation
   Download `klaro.zip` and install via WordPress Admin:
   Appearance > Themes > Add New > Upload Theme

   ### Requirements
   - WordPress 6.0+
   - PHP 7.4+

   See [README.md](https://github.com/rafael-minuesa/klaro) for full documentation.
   ```
6. Attach `klaro.zip` file
7. Click "Publish release"

---

## Useful Git Commands

### Daily Workflow

```bash
# Check status
git status

# Add specific files
git add klaro-theme/style.css
git add klaro-theme/functions.php

# Or add all changed files
git add .

# Commit changes
git commit -m "Update: Description of changes"

# Push to GitHub
git push
```

### View History

```bash
# View commit history
git log

# View recent commits (one line each)
git log --oneline

# View changes in last commit
git show
```

### Branches

```bash
# Create new branch
git checkout -b feature-name

# Switch branches
git checkout main

# Merge branch
git merge feature-name

# Delete branch
git branch -d feature-name
```

### Tagging Versions

```bash
# Create annotated tag
git tag -a v1.2.0 -m "Release v1.2.0"

# Push tag to GitHub
git push origin v1.2.0

# List all tags
git tag

# Delete tag
git tag -d v1.2.0
git push origin :refs/tags/v1.2.0
```

---

## .gitignore Already Configured

The `.gitignore` file is already set up to exclude:
- WordPress core files
- Node modules
- IDE files (.vscode, .idea)
- OS files (.DS_Store)
- Log files
- Temporary files
- The .claude directory

---

## Best Practices

### Commit Messages

Good commit messages:
```
✅ "Fix: Search button wrapping on mobile devices"
✅ "Add: Dashicons support for accessibility icon"
✅ "Update: README with installation instructions"
✅ "Release: Version 1.1.0"
```

Bad commit messages:
```
❌ "fixes"
❌ "update"
❌ "changes"
❌ "asdf"
```

### When to Commit

- After completing a feature
- After fixing a bug
- Before making major changes
- At logical stopping points
- When code is working

### When to Push

- After one or more related commits
- At end of work session
- Before switching computers
- Before making risky changes

---

## Troubleshooting

### "Permission denied (publickey)"

**Solution:** Use HTTPS instead of SSH, or set up SSH keys:
```bash
# Change to HTTPS
git remote set-url origin https://github.com/rafael-minuesa/klaro.git
```

### "fatal: remote origin already exists"

**Solution:** Update the existing remote:
```bash
git remote set-url origin https://github.com/rafael-minuesa/klaro.git
```

### Undo Last Commit (not pushed)

```bash
git reset --soft HEAD~1
```

### Discard Local Changes

```bash
# Discard changes in specific file
git checkout -- filename

# Discard all local changes
git reset --hard HEAD
```

---

## Next Steps

After pushing to GitHub:

1. ✅ Verify repository: https://github.com/rafael-minuesa/klaro
2. ✅ Create v1.1.0 release with klaro.zip attachment
3. ✅ Add repository description and topics on GitHub
4. ✅ Enable GitHub Pages (optional - for demo site)
5. ✅ Submit theme to WordPress.org

---

**Your repository is ready!** 🚀

Visit: https://github.com/rafael-minuesa/klaro

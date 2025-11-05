#!/bin/bash

# Klaro Theme - Git Setup and Push Script
# This script initializes git, commits, and pushes to GitHub

echo "================================================"
echo "Klaro Theme - GitHub Setup"
echo "================================================"
echo ""

# Navigate to project directory
cd /mnt/data/WebDev/WordPress/Themes/Klaro/www

echo "📁 Current directory: $(pwd)"
echo ""

# Check if git is initialized
if [ -d ".git" ]; then
    echo "⚠️  Git already initialized in this directory"
    read -p "Do you want to continue? (y/n) " -n 1 -r
    echo ""
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        echo "Aborted."
        exit 1
    fi
else
    echo "✅ Initializing Git repository..."
    git init
fi

echo ""
echo "👤 Configuring Git user..."
git config user.name "Rafael Minuesa"
read -p "Enter your email for Git commits: " email
git config user.email "$email"

echo ""
echo "📝 Checking repository status..."
git status

echo ""
echo "➕ Adding all files..."
git add .

echo ""
echo "💾 Creating initial commit..."
git commit -m "Initial commit: Klaro v1.1.0 - Accessibility-first WordPress theme

Features:
- WCAG AAA compliance (7:1 contrast ratios)
- Full keyboard navigation with visible focus indicators
- Screen reader optimized with comprehensive ARIA
- User-adjustable text sizes (18px-32px)
- Multiple color modes (standard, high contrast, monochrome)
- Admin accessibility enhancements
- WordPress Starter Content integration
- GPL v2.0 licensed"

echo ""
echo "🔗 Adding GitHub remote..."
git remote add origin https://github.com/rafael-minuesa/klaro.git

echo ""
echo "🌿 Renaming branch to 'main'..."
git branch -M main

echo ""
echo "🚀 Pushing to GitHub..."
echo "⚠️  You will be prompted for GitHub credentials"
echo ""
git push -u origin main

echo ""
echo "🏷️  Creating version tag v1.1.0..."
git tag -a v1.1.0 -m "Release v1.1.0 - WordPress.org submission ready

First public release featuring:
- WCAG AAA accessibility compliance
- Comprehensive keyboard and screen reader support
- User customization options
- Admin accessibility features
- Full WordPress.org compliance"

echo ""
echo "📤 Pushing tag to GitHub..."
git push origin v1.1.0

echo ""
echo "================================================"
echo "✅ SUCCESS! Repository created and pushed"
echo "================================================"
echo ""
echo "📍 Your repository: https://github.com/rafael-minuesa/klaro"
echo ""
echo "Next steps:"
echo "1. Visit https://github.com/rafael-minuesa/klaro"
echo "2. Create a release for v1.1.0"
echo "3. Upload klaro.zip to the release"
echo "4. Submit theme to WordPress.org"
echo ""

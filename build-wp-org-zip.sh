#!/bin/bash

# Build WordPress.org Submission ZIP for Klaro Theme
# This script creates a clean zip file excluding development files

set -e  # Exit on error

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Get the directory where the script is located
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
THEME_DIR="$SCRIPT_DIR"
PARENT_DIR="$(dirname "$THEME_DIR")"
ZIP_NAME="klaro.zip"
ZIP_PATH="$PARENT_DIR/$ZIP_NAME"

echo -e "${GREEN}Building WordPress.org submission ZIP for Klaro Theme...${NC}"
echo ""

# Check if we're in the right directory
if [ ! -f "$THEME_DIR/style.css" ]; then
    echo -e "${RED}Error: style.css not found. Please run this script from the theme directory.${NC}"
    exit 1
fi

# Remove old zip if it exists
if [ -f "$ZIP_PATH" ]; then
    echo -e "${YELLOW}Removing existing $ZIP_NAME...${NC}"
    rm "$ZIP_PATH"
fi

# Change to parent directory so the ZIP contains a single top-level `klaro/` folder
cd "$PARENT_DIR"

echo -e "${GREEN}Creating ZIP file...${NC}"
echo ""

# Create zip excluding development files
echo "Excluding development files:"
echo "  - .gitignore"
  echo "  - .git/ folder"
  echo "  - .claude/ folder"
echo "  - CLAUDE.md"
echo "  - README.md"
echo "  - CHANGELOG.md"
echo "  - WP-ORG-SUBMISSION.md"
  echo "  - .wordpress-org/ folder"
  echo "  - banners/ folder"
  echo "  - editor/workspace files"
echo "  - build scripts"
echo ""

zip -r "$ZIP_PATH" klaro/ \
    -x "klaro/.git/*" \
    -x "klaro/.gitignore" \
    -x "klaro/.claude/*" \
    -x "klaro/CLAUDE.md" \
    -x "klaro/README.md" \
    -x "klaro/CHANGELOG.md" \
    -x "klaro/WP-ORG-SUBMISSION.md" \
    -x "klaro/.wordpress-org/*" \
    -x "klaro/banners/*" \
    -x "klaro/woocommerce/single-product/*" \
    -x "klaro/build-wp-org-zip.sh" \
    -x "klaro/build-wp-org-zip.bat" \
    -x "klaro/klaro.code-workspace" \
    -x "klaro/*.DS_Store" \
    -x "klaro/*__MACOSX*" \
    -x "klaro/*.zip" \
    -x "klaro/*.log" \
    -x "klaro/node_modules/*" \
    -x "klaro/.vscode/*" \
    -x "klaro/.idea/*" \
    -x "klaro/*.swp" \
    -x "klaro/*.swo" \
    -x "klaro/*~"

# Verify zip was created
if [ -f "$ZIP_PATH" ]; then
    ZIP_SIZE=$(du -h "$ZIP_PATH" | cut -f1)
    echo ""
    echo -e "${GREEN}✓ ZIP file created successfully!${NC}"
    echo -e "  Location: ${YELLOW}$ZIP_PATH${NC}"
    echo -e "  Size: ${YELLOW}$ZIP_SIZE${NC}"
    echo ""
    echo -e "${GREEN}Files included:${NC}"
    unzip -l "$ZIP_PATH" | tail -n +4 | head -n -2 | awk '{print "  " $4}'
    echo ""
    echo -e "${GREEN}Ready for WordPress.org submission!${NC}"
else
    echo -e "${RED}Error: ZIP file was not created.${NC}"
    exit 1
fi

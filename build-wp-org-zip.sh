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

# Change to theme directory
cd "$THEME_DIR"

echo -e "${GREEN}Creating ZIP file...${NC}"
echo ""

# Create zip excluding development files
echo "Excluding development files:"
echo "  - .gitignore"
echo "  - CLAUDE.md"
echo "  - README.md"
echo "  - CHANGELOG.md"
echo "  - WP-ORG-SUBMISSION.md"
echo "  - .wordpress-org/ folder"
echo "  - assets/ folder (empty)"
echo "  - build scripts"
echo ""

zip -r "$ZIP_PATH" . \
    -x "*.git*" \
    -x ".gitignore" \
    -x ".claude/*" \
    -x "CLAUDE.md" \
    -x "README.md" \
    -x "CHANGELOG.md" \
    -x "WP-ORG-SUBMISSION.md" \
    -x ".wordpress-org/*" \
    -x "assets/*" \
    -x "woocommerce/single-product/*" \
    -x "*.DS_Store" \
    -x "*__MACOSX*" \
    -x "*.zip" \
    -x "*.log" \
    -x "build-wp-org-zip.sh" \
    -x "build-wp-org-zip.bat" \
    -x "node_modules/*" \
    -x ".vscode/*" \
    -x ".idea/*" \
    -x "*.swp" \
    -x "*.swo" \
    -x "*~"

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

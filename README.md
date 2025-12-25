# Klaro WordPress Theme

**An uncompromisingly accessible WordPress Theme that prioritizes Accessibility First.**

![WordPress Theme](https://img.shields.io/badge/WordPress-Theme-blue.svg)
![Version](https://img.shields.io/badge/version-1.4.0-green.svg)
![License](https://img.shields.io/badge/license-GPL--2.0%2B-blue.svg)
![WCAG](https://img.shields.io/badge/WCAG-AAA-success.svg)

---
![Klaro WordPress Theme screenshot](banners/banner-1544x500.png)

## 🌟 Overview

Klaro is a WordPress theme built from the ground up with accessibility as the primary focus, not an afterthought. While most themes add accessibility features after design, Klaro starts with **WCAG AAA compliance** and builds everything around that foundation.

Perfect for:
- Government and educational institutions
- Non-profit organizations
- Healthcare providers
- WordPress developers and Content creators with disabilities
- Any site committed to digital accessibility

---

## ✨ Key Features

### Visual Accessibility
- ✅ **WCAG AAA Contrast Ratios** (7:1 minimum for all text)
- ✅ **Multiple Color Modes**: Standard AAA, High Contrast, Monochrome
- ✅ **User-Adjustable Text Sizes**: 18px base (up to 32px)
- ✅ **Generous Line Spacing**: 1.8 line height default
- ✅ **Optimal Line Length**: Maximum 70 characters for readability

### Keyboard & Motor Accessibility
- ✅ **Full Keyboard Navigation**: Every feature accessible via keyboard
- ✅ **Highly Visible Focus Indicators**: 3px thick, high-contrast outlines
- ✅ **Large Touch Targets**: Minimum 44x44px for all interactive elements
- ✅ **Comprehensive Skip Links**: Skip to navigation, main content, sidebar, and footer

### Screen Reader Optimization
- ✅ **Semantic HTML5 Structure**: Proper heading hierarchy throughout
- ✅ **Comprehensive ARIA Implementation**: Landmarks, labels, live regions
- ✅ **Meaningful Link Text**: No "click here" or generic links
- ✅ **Alt Text Enforcement**: Prevents publishing without image descriptions
- ✅ **Breadcrumb Navigation**: Schema.org structured data on all pages

### Cognitive & Motion Accessibility
- ✅ **Respects prefers-reduced-motion**: No unwanted animations
- ✅ **User Toggle for Animations**: Complete control over motion
- ✅ **No Autoplay**: All media requires user interaction
- ✅ **Clear Visual Hierarchy**: Consistent, logical layout

### Admin Accessibility
- ✅ **Classic Editor Option**: Better screen reader support than Gutenberg
- ✅ **High Contrast Admin Mode**: For low vision users
- ✅ **Large Admin Text Option**: Increased font sizes
- ✅ **Enhanced Focus Indicators**: Throughout WordPress admin
- ✅ **Disable Admin Animations**: For vestibular disorder support

---

## 📦 Installation

### WordPress Admin (Recommended)

1. Download `klaro.zip` from [Releases](https://github.com/rafael-minuesa/klaro/releases)
2. Go to **Appearance > Themes > Add New**
3. Click **Upload Theme**
4. Choose the ZIP file and click **Install Now**
5. Click **Activate**

### Manual Installation

1. Download and unzip the theme
2. Upload the `klaro-theme` folder to `/wp-content/themes/`
3. Go to **Appearance > Themes**
4. Activate **Klaro**

### Via WordPress.org

Once approved, you will be able to install it directly from WordPress.org:

```
Appearance > Themes > Add New > Search "Klaro"
```

---

## 🎨 Child Theme

This repository includes an example child theme in `klaro-theme-child/`.

### Creating a Child Theme:

1. Copy the `klaro-theme-child` folder to `/wp-content/themes/`
2. Activate the child theme in **Appearance > Themes**
3. Customize the child theme without modifying the parent

See `klaro-theme-child/README.md` for detailed instructions.

---

## 🛠️ Requirements

- **WordPress:** 6.0 or higher
- **PHP:** 7.4 or higher
- **Modern Browser**: Chrome, Firefox, Safari, Edge (last 2 versions)

---

## 📖 Documentation

- **[Installation Guide](klaro-theme/INSTALL.md)** - Coming soon
- **[Customization Guide](klaro-theme/CUSTOMIZATION.md)** - Coming soon
- **[Accessibility Features](klaro-theme/ACCESSIBILITY.md)** - Coming soon
- **[Changelog](CHANGELOG.md)** - Version history

---

## 🎯 Accessibility Standards Met

- ✅ **WCAG 2.1 Level AAA** compliance
- ✅ **Section 508** compliance
- ✅ **ARIA 1.2** specifications
- ✅ **Keyboard navigation** (all features)
- ✅ **Screen reader compatibility** (NVDA, JAWS, VoiceOver, ORCA)

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

### Development Setup:

```bash
# Clone the repository
git clone https://github.com/rafael-minuesa/klaro.git

# Navigate to theme directory
cd klaro/klaro-theme

# Symlink to WordPress themes directory (adjust path as needed)
ln -s $(pwd) /path/to/wordpress/wp-content/themes/klaro-theme
```

### Reporting Issues:

Found a bug or accessibility issue? Please [open an issue](https://github.com/rafael-minuesa/klaro/issues) with:
- WordPress version
- Theme version
- Steps to reproduce
- Expected vs actual behavior
- Screenshots (if applicable)

---

## 📄 License

Klaro WordPress Theme, Copyright 2025 Rafael Minuesa

Klaro is distributed under the terms of the [GNU General Public License v2.0 or later](LICENSE).

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

---

## 🙏 Credits

- Built with accessibility in mind from day one
- Tested with NVDA, JAWS, VoiceOver, and ORCA screen readers
- Follows WordPress Coding Standards
- Inspired by the need for truly accessible web experiences

---

## 🔗 Links

- **WordPress.org:** Coming soon
- **GitHub:** https://github.com/rafael-minuesa/klaro
- **Issues:** https://github.com/rafael-minuesa/klaro/issues
- **Author:** https://github.com/rafael-minuesa

---

**Made with ♿ for everyone**

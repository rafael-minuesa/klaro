/**
 * Klaro Accessibility Enhancements
 * 
 * @package Klaro
 * @since 1.0.0
 */

(function() {
    'use strict';

    // Settings storage
    const STORAGE_KEY = 'klaro_accessibility_settings';

    // Get accessibility settings from localStorage
    function getSettings() {
        const stored = localStorage.getItem(STORAGE_KEY);
        return stored ? JSON.parse(stored) : {
            fontSize: 'normal',
            contrast: 'normal',
            animations: 'enabled'
        };
    }

    // Save settings to localStorage
    function saveSettings(settings) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(settings));
        announceChange('Settings saved');
    }

    // Announce changes to screen readers
    function announceChange(message) {
        const status = document.getElementById('klaro-accessibility-status');
        if (status) {
            status.textContent = message;
            // Clear after 3 seconds
            setTimeout(() => {
                status.textContent = '';
            }, 3000);
        }
    }

    // Apply saved settings on page load
    function applySavedSettings() {
        const settings = getSettings();
        const html = document.documentElement;
        const body = document.body;

        // Apply font size to html element (root for rem units)
        if (settings.fontSize === 'medium') {
            html.classList.add('klaro-medium-text');
        } else if (settings.fontSize === 'large') {
            html.classList.add('klaro-large-text');
        } else if (settings.fontSize === 'extra-large') {
            html.classList.add('klaro-extra-large-text');
        } else if (settings.fontSize === 'maximum') {
            html.classList.add('klaro-maximum-text');
        }

        // Apply contrast to body
        if (settings.contrast === 'high') {
            body.classList.add('klaro-high-contrast');
            updateButtonState('klaro-toggle-contrast', true);
        } else if (settings.contrast === 'klaro-monochrome') {
            body.classList.add('klaro-monochrome');
            updateButtonState('klaro-toggle-klaro-monochrome', true);
        }

        // Apply animation preference to html (affects all descendants)
        if (settings.animations === 'disabled') {
            html.classList.add('klaro-reduce-motion');
            updateButtonState('klaro-toggle-animations', true);
        }
    }

    // Update button pressed state
    function updateButtonState(buttonId, isPressed) {
        const button = document.getElementById(buttonId);
        if (button) {
            button.setAttribute('aria-pressed', isPressed ? 'true' : 'false');
        }
    }

    // Font size controls
    function initFontSizeControls() {
        const increaseBtn = document.getElementById('klaro-increase-font');
        const decreaseBtn = document.getElementById('klaro-decrease-font');
        const resetBtn = document.getElementById('klaro-reset-font');
        const html = document.documentElement;

        // Font size levels: normal (18px) → medium (20px) → large (22px) → extra-large (26px) → maximum (32px)
        const fontSizeClasses = ['klaro-medium-text', 'klaro-large-text', 'klaro-extra-large-text', 'klaro-maximum-text'];

        function clearFontClasses() {
            fontSizeClasses.forEach(cls => html.classList.remove(cls));
        }

        if (!increaseBtn || !decreaseBtn || !resetBtn) return;

        increaseBtn.addEventListener('click', () => {
            const settings = getSettings();
            clearFontClasses();

            if (settings.fontSize === 'normal') {
                html.classList.add('klaro-medium-text');
                settings.fontSize = 'medium';
                announceChange('Text size: medium (20px)');
            } else if (settings.fontSize === 'medium') {
                html.classList.add('klaro-large-text');
                settings.fontSize = 'large';
                announceChange('Text size: large (22px)');
            } else if (settings.fontSize === 'large') {
                html.classList.add('klaro-extra-large-text');
                settings.fontSize = 'extra-large';
                announceChange('Text size: extra large (26px)');
            } else if (settings.fontSize === 'extra-large') {
                html.classList.add('klaro-maximum-text');
                settings.fontSize = 'maximum';
                announceChange('Text size: maximum (32px)');
            } else {
                html.classList.add('klaro-maximum-text');
                announceChange('Text size is already at maximum');
                return;
            }

            saveSettings(settings);
        });

        decreaseBtn.addEventListener('click', () => {
            const settings = getSettings();
            clearFontClasses();

            if (settings.fontSize === 'maximum') {
                html.classList.add('klaro-extra-large-text');
                settings.fontSize = 'extra-large';
                announceChange('Text size: extra large (26px)');
            } else if (settings.fontSize === 'extra-large') {
                html.classList.add('klaro-large-text');
                settings.fontSize = 'large';
                announceChange('Text size: large (22px)');
            } else if (settings.fontSize === 'large') {
                html.classList.add('klaro-medium-text');
                settings.fontSize = 'medium';
                announceChange('Text size: medium (20px)');
            } else if (settings.fontSize === 'medium') {
                settings.fontSize = 'normal';
                announceChange('Text size: normal (18px)');
            } else if (settings.fontSize === 'normal' || !settings.fontSize) {
                announceChange('Text size is already at minimum');
                return;
            } else {
                // Handle any unknown/legacy values - reset to normal
                settings.fontSize = 'normal';
                announceChange('Text size: normal (18px)');
            }

            saveSettings(settings);
        });

        resetBtn.addEventListener('click', () => {
            const settings = getSettings();
            clearFontClasses();
            settings.fontSize = 'normal';
            saveSettings(settings);
            announceChange('Text size reset to normal (18px)');
        });
    }

    // High contrast mode
    function initContrastControls() {
        const contrastBtn = document.getElementById('klaro-toggle-contrast');
        const klaro-monochromeBtn = document.getElementById('klaro-toggle-klaro-monochrome');
        const body = document.body;

        if (!contrastBtn || !klaro-monochromeBtn) return;

        contrastBtn.addEventListener('click', () => {
            const settings = getSettings();
            
            // Remove other contrast modes
            body.classList.remove('klaro-monochrome');
            updateButtonState('klaro-toggle-klaro-monochrome', false);
            
            if (settings.contrast === 'high') {
                body.classList.remove('klaro-high-contrast');
                settings.contrast = 'normal';
                updateButtonState('klaro-toggle-contrast', false);
                announceChange('High contrast mode disabled');
            } else {
                body.classList.add('klaro-high-contrast');
                settings.contrast = 'high';
                updateButtonState('klaro-toggle-contrast', true);
                announceChange('High contrast mode enabled');
            }
            
            saveSettings(settings);
        });

        klaro-monochromeBtn.addEventListener('click', () => {
            const settings = getSettings();
            
            // Remove other contrast modes
            body.classList.remove('klaro-high-contrast');
            updateButtonState('klaro-toggle-contrast', false);
            
            if (settings.contrast === 'klaro-monochrome') {
                body.classList.remove('klaro-monochrome');
                settings.contrast = 'normal';
                updateButtonState('klaro-toggle-klaro-monochrome', false);
                announceChange('Monochrome mode disabled');
            } else {
                body.classList.add('klaro-monochrome');
                settings.contrast = 'klaro-monochrome';
                updateButtonState('klaro-toggle-klaro-monochrome', true);
                announceChange('Monochrome mode enabled');
            }
            
            saveSettings(settings);
        });
    }

    // Animation controls
    function initAnimationControls() {
        const animationBtn = document.getElementById('klaro-toggle-animations');
        const html = document.documentElement;

        if (!animationBtn) return;

        animationBtn.addEventListener('click', () => {
            const settings = getSettings();

            if (settings.animations === 'disabled') {
                html.classList.remove('klaro-reduce-motion');
                settings.animations = 'enabled';
                updateButtonState('klaro-toggle-animations', false);
                announceChange('Animations enabled');
            } else {
                html.classList.add('klaro-reduce-motion');
                settings.animations = 'disabled';
                updateButtonState('klaro-toggle-animations', true);
                announceChange('Animations disabled');
            }

            saveSettings(settings);
        });
    }

    // Add klaro-reduce-motion class based on system preference
    function initReducedMotion() {
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
        const html = document.documentElement;

        if (prefersReducedMotion.matches) {
            html.classList.add('klaro-reduce-motion');
        }

        // Listen for changes
        prefersReducedMotion.addEventListener('change', (e) => {
            if (e.matches) {
                html.classList.add('klaro-reduce-motion');
            } else {
                html.classList.remove('klaro-reduce-motion');
            }
        });
    }

    // Enhanced focus visibility for keyboard navigation
    function initFocusManagement() {
        let isUsingKeyboard = false;

        // Detect keyboard usage
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                isUsingKeyboard = true;
                document.body.classList.add('klaro-keyboard-nav');
            }
        });

        // Detect mouse usage
        document.addEventListener('mousedown', () => {
            isUsingKeyboard = false;
            document.body.classList.remove('klaro-keyboard-nav');
        });
    }

    // Add proper focus management for modals/dialogs
    function trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
        );
        
        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];

        element.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusable) {
                        lastFocusable.focus();
                        e.preventDefault();
                    }
                } else {
                    if (document.activeElement === lastFocusable) {
                        firstFocusable.focus();
                        e.preventDefault();
                    }
                }
            }

            if (e.key === 'Escape') {
                element.close();
            }
        });
    }

    // Ensure external links in content have proper attributes and warnings
    function initExternalLinks() {
        const contentArea = document.getElementById('main-content');
        if (!contentArea) return;

        const links = contentArea.querySelectorAll('a[href^="http"]');
        const currentDomain = window.location.hostname;

        links.forEach(link => {
            const linkDomain = new URL(link.href).hostname;

            if (linkDomain !== currentDomain) {
                // Add external link indicator if not already present
                if (!link.querySelector('.klaro-external-link-text')) {
                    const span = document.createElement('span');
                    span.className = 'screen-reader-text klaro-external-link-text';
                    span.textContent = ' (opens in new window)';
                    link.appendChild(span);
                }

                // Ensure proper attributes
                link.setAttribute('target', '_blank');
                link.setAttribute('rel', 'noopener noreferrer');
            }
        });
    }

    // Ensure all images have alt text
    function validateImageAltText() {
        const images = document.querySelectorAll('img');
        
        images.forEach(img => {
            if (!img.hasAttribute('alt')) {

                img.style.border = '5px solid red';
                img.setAttribute('role', 'presentation');
            }
        });
    }

    // Add ARIA live region updates for dynamic content
    function initLiveRegions() {
        // Create a polite live region for non-urgent updates
        const politeRegion = document.createElement('div');
        politeRegion.setAttribute('role', 'status');
        politeRegion.setAttribute('aria-live', 'polite');
        politeRegion.setAttribute('aria-atomic', 'true');
        politeRegion.className = 'screen-reader-text';
        politeRegion.id = 'klaro-polite-announcements';
        document.body.appendChild(politeRegion);

        // Create an assertive live region for urgent updates
        const assertiveRegion = document.createElement('div');
        assertiveRegion.setAttribute('role', 'alert');
        assertiveRegion.setAttribute('aria-live', 'assertive');
        assertiveRegion.setAttribute('aria-atomic', 'true');
        assertiveRegion.className = 'screen-reader-text';
        assertiveRegion.id = 'klaro-urgent-announcements';
        document.body.appendChild(assertiveRegion);
    }

    // Initialize all accessibility features
    function init() {
        // Apply saved settings first
        applySavedSettings();

        // Initialize all controls
        initFontSizeControls();
        initContrastControls();
        initAnimationControls();
        initReducedMotion();
        initFocusManagement();
        initExternalLinks();
        initLiveRegions();

        // Validate images in development
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            validateImageAltText();
        }


    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();

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
        const status = document.getElementById('accessibility-status');
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
        const body = document.body;

        // Apply font size
        if (settings.fontSize === 'large') {
            body.classList.add('large-text');
        } else if (settings.fontSize === 'extra-large') {
            body.classList.add('extra-large-text');
        }

        // Apply contrast
        if (settings.contrast === 'high') {
            body.classList.add('high-contrast');
            updateButtonState('toggle-contrast', true);
        } else if (settings.contrast === 'monochrome') {
            body.classList.add('monochrome');
            updateButtonState('toggle-monochrome', true);
        }

        // Apply animation preference
        if (settings.animations === 'disabled') {
            body.classList.add('reduce-motion');
            updateButtonState('toggle-animations', true);
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
        const increaseBtn = document.getElementById('increase-font');
        const decreaseBtn = document.getElementById('decrease-font');
        const resetBtn = document.getElementById('reset-font');
        const body = document.body;

        if (!increaseBtn || !decreaseBtn || !resetBtn) return;

        increaseBtn.addEventListener('click', () => {
            const settings = getSettings();
            
            body.classList.remove('large-text', 'extra-large-text');
            
            if (settings.fontSize === 'normal') {
                body.classList.add('large-text');
                settings.fontSize = 'large';
                announceChange('Text size increased to large');
            } else if (settings.fontSize === 'large') {
                body.classList.add('extra-large-text');
                settings.fontSize = 'extra-large';
                announceChange('Text size increased to extra large');
            } else {
                announceChange('Text size is already at maximum');
                return;
            }
            
            saveSettings(settings);
        });

        decreaseBtn.addEventListener('click', () => {
            const settings = getSettings();
            
            body.classList.remove('large-text', 'extra-large-text');
            
            if (settings.fontSize === 'extra-large') {
                body.classList.add('large-text');
                settings.fontSize = 'large';
                announceChange('Text size decreased to large');
            } else if (settings.fontSize === 'large') {
                settings.fontSize = 'normal';
                announceChange('Text size decreased to normal');
            } else {
                announceChange('Text size is already at minimum');
                return;
            }
            
            saveSettings(settings);
        });

        resetBtn.addEventListener('click', () => {
            const settings = getSettings();
            body.classList.remove('large-text', 'extra-large-text');
            settings.fontSize = 'normal';
            saveSettings(settings);
            announceChange('Text size reset to normal');
        });
    }

    // High contrast mode
    function initContrastControls() {
        const contrastBtn = document.getElementById('toggle-contrast');
        const monochromeBtn = document.getElementById('toggle-monochrome');
        const body = document.body;

        if (!contrastBtn || !monochromeBtn) return;

        contrastBtn.addEventListener('click', () => {
            const settings = getSettings();
            
            // Remove other contrast modes
            body.classList.remove('monochrome');
            updateButtonState('toggle-monochrome', false);
            
            if (settings.contrast === 'high') {
                body.classList.remove('high-contrast');
                settings.contrast = 'normal';
                updateButtonState('toggle-contrast', false);
                announceChange('High contrast mode disabled');
            } else {
                body.classList.add('high-contrast');
                settings.contrast = 'high';
                updateButtonState('toggle-contrast', true);
                announceChange('High contrast mode enabled');
            }
            
            saveSettings(settings);
        });

        monochromeBtn.addEventListener('click', () => {
            const settings = getSettings();
            
            // Remove other contrast modes
            body.classList.remove('high-contrast');
            updateButtonState('toggle-contrast', false);
            
            if (settings.contrast === 'monochrome') {
                body.classList.remove('monochrome');
                settings.contrast = 'normal';
                updateButtonState('toggle-monochrome', false);
                announceChange('Monochrome mode disabled');
            } else {
                body.classList.add('monochrome');
                settings.contrast = 'monochrome';
                updateButtonState('toggle-monochrome', true);
                announceChange('Monochrome mode enabled');
            }
            
            saveSettings(settings);
        });
    }

    // Animation controls
    function initAnimationControls() {
        const animationBtn = document.getElementById('toggle-animations');
        const body = document.body;

        if (!animationBtn) return;

        animationBtn.addEventListener('click', () => {
            const settings = getSettings();
            
            if (settings.animations === 'disabled') {
                body.classList.remove('reduce-motion');
                settings.animations = 'enabled';
                updateButtonState('toggle-animations', false);
                announceChange('Animations enabled');
            } else {
                body.classList.add('reduce-motion');
                settings.animations = 'disabled';
                updateButtonState('toggle-animations', true);
                announceChange('Animations disabled');
            }
            
            saveSettings(settings);
        });
    }

    // Add reduce-motion class based on system preference
    function initReducedMotion() {
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
        
        if (prefersReducedMotion.matches) {
            document.body.classList.add('reduce-motion');
        }

        // Listen for changes
        prefersReducedMotion.addEventListener('change', (e) => {
            if (e.matches) {
                document.body.classList.add('reduce-motion');
            } else {
                document.body.classList.remove('reduce-motion');
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
                document.body.classList.add('keyboard-nav');
            }
        });

        // Detect mouse usage
        document.addEventListener('mousedown', () => {
            isUsingKeyboard = false;
            document.body.classList.remove('keyboard-nav');
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

    // Ensure external links have proper attributes and warnings
    function initExternalLinks() {
        const links = document.querySelectorAll('a[href^="http"]');
        const currentDomain = window.location.hostname;

        links.forEach(link => {
            const linkDomain = new URL(link.href).hostname;
            
            if (linkDomain !== currentDomain) {
                // Add external link indicator if not already present
                if (!link.querySelector('.external-link-icon')) {
                    const span = document.createElement('span');
                    span.className = 'screen-reader-text';
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
                console.warn('Image missing alt text:', img);
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
        politeRegion.id = 'polite-announcements';
        document.body.appendChild(politeRegion);

        // Create an assertive live region for urgent updates
        const assertiveRegion = document.createElement('div');
        assertiveRegion.setAttribute('role', 'alert');
        assertiveRegion.setAttribute('aria-live', 'assertive');
        assertiveRegion.setAttribute('aria-atomic', 'true');
        assertiveRegion.className = 'screen-reader-text';
        assertiveRegion.id = 'urgent-announcements';
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

        console.log('Klaro accessibility features initialized');
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();

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

    // Accepted values per setting. Anything else in storage (an older or
    // hand-edited object, a value from a future version) falls back to the
    // default for that key instead of leaking into class names or logic.
    // contrast: 'normal' means no visitor choice, follow the Customizer mode
    // (also what older stored settings contain); 'standard' means the
    // visitor switched the site's mode off; 'high', 'monochrome' and 'dark'
    // are visitor-selected modes.
    const klaroAllowedValues = {
        fontSize: ['normal', 'medium', 'large', 'extra-large', 'maximum'],
        contrast: ['normal', 'standard', 'high', 'monochrome', 'dark'],
        // animations: 'enabled' means no visitor choice, follow the operating
        // system (also what older stored settings contain); 'disabled' means
        // the visitor asked for reduced motion; 'allowed' means the visitor
        // wants animations although the system prefers reduced motion.
        animations: ['enabled', 'disabled', 'allowed'],
        colorFilter: ['none', 'protanopia', 'deuteranopia', 'tritanopia'],
        dyslexiaFont: ['disabled', 'enabled'],
        readingSpacing: ['disabled', 'enabled'],
        highlightLinks: ['disabled', 'enabled'],
        bigCursor: ['disabled', 'enabled']
    };

    // The active settings live here. Storage is only a way to remember them
    // between visits: when reading or writing it fails (private mode, blocked
    // site data, a malformed value), the toolbar keeps working from memory.
    let klaroSettingsCache = null;

    function klaroDefaultSettings() {
        const defaults = {};
        Object.keys(klaroAllowedValues).forEach(key => {
            defaults[key] = klaroAllowedValues[key][0];
        });
        return defaults;
    }

    function klaroSanitizeSettings(raw) {
        const settings = klaroDefaultSettings();
        if (raw && typeof raw === 'object') {
            Object.keys(klaroAllowedValues).forEach(key => {
                if (klaroAllowedValues[key].indexOf(raw[key]) !== -1) {
                    settings[key] = raw[key];
                }
            });
        }
        return settings;
    }

    // Read the stored settings once, validated; afterwards return the live
    // in-memory object so every control sees the same state.
    function klaroGetSettings() {
        if (klaroSettingsCache) {
            return klaroSettingsCache;
        }

        let raw = null;
        try {
            const stored = window.localStorage.getItem(STORAGE_KEY);
            raw = stored ? JSON.parse(stored) : null;
        } catch (error) {
            raw = null;
        }

        klaroSettingsCache = klaroSanitizeSettings(raw);
        return klaroSettingsCache;
    }

    // Reading aids: independent on/off toggles
    const klaroReadingAids = [
        {
            key: 'readingSpacing',
            buttonId: 'klaro-toggle-spacing',
            className: 'klaro-reading-spacing',
            label: 'Increased text spacing'
        },
        {
            key: 'highlightLinks',
            buttonId: 'klaro-toggle-links',
            className: 'klaro-highlight-links',
            label: 'Link highlighting'
        },
        {
            key: 'bigCursor',
            buttonId: 'klaro-toggle-cursor',
            className: 'klaro-big-cursor',
            label: 'Large cursor'
        }
    ];

    // Contrast modes: setting value -> body class, toolbar button, announcement name
    const klaroContrastModes = {
        'high': {
            className: 'klaro-high-contrast',
            buttonId: 'klaro-toggle-contrast',
            label: 'High contrast mode'
        },
        'monochrome': {
            className: 'klaro-monochrome',
            buttonId: 'klaro-toggle-monochrome',
            label: 'Monochrome mode'
        },
        'dark': {
            className: 'klaro-dark',
            buttonId: 'klaro-toggle-dark',
            label: 'Dark mode'
        }
    };

    // The contrast mode the Customizer put on <body> before any visitor
    // preference is applied, or null for the standard palette. Read once at
    // start-up, before the classes are touched.
    let klaroSiteContrast = null;

    function klaroDetectSiteContrast() {
        const body = document.body;
        return Object.keys(klaroContrastModes).find(mode =>
            body.classList.contains(klaroContrastModes[mode].className)) || null;
    }

    // Resolve the one mode that should be active: the visitor's own choice,
    // or the site default when the visitor has not chosen, or none when the
    // visitor switched the site's mode off. Returns a mode key or null.
    function klaroEffectiveContrast(settings) {
        if (klaroContrastModes[settings.contrast]) {
            return settings.contrast;
        }
        if (settings.contrast === 'standard') {
            return null;
        }
        return klaroSiteContrast;
    }

    // Put exactly the effective mode class on <body> and mark its button as
    // pressed, so the announced state always matches what is shown.
    function klaroApplyContrast(settings) {
        const body = document.body;
        const effective = klaroEffectiveContrast(settings);

        Object.keys(klaroContrastModes).forEach(mode => {
            const config = klaroContrastModes[mode];
            body.classList.toggle(config.className, mode === effective);
            klaroUpdateButtonState(config.buttonId, mode === effective);
        });

        return effective;
    }

    // Color vision filters: setting value -> body class, toolbar button, announcement name
    const klaroColorFilters = {
        'protanopia': {
            className: 'klaro-filter-protanopia',
            buttonId: 'klaro-filter-protanopia',
            label: 'Red-blind color filter'
        },
        'deuteranopia': {
            className: 'klaro-filter-deuteranopia',
            buttonId: 'klaro-filter-deuteranopia',
            label: 'Green-blind color filter'
        },
        'tritanopia': {
            className: 'klaro-filter-tritanopia',
            buttonId: 'klaro-filter-tritanopia',
            label: 'Blue-blind color filter'
        }
    };

    // Remember the settings for the next visit. Persistence is optional:
    // a failed write leaves the in-memory settings, and the page, as they are.
    // Saving is silent; the control that changed announces its own result.
    function klaroSaveSettings(settings) {
        klaroSettingsCache = settings;
        try {
            window.localStorage.setItem(STORAGE_KEY, JSON.stringify(settings));
        } catch (error) {
            // Storage unavailable or full; the choice still applies to this page.
        }
    }

    // Translated announcement strings come from PHP (klaroSettings.messages);
    // the English fallbacks keep the toolbar talking if they are missing.
    function klaroMessages() {
        return (typeof klaroSettings !== 'undefined' && klaroSettings.messages) ? klaroSettings.messages : {};
    }

    // Fill a message template: %1$s, %2$s or plain %s placeholders in order.
    function klaroMsg(key, fallback) {
        const args = Array.prototype.slice.call(arguments, 2);
        let template = klaroMessages()[key] || fallback;
        args.forEach((value, index) => {
            template = template.replace(new RegExp('%' + (index + 1) + '\\$s', 'g'), value);
        });
        args.forEach(value => {
            template = template.replace('%s', value);
        });
        return template;
    }

    // Translated name of a toolbar option (mode, filter, aid).
    function klaroName(key, fallback) {
        const names = klaroMessages().names || {};
        return names[key] || fallback;
    }

    // Announce changes to screen readers. A new message cancels the timer of
    // the previous one, so a quick second action cannot wipe the latest text.
    let klaroAnnounceTimer = null;

    function klaroAnnounceChange(message) {
        const status = document.getElementById('klaro-accessibility-status');
        if (!status) {
            return;
        }
        if (klaroAnnounceTimer) {
            clearTimeout(klaroAnnounceTimer);
        }
        status.textContent = message;
        klaroAnnounceTimer = setTimeout(() => {
            status.textContent = '';
            klaroAnnounceTimer = null;
        }, 3000);
    }

    // Reduced motion: the visitor's choice wins, otherwise the operating
    // system preference decides. Returns true when motion should be reduced.
    const klaroMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

    function klaroEffectiveReducedMotion(settings) {
        if (settings.animations === 'disabled') {
            return true;
        }
        if (settings.animations === 'allowed') {
            return false;
        }
        return klaroMotionQuery.matches;
    }

    function klaroApplyReducedMotion(settings) {
        const reduced = klaroEffectiveReducedMotion(settings);
        document.documentElement.classList.toggle('klaro-reduce-motion', reduced);
        klaroUpdateButtonState('klaro-toggle-animations', reduced);
        return reduced;
    }

    // Apply saved settings on page load
    function klaroApplySavedSettings() {
        const settings = klaroGetSettings();
        const html = document.documentElement;
        const body = document.body;

        // Apply font size to html element (root for rem units)
        klaroApplyFontSize(settings.fontSize);

        // Apply contrast to body: resolve the visitor preference against the
        // Customizer default instead of stacking a second mode class on it.
        klaroSiteContrast = klaroDetectSiteContrast();
        klaroApplyContrast(settings);

        // Apply color vision filter to body
        if (klaroColorFilters[settings.colorFilter]) {
            body.classList.add(klaroColorFilters[settings.colorFilter].className);
            klaroUpdateButtonState(klaroColorFilters[settings.colorFilter].buttonId, true);
        }

        // Apply dyslexia-friendly font to body
        if (settings.dyslexiaFont === 'enabled') {
            body.classList.add('klaro-dyslexia-font');
            klaroUpdateButtonState('klaro-toggle-dyslexia', true);
        }

        // Apply reading aids to body
        klaroReadingAids.forEach(aid => {
            if (settings[aid.key] === 'enabled') {
                body.classList.add(aid.className);
                klaroUpdateButtonState(aid.buttonId, true);
            }
        });

        // Apply the motion preference, resolved against the system setting
        klaroApplyReducedMotion(settings);
    }

    // Update button pressed state
    function klaroUpdateButtonState(buttonId, isPressed) {
        const button = document.getElementById(buttonId);
        if (button) {
            button.setAttribute('aria-pressed', isPressed ? 'true' : 'false');
        }
    }

    // Text size levels in order; each level's class sets the root font size.
    const klaroFontSizeLevels = ['normal', 'medium', 'large', 'extra-large', 'maximum'];
    const klaroFontSizeClasses = {
        medium: 'klaro-medium-text',
        large: 'klaro-large-text',
        'extra-large': 'klaro-extra-large-text',
        maximum: 'klaro-maximum-text'
    };

    function klaroApplyFontSize(level) {
        const html = document.documentElement;
        Object.keys(klaroFontSizeClasses).forEach(key => {
            html.classList.toggle(klaroFontSizeClasses[key], key === level);
        });
    }

    // The size actually in effect, from the rendered root font size, so the
    // announcement reflects the Customizer base and any zoom rather than a
    // fixed table.
    function klaroCurrentFontSizePx() {
        return Math.round(parseFloat(window.getComputedStyle(document.documentElement).fontSize));
    }

    function klaroFontSizeName(level) {
        const sizes = klaroMessages().sizes || {};
        return sizes[level] || level.replace('-', ' ');
    }

    // Font size controls
    function klaroInitFontSizeControls() {
        const increaseBtn = document.getElementById('klaro-increase-font');
        const decreaseBtn = document.getElementById('klaro-decrease-font');
        const resetBtn = document.getElementById('klaro-reset-font');

        if (!increaseBtn || !decreaseBtn || !resetBtn) return;

        function klaroStep(direction) {
            const settings = klaroGetSettings();
            let index = klaroFontSizeLevels.indexOf(settings.fontSize);
            if (index === -1) {
                index = 0;
            }
            const next = index + direction;

            if (next >= klaroFontSizeLevels.length) {
                klaroAnnounceChange(klaroMsg('textSizeMax', 'Text size is already at maximum'));
                return;
            }
            if (next < 0) {
                klaroAnnounceChange(klaroMsg('textSizeMin', 'Text size is already at minimum'));
                return;
            }

            settings.fontSize = klaroFontSizeLevels[next];
            klaroApplyFontSize(settings.fontSize);
            klaroSaveSettings(settings);
            klaroAnnounceChange(klaroMsg('textSize', 'Text size: %1$s (%2$spx)',
                klaroFontSizeName(settings.fontSize), klaroCurrentFontSizePx()));
        }

        increaseBtn.addEventListener('click', () => klaroStep(1));
        decreaseBtn.addEventListener('click', () => klaroStep(-1));

        resetBtn.addEventListener('click', () => {
            const settings = klaroGetSettings();
            settings.fontSize = 'normal';
            klaroApplyFontSize('normal');
            klaroSaveSettings(settings);
            klaroAnnounceChange(klaroMsg('textSizeReset', 'Text size reset to %1$s (%2$spx)',
                klaroFontSizeName('normal'), klaroCurrentFontSizePx()));
        });
    }

    // Contrast modes (high contrast, monochrome, dark) - mutually exclusive toggles
    function klaroInitContrastControls() {
        Object.keys(klaroContrastModes).forEach(mode => {
            const config = klaroContrastModes[mode];
            const button = document.getElementById(config.buttonId);
            if (!button) return;

            button.addEventListener('click', () => {
                const settings = klaroGetSettings();

                if (klaroEffectiveContrast(settings) === mode) {
                    // Switching off the site's own default has to be stored
                    // as an explicit choice, otherwise the next page load
                    // would follow the default again. Switching off a mode
                    // the visitor picked just drops the preference.
                    settings.contrast = (klaroSiteContrast === mode) ? 'standard' : 'normal';
                    klaroApplyContrast(settings);
                    klaroAnnounceChange(klaroMsg('disabled', '%s disabled', klaroName(mode, config.label)));
                } else {
                    settings.contrast = mode;
                    klaroApplyContrast(settings);
                    klaroAnnounceChange(klaroMsg('enabled', '%s enabled', klaroName(mode, config.label)));
                }

                klaroSaveSettings(settings);
            });
        });
    }

    // Color vision filters (daltonization) - mutually exclusive toggles
    function klaroInitColorFilterControls() {
        const body = document.body;

        Object.keys(klaroColorFilters).forEach(filter => {
            const config = klaroColorFilters[filter];
            const button = document.getElementById(config.buttonId);
            if (!button) return;

            button.addEventListener('click', () => {
                const settings = klaroGetSettings();

                // Remove the other color filters
                Object.keys(klaroColorFilters).forEach(other => {
                    if (other !== filter) {
                        body.classList.remove(klaroColorFilters[other].className);
                        klaroUpdateButtonState(klaroColorFilters[other].buttonId, false);
                    }
                });

                if (settings.colorFilter === filter) {
                    body.classList.remove(config.className);
                    settings.colorFilter = 'none';
                    klaroUpdateButtonState(config.buttonId, false);
                    klaroAnnounceChange(klaroMsg('disabled', '%s disabled', klaroName(filter, config.label)));
                } else {
                    body.classList.add(config.className);
                    settings.colorFilter = filter;
                    klaroUpdateButtonState(config.buttonId, true);
                    klaroAnnounceChange(klaroMsg('enabled', '%s enabled', klaroName(filter, config.label)));
                }

                klaroSaveSettings(settings);
            });
        });
    }

    // Animation controls
    function klaroInitAnimationControls() {
        const animationBtn = document.getElementById('klaro-toggle-animations');

        if (!animationBtn) return;

        animationBtn.addEventListener('click', () => {
            const settings = klaroGetSettings();

            if (klaroEffectiveReducedMotion(settings)) {
                // Switching motion back on while the system prefers reduced
                // motion has to be an explicit choice, otherwise the system
                // setting would reduce it again on the next page.
                settings.animations = klaroMotionQuery.matches ? 'allowed' : 'enabled';
                klaroApplyReducedMotion(settings);
                klaroAnnounceChange(klaroMsg('enabled', '%s enabled', klaroName('animations', 'Animations')));
            } else {
                settings.animations = 'disabled';
                klaroApplyReducedMotion(settings);
                klaroAnnounceChange(klaroMsg('disabled', '%s disabled', klaroName('animations', 'Animations')));
            }

            klaroSaveSettings(settings);
        });
    }

    // Dyslexia-friendly font toggle
    function klaroInitDyslexiaControls() {
        const dyslexiaBtn = document.getElementById('klaro-toggle-dyslexia');
        const body = document.body;

        if (!dyslexiaBtn) return;

        dyslexiaBtn.addEventListener('click', () => {
            const settings = klaroGetSettings();

            if (settings.dyslexiaFont === 'enabled') {
                body.classList.remove('klaro-dyslexia-font');
                settings.dyslexiaFont = 'disabled';
                klaroUpdateButtonState('klaro-toggle-dyslexia', false);
                klaroAnnounceChange(klaroMsg('disabled', '%s disabled', klaroName('dyslexiaFont', 'Dyslexia-friendly font')));
            } else {
                body.classList.add('klaro-dyslexia-font');
                settings.dyslexiaFont = 'enabled';
                klaroUpdateButtonState('klaro-toggle-dyslexia', true);
                klaroAnnounceChange(klaroMsg('enabled', '%s enabled', klaroName('dyslexiaFont', 'Dyslexia-friendly font')));
            }

            klaroSaveSettings(settings);
        });
    }

    // Reading aid toggles (spacing, link highlighting, large cursor)
    function klaroInitReadingAidControls() {
        const body = document.body;

        klaroReadingAids.forEach(aid => {
            const button = document.getElementById(aid.buttonId);
            if (!button) return;

            button.addEventListener('click', () => {
                const settings = klaroGetSettings();

                if (settings[aid.key] === 'enabled') {
                    body.classList.remove(aid.className);
                    settings[aid.key] = 'disabled';
                    klaroUpdateButtonState(aid.buttonId, false);
                    klaroAnnounceChange(klaroMsg('disabled', '%s disabled', klaroName(aid.key, aid.label)));
                } else {
                    body.classList.add(aid.className);
                    settings[aid.key] = 'enabled';
                    klaroUpdateButtonState(aid.buttonId, true);
                    klaroAnnounceChange(klaroMsg('enabled', '%s enabled', klaroName(aid.key, aid.label)));
                }

                klaroSaveSettings(settings);
            });
        });
    }

    // Follow operating system changes during the visit, still resolved
    // against the visitor's own choice, so an explicit preference survives
    // the system flipping back.
    function klaroInitReducedMotion() {
        klaroMotionQuery.addEventListener('change', () => {
            klaroApplyReducedMotion(klaroGetSettings());
        });
    }

    // Enhanced focus visibility for keyboard navigation
    function klaroInitFocusManagement() {
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

    // Accessibility toolbar popup: close with Escape and on outside click
    function klaroInitAccessibilityMenu() {
        const details = document.querySelector('.klaro-accessibility-menu');
        if (!details) return;

        const summary = details.querySelector('summary');

        // Keep aria-expanded on the toggle in sync so the open/closed state is
        // announced dynamically by assistive technology.
        function klaroSyncExpanded() {
            if (summary) {
                summary.setAttribute('aria-expanded', details.open ? 'true' : 'false');
            }
        }
        klaroSyncExpanded();
        details.addEventListener('toggle', klaroSyncExpanded);

        function klaroCloseMenu(restoreFocus) {
            if (!details.open) return;
            details.open = false;
            if (restoreFocus && summary) {
                summary.focus();
            }
        }

        // Escape closes the popup and returns focus to the toggle.
        details.addEventListener('keydown', (e) => {
            if ((e.key === 'Escape' || e.key === 'Esc') && details.open) {
                klaroCloseMenu(true);
                e.preventDefault();
            }
        });

        // Clicking outside the popup closes it.
        document.addEventListener('click', (e) => {
            if (details.open && !details.contains(e.target)) {
                klaroCloseMenu(false);
            }
        });

        // The admin bar's Accessibility item opens this toolbar and moves
        // focus into it. Its href points at the toolbar for the no-script case.
        const adminBarLink = document.querySelector('#wp-admin-bar-klaro-accessibility > a');
        if (adminBarLink) {
            adminBarLink.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                details.open = true;
                details.scrollIntoView({ block: 'nearest' });
                const first = details.querySelector('.klaro-accessibility-button');
                if (first) {
                    first.focus();
                } else if (summary) {
                    summary.focus();
                }
            });
        }
    }

    // Annotate author-set new-window links with a visual indicator and a
    // screen reader warning. The theme never forces target="_blank" itself,
    // opening new windows without a user request fails WCAG 3.2.5.
    function klaroInitExternalLinks() {
        const contentArea = document.getElementById('main-content');
        if (!contentArea) return;

        const links = contentArea.querySelectorAll('a[target="_blank"]');
        const newWindowText = (typeof klaroSettings !== 'undefined' && klaroSettings.newWindow) ?
            klaroSettings.newWindow : '(opens in new window)';

        links.forEach(link => {
            // Security hardening for new-window links. relList.add keeps any
            // author-set tokens (nofollow, sponsored, ugc) instead of replacing them.
            link.relList.add('noopener', 'noreferrer');

            if (!link.querySelector('.klaro-external-link-text')) {
                const srSpan = document.createElement('span');
                srSpan.className = 'screen-reader-text klaro-external-link-text';
                srSpan.textContent = ' ' + newWindowText;
                link.appendChild(srSpan);

                const visualSpan = document.createElement('span');
                visualSpan.className = 'klaro-new-window-icon';
                visualSpan.setAttribute('aria-hidden', 'true');
                visualSpan.textContent = ' ↗';
                link.appendChild(visualSpan);
            }
        });
    }

    // Development aid: highlight images missing an alt attribute
    function klaroValidateImageAltText() {
        const images = document.querySelectorAll('img');

        images.forEach(img => {
            if (!img.hasAttribute('alt')) {
                img.style.border = '5px solid red';
            }
        });
    }

    // Initialize all accessibility features
    function klaroInit() {
        // Apply saved settings first
        klaroApplySavedSettings();

        // Initialize all controls
        klaroInitFontSizeControls();
        klaroInitContrastControls();
        klaroInitColorFilterControls();
        klaroInitDyslexiaControls();
        klaroInitReadingAidControls();
        klaroInitAnimationControls();
        klaroInitReducedMotion();
        klaroInitFocusManagement();
        klaroInitExternalLinks();
        klaroInitAccessibilityMenu();

        // Validate images in development
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            klaroValidateImageAltText();
        }


    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', klaroInit);
    } else {
        klaroInit();
    }

})();

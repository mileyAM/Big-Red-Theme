/**
 * MILEYM3DIA Theme - Main JavaScript
 * Handles navigation, animations, and interactive elements
 */

(function() {
    'use strict';

    // DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        
        // ========================================
        // SCROLL PROGRESS BAR
        // ========================================
        const scrollProgress = document.getElementById('scrollProgress');
        if (scrollProgress) {
            window.addEventListener('scroll', function() {
                const scrollTop = window.scrollY;
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                const scrollPercent = (scrollTop / docHeight) * 100;
                scrollProgress.style.width = scrollPercent + '%';
            });
        }

        // ========================================
        // MOBILE MENU DRAWER
        // ========================================
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenuClose = document.getElementById('mobileMenuClose');
        const navMobile = document.getElementById('navMobile');
        const mobileBackdrop = navMobile ? navMobile.querySelector('.mobile-nav-backdrop') : null;
        const body = document.body;
        
        function openMobileMenu() {
            if (!navMobile) return;
            navMobile.classList.add('active');
            navMobile.setAttribute('aria-hidden', 'false');
            body.style.overflow = 'hidden';
            body.setAttribute('data-menu-open', 'true');
            if (mobileMenuToggle) {
                mobileMenuToggle.setAttribute('aria-expanded', 'true');
            }
            if (mobileMenuClose) {
                mobileMenuClose.focus();
            }
        }
        
        function closeMobileMenu() {
            if (!navMobile) return;
            navMobile.classList.remove('active');
            navMobile.setAttribute('aria-hidden', 'true');
            body.style.overflow = '';
            body.removeAttribute('data-menu-open');
            if (mobileMenuToggle) {
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                mobileMenuToggle.focus();
            }
        }
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                if (navMobile && navMobile.classList.contains('active')) {
                    closeMobileMenu();
                } else {
                    openMobileMenu();
                }
            });
            mobileMenuToggle.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    openMobileMenu();
                }
            });
        }
        
        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', function(e) {
                e.preventDefault();
                closeMobileMenu();
            });
        }

        if (mobileBackdrop) {
            mobileBackdrop.addEventListener('click', closeMobileMenu);
        }

        if (navMobile) {
            // Close drawer when any link inside is clicked
            navMobile.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function() {
                    closeMobileMenu();
                });
            });
            
            // Add numbering attributes to mobile menu items if not already provided by Walker
            const mobileNavLinks = navMobile.querySelectorAll('.mobile-nav-menu a');
            mobileNavLinks.forEach(function(link, index) {
                if (!link.getAttribute('data-number')) {
                    const number = (index + 1).toString().padStart(2, '0');
                    link.setAttribute('data-number', number);
                }
            });

            // Mobile submenu accordion toggles
            navMobile.querySelectorAll('.mobile-sub-toggle').forEach(function(toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleBtn.classList.toggle('is-active');
                    const parent = toggleBtn.closest('.mobile-nav-has-children') || toggleBtn.closest('.mobile-nav-item');
                    if (parent) {
                        const subMenu = parent.querySelector('.mobile-sub-menu, .sub-menu');
                        if (subMenu) {
                            const isHidden = window.getComputedStyle(subMenu).display === 'none';
                            subMenu.style.display = isHidden ? 'flex' : 'none';
                        }
                    }
                });
            });
        }
        
        // Trap focus & Escape key inside mobile drawer
        document.addEventListener('keydown', function(e) {
            if (!navMobile || !navMobile.classList.contains('active')) return;

            if (e.key === 'Escape') {
                e.preventDefault();
                closeMobileMenu();
                return;
            }

            if (e.key === 'Tab') {
                const focusable = navMobile.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                if (focusable.length === 0) return;
                const firstEl = focusable[0];
                const lastEl = focusable[focusable.length - 1];

                if (e.shiftKey) {
                    if (document.activeElement === firstEl) {
                        e.preventDefault();
                        lastEl.focus();
                    }
                } else {
                    if (document.activeElement === lastEl) {
                        e.preventDefault();
                        firstEl.focus();
                    }
                }
            }
        });

        // ========================================
        // HEADER SCROLL EFFECT
        // ========================================
        const siteHeader = document.getElementById('siteHeader');
        if (siteHeader) {
            let lastScroll = 0;
            window.addEventListener('scroll', function() {
                const currentScroll = window.scrollY;
                if (currentScroll > 40) {
                    siteHeader.classList.add('scrolled');
                } else {
                    siteHeader.classList.remove('scrolled');
                }
                lastScroll = currentScroll;
            }, { passive: true });
        }

        // ========================================
        // INTERSECTION OBSERVER FOR ANIMATIONS
        // ========================================
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        
        if (!prefersReducedMotion && 'IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -40px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const animateElements = document.querySelectorAll(
                '.work-card, .discipline-row, .resource-card, .dispatch-card, ' +
                '.manifesto-grid, .contact-banner, .section-header, .portfolio-item, ' +
                '.service-item, .blog-card, .capability-item, .resource-item, .work-item'
            );
            animateElements.forEach(function(el) {
                el.classList.add('animate-on-scroll');
                observer.observe(el);
            });
        }

        // ========================================
        // SMOOTH SCROLL FOR ANCHOR LINKS (HEADER-AWARE)
        // ========================================
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href && href !== '#' && href.length > 1) {
                    try {
                        const target = document.querySelector(href);
                        if (target) {
                            e.preventDefault();
                            const headerEl = document.getElementById('siteHeader');
                            const headerHeight = headerEl ? headerEl.offsetHeight : 80;
                            const elementTop = target.getBoundingClientRect().top;
                            const offsetPosition = elementTop + window.pageYOffset - headerHeight + 2;

                            window.scrollTo({
                                top: offsetPosition,
                                behavior: prefersReducedMotion ? 'auto' : 'smooth'
                            });

                            if (window.history && window.history.pushState) {
                                window.history.pushState(null, null, href);
                            }
                        }
                    } catch (err) {
                        // Pass-through if selector is not standard
                    }
                }
            });
        });

        // ========================================
        // SCROLLSPY / NAVIGATION ACTIVE HIGHLIGHT
        // ========================================
        const sections = document.querySelectorAll('section[id]');
        const desktopNavLinks = document.querySelectorAll('.main-navigation a[href^="#"]');
        const drawerNavLinks = document.querySelectorAll('.mobile-nav-menu a[href^="#"]');

        if (sections.length > 0 && (desktopNavLinks.length > 0 || drawerNavLinks.length > 0)) {
            window.addEventListener('scroll', function() {
                const scrollPos = window.scrollY + 140;
                let currentId = '';

                sections.forEach(function(section) {
                    const top = section.offsetTop;
                    const height = section.offsetHeight;
                    if (scrollPos >= top && scrollPos < top + height) {
                        currentId = section.getAttribute('id');
                    }
                });

                if (currentId) {
                    const updateActiveLinks = function(links) {
                        links.forEach(function(link) {
                            const href = link.getAttribute('href');
                            if (href === '#' + currentId) {
                                link.classList.add('active');
                            } else {
                                link.classList.remove('active');
                            }
                        });
                    };
                    updateActiveLinks(desktopNavLinks);
                    updateActiveLinks(drawerNavLinks);
                }
            }, { passive: true });
        }

        // ========================================
        // DISCIPLINES & CAPABILITIES HOVER ACCENT
        // ========================================
        const interactiveRows = document.querySelectorAll('.discipline-row, .capability-item');
        interactiveRows.forEach(function(item) {
            item.addEventListener('mouseenter', function() {
                interactiveRows.forEach(function(other) {
                    if (other !== item) {
                        other.style.opacity = '0.35';
                    }
                });
            });
            
            item.addEventListener('mouseleave', function() {
                interactiveRows.forEach(function(other) {
                    other.style.opacity = '1';
                });
            });
        });

        // ========================================
        // HERO AMBIENT DRIFT (PARALLAX)
        // ========================================
        const ambientLayers = document.querySelectorAll('.hero-grid-ambient, .hero-glow, .hero-accent-line');
        if (ambientLayers.length > 0 && !prefersReducedMotion) {
            window.addEventListener('scroll', function() {
                const scrolled = window.scrollY;
                const heroHeight = window.innerHeight;
                if (scrolled < heroHeight) {
                    ambientLayers.forEach(function(layer, idx) {
                        const speed = 0.08 * (idx + 1);
                        layer.style.transform = 'translate3d(0, ' + (scrolled * speed) + 'px, 0)';
                    });
                }
            }, { passive: true });
        }

        // ========================================
        // MAGNETIC BUTTON ACCENT (FINE POINTERS ONLY)
        // ========================================
        const isFinePointer = window.matchMedia('(pointer: fine)').matches;
        if (isFinePointer && !prefersReducedMotion) {
            const magneticButtons = document.querySelectorAll('.btn-studio-cta, .hero-actions .btn, .contact-action-btn, .text-link-arrow');
            magneticButtons.forEach(function(button) {
                button.addEventListener('mousemove', function(e) {
                    const rect = button.getBoundingClientRect();
                    const x = e.clientX - rect.left - rect.width / 2;
                    const y = e.clientY - rect.top - rect.height / 2;
                    button.style.transform = 'translate3d(' + (x * 0.1) + 'px, ' + (y * 0.1) + 'px, 0)';
                });
                
                button.addEventListener('mouseleave', function() {
                    button.style.transform = '';
                });
            });
        }

        // ========================================
        // FORM VALIDATION ENHANCEMENT
        // ========================================
        const contactForm = document.querySelector('form.contact-form, .contact-form form, form#m3BookingForm');
        if (contactForm) {
            const inputs = contactForm.querySelectorAll('input[type="email"], input[type="text"], textarea');
            inputs.forEach(function(input) {
                input.addEventListener('blur', function() {
                    if (this.validity.valid) {
                        this.classList.add('valid');
                        this.classList.remove('invalid');
                    } else if (this.value !== '') {
                        this.classList.add('invalid');
                        this.classList.remove('valid');
                    }
                });
            });
        }

        // ========================================
        // REUSABLE MODAL / POPUP CONTROLLER
        // ========================================
        const modal = document.getElementById('m3Modal');
        const modalTriggers = document.querySelectorAll('[data-m3-modal], [data-m3-modal-target]');
        const modalClosers = document.querySelectorAll('[data-m3-modal-close]');

        function openModal(targetModal) {
            const m = targetModal || modal;
            if (!m) return;
            m.classList.add('active');
            m.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            const firstInput = m.querySelector('input:not([disabled]), button:not([disabled])');
            if (firstInput) firstInput.focus();
        }

        function closeModal(targetModal) {
            const m = targetModal || modal;
            if (!m) return;
            m.classList.remove('active');
            m.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        modalTriggers.forEach(function(trigger) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = trigger.getAttribute('data-m3-modal-target') || trigger.getAttribute('href');
                const target = (targetId && targetId.startsWith('#')) ? document.querySelector(targetId) : modal;
                openModal(target);
            });
        });

        modalClosers.forEach(function(closer) {
            closer.addEventListener('click', function(e) {
                e.preventDefault();
                const m = closer.closest('.m3-modal') || modal;
                closeModal(m);
            });
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModals = document.querySelectorAll('.m3-modal.active');
                openModals.forEach(function(m) {
                    closeModal(m);
                });
            }
        });

        // Add loaded class to body
        document.body.classList.add('loaded');

    });

})();

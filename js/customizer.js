/**
 * MILEYM3DIA Theme Customizer Preview JS
 * Matching live DOM selectors in front-page.php, header.php, and subpages.
 */

(function($) {
    'use strict';

    // Site title & brand wordmark
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            $('.site-title a, .brand-logo-text').text(to);
        });
    });

    // Site description / tagline
    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            $('.site-description, .brand-tagline').text(to);
        });
    });

    // Hero eyebrow
    wp.customize('mileym3dia_hero_eyebrow', function(value) {
        value.bind(function(to) {
            $('.hero-welcome-badge .welcome-text, .hero-eyebrow').text(to);
        });
    });

    // Hero headline 1
    wp.customize('mileym3dia_hero_headline_1', function(value) {
        value.bind(function(to) {
            $('.hero-oversized-headline .hero-line:nth-child(1), .hero-headline-1').text(to);
        });
    });

    // Hero headline 2
    wp.customize('mileym3dia_hero_headline_2', function(value) {
        value.bind(function(to) {
            $('.hero-oversized-headline .hero-line:nth-child(2), .hero-headline-2').text(to);
        });
    });

    // Hero headline 3
    wp.customize('mileym3dia_hero_headline_3', function(value) {
        value.bind(function(to) {
            $('.hero-oversized-headline .hero-line:nth-child(3), .hero-headline-3').text(to);
        });
    });

    // Hero disciplines strip
    wp.customize('mileym3dia_hero_disciplines', function(value) {
        value.bind(function(to) {
            $('.hero-disciplines-tagline').text(to);
        });
    });

    // Hero description
    wp.customize('mileym3dia_hero_description', function(value) {
        value.bind(function(to) {
            $('.hero-lead-description, .hero-description').text(to);
        });
    });

})(jQuery);

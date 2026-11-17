<?php
/**
 * Header Template
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

$brand_prefix  = get_theme_mod('mileym3dia_brand_prefix', 'MILEYM');
$brand_accent  = get_theme_mod('mileym3dia_brand_accent_char', '3');
$brand_suffix  = get_theme_mod('mileym3dia_brand_suffix', 'DIA');
$brand_tagline = get_theme_mod('mileym3dia_brand_tagline', 'CREATIVE MEDIA AGENCY');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'mileym3dia'); ?></a>

    <header id="siteHeader" class="site-header <?php echo get_theme_mod('mileym3dia_sticky_header', true) ? 'is-sticky header-sticky sticky' : 'header-static'; ?>" role="banner">
        <div class="header-container">
            <div class="header-left">
                <?php if (has_custom_logo()) : ?>
                    <div class="site-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <div class="site-brand">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-link" rel="home">
                            <span class="brand-wordmark"><?php echo esc_html($brand_prefix); ?><span class="brand-accent-3"><?php echo esc_html($brand_accent); ?></span><?php echo esc_html($brand_suffix); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <nav id="siteNavigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'mileym3dia'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'depth'          => 2,
                    'walker'         => new Mileym3dia_Walker_Nav_Menu(),
                    'fallback_cb'    => 'mileym3dia_default_nav_menu',
                ));
                ?>
            </nav>

            <div class="header-right">
                <?php if (is_active_sidebar('header-1')) : ?>
                    <div class="header-widgets">
                        <?php dynamic_sidebar('header-1'); ?>
                    </div>
                <?php endif; ?>

                <?php
                $cta_text = get_theme_mod('mileym3dia_header_cta_text', __('START A PROJECT', 'mileym3dia'));
                $cta_url  = get_theme_mod('mileym3dia_header_cta_url');
                if (empty($cta_url) || '/contact/' === $cta_url || '#' === $cta_url) {
                    $cta_url = mileym3dia_get_page_url('contact');
                }
                if ($cta_text && $cta_url) :
                ?>
                    <a href="<?php echo esc_url($cta_url); ?>" class="btn btn--header-cta header-cta">
                        <span class="btn-text"><?php echo esc_html($cta_text); ?></span>
                    </a>
                <?php endif; ?>

                <button
                    id="mobileMenuToggle"
                    class="mobile-menu-toggle"
                    aria-expanded="false"
                    aria-controls="navMobile"
                    aria-label="<?php esc_attr_e('Open navigation menu', 'mileym3dia'); ?>"
                >
                    <span class="toggle-text">MENU</span>
                    <span class="toggle-box">
                        <span class="toggle-bar toggle-bar--1"></span>
                        <span class="toggle-bar toggle-bar--2"></span>
                    </span>
                </button>
            </div>
        </div>
    </header>

    <div id="navMobile" class="mobile-navigation" aria-hidden="true" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Mobile Menu', 'mileym3dia'); ?>">
        <div class="mobile-nav-backdrop"></div>
        <div class="mobile-nav-inner">
            <div class="mobile-nav-header">
                <div class="mobile-nav-brand">
                    <span class="brand-wordmark"><?php echo esc_html($brand_prefix); ?><span class="brand-accent-3"><?php echo esc_html($brand_accent); ?></span><?php echo esc_html($brand_suffix); ?></span>
                    <span class="brand-badge"><span class="brand-status-dot"></span><?php echo esc_html($brand_tagline); ?></span>
                </div>
                <button
                    id="mobileMenuClose"
                    class="mobile-menu-close"
                    aria-label="<?php esc_attr_e('Close menu', 'mileym3dia'); ?>"
                >
                    <span class="close-text">CLOSE</span>
                    <span class="close-icon">&times;</span>
                </button>
            </div>

            <div class="mobile-nav-body">
                <span class="mobile-nav-eyebrow">NAVIGATION</span>
                <?php
                $mobile_menu_location = has_nav_menu('mobile') ? 'mobile' : (has_nav_menu('primary') ? 'primary' : '');
                if ($mobile_menu_location) {
                    wp_nav_menu(array(
                        'theme_location' => $mobile_menu_location,
                        'menu_class'     => 'mobile-nav-menu',
                        'container'      => false,
                        'depth'          => 2,
                        'walker'         => new Mileym3dia_Walker_Nav_Menu(),
                        'fallback_cb'    => 'mileym3dia_default_mobile_nav_menu',
                    ));
                } else {
                    mileym3dia_default_mobile_nav_menu();
                }
                ?>

                <?php if ($cta_text && $cta_url) : ?>
                    <div class="mobile-nav-cta">
                        <a href="<?php echo esc_url($cta_url); ?>" class="btn btn--primary mobile-cta-btn">
                            <span class="btn-text"><?php echo esc_html($cta_text); ?></span>
                            <span class="cta-arrow">↗</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mobile-nav-footer">
                <div class="mobile-meta">
                    <span class="meta-label">DIRECT INQUIRIES</span>
                    <?php $mobile_email = get_theme_mod('mileym3dia_contact_email', 'hello@mileym3dia.com'); ?>
                    <a href="mailto:<?php echo esc_attr($mobile_email); ?>" class="meta-link"><?php echo esc_html($mobile_email); ?></a>
                </div>
                <?php $mobile_loc = get_theme_mod('mileym3dia_contact_location', 'ORLANDO, FL · AVAILABLE WORLDWIDE'); ?>
                <?php if (!empty($mobile_loc)) : ?>
                    <div class="mobile-meta">
                        <span class="meta-label">STUDIO LOCATION</span>
                        <span class="meta-text"><?php echo esc_html($mobile_loc); ?></span>
                    </div>
                <?php endif; ?>
                <?php if (has_nav_menu('social')) : ?>
                    <div class="mobile-social">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'social',
                            'menu_class'     => 'social-links',
                            'container'      => false,
                            'link_before'    => '<span class="screen-reader-text">',
                            'link_after'     => '</span>',
                        ));
                        ?>
                    </div>
                <?php else : ?>
                    <div class="mobile-social-static">
                        <?php mileym3dia_social_links('mobile-social-links'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

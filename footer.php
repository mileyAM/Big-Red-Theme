<?php
/**
 * Footer Template
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
$footer_desc   = get_theme_mod('mileym3dia_footer_description', 'Full-service creative media agency specializing in video production, photography, branding, web design, and music/audio production.');
?>

    <footer id="siteFooter" class="site-footer" role="contentinfo">
        <div class="footer-container">
            <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) : ?>
                <div class="footer-widgets">
                    <?php for ($i = 1; $i <= 4; $i++) : ?>
                        <?php if (is_active_sidebar('footer-' . $i)) : ?>
                            <div class="footer-widget-area footer-<?php echo (int) $i; ?>">
                                <?php dynamic_sidebar('footer-' . $i); ?>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>

            <div class="footer-main">
                <div class="footer-brand">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <div class="site-title footer-title-wrap">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="footer-brand-link">
                                <span class="brand-wordmark"><?php echo esc_html($brand_prefix); ?><span class="brand-accent-3"><?php echo esc_html($brand_accent); ?></span><?php echo esc_html($brand_suffix); ?></span>
                                <span class="brand-badge"><?php echo esc_html($brand_tagline); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>
                    <p class="site-description footer-description">
                        <?php echo esc_html($footer_desc); ?>
                    </p>
                    <?php
                    $footer_location     = get_theme_mod('mileym3dia_contact_location', 'ORLANDO, FL · AVAILABLE WORLDWIDE');
                    $footer_availability = get_theme_mod('mileym3dia_contact_availability', 'NOW BOOKING NEW PROJECTS');
                    ?>
                    <div class="footer-telemetry-pill">
                        <span class="status-dot"></span>
                        <?php echo !empty($footer_location) ? esc_html($footer_location) . ' · ' : ''; ?><?php echo esc_html($footer_availability); ?>
                    </div>
                </div>

                <?php mileym3dia_social_links('footer-social'); ?>

                <nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e('Footer Menu', 'mileym3dia'); ?>">
                    <?php
                    if (has_nav_menu('footer')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'footer-menu',
                            'container'      => false,
                            'depth'          => 1,
                        ));
                    } else {
                        $store_url  = mileym3dia_get_page_url('store');
                        $portal_url = mileym3dia_get_page_url('creator-hub');
                        ?>
                        <div class="footer-directory">
                            <div class="footer-dir-col">
                                <span class="footer-dir-heading">STUDIO</span>
                                <ul class="footer-dir-list">
                                    <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                                    <li><a href="<?php echo esc_url(mileym3dia_get_page_url('about')); ?>">About Studio</a></li>
                                    <li><a href="<?php echo esc_url(mileym3dia_get_page_url('services')); ?>">Services &amp; Packages</a></li>
                                    <li><a href="<?php echo esc_url(mileym3dia_get_work_page_url()); ?>">Selected Work</a></li>
                                    <li><a href="<?php echo esc_url(mileym3dia_get_page_url('contact')); ?>">Book / Contact</a></li>
                                </ul>
                            </div>
                            <div class="footer-dir-col">
                                <span class="footer-dir-heading">STORE &amp; RESOURCES</span>
                                <ul class="footer-dir-list">
                                    <li><a href="<?php echo esc_url($store_url); ?>">Studio Store</a></li>
                                    <li><a href="<?php echo esc_url(add_query_arg('cat', 'luts-video', $store_url)); ?>">LUTs &amp; Video Packs</a></li>
                                    <li><a href="<?php echo esc_url(add_query_arg('cat', 'audio-stems', $store_url)); ?>">Audio &amp; Stems</a></li>
                                    <li><a href="<?php echo esc_url(mileym3dia_get_page_url('resources')); ?>">Creator Resources</a></li>
                                </ul>
                            </div>
                            <div class="footer-dir-col">
                                <span class="footer-dir-heading">PORTAL &amp; JOURNAL</span>
                                <ul class="footer-dir-list">
                                    <li><a href="<?php echo esc_url(add_query_arg('tab', 'register', $portal_url)); ?>">Create Account</a></li>
                                    <li><a href="<?php echo esc_url(add_query_arg('tab', 'login', $portal_url)); ?>">Client Sign In</a></li>
                                    <li><a href="<?php echo esc_url($portal_url . '#member-vault'); ?>">Download Vault</a></li>
                                    <li><a href="<?php echo esc_url(mileym3dia_get_blog_page_url()); ?>">Studio Journal</a></li>
                                </ul>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </nav>
            </div>

            <div class="footer-bottom">
                <div class="footer-copyright">
                    <?php
                    $copyright = get_theme_mod('mileym3dia_footer_copyright', '&copy; ' . date('Y') . ' MILEYM3DIA. All rights reserved.');
                    echo wp_kses_post($copyright);
                    ?>
                    <span class="footer-legal-sep">&middot;</span>
                    <a href="<?php echo esc_url(mileym3dia_get_page_url('privacy-terms')); ?>" class="footer-legal-link">Privacy &amp; Terms</a>
                </div>

                <?php
                $contact_email = get_theme_mod('mileym3dia_contact_email', 'hello@mileym3dia.com');
                if ($contact_email) :
                ?>
                    <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="footer-email">
                        <?php echo esc_html($contact_email); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </footer>

    <!-- Reusable Modal Foundation -->
    <div id="m3Modal" class="m3-modal" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="m3-modal-backdrop" data-m3-modal-close></div>
        <div class="m3-modal-dialog">
            <button type="button" class="m3-modal-close" data-m3-modal-close aria-label="<?php esc_attr_e('Close modal', 'mileym3dia'); ?>">
                <span>&times;</span>
            </button>
            <div class="m3-modal-content" id="m3ModalContent">
                <div class="m3-modal-body">
                    <?php
                    mileym3dia_newsletter_box(array(
                        'eyebrow'     => 'STUDIO UPDATES',
                        'title'       => __('Stay In The Loop', 'mileym3dia'),
                        'description' => __('Get updates on recent productions, behind-the-scenes breakdowns, and studio announcements.', 'mileym3dia'),
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

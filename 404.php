<?php
/**
 * 404 Error Template
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main error-404-main bg-shade-base">
    <section class="error-404 section-loose">
        <div class="container container--wide">
            <div class="error-404-card text-center">
                <div class="error-telemetry-pill">
                    <span class="status-dot"></span>
                    <span>ERROR 404 · SIGNAL LOST</span>
                </div>

                <div class="error-number-wrap">
                    <span class="error-number">4<span class="text-red">0</span>4</span>
                    <div class="error-scanline" aria-hidden="true"></div>
                </div>

                <h1 class="error-title">PAGE <span class="text-red">NOT FOUND</span></h1>
                <p class="error-description">
                    <?php esc_html_e('The page or production file you requested does not exist, was moved, or is currently offline. Use the search bar or studio directory below to navigate straight to your destination.', 'mileym3dia'); ?>
                </p>

                <div class="error-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--streetwear-red">
                        <span class="btn-text"><?php esc_html_e('BACK TO HOME', 'mileym3dia'); ?></span>
                        <span class="btn-arrow">↗</span>
                    </a>
                    <a href="<?php echo esc_url(mileym3dia_get_page_url('services')); ?>" class="btn btn--streetwear-outline">
                        <span class="btn-text"><?php esc_html_e('SERVICES & PACKAGES', 'mileym3dia'); ?></span>
                        <span class="btn-arrow">↗</span>
                    </a>
                    <a href="<?php echo esc_url(mileym3dia_get_work_page_url()); ?>" class="btn btn--streetwear-outline">
                        <span class="btn-text"><?php esc_html_e('VIEW PORTFOLIO', 'mileym3dia'); ?></span>
                        <span class="btn-arrow">↗</span>
                    </a>
                </div>

                <div class="error-search-box">
                    <span class="error-search-label"><?php esc_html_e('SEARCH THE STUDIO ARCHIVE', 'mileym3dia'); ?></span>
                    <?php get_search_form(); ?>
                </div>

                <div class="error-directory-dock">
                    <span class="error-directory-label"><?php esc_html_e('QUICK STUDIO DIRECTORY', 'mileym3dia'); ?></span>
                    <div class="error-directory-grid">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="error-dir-item error-dir-item--red">
                            <span class="dir-num text-red">01</span>
                            <span class="dir-name"><?php esc_html_e('HOME', 'mileym3dia'); ?></span>
                            <span class="dir-sub"><?php esc_html_e('Studio Overview', 'mileym3dia'); ?></span>
                        </a>
                        <a href="<?php echo esc_url(mileym3dia_get_page_url('about')); ?>" class="error-dir-item error-dir-item--yellow">
                            <span class="dir-num text-yellow">02</span>
                            <span class="dir-name"><?php esc_html_e('ABOUT', 'mileym3dia'); ?></span>
                            <span class="dir-sub"><?php esc_html_e('Vision & Gear', 'mileym3dia'); ?></span>
                        </a>
                        <a href="<?php echo esc_url(mileym3dia_get_page_url('services')); ?>" class="error-dir-item error-dir-item--lime">
                            <span class="dir-num text-lime">03</span>
                            <span class="dir-name"><?php esc_html_e('SERVICES', 'mileym3dia'); ?></span>
                            <span class="dir-sub"><?php esc_html_e('Packages & Bundles', 'mileym3dia'); ?></span>
                        </a>
                        <a href="<?php echo esc_url(mileym3dia_get_work_page_url()); ?>" class="error-dir-item error-dir-item--red">
                            <span class="dir-num text-red">04</span>
                            <span class="dir-name"><?php esc_html_e('WORK', 'mileym3dia'); ?></span>
                            <span class="dir-sub"><?php esc_html_e('Featured Case Studies', 'mileym3dia'); ?></span>
                        </a>
                        <a href="<?php echo esc_url(mileym3dia_get_blog_page_url()); ?>" class="error-dir-item error-dir-item--blue">
                            <span class="dir-num text-blue">05</span>
                            <span class="dir-name"><?php esc_html_e('BLOG', 'mileym3dia'); ?></span>
                            <span class="dir-sub"><?php esc_html_e('Studio Journal', 'mileym3dia'); ?></span>
                        </a>
                        <a href="<?php echo esc_url(mileym3dia_get_page_url('contact')); ?>" class="error-dir-item error-dir-item--yellow">
                            <span class="dir-num text-yellow">06</span>
                            <span class="dir-name"><?php esc_html_e('CONTACT', 'mileym3dia'); ?></span>
                            <span class="dir-sub"><?php esc_html_e('Start A Project', 'mileym3dia'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();

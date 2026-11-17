<?php
/**
 * WooCommerce Compatibility Wrapper Template
 *
 * Renders WooCommerce shop/product views in the M3 Big Red obsidian design system
 * when the WooCommerce plugin is active, or falls back to the built-in Studio Store.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('woocommerce_content')) {
    include get_template_directory() . '/page-store.php';
    return;
}

get_header();
?>

<main id="primary" class="site-main">
    <section class="page-title-section bg-shade-base">
        <div class="container container--wide">
            <span class="page-subtitle text-lime"><?php echo esc_html(get_theme_mod('mileym3dia_store_eyebrow', 'STUDIO STORE // DIGITAL & PHYSICAL')); ?></span>
            <h1 class="page-title page-title--mega">
                STUDIO <span class="text-lime">STORE</span>
            </h1>
            <p class="page-lead"><?php echo esc_html(get_theme_mod('mileym3dia_store_subtitle', 'Production-tested LUT packs, analog drum & stem libraries, brand lookbook kits, and limited studio gear.')); ?></p>
        </div>
    </section>

    <section class="section-loose bg-shade-elevated">
        <div class="container container--wide woocommerce-m3-shell">
            <?php woocommerce_content(); ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>

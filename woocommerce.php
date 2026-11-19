<?php
/**
 * WooCommerce Compatibility Wrapper Template
 *
 * Renders WooCommerce shop, single product, cart, checkout, and customer account views
 * inside the M3 Big Red obsidian design system.
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

$cart_url     = function_exists('mileym3dia_get_cart_url') ? mileym3dia_get_cart_url() : home_url('/cart/');
$checkout_url = function_exists('mileym3dia_get_checkout_url') ? mileym3dia_get_checkout_url() : home_url('/checkout/');
$account_url  = function_exists('mileym3dia_get_account_url') ? mileym3dia_get_account_url() : home_url('/my-account/');
$cart_count   = function_exists('mileym3dia_get_cart_count') ? mileym3dia_get_cart_count() : 0;
$page_heading = is_product() ? get_the_title() : 'STUDIO <span class="text-lime">STORE</span>';
?>

<main id="primary" class="site-main m3-wc-main">
    <section class="page-title-section bg-shade-base">
        <div class="container container--wide">
            <span class="page-subtitle text-lime"><?php echo esc_html(get_theme_mod('mileym3dia_store_eyebrow', 'STUDIO STORE // WOOCOMMERCE DIGITAL & PHYSICAL')); ?></span>
            <h1 class="page-title page-title--mega">
                <?php echo is_product() ? esc_html($page_heading) : $page_heading; ?>
            </h1>
            <div class="store-hero-bar">
                <div class="store-hero-badges">
                    <a href="<?php echo esc_url(mileym3dia_get_page_url('store')); ?>" class="store-pill">← ALL STUDIO PRODUCTS</a>
                    <span class="store-pill">INSTANT DIGITAL DOWNLOADS</span>
                </div>
                <div class="m3-wc-nav-actions">
                    <a href="<?php echo esc_url($cart_url); ?>" class="btn btn--streetwear-red">
                        <span>CART (<?php echo esc_html((string) $cart_count); ?>)</span>
                    </a>
                    <a href="<?php echo esc_url($checkout_url); ?>" class="btn btn--streetwear-outline">
                        <span>CHECKOUT</span>
                    </a>
                    <a href="<?php echo esc_url($account_url); ?>" class="btn btn--streetwear-outline">
                        <span>MY ACCOUNT</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-loose bg-shade-elevated">
        <div class="container container--wide woocommerce-m3-shell">
            <?php woocommerce_content(); ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>

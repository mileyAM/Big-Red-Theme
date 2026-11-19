<?php
/**
 * Template Name: Store / Shop
 * Description: Unified WooCommerce Digital & Physical Studio Store template preserving the
 * M3 Big Red obsidian layout, category filtering, product cards, and direct WooCommerce Cart/Checkout/Account flows.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$store_eyebrow  = get_theme_mod('mileym3dia_store_eyebrow', 'STUDIO STORE // WOOCOMMERCE DIGITAL & PHYSICAL');
$store_title    = get_theme_mod('mileym3dia_store_title', 'STUDIO STORE');
$store_subtitle = get_theme_mod('mileym3dia_store_subtitle', 'Production-tested LUT packs, analog drum & stem libraries, brand lookbook systems, studio merch, and Pro retainer passes powered by WooCommerce.');
$products       = function_exists('mileym3dia_get_store_products') ? mileym3dia_get_store_products() : array();
$active_cat     = isset($_GET['cat']) ? sanitize_title(wp_unslash($_GET['cat'])) : 'all';
$cart_url       = function_exists('mileym3dia_get_cart_url') ? mileym3dia_get_cart_url() : home_url('/cart/');
$checkout_url   = function_exists('mileym3dia_get_checkout_url') ? mileym3dia_get_checkout_url() : home_url('/checkout/');
$account_url    = function_exists('mileym3dia_get_account_url') ? mileym3dia_get_account_url() : home_url('/my-account/');
$cart_count     = function_exists('mileym3dia_get_cart_count') ? mileym3dia_get_cart_count() : 0;
$added_notice   = isset($_GET['added-to-cart']) ? absint($_GET['added-to-cart']) : 0;

if (strpos($store_title, '<') === false) {
    $words = explode(' ', trim($store_title));
    if (count($words) > 1) {
        $last_word        = array_pop($words);
        $store_title_html = esc_html(implode(' ', $words)) . ' <span class="text-lime">' . esc_html($last_word) . '</span>';
    } else {
        $store_title_html = '<span class="text-lime">' . esc_html($store_title) . '</span>';
    }
} else {
    $store_title_html = wp_kses_post($store_title);
}
?>

<main id="primary" class="site-main">

    <!-- FULL-WIDTH STORE HERO -->
    <section class="page-title-section bg-shade-base">
        <div class="container container--wide">
            <span class="page-subtitle text-lime"><?php echo esc_html($store_eyebrow); ?></span>
            <h1 class="page-title page-title--mega">
                <?php echo $store_title_html; ?>
            </h1>
            <p class="page-lead"><?php echo esc_html($store_subtitle); ?></p>

            <div class="store-hero-bar">
                <div class="store-hero-badges">
                    <span class="store-pill"><span class="store-pill__dot"></span> INSTANT DIGITAL DOWNLOADS</span>
                    <span class="store-pill">WOOCOMMERCE CHECKOUT</span>
                    <span class="store-pill">DIGITAL &amp; PHYSICAL READY</span>
                </div>
                <div class="m3-wc-nav-actions">
                    <a href="<?php echo esc_url($cart_url); ?>" class="btn btn--streetwear-red store-cart-trigger">
                        <span>CART (<span id="store-cart-count"><?php echo esc_html((string) $cart_count); ?></span>) →</span>
                    </a>
                    <a href="<?php echo esc_url($checkout_url); ?>" class="btn btn--streetwear-outline">
                        <span>CHECKOUT</span>
                    </a>
                    <a href="<?php echo esc_url($account_url); ?>" class="btn btn--streetwear-outline">
                        <span>MY ACCOUNT &amp; DOWNLOADS</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php while (have_posts()) : the_post(); ?>
        <?php if (trim(get_the_content())) : ?>
            <section class="section-loose page-editor-content bg-shade-base" style="padding-top: 2rem; padding-bottom: 2rem;">
                <div class="container container--wide">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endwhile; ?>

    <?php if ($added_notice > 0) : ?>
        <section class="bg-shade-elevated" style="padding-top: 2rem;">
            <div class="container container--wide">
                <div class="portal-notice portal-notice--success" role="status">
                    <strong>ADDED TO CART //</strong> Item added to your WooCommerce cart.
                    <a href="<?php echo esc_url($cart_url); ?>" class="text-lime" style="margin-left: 0.75rem;">View Cart →</a>
                    <a href="<?php echo esc_url($checkout_url); ?>" class="text-lime" style="margin-left: 0.75rem;">Proceed to Checkout →</a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- CATEGORY FILTER & PRODUCT GRID -->
    <section class="section-loose bg-shade-elevated" id="catalog">
        <div class="container container--wide">

            <div class="portfolio-filters store-filters" id="store-filters" role="tablist" aria-label="<?php esc_attr_e('Filter store products by category', 'm3-big-red'); ?>">
                <button type="button" class="filter-btn <?php echo ('all' === $active_cat || empty($active_cat)) ? 'active' : ''; ?>" data-filter="all" role="tab" aria-selected="<?php echo ('all' === $active_cat || empty($active_cat)) ? 'true' : 'false'; ?>">ALL ITEMS</button>
                <button type="button" class="filter-btn <?php echo 'luts-video' === $active_cat ? 'active' : ''; ?>" data-filter="luts-video" role="tab" aria-selected="<?php echo 'luts-video' === $active_cat ? 'true' : 'false'; ?>">LUTS &amp; VIDEO</button>
                <button type="button" class="filter-btn <?php echo 'audio-stems' === $active_cat ? 'active' : ''; ?>" data-filter="audio-stems" role="tab" aria-selected="<?php echo 'audio-stems' === $active_cat ? 'true' : 'false'; ?>">AUDIO &amp; STEMS</button>
                <button type="button" class="filter-btn <?php echo 'templates-guides' === $active_cat ? 'active' : ''; ?>" data-filter="templates-guides" role="tab" aria-selected="<?php echo 'templates-guides' === $active_cat ? 'true' : 'false'; ?>">TEMPLATES &amp; GUIDES</button>
                <button type="button" class="filter-btn <?php echo 'merch-passes' === $active_cat ? 'active' : ''; ?>" data-filter="merch-passes" role="tab" aria-selected="<?php echo 'merch-passes' === $active_cat ? 'true' : 'false'; ?>">MERCH &amp; PASSES</button>
            </div>

            <div class="store-grid" id="store-grid">
                <?php foreach ($products as $idx => $item) :
                    $prod_id    = isset($item['id']) ? (int) $item['id'] : ($idx + 501);
                    $cat_slug   = sanitize_title($item['category_slug']);
                    $is_hidden  = ('all' !== $active_cat && !empty($active_cat) && $active_cat !== $cat_slug);
                    $permalink  = !empty($item['permalink']) ? $item['permalink'] : home_url('/product/' . sanitize_title($item['title']) . '/');
                    $add_url    = !empty($item['add_to_cart_url']) ? $item['add_to_cart_url'] : add_query_arg('add-to-cart', $prod_id, $cart_url);
                    $fulfill    = !empty($item['is_physical']) ? 'PHYSICAL · SHIPS WORLDWIDE' : (!empty($item['is_downloadable']) ? 'INSTANT DIGITAL DOWNLOAD' : 'DIGITAL STUDIO PASS');
                ?>
                <article class="store-card" data-category="<?php echo esc_attr($cat_slug); ?>" data-product-id="<?php echo esc_attr((string) $prod_id); ?>" style="<?php echo $is_hidden ? 'display:none;' : ''; ?>">
                    <a href="<?php echo esc_url($permalink); ?>" class="store-card__media">
                        <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy" />
                        <?php if (!empty($item['badge'])) : ?>
                            <span class="store-card__badge"><?php echo esc_html($item['badge']); ?></span>
                        <?php endif; ?>
                        <span class="store-card__price-tag"><?php echo esc_html($item['price']); ?></span>
                    </a>

                    <div class="store-card__body">
                        <div class="store-card__meta">
                            <span class="store-card__category"><?php echo esc_html($item['category_label']); ?></span>
                            <span class="store-card__format"><?php echo esc_html($item['format']); ?></span>
                        </div>
                        <h2 class="store-card__title">
                            <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($item['title']); ?></a>
                        </h2>
                        <p class="store-card__desc"><?php echo esc_html($item['desc']); ?></p>
                        <div class="store-card__fulfillment"><?php echo esc_html($fulfill); ?></div>

                        <div class="store-card__actions">
                            <a href="<?php echo esc_url($add_url); ?>" class="btn btn--streetwear-red add_to_cart_button" data-product_id="<?php echo esc_attr((string) $prod_id); ?>">
                                <span><?php echo esc_html($item['btn_text']); ?></span>
                            </a>
                            <a href="<?php echo esc_url($permalink); ?>" class="btn btn--streetwear-outline">
                                <span>VIEW DETAILS →</span>
                            </a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- CREATOR HUB & FREE RESOURCES CTA -->
    <section class="contact-cta section-loose bg-shade-base">
        <div class="container container--wide cta-content text-center">
            <span class="contact-eyebrow text-lime">MEMBER VAULT &amp; CUSTOMER ACCOUNT</span>
            <h2 class="contact-headline">WANT FREE STARTER PACKS &amp; INSTANT ORDER DOWNLOADS?</h2>
            <p class="contact-subhead">Manage all WooCommerce digital downloads in My Account, or join the free Creator Hub for complimentary LUTs, call sheets, and live project tracking.</p>
            <div class="hero-action-buttons" style="justify-content:center; margin-top:2rem;">
                <a href="<?php echo esc_url($account_url); ?>" class="btn btn--streetwear-red">
                    <span class="btn-text">CUSTOMER ACCOUNT</span>
                    <span class="btn-arrow">↗</span>
                </a>
                <a href="<?php echo esc_url(add_query_arg('tab', 'register', mileym3dia_get_page_url('creator-hub'))); ?>" class="btn btn--streetwear-outline">
                    <span class="btn-text">JOIN CREATOR HUB FREE</span>
                </a>
                <a href="<?php echo esc_url(mileym3dia_get_page_url('resources')); ?>" class="btn btn--streetwear-outline">
                    <span class="btn-text">FREE RESOURCE DIRECTORY</span>
                </a>
            </div>
        </div>
    </section>

</main>

<script>
(function() {
    var filterContainer = document.getElementById('store-filters');
    var cards = document.querySelectorAll('#store-grid .store-card');
    if (filterContainer && cards.length) {
        filterContainer.addEventListener('click', function(e) {
            var btn = e.target.closest('.filter-btn');
            if (!btn) return;
            var filter = btn.getAttribute('data-filter');
            filterContainer.querySelectorAll('.filter-btn').forEach(function(b) {
                b.classList.remove('active');
                b.setAttribute('aria-selected', 'false');
            });
            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');

            cards.forEach(function(card) {
                var cat = card.getAttribute('data-category');
                card.style.display = (filter === 'all' || cat === filter) ? '' : 'none';
            });
        });
    }
})();
</script>

<?php get_footer(); ?>

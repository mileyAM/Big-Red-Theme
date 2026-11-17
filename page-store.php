<?php
/**
 * Template Name: Store / Shop
 * Description: Studio Store & Digital Asset Shop with Customizer-editable products,
 * category filtering, interactive Studio Cart & Express Checkout, and WooCommerce support.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$store_eyebrow  = get_theme_mod('mileym3dia_store_eyebrow', 'STUDIO STORE // DIGITAL & PHYSICAL');
$store_title    = get_theme_mod('mileym3dia_store_title', 'THE STUDIO STORE');
$store_subtitle = get_theme_mod('mileym3dia_store_subtitle', 'Production-tested LUT packs, analog drum & stem libraries, brand lookbook kits, and limited studio gear. Edit products, prices, photos, and checkout links anytime in the Customizer.');
$products       = function_exists('mileym3dia_get_store_products') ? mileym3dia_get_store_products() : array();
$active_cat     = isset($_GET['cat']) ? sanitize_title(wp_unslash($_GET['cat'])) : 'all';
$order_status   = isset($_GET['order']) ? sanitize_key(wp_unslash($_GET['order'])) : '';
?>

<main id="primary" class="site-main">

    <!-- FULL-WIDTH STORE HERO -->
    <section class="page-title-section bg-shade-base">
        <div class="container container--wide">
            <span class="page-subtitle text-lime"><?php echo esc_html($store_eyebrow); ?></span>
            <h1 class="page-title page-title--mega">
                STUDIO <span class="text-lime">STORE</span>
            </h1>
            <p class="page-lead"><?php echo esc_html($store_subtitle); ?></p>

            <div class="store-hero-bar">
                <div class="store-hero-badges">
                    <span class="store-pill"><span class="store-pill__dot"></span> INSTANT DIGITAL DELIVERY</span>
                    <span class="store-pill">COMMERCIAL STUDIO LICENSE</span>
                    <span class="store-pill">CUSTOMIZER EDITABLE</span>
                </div>
                <button type="button" class="btn btn--streetwear-outline store-cart-trigger" id="open-store-cart">
                    <span>STUDIO CART (<span id="store-cart-count">0</span>) — <span id="store-cart-total">$0</span></span>
                </button>
            </div>
        </div>
    </section>

    <?php if ('placed' === $order_status) : ?>
    <section class="section-loose bg-shade-elevated" style="padding-top: 2rem; padding-bottom: 0;">
        <div class="container container--wide">
            <div class="portal-notice portal-notice--success" role="status">
                <strong>STUDIO ORDER RECEIVED //</strong> Your order request has been logged. Check your inbox for your invoice and download link, or grab your complimentary studio files in the <a href="<?php echo esc_url(mileym3dia_get_page_url('resources')); ?>" class="text-lime">Resources Vault</a>.
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
                    $num       = $idx + 1;
                    $cat_slug  = sanitize_title($item['category_slug']);
                    $is_hidden = ('all' !== $active_cat && !empty($active_cat) && $active_cat !== $cat_slug);
                    $price_num = floatval(preg_replace('/[^0-9.]/', '', (string) $item['price']));
                ?>
                <article class="store-card" data-category="<?php echo esc_attr($cat_slug); ?>" data-product-id="m3-prod-<?php echo esc_attr($num); ?>" style="<?php echo $is_hidden ? 'display:none;' : ''; ?>">
                    <div class="store-card__media">
                        <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy" />
                        <?php if (!empty($item['badge'])) : ?>
                            <span class="store-card__badge"><?php echo esc_html($item['badge']); ?></span>
                        <?php endif; ?>
                        <span class="store-card__price-tag"><?php echo esc_html($item['price']); ?></span>
                    </div>

                    <div class="store-card__body">
                        <div class="store-card__meta">
                            <span class="store-card__category"><?php echo esc_html($item['category_label']); ?></span>
                            <span class="store-card__format"><?php echo esc_html($item['format']); ?></span>
                        </div>
                        <h2 class="store-card__title"><?php echo esc_html($item['title']); ?></h2>
                        <p class="store-card__desc"><?php echo esc_html($item['desc']); ?></p>

                        <div class="store-card__actions">
                            <button
                                type="button"
                                class="btn btn--streetwear-red store-add-btn"
                                data-id="m3-prod-<?php echo esc_attr($num); ?>"
                                data-title="<?php echo esc_attr($item['title']); ?>"
                                data-price="<?php echo esc_attr($price_num); ?>"
                            >
                                <span><?php echo esc_html($item['btn_text']); ?></span>
                            </button>

                            <?php if (!empty($item['checkout_url'])) : ?>
                                <a href="<?php echo esc_url($item['checkout_url']); ?>" class="btn btn--streetwear-outline" <?php echo (0 === strpos($item['checkout_url'], 'http') && false === strpos($item['checkout_url'], home_url())) ? 'target="_blank" rel="noopener noreferrer"' : 'download'; ?>>
                                    <span><?php echo esc_html($item['secondary_text']); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- EXPRESS CHECKOUT & STUDIO CART -->
    <section class="section-loose bg-shade-base" id="checkout">
        <div class="container container--wide">
            <div class="store-checkout-shell">
                <div class="store-checkout-summary">
                    <span class="section-label text-lime">EXPRESS STUDIO CHECKOUT</span>
                    <h2 class="section-title" style="margin-bottom: 0.75rem;">YOUR STUDIO CART</h2>
                    <p class="section-header-desc" style="margin-bottom: 1.5rem;">
                        Select any combination of LUT packs, stem libraries, templates, or studio passes above. Submit your order below for instant invoice &amp; digital delivery, or connect your WooCommerce/Stripe checkout URL in the Customizer.
                    </p>

                    <div class="store-cart-items" id="store-cart-items-list">
                        <div class="store-cart-empty" id="store-cart-empty-msg">
                            No items selected yet. Click <strong>ADD TO CART</strong> on any product above to build your order.
                        </div>
                    </div>

                    <div class="store-cart-totals">
                        <div class="store-cart-totals__row">
                            <span>LICENSE TIER</span>
                            <span>COMMERCIAL STUDIO MASTER</span>
                        </div>
                        <div class="store-cart-totals__row store-cart-totals__row--grand">
                            <span>ESTIMATED TOTAL</span>
                            <span id="store-checkout-grand-total">$0</span>
                        </div>
                    </div>
                </div>

                <div class="store-checkout-form-wrap">
                    <form class="contact-form store-checkout-form" method="post" action="<?php echo esc_url(add_query_arg('order', 'placed', mileym3dia_get_page_url('store')) . '#checkout'); ?>">
                        <?php if (function_exists('wp_nonce_field')) { wp_nonce_field('mileym3dia_store_order', 'mileym3dia_store_nonce'); } ?>
                        <input type="hidden" name="mileym3dia_action" value="store_order" />
                        <input type="hidden" name="order_items_json" id="order-items-json" value="[]" />
                        <input type="hidden" name="order_total" id="order-total-input" value="$0" />

                        <h3 class="store-checkout-form__title">COMPLETE ORDER / REQUEST INVOICE</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="order-name">FULL NAME *</label>
                                <input type="text" id="order-name" name="order_name" placeholder="Your name or studio" required />
                            </div>
                            <div class="form-group">
                                <label for="order-email">DELIVERY EMAIL *</label>
                                <input type="email" id="order-email" name="order_email" placeholder="you@studio.com" required />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="order-payment-method">PAYMENT PREFERENCE</label>
                                <select id="order-payment-method" name="order_payment_method">
                                    <option value="card-invoice">Instant Card Checkout / Stripe Link</option>
                                    <option value="paypal-live">PayPal Express Checkout</option>
                                    <option value="studio-invoice">Net-15 Studio Production Invoice</option>
                                    <option value="creator-credit">Creator Hub Member Credit</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="order-selected-summary">SELECTED ITEMS</label>
                                <input type="text" id="order-selected-summary" name="order_selected_summary" value="None selected yet" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="order-notes">ORDER NOTES / SIZING / CAMERA PROFILE</label>
                            <textarea id="order-notes" name="order_notes" rows="3" placeholder="Optional: hoodie size (S-XXL), camera profile (RED / ARRI / Sony S-Log3), or billing notes..."></textarea>
                        </div>

                        <button type="submit" class="btn btn--streetwear-red btn--full">
                            <span><?php echo esc_html(get_theme_mod('mileym3dia_store_checkout_btn', 'COMPLETE STUDIO ORDER →')); ?></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CREATOR HUB & FREE RESOURCES CTA -->
    <section class="contact-cta section-loose bg-shade-elevated">
        <div class="container container--wide cta-content text-center">
            <span class="contact-eyebrow text-lime">MEMBER VAULT ACCESS</span>
            <h2 class="contact-headline">WANT FREE STARTER PACKS &amp; CLIENT VAULT ACCESS?</h2>
            <p class="contact-subhead">Register a free Creator Hub account to unlock complimentary LUTs, call sheets, and private client delivery folders.</p>
            <div class="hero-action-buttons" style="justify-content:center; margin-top:2rem;">
                <a href="<?php echo esc_url(add_query_arg('tab', 'register', mileym3dia_get_page_url('creator-hub'))); ?>" class="btn btn--streetwear-red">
                    <span class="btn-text">CREATE ACCOUNT</span>
                    <span class="btn-arrow">↗</span>
                </a>
                <a href="<?php echo esc_url(mileym3dia_get_page_url('resources')); ?>" class="btn btn--streetwear-outline">
                    <span class="btn-text">FREE RESOURCE PACKS</span>
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

    var cart = [];
    var countEl = document.getElementById('store-cart-count');
    var totalEl = document.getElementById('store-cart-total');
    var grandTotalEl = document.getElementById('store-checkout-grand-total');
    var itemsListEl = document.getElementById('store-cart-items-list');
    var emptyMsgEl = document.getElementById('store-cart-empty-msg');
    var summaryInput = document.getElementById('order-selected-summary');
    var jsonInput = document.getElementById('order-items-json');
    var totalInput = document.getElementById('order-total-input');

    function renderCart() {
        var total = 0;
        var count = 0;
        var names = [];

        cart.forEach(function(item) {
            total += item.price * item.qty;
            count += item.qty;
            names.push(item.title + (item.qty > 1 ? ' (x' + item.qty + ')' : ''));
        });

        if (countEl) countEl.textContent = count;
        if (totalEl) totalEl.textContent = '$' + total.toLocaleString();
        if (grandTotalEl) grandTotalEl.textContent = '$' + total.toLocaleString();
        if (summaryInput) summaryInput.value = names.length ? names.join(', ') : 'None selected yet';
        if (jsonInput) jsonInput.value = JSON.stringify(cart);
        if (totalInput) totalInput.value = '$' + total.toLocaleString();

        if (!itemsListEl) return;
        itemsListEl.innerHTML = '';
        if (!cart.length) {
            if (emptyMsgEl) itemsListEl.appendChild(emptyMsgEl);
            return;
        }

        cart.forEach(function(item, index) {
            var row = document.createElement('div');
            row.className = 'store-cart-row';
            row.innerHTML =
                '<div class="store-cart-row__info">' +
                    '<strong>' + item.title + '</strong>' +
                    '<span>$' + item.price + ' × ' + item.qty + '</span>' +
                '</div>' +
                '<div class="store-cart-row__controls">' +
                    '<button type="button" class="store-qty-btn" data-idx="' + index + '" data-delta="-1" aria-label="Decrease quantity">−</button>' +
                    '<span class="store-qty-val">' + item.qty + '</span>' +
                    '<button type="button" class="store-qty-btn" data-idx="' + index + '" data-delta="1" aria-label="Increase quantity">+</button>' +
                '</div>';
            itemsListEl.appendChild(row);
        });
    }

    document.querySelectorAll('.store-add-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = btn.getAttribute('data-id');
            var title = btn.getAttribute('data-title');
            var price = parseFloat(btn.getAttribute('data-price')) || 0;

            var existing = cart.find(function(c) { return c.id === id; });
            if (existing) {
                existing.qty += 1;
            } else {
                cart.push({ id: id, title: title, price: price, qty: 1 });
            }

            var span = btn.querySelector('span');
            var originalText = span ? span.textContent : btn.textContent;
            if (span) span.textContent = 'ADDED TO CART ✓';
            setTimeout(function() {
                if (span) span.textContent = originalText;
            }, 1200);

            renderCart();
        });
    });

    if (itemsListEl) {
        itemsListEl.addEventListener('click', function(e) {
            var qBtn = e.target.closest('.store-qty-btn');
            if (!qBtn) return;
            var idx = parseInt(qBtn.getAttribute('data-idx'), 10);
            var delta = parseInt(qBtn.getAttribute('data-delta'), 10);
            if (!cart[idx]) return;
            cart[idx].qty += delta;
            if (cart[idx].qty <= 0) {
                cart.splice(idx, 1);
            }
            renderCart();
        });
    }

    var openCartBtn = document.getElementById('open-store-cart');
    if (openCartBtn) {
        openCartBtn.addEventListener('click', function() {
            var checkoutEl = document.getElementById('checkout');
            if (checkoutEl) {
                checkoutEl.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
})();
</script>

<?php get_footer(); ?>

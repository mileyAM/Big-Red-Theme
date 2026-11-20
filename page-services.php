<?php
/**
 * Template Name: Services
 * Description: Dedicated Services, Capabilities & Pricing page template.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$services_hero_bg = '';
if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {
    $services_hero_bg = get_the_post_thumbnail_url(get_the_ID(), 'full');
}
if (empty($services_hero_bg)) {
    $services_hero_bg = get_theme_mod('mileym3dia_services_hero_image', '');
}
if (empty($services_hero_bg)) {
    $services_hero_bg = mileym3dia_asset_image_url('services-bg.jpg');
}

$services_raw_title = get_theme_mod('mileym3dia_services_hero_title', 'SERVICES & CAPABILITIES');
if (strpos($services_raw_title, '<') === false) {
    $s_words = explode(' ', trim($services_raw_title));
    if (count($s_words) > 1) {
        $s_last = array_pop($s_words);
        $services_title_html = esc_html(implode(' ', $s_words)) . ' <span class="text-lime">' . esc_html($s_last) . '</span>';
    } else {
        $services_title_html = '<span class="text-lime">' . esc_html($services_raw_title) . '</span>';
    }
} else {
    $services_title_html = wp_kses_post($services_raw_title);
}
?>

<main id="primary" class="site-main">

    <!-- OFFICIAL MILEYM3DIA SERVICES BANNER (BIG IDEAS — LIME ACCENT) -->
    <?php
    if (function_exists('mileym3dia_render_page_banner')) {
        mileym3dia_render_page_banner('services', array(
            'heading_tag' => 'h1',
        ));
    }
    ?>

    <?php while (have_posts()) : the_post(); ?>
        <?php if (trim(get_the_content())) : ?>
            <section class="section-loose page-editor-content bg-shade-base">
                <div class="container">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endwhile; ?>

    <!-- 5 CORE AGENCY SERVICES (#services) -->
    <section class="services-section section-loose bg-shade-elevated" id="services">
        <div class="container container--wide">
            <div class="section-header">
                <div class="section-header-left">
                    <span class="section-label text-lime">OUR SPECIALIZATIONS</span>
                    <h2 class="section-title section-title--xl"><?php echo esc_html(get_theme_mod('mileym3dia_services_title', 'CORE CREATIVE SERVICES')); ?></h2>
                </div>
                <div class="section-header-right">
                    <p class="section-header-desc">
                        Every service is handled in-house from creative concept through final master delivery.
                    </p>
                </div>
            </div>

            <?php
            $services_list = function_exists('mileym3dia_get_services') ? mileym3dia_get_services() : array();
            ?>
            <div class="services-grid">
                <?php foreach ($services_list as $idx => $srv) :
                    $s_num     = !empty($srv['num']) ? $srv['num'] : str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT);
                    $s_title   = $srv['title'];
                    $s_tag     = $srv['tag'];
                    $s_desc    = $srv['desc'];
                    $s_subtags = !empty($srv['subtags']) && is_array($srv['subtags']) ? $srv['subtags'] : array();
                    $accent    = !empty($srv['accent']) ? $srv['accent'] : 'red';
                    $cta_text  = !empty($srv['cta_text']) ? $srv['cta_text'] : sprintf(__('BOOK %s', 'mileym3dia'), strtoupper($s_title));
                    $cta_url   = !empty($srv['cta_url']) ? $srv['cta_url'] : add_query_arg('discipline', rawurlencode($s_title), mileym3dia_get_page_url('contact'));
                ?>
                    <article class="service-card service-card--<?php echo esc_attr($accent); ?>">
                        <div class="service-card-header">
                            <span class="service-card-num"><?php echo esc_html($s_num); ?></span>
                            <span class="service-card-tag text-<?php echo esc_attr($accent); ?>"><?php echo esc_html($s_tag); ?></span>
                        </div>
                        <div class="service-card-body">
                            <h3 class="service-card-title"><?php echo esc_html($s_title); ?></h3>
                            <p class="service-card-desc"><?php echo esc_html($s_desc); ?></p>
                            <?php if (!empty($s_subtags)) : ?>
                                <ul class="service-deliverables">
                                    <?php foreach ($s_subtags as $item) : ?>
                                        <li><span class="deliverable-arrow text-<?php echo esc_attr($accent); ?>">→</span> <?php echo esc_html($item); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="service-card-footer">
                            <a href="<?php echo esc_url($cta_url); ?>" class="service-card-action">
                                <span><?php echo esc_html($cta_text); ?></span>
                                <span class="action-arrow">↗</span>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- PRICING & PRODUCTION PACKAGES + COMPACT BUNDLE BUILDER (#pricing) -->
    <section class="pricing-section section-loose bg-shade-base" id="pricing">
        <div class="container container--wide">
            <div class="section-header text-center">
                <span class="section-label text-accent">TRANSPARENT PRODUCTION PRICING</span>
                <h2 class="section-title section-title--xl">PACKAGES &amp; CUSTOM BUNDLES</h2>
                <p class="section-header-desc pricing-header-desc">
                    Choose a ready-to-shoot package or switch to the Interactive Bundle Builder to mix and match individual services from $95.
                </p>

                <!-- Interactive Tab Switcher -->
                <div class="pricing-tabs-nav" role="tablist" aria-label="<?php esc_attr_e('Pricing View Options', 'mileym3dia'); ?>">
                    <button type="button" class="pricing-tab-btn active" id="tabBtnPackages" data-tab="packages" role="tab" aria-selected="true" aria-controls="viewPackages">
                        <span class="tab-badge">01</span>
                        <span class="tab-label">CURATED PACKAGES</span>
                        <span class="tab-meta text-accent">$350 – $1,450</span>
                    </button>
                    <button type="button" class="pricing-tab-btn" id="tabBtnBundle" data-tab="bundle" role="tab" aria-selected="false" aria-controls="viewBundle">
                        <span class="tab-badge">02</span>
                        <span class="tab-label">CUSTOM BUNDLE BUILDER</span>
                        <span class="tab-meta text-accent">SAVE 10% (3+ SERVICES)</span>
                    </button>
                </div>
            </div>

            <!-- TAB 1: CURATED PACKAGES -->
            <div class="pricing-view-panel active" id="viewPackages" role="tabpanel" aria-labelledby="tabBtnPackages">
                <?php mileym3dia_render_pricing_packages(); ?>

                <div class="pricing-switch-banner">
                    <div class="switch-banner-content">
                        <span class="switch-banner-tag text-accent">LOOKING FOR INDIVIDUAL DELIVERABLES?</span>
                        <p class="switch-banner-text">
                            Need a single vertical reel ($95), cover art ($125), vocal mix ($150), or photo session ($225)? Mix &amp; match your own bundle.
                        </p>
                    </div>
                    <button type="button" class="btn btn--page-accent js-open-bundle-tab">
                        <span class="btn-text">OPEN BUNDLE BUILDER (FROM $95)</span>
                        <span class="btn-arrow">⚡</span>
                    </button>
                </div>
            </div>

            <!-- TAB 2: COMPACT BUNDLE BUILDER -->
            <div class="pricing-view-panel" id="viewBundle" role="tabpanel" aria-labelledby="tabBtnBundle">
                <div id="bundle"></div>
                <?php mileym3dia_render_bundle_builder('services'); ?>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var tabBtns = document.querySelectorAll('.pricing-tab-btn');
        var panels  = document.querySelectorAll('.pricing-view-panel');

        function switchPricingTab(tabKey) {
            tabBtns.forEach(function(btn) {
                var isMatch = btn.getAttribute('data-tab') === tabKey;
                btn.classList.toggle('active', isMatch);
                btn.setAttribute('aria-selected', isMatch ? 'true' : 'false');
            });
            panels.forEach(function(panel) {
                var targetId = (tabKey === 'bundle') ? 'viewBundle' : 'viewPackages';
                panel.classList.toggle('active', panel.id === targetId);
            });
        }

        tabBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                var target = btn.getAttribute('data-tab');
                switchPricingTab(target);
            });
        });

        var bundleSwitchers = document.querySelectorAll('.js-open-bundle-tab');
        bundleSwitchers.forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                switchPricingTab('bundle');
                var prSection = document.getElementById('pricing');
                if (prSection) {
                    prSection.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // URL param & Hash auto-selection
        var urlParams = new URLSearchParams(window.location.search);
        var viewParam = (urlParams.get('view') || urlParams.get('tab') || '').toLowerCase();
        var hash      = (window.location.hash || '').toLowerCase();

        if (viewParam === 'bundle' || hash === '#bundle' || hash === '#bundle-builder' || hash === '#custom-bundle') {
            switchPricingTab('bundle');
        } else if (viewParam === 'packages' || hash === '#packages' || hash === '#pricing') {
            switchPricingTab('packages');
        }

        window.addEventListener('hashchange', function() {
            var h = (window.location.hash || '').toLowerCase();
            if (h === '#bundle' || h === '#bundle-builder' || h === '#custom-bundle') {
                switchPricingTab('bundle');
            } else if (h === '#packages' || h === '#pricing') {
                switchPricingTab('packages');
            }
        });
    });
    </script>

    <!-- CONTACT CTA (#quote) -->
    <section class="contact-cta section-loose bg-shade-elevated" id="quote">
        <div class="container container--wide cta-content text-center">
            <span class="contact-eyebrow text-accent">CUSTOM SCOPES AVAILABLE</span>
            <h2 class="contact-headline">NEED A CUSTOM PRODUCTION QUOTE?</h2>
            <p class="contact-subhead">Tell us what you are building and we will put together a tailored production plan and budget.</p>
            <div class="hero-action-buttons" style="justify-content:center; margin-top:2rem;">
                <a href="<?php echo esc_url(mileym3dia_get_page_url('contact')); ?>" class="btn btn--page-accent">
                    <span class="btn-text"><?php esc_html_e('REQUEST A CUSTOM QUOTE', 'mileym3dia'); ?></span>
                    <span class="btn-arrow">↗</span>
                </a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>

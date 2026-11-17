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
?>

<main id="primary" class="site-main">

    <!-- FULL-WIDTH SERVICES HERO -->
    <section class="page-title-section services-hero-banner bg-shade-base">
        <div class="services-hero-bg" style="background-image: url('<?php echo esc_url(mileym3dia_asset_image_url('services-bg.jpg')); ?>');"></div>
        <div class="services-hero-overlay"></div>
        <div class="container container--wide services-hero-inner">
            <span class="page-subtitle text-lime"><?php echo esc_html(get_theme_mod('mileym3dia_services_eyebrow', '03 / WHAT WE DO')); ?></span>
            <h1 class="page-title page-title--mega">
                SERVICES &amp; <span class="text-lime">CAPABILITIES</span>
            </h1>
            <p class="page-lead">
                <?php echo esc_html(get_theme_mod('mileym3dia_services_description', 'Full-spectrum production for businesses, artists, and creators who want work that stands out.')); ?>
            </p>
        </div>
    </section>

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
            $services_defaults = array(
                1 => array('title' => 'Video Production', 'tag' => 'COMMERCIALS · MUSIC VIDEOS · REELS', 'desc' => 'Cinema-grade music videos, brand commercials, documentaries, aerial drone capture, and professional DaVinci Resolve color grading.', 'subtags' => 'Music Video Direction & Capture, Brand Commercials & Documentaries, Licensed Aerial Drone Cinematography, DaVinci Resolve RAW Color Grading', 'accent' => 'red'),
                2 => array('title' => 'Photography', 'tag' => 'EDITORIAL · PRODUCT · PRESS KITS', 'desc' => 'High-impact brand lookbooks, studio & on-location portraits, artist press photos, commercial product photography, and retouching.', 'subtags' => 'Brand & Fashion Lookbooks, Artist & Musician Press Stills, Commercial Product Photography, High-Resolution Retouching', 'accent' => 'yellow'),
                3 => array('title' => 'Branding & Graphic Design', 'tag' => 'IDENTITY · LOGOS · PACKAGING', 'desc' => 'Memorable logo systems, typography, brand guidelines, merch & apparel graphics, album artwork, and physical packaging.', 'subtags' => 'Logo & Wordmark Systems, Complete Brand Guidelines, Apparel & Merch Graphics, Album Art & Print Packaging', 'accent' => 'lime'),
                4 => array('title' => 'Web Design & Development', 'tag' => 'CUSTOM SITES · E-COMMERCE · UI/UX', 'desc' => 'Fast, modern, custom-designed websites, artist & agency portfolios, landing pages, and WooCommerce / Shopify storefronts.', 'subtags' => 'Custom WordPress & Web Builds, E-Commerce Storefronts, Responsive UI/UX Design, High-Converting Landing Pages', 'accent' => 'blue'),
                5 => array('title' => 'Music & Audio Production', 'tag' => 'RECORDING · MIXING · SOUND DESIGN', 'desc' => 'Original music production, custom scoring for film & commercials, vocal mixing, mastering, and clean audio post-production.', 'subtags' => 'Original Music & Custom Scoring, Studio Mixing & Mastering, Commercial Sound Design, Dialogue & Audio Post-Production', 'accent' => 'red'),
            );
            ?>
            <div class="services-grid">
                <?php foreach ($services_defaults as $idx => $srv) :
                    $s_title   = get_theme_mod("mileym3dia_service_{$idx}_title", $srv['title']);
                    $s_tag     = get_theme_mod("mileym3dia_service_{$idx}_tag", $srv['tag']);
                    $s_desc    = get_theme_mod("mileym3dia_service_{$idx}_desc", $srv['desc']);
                    $s_subtags = array_filter(array_map('trim', explode(',', get_theme_mod("mileym3dia_service_{$idx}_subtags", $srv['subtags']))));
                    $accent    = $srv['accent'];
                ?>
                    <article class="service-card service-card--<?php echo esc_attr($accent); ?>">
                        <div class="service-card-header">
                            <span class="service-card-num">0<?php echo (int) $idx; ?></span>
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
                            <a href="<?php echo esc_url(add_query_arg('discipline', rawurlencode($s_title), mileym3dia_get_page_url('contact'))); ?>" class="service-card-action">
                                <span><?php printf(esc_html__('BOOK %s', 'mileym3dia'), esc_html(strtoupper($s_title))); ?></span>
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
                <span class="section-label text-yellow">TRANSPARENT PRODUCTION PRICING</span>
                <h2 class="section-title section-title--xl">PACKAGES &amp; CUSTOM BUNDLES</h2>
                <p class="section-header-desc pricing-header-desc">
                    Choose a ready-to-shoot package or switch to the Interactive Bundle Builder to mix and match individual services from $95.
                </p>

                <!-- Interactive Tab Switcher -->
                <div class="pricing-tabs-nav" role="tablist" aria-label="<?php esc_attr_e('Pricing View Options', 'mileym3dia'); ?>">
                    <button type="button" class="pricing-tab-btn active" id="tabBtnPackages" data-tab="packages" role="tab" aria-selected="true" aria-controls="viewPackages">
                        <span class="tab-badge">01</span>
                        <span class="tab-label">CURATED PACKAGES</span>
                        <span class="tab-meta text-yellow">$350 – $1,450</span>
                    </button>
                    <button type="button" class="pricing-tab-btn" id="tabBtnBundle" data-tab="bundle" role="tab" aria-selected="false" aria-controls="viewBundle">
                        <span class="tab-badge">02</span>
                        <span class="tab-label">CUSTOM BUNDLE BUILDER</span>
                        <span class="tab-meta text-lime">SAVE 10% (3+ SERVICES)</span>
                    </button>
                </div>
            </div>

            <!-- TAB 1: CURATED PACKAGES -->
            <div class="pricing-view-panel active" id="viewPackages" role="tabpanel" aria-labelledby="tabBtnPackages">
                <?php mileym3dia_render_pricing_packages(); ?>

                <div class="pricing-switch-banner">
                    <div class="switch-banner-content">
                        <span class="switch-banner-tag text-lime">LOOKING FOR INDIVIDUAL DELIVERABLES?</span>
                        <p class="switch-banner-text">
                            Need a single vertical reel ($95), cover art ($125), vocal mix ($150), or photo session ($225)? Mix &amp; match your own bundle.
                        </p>
                    </div>
                    <button type="button" class="btn btn--accent-lime js-open-bundle-tab">
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
            <span class="contact-eyebrow text-lime">CUSTOM SCOPES AVAILABLE</span>
            <h2 class="contact-headline">NEED A CUSTOM PRODUCTION QUOTE?</h2>
            <p class="contact-subhead">Tell us what you are building and we will put together a tailored production plan and budget.</p>
            <div class="hero-action-buttons" style="justify-content:center; margin-top:2rem;">
                <a href="<?php echo esc_url(mileym3dia_get_page_url('contact')); ?>" class="btn btn--accent-lime">
                    <span class="btn-text"><?php esc_html_e('REQUEST A CUSTOM QUOTE', 'mileym3dia'); ?></span>
                    <span class="btn-arrow">↗</span>
                </a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>

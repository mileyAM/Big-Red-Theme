<?php
/**
 * Template Name: Portfolio / Work
 * Description: Selected work and portfolio showcase page template.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$portfolio_hero_bg = '';
if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {
    $portfolio_hero_bg = get_the_post_thumbnail_url(get_the_ID(), 'full');
}
?>

<main id="primary" class="site-main portfolio-page-main">

    <!-- FULL-WIDTH PORTFOLIO HEADER -->
    <section class="page-title-section portfolio-hero-section bg-shade-base"<?php echo !empty($portfolio_hero_bg) ? ' style="background-image: linear-gradient(180deg, rgba(6,6,9,0.78) 0%, rgba(6,6,9,0.95) 100%), url(\'' . esc_url($portfolio_hero_bg) . '\'); background-size: cover; background-position: center;"' : ''; ?>>
        <div class="container container--wide">
            <div class="portfolio-hero-header">
                <span class="page-subtitle text-red"><?php echo esc_html(get_theme_mod('mileym3dia_portfolio_eyebrow', '02 / SELECTED WORK')); ?></span>
                <?php
                $portfolio_raw_title = get_theme_mod('mileym3dia_portfolio_hero_title', get_theme_mod('mileym3dia_portfolio_title', 'FEATURED PRODUCTIONS'));
                if (strpos($portfolio_raw_title, '<') === false) {
                    $words = explode(' ', trim($portfolio_raw_title));
                    if (count($words) > 1) {
                        $last_word = array_pop($words);
                        $portfolio_title_html = esc_html(implode(' ', $words)) . ' <span class="text-red">' . esc_html($last_word) . '</span>';
                    } else {
                        $portfolio_title_html = '<span class="text-red">' . esc_html($portfolio_raw_title) . '</span>';
                    }
                } else {
                    $portfolio_title_html = wp_kses_post($portfolio_raw_title);
                }
                ?>
                <h1 class="page-title page-title--mega">
                    <?php echo $portfolio_title_html; ?>
                </h1>
                <p class="page-lead">
                    <?php echo esc_html(get_theme_mod('mileym3dia_portfolio_desc', 'Recent commercial films, music videos, brand identity systems, web builds, and photography campaigns.')); ?>
                </p>
            </div>
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

    <!-- PORTFOLIO GALLERY & CATEGORY FILTER -->
    <section class="portfolio-gallery-section section-loose bg-shade-elevated">
        <div class="container container--wide">

            <div class="portfolio-filter-bar">
                <span class="filter-bar-label">FILTER BY SERVICE:</span>
                <div class="portfolio-filter-buttons" id="portfolioFilterButtons">
                    <button type="button" class="filter-btn active" data-filter="all">ALL WORK</button>
                    <button type="button" class="filter-btn" data-filter="video-production">VIDEO PRODUCTION</button>
                    <button type="button" class="filter-btn" data-filter="photography">PHOTOGRAPHY</button>
                    <button type="button" class="filter-btn" data-filter="branding-design">BRANDING &amp; DESIGN</button>
                    <button type="button" class="filter-btn" data-filter="web-design">WEB DESIGN</button>
                    <button type="button" class="filter-btn" data-filter="music-audio">MUSIC &amp; AUDIO</button>
                </div>
            </div>

            <div class="portfolio-cinematic-grid" id="portfolioGrid">
                <?php
                $accent_cycle = array('red', 'yellow', 'lime', 'blue');
                $accent_map   = array(
                    'video-production' => 'red',
                    'video'            => 'red',
                    'photography'      => 'blue',
                    'photo'            => 'blue',
                    'branding-design'  => 'lime',
                    'branding'         => 'lime',
                    'web-design'       => 'yellow',
                    'web'              => 'yellow',
                    'music-audio'      => 'yellow',
                    'audio'            => 'yellow',
                );
                $portfolio_count = max(1, (int) get_theme_mod('mileym3dia_portfolio_count', 12));
                // If default 4 is stored in Customizer for homepage, allow up to 12 on the full Portfolio page unless explicitly set higher
                $query_limit     = ($portfolio_count === 4) ? 12 : $portfolio_count;

                $portfolio_query = null;
                if (mileym3dia_has_projects()) {
                    $portfolio_query = new WP_Query(array(
                        'post_type'      => 'project',
                        'posts_per_page' => $query_limit,
                        'post_status'    => 'publish',
                        'orderby'        => array('menu_order' => 'ASC', 'ID' => 'ASC'),
                    ));
                }

                if ($portfolio_query && $portfolio_query->have_posts()) :
                    $counter = 1;
                    while ($portfolio_query->have_posts()) :
                        $portfolio_query->the_post();
                        $pid          = get_the_ID();
                        $terms        = get_the_terms($pid, 'project_category');
                        $filter_tokens = array();
                        $cat_names     = array();
                        $first_slug    = '';

                        if ($terms && !is_wp_error($terms)) {
                            foreach ($terms as $t) {
                                $cat_names[] = strtoupper($t->name);
                                if ('' === $first_slug) {
                                    $first_slug = $t->slug;
                                }
                                if (function_exists('mileym3dia_get_project_category_filter_tokens')) {
                                    $filter_tokens = array_merge($filter_tokens, mileym3dia_get_project_category_filter_tokens($t->slug));
                                } else {
                                    $filter_tokens[] = $t->slug;
                                }
                            }
                        }

                        if (empty($filter_tokens)) {
                            $filter_tokens = array('video-production', 'video');
                        }
                        $filter_attr = implode(' ', array_unique($filter_tokens));
                        $cat_name    = !empty($cat_names) ? implode(' & ', array_slice($cat_names, 0, 2)) : 'VIDEO PRODUCTION';

                        $custom_accent = get_post_meta($pid, '_project_accent', true);
                        if (!empty($custom_accent)) {
                            $accent = $custom_accent;
                        } elseif ($first_slug && isset($accent_map[$first_slug])) {
                            $accent = $accent_map[$first_slug];
                        } else {
                            $accent = $accent_cycle[($counter - 1) % 4];
                        }

                        $year   = get_post_meta($pid, '_project_year', true) ?: get_the_date('Y');
                        $client = get_post_meta($pid, '_project_client', true);
                ?>
                    <article class="portfolio-card" data-category="<?php echo esc_attr($filter_attr); ?>">
                        <div class="card-inner">
                            <div class="card-media">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('mileym3dia-large', array('class' => 'card-image')); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url(mileym3dia_get_project_image_url($counter)); ?>" alt="<?php the_title_attribute(); ?>" class="card-image" loading="lazy" />
                                <?php endif; ?>
                                <div class="card-overlay-gradient"></div>
                                <div class="card-corner-badge card-corner-badge--<?php echo esc_attr($accent); ?>">
                                    <span><?php echo esc_html($year); ?></span>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-meta">
                                    <span class="card-index"><?php echo str_pad($counter, 2, '0', STR_PAD_LEFT); ?></span>
                                    <span class="card-category text-<?php echo esc_attr($accent); ?>"><?php echo esc_html($cat_name); ?></span>
                                </div>
                                <h3 class="card-title"><?php the_title(); ?></h3>
                                <p class="card-desc"><?php echo esc_html(mileym3dia_custom_excerpt(20)); ?></p>
                                <?php if ($client) : ?>
                                    <div class="card-client-tag">
                                        <span class="tag-label">CLIENT:</span> <?php echo esc_html($client); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="card-footer-cta">
                                    <a href="<?php the_permalink(); ?>" class="card-link-action">
                                        <span>VIEW CASE STUDY</span>
                                        <span class="arrow">↗</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php
                        $counter++;
                    endwhile;
                    wp_reset_postdata();
                else :
                    $fallback_items = array(
                        1 => array('slug' => 'nightfall-apparel-campaign', 'title' => 'NIGHTFALL APPAREL CAMPAIGN', 'cat' => 'VIDEO PRODUCTION & PHOTOGRAPHY', 'filter' => 'video-production video photography photo', 'year' => '2026', 'client' => 'NIGHTFALL ATELIER', 'desc' => 'Full commercial video production, street lookbook photography, and social campaign rollout.', 'accent' => 'red'),
                        2 => array('slug' => 'static-frequency-tour-visuals', 'title' => 'STATIC FREQUENCY TOUR & VISUALS', 'cat' => 'MUSIC & AUDIO PRODUCTION', 'filter' => 'music-audio audio video-production video', 'year' => '2026', 'client' => 'STATIC FREQUENCY', 'desc' => 'Music video direction, custom live tour visuals, and surround audio mastering.', 'accent' => 'yellow'),
                        3 => array('slug' => 'monolith-audio-hardware', 'title' => 'MONOLITH AUDIO HARDWARE', 'cat' => 'BRANDING & WEB DESIGN', 'filter' => 'branding-design branding web-design web', 'year' => '2025', 'client' => 'MONOLITH LABS', 'desc' => 'Complete visual identity, custom typography, packaging design, and e-commerce web design.', 'accent' => 'lime'),
                        4 => array('slug' => 'apex-motorsport-identity', 'title' => 'APEX MOTORSPORT IDENTITY', 'cat' => 'PHOTOGRAPHY & BRANDING', 'filter' => 'photography photo branding-design branding', 'year' => '2025', 'client' => 'APEX RACING CO.', 'desc' => 'Custom brand identity system, team apparel graphics, and trackside photography.', 'accent' => 'blue'),
                    );
                    foreach ($fallback_items as $idx => $item) :
                        $p_title = get_theme_mod("mileym3dia_proj_{$idx}_title", $item['title']);
                        $p_cat   = get_theme_mod("mileym3dia_proj_{$idx}_cat", $item['cat']);
                        $p_year  = get_theme_mod("mileym3dia_proj_{$idx}_year", $item['year']);
                        $p_desc  = get_theme_mod("mileym3dia_proj_{$idx}_desc", $item['desc']);
                        $p_img   = mileym3dia_get_project_image_url($idx);
                        $p_url   = mileym3dia_get_project_url($item['slug']);
                ?>
                    <article class="portfolio-card" data-category="<?php echo esc_attr($item['filter']); ?>">
                        <div class="card-inner">
                            <div class="card-media">
                                <img src="<?php echo esc_url($p_img); ?>" alt="<?php echo esc_attr($p_title); ?>" class="card-image" loading="lazy" />
                                <div class="card-overlay-gradient"></div>
                                <div class="card-corner-badge card-corner-badge--<?php echo esc_attr($item['accent']); ?>">
                                    <span><?php echo esc_html($p_year); ?></span>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-meta">
                                    <span class="card-index">0<?php echo (int) $idx; ?></span>
                                    <span class="card-category text-<?php echo esc_attr($item['accent']); ?>"><?php echo esc_html($p_cat); ?></span>
                                </div>
                                <h3 class="card-title"><?php echo esc_html($p_title); ?></h3>
                                <p class="card-desc"><?php echo esc_html($p_desc); ?></p>
                                <div class="card-client-tag">
                                    <span class="tag-label">CLIENT:</span> <?php echo esc_html($item['client']); ?>
                                </div>
                                <div class="card-footer-cta">
                                    <a href="<?php echo esc_url($p_url); ?>" class="card-link-action">
                                        <span>VIEW CASE STUDY</span>
                                        <span class="arrow">↗</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- CONTACT CTA -->
    <section class="contact-cta section-loose bg-shade-base">
        <div class="container container--wide cta-content text-center">
            <span class="contact-eyebrow text-red">START YOUR PRODUCTION</span>
            <h2 class="contact-headline"><?php echo esc_html(get_theme_mod('mileym3dia_contact_cta', "LET'S BUILD YOUR NEXT PROJECT.")); ?></h2>
            <p class="contact-subhead">Ready to shoot a commercial, music video, photo lookbook, or launch a new brand identity and website?</p>
            <div class="hero-action-buttons" style="justify-content:center; margin-top:2rem;">
                <a href="<?php echo esc_url(mileym3dia_get_page_url('contact')); ?>" class="btn btn--streetwear-red">
                    <span class="btn-text"><?php esc_html_e('START A PROJECT', 'mileym3dia'); ?></span>
                    <span class="btn-arrow">↗</span>
                </a>
                <a href="<?php echo esc_url(mileym3dia_get_pricing_page_url()); ?>" class="btn btn--streetwear-outline">
                    <span class="btn-text"><?php esc_html_e('VIEW PACKAGES & PRICING', 'mileym3dia'); ?></span>
                </a>
            </div>
        </div>
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var filterBtns = document.querySelectorAll('#portfolioFilterButtons .filter-btn');
    var cards = document.querySelectorAll('#portfolioGrid .portfolio-card');

    filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            filterBtns.forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');

            var filterValue = btn.getAttribute('data-filter');
            cards.forEach(function(card) {
                var cat = (card.getAttribute('data-category') || '').toLowerCase();
                if (filterValue === 'all' || cat.indexOf(filterValue) !== -1) {
                    card.style.display = '';
                    card.style.opacity = '1';
                } else {
                    card.style.display = 'none';
                    card.style.opacity = '0';
                }
            });
        });
    });
});
</script>

<?php get_footer(); ?>

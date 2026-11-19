<?php
/**
 * Project Archive Template
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main portfolio-page-main">

    <!-- FULL-WIDTH PORTFOLIO ARCHIVE HEADER -->
    <section class="page-title-section portfolio-hero-section bg-shade-base">
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
                <h1 class="page-title page-title--mega"><?php echo $portfolio_title_html; ?></h1>
                <?php
                $taxonomy = get_query_var('project_category');
                $term_desc = '';
                if ($taxonomy) {
                    $term = get_term_by('slug', $taxonomy, 'project_category');
                    if ($term && !is_wp_error($term) && !empty($term->description)) {
                        $term_desc = $term->description;
                    }
                }
                ?>
                <p class="page-lead">
                    <?php echo esc_html($term_desc ?: get_theme_mod('mileym3dia_portfolio_desc', 'Recent commercial films, music videos, brand identity systems, web builds, and photography campaigns.')); ?>
                </p>
            </div>
        </div>
    </section>

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
                $count = max(1, (int) get_theme_mod('mileym3dia_portfolio_count', 12));
                $query_limit = ($count === 4) ? 12 : $count;

                $args = array(
                    'post_type'      => 'project',
                    'posts_per_page' => $query_limit,
                    'post_status'    => 'publish',
                    'orderby'        => array('menu_order' => 'ASC', 'ID' => 'ASC'),
                    'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
                );
                if (!empty($taxonomy)) {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'project_category',
                            'field'    => 'slug',
                            'terms'    => $taxonomy,
                        ),
                    );
                }

                $project_query = mileym3dia_has_projects() ? new WP_Query($args) : null;

                if ($project_query && $project_query->have_posts()) :
                    $counter = 1;
                    while ($project_query->have_posts()) :
                        $project_query->the_post();
                        $pid           = get_the_ID();
                        $terms         = get_the_terms($pid, 'project_category');
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

                    echo '<div class="pagination-wrapper">';
                    echo paginate_links(array(
                        'total'   => $project_query->max_num_pages,
                        'current' => max(1, get_query_var('paged')),
                    ));
                    echo '</div>';

                    wp_reset_postdata();
                else :
                ?>
                    <div class="no-projects">
                        <p><?php esc_html_e('No projects found. Coming soon.', 'mileym3dia'); ?></p>
                    </div>
                <?php endif; ?>
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

<?php
get_footer();

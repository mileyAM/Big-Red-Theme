<?php
/**
 * Blog Home / Archive Template
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);

global $wp_query;
$m3_orig_query = null;
if (is_page()) {
    $m3_orig_query = $wp_query;
    $wp_query = new WP_Query(array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'paged'               => $paged,
        'ignore_sticky_posts' => 1,
    ));
}
?>

<main id="primary" class="site-main blog-main">

    <!-- OFFICIAL MILEYM3DIA BLOG BANNER (VISION MEETS EXECUTION — RED / NEUTRAL ACCENT) -->
    <?php
    ob_start();
    ?>
    <div class="blog-category-nav">
        <span class="category-nav-label">TOPICS:</span>
        <ul class="category-pills">
            <li class="category-pill active">
                <a href="<?php echo esc_url(mileym3dia_get_blog_page_url()); ?>">ALL ARTICLES</a>
            </li>
            <?php
            $categories = get_categories(array(
                'orderby'    => 'count',
                'order'      => 'DESC',
                'number'     => 6,
                'hide_empty' => 1,
            ));
            if (!empty($categories)) :
                foreach ($categories as $cat) :
            ?>
                    <li class="category-pill">
                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
                            <?php echo esc_html(strtoupper($cat->name)); ?>
                            <span class="pill-count"><?php echo esc_html($cat->count); ?></span>
                        </a>
                    </li>
            <?php
                endforeach;
            endif;
            ?>
        </ul>
    </div>
    <?php
    $blog_cats_html = ob_get_clean();
    if (function_exists('mileym3dia_render_page_banner')) {
        mileym3dia_render_page_banner('blog', array(
            'heading_tag'      => 'h1',
            'override_eyebrow' => get_theme_mod('mileym3dia_blog_section_eyebrow', '04 / STUDIO JOURNAL'),
            'extra_html'       => $blog_cats_html,
        ));
    }
    ?>

    <div class="container container--wide blog-container section-loose">

        <?php if (have_posts()) : ?>

            <?php
            if (1 === (int) $paged) :
                the_post();
                $featured_id     = get_the_ID();
                $featured_thumb  = get_the_post_thumbnail($featured_id, 'mileym3dia-large', array('class' => 'featured-hero-img'));
                $featured_cats   = get_the_category($featured_id);
                $featured_author = get_the_author_meta('display_name');
                $featured_date   = get_the_date();
            ?>
                <section class="blog-featured-spotlight">
                    <div class="featured-spotlight-card">
                        <div class="featured-spotlight-media">
                            <a href="<?php the_permalink(); ?>" class="featured-spotlight-media-link" aria-label="<?php the_title_attribute(); ?>">
                                <?php if ($featured_thumb) : ?>
                                    <?php echo $featured_thumb; ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url(mileym3dia_get_blog_image_url(1)); ?>" alt="<?php the_title_attribute(); ?>" class="featured-hero-img" />
                                <?php endif; ?>
                                <div class="featured-spotlight-overlay"></div>
                                <div class="card-corner-badge card-corner-badge--blue">
                                    <span>FEATURED ARTICLE</span>
                                </div>
                            </a>
                        </div>
                        <div class="featured-spotlight-content">
                            <div class="featured-spotlight-top">
                                <span class="featured-badge text-blue">FEATURED STORY</span>
                                <?php if ($featured_cats) : ?>
                                    <a href="<?php echo esc_url(get_category_link($featured_cats[0]->term_id)); ?>" class="featured-cat-pill">
                                        <?php echo esc_html($featured_cats[0]->name); ?>
                                    </a>
                                <?php endif; ?>
                                <span class="featured-read-time"><?php echo esc_html(mileym3dia_reading_time($featured_id)); ?></span>
                            </div>

                            <h2 class="featured-spotlight-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <p class="featured-spotlight-excerpt">
                                <?php echo esc_html(mileym3dia_custom_excerpt(32)); ?>
                            </p>

                            <div class="featured-spotlight-footer">
                                <div class="featured-author-meta">
                                    <div class="author-info">
                                        <span class="author-name"><?php echo esc_html($featured_author); ?></span>
                                        <span class="post-date"><?php echo esc_html($featured_date); ?></span>
                                    </div>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="btn btn--streetwear-red">
                                    <span class="btn-text"><?php echo esc_html(get_theme_mod('mileym3dia_blog_read_more_text', 'READ ARTICLE')); ?></span>
                                    <span class="btn-arrow">↗</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <div class="blog-layout-wrap">
                <div class="blog-main-content">
                    <div class="blog-feed-header">
                        <span class="feed-count">
                            <?php
                            global $wp_query;
                            printf(esc_html__('%d ARTICLES PUBLISHED', 'mileym3dia'), $wp_query->found_posts);
                            ?>
                        </span>
                        <div class="feed-line"></div>
                    </div>

                    <div class="blog-card-grid">
                        <?php
                        while (have_posts()) :
                            the_post();
                            if (1 === (int) $paged && isset($featured_id) && get_the_ID() === $featured_id) {
                                continue;
                            }
                            mileym3dia_blog_card(get_the_ID());
                        endwhile;
                        ?>
                    </div>

                    <div class="blog-pagination-wrap">
                        <?php mileym3dia_pagination(); ?>
                    </div>
                </div>

                <div class="blog-sidebar-wrap">
                    <?php get_sidebar(); ?>
                </div>
            </div>

        <?php else : ?>
            <div class="blog-empty-state">
                <span class="empty-badge">NO ARTICLES YET</span>
                <h2><?php esc_html_e('No Articles Published Yet', 'mileym3dia'); ?></h2>
                <p><?php esc_html_e('Articles and studio insights will appear here once published in WordPress.', 'mileym3dia'); ?></p>
                <div class="empty-search">
                    <?php get_search_form(); ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

</main>

<?php
get_footer();

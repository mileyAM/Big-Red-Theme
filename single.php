<?php
/**
 * Single Post Template
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main single-post-main">

    <?php while (have_posts()) : the_post(); ?>

        <?php
        $single_id = get_the_ID();
        if (has_post_thumbnail()) {
            $hero_img_url = get_the_post_thumbnail_url($single_id, 'full');
        } else {
            $fallback_idx = (($single_id % 3) === 0) ? '3' : ((($single_id % 2) === 0) ? '2' : '1');
            $hero_img_url = get_template_directory_uri() . '/assets/images/blog-' . $fallback_idx . '.jpg';
        }
        if (empty($hero_img_url)) {
            $hero_img_url = get_template_directory_uri() . '/assets/images/blog-1.jpg';
        }
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('single-article-entry'); ?>>
            <header class="single-post-hero" style="background-image: url('<?php echo esc_url($hero_img_url); ?>');">
                <div class="single-post-hero__overlay" aria-hidden="true"></div>
                <div class="container container--wide single-post-hero__inner">
                    <div class="single-post-top-meta">
                        <div class="single-breadcrumbs">
                            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('HOME', 'mileym3dia'); ?></a>
                            <span class="crumb-sep">/</span>
                            <a href="<?php echo esc_url(mileym3dia_get_blog_page_url()); ?>"><?php esc_html_e('BLOG', 'mileym3dia'); ?></a>
                            <?php
                            $categories = get_the_category();
                            if ($categories) :
                            ?>
                                <span class="crumb-sep">/</span>
                                <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>"><?php echo esc_html(strtoupper($categories[0]->name)); ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="single-reading-badge">
                            <span class="single-reading-time"><?php echo esc_html(mileym3dia_reading_time()); ?></span>
                        </div>
                    </div>

                    <h1 class="single-post-title"><?php the_title(); ?></h1>

                    <div class="single-post-meta-bar">
                        <div class="single-author-badge">
                            <div class="author-details">
                                <span class="author-label"><?php esc_html_e('WRITTEN BY', 'mileym3dia'); ?></span>
                                <span class="author-name"><?php the_author(); ?></span>
                            </div>
                        </div>
                        <div class="meta-divider"></div>
                        <div class="single-date-badge">
                            <span class="meta-label"><?php esc_html_e('PUBLISHED', 'mileym3dia'); ?></span>
                            <span class="meta-value"><?php echo esc_html(get_the_date()); ?></span>
                        </div>
                        <?php if (comments_open() || get_comments_number()) : ?>
                            <div class="meta-divider"></div>
                            <div class="single-comments-badge">
                                <span class="meta-label"><?php esc_html_e('COMMENTS', 'mileym3dia'); ?></span>
                                <a href="#comments" class="meta-value"><?php comments_number('0 Comments', '1 Comment', '% Comments'); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </header>

            <div class="container container--wide blog-container section-loose">
                <div class="blog-layout-wrap">
                    <div class="blog-main-content single-content-area">
                        <div class="entry-content reading-column">
                            <?php
                            the_content(sprintf(
                                wp_kses(
                                    __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'mileym3dia'),
                                    array('span' => array('class' => array()))
                                ),
                                wp_kses_post(get_the_title())
                            ));

                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'mileym3dia'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>

                        <?php
                        $tags = get_the_tags();
                        if ($tags) :
                        ?>
                            <footer class="single-post-footer">
                                <div class="post-tags-wrap">
                                    <span class="tags-label"><?php esc_html_e('TOPICS:', 'mileym3dia'); ?></span>
                                    <div class="post-tags-list">
                                        <?php foreach ($tags as $tag) : ?>
                                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-pill">
                                                #<?php echo esc_html($tag->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </footer>
                        <?php endif; ?>

                        <div class="single-author-card">
                            <div class="author-card-avatar">
                                <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                            </div>
                            <div class="author-card-bio">
                                <span class="author-card-eyebrow text-blue">ABOUT THE AUTHOR</span>
                                <h3 class="author-card-name"><?php the_author(); ?></h3>
                                <p class="author-card-desc">
                                    <?php
                                    $bio = get_the_author_meta('description');
                                    echo esc_html($bio ?: 'Creative production team at MILEYM3DIA specializing in video production, photography, brand identity, web design, and studio audio.');
                                    ?>
                                </p>
                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="author-card-link">
                                    <?php esc_html_e('VIEW ALL ARTICLES', 'mileym3dia'); ?> ↗
                                </a>
                            </div>
                        </div>

                        <?php
                        the_post_navigation(array(
                            'prev_text' => '<span class="nav-direction">← ' . esc_html__('PREVIOUS ARTICLE', 'mileym3dia') . '</span><span class="nav-title">%title</span>',
                            'next_text' => '<span class="nav-direction">' . esc_html__('NEXT ARTICLE', 'mileym3dia') . ' →</span><span class="nav-title">%title</span>',
                        ));
                        ?>

                        <?php mileym3dia_related_posts(get_the_ID(), 3); ?>

                        <?php
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                        ?>
                    </div>

                    <div class="blog-sidebar-wrap">
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            </div>
        </article>

    <?php endwhile; ?>

</main>

<?php
get_footer();

<?php
/**
 * Search Results Template
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main blog-main">

    <section class="page-title-section blog-title-section bg-shade-base">
        <div class="container container--wide">
            <div class="blog-title-header">
                <div class="blog-title-left">
                    <span class="page-subtitle text-blue">EXPLORE ARCHIVE</span>
                    <h1 class="page-title page-title--mega">
                        SEARCH <span class="text-blue">RESULTS:</span> &ldquo;<?php echo esc_html(get_search_query()); ?>&rdquo;
                    </h1>
                </div>
            </div>

            <div class="blog-breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('HOME', 'mileym3dia'); ?></a>
                <span class="breadcrumb-sep">/</span>
                <a href="<?php echo esc_url(mileym3dia_get_blog_page_url()); ?>"><?php esc_html_e('BLOG', 'mileym3dia'); ?></a>
                <span class="breadcrumb-sep">/</span>
                <span class="breadcrumb-current"><?php printf(esc_html__('SEARCH: %s', 'mileym3dia'), esc_html(get_search_query())); ?></span>
            </div>
        </div>
    </section>

    <div class="container container--wide blog-container section-loose">
        <div class="blog-layout-wrap">
            <div class="blog-main-content">
                <?php if (have_posts()) : ?>
                    <div class="blog-card-grid">
                        <?php
                        while (have_posts()) :
                            the_post();
                            mileym3dia_blog_card(get_the_ID());
                        endwhile;
                        ?>
                    </div>

                    <div class="blog-pagination-wrap">
                        <?php mileym3dia_pagination(); ?>
                    </div>
                <?php else : ?>
                    <div class="blog-empty-state">
                        <span class="empty-badge">NO MATCHES</span>
                        <h2><?php esc_html_e('No Matches Found', 'mileym3dia'); ?></h2>
                        <p><?php esc_html_e('No articles or pages matched your search terms. Try refining your keywords or browse by category.', 'mileym3dia'); ?></p>
                        <div class="empty-search">
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="blog-sidebar-wrap">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>

</main>

<?php
get_footer();

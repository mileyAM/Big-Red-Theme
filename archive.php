<?php
/**
 * Category, Tag, and Author Archive Template
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
                    <span class="page-subtitle text-blue">
                        <?php
                        if (is_category()) {
                            echo 'CATEGORY ARCHIVE';
                        } elseif (is_tag()) {
                            echo 'TOPIC ARCHIVE';
                        } elseif (is_author()) {
                            echo 'AUTHOR ARCHIVE';
                        } else {
                            echo 'STUDIO JOURNAL';
                        }
                        ?>
                    </span>
                    <h1 class="page-title page-title--mega">
                        <?php
                        if (is_category()) {
                            single_cat_title();
                        } elseif (is_tag()) {
                            echo '#' . single_tag_title('', false);
                        } elseif (is_author()) {
                            echo esc_html(get_the_author());
                        } else {
                            the_archive_title();
                        }
                        ?>
                    </h1>
                </div>
                <div class="blog-title-right">
                    <?php if (get_the_archive_description()) : ?>
                        <div class="archive-description-text">
                            <?php the_archive_description(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="blog-breadcrumb">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('HOME', 'mileym3dia'); ?></a>
                <span class="breadcrumb-sep">/</span>
                <a href="<?php echo esc_url(mileym3dia_get_blog_page_url()); ?>"><?php esc_html_e('BLOG', 'mileym3dia'); ?></a>
                <span class="breadcrumb-sep">/</span>
                <span class="breadcrumb-current"><?php echo esc_html(single_term_title('', false) ?: get_the_archive_title()); ?></span>
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
                        <span class="empty-badge">NO ARTICLES FOUND</span>
                        <h2><?php esc_html_e('No Articles Found in this Archive', 'mileym3dia'); ?></h2>
                        <p><?php esc_html_e('Try searching for another topic or browse the full blog archive.', 'mileym3dia'); ?></p>
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

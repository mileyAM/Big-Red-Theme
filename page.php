<?php
/**
 * Page Template
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        <section class="page-title-section">
            <div class="container">
                <span class="page-subtitle">[ PAGE ]</span>
                <h1 class="page-title"><?php the_title(); ?></h1>
            </div>
        </section>

        <section class="section-loose">
            <div class="container">
                <article id="post-<?php the_ID(); ?>" <?php post_class('entry-content'); ?>>
                    <?php the_content(); ?>
                    
                    <?php if (comments_open() || get_comments_number()) : ?>
                        <div class="comments-area">
                            <?php comments_template(); ?>
                        </div>
                    <?php endif; ?>
                </article>
            </div>
        </section>
    <?php endwhile; ?>
</main>

<?php
get_footer();

<?php
/**
 * Main Template File
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main">
    <div class="page-container">
        <?php
        while (have_posts()) :
            the_post();
            get_template_part('template-parts/content', get_post_type());
        endwhile;

        mileym3dia_pagination();
        ?>
    </div>
</main>

<?php
get_footer();

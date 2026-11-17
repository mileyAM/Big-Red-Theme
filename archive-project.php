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

<main id="primary" class="site-main">
    <header class="archive-header portfolio-header">
        <?php
        $portfolio_title = get_theme_mod('mileym3dia_portfolio_title', 'SELECTED WORK');
        if (strpos($portfolio_title, '<') === false) {
            $words = explode(' ', trim($portfolio_title));
            if (count($words) > 1) {
                $last = array_pop($words);
                $title_html = esc_html(implode(' ', $words)) . ' <span class="text-red">' . esc_html($last) . '</span>';
            } else {
                $title_html = '<span class="text-red">' . esc_html($portfolio_title) . '</span>';
            }
        } else {
            $title_html = wp_kses_post($portfolio_title);
        }
        ?>
        <h1 class="archive-title"><?php echo $title_html; ?></h1>
        
        <?php
        $taxonomy = get_query_var('project_category');
        if ($taxonomy) {
            $term = get_term_by('slug', $taxonomy, 'project_category');
            if ($term && !is_wp_error($term)) {
                echo '<p class="archive-description">' . esc_html($term->description) . '</p>';
            }
        }
        ?>
    </header>
    
    <div class="portfolio-grid">
        <?php
        $count = get_theme_mod('mileym3dia_portfolio_count', 6);
        $args = array(
            'post_type'      => 'project',
            'posts_per_page' => $count,
            'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
        );
        
        $project_query = mileym3dia_has_projects() ? new WP_Query($args) : null;
        
        if ($project_query && $project_query->have_posts()) :
            while ($project_query->have_posts()) : $project_query->the_post();
                mileym3dia_portfolio_item(get_the_ID());
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
</main>

<?php
get_footer();

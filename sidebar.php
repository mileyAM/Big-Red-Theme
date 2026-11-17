<?php
/**
 * The sidebar containing the main blog widget area
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!get_theme_mod('mileym3dia_blog_sidebar', true)) {
    return;
}
?>

<aside id="secondary" class="widget-area blog-sidebar" role="complementary" aria-label="<?php esc_attr_e('Blog Sidebar', 'mileym3dia'); ?>">

    <!-- 01. SEARCH INSIGHTS -->
    <section id="sidebar-search" class="widget widget_search widget--accent-red">
        <h3 class="widget-title"><?php esc_html_e('SEARCH INSIGHTS', 'mileym3dia'); ?></h3>
        <form role="search" method="get" class="search-form m3-sidebar-search" action="<?php echo esc_url(home_url('/')); ?>">
            <label class="screen-reader-text" for="m3-sidebar-search-input"><?php esc_html_e('Search for:', 'mileym3dia'); ?></label>
            <input type="search" id="m3-sidebar-search-input" class="search-field" placeholder="<?php esc_attr_e('Search articles, tips, gear...', 'mileym3dia'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s" />
            <button type="submit" class="search-submit"><?php esc_html_e('GO', 'mileym3dia'); ?></button>
        </form>
    </section>

    <!-- 02. STUDIO CATEGORIES -->
    <section id="sidebar-categories" class="widget widget_categories widget--accent-blue">
        <h3 class="widget-title"><?php esc_html_e('STUDIO CATEGORIES', 'mileym3dia'); ?></h3>
        <ul class="m3-cat-list">
            <?php
            $cat_dots = array('red', 'blue', 'lime', 'purple', 'yellow', 'blue');
            $cats = get_categories(array(
                'orderby'    => 'count',
                'order'      => 'DESC',
                'number'     => 6,
                'hide_empty' => 0,
            ));
            if (!empty($cats)) :
                foreach ($cats as $c_idx => $cat) :
                    $dot_color = $cat_dots[$c_idx % count($cat_dots)];
            ?>
                    <li class="m3-cat-item m3-cat-item--<?php echo esc_attr($dot_color); ?>">
                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
                            <span class="m3-cat-left">
                                <span class="m3-cat-dot" aria-hidden="true"></span>
                                <span class="cat-name"><?php echo esc_html(strtoupper($cat->name)); ?></span>
                            </span>
                            <span class="cat-count"><?php echo esc_html(str_pad((string) $cat->count, 2, '0', STR_PAD_LEFT)); ?></span>
                        </a>
                    </li>
            <?php
                endforeach;
            else :
                $fallback_cats = array(
                    array('name' => 'VIDEO PRODUCTION', 'count' => '04', 'dot' => 'red'),
                    array('name' => 'BRANDING & WEB',   'count' => '05', 'dot' => 'blue'),
                    array('name' => 'MUSIC & AUDIO',    'count' => '03', 'dot' => 'lime'),
                    array('name' => 'PHOTOGRAPHY',      'count' => '04', 'dot' => 'purple'),
                );
                foreach ($fallback_cats as $fc) :
            ?>
                    <li class="m3-cat-item m3-cat-item--<?php echo esc_attr($fc['dot']); ?>">
                        <a href="<?php echo esc_url(mileym3dia_get_blog_page_url()); ?>">
                            <span class="m3-cat-left">
                                <span class="m3-cat-dot" aria-hidden="true"></span>
                                <span class="cat-name"><?php echo esc_html($fc['name']); ?></span>
                            </span>
                            <span class="cat-count"><?php echo esc_html($fc['count']); ?></span>
                        </a>
                    </li>
            <?php
                endforeach;
            endif;
            ?>
        </ul>
    </section>

    <!-- 03. RECENT ARTICLES WITH THUMBNAILS -->
    <section id="sidebar-recent-posts" class="widget widget_recent_entries widget--accent-lime">
        <h3 class="widget-title"><?php esc_html_e('RECENT ARTICLES', 'mileym3dia'); ?></h3>
        <ul class="m3-recent-list">
            <?php
            $recent_posts = wp_get_recent_posts(array(
                'numberposts' => 4,
                'post_status' => 'publish',
            ));
            if (!empty($recent_posts)) :
                foreach ($recent_posts as $r_idx => $recent) :
                    $r_id    = (int) $recent['ID'];
                    $r_thumb = get_the_post_thumbnail_url($r_id, 'thumbnail');
                    if (empty($r_thumb)) {
                        $r_thumb = mileym3dia_get_blog_image_url($r_idx + 1);
                    }
                    $r_cats  = get_the_category($r_id);
                    $r_cat   = !empty($r_cats) ? strtoupper($r_cats[0]->name) : 'JOURNAL';
            ?>
                    <li class="m3-recent-item">
                        <a href="<?php echo esc_url(get_permalink($r_id)); ?>">
                            <div class="m3-recent-thumb">
                                <img src="<?php echo esc_url($r_thumb); ?>" alt="<?php echo esc_attr($recent['post_title']); ?>" loading="lazy" />
                            </div>
                            <div class="m3-recent-info">
                                <span class="m3-recent-meta"><?php echo esc_html($r_cat); ?> &bull; <?php echo esc_html(mileym3dia_reading_time($r_id)); ?></span>
                                <span class="recent-post-title"><?php echo esc_html(strtoupper($recent['post_title'])); ?></span>
                            </div>
                        </a>
                    </li>
            <?php
                endforeach;
                wp_reset_query();
            endif;
            ?>
        </ul>
    </section>

    <!-- 04. POPULAR TAGS -->
    <section id="sidebar-tags" class="widget widget_tag_cloud widget--accent-purple">
        <h3 class="widget-title"><?php esc_html_e('POPULAR TAGS', 'mileym3dia'); ?></h3>
        <div class="m3-tag-cloud">
            <?php
            $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 10));
            if (!empty($tags)) :
                foreach ($tags as $tag) :
            ?>
                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="m3-tag-pill">#<?php echo esc_html($tag->name); ?></a>
            <?php
                endforeach;
            else :
                foreach (array('Cinematography', 'MusicVideo', 'BrandIdentity', 'WebDesign', 'ColorGrading', 'StudioAudio') as $ftag) :
            ?>
                    <a href="<?php echo esc_url(mileym3dia_get_blog_page_url()); ?>" class="m3-tag-pill">#<?php echo esc_html($ftag); ?></a>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </section>

</aside>

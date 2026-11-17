<?php
/**
 * Custom template tags for this theme
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display SVG icons.
 */
function mileym3dia_icon($name, $class = '', $echo = true) {
    $icons = array(
        'arrow-right' => '<svg class="icon icon-arrow-right ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>',
        'arrow-left' => '<svg class="icon icon-arrow-left ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>',
        'arrow-down' => '<svg class="icon icon-arrow-down ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>',
        'menu' => '<svg class="icon icon-menu ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>',
        'close' => '<svg class="icon icon-close ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
        'instagram' => '<svg class="icon icon-instagram ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
        'twitter' => '<svg class="icon icon-twitter ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>',
        'facebook' => '<svg class="icon icon-facebook ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
        'linkedin' => '<svg class="icon icon-linkedin ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>',
        'youtube' => '<svg class="icon icon-youtube ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/></svg>',
        'vimeo' => '<svg class="icon icon-vimeo ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15c-1.5 0-2.5-.5-3-1.5-.5-1-.75-2.5-.75-4.5 0-2.5.5-4.5 1.5-6 .5-.75 1.25-1.25 2.25-1.5.5-.12 1-.18 1.5-.18 1.5 0 2.75.5 3.75 1.5.5.5.75 1.25.75 2.25 0 .5-.12 1-.37 1.5-.25.5-.75 1-1.5 1.5.75.25 1.25.75 1.5 1.5.25.5.37 1.25.37 2.25 0 1.5-.5 2.75-1.5 3.75-1 1-2.25 1.5-3.75 1.5z"/></svg>',
        'behance' => '<svg class="icon icon-behance ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 7h-7V5h7v2zm0 4h-7v2h7v-2zm-7-6H5v14h10c2.21 0 4-1.79 4-4s-1.79-4-4-4c1.1 0 2-.9 2-2s-.9-2-2-2zm-3 8h3c1.1 0 2 .9 2 2s-.9 2-2 2h-3v-4zm0-4h3c1.1 0 2 .9 2 2s-.9 2-2 2h-3V9z"/></svg>',
        'dribbble' => '<svg class="icon icon-dribbble ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"/></svg>',
        'tiktok' => '<svg class="icon icon-tiktok ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5v4a9 9 0 0 1-9-9v12z"/></svg>',
        'play' => '<svg class="icon icon-play ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>',
        'external' => '<svg class="icon icon-external ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>',
        'mail' => '<svg class="icon icon-mail ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22 6 12 13 2 6"/></svg>',
        'location' => '<svg class="icon icon-location ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
        'check' => '<svg class="icon icon-check ' . esc_attr($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>',
    );

    if (isset($icons[$name])) {
        if ($echo) {
            echo $icons[$name];
        } else {
            return $icons[$name];
        }
    }
    return '';
}

/**
 * Display social links.
 */
function mileym3dia_social_links($class = '') {
    $social_platforms = array(
        'instagram' => get_theme_mod('mileym3dia_social_instagram'),
        'twitter'   => get_theme_mod('mileym3dia_social_twitter'),
        'facebook'  => get_theme_mod('mileym3dia_social_facebook'),
        'linkedin'  => get_theme_mod('mileym3dia_social_linkedin'),
        'youtube'   => get_theme_mod('mileym3dia_social_youtube'),
        'vimeo'     => get_theme_mod('mileym3dia_social_vimeo'),
        'behance'   => get_theme_mod('mileym3dia_social_behance'),
        'dribbble'  => get_theme_mod('mileym3dia_social_dribbble'),
        'tiktok'    => get_theme_mod('mileym3dia_social_tiktok'),
    );

    $has_links = false;
    foreach ($social_platforms as $url) {
        if (!empty($url)) {
            $has_links = true;
            break;
        }
    }

    if (!$has_links) {
        $social_platforms = array(
            'instagram' => 'https://instagram.com/mileym3dia',
            'twitter'   => 'https://x.com/mileym3dia',
            'youtube'   => 'https://youtube.com/@mileym3dia',
            'behance'   => 'https://behance.net/mileym3dia',
        );
    }

    $output = '<ul class="social-links ' . esc_attr($class) . '">';
    foreach ($social_platforms as $platform => $url) {
        if (!empty($url)) {
            $output .= '<li class="social-link social-link-' . esc_attr($platform) . '">';
            $output .= '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr(ucfirst($platform)) . '">';
            $output .= mileym3dia_icon($platform, '', false);
            $output .= '</a>';
            $output .= '</li>';
        }
    }
    $output .= '</ul>';

    echo $output;
}

/**
 * Display section heading with optional eyebrow and number.
 */
function mileym3dia_section_heading($args = array()) {
    $defaults = array(
        'eyebrow'       => '',
        'title'         => '',
        'description'   => '',
        'number'        => '',
        'class'         => '',
        'align'         => 'left',
        'show_line'     => true,
    );

    $args = wp_parse_args($args, $defaults);

    echo '<div class="section-heading section-heading--' . esc_attr($args['align']) . ' ' . esc_attr($args['class']) . '">';

    if (!empty($args['eyebrow'])) {
        echo '<span class="section-eyebrow">' . esc_html($args['eyebrow']) . '</span>';
    }

    if (!empty($args['number'])) {
        echo '<span class="section-number">[' . esc_html($args['number']) . ']</span>';
    }

    if (!empty($args['title'])) {
        echo '<h2 class="section-title">' . wp_kses_post($args['title']) . '</h2>';
    }

    if (!empty($args['description'])) {
        echo '<p class="section-description">' . wp_kses_post($args['description']) . '</p>';
    }

    if ($args['show_line']) {
        echo '<div class="section-line"></div>';
    }

    echo '</div>';
}

/**
 * Display button component.
 */
function mileym3dia_button($args = array()) {
    $defaults = array(
        'text'      => __('Learn More', 'mileym3dia'),
        'url'       => home_url('/'),
        'variant'   => 'primary',
        'size'      => 'medium',
        'class'     => '',
        'icon'      => '',
        'target'    => '',
        'aria'      => '',
    );

    $args = wp_parse_args($args, $defaults);
    if (empty($args['url']) || $args['url'] === '#') {
        $args['url'] = home_url('/');
    }

    $classes = array('btn', 'btn--' . $args['variant'], 'btn--' . $args['size']);
    if (!empty($args['class'])) {
        $classes[] = $args['class'];
    }

    $attributes = 'href="' . esc_url($args['url']) . '"';
    $attributes .= ' class="' . esc_attr(implode(' ', $classes)) . '"';

    if (!empty($args['target'])) {
        $attributes .= ' target="' . esc_attr($args['target']) . '"';
    }

    if (!empty($args['aria'])) {
        $attributes .= ' aria-label="' . esc_attr($args['aria']) . '"';
    }

    echo '<a ' . $attributes . '>';
    echo '<span class="btn-text">' . esc_html($args['text']) . '</span>';
    if (!empty($args['icon'])) {
        mileym3dia_icon($args['icon']);
    }
    echo '</a>';
}

/**
 * Get cache-busted theme asset image URL.
 */
function mileym3dia_asset_image_url($filename) {
    $ver = defined('MILEYM3DIA_VERSION') ? MILEYM3DIA_VERSION : '2.3.0';
    return get_template_directory_uri() . '/assets/images/' . ltrim($filename, '/') . '?v=' . rawurlencode($ver);
}

/**
 * Get project fallback image URL from Customizer or theme assets.
 */
function mileym3dia_get_project_image_url($index = 1) {
    $slot = ((max(1, (int) $index) - 1) % 4) + 1;
    $default = mileym3dia_asset_image_url("portfolio-{$slot}.jpg");
    $custom = get_theme_mod("mileym3dia_proj_{$slot}_image", '');
    return !empty($custom) ? $custom : $default;
}

/**
 * Get blog post fallback image URL from Customizer or theme assets.
 */
function mileym3dia_get_blog_image_url($index = 1) {
    $slot = ((max(1, (int) $index) - 1) % 3) + 1;
    $default = mileym3dia_asset_image_url("blog-{$slot}.jpg");
    $custom = get_theme_mod("mileym3dia_blog_{$slot}_image", '');
    return !empty($custom) ? $custom : $default;
}

/**
 * Display portfolio item.
 */
function mileym3dia_portfolio_item($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $post = get_post($post_id);
    if (!$post) {
        return;
    }

    setup_postdata($post);

    $thumbnail = get_the_post_thumbnail($post_id, 'mileym3dia-medium', array('class' => 'portfolio-item-image'));
    $categories = get_the_terms($post_id, 'project_category');
    $year = get_post_meta($post_id, '_project_year', true);
    ?>
    <article class="portfolio-item" data-project-id="<?php echo esc_attr($post_id); ?>">
        <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="portfolio-item-link">
            <div class="portfolio-item-media">
                <?php if ($thumbnail) : ?>
                    <?php echo $thumbnail; ?>
                <?php else : ?>
                    <img src="<?php echo esc_url(mileym3dia_get_project_image_url($post_id)); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>" class="portfolio-item-image" loading="lazy" />
                <?php endif; ?>
                <div class="portfolio-item-overlay"></div>
            </div>
            <div class="portfolio-item-content">
                <h3 class="portfolio-item-title"><?php echo esc_html(get_the_title()); ?></h3>
                <?php if ($categories) : ?>
                    <span class="portfolio-item-category"><?php echo esc_html($categories[0]->name); ?></span>
                <?php endif; ?>
                <?php if ($year) : ?>
                    <span class="portfolio-item-year"><?php echo esc_html($year); ?></span>
                <?php endif; ?>
            </div>
        </a>
    </article>
    <?php

    wp_reset_postdata();
}

/**
 * Display service item.
 */
function mileym3dia_service_item($args = array()) {
    $defaults = array(
        'title'       => '',
        'description' => '',
        'icon'        => '',
        'color'       => 'lime',
        'class'       => '',
    );

    $args = wp_parse_args($args, $defaults);

    echo '<div class="service-item service-item--' . esc_attr($args['color']) . ' ' . esc_attr($args['class']) . '">';

    if (!empty($args['icon'])) {
        echo '<div class="service-icon">';
        mileym3dia_icon($args['icon']);
        echo '</div>';
    }

    if (!empty($args['title'])) {
        echo '<h3 class="service-title">' . esc_html($args['title']) . '</h3>';
    }

    if (!empty($args['description'])) {
        echo '<p class="service-description">' . esc_html($args['description']) . '</p>';
    }

    echo '</div>';
}

/**
 * Display blog post card.
 */
function mileym3dia_blog_card($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $post = get_post($post_id);
    if (!$post) {
        return;
    }

    setup_postdata($post);

    $thumbnail      = get_the_post_thumbnail($post_id, 'mileym3dia-medium', array('class' => 'blog-card-image'));
    $categories     = get_the_category($post_id);
    $tags           = get_the_tags($post_id);
    $date           = get_the_date('', $post_id);
    $author         = get_the_author_meta('display_name', $post->post_author);
    $show_cats      = get_theme_mod('mileym3dia_blog_show_categories', true);
    $show_date      = get_theme_mod('mileym3dia_blog_show_date', true);
    $show_author    = get_theme_mod('mileym3dia_blog_show_author', true);
    $read_more_text = get_theme_mod('mileym3dia_blog_read_more_text', __('READ FULL ARTICLE', 'mileym3dia'));
    $accents        = array('red', 'blue', 'lime', 'yellow');
    $card_accent    = $accents[absint($post_id) % count($accents)];
    $read_time      = mileym3dia_reading_time($post_id);
    ?>
    <article class="blog-card blog-card--<?php echo esc_attr($card_accent); ?>" data-post-id="<?php echo esc_attr($post_id); ?>">
        <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="blog-card-link">
            <div class="blog-card-media">
                <?php if ($thumbnail) : ?>
                    <?php echo $thumbnail; ?>
                <?php else : ?>
                    <img src="<?php echo esc_url(mileym3dia_get_blog_image_url($post_id)); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>" class="blog-card-image" loading="lazy" />
                <?php endif; ?>
                <div class="blog-card-overlay"></div>
                <div class="blog-card-media-badges">
                    <?php if ($show_cats && $categories) : ?>
                        <span class="blog-card-cat-badge"><?php echo esc_html(strtoupper($categories[0]->name)); ?></span>
                    <?php endif; ?>
                    <span class="blog-card-time-badge"><?php echo esc_html($read_time); ?></span>
                </div>
            </div>
            <div class="blog-card-content">
                <div class="blog-card-top-meta">
                    <?php if ($show_cats && $categories) : ?>
                        <span class="blog-card-category">&bull; <?php echo esc_html(strtoupper($categories[0]->name)); ?></span>
                    <?php endif; ?>
                    <?php if ($show_date) : ?>
                        <span class="blog-card-date-inline"><?php echo esc_html($date); ?></span>
                    <?php endif; ?>
                    <span class="blog-card-read-time"><?php echo esc_html($read_time); ?></span>
                </div>
                <h3 class="blog-card-title"><?php echo esc_html(strtoupper(get_the_title($post_id))); ?></h3>
                <p class="blog-card-excerpt"><?php echo mileym3dia_custom_excerpt(get_theme_mod('mileym3dia_blog_excerpt_length', 20)); ?></p>
                <?php if (!empty($tags) && !is_wp_error($tags)) : ?>
                    <div class="blog-card-tags">
                        <?php foreach (array_slice($tags, 0, 3) as $t) : ?>
                            <span class="blog-card-tag">#<?php echo esc_html($t->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="blog-card-footer">
                    <span class="blog-card-cta">
                        <span class="cta-label"><?php echo esc_html($read_more_text); ?></span>
                        <span class="cta-arrow">&rarr;</span>
                    </span>
                    <?php if ($show_author) : ?>
                        <span class="blog-card-author"><?php echo esc_html($author); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </a>
    </article>
    <?php

    wp_reset_postdata();
}

/**
 * Display pagination.
 */
function mileym3dia_pagination($args = array()) {
    $defaults = array(
        'mid_size'  => 2,
        'prev_text' => __('Previous', 'mileym3dia'),
        'next_text' => __('Next', 'mileym3dia'),
        'class'     => '',
    );

    $args = wp_parse_args($args, $defaults);

    the_posts_pagination(array(
        'mid_size'  => $args['mid_size'],
        'prev_text' => $args['prev_text'],
        'next_text' => $args['next_text'],
        'class'     => $args['class'],
    ));
}

/**
 * Get project meta information.
 */
function mileym3dia_get_project_meta($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $meta = array(
        'year'      => get_post_meta($post_id, '_project_year', true),
        'client'    => get_post_meta($post_id, '_project_client', true),
        'services'  => get_post_meta($post_id, '_project_services', true),
        'url'       => get_post_meta($post_id, '_project_url', true),
    );

    return $meta;
}

/**
 * Display resource item.
 */
function mileym3dia_resource_item($args = array()) {
    $defaults = array(
        'title'       => '',
        'description' => '',
        'type'        => 'guide',
        'url'         => mileym3dia_get_page_url('resources'),
        'icon'        => '',
        'class'       => '',
    );

    $args = wp_parse_args($args, $defaults);
    if (empty($args['url']) || $args['url'] === '#') {
        $args['url'] = mileym3dia_get_page_url('resources');
    }

    echo '<div class="resource-item ' . esc_attr($args['class']) . '">';
    echo '<a href="' . esc_url($args['url']) . '" class="resource-item-link">';

    if (!empty($args['icon'])) {
        echo '<div class="resource-icon">';
        mileym3dia_icon($args['icon']);
        echo '</div>';
    }

    echo '<div class="resource-content">';
    echo '<span class="resource-type">' . esc_html($args['type']) . '</span>';
    echo '<h3 class="resource-title">' . esc_html($args['title']) . '</h3>';
    if (!empty($args['description'])) {
        echo '<p class="resource-description">' . esc_html($args['description']) . '</p>';
    }
    echo '</div>';

    echo '<div class="resource-arrow">';
    mileym3dia_icon('arrow-right');
    echo '</div>';

    echo '</a>';
    echo '</div>';
}

/**
 * Check if homepage section should be displayed.
 */
function mileym3dia_show_section($section_name) {
    return get_theme_mod('mileym3dia_show_' . $section_name, true);
}

/**
 * Calculate estimated reading time for a post.
 */
function mileym3dia_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    return max(1, $reading_time) . ' MIN READ';
}

/**
 * Render reusable related posts section.
 */
function mileym3dia_related_posts($post_id = null, $count = 3) {
    if (!get_theme_mod('mileym3dia_blog_show_related', true)) {
        return;
    }
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $count = (int) get_theme_mod('mileym3dia_blog_related_count', $count);

    $categories = wp_get_post_categories($post_id);
    if (empty($categories)) {
        return;
    }

    $args = array(
        'category__in'        => $categories,
        'post__not_in'        => array($post_id),
        'posts_per_page'      => $count,
        'ignore_sticky_posts' => 1,
    );

    $related_query = new WP_Query($args);

    if ($related_query->have_posts()) :
        ?>
        <section class="related-posts-section">
            <div class="related-posts-header">
                <span class="related-eyebrow text-blue">STUDIO JOURNAL</span>
                <h3 class="related-title"><?php esc_html_e('Related Articles', 'mileym3dia'); ?></h3>
            </div>
            <div class="related-posts-grid">
                <?php
                while ($related_query->have_posts()) :
                    $related_query->the_post();
                    mileym3dia_blog_card(get_the_ID());
                endwhile;
                ?>
            </div>
        </section>
        <?php
    endif;
    wp_reset_postdata();
}

/**
 * Display reusable newsletter signup box.
 */
function mileym3dia_newsletter_box($args = array()) {
    $defaults = array(
        'eyebrow'     => 'STUDIO NEWSLETTER',
        'title'       => __('Stay In The Loop', 'mileym3dia'),
        'description' => __('Get updates on new video productions, behind-the-scenes breakdowns, and creative resources.', 'mileym3dia'),
        'button_text' => __('SUBSCRIBE', 'mileym3dia'),
        'class'       => '',
    );
    $args = wp_parse_args($args, $defaults);
    ?>
    <div class="newsletter-card <?php echo esc_attr($args['class']); ?>">
        <div class="newsletter-card-inner">
            <?php if (!empty($args['eyebrow'])) : ?>
                <span class="newsletter-eyebrow"><?php echo esc_html($args['eyebrow']); ?></span>
            <?php endif; ?>
            <h3 class="newsletter-title"><?php echo esc_html($args['title']); ?></h3>
            <?php if (!empty($args['description'])) : ?>
                <p class="newsletter-description"><?php echo esc_html($args['description']); ?></p>
            <?php endif; ?>
            <form class="newsletter-form" action="<?php echo esc_url(home_url('/')); ?>" method="post" onsubmit="event.preventDefault(); var b = this.querySelector('.newsletter-submit .btn-text'); if(b) b.textContent='SUBSCRIBED'; var inp = this.querySelector('.newsletter-input'); if(inp) inp.disabled=true;">
                <div class="newsletter-field-wrap">
                    <input type="email" class="newsletter-input" placeholder="<?php esc_attr_e('Enter your email address...', 'mileym3dia'); ?>" required aria-label="<?php esc_attr_e('Email Address', 'mileym3dia'); ?>" />
                    <button type="submit" class="btn btn--primary newsletter-submit">
                        <span class="btn-text"><?php echo esc_html($args['button_text']); ?></span>
                        <span class="cta-arrow">↗</span>
                    </button>
                </div>
                <span class="newsletter-privacy"><?php esc_html_e('No spam. Unsubscribe at any time.', 'mileym3dia'); ?></span>
            </form>
        </div>
    </div>
    <?php
}

/**
 * Render the 3 Accessible Production Pricing Packages ($350 / $750 / $1,450).
 */
function mileym3dia_render_pricing_packages() {
    $contact_url = mileym3dia_get_page_url('contact');
    ?>
    <div class="pricing-grid">
        <!-- Tier 1: Starter / Single Service ($350) -->
        <div class="pricing-card">
            <div class="pricing-badge text-lime"><?php echo esc_html(get_theme_mod('mileym3dia_tier_1_badge', 'STARTER / SINGLE SERVICE')); ?></div>
            <h3 class="pricing-title"><?php echo esc_html(get_theme_mod('mileym3dia_tier_1_title', 'SINGLE SHOOT OR DESIGN')); ?></h3>
            <div class="pricing-cost">
                <span class="pricing-curr text-lime">$</span><span class="pricing-amount"><?php echo esc_html(get_theme_mod('mileym3dia_tier_1_price', '350')); ?></span>
                <span class="pricing-period"><?php echo esc_html(get_theme_mod('mileym3dia_tier_1_period', '/ project')); ?></span>
            </div>
            <p class="pricing-desc"><?php echo esc_html(get_theme_mod('mileym3dia_tier_1_desc', 'Ideal for a single promo reel shoot, photo mini-session, custom logo, or single song mix & master.')); ?></p>
            <ul class="pricing-features">
                <li><span class="check text-lime">✓</span> Half-Day 4K Camera Shoot or Studio Session</li>
                <li><span class="check text-lime">✓</span> Or Complete Custom Logo &amp; Brand Mark Kit</li>
                <li><span class="check text-lime">✓</span> Professional Color Grading or Studio Audio Mix</li>
                <li><span class="check text-lime">✓</span> Fast 3–5 Business Day Turnaround</li>
                <li><span class="check text-lime">✓</span> 2 Rounds of Client Revisions Included</li>
            </ul>
            <a href="<?php echo esc_url($contact_url); ?>?tier=starter" class="btn btn--streetwear-outline btn--full">
                BOOK STARTER PACKAGE
            </a>
        </div>

        <!-- Tier 2 (Featured): Creator & Brand Launch ($750) -->
        <div class="pricing-card pricing-card--featured">
            <div class="pricing-badge badge--featured"><?php echo esc_html(get_theme_mod('mileym3dia_tier_2_badge', 'MOST POPULAR')); ?></div>
            <h3 class="pricing-title"><?php echo esc_html(get_theme_mod('mileym3dia_tier_2_title', 'CREATOR & BRAND LAUNCH')); ?></h3>
            <div class="pricing-cost">
                <span class="pricing-curr">$</span><span class="pricing-amount"><?php echo esc_html(get_theme_mod('mileym3dia_tier_2_price', '750')); ?></span>
                <span class="pricing-period"><?php echo esc_html(get_theme_mod('mileym3dia_tier_2_period', '/ package')); ?></span>
            </div>
            <p class="pricing-desc"><?php echo esc_html(get_theme_mod('mileym3dia_tier_2_desc', 'Complete rollout package including a 4K promo or music video shoot, lookbook photo session, social vertical edits, and custom cover/flyer art.')); ?></p>
            <ul class="pricing-features">
                <li><span class="check text-yellow">✓</span> Full-Day 4K Video Production (Music Video or Promo)</li>
                <li><span class="check text-yellow">✓</span> Photography Session (15 Retouched Lookbook/Press Stills)</li>
                <li><span class="check text-yellow">✓</span> 3 Vertical Cutdowns for Reels, TikTok &amp; Shorts</li>
                <li><span class="check text-yellow">✓</span> Custom Cover Art, Flyer, or Social Launch Kit</li>
                <li><span class="check text-yellow">✓</span> DaVinci Resolve Color Grade &amp; Clean Audio Master</li>
                <li><span class="check text-yellow">✓</span> Full Commercial &amp; Release Licensing</li>
            </ul>
            <a href="<?php echo esc_url($contact_url); ?>?tier=launch" class="btn btn--streetwear-red btn--full">
                BOOK LAUNCH PACKAGE ↗
            </a>
        </div>

        <!-- Tier 3: Full Production + Web ($1,450) -->
        <div class="pricing-card">
            <div class="pricing-badge text-blue"><?php echo esc_html(get_theme_mod('mileym3dia_tier_3_badge', 'ALL-IN-ONE STUDIO')); ?></div>
            <h3 class="pricing-title"><?php echo esc_html(get_theme_mod('mileym3dia_tier_3_title', 'FULL PRODUCTION + WEB')); ?></h3>
            <div class="pricing-cost">
                <span class="pricing-curr text-blue">$</span><span class="pricing-amount"><?php echo esc_html(get_theme_mod('mileym3dia_tier_3_price', '1,450')); ?></span>
                <span class="pricing-period"><?php echo esc_html(get_theme_mod('mileym3dia_tier_3_period', '/ package')); ?></span>
            </div>
            <p class="pricing-desc"><?php echo esc_html(get_theme_mod('mileym3dia_tier_3_desc', 'End-to-end brand identity, custom website build, flagship video production, photography set, and studio audio.')); ?></p>
            <ul class="pricing-features">
                <li><span class="check text-blue">✓</span> Complete Brand Identity, Logo Suite &amp; Style Guide</li>
                <li><span class="check text-blue">✓</span> Custom Multi-Section Website or Online Storefront</li>
                <li><span class="check text-blue">✓</span> Flagship 4K Commercial or Music Video Production</li>
                <li><span class="check text-blue">✓</span> Full Brand &amp; Product Photography Campaign (25+ Stills)</li>
                <li><span class="check text-blue">✓</span> Custom Audio Scoring or Multi-Track Mix &amp; Master</li>
            </ul>
            <a href="<?php echo esc_url($contact_url); ?>?tier=full" class="btn btn--streetwear-outline btn--full">
                BOOK FULL PRODUCTION
            </a>
        </div>
    </div>
    <?php
}

/**
 * Render the Interactive Service Bundle Builder (Smaller A-La-Carte Services $95–$350).
 */
function mileym3dia_render_bundle_builder($instance_id = 'main') {
    if (!get_theme_mod('mileym3dia_show_bundle_builder', true)) {
        return;
    }

    $eyebrow      = get_theme_mod('mileym3dia_bundle_eyebrow', 'CUSTOM BUNDLE BUILDER · MIX & MATCH');
    $title        = get_theme_mod('mileym3dia_bundle_title', 'BUILD YOUR OWN BUNDLE');
    $subtitle     = get_theme_mod('mileym3dia_bundle_subtitle', 'Need smaller individual services? Click any services below to mix and match your custom bundle—and automatically save 10% when you combine 3 or more.');
    $discount_pct = max(0, min(50, (int) get_theme_mod('mileym3dia_bundle_discount_pct', 10)));
    $contact_base = mileym3dia_get_page_url('contact');

    $default_items = array(
        1 => array('title' => 'Vertical Reels / Shorts Edit', 'price' => 95, 'cat' => 'VIDEO EDIT', 'accent' => 'red', 'desc' => 'High-retention vertical edit with captions, color grade, and sound design for Reels, TikTok, or Shorts.'),
        2 => array('title' => 'Flyer, Cover Art or Social Kit', 'price' => 125, 'cat' => 'DESIGN', 'accent' => 'yellow', 'desc' => 'Custom single/album cover art, event flyer, or matching social media graphics with print & digital files.'),
        3 => array('title' => 'Single Song Mix & Master', 'price' => 150, 'cat' => 'AUDIO', 'accent' => 'lime', 'desc' => 'Studio vocal and stem mixing plus streaming-ready mastering for Spotify, Apple Music, and YouTube.'),
        4 => array('title' => 'Custom Logo & Brand Mark', 'price' => 195, 'cat' => 'BRANDING', 'accent' => 'blue', 'desc' => 'Original vector logo design with primary, stacked, and icon variations plus color palette guide.'),
        5 => array('title' => 'Photography Mini-Session', 'price' => 225, 'cat' => 'PHOTO', 'accent' => 'yellow', 'desc' => '2-hour studio or on-location shoot for artist press photos, portraits, or products (10 retouched stills).'),
        6 => array('title' => 'Custom Beat or Audio Score', 'price' => 250, 'cat' => 'AUDIO', 'accent' => 'lime', 'desc' => 'Original custom-produced instrumental or commercial soundtrack with tracked-out stems and commercial rights.'),
        7 => array('title' => '4K Promo or Music Video Shoot', 'price' => 350, 'cat' => 'VIDEO', 'accent' => 'red', 'desc' => 'Half-day 4K cinema camera shoot on location with professional lighting, full edit, and DaVinci color grade.'),
        8 => array('title' => 'Custom 1-Page Website / EPK', 'price' => 350, 'cat' => 'WEB', 'accent' => 'blue', 'desc' => 'Fast, mobile-ready custom landing page, artist EPK, or booking site with contact form and domain setup.'),
    );

    $uid = sanitize_html_class($instance_id);
    ?>
    <div class="m3-bundle-builder" id="bundleBuilder-<?php echo esc_attr($uid); ?>" data-discount-pct="<?php echo esc_attr($discount_pct); ?>" data-contact-url="<?php echo esc_url($contact_base); ?>">
        <div class="bundle-builder-header">
            <div class="bundle-header-left">
                <span class="section-label text-lime"><?php echo esc_html($eyebrow); ?></span>
                <h3 class="bundle-builder-title"><?php echo esc_html($title); ?></h3>
                <p class="bundle-builder-subtitle"><?php echo esc_html($subtitle); ?></p>
            </div>
            <?php if ($discount_pct > 0) : ?>
                <div class="bundle-discount-pill">
                    <span class="discount-dot"></span>
                    <span>BUNDLE 3+ SERVICES &amp; SAVE <strong><?php echo (int) $discount_pct; ?>%</strong></span>
                </div>
            <?php endif; ?>
        </div>

        <div class="bundle-builder-layout">
            <!-- 8 Smaller Services (Symmetrical 2x4 Grid) -->
            <div class="bundle-items-grid" role="group" aria-label="<?php esc_attr_e('Selectable creative services', 'mileym3dia'); ?>">
                <?php foreach ($default_items as $idx => $item) :
                    $b_title   = get_theme_mod("mileym3dia_bundle_{$idx}_title", $item['title']);
                    $b_price   = max(1, (int) get_theme_mod("mileym3dia_bundle_{$idx}_price", $item['price']));
                    $b_cat     = get_theme_mod("mileym3dia_bundle_{$idx}_cat", $item['cat']);
                    $b_desc    = get_theme_mod("mileym3dia_bundle_{$idx}_desc", $item['desc']);
                    $accent    = $item['accent'];
                    $is_active = ($idx === 1 || $idx === 4);
                ?>
                    <button type="button"
                            class="bundle-item-card bundle-item--<?php echo esc_attr($accent); ?><?php echo $is_active ? ' is-selected' : ''; ?>"
                            data-title="<?php echo esc_attr($b_title); ?>"
                            data-price="<?php echo esc_attr($b_price); ?>"
                            data-cat="<?php echo esc_attr($b_cat); ?>"
                            aria-pressed="<?php echo $is_active ? 'true' : 'false'; ?>">
                        <div class="bundle-item-top">
                            <span class="bundle-item-cat text-<?php echo esc_attr($accent); ?>"><?php echo esc_html($b_cat); ?></span>
                            <span class="bundle-item-price">$<?php echo esc_html(number_format_i18n($b_price)); ?></span>
                        </div>
                        <h4 class="bundle-item-name"><?php echo esc_html($b_title); ?></h4>
                        <p class="bundle-item-desc"><?php echo esc_html($b_desc); ?></p>
                        <div class="bundle-item-footer">
                            <span class="bundle-check-box">
                                <span class="bundle-check-mark">✓</span>
                            </span>
                            <span class="bundle-toggle-label"><?php echo $is_active ? esc_html__('ADDED TO BUNDLE', 'mileym3dia') : esc_html__('ADD TO BUNDLE', 'mileym3dia'); ?></span>
                        </div>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Sleek Horizontal Live Bundle Summary Dock -->
            <aside class="bundle-summary-panel" aria-live="polite">
                <div class="bundle-summary-card">
                    <div class="bundle-summary-col-left">
                        <div class="bundle-summary-header">
                            <span class="summary-eyebrow text-yellow">YOUR CUSTOM BUNDLE</span>
                            <span class="summary-count-badge"><span class="js-bundle-count">2</span> SELECTED</span>
                        </div>
                        <div class="bundle-discount-progress js-bundle-promo">
                            Add <strong>1 more service</strong> to unlock your <strong><?php echo (int) $discount_pct; ?>% bundle discount</strong>!
                        </div>
                    </div>

                    <div class="bundle-summary-col-middle">
                        <span class="summary-items-label">INCLUDED IN BUNDLE:</span>
                        <ul class="bundle-selected-list js-bundle-list"></ul>
                    </div>

                    <div class="bundle-summary-col-right">
                        <div class="bundle-totals-box">
                            <div class="bundle-total-row">
                                <span>Subtotal</span>
                                <span class="js-bundle-subtotal">$290</span>
                            </div>
                            <div class="bundle-total-row bundle-discount-row js-bundle-discount-row" style="display:none;">
                                <span class="text-lime">Bundle Discount (<?php echo (int) $discount_pct; ?>% Off)</span>
                                <span class="text-lime js-bundle-discount">-$0</span>
                            </div>
                            <div class="bundle-total-row bundle-grand-total">
                                <span>ESTIMATED TOTAL</span>
                                <span class="js-bundle-total">$290</span>
                            </div>
                        </div>

                        <div class="bundle-summary-actions">
                            <a href="<?php echo esc_url($contact_base); ?>" class="btn btn--accent-lime btn--full js-bundle-book-btn">
                                <span class="btn-text">BOOK THIS BUNDLE</span>
                                <span class="btn-arrow">↗</span>
                            </a>
                            <button type="button" class="bundle-clear-btn js-bundle-clear-btn">
                                CLEAR SELECTION
                            </button>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
    (function() {
        var root = document.getElementById('bundleBuilder-<?php echo esc_js($uid); ?>');
        if (!root || root.dataset.initialized === 'true') return;
        root.dataset.initialized = 'true';

        var discountPct = parseInt(root.getAttribute('data-discount-pct') || '10', 10);
        var contactUrl  = root.getAttribute('data-contact-url') || '/contact/';
        var cards       = Array.prototype.slice.call(root.querySelectorAll('.bundle-item-card'));
        var countEl     = root.querySelector('.js-bundle-count');
        var listEl      = root.querySelector('.js-bundle-list');
        var promoEl     = root.querySelector('.js-bundle-promo');
        var subtotalEl  = root.querySelector('.js-bundle-subtotal');
        var discRowEl   = root.querySelector('.js-bundle-discount-row');
        var discValEl   = root.querySelector('.js-bundle-discount');
        var totalEl     = root.querySelector('.js-bundle-total');
        var bookBtn     = root.querySelector('.js-bundle-book-btn');
        var clearBtn    = root.querySelector('.js-bundle-clear-btn');

        function formatMoney(n) {
            return '$' + Math.round(n).toLocaleString('en-US');
        }

        function updateBundle() {
            var selected = [];
            var subtotal = 0;

            cards.forEach(function(card) {
                var active = card.classList.contains('is-selected');
                card.setAttribute('aria-pressed', active ? 'true' : 'false');
                var lbl = card.querySelector('.bundle-toggle-label');
                if (lbl) {
                    lbl.textContent = active ? 'ADDED TO BUNDLE' : 'ADD TO BUNDLE';
                }
                if (active) {
                    var title = card.getAttribute('data-title') || '';
                    var price = parseFloat(card.getAttribute('data-price') || '0');
                    selected.push({ title: title, price: price, card: card });
                    subtotal += price;
                }
            });

            if (countEl) countEl.textContent = String(selected.length);

            if (listEl) {
                listEl.innerHTML = '';
                if (selected.length === 0) {
                    var emptyLi = document.createElement('li');
                    emptyLi.className = 'bundle-empty-msg';
                    emptyLi.textContent = 'Select any services on the left to build your custom package.';
                    listEl.appendChild(emptyLi);
                } else {
                    selected.forEach(function(item) {
                        var li = document.createElement('li');
                        li.className = 'bundle-selected-item';
                        var nameSpan = document.createElement('span');
                        nameSpan.className = 'selected-item-name';
                        nameSpan.textContent = item.title;
                        var priceSpan = document.createElement('span');
                        priceSpan.className = 'selected-item-price';
                        priceSpan.textContent = formatMoney(item.price);
                        li.appendChild(nameSpan);
                        li.appendChild(priceSpan);
                        listEl.appendChild(li);
                    });
                }
            }

            var hasDiscount = (discountPct > 0 && selected.length >= 3);
            var discountAmt = hasDiscount ? Math.round(subtotal * (discountPct / 100)) : 0;
            var finalTotal  = Math.max(0, subtotal - discountAmt);

            if (promoEl) {
                if (discountPct <= 0) {
                    promoEl.style.display = 'none';
                } else if (hasDiscount) {
                    promoEl.className = 'bundle-discount-progress is-unlocked js-bundle-promo';
                    promoEl.innerHTML = '✓ <strong>' + discountPct + '% Bundle Discount Unlocked!</strong> You save <strong>' + formatMoney(discountAmt) + '</strong>.';
                } else {
                    var needed = 3 - selected.length;
                    promoEl.className = 'bundle-discount-progress js-bundle-promo';
                    promoEl.innerHTML = 'Add <strong>' + needed + ' more service' + (needed > 1 ? 's' : '') + '</strong> to unlock your <strong>' + discountPct + '% bundle discount</strong>!';
                }
            }

            if (subtotalEl) subtotalEl.textContent = formatMoney(subtotal);
            if (discRowEl) discRowEl.style.display = hasDiscount ? 'flex' : 'none';
            if (discValEl) discValEl.textContent = '-' + formatMoney(discountAmt);
            if (totalEl) totalEl.textContent = formatMoney(finalTotal);

            if (bookBtn) {
                if (selected.length === 0) {
                    bookBtn.setAttribute('href', contactUrl);
                } else {
                    var names = selected.map(function(s) { return s.title + ' ($' + s.price + ')'; }).join(', ');
                    var sep = contactUrl.indexOf('?') === -1 ? '?' : '&';
                    var target = contactUrl + sep + 'bundle=' + encodeURIComponent(names) + '&estimate=' + encodeURIComponent(formatMoney(finalTotal));
                    bookBtn.setAttribute('href', target);
                }
            }
        }

        cards.forEach(function(card) {
            card.addEventListener('click', function() {
                card.classList.toggle('is-selected');
                updateBundle();
            });
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                cards.forEach(function(c) { c.classList.remove('is-selected'); });
                updateBundle();
            });
        }

        updateBundle();
    })();
    </script>
    <?php
}



<?php
/**
 * MILEYM3DIA Theme Functions
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

define('MILEYM3DIA_VERSION', '2.4.0');

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/class-walker-nav-menu.php';
require get_template_directory() . '/inc/customizer.php';

/**
 * Theme setup
 */
function mileym3dia_setup() {
    if (function_exists('load_theme_textdomain')) {
        load_theme_textdomain('m3-big-red', get_template_directory() . '/languages');
        load_theme_textdomain('mileym3dia', get_template_directory() . '/languages');
    }

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('custom-background');

    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'mileym3dia'),
        'footer'  => __('Footer Menu', 'mileym3dia'),
        'mobile'  => __('Mobile Menu', 'mileym3dia'),
        'social'  => __('Social Links Menu', 'mileym3dia'),
    ));

    set_post_thumbnail_size(1920, 1080, true);
    add_image_size('mileym3dia-hero', 2400, 1350, true);
    add_image_size('mileym3dia-large', 1600, 900, true);
    add_image_size('mileym3dia-medium', 800, 600, true);
    add_image_size('mileym3dia-small', 400, 300, true);
}
add_action('after_setup_theme', 'mileym3dia_setup');

/**
 * Register Portfolio Project Custom Post Type & Category if not already registered
 */
function mileym3dia_register_portfolio_cpt() {
    if (!post_type_exists('project') && function_exists('register_post_type')) {
        register_post_type('project', array(
            'labels' => array(
                'name'               => __('Projects', 'mileym3dia'),
                'singular_name'      => __('Project', 'mileym3dia'),
                'add_new'            => __('Add New Project', 'mileym3dia'),
                'add_new_item'       => __('Add New Project', 'mileym3dia'),
                'edit_item'          => __('Edit Project', 'mileym3dia'),
                'new_item'           => __('New Project', 'mileym3dia'),
                'view_item'          => __('View Project', 'mileym3dia'),
                'search_items'       => __('Search Projects', 'mileym3dia'),
                'not_found'          => __('No projects found', 'mileym3dia'),
                'not_found_in_trash' => __('No projects found in Trash', 'mileym3dia'),
                'menu_name'          => __('Portfolio', 'mileym3dia'),
            ),
            'public'       => true,
            'has_archive'  => true,
            'rewrite'      => array('slug' => 'project'),
            'menu_icon'    => 'dashicons-format-video',
            'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'show_in_rest' => true,
        ));
    }

    if (!taxonomy_exists('project_category') && function_exists('register_taxonomy')) {
        register_taxonomy('project_category', array('project'), array(
            'labels' => array(
                'name'          => __('Project Categories', 'mileym3dia'),
                'singular_name' => __('Project Category', 'mileym3dia'),
            ),
            'public'       => true,
            'hierarchical' => true,
            'rewrite'      => array('slug' => 'project-category'),
            'show_in_rest' => true,
        ));
    }
}
add_action('init', 'mileym3dia_register_portfolio_cpt');

/**
 * Enqueue scripts and styles & output dynamic Customizer CSS variables
 */
function mileym3dia_scripts() {
    $style_path    = get_template_directory() . '/style.css';
    $main_css_path = get_template_directory() . '/css/main.css';
    $main_js_path  = get_template_directory() . '/js/main.js';

    wp_enqueue_style(
        'mileym3dia-google-fonts',
        'https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap',
        array(),
        null
    );

    wp_enqueue_style('mileym3dia-style', get_stylesheet_uri(), array('mileym3dia-google-fonts'), file_exists($style_path) ? filemtime($style_path) : MILEYM3DIA_VERSION);
    wp_enqueue_style('mileym3dia-main', get_template_directory_uri() . '/css/main.css', array('mileym3dia-style'), file_exists($main_css_path) ? filemtime($main_css_path) : MILEYM3DIA_VERSION);

    $custom_colors = array(
        '--bg-base'            => get_theme_mod('mileym3dia_bg_color', '#050507'),
        '--bg-elevated'        => get_theme_mod('mileym3dia_bg_elevated', '#0A0B0F'),
        '--bg-surface'         => get_theme_mod('mileym3dia_bg_surface', '#101116'),
        '--color-black'        => get_theme_mod('mileym3dia_bg_color', '#050507'),
        '--color-dark'         => get_theme_mod('mileym3dia_bg_elevated', '#0A0B0F'),
        '--color-surface'      => get_theme_mod('mileym3dia_bg_surface', '#101116'),
        '--color-white'        => get_theme_mod('mileym3dia_text_color', '#F4F4F6'),
        '--color-off-white'    => get_theme_mod('mileym3dia_text_color', '#F4F4F6'),
        '--color-red'          => get_theme_mod('mileym3dia_color_red', '#EF233C'),
        '--color-yellow'       => get_theme_mod('mileym3dia_color_yellow', '#FFE600'),
        '--color-lime'         => get_theme_mod('mileym3dia_color_lime', '#00FF66'),
        '--color-blue'         => get_theme_mod('mileym3dia_color_blue', '#2563EB'),
        '--color-purple'       => get_theme_mod('mileym3dia_color_yellow', '#FFE600'),
        '--accent-work'        => get_theme_mod('mileym3dia_accent_work', '#EF233C'),
        '--accent-services'    => get_theme_mod('mileym3dia_accent_services', '#00FF66'),
        '--accent-about'       => get_theme_mod('mileym3dia_accent_about', '#FFE600'),
        '--accent-resources'   => get_theme_mod('mileym3dia_accent_resources', '#2563EB'),
        '--accent-contact'     => get_theme_mod('mileym3dia_accent_contact', '#EF233C'),
    );

    $variables = array();
    foreach ($custom_colors as $property => $color) {
        $color = sanitize_hex_color($color);
        if ($color) {
            $variables[] = $property . ':' . $color;
        }
    }
    if ($variables) {
        wp_add_inline_style('mileym3dia-main', ':root{' . implode(';', $variables) . ';}');
    }

    wp_enqueue_script('mileym3dia-main', get_template_directory_uri() . '/js/main.js', array(), file_exists($main_js_path) ? filemtime($main_js_path) : MILEYM3DIA_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'mileym3dia_scripts');

/**
 * Add preconnect resource hints for Google Fonts
 */
function mileym3dia_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        $urls[] = array(
            'href'        => 'https://fonts.googleapis.com',
            'crossorigin' => 'anonymous',
        );
        $urls[] = array(
            'href'        => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'mileym3dia_resource_hints', 10, 2);

/**
 * Defer non-critical theme scripts
 */
function mileym3dia_defer_scripts($tag, $handle, $src) {
    if ('mileym3dia-main' === $handle && false === strpos($tag, 'defer')) {
        $tag = str_replace('<script ', '<script defer ', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'mileym3dia_defer_scripts', 10, 3);

/**
 * Editor styles
 */
function mileym3dia_editor_styles() {
    add_editor_style('css/editor-style.css');
}
add_action('after_setup_theme', 'mileym3dia_editor_styles');

/**
 * Check if portfolio projects exist
 */
function mileym3dia_has_projects() {
    return post_type_exists('project');
}

function mileym3dia_project_archive_url() {
    return mileym3dia_get_work_page_url();
}

/**
 * Custom body classes
 */
function mileym3dia_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'home-page';
    }
    if (is_singular()) {
        $classes[] = 'singular-page';
    }

    if (is_page('work') || is_page('portfolio') || is_page_template('page-portfolio.php') || is_page_template('page-work.php') || is_post_type_archive('project') || is_singular('project')) {
        $classes[] = 'accent-work';
    } elseif (is_page('services') || is_page_template('page-services.php')) {
        $classes[] = 'accent-services';
    } elseif (is_page('about') || is_page_template('page-about.php')) {
        $classes[] = 'accent-about';
    } elseif (is_home() || (is_archive() && !is_post_type_archive('project')) || is_singular('post') || is_search() || is_page('resources') || is_page_template('page-resources.php')) {
        $classes[] = 'accent-blog';
    } elseif (is_page('contact') || is_page_template('page-contact.php')) {
        $classes[] = 'accent-contact';
    } elseif (is_page('creator-hub') || is_page_template('page-creator-hub.php')) {
        $classes[] = 'accent-creator-hub';
    } elseif (is_page('store') || is_page('shop') || is_page_template('page-store.php') || (function_exists('is_woocommerce') && is_woocommerce())) {
        $classes[] = 'accent-store';
    }

    if (is_home() || (is_archive() && !is_post_type_archive('project')) || is_singular('post') || is_search()) {
        $sidebar_enabled = get_theme_mod('mileym3dia_blog_sidebar', true);
        $sidebar_pos     = get_theme_mod('mileym3dia_blog_sidebar_pos', 'right');
        if ($sidebar_enabled) {
            $classes[] = 'has-blog-sidebar';
            $classes[] = 'blog-sidebar-' . sanitize_html_class($sidebar_pos);
        } else {
            $classes[] = 'blog-no-sidebar';
        }
    }

    return $classes;
}
add_filter('body_class', 'mileym3dia_body_classes');

function mileym3dia_excerpt_length($length) {
    return (int) get_theme_mod('mileym3dia_blog_excerpt_length', 24);
}
add_filter('excerpt_length', 'mileym3dia_excerpt_length', 999);

function mileym3dia_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'mileym3dia_excerpt_more');

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

function mileym3dia_custom_excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt) >= $limit) {
        array_pop($excerpt);
        $excerpt = implode(' ', $excerpt) . '...';
    } else {
        $excerpt = implode(' ', $excerpt);
    }
    return $excerpt;
}

/**
 * Register widget areas
 */
function mileym3dia_widgets_init() {
    register_sidebar(array(
        'name'          => __('Header', 'mileym3dia'),
        'id'            => 'header-1',
        'description'   => __('Header widgets.', 'mileym3dia'),
        'before_widget' => '<div id="%1$s" class="header-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<span class="screen-reader-text">',
        'after_title'   => '</span>',
    ));

    register_sidebar(array(
        'name'          => __('Blog Sidebar', 'mileym3dia'),
        'id'            => 'sidebar-blog',
        'description'   => __('Blog sidebar widgets.', 'mileym3dia'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer %d', 'mileym3dia'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(__('Footer column %d widgets.', 'mileym3dia'), $i),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}
add_action('widgets_init', 'mileym3dia_widgets_init');

/**
 * Dynamic page & project URL helpers
 */
function mileym3dia_get_page_url($slug, $fallback_slug = '') {
    $slug = trim((string) $slug, '/');
    if ('pricing' === $slug) {
        return mileym3dia_get_pricing_page_url();
    }
    $page = get_page_by_path($slug);
    if ($page && 'publish' === $page->post_status) {
        return get_permalink($page->ID);
    }
    if ($fallback_slug) {
        $fallback_page = get_page_by_path(trim((string) $fallback_slug, '/'));
        if ($fallback_page && 'publish' === $fallback_page->post_status) {
            return get_permalink($fallback_page->ID);
        }
    }
    return home_url('/' . $slug . '/');
}

function mileym3dia_get_work_page_url() {
    $page = get_page_by_path('work');
    if (!$page || 'publish' !== $page->post_status) {
        $page = get_page_by_path('portfolio');
    }
    if ($page && 'publish' === $page->post_status) {
        return get_permalink($page->ID);
    }
    return home_url('/work/');
}

function mileym3dia_get_pricing_page_url() {
    $pricing_page = get_page_by_path('pricing');
    if ($pricing_page && 'publish' === $pricing_page->post_status) {
        return get_permalink($pricing_page->ID);
    }
    return mileym3dia_get_page_url('services') . '#pricing';
}

function mileym3dia_get_blog_page_url() {
    $posts_page_id = get_option('page_for_posts');
    if ($posts_page_id) {
        return get_permalink($posts_page_id);
    }
    $blog_page = get_page_by_path('blog');
    if ($blog_page && 'publish' === $blog_page->post_status) {
        return get_permalink($blog_page->ID);
    }
    return home_url('/blog/');
}

function mileym3dia_get_project_url($slug) {
    $slug = trim((string) $slug, '/');
    if (function_exists('get_page_by_path')) {
        $project = get_page_by_path($slug, OBJECT, 'project');
        if ($project && isset($project->ID) && 'publish' === $project->post_status) {
            return get_permalink($project->ID);
        }
    }
    return home_url('/project/' . $slug . '/');
}

/**
 * Canonical default portfolio projects data used for seeding and fallback rendering
 */
function mileym3dia_get_default_projects_data() {
    return array(
        'nightfall-apparel-campaign' => array(
            'slot'      => 1,
            'slug'      => 'nightfall-apparel-campaign',
            'title'     => 'NIGHTFALL APPAREL CAMPAIGN',
            'cat_name'  => 'Video Production & Lookbook',
            'cat_slug'  => 'video',
            'accent'    => 'red',
            'year'      => '2026',
            'client'    => 'NIGHTFALL ATELIER',
            'services'  => 'Cinema Video Production / Stills / DaVinci Grade',
            'url'       => '',
            'excerpt'   => 'Full commercial video production, street lookbook photography, and social campaign rollout for Nightfall Atelier.',
            'content'   => '<p>Shot on location over four nights, the Nightfall campaign combines cinema camera movement, editorial lookbook photography, and custom sound design for a multi-platform brand launch.</p>',
            'challenge' => 'Nightfall Atelier required an unmistakable, high-tension nocturnal campaign for their Winter 2026 technical outerwear capsule. The aesthetic directive required authentic rainy neon city streets, high-speed movement, and cinema-grade lighting without appearing clinical or commercialized.',
            'solution'  => 'Filmed entirely over four consecutive overnight shoots using RED V-Raptor and Sony FX6 packages paired with vintage Cooke anamorphic glass. We engineered a proprietary DaVinci Resolve color pipeline that preserved shadow detail while making neon reds and cyans explode off the screen.',
            'stats'     => array(
                array('num' => '4K RAW', 'label' => 'Cinema Camera Master'),
                array('num' => '10-DAY', 'label' => 'Turnaround Delivery'),
                array('num' => '100%', 'label' => 'In-House Production'),
                array('num' => '2.4M+', 'label' => 'Organic Social Reach'),
            ),
        ),
        'static-frequency-tour-visuals' => array(
            'slot'      => 2,
            'slug'      => 'static-frequency-tour-visuals',
            'title'     => 'STATIC FREQUENCY TOUR & VISUALS',
            'cat_name'  => 'Music Video & Audio',
            'cat_slug'  => 'audio',
            'accent'    => 'yellow',
            'year'      => '2026',
            'client'    => 'STATIC FREQUENCY',
            'services'  => 'Music Video / Audio Production / Live Tour Visuals',
            'url'       => '',
            'excerpt'   => 'Music video direction, custom live tour visuals, and surround audio mastering for independent recording artist Static Frequency.',
            'content'   => '<p>Produced end-to-end by MILEYM3DIA, including music video production, tour visual packages, and studio audio mastering.</p>',
            'challenge' => 'Static Frequency needed an immersive visual world to accompany their 18-city headline tour and lead single release. The challenge was syncing 4K stage visuals to MIDI timecode while delivering a cinematic music video with authentic studio audio fidelity.',
            'solution'  => 'MILEYM3DIA built a multi-discipline pipeline: tracking 120fps high-speed camera footage, developing custom generative tour visual loops synced to audio triggers, and executing final Dolby Atmos stereo mix and mastering in our audio suite.',
            'stats'     => array(
                array('num' => '18-CITY', 'label' => 'Headline Tour Visuals'),
                array('num' => '96kHz/24b', 'label' => 'Master Audio Fidelity'),
                array('num' => '100%', 'label' => 'Sync to MIDI Stage Rig'),
                array('num' => '850K+', 'label' => 'Single Stream Plays'),
            ),
        ),
        'monolith-audio-hardware' => array(
            'slot'      => 3,
            'slug'      => 'monolith-audio-hardware',
            'title'     => 'MONOLITH AUDIO HARDWARE',
            'cat_name'  => 'Brand Identity & Web Design',
            'cat_slug'  => 'branding',
            'accent'    => 'lime',
            'year'      => '2025',
            'client'    => 'MONOLITH LABS',
            'services'  => 'Brand Identity / Web Design / Packaging System',
            'url'       => '',
            'excerpt'   => 'Complete visual identity, custom typography, packaging design, and e-commerce web design for Monolith Labs.',
            'content'   => '<p>Full brand identity system, product photography, packaging design, and custom e-commerce website built for Monolith Labs.</p>',
            'challenge' => 'Monolith Labs engineered a premium studio monitor controller for professional audio producers and needed a visual identity and digital storefront that commanded a $1,200 retail price tag with absolute credibility.',
            'solution'  => 'We crafted a brutalist industrial brand system: custom wordmark typography, matte-black unboxing packaging with foil accents, studio macro product photography, and a lightning-fast responsive web store with 3D product previews.',
            'stats'     => array(
                array('num' => '100%', 'label' => 'Sold Out Initial Run'),
                array('num' => '0.8s', 'label' => 'E-Commerce Page Speed'),
                array('num' => '32-ASSET', 'label' => 'Complete Brand Identity'),
                array('num' => '$420K+', 'label' => 'Launch Month Revenue'),
            ),
        ),
        'apex-motorsport-identity' => array(
            'slot'      => 4,
            'slug'      => 'apex-motorsport-identity',
            'title'     => 'APEX MOTORSPORT IDENTITY',
            'cat_name'  => 'Branding & Photography',
            'cat_slug'  => 'photo',
            'accent'    => 'blue',
            'year'      => '2025',
            'client'    => 'APEX RACING CO.',
            'services'  => 'Branding / Photography / Apparel Graphics',
            'url'       => '',
            'excerpt'   => 'Custom brand identity system, team apparel graphics, and trackside photography for Apex Racing.',
            'content'   => '<p>Complete visual identity, vehicle livery design, apparel graphics, and high-speed trackside photography for Apex Racing Co.</p>',
            'challenge' => 'Apex Racing needed a high-octane visual refresh for their GT3 racing campaign, requiring vehicle liveries, paddock team kits, merchandise designs, and dynamic trackside imagery that captured blistering speeds under changing track conditions.',
            'solution'  => 'Our team designed full 3M wrap liveries, engineered a streetwear-inspired apparel line, and deployed trackside with high-speed telephoto setups to capture race-day drama, pit stops, and high-contrast motion blur.',
            'stats'     => array(
                array('num' => '1/8000s', 'label' => 'High-Speed Action Stills'),
                array('num' => 'GT3', 'label' => 'Full Livery Vehicle Wrap'),
                array('num' => '14-PIECE', 'label' => 'Apparel & Paddock Line'),
                array('num' => '4.2M+', 'label' => 'Season Impressions'),
            ),
        ),
    );
}

/**
 * Automatically create core pages and portfolio projects in WordPress if missing
 */
function mileym3dia_ensure_core_pages_and_content() {
    if (!function_exists('wp_insert_post') || !function_exists('update_post_meta')) {
        return;
    }

    $core_pages = array(
        'about'       => array('title' => 'About',       'template' => 'page-about.php'),
        'services'    => array('title' => 'Services',    'template' => 'page-services.php'),
        'work'        => array('title' => 'Work',        'template' => 'page-portfolio.php'),
        'portfolio'   => array('title' => 'Portfolio',   'template' => 'page-portfolio.php'),
        'blog'        => array('title' => 'Blog',        'template' => 'page-blog.php'),
        'store'       => array('title' => 'Store',       'template' => 'page-store.php'),
        'contact'     => array('title' => 'Contact',     'template' => 'page-contact.php'),
        'resources'     => array('title' => 'Resources',       'template' => 'page-resources.php'),
        'creator-hub'   => array('title' => 'Creator Hub',     'template' => 'page-creator-hub.php'),
        'privacy-terms' => array('title' => 'Privacy & Terms', 'template' => 'page-privacy-terms.php'),
    );

    $changed = false;

    foreach ($core_pages as $slug => $info) {
        $existing = get_page_by_path($slug, OBJECT, 'page');
        if (!$existing) {
            $page_id = wp_insert_post(array(
                'post_title'   => $info['title'],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ));
            if ($page_id && !is_wp_error($page_id) && !empty($info['template'])) {
                update_post_meta($page_id, '_wp_page_template', $info['template']);
                $changed = true;
            }
        } else {
            if ('publish' !== $existing->post_status && function_exists('wp_update_post')) {
                wp_update_post(array(
                    'ID'          => $existing->ID,
                    'post_status' => 'publish',
                ));
                $changed = true;
            }
            if (!empty($info['template'])) {
                $cur_tpl = get_post_meta($existing->ID, '_wp_page_template', true);
                if (empty($cur_tpl) || 'default' === $cur_tpl) {
                    update_post_meta($existing->ID, '_wp_page_template', $info['template']);
                }
            }
        }
    }

    if (post_type_exists('project')) {
        $default_projects = mileym3dia_get_default_projects_data();
        foreach ($default_projects as $slug => $proj) {
            $existing_proj = get_page_by_path($slug, OBJECT, 'project');
            if (!$existing_proj) {
                $proj_id = wp_insert_post(array(
                    'post_title'   => $proj['title'],
                    'post_name'    => $slug,
                    'post_status'  => 'publish',
                    'post_type'    => 'project',
                    'post_excerpt' => $proj['excerpt'],
                    'post_content' => $proj['content'],
                ));
                if ($proj_id && !is_wp_error($proj_id)) {
                    update_post_meta($proj_id, '_project_year', $proj['year']);
                    update_post_meta($proj_id, '_project_client', $proj['client']);
                    update_post_meta($proj_id, '_project_services', $proj['services']);
                    update_post_meta($proj_id, '_project_url', $proj['url']);
                    update_post_meta($proj_id, '_project_challenge', $proj['challenge']);
                    update_post_meta($proj_id, '_project_solution', $proj['solution']);
                    update_post_meta($proj_id, '_project_stats', $proj['stats']);
                    if (taxonomy_exists('project_category') && function_exists('wp_set_object_terms')) {
                        wp_set_object_terms($proj_id, $proj['cat_name'], 'project_category');
                    }
                    $changed = true;
                }
            }
        }
    }

    if (($changed || !get_option('mileym3dia_rewrites_flushed_v24')) && function_exists('flush_rewrite_rules')) {
        flush_rewrite_rules(false);
        if (function_exists('update_option')) {
            update_option('mileym3dia_rewrites_flushed_v24', '1');
        }
    }
}
add_action('init', 'mileym3dia_ensure_core_pages_and_content', 20);
add_action('after_switch_theme', 'mileym3dia_ensure_core_pages_and_content');

/**
 * Virtual route fallback so core studio pages and case studies never 404 in WordPress
 * even if permalinks haven't been flushed or pages were deleted.
 */
function mileym3dia_virtual_route_fallback($template) {
    if (!is_404()) {
        if (is_page('blog') || is_page('journal')) {
            $blog_tpl = get_template_directory() . '/page-blog.php';
            if (file_exists($blog_tpl)) {
                return $blog_tpl;
            }
        }
        return $template;
    }

    $req_uri  = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '';
    $req_path = trim((string) parse_url($req_uri, PHP_URL_PATH), '/');
    $home_path = trim((string) parse_url(home_url('/'), PHP_URL_PATH), '/');
    if ($home_path && 0 === strpos($req_path, $home_path)) {
        $req_path = trim(substr($req_path, strlen($home_path)), '/');
    }
    if (0 === strpos($req_path, 'index.php/')) {
        $req_path = trim(substr($req_path, strlen('index.php/')), '/');
    }

    $page_template_map = array(
        'about'       => 'page-about.php',
        'services'    => 'page-services.php',
        'pricing'     => 'page-services.php',
        'work'        => 'page-portfolio.php',
        'portfolio'   => 'page-portfolio.php',
        'projects'    => 'page-portfolio.php',
        'project'     => 'page-portfolio.php',
        'blog'        => 'page-blog.php',
        'journal'     => 'page-blog.php',
        'store'       => 'page-store.php',
        'shop'        => 'page-store.php',
        'contact'       => 'page-contact.php',
        'resources'     => 'page-resources.php',
        'creator-hub'   => 'page-creator-hub.php',
        'privacy-terms' => 'page-privacy-terms.php',
        'privacy'       => 'page-privacy-terms.php',
        'terms'         => 'page-privacy-terms.php',
    );

    global $wp_query, $post;

    if (isset($page_template_map[$req_path])) {
        $tpl_file = get_template_directory() . '/' . $page_template_map[$req_path];
        if (file_exists($tpl_file)) {
            if (function_exists('status_header')) {
                status_header(200);
            }
            if (isset($wp_query) && is_object($wp_query)) {
                $wp_query->is_404      = false;
                $wp_query->is_page     = true;
                $wp_query->is_singular = true;
                $dummy_post = (object) array(
                    'ID'           => 0,
                    'post_title'   => strtoupper(str_replace('-', ' ', $req_path)),
                    'post_name'    => $req_path,
                    'post_content' => '',
                    'post_excerpt' => '',
                    'post_status'  => 'publish',
                    'post_type'    => 'page',
                    'post_author'  => 1,
                    'post_date'    => date('Y-m-d H:i:s'),
                );
                if (class_exists('WP_Post')) {
                    $dummy_post = new WP_Post($dummy_post);
                }
                $wp_query->post        = $dummy_post;
                $wp_query->posts       = array($dummy_post);
                $wp_query->post_count  = 1;
                $wp_query->found_posts = 1;
                $post = $dummy_post;
            }
            return $tpl_file;
        }
    }

    if (0 === strpos($req_path, 'project/')) {
        $proj_slug = trim(substr($req_path, strlen('project/')), '/');
        $defaults  = mileym3dia_get_default_projects_data();
        $proj_data = isset($defaults[$proj_slug]) ? $defaults[$proj_slug] : reset($defaults);
        $tpl_file  = get_template_directory() . '/single-project.php';

        if (file_exists($tpl_file) && $proj_data) {
            if (function_exists('status_header')) {
                status_header(200);
            }
            if (isset($wp_query) && is_object($wp_query)) {
                $wp_query->is_404      = false;
                $wp_query->is_single   = true;
                $wp_query->is_singular = true;
                $dummy_proj = (object) array(
                    'ID'           => -1 * (int) $proj_data['slot'],
                    'post_title'   => $proj_data['title'],
                    'post_name'    => $proj_data['slug'],
                    'post_content' => $proj_data['content'],
                    'post_excerpt' => $proj_data['excerpt'],
                    'post_status'  => 'publish',
                    'post_type'    => 'project',
                    'post_author'  => 1,
                    'post_date'    => date('Y-m-d H:i:s'),
                );
                if (class_exists('WP_Post')) {
                    $dummy_proj = new WP_Post($dummy_proj);
                }
                $wp_query->post        = $dummy_proj;
                $wp_query->posts       = array($dummy_proj);
                $wp_query->post_count  = 1;
                $wp_query->found_posts = 1;
                $post = $dummy_proj;
            }
            return $tpl_file;
        }
    }

    return $template;
}
add_filter('template_include', 'mileym3dia_virtual_route_fallback', 99);

function mileym3dia_filter_nav_menu_objects($items, $args) {
    if (empty($items) || !is_array($items)) {
        return $items;
    }
    foreach ($items as &$item) {
        if (!empty($item->url) && !empty($item->title)) {
            $item->url = Mileym3dia_Walker_Nav_Menu::resolve_dynamic_url($item->url, $item->title);
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'mileym3dia_filter_nav_menu_objects', 10, 2);

function mileym3dia_default_nav_menu() {
    $is_home      = is_front_page();
    $is_about     = is_page('about') || is_page_template('page-about.php');
    $is_services  = is_page('services') || is_page_template('page-services.php');
    $is_work      = is_page('work') || is_page('portfolio') || is_page_template('page-portfolio.php') || is_page_template('page-work.php') || is_post_type_archive('project') || is_singular('project');
    $is_store     = is_page('store') || is_page('shop') || is_page_template('page-store.php') || (function_exists('is_woocommerce') && is_woocommerce());
    $is_blog      = is_home() || is_page('blog') || is_page('resources') || is_page_template('page-blog.php') || is_page_template('page-resources.php') || (is_archive() && !is_post_type_archive('project')) || is_singular('post');
    $is_hub       = is_page('creator-hub') || is_page_template('page-creator-hub.php');
    $is_contact   = is_page('contact') || is_page_template('page-contact.php');

    echo '<ul class="nav-menu">';
    echo '<li class="nav-item' . ($is_home ? ' active current-menu-item' : '') . '"><a href="' . esc_url(home_url('/')) . '" data-number="01">' . esc_html__('HOME', 'm3-big-red') . '</a></li>';

    // ABOUT with dropdown
    echo '<li class="nav-item has-dropdown menu-item-has-children' . ($is_about ? ' active current-menu-item' : '') . '">';
    echo '<a href="' . esc_url(mileym3dia_get_page_url('about')) . '" data-number="02">' . esc_html__('ABOUT', 'm3-big-red') . ' <span class="nav-caret" aria-hidden="true">▾</span></a>';
    echo '<ul class="sub-menu">';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('about')) . '#overview">' . esc_html__('Agency Overview & Vision', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('about')) . '#process">' . esc_html__('Production Pipeline & Process', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('about')) . '#gear">' . esc_html__('Studio Gear & Technology', 'm3-big-red') . '</a></li>';
    echo '</ul>';
    echo '</li>';

    // SERVICES with dropdown (Packages & Bundle Builder live inside Services)
    echo '<li class="nav-item has-dropdown menu-item-has-children' . ($is_services ? ' active current-menu-item' : '') . '">';
    echo '<a href="' . esc_url(mileym3dia_get_page_url('services')) . '" data-number="03">' . esc_html__('SERVICES', 'm3-big-red') . ' <span class="nav-caret" aria-hidden="true">▾</span></a>';
    echo '<ul class="sub-menu">';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('services')) . '#services">' . esc_html__('Core Creative Disciplines', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('services')) . '#pricing">' . esc_html__('Curated Packages ($350 - $1,450)', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('services')) . '?view=bundle#bundle">' . esc_html__('Custom Bundle Builder (Save 10%)', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('services')) . '#quote">' . esc_html__('Request Custom Quote', 'm3-big-red') . '</a></li>';
    echo '</ul>';
    echo '</li>';

    // WORK with dropdown
    echo '<li class="nav-item has-dropdown menu-item-has-children' . ($is_work ? ' active current-menu-item' : '') . '">';
    echo '<a href="' . esc_url(mileym3dia_get_work_page_url()) . '" data-number="04">' . esc_html__('WORK', 'm3-big-red') . ' <span class="nav-caret" aria-hidden="true">▾</span></a>';
    echo '<ul class="sub-menu">';
    echo '<li><a href="' . esc_url(mileym3dia_get_work_page_url()) . '">' . esc_html__('All Featured Productions', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_project_url('nightfall-apparel-campaign')) . '">' . esc_html__('Nightfall Apparel Campaign', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_project_url('static-frequency-tour-visuals')) . '">' . esc_html__('Static Frequency Visuals', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_project_url('monolith-audio-hardware')) . '">' . esc_html__('Monolith Audio Hardware', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_project_url('apex-motorsport-identity')) . '">' . esc_html__('Apex Motorsport Identity', 'm3-big-red') . '</a></li>';
    echo '</ul>';
    echo '</li>';

    // STORE with dropdown
    $store_url = mileym3dia_get_page_url('store');
    echo '<li class="nav-item has-dropdown menu-item-has-children' . ($is_store ? ' active current-menu-item' : '') . '">';
    echo '<a href="' . esc_url($store_url) . '" data-number="05">' . esc_html__('STORE', 'm3-big-red') . ' <span class="nav-caret" aria-hidden="true">▾</span></a>';
    echo '<ul class="sub-menu">';
    echo '<li><a href="' . esc_url($store_url) . '">' . esc_html__('All Studio Products', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(add_query_arg('cat', 'luts-video', $store_url)) . '">' . esc_html__('LUTs & Video Packs', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(add_query_arg('cat', 'audio-stems', $store_url)) . '">' . esc_html__('Audio & Stem Vaults', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(add_query_arg('cat', 'templates-guides', $store_url)) . '">' . esc_html__('Templates & Guides', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(add_query_arg('cat', 'merch-passes', $store_url)) . '">' . esc_html__('Merch & Studio Passes', 'm3-big-red') . '</a></li>';
    echo '</ul>';
    echo '</li>';

    // JOURNAL & RESOURCES with dropdown
    echo '<li class="nav-item has-dropdown menu-item-has-children' . ($is_blog ? ' active current-menu-item' : '') . '">';
    echo '<a href="' . esc_url(mileym3dia_get_blog_page_url()) . '" data-number="06">' . esc_html__('JOURNAL', 'm3-big-red') . ' <span class="nav-caret" aria-hidden="true">▾</span></a>';
    echo '<ul class="sub-menu">';
    echo '<li><a href="' . esc_url(mileym3dia_get_blog_page_url()) . '">' . esc_html__('Studio Journal (All Posts)', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/category/video-production/')) . '">' . esc_html__('Video Production', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/category/branding-web/')) . '">' . esc_html__('Branding & Web', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('resources')) . '">' . esc_html__('Free Creator Resources', 'm3-big-red') . '</a></li>';
    echo '</ul>';
    echo '</li>';

    // CREATOR HUB / REGISTRATION with dropdown
    $hub_url = mileym3dia_get_page_url('creator-hub');
    echo '<li class="nav-item has-dropdown menu-item-has-children' . ($is_hub ? ' active current-menu-item' : '') . '">';
    echo '<a href="' . esc_url($hub_url) . '" data-number="07">' . esc_html__('PORTAL', 'm3-big-red') . ' <span class="nav-caret" aria-hidden="true">▾</span></a>';
    echo '<ul class="sub-menu">';
    echo '<li><a href="' . esc_url(add_query_arg('tab', 'register', $hub_url)) . '">' . esc_html__('Create Account / Register', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(add_query_arg('tab', 'login', $hub_url)) . '">' . esc_html__('Client & Member Sign In', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url($hub_url) . '#member-vault">' . esc_html__('Deliverables & Download Vault', 'm3-big-red') . '</a></li>';
    echo '</ul>';
    echo '</li>';

    echo '<li class="nav-item' . ($is_contact ? ' active current-menu-item' : '') . '"><a href="' . esc_url(mileym3dia_get_page_url('contact')) . '" data-number="08">' . esc_html__('CONTACT', 'm3-big-red') . '</a></li>';
    echo '</ul>';
}

function mileym3dia_default_mobile_nav_menu() {
    $is_home      = is_front_page();
    $is_about     = is_page('about') || is_page_template('page-about.php');
    $is_services  = is_page('services') || is_page_template('page-services.php');
    $is_work      = is_page('work') || is_page('portfolio') || is_page_template('page-portfolio.php') || is_page_template('page-work.php') || is_post_type_archive('project') || is_singular('project');
    $is_store     = is_page('store') || is_page('shop') || is_page_template('page-store.php') || (function_exists('is_woocommerce') && is_woocommerce());
    $is_blog      = is_home() || is_page('blog') || is_page('resources') || is_page_template('page-blog.php') || is_page_template('page-resources.php') || (is_archive() && !is_post_type_archive('project')) || is_singular('post');
    $is_hub       = is_page('creator-hub') || is_page_template('page-creator-hub.php');
    $is_contact   = is_page('contact') || is_page_template('page-contact.php');

    $store_url = mileym3dia_get_page_url('store');
    $hub_url   = mileym3dia_get_page_url('creator-hub');

    echo '<ul class="mobile-nav-menu">';
    echo '<li class="mobile-nav-item' . ($is_home ? ' active' : '') . '"><a href="' . esc_url(home_url('/')) . '" data-number="01"><span class="nav-num">01</span><span class="nav-label">' . esc_html__('HOME', 'm3-big-red') . '</span><span class="nav-tag">STUDIO</span></a></li>';

    // ABOUT
    echo '<li class="mobile-nav-item mobile-nav-has-children' . ($is_about ? ' active' : '') . '">';
    echo '<div class="mobile-nav-link-row">';
    echo '<a href="' . esc_url(mileym3dia_get_page_url('about')) . '" data-number="02"><span class="nav-num">02</span><span class="nav-label">' . esc_html__('ABOUT', 'm3-big-red') . '</span><span class="nav-tag">AGENCY</span></a>';
    echo '<button type="button" class="mobile-sub-toggle" aria-label="Toggle submenu">▾</button>';
    echo '</div>';
    echo '<ul class="mobile-sub-menu">';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('about')) . '#overview">' . esc_html__('Overview & Vision', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('about')) . '#process">' . esc_html__('Production Pipeline', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('about')) . '#gear">' . esc_html__('Studio Gear', 'm3-big-red') . '</a></li>';
    echo '</ul>';
    echo '</li>';

    // SERVICES
    echo '<li class="mobile-nav-item mobile-nav-has-children' . ($is_services ? ' active' : '') . '">';
    echo '<div class="mobile-nav-link-row">';
    echo '<a href="' . esc_url(mileym3dia_get_page_url('services')) . '" data-number="03"><span class="nav-num">03</span><span class="nav-label">' . esc_html__('SERVICES', 'm3-big-red') . '</span><span class="nav-tag">CAPABILITIES</span></a>';
    echo '<button type="button" class="mobile-sub-toggle" aria-label="Toggle submenu">▾</button>';
    echo '</div>';
    echo '<ul class="mobile-sub-menu">';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('services')) . '#services">' . esc_html__('Creative Disciplines', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('services')) . '#pricing">' . esc_html__('Curated Packages ($350 - $1,450)', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('services')) . '?view=bundle#bundle">' . esc_html__('Custom Bundle Builder', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('services')) . '#quote">' . esc_html__('Request Custom Quote', 'm3-big-red') . '</a></li>';
    echo '</ul>';
    echo '</li>';

    // WORK
    echo '<li class="mobile-nav-item mobile-nav-has-children' . ($is_work ? ' active' : '') . '">';
    echo '<div class="mobile-nav-link-row">';
    echo '<a href="' . esc_url(mileym3dia_get_work_page_url()) . '" data-number="04"><span class="nav-num">04</span><span class="nav-label">' . esc_html__('WORK', 'm3-big-red') . '</span><span class="nav-tag">PORTFOLIO</span></a>';
    echo '<button type="button" class="mobile-sub-toggle" aria-label="Toggle submenu">▾</button>';
    echo '</div>';
    echo '<ul class="mobile-sub-menu">';
    echo '<li><a href="' . esc_url(mileym3dia_get_work_page_url()) . '">' . esc_html__('All Case Studies', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_project_url('nightfall-apparel-campaign')) . '">' . esc_html__('Nightfall Apparel', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_project_url('static-frequency-tour-visuals')) . '">' . esc_html__('Static Frequency', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_project_url('monolith-audio-hardware')) . '">' . esc_html__('Monolith Audio', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_project_url('apex-motorsport-identity')) . '">' . esc_html__('Apex Motorsport', 'm3-big-red') . '</a></li>';
    echo '</ul>';
    echo '</li>';

    // STORE
    echo '<li class="mobile-nav-item mobile-nav-has-children' . ($is_store ? ' active' : '') . '">';
    echo '<div class="mobile-nav-link-row">';
    echo '<a href="' . esc_url($store_url) . '" data-number="05"><span class="nav-num">05</span><span class="nav-label">' . esc_html__('STORE', 'm3-big-red') . '</span><span class="nav-tag">SHOP</span></a>';
    echo '<button type="button" class="mobile-sub-toggle" aria-label="Toggle submenu">▾</button>';
    echo '</div>';
    echo '<ul class="mobile-sub-menu">';
    echo '<li><a href="' . esc_url($store_url) . '">' . esc_html__('All Studio Products', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(add_query_arg('cat', 'luts-video', $store_url)) . '">' . esc_html__('LUTs & Video Packs', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(add_query_arg('cat', 'audio-stems', $store_url)) . '">' . esc_html__('Audio & Stem Vaults', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(add_query_arg('cat', 'templates-guides', $store_url)) . '">' . esc_html__('Templates & Guides', 'm3-big-red') . '</a></li>';
    echo '</ul>';
    echo '</li>';

    // JOURNAL & RESOURCES
    echo '<li class="mobile-nav-item mobile-nav-has-children' . ($is_blog ? ' active' : '') . '">';
    echo '<div class="mobile-nav-link-row">';
    echo '<a href="' . esc_url(mileym3dia_get_blog_page_url()) . '" data-number="06"><span class="nav-num">06</span><span class="nav-label">' . esc_html__('JOURNAL', 'm3-big-red') . '</span><span class="nav-tag">BLOG & TOOLS</span></a>';
    echo '<button type="button" class="mobile-sub-toggle" aria-label="Toggle submenu">▾</button>';
    echo '</div>';
    echo '<ul class="mobile-sub-menu">';
    echo '<li><a href="' . esc_url(mileym3dia_get_blog_page_url()) . '">' . esc_html__('All Articles', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(mileym3dia_get_page_url('resources')) . '">' . esc_html__('Free Creator Resources', 'm3-big-red') . '</a></li>';
    echo '</ul>';
    echo '</li>';

    // CREATOR HUB / REGISTRATION
    echo '<li class="mobile-nav-item mobile-nav-has-children' . ($is_hub ? ' active' : '') . '">';
    echo '<div class="mobile-nav-link-row">';
    echo '<a href="' . esc_url($hub_url) . '" data-number="07"><span class="nav-num">07</span><span class="nav-label">' . esc_html__('PORTAL', 'm3-big-red') . '</span><span class="nav-tag">REGISTER</span></a>';
    echo '<button type="button" class="mobile-sub-toggle" aria-label="Toggle submenu">▾</button>';
    echo '</div>';
    echo '<ul class="mobile-sub-menu">';
    echo '<li><a href="' . esc_url(add_query_arg('tab', 'register', $hub_url)) . '">' . esc_html__('Create Account', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url(add_query_arg('tab', 'login', $hub_url)) . '">' . esc_html__('Client Sign In', 'm3-big-red') . '</a></li>';
    echo '<li><a href="' . esc_url($hub_url) . '#member-vault">' . esc_html__('Download Vault', 'm3-big-red') . '</a></li>';
    echo '</ul>';
    echo '</li>';

    echo '<li class="mobile-nav-item' . ($is_contact ? ' active' : '') . '"><a href="' . esc_url(mileym3dia_get_page_url('contact')) . '" data-number="08"><span class="nav-num">08</span><span class="nav-label">' . esc_html__('CONTACT', 'm3-big-red') . '</span><span class="nav-tag">BOOKING</span></a></li>';
    echo '</ul>';
}

/**
 * Default Studio Store Products (Customizer-overridable)
 */
function mileym3dia_get_default_store_products() {
    $files_base = get_template_directory_uri() . '/assets/files/';
    return array(
        array(
            'title'          => 'M3 35mm Cinema LUT Suite (12 LUTs)',
            'price'          => '$49',
            'category_slug'  => 'luts-video',
            'category_label' => 'LUTS & VIDEO',
            'badge'          => 'BEST SELLER',
            'format'         => '.CUBE // LOG & REC.709',
            'desc'           => 'Twelve production-calibrated color grading LUTs for RED, Sony S-Log3, Blackmagic, and Canon cameras.',
            'btn_text'       => 'ADD TO CART',
            'secondary_text' => 'FREE SAMPLE .CUBE ↓',
            'checkout_url'   => $files_base . 'm3-35mm-cinema-lut-pack.cube',
            'image'          => mileym3dia_asset_image_url('portfolio-1.jpg'),
        ),
        array(
            'title'          => 'Obsidian Analog Drum & Synth Vault',
            'price'          => '$39',
            'category_slug'  => 'audio-stems',
            'category_label' => 'AUDIO & STEMS',
            'badge'          => 'STUDIO MASTER',
            'format'         => '24-BIT / 48KHZ WAV',
            'desc'           => '140+ royalty-free punchy drums, sub-bass loops, analog synth textures, and cinema risers tracked in-house.',
            'btn_text'       => 'ADD TO CART',
            'secondary_text' => 'SPEC SHEET ↓',
            'checkout_url'   => $files_base . 'm3-studio-audio-stem-guide.txt',
            'image'          => mileym3dia_asset_image_url('portfolio-2.jpg'),
        ),
        array(
            'title'          => 'Brutalist Brand & Lookbook System',
            'price'          => '$59',
            'category_slug'  => 'templates-guides',
            'category_label' => 'TEMPLATES & GUIDES',
            'badge'          => 'NEW DROP',
            'format'         => 'FIGMA + INDESIGN + PDF',
            'desc'           => 'Modular 12-column editorial lookbook, pitch deck, and brand identity presentation system built for agencies.',
            'btn_text'       => 'ADD TO CART',
            'secondary_text' => 'LAYOUT GUIDE ↓',
            'checkout_url'   => $files_base . 'm3-brand-lookbook-layout-guide.txt',
            'image'          => mileym3dia_asset_image_url('portfolio-3.jpg'),
        ),
        array(
            'title'          => 'Producer Call Sheet & Set Kit Pro',
            'price'          => '$24',
            'category_slug'  => 'templates-guides',
            'category_label' => 'TEMPLATES & GUIDES',
            'badge'          => 'WORKFLOW',
            'format'         => 'NOTION + SHEETS + PDF',
            'desc'           => 'Complete commercial & music video pre-production toolkit: call sheets, shot lists, DIT logs, and release forms.',
            'btn_text'       => 'ADD TO CART',
            'secondary_text' => 'FREE CHECKLIST ↓',
            'checkout_url'   => $files_base . 'm3-production-call-sheet-checklist.txt',
            'image'          => mileym3dia_asset_image_url('blog-1.jpg'),
        ),
        array(
            'title'          => 'M3 Big Red Heavyweight Studio Hoodie',
            'price'          => '$75',
            'category_slug'  => 'merch-passes',
            'category_label' => 'MERCH & PASSES',
            'badge'          => 'LIMITED RUN',
            'format'         => '480GSM // S - XXL',
            'desc'           => 'Heavyweight 480gsm jet-black French terry hoodie with high-density crimson M3 chest & back screenprint.',
            'btn_text'       => 'ADD TO CART',
            'secondary_text' => '',
            'checkout_url'   => '',
            'image'          => mileym3dia_asset_image_url('about-image.jpg'),
        ),
        array(
            'title'          => 'Priority 4K Retainer Day Pass',
            'price'          => '$450',
            'category_slug'  => 'merch-passes',
            'category_label' => 'MERCH & PASSES',
            'badge'          => 'STUDIO PASS',
            'format'         => '1-DAY STUDIO CREDIT',
            'desc'           => 'Lock in a priority 1-day studio shoot, audio mix, or edit sprint with 48-hour express master delivery.',
            'btn_text'       => 'ADD TO CART',
            'secondary_text' => '',
            'checkout_url'   => '',
            'image'          => mileym3dia_asset_image_url('portfolio-4.jpg'),
        ),
    );
}

function mileym3dia_get_store_products() {
    $defaults = mileym3dia_get_default_store_products();
    $cat_labels = array(
        'luts-video'       => 'LUTS & VIDEO',
        'audio-stems'      => 'AUDIO & STEMS',
        'templates-guides' => 'TEMPLATES & GUIDES',
        'merch-passes'     => 'MERCH & PASSES',
    );

    $products = array();
    foreach ($defaults as $idx => $item) {
        $n        = $idx + 1;
        $cat_slug = get_theme_mod("mileym3dia_store_item_{$n}_category_slug", $item['category_slug']);
        $img      = get_theme_mod("mileym3dia_store_item_{$n}_image", $item['image']);
        if (empty($img)) {
            $img = $item['image'];
        }
        $products[] = array(
            'title'          => get_theme_mod("mileym3dia_store_item_{$n}_title", $item['title']),
            'price'          => get_theme_mod("mileym3dia_store_item_{$n}_price", $item['price']),
            'category_slug'  => $cat_slug,
            'category_label' => isset($cat_labels[$cat_slug]) ? $cat_labels[$cat_slug] : $item['category_label'],
            'badge'          => get_theme_mod("mileym3dia_store_item_{$n}_badge", $item['badge']),
            'format'         => get_theme_mod("mileym3dia_store_item_{$n}_format", $item['format']),
            'desc'           => get_theme_mod("mileym3dia_store_item_{$n}_desc", $item['desc']),
            'btn_text'       => get_theme_mod("mileym3dia_store_item_{$n}_btn_text", $item['btn_text']),
            'secondary_text' => $item['secondary_text'],
            'checkout_url'   => get_theme_mod("mileym3dia_store_item_{$n}_checkout_url", $item['checkout_url']),
            'image'          => $img,
        );
    }
    return $products;
}

/**
 * Native WordPress Registration, Sign-In, and Store Order Handler
 */
function mileym3dia_handle_portal_and_store_posts() {
    if ('POST' !== ($_SERVER['REQUEST_METHOD'] ?? '')) {
        return;
    }
    $action = isset($_POST['mileym3dia_action']) ? sanitize_key(wp_unslash($_POST['mileym3dia_action'])) : '';
    if (empty($action)) {
        return;
    }

    if ('register_user' === $action && function_exists('wp_insert_user')) {
        if (!isset($_POST['mileym3dia_register_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mileym3dia_register_nonce'])), 'mileym3dia_register_action')) {
            return;
        }
        $username = sanitize_user(wp_unslash($_POST['reg_username'] ?? ''));
        $email    = sanitize_email(wp_unslash($_POST['reg_email'] ?? ''));
        $fullname = sanitize_text_field(wp_unslash($_POST['reg_fullname'] ?? ''));
        $password = (string) ($_POST['reg_password'] ?? '');
        $acc_type = sanitize_key(wp_unslash($_POST['reg_account_type'] ?? 'client'));
        $company  = sanitize_text_field(wp_unslash($_POST['reg_company'] ?? ''));

        $hub_url = mileym3dia_get_page_url('creator-hub');

        if (empty($username) || empty($email) || empty($password)) {
            wp_safe_redirect(add_query_arg(array('tab' => 'register', 'auth_error' => 'Please fill out all required registration fields.'), $hub_url) . '#portal-access');
            exit;
        }
        if (username_exists($username) || email_exists($email)) {
            wp_safe_redirect(add_query_arg(array('tab' => 'login', 'auth_error' => 'An account with that username or email already exists. Please sign in.'), $hub_url) . '#portal-access');
            exit;
        }

        $user_id = wp_insert_user(array(
            'user_login'   => $username,
            'user_email'   => $email,
            'user_pass'    => $password,
            'display_name' => $fullname ?: $username,
            'role'         => 'subscriber',
        ));

        if (is_wp_error($user_id)) {
            wp_safe_redirect(add_query_arg(array('tab' => 'register', 'auth_error' => $user_id->get_error_message()), $hub_url) . '#portal-access');
            exit;
        }

        update_user_meta($user_id, 'm3_account_type', $acc_type);
        update_user_meta($user_id, 'm3_company', $company);
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true);

        if (function_exists('wp_mail') && !empty($email)) {
            $studio_email = get_theme_mod('mileym3dia_contact_email', get_option('admin_email'));
            $welcome_body = "Welcome to MILEYM3DIA Creator Hub, " . ($fullname ?: $username) . "!\n\nYour studio account ({$username}) is now active. Sign in anytime at:\n{$hub_url}\n\n— MILEYM3DIA Studio";
            wp_mail($email, 'Welcome to MILEYM3DIA Creator Hub', $welcome_body);
            if (!empty($studio_email)) {
                wp_mail($studio_email, 'New Creator Hub Registration: ' . $username, "Name: {$fullname}\nEmail: {$email}\nType: {$acc_type}\nBrand/Code: {$company}");
            }
        }

        wp_safe_redirect(add_query_arg('auth', 'registered', $hub_url) . '#portal-access');
        exit;
    }

    if ('login_user' === $action && function_exists('wp_signon')) {
        if (!isset($_POST['mileym3dia_login_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mileym3dia_login_nonce'])), 'mileym3dia_login_action')) {
            return;
        }
        $creds = array(
            'user_login'    => sanitize_text_field(wp_unslash($_POST['log'] ?? '')),
            'user_password' => (string) ($_POST['pwd'] ?? ''),
            'remember'      => !empty($_POST['rememberme']),
        );
        $hub_url = mileym3dia_get_page_url('creator-hub');
        $user    = wp_signon($creds, is_ssl());

        if (is_wp_error($user)) {
            wp_safe_redirect(add_query_arg(array('tab' => 'login', 'auth_error' => 'Invalid username/email or password.'), $hub_url) . '#portal-access');
            exit;
        }
        wp_safe_redirect(add_query_arg('auth', 'logged_in', $hub_url) . '#portal-access');
        exit;
    }

    if ('store_order' === $action && function_exists('wp_mail')) {
        if (!isset($_POST['mileym3dia_store_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mileym3dia_store_nonce'])), 'mileym3dia_store_order')) {
            return;
        }
        $admin_email = get_theme_mod('mileym3dia_contact_email', get_option('admin_email'));
        $buyer_name  = sanitize_text_field(wp_unslash($_POST['order_name'] ?? ''));
        $buyer_email = sanitize_email(wp_unslash($_POST['order_email'] ?? ''));
        $summary     = sanitize_text_field(wp_unslash($_POST['order_selected_summary'] ?? ''));
        $total       = sanitize_text_field(wp_unslash($_POST['order_total'] ?? '$0'));
        $method      = sanitize_text_field(wp_unslash($_POST['order_payment_method'] ?? ''));
        $notes       = sanitize_textarea_field(wp_unslash($_POST['order_notes'] ?? ''));

        $body = "New M3 Studio Store Order Request:\n\nName: {$buyer_name}\nEmail: {$buyer_email}\nItems: {$summary}\nTotal: {$total}\nPayment Method: {$method}\nNotes: {$notes}\n";
        wp_mail($admin_email, 'M3 Studio Store Order: ' . $buyer_name, $body);
        if (!empty($buyer_email)) {
            wp_mail($buyer_email, 'MILEYM3DIA Studio Store — Order Confirmation', "Thanks {$buyer_name},\n\nWe received your Studio Store order ({$summary} — {$total}).\n\n— MILEYM3DIA Studio");
        }

        $stripe_link = esc_url_raw(get_theme_mod('mileym3dia_store_stripe_link', ''));
        $paypal_link = esc_url_raw(get_theme_mod('mileym3dia_store_paypal_link', ''));
        if ('card-invoice' === $method && !empty($stripe_link) && function_exists('wp_redirect')) {
            wp_redirect($stripe_link);
            exit;
        }
        if ('paypal-live' === $method && !empty($paypal_link) && function_exists('wp_redirect')) {
            wp_redirect($paypal_link);
            exit;
        }

        wp_safe_redirect(add_query_arg('order', 'placed', mileym3dia_get_page_url('store')) . '#checkout');
        exit;
    }
}
add_action('template_redirect', 'mileym3dia_handle_portal_and_store_posts');

/**
 * Configure Transactional Email (SMTP) & Sender Identity from Customizer
 */
function mileym3dia_mail_from_email($email) {
    $custom = get_theme_mod('mileym3dia_smtp_from_email', '');
    return is_email($custom) ? $custom : $email;
}
add_filter('wp_mail_from', 'mileym3dia_mail_from_email');

function mileym3dia_mail_from_name($name) {
    $custom = get_theme_mod('mileym3dia_smtp_from_name', '');
    return !empty($custom) ? sanitize_text_field($custom) : $name;
}
add_filter('wp_mail_from_name', 'mileym3dia_mail_from_name');

function mileym3dia_configure_smtp($phpmailer) {
    if (!get_theme_mod('mileym3dia_smtp_enabled', false)) {
        return;
    }
    $host = get_theme_mod('mileym3dia_smtp_host', '');
    if (empty($host)) {
        return;
    }
    $phpmailer->isSMTP();
    $phpmailer->Host       = $host;
    $phpmailer->Port       = absint(get_theme_mod('mileym3dia_smtp_port', 587));
    $phpmailer->SMTPSecure = sanitize_text_field(get_theme_mod('mileym3dia_smtp_encryption', 'tls'));
    $user                  = get_theme_mod('mileym3dia_smtp_username', '');
    $pass                  = get_theme_mod('mileym3dia_smtp_password', '');
    if (!empty($user) && !empty($pass)) {
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = $user;
        $phpmailer->Password = $pass;
    }
}
add_action('phpmailer_init', 'mileym3dia_configure_smtp');

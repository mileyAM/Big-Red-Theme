<?php
/**
 * MILEYM3DIA Theme Functions
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

define('MILEYM3DIA_VERSION', '2.5.0');

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/class-walker-nav-menu.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/meta-boxes.php';

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
        'primary' => __('Primary Menu', 'm3-big-red'),
        'footer'  => __('Footer Menu', 'm3-big-red'),
        'mobile'  => __('Mobile Menu', 'm3-big-red'),
        'social'  => __('Social Links Menu', 'm3-big-red'),
    ));

    set_post_thumbnail_size(1920, 1080, true);
    add_image_size('mileym3dia-hero', 2400, 1350, true);
    add_image_size('mileym3dia-large', 1600, 900, true);
    add_image_size('mileym3dia-medium', 800, 600, true);
    add_image_size('mileym3dia-small', 400, 300, true);
}
add_action('after_setup_theme', 'mileym3dia_setup');

/**
 * Register Portfolio Project, Service, Resource Library & Client Brief CPTs
 */
function mileym3dia_register_portfolio_cpt() {
    if (!post_type_exists('project') && function_exists('register_post_type')) {
        register_post_type('project', array(
            'labels' => array(
                'name'               => __('Projects', 'm3-big-red'),
                'singular_name'      => __('Project', 'm3-big-red'),
                'add_new'            => __('Add New Project', 'm3-big-red'),
                'add_new_item'       => __('Add New Project', 'm3-big-red'),
                'edit_item'          => __('Edit Project', 'm3-big-red'),
                'new_item'           => __('New Project', 'm3-big-red'),
                'view_item'          => __('View Project', 'm3-big-red'),
                'search_items'       => __('Search Projects', 'm3-big-red'),
                'not_found'          => __('No projects found', 'm3-big-red'),
                'not_found_in_trash' => __('No projects found in Trash', 'm3-big-red'),
                'menu_name'          => __('Portfolio', 'm3-big-red'),
            ),
            'public'       => true,
            'has_archive'  => true,
            'rewrite'      => array('slug' => 'project'),
            'menu_icon'    => 'dashicons-format-video',
            'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields'),
            'show_in_rest' => true,
        ));
    }

    if (!taxonomy_exists('project_category') && function_exists('register_taxonomy')) {
        register_taxonomy('project_category', array('project'), array(
            'labels' => array(
                'name'          => __('Project Categories', 'm3-big-red'),
                'singular_name' => __('Project Category', 'm3-big-red'),
            ),
            'public'       => true,
            'hierarchical' => true,
            'rewrite'      => array('slug' => 'project-category'),
            'show_in_rest' => true,
        ));
    }

    if (!post_type_exists('service') && function_exists('register_post_type')) {
        register_post_type('service', array(
            'labels' => array(
                'name'               => __('Services', 'm3-big-red'),
                'singular_name'      => __('Service', 'm3-big-red'),
                'add_new'            => __('Add New Service', 'm3-big-red'),
                'add_new_item'       => __('Add New Service', 'm3-big-red'),
                'edit_item'          => __('Edit Service', 'm3-big-red'),
                'new_item'           => __('New Service', 'm3-big-red'),
                'view_item'          => __('View Service', 'm3-big-red'),
                'search_items'       => __('Search Services', 'm3-big-red'),
                'not_found'          => __('No services found', 'm3-big-red'),
                'not_found_in_trash' => __('No services found in Trash', 'm3-big-red'),
                'menu_name'          => __('Services', 'm3-big-red'),
            ),
            'public'       => true,
            'has_archive'  => false,
            'rewrite'      => array('slug' => 'service'),
            'menu_icon'    => 'dashicons-megaphone',
            'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields'),
            'show_in_rest' => true,
        ));
    }

    if (!post_type_exists('m3_resource') && function_exists('register_post_type')) {
        register_post_type('m3_resource', array(
            'labels' => array(
                'name'               => __('Resources', 'm3-big-red'),
                'singular_name'      => __('Resource', 'm3-big-red'),
                'add_new'            => __('Add New Resource', 'm3-big-red'),
                'add_new_item'       => __('Add New Resource', 'm3-big-red'),
                'edit_item'          => __('Edit Resource', 'm3-big-red'),
                'new_item'           => __('New Resource', 'm3-big-red'),
                'view_item'          => __('View Resource', 'm3-big-red'),
                'search_items'       => __('Search Resources', 'm3-big-red'),
                'not_found'          => __('No resources found', 'm3-big-red'),
                'not_found_in_trash' => __('No resources found in Trash', 'm3-big-red'),
                'menu_name'          => __('Resources', 'm3-big-red'),
            ),
            'public'       => true,
            'has_archive'  => false,
            'rewrite'      => array('slug' => 'resource'),
            'menu_icon'    => 'dashicons-download',
            'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields'),
            'show_in_rest' => true,
        ));
    }

    if (!taxonomy_exists('resource_category') && function_exists('register_taxonomy')) {
        register_taxonomy('resource_category', array('m3_resource'), array(
            'labels' => array(
                'name'          => __('Resource Categories', 'm3-big-red'),
                'singular_name' => __('Resource Category', 'm3-big-red'),
            ),
            'public'       => true,
            'hierarchical' => true,
            'rewrite'      => array('slug' => 'resource-category'),
            'show_in_rest' => true,
        ));
    }

    if (!taxonomy_exists('resource_tag') && function_exists('register_taxonomy')) {
        register_taxonomy('resource_tag', array('m3_resource'), array(
            'labels' => array(
                'name'          => __('Resource Tags', 'm3-big-red'),
                'singular_name' => __('Resource Tag', 'm3-big-red'),
            ),
            'public'       => true,
            'hierarchical' => false,
            'rewrite'      => array('slug' => 'resource-tag'),
            'show_in_rest' => true,
        ));
    }

    if (!post_type_exists('m3_inquiry') && function_exists('register_post_type')) {
        register_post_type('m3_inquiry', array(
            'labels' => array(
                'name'          => __('Studio Briefs', 'm3-big-red'),
                'singular_name' => __('Studio Brief', 'm3-big-red'),
                'menu_name'     => __('Client Briefs', 'm3-big-red'),
            ),
            'public'       => false,
            'show_ui'      => true,
            'menu_icon'    => 'dashicons-clipboard',
            'supports'     => array('title', 'editor', 'custom-fields'),
            'show_in_rest' => false,
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
        '--bg-base'            => get_theme_mod('mileym3dia_bg_color', '#060609'),
        '--bg-elevated'        => get_theme_mod('mileym3dia_bg_elevated', '#0C0C12'),
        '--bg-surface'         => get_theme_mod('mileym3dia_bg_surface', '#12121B'),
        '--color-black'        => get_theme_mod('mileym3dia_bg_color', '#060609'),
        '--color-dark'         => get_theme_mod('mileym3dia_bg_elevated', '#0C0C12'),
        '--color-surface'      => get_theme_mod('mileym3dia_bg_surface', '#12121B'),
        '--color-white'        => get_theme_mod('mileym3dia_text_color', '#F4F4F6'),
        '--color-off-white'    => get_theme_mod('mileym3dia_text_color', '#F4F4F6'),
        '--color-red'          => get_theme_mod('mileym3dia_color_red', '#FF2442'),
        '--color-yellow'       => get_theme_mod('mileym3dia_color_yellow', '#FFDD00'),
        '--color-lime'         => get_theme_mod('mileym3dia_color_lime', '#00FF7F'),
        '--color-blue'         => get_theme_mod('mileym3dia_color_blue', '#38BDF8'),
        '--color-purple'       => get_theme_mod('mileym3dia_color_yellow', '#FFDD00'),
        '--accent-work'        => get_theme_mod('mileym3dia_accent_work', '#FF2442'),
        '--accent-services'    => get_theme_mod('mileym3dia_accent_services', '#00FF7F'),
        '--accent-about'       => get_theme_mod('mileym3dia_accent_about', '#FFDD00'),
        '--accent-resources'   => get_theme_mod('mileym3dia_accent_resources', '#38BDF8'),
        '--accent-contact'     => get_theme_mod('mileym3dia_accent_contact', '#FF2442'),
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
 * Canonical 5 MILEYM3DIA Service Categories for `project_category` taxonomy
 */
function mileym3dia_get_service_project_categories() {
    return array(
        'video-production' => array(
            'name'   => 'Video Production',
            'slug'   => 'video-production',
            'alias'  => 'video',
            'accent' => 'red',
            'label'  => 'VIDEO PRODUCTION',
        ),
        'photography' => array(
            'name'   => 'Photography',
            'slug'   => 'photography',
            'alias'  => 'photo',
            'accent' => 'blue',
            'label'  => 'PHOTOGRAPHY',
        ),
        'branding-design' => array(
            'name'   => 'Branding & Graphic Design',
            'slug'   => 'branding-design',
            'alias'  => 'branding',
            'accent' => 'lime',
            'label'  => 'BRANDING & DESIGN',
        ),
        'web-design' => array(
            'name'   => 'Web Design & Development',
            'slug'   => 'web-design',
            'alias'  => 'web',
            'accent' => 'yellow',
            'label'  => 'WEB DESIGN',
        ),
        'music-audio' => array(
            'name'   => 'Music & Audio Production',
            'slug'   => 'music-audio',
            'alias'  => 'audio',
            'accent' => 'yellow',
            'label'  => 'MUSIC & AUDIO',
        ),
    );
}

/**
 * Helper to expand a `project_category` slug into canonical slug + short alias tokens for filtering
 */
function mileym3dia_get_project_category_filter_tokens($slug) {
    $slug    = strtolower(trim((string) $slug));
    $service_cats = mileym3dia_get_service_project_categories();
    $tokens  = array($slug);

    if (isset($service_cats[$slug])) {
        $tokens[] = $service_cats[$slug]['alias'];
    } else {
        foreach ($service_cats as $c_slug => $c_info) {
            if ($c_info['alias'] === $slug) {
                $tokens[] = $c_slug;
                break;
            }
        }
    }
    return array_values(array_unique(array_filter($tokens)));
}

/**
 * Default 5 MILEYM3DIA Core Services data used for seeding and fallback rendering
 */
function mileym3dia_get_default_services() {
    return array(
        1 => array(
            'num'           => '01',
            'slug'          => 'video-production',
            'title'         => 'Video Production',
            'category_slug' => 'video-production',
            'tag'           => '4K / 8K CINEMA · COMMERCIALS · MUSIC VIDEOS',
            'accent'        => 'red',
            'desc'          => 'Cinema-grade music videos, brand commercials, documentaries, aerial drone capture, and professional DaVinci Resolve color grading.',
            'deliverables'  => 'Commercials & Brand Films, Music Videos & Performance, Color Grading & VFX, Documentary & Aerial',
            'cta_text'      => 'BOOK VIDEO PRODUCTION',
            'cta_url'       => '',
        ),
        2 => array(
            'num'           => '02',
            'slug'          => 'photography',
            'title'         => 'Photography',
            'category_slug' => 'photography',
            'tag'           => 'EDITORIAL · PRODUCT · CAMPAIGN STILLS',
            'accent'        => 'blue',
            'desc'          => 'High-impact brand lookbooks, studio & on-location portraits, artist press photos, commercial product photography, and retouching.',
            'deliverables'  => 'Lookbooks & Apparel, Product & Studio Stills, Artist Press & Portraits, Event & BTS Coverage',
            'cta_text'      => 'BOOK PHOTOGRAPHY',
            'cta_url'       => '',
        ),
        3 => array(
            'num'           => '03',
            'slug'          => 'branding-design',
            'title'         => 'Branding & Graphic Design',
            'category_slug' => 'branding-design',
            'tag'           => 'VISUAL IDENTITY · PACKAGING · KEY ART',
            'accent'        => 'lime',
            'desc'          => 'Memorable logo systems, typography, brand guidelines, merch & apparel graphics, album artwork, and physical packaging.',
            'deliverables'  => 'Logo & Identity Systems, Album & Tour Key Art, Packaging & Merch Design, Brand Guidelines',
            'cta_text'      => 'BOOK BRANDING & GRAPHIC DESIGN',
            'cta_url'       => '',
        ),
        4 => array(
            'num'           => '04',
            'slug'          => 'web-design',
            'title'         => 'Web Design & Development',
            'category_slug' => 'web-design',
            'tag'           => 'CUSTOM WORDPRESS · E-COMMERCE · INTERACTIVE',
            'accent'        => 'yellow',
            'desc'          => 'Fast, modern, custom-designed websites, artist & agency portfolios, landing pages, and WooCommerce / Shopify storefronts.',
            'deliverables'  => 'Custom WordPress Themes, WooCommerce Storefronts, Interactive Launch Sites, Performance & SEO',
            'cta_text'      => 'BOOK WEB DESIGN & DEVELOPMENT',
            'cta_url'       => '',
        ),
        5 => array(
            'num'           => '05',
            'slug'          => 'music-audio',
            'title'         => 'Music & Audio Production',
            'category_slug' => 'music-audio',
            'tag'           => 'MIXING · MASTERING · SOUND DESIGN · SCORING',
            'accent'        => 'red',
            'desc'          => 'Original music production, custom scoring for film & commercials, vocal mixing, mastering, and clean audio post-production.',
            'deliverables'  => 'Dolby Atmos & Stereo Mixing, Commercial Sound Design, Original Film Scoring, Stem Mastering',
            'cta_text'      => 'BOOK MUSIC & AUDIO PRODUCTION',
            'cta_url'       => '',
        ),
    );
}

/**
 * Retrieve normalized Services list from `service` CPT with Customizer override/fallback support
 */
function mileym3dia_get_services() {
    $defaults    = mileym3dia_get_default_services();
    $contact_url = mileym3dia_get_page_url('contact');

    // Old Customizer defaults from inc/customizer.php so we know whether a theme_mod was explicitly customized
    $legacy_customizer_defaults = array(
        1 => array('title' => 'Video Production', 'tag' => 'COMMERCIALS · MUSIC VIDEOS · REELS', 'desc' => 'Cinema-grade music videos, brand commercials, documentaries, aerial drone capture, and professional DaVinci Resolve color grading.', 'subtags' => 'Music Videos, Brand Films, Drone Capture, Color Grading'),
        2 => array('title' => 'Photography', 'tag' => 'EDITORIAL · PRODUCT · PRESS KITS', 'desc' => 'High-impact brand lookbooks, studio & on-location portraits, artist press photos, commercial product photography, and retouching.', 'subtags' => 'Lookbooks, Artist Press Kits, Product Stills, Event Coverage'),
        3 => array('title' => 'Branding & Graphic Design', 'tag' => 'IDENTITY · LOGOS · PACKAGING', 'desc' => 'Memorable logo systems, typography, brand guidelines, merch & apparel graphics, album artwork, and physical packaging.', 'subtags' => 'Logo Systems, Brand Guidelines, Apparel & Merch, Album Art'),
        4 => array('title' => 'Web Design & Development', 'tag' => 'CUSTOM SITES · E-COMMERCE · UI/UX', 'desc' => 'Fast, modern, custom-designed websites, artist & agency portfolios, landing pages, and WooCommerce / Shopify storefronts.', 'subtags' => 'Custom WordPress, E-Commerce, Responsive UI/UX, Landing Pages'),
        5 => array('title' => 'Music & Audio Production', 'tag' => 'RECORDING · MIXING · SOUND DESIGN', 'desc' => 'Original music production, custom scoring for film & commercials, vocal mixing, mastering, and clean audio post-production.', 'subtags' => 'Custom Scoring, Mixing & Mastering, Sound Design, Audio Post'),
    );

    $services = array();
    $query    = null;
    if (post_type_exists('service') && class_exists('WP_Query')) {
        $query = new WP_Query(array(
            'post_type'      => 'service',
            'posts_per_page' => 20,
            'post_status'    => 'publish',
            'orderby'        => array('menu_order' => 'ASC', 'ID' => 'ASC'),
        ));
    }

    if ($query && !empty($query->posts)) {
        $slot = 1;
        foreach ($query->posts as $srv_post) {
            $sid      = (int) $srv_post->ID;
            $def      = isset($defaults[$slot]) ? $defaults[$slot] : $defaults[1];
            $leg_def  = isset($legacy_customizer_defaults[$slot]) ? $legacy_customizer_defaults[$slot] : null;

            $num           = get_post_meta($sid, '_service_number', true) ?: str_pad((string) $slot, 2, '0', STR_PAD_LEFT);
            $title         = $srv_post->post_title ?: $def['title'];
            $slug          = $srv_post->post_name ?: sanitize_title($title);
            $tag           = get_post_meta($sid, '_service_tag', true) ?: $def['tag'];
            $desc          = $srv_post->post_excerpt ?: (strip_tags($srv_post->post_content) ?: $def['desc']);
            $deliv_raw     = get_post_meta($sid, '_service_deliverables', true) ?: $def['deliverables'];
            $accent        = get_post_meta($sid, '_service_accent', true) ?: $def['accent'];
            $cta_text      = get_post_meta($sid, '_service_cta_text', true) ?: ('BOOK ' . strtoupper($title));
            $cta_url       = get_post_meta($sid, '_service_cta_url', true);
            $category_slug = get_post_meta($sid, '_service_category_slug', true) ?: $def['category_slug'];
            $image         = function_exists('get_the_post_thumbnail_url') ? get_the_post_thumbnail_url($sid, 'full') : '';

            // Overlay non-default Customizer theme_mods for slots 1-5 if customized
            if ($slot <= 5 && $leg_def) {
                $mod_title = get_theme_mod("mileym3dia_service_{$slot}_title", $def['title']);
                if (!empty($mod_title) && $mod_title !== $def['title'] && $mod_title !== $leg_def['title']) {
                    $title = $mod_title;
                }
                $mod_tag = get_theme_mod("mileym3dia_service_{$slot}_tag", $def['tag']);
                if (!empty($mod_tag) && $mod_tag !== $def['tag'] && $mod_tag !== $leg_def['tag']) {
                    $tag = $mod_tag;
                }
                $mod_desc = get_theme_mod("mileym3dia_service_{$slot}_desc", $def['desc']);
                if (!empty($mod_desc) && $mod_desc !== $def['desc'] && $mod_desc !== $leg_def['desc']) {
                    $desc = $mod_desc;
                }
                $mod_subtags = get_theme_mod("mileym3dia_service_{$slot}_subtags", $def['deliverables']);
                if (!empty($mod_subtags) && $mod_subtags !== $def['deliverables'] && $mod_subtags !== $leg_def['subtags']) {
                    $deliv_raw = $mod_subtags;
                }
            }

            $subtags = array_values(array_filter(array_map('trim', preg_split('/[,\r\n]+/', (string) $deliv_raw))));
            if (empty($cta_url)) {
                $cta_url = add_query_arg('discipline', rawurlencode($title), $contact_url);
            }

            $services[] = array(
                'id'            => $sid,
                'num'           => $num,
                'title'         => $title,
                'slug'          => $slug,
                'tag'           => $tag,
                'desc'          => $desc,
                'subtags'       => $subtags,
                'accent'        => $accent,
                'cta_text'      => $cta_text,
                'cta_url'       => $cta_url,
                'category_slug' => $category_slug,
                'image'         => $image,
            );
            $slot++;
        }
        return $services;
    }

    // Fallback to the 5 default services overlaid with Customizer mods
    foreach ($defaults as $idx => $srv) {
        $s_title   = get_theme_mod("mileym3dia_service_{$idx}_title", $srv['title']);
        $s_tag     = get_theme_mod("mileym3dia_service_{$idx}_tag", $srv['tag']);
        $s_desc    = get_theme_mod("mileym3dia_service_{$idx}_desc", $srv['desc']);
        $s_deliv   = get_theme_mod("mileym3dia_service_{$idx}_subtags", $srv['deliverables']);
        $s_subtags = array_values(array_filter(array_map('trim', preg_split('/[,\r\n]+/', (string) $s_deliv))));

        $services[] = array(
            'id'            => $idx,
            'num'           => $srv['num'],
            'title'         => $s_title,
            'slug'          => $srv['slug'],
            'tag'           => $s_tag,
            'desc'          => $s_desc,
            'subtags'       => $s_subtags,
            'accent'        => $srv['accent'],
            'cta_text'      => 'BOOK ' . strtoupper($s_title),
            'cta_url'       => add_query_arg('discipline', rawurlencode($s_title), $contact_url),
            'category_slug' => $srv['category_slug'],
            'image'         => '',
        );
    }

    return $services;
}

/**
 * Canonical default portfolio projects data used for seeding and fallback rendering
 */
function mileym3dia_get_default_projects_data() {
    return array(
        'nightfall-apparel-campaign' => array(
            'slot'            => 1,
            'slug'            => 'nightfall-apparel-campaign',
            'title'           => 'NIGHTFALL APPAREL CAMPAIGN',
            'cat_name'        => 'Video Production',
            'cat_slug'        => 'video-production',
            'categories'      => array('video-production', 'photography'),
            'accent'          => 'red',
            'year'            => '2026',
            'timeline'        => '4-Week Cycle',
            'client'          => 'NIGHTFALL ATELIER',
            'services'        => 'Cinema Video Production / Stills / DaVinci Grade',
            'url'             => '',
            'featured'        => '1',
            'excerpt'         => 'Full commercial video production, street lookbook photography, and social campaign rollout for Nightfall Atelier.',
            'content'         => '<p>Shot on location over four nights, the Nightfall campaign combines cinema camera movement, editorial lookbook photography, and custom sound design for a multi-platform brand launch.</p>',
            'challenge_title' => 'Defining the Visual Identity & Cinematic Scope',
            'challenge'       => 'Nightfall Atelier required an unmistakable, high-tension nocturnal campaign for their Winter 2026 technical outerwear capsule. The aesthetic directive required authentic rainy neon city streets, high-speed movement, and cinema-grade lighting without appearing clinical or commercialized.',
            'solution_title'  => 'Precision Lighting, Color Mastery & Delivery',
            'solution'        => 'Filmed entirely over four consecutive overnight shoots using RED V-Raptor and Sony FX6 packages paired with vintage Cooke anamorphic glass. We engineered a proprietary DaVinci Resolve color pipeline that preserved shadow detail while making neon reds and cyans explode off the screen.',
            'specs'           => "Camera: RED Digital Cinema · Sony Cinema Line\nColor Pipeline: DaVinci Resolve Studio RAW Grading\nSound & Score: Bespoke Studio Sound Design & Master\nDeliverables: 4K Master, Social Reels, Still Lookbook",
            'stats'           => array(
                array('num' => '4K RAW', 'label' => 'Cinema Camera Master'),
                array('num' => '10-DAY', 'label' => 'Turnaround Delivery'),
                array('num' => '100%', 'label' => 'In-House Production'),
                array('num' => '2.4M+', 'label' => 'Organic Social Reach'),
            ),
        ),
        'static-frequency-tour-visuals' => array(
            'slot'            => 2,
            'slug'            => 'static-frequency-tour-visuals',
            'title'           => 'STATIC FREQUENCY TOUR & VISUALS',
            'cat_name'        => 'Music & Audio Production',
            'cat_slug'        => 'music-audio',
            'categories'      => array('music-audio', 'video-production'),
            'accent'          => 'yellow',
            'year'            => '2026',
            'timeline'        => '4-Week Cycle',
            'client'          => 'STATIC FREQUENCY',
            'services'        => 'Music Video / Audio Production / Live Tour Visuals',
            'url'             => '',
            'featured'        => '0',
            'excerpt'         => 'Music video direction, custom live tour visuals, and surround audio mastering for independent recording artist Static Frequency.',
            'content'         => '<p>Produced end-to-end by MILEYM3DIA, including music video production, tour visual packages, and studio audio mastering.</p>',
            'challenge_title' => 'Defining the Visual Identity & Cinematic Scope',
            'challenge'       => 'Static Frequency needed an immersive visual world to accompany their 18-city headline tour and lead single release. The challenge was syncing 4K stage visuals to MIDI timecode while delivering a cinematic music video with authentic studio audio fidelity.',
            'solution_title'  => 'Precision Lighting, Color Mastery & Delivery',
            'solution'        => 'MILEYM3DIA built a multi-discipline pipeline: tracking 120fps high-speed camera footage, developing custom generative tour visual loops synced to audio triggers, and executing final Dolby Atmos stereo mix and mastering in our audio suite.',
            'specs'           => "Camera: RED Digital Cinema · Sony Cinema Line\nColor Pipeline: DaVinci Resolve Studio RAW Grading\nSound & Score: Bespoke Studio Sound Design & Master\nDeliverables: 4K Master, Social Reels, Still Lookbook",
            'stats'           => array(
                array('num' => '18-CITY', 'label' => 'Headline Tour Visuals'),
                array('num' => '96kHz/24b', 'label' => 'Master Audio Fidelity'),
                array('num' => '100%', 'label' => 'Sync to MIDI Stage Rig'),
                array('num' => '850K+', 'label' => 'Single Stream Plays'),
            ),
        ),
        'monolith-audio-hardware' => array(
            'slot'            => 3,
            'slug'            => 'monolith-audio-hardware',
            'title'           => 'MONOLITH AUDIO HARDWARE',
            'cat_name'        => 'Branding & Graphic Design',
            'cat_slug'        => 'branding-design',
            'categories'      => array('branding-design', 'web-design'),
            'accent'          => 'lime',
            'year'            => '2025',
            'timeline'        => '4-Week Cycle',
            'client'          => 'MONOLITH LABS',
            'services'        => 'Brand Identity / Web Design / Packaging System',
            'url'             => '',
            'featured'        => '0',
            'excerpt'         => 'Complete visual identity, custom typography, packaging design, and e-commerce web design for Monolith Labs.',
            'content'         => '<p>Full brand identity system, product photography, packaging design, and custom e-commerce website built for Monolith Labs.</p>',
            'challenge_title' => 'Defining the Visual Identity & Cinematic Scope',
            'challenge'       => 'Monolith Labs engineered a premium studio monitor controller for professional audio producers and needed a visual identity and digital storefront that commanded a $1,200 retail price tag with absolute credibility.',
            'solution_title'  => 'Precision Lighting, Color Mastery & Delivery',
            'solution'        => 'We crafted a brutalist industrial brand system: custom wordmark typography, matte-black unboxing packaging with foil accents, studio macro product photography, and a lightning-fast responsive web store with 3D product previews.',
            'specs'           => "Camera: RED Digital Cinema · Sony Cinema Line\nColor Pipeline: DaVinci Resolve Studio RAW Grading\nSound & Score: Bespoke Studio Sound Design & Master\nDeliverables: 4K Master, Social Reels, Still Lookbook",
            'stats'           => array(
                array('num' => '100%', 'label' => 'Sold Out Initial Run'),
                array('num' => '0.8s', 'label' => 'E-Commerce Page Speed'),
                array('num' => '32-ASSET', 'label' => 'Complete Brand Identity'),
                array('num' => '$420K+', 'label' => 'Launch Month Revenue'),
            ),
        ),
        'apex-motorsport-identity' => array(
            'slot'            => 4,
            'slug'            => 'apex-motorsport-identity',
            'title'           => 'APEX MOTORSPORT IDENTITY',
            'cat_name'        => 'Photography',
            'cat_slug'        => 'photography',
            'categories'      => array('photography', 'branding-design'),
            'accent'          => 'blue',
            'year'            => '2025',
            'timeline'        => '4-Week Cycle',
            'client'          => 'APEX RACING CO.',
            'services'        => 'Branding / Photography / Apparel Graphics',
            'url'             => '',
            'featured'        => '0',
            'excerpt'         => 'Custom brand identity system, team apparel graphics, and trackside photography for Apex Racing.',
            'content'         => '<p>Complete visual identity, vehicle livery design, apparel graphics, and high-speed trackside photography for Apex Racing Co.</p>',
            'challenge_title' => 'Defining the Visual Identity & Cinematic Scope',
            'challenge'       => 'Apex Racing needed a high-octane visual refresh for their GT3 racing campaign, requiring vehicle liveries, paddock team kits, merchandise designs, and dynamic trackside imagery that captured blistering speeds under changing track conditions.',
            'solution_title'  => 'Precision Lighting, Color Mastery & Delivery',
            'solution'        => 'Our team designed full 3M wrap liveries, engineered a streetwear-inspired apparel line, and deployed trackside with high-speed telephoto setups to capture race-day drama, pit stops, and high-contrast motion blur.',
            'specs'           => "Camera: RED Digital Cinema · Sony Cinema Line\nColor Pipeline: DaVinci Resolve Studio RAW Grading\nSound & Score: Bespoke Studio Sound Design & Master\nDeliverables: 4K Master, Social Reels, Still Lookbook",
            'stats'           => array(
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

    // Ensure all 5 canonical `project_category` service terms exist
    if (taxonomy_exists('project_category') && function_exists('wp_insert_term') && function_exists('term_exists')) {
        foreach (mileym3dia_get_service_project_categories() as $cat_slug => $cat_info) {
            if (!term_exists($cat_slug, 'project_category')) {
                wp_insert_term($cat_info['name'], 'project_category', array('slug' => $cat_slug));
                $changed = true;
            }
        }
    }

    // Seed / sync default `project` posts and migrate categories to canonical 5 service terms
    if (post_type_exists('project')) {
        $default_projects = mileym3dia_get_default_projects_data();
        $schema_upgraded  = get_option('mileym3dia_m1_schema_v25');

        foreach ($default_projects as $slug => $proj) {
            $existing_proj = get_page_by_path($slug, OBJECT, 'project');
            $proj_id       = 0;

            if (!$existing_proj) {
                $proj_id = wp_insert_post(array(
                    'post_title'   => $proj['title'],
                    'post_name'    => $slug,
                    'post_status'  => 'publish',
                    'post_type'    => 'project',
                    'post_excerpt' => $proj['excerpt'],
                    'post_content' => $proj['content'],
                    'menu_order'   => (int) $proj['slot'],
                ));
                if ($proj_id && !is_wp_error($proj_id)) {
                    update_post_meta($proj_id, '_project_year', $proj['year']);
                    update_post_meta($proj_id, '_project_timeline', $proj['timeline']);
                    update_post_meta($proj_id, '_project_client', $proj['client']);
                    update_post_meta($proj_id, '_project_services', $proj['services']);
                    update_post_meta($proj_id, '_project_url', $proj['url']);
                    update_post_meta($proj_id, '_project_featured', $proj['featured']);
                    update_post_meta($proj_id, '_project_challenge_title', $proj['challenge_title']);
                    update_post_meta($proj_id, '_project_challenge', $proj['challenge']);
                    update_post_meta($proj_id, '_project_solution_title', $proj['solution_title']);
                    update_post_meta($proj_id, '_project_solution', $proj['solution']);
                    update_post_meta($proj_id, '_project_specs', $proj['specs']);
                    update_post_meta($proj_id, '_project_stats', $proj['stats']);
                    if (taxonomy_exists('project_category') && function_exists('wp_set_object_terms')) {
                        wp_set_object_terms($proj_id, $proj['categories'], 'project_category');
                    }
                    $changed = true;
                }
            } elseif (!$schema_upgraded) {
                $proj_id = (int) $existing_proj->ID;
                if (taxonomy_exists('project_category') && function_exists('wp_set_object_terms')) {
                    wp_set_object_terms($proj_id, $proj['categories'], 'project_category');
                }
                if ('' === get_post_meta($proj_id, '_project_timeline', true)) {
                    update_post_meta($proj_id, '_project_timeline', $proj['timeline']);
                }
                if ('' === get_post_meta($proj_id, '_project_challenge_title', true)) {
                    update_post_meta($proj_id, '_project_challenge_title', $proj['challenge_title']);
                }
                if ('' === get_post_meta($proj_id, '_project_solution_title', true)) {
                    update_post_meta($proj_id, '_project_solution_title', $proj['solution_title']);
                }
                if ('' === get_post_meta($proj_id, '_project_specs', true)) {
                    update_post_meta($proj_id, '_project_specs', $proj['specs']);
                }
                if ('' === get_post_meta($proj_id, '_project_featured', true)) {
                    update_post_meta($proj_id, '_project_featured', $proj['featured']);
                }
                $changed = true;
            }
        }

        // Clean up old ad-hoc auto-generated project_category terms if present
        if (!$schema_upgraded && taxonomy_exists('project_category') && function_exists('get_term_by') && function_exists('wp_delete_term')) {
            $old_adhoc_slugs = array(
                'video-production-lookbook',
                'music-video-audio',
                'brand-identity-web-design',
                'branding-photography',
            );
            foreach ($old_adhoc_slugs as $old_slug) {
                $old_term = get_term_by('slug', $old_slug, 'project_category');
                if ($old_term && !is_wp_error($old_term)) {
                    wp_delete_term($old_term->term_id, 'project_category');
                }
            }
        }
    }

    // Seed the 5 core MILEYM3DIA services in `service` CPT if missing
    if (post_type_exists('service')) {
        $default_services = mileym3dia_get_default_services();
        foreach ($default_services as $s_idx => $srv) {
            $existing_srv = get_page_by_path($srv['slug'], OBJECT, 'service');
            if (!$existing_srv) {
                $srv_id = wp_insert_post(array(
                    'post_title'   => $srv['title'],
                    'post_name'    => $srv['slug'],
                    'post_status'  => 'publish',
                    'post_type'    => 'service',
                    'post_excerpt' => $srv['desc'],
                    'post_content' => '<p>' . $srv['desc'] . '</p>',
                    'menu_order'   => (int) $s_idx,
                ));
                if ($srv_id && !is_wp_error($srv_id)) {
                    update_post_meta($srv_id, '_service_number', $srv['num']);
                    update_post_meta($srv_id, '_service_tag', $srv['tag']);
                    update_post_meta($srv_id, '_service_deliverables', $srv['deliverables']);
                    update_post_meta($srv_id, '_service_accent', $srv['accent']);
                    update_post_meta($srv_id, '_service_cta_text', $srv['cta_text']);
                    update_post_meta($srv_id, '_service_cta_url', $srv['cta_url']);
                    update_post_meta($srv_id, '_service_category_slug', $srv['category_slug']);
                    $changed = true;
                }
            }
        }
    }

    // Seed default Studio Journal blog posts if only the default "Hello world!" post exists
    if (!get_option('mileym3dia_m1_schema_v25') && function_exists('get_posts')) {
        $existing_posts = get_posts(array('post_type' => 'post', 'posts_per_page' => 5, 'post_status' => 'publish'));
        if (count($existing_posts) <= 1) {
            $seed_posts = array(
                array(
                    'title'   => 'Lighting & Lens Selection for High-Impact Commercial and Music Video Shoots',
                    'slug'    => 'lighting-lens-selection-commercial-music-videos',
                    'excerpt' => 'How pairing cinema prime lenses with intentional key-to-fill lighting ratios elevates brand commercials and music videos on location.',
                    'content' => '<p>Great video production starts long before the camera rolls. Choosing the right lens focal lengths and shaping practical lighting on location sets the emotional tone of a commercial or music video from the very first frame.</p><h2>Why Cinema Glass Matters</h2><p>On recent campaign shoots, our camera team paired fast cinema primes with soft directional LED fixtures to maintain natural skin tones while preserving deep shadow contrast.</p>',
                ),
                array(
                    'title'   => 'Building a Cohesive Visual Identity Across Video, Photography, Print, and Web',
                    'slug'    => 'building-cohesive-visual-identity-video-photo-web',
                    'excerpt' => 'A practical breakdown of how we align logo systems, color palettes, lookbook photography, and custom web design for growing brands and recording artists.',
                    'content' => '<p>When a business or recording artist launches a new campaign, consistency across every touchpoint is what builds lasting recognition. At MILEYM3DIA, our branding, photography, video, and web teams work from a shared creative brief.</p>',
                ),
                array(
                    'title'   => 'DaVinci Resolve Color Grading Workflow: Creating Rich Film Contrast for Brand Campaigns',
                    'slug'    => 'davinci-resolve-color-grading-workflow-brand-campaigns',
                    'excerpt' => 'Inside our color grading pipeline for balancing multiple camera angles, preserving highlight roll-off, and delivering consistent masters for broadcast and social.',
                    'content' => '<p>Color grading is the final step that gives commercial and music video footage its signature look. Working in DaVinci Wide Gamut allows us to match cameras cleanly and craft film-inspired color palettes.</p>',
                ),
            );
            foreach ($seed_posts as $sp) {
                if (!get_page_by_path($sp['slug'], OBJECT, 'post')) {
                    wp_insert_post(array(
                        'post_title'   => $sp['title'],
                        'post_name'    => $sp['slug'],
                        'post_status'  => 'publish',
                        'post_type'    => 'post',
                        'post_excerpt' => $sp['excerpt'],
                        'post_content' => $sp['content'],
                    ));
                }
            }
        }
        if (function_exists('update_option')) {
            update_option('mileym3dia_m1_schema_v25', '1');
        }
    }

    // Seed default scalable Resource Library items in `m3_resource` CPT
    if (post_type_exists('m3_resource') && function_exists('mileym3dia_get_default_resources')) {
        $default_resources = mileym3dia_get_default_resources();
        foreach ($default_resources as $r_idx => $res) {
            $existing_res = get_page_by_path($res['slug'], OBJECT, 'm3_resource');
            if (!$existing_res) {
                $res_id = wp_insert_post(array(
                    'post_title'   => $res['title'],
                    'post_name'    => $res['slug'],
                    'post_status'  => 'publish',
                    'post_type'    => 'm3_resource',
                    'post_excerpt' => $res['desc'],
                    'post_content' => '<p>' . $res['desc'] . '</p>',
                    'menu_order'   => (int) $r_idx + 1,
                ));
                if ($res_id && !is_wp_error($res_id)) {
                    update_post_meta($res_id, '_m3_resource_type', $res['type']);
                    update_post_meta($res_id, '_m3_resource_access', $res['access']);
                    update_post_meta($res_id, '_m3_resource_url', $res['url']);
                    update_post_meta($res_id, '_m3_resource_format', $res['format']);
                    update_post_meta($res_id, '_m3_resource_compatibility', $res['compatibility']);
                    update_post_meta($res_id, '_m3_resource_accent', $res['accent']);
                    update_post_meta($res_id, '_m3_resource_badge', $res['badge']);
                    update_post_meta($res_id, '_m3_resource_btn_text', $res['btn_text']);
                    update_post_meta($res_id, '_m3_resource_affiliate_code', $res['affiliate_code']);

                    if (!empty($res['categories']) && taxonomy_exists('resource_category') && function_exists('wp_set_object_terms')) {
                        wp_set_object_terms($res_id, $res['categories'], 'resource_category', false);
                    }
                    if (!empty($res['tags']) && taxonomy_exists('resource_tag') && function_exists('wp_set_object_terms')) {
                        wp_set_object_terms($res_id, $res['tags'], 'resource_tag', false);
                    }
                    $changed = true;
                }
            }
        }
    }

    // Seed the 6 MILEYM3DIA Studio Store products into WooCommerce `product` CPT if WooCommerce is active
    if (post_type_exists('product') && function_exists('mileym3dia_get_default_store_products') && !get_option('mileym3dia_wc_products_seeded_v25')) {
        $wc_defaults = mileym3dia_get_default_store_products();
        foreach ($wc_defaults as $p_idx => $prod) {
            $existing_prod = get_page_by_path($prod['slug'], OBJECT, 'product');
            if (!$existing_prod) {
                $price_clean = preg_replace('/[^0-9.]/', '', (string) $prod['price']);
                $prod_id     = wp_insert_post(array(
                    'post_title'   => $prod['title'],
                    'post_name'    => $prod['slug'],
                    'post_status'  => 'publish',
                    'post_type'    => 'product',
                    'post_excerpt' => $prod['desc'],
                    'post_content' => '<p>' . $prod['desc'] . '</p>',
                    'menu_order'   => (int) $p_idx + 1,
                ));
                if ($prod_id && !is_wp_error($prod_id)) {
                    update_post_meta($prod_id, '_regular_price', $price_clean);
                    update_post_meta($prod_id, '_price', $price_clean);
                    update_post_meta($prod_id, '_stock_status', 'instock');
                    update_post_meta($prod_id, '_visibility', 'visible');
                    update_post_meta($prod_id, '_virtual', !empty($prod['is_virtual']) ? 'yes' : 'no');
                    update_post_meta($prod_id, '_downloadable', !empty($prod['is_downloadable']) ? 'yes' : 'no');
                    update_post_meta($prod_id, '_m3_badge', $prod['badge']);
                    update_post_meta($prod_id, '_m3_format', $prod['format']);
                    update_post_meta($prod_id, '_m3_image_url', $prod['image']);

                    if (!empty($prod['is_downloadable']) && !empty($prod['download_file'])) {
                        $dl_key = md5($prod['slug'] . '-file');
                        update_post_meta($prod_id, '_downloadable_files', array(
                            $dl_key => array(
                                'id'   => $dl_key,
                                'name' => $prod['title'] . ' (' . $prod['format'] . ')',
                                'file' => $prod['download_file'],
                            ),
                        ));
                    }

                    if (!empty($prod['is_physical']) && !empty($prod['attributes'])) {
                        update_post_meta($prod_id, '_product_attributes', array(
                            'size' => array(
                                'name'         => 'Size',
                                'value'        => implode(' | ', $prod['attributes']),
                                'position'     => 0,
                                'is_visible'   => 1,
                                'is_variation' => 0,
                                'is_taxonomy'  => 0,
                            ),
                        ));
                    }

                    if (!empty($prod['grants_tier'])) {
                        update_post_meta($prod_id, '_m3_grants_membership_tier', sanitize_key($prod['grants_tier']));
                    }

                    if (taxonomy_exists('product_cat') && function_exists('wp_set_object_terms')) {
                        if (!term_exists($prod['category_slug'], 'product_cat') && function_exists('wp_insert_term')) {
                            wp_insert_term($prod['category_label'], 'product_cat', array('slug' => $prod['category_slug']));
                        }
                        wp_set_object_terms($prod_id, array($prod['category_slug']), 'product_cat', false);
                    }
                    $changed = true;
                }
            }
        }
        if (function_exists('update_option')) {
            update_option('mileym3dia_wc_products_seeded_v25', '1');
        }
    }

    if (($changed || !get_option('mileym3dia_rewrites_flushed_v25')) && function_exists('flush_rewrite_rules')) {
        flush_rewrite_rules(false);
        if (function_exists('update_option')) {
            update_option('mileym3dia_rewrites_flushed_v25', '1');
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

    // WORK with dropdown (dynamically populated from published `project` CPT posts)
    echo '<li class="nav-item has-dropdown menu-item-has-children' . ($is_work ? ' active current-menu-item' : '') . '">';
    echo '<a href="' . esc_url(mileym3dia_get_work_page_url()) . '" data-number="04">' . esc_html__('WORK', 'm3-big-red') . ' <span class="nav-caret" aria-hidden="true">▾</span></a>';
    echo '<ul class="sub-menu">';
    echo '<li><a href="' . esc_url(mileym3dia_get_work_page_url()) . '">' . esc_html__('All Featured Productions', 'm3-big-red') . '</a></li>';
    $nav_projects = array();
    if (post_type_exists('project') && class_exists('WP_Query')) {
        $nav_proj_q = new WP_Query(array(
            'post_type'      => 'project',
            'posts_per_page' => 6,
            'post_status'    => 'publish',
            'orderby'        => array('menu_order' => 'ASC', 'ID' => 'ASC'),
        ));
        if (!empty($nav_proj_q->posts)) {
            $nav_projects = $nav_proj_q->posts;
        }
    }
    if (!empty($nav_projects)) {
        foreach ($nav_projects as $np) {
            echo '<li><a href="' . esc_url(get_permalink($np->ID)) . '">' . esc_html($np->post_title) . '</a></li>';
        }
    } else {
        echo '<li><a href="' . esc_url(mileym3dia_get_project_url('nightfall-apparel-campaign')) . '">' . esc_html__('Nightfall Apparel Campaign', 'm3-big-red') . '</a></li>';
        echo '<li><a href="' . esc_url(mileym3dia_get_project_url('static-frequency-tour-visuals')) . '">' . esc_html__('Static Frequency Visuals', 'm3-big-red') . '</a></li>';
        echo '<li><a href="' . esc_url(mileym3dia_get_project_url('monolith-audio-hardware')) . '">' . esc_html__('Monolith Audio Hardware', 'm3-big-red') . '</a></li>';
        echo '<li><a href="' . esc_url(mileym3dia_get_project_url('apex-motorsport-identity')) . '">' . esc_html__('Apex Motorsport Identity', 'm3-big-red') . '</a></li>';
    }
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
    $mob_projects = array();
    if (post_type_exists('project') && class_exists('WP_Query')) {
        $mob_proj_q = new WP_Query(array(
            'post_type'      => 'project',
            'posts_per_page' => 6,
            'post_status'    => 'publish',
            'orderby'        => array('menu_order' => 'ASC', 'ID' => 'ASC'),
        ));
        if (!empty($mob_proj_q->posts)) {
            $mob_projects = $mob_proj_q->posts;
        }
    }
    if (!empty($mob_projects)) {
        foreach ($mob_projects as $mp) {
            echo '<li><a href="' . esc_url(get_permalink($mp->ID)) . '">' . esc_html($mp->post_title) . '</a></li>';
        }
    } else {
        echo '<li><a href="' . esc_url(mileym3dia_get_project_url('nightfall-apparel-campaign')) . '">' . esc_html__('Nightfall Apparel', 'm3-big-red') . '</a></li>';
        echo '<li><a href="' . esc_url(mileym3dia_get_project_url('static-frequency-tour-visuals')) . '">' . esc_html__('Static Frequency', 'm3-big-red') . '</a></li>';
        echo '<li><a href="' . esc_url(mileym3dia_get_project_url('monolith-audio-hardware')) . '">' . esc_html__('Monolith Audio', 'm3-big-red') . '</a></li>';
        echo '<li><a href="' . esc_url(mileym3dia_get_project_url('apex-motorsport-identity')) . '">' . esc_html__('Apex Motorsport', 'm3-big-red') . '</a></li>';
    }
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
 * Default Scalable Resource Library Catalog (Downloads, Free Tools, Tutorials, Curated Links, Affiliate Resources)
 */
function mileym3dia_get_default_resources() {
    $files_base = get_template_directory_uri() . '/assets/files/';
    return array(
        array(
            'id'             => 101,
            'slug'           => '35mm-cinema-lut-pack',
            'title'          => get_theme_mod('mileym3dia_resource_1_title', '35MM CINEMA LUT PACK'),
            'desc'           => get_theme_mod('mileym3dia_resource_1_desc', 'Calibrated look LUTs for Sony S-Log3, RED Log3G10, and Blackmagic Film Gen 5. Designed for natural skin tones and rich film contrast.'),
            'type'           => 'download',
            'access'         => 'free',
            'url'            => get_theme_mod('mileym3dia_resource_1_file', $files_base . 'm3-35mm-cinema-lut-pack.cube'),
            'format'         => '.CUBE (DaVinci Resolve, Premiere, Final Cut)',
            'compatibility'  => 'Commercial & Personal Use',
            'accent'         => 'blue',
            'badge'          => 'COLOR GRADING',
            'btn_text'       => get_theme_mod('mileym3dia_resource_1_btn', 'DOWNLOAD .CUBE PACK'),
            'affiliate_code' => '',
            'categories'     => array('Color Grading', 'Video Production'),
            'tags'           => array('luts', 'davinci-resolve', 's-log3', 'cinema'),
        ),
        array(
            'id'             => 102,
            'slug'           => 'studio-audio-stem-mix-guide',
            'title'          => get_theme_mod('mileym3dia_resource_2_title', 'STUDIO AUDIO STEM & MIX GUIDE'),
            'desc'           => get_theme_mod('mileym3dia_resource_2_desc', '24-Bit / 48kHz broadcast WAV stem grouping, loudness targets (-14 LUFS), and studio delivery file naming specs.'),
            'type'           => 'download',
            'access'         => 'free',
            'url'            => get_theme_mod('mileym3dia_resource_2_file', $files_base . 'm3-studio-audio-stem-guide.txt'),
            'format'         => 'Studio Mixing & Mastering Guide (.TXT)',
            'compatibility'  => 'Logic Pro, Ableton, Pro Tools, Premiere',
            'accent'         => 'yellow',
            'badge'          => 'MUSIC & AUDIO',
            'btn_text'       => get_theme_mod('mileym3dia_resource_2_btn', 'DOWNLOAD AUDIO SPECS'),
            'affiliate_code' => '',
            'categories'     => array('Music & Audio'),
            'tags'           => array('mixing', 'stems', 'mastering', 'lufs'),
        ),
        array(
            'id'             => 103,
            'slug'           => 'brand-lookbook-layout-kit',
            'title'          => get_theme_mod('mileym3dia_resource_3_title', 'BRAND & LOOKBOOK LAYOUT KIT'),
            'desc'           => get_theme_mod('mileym3dia_resource_3_desc', '12-column Swiss brutalist grid system, typography scale guides, and print/web export specifications.'),
            'type'           => 'download',
            'access'         => 'member',
            'url'            => get_theme_mod('mileym3dia_resource_3_file', $files_base . 'm3-brand-lookbook-layout-guide.txt'),
            'format'         => 'Layout Grid & Color Profile Specification',
            'compatibility'  => 'Figma, InDesign, Illustrator',
            'accent'         => 'lime',
            'badge'          => 'BRAND DESIGN',
            'btn_text'       => get_theme_mod('mileym3dia_resource_3_btn', 'DOWNLOAD LAYOUT KIT'),
            'affiliate_code' => '',
            'categories'     => array('Branding & Design'),
            'tags'           => array('grid', 'typography', 'lookbook', 'brand-kit'),
        ),
        array(
            'id'             => 104,
            'slug'           => 'video-production-call-sheet-checklist',
            'title'          => get_theme_mod('mileym3dia_resource_4_title', 'VIDEO PRODUCTION CALL SHEET & CHECKLIST'),
            'desc'           => get_theme_mod('mileym3dia_resource_4_desc', 'Our complete pre-production call sheet, shot list template, and on-set location lighting checklist.'),
            'type'           => 'download',
            'access'         => 'member',
            'url'            => get_theme_mod('mileym3dia_resource_4_file', $files_base . 'm3-production-call-sheet-checklist.txt'),
            'format'         => 'Editable On-Set Checklist & Call Sheet',
            'compatibility'  => 'Commercial & Music Video Shoots',
            'accent'         => 'red',
            'badge'          => 'PRE-PRODUCTION',
            'btn_text'       => get_theme_mod('mileym3dia_resource_4_btn', 'DOWNLOAD CALL SHEET'),
            'affiliate_code' => '',
            'categories'     => array('Video Production', 'Pre-Production'),
            'tags'           => array('call-sheet', 'checklist', 'directing', 'on-set'),
        ),
        array(
            'id'             => 105,
            'slug'           => 'davinci-resolve-studio-free',
            'title'          => 'DAVINCI RESOLVE FREE NLE & COLOR SUITE',
            'desc'           => 'Industry-standard non-linear editing, Hollywood color grading, Fusion VFX, and Fairlight audio post-production in one free download.',
            'type'           => 'tool',
            'access'         => 'free',
            'url'            => 'https://www.blackmagicdesign.com/products/davinciresolve',
            'format'         => 'macOS / Windows / Linux',
            'compatibility'  => 'Free Forever (Studio Optional)',
            'accent'         => 'blue',
            'badge'          => 'FREE TOOL',
            'btn_text'       => 'OPEN DAVINCI RESOLVE',
            'affiliate_code' => '',
            'categories'     => array('Color Grading', 'Video Production'),
            'tags'           => array('davinci-resolve', 'editing', 'free-software'),
        ),
        array(
            'id'             => 106,
            'slug'           => 'figma-starter-brand-workspace',
            'title'          => 'FIGMA COLLABORATIVE UI & BRAND DESIGN',
            'desc'           => 'Browser-based vector design, interactive prototyping, and real-time client design handoff used on every MILEYM3DIA web & brand sprint.',
            'type'           => 'tool',
            'access'         => 'free',
            'url'            => 'https://www.figma.com/',
            'format'         => 'Web / macOS / Windows',
            'compatibility'  => 'Free Starter Tier',
            'accent'         => 'lime',
            'badge'          => 'FREE TOOL',
            'btn_text'       => 'LAUNCH FIGMA',
            'affiliate_code' => '',
            'categories'     => array('Branding & Design', 'Web Development'),
            'tags'           => array('figma', 'ui-ux', 'wireframes', 'brand-kit'),
        ),
        array(
            'id'             => 107,
            'slug'           => 'anamorphic-lighting-breakdown-tutorial',
            'title'          => 'NOCTURNAL CINEMA LIGHTING & LENS BREAKDOWN',
            'desc'           => 'Step-by-step lighting diagrams, key-to-fill ratios, and practical neon rigging techniques from our Nightfall Apparel commercial shoot.',
            'type'           => 'tutorial',
            'access'         => 'free',
            'url'            => home_url('/blog/'),
            'format'         => 'Studio Breakdown & Diagram Guide',
            'compatibility'  => 'All Cinema & Mirrorless Cameras',
            'accent'         => 'red',
            'badge'          => 'TUTORIAL',
            'btn_text'       => 'READ BREAKDOWN',
            'affiliate_code' => '',
            'categories'     => array('Video Production', 'Photography'),
            'tags'           => array('lighting', 'cinema', 'commercial', 'tutorial'),
        ),
        array(
            'id'             => 108,
            'slug'           => 'vocal-chain-mastering-walkthrough',
            'title'          => 'BROADCAST VOCAL CHAIN & -14 LUFS MASTERING GUIDE',
            'desc'           => 'How we compress, de-ess, saturate, and bus-limit lead vocals and 808s for Spotify, Apple Music, and YouTube Music Videos.',
            'type'           => 'tutorial',
            'access'         => 'member',
            'url'            => $files_base . 'm3-studio-audio-stem-guide.txt',
            'format'         => 'In-House Audio Engineering Guide',
            'compatibility'  => 'Pro Tools, Logic Pro, Ableton Live',
            'accent'         => 'yellow',
            'badge'          => 'MEMBER TUTORIAL',
            'btn_text'       => 'OPEN AUDIO GUIDE',
            'affiliate_code' => '',
            'categories'     => array('Music & Audio'),
            'tags'           => array('vocals', 'mixing', 'mastering', 'tutorial'),
        ),
        array(
            'id'             => 109,
            'slug'           => 'shotdeck-cinema-reference-library',
            'title'          => 'SHOTDECK CINEMA FRAME REFERENCE DIRECTORY',
            'desc'           => 'Searchable database of high-definition film stills organized by lens, lighting style, color palette, and aspect ratio for director treatments.',
            'type'           => 'link',
            'access'         => 'free',
            'url'            => 'https://shotdeck.com/',
            'format'         => 'Web Reference Directory',
            'compatibility'  => 'Directors, DPs & Art Directors',
            'accent'         => 'blue',
            'badge'          => 'CURATED LINK',
            'btn_text'       => 'VISIT SHOTDECK',
            'affiliate_code' => '',
            'categories'     => array('Pre-Production', 'Video Production'),
            'tags'           => array('treatments', 'references', 'cinematography'),
        ),
        array(
            'id'             => 110,
            'slug'           => 'google-fonts-variable-type-archive',
            'title'          => 'OPEN-SOURCE DISPLAY & MONOSPACE TYPE ARCHIVE',
            'desc'           => 'Curated selection of bold condensed display fonts (Anton, Bebas Neue, Syne) and technical monospaces (JetBrains Mono) cleared for commercial web use.',
            'type'           => 'link',
            'access'         => 'free',
            'url'            => 'https://fonts.google.com/',
            'format'         => 'Open-Source Font Directory',
            'compatibility'  => 'Web, Print & Motion Graphics',
            'accent'         => 'lime',
            'badge'          => 'CURATED LINK',
            'btn_text'       => 'BROWSE FONTS',
            'affiliate_code' => '',
            'categories'     => array('Branding & Design', 'Web Development'),
            'tags'           => array('typography', 'fonts', 'free-software'),
        ),
        array(
            'id'             => 111,
            'slug'           => 'artlist-royalty-free-music-sfx-partner',
            'title'          => 'ARTLIST PRO MUSIC, SFX & STOCK FOOTAGE',
            'desc'           => 'Unlimited commercial licensing for cinema sound effects, stems, and music cues. Includes 2 bonus months through the MILEYM3DIA studio partner link.',
            'type'           => 'affiliate',
            'access'         => 'free',
            'url'            => 'https://artlist.io/',
            'format'         => 'Commercial Licensing Partner',
            'compatibility'  => 'YouTube, Client Commercials & Social',
            'accent'         => 'yellow',
            'badge'          => 'PARTNER DEAL',
            'btn_text'       => 'CLAIM PARTNER OFFER',
            'affiliate_code' => 'M3STUDIO2MO',
            'categories'     => array('Music & Audio', 'Video Production'),
            'tags'           => array('sfx', 'music-licensing', 'partner-deal'),
        ),
        array(
            'id'             => 112,
            'slug'           => 'm3-pro-raw-lut-and-node-tree-vault',
            'title'          => 'M3 PRO 8K RAW POWERGRADE & NODE TREE VAULT',
            'desc'           => 'Our private DaVinci Resolve halation, film grain, and RED/ARRI color-management PowerGrade reserved for Creator Hub Pro members.',
            'type'           => 'download',
            'access'         => 'pro',
            'url'            => $files_base . 'm3-35mm-cinema-lut-pack.cube',
            'format'         => '.DRX PowerGrade + .CUBE Bundle',
            'compatibility'  => 'DaVinci Resolve Studio 18/19+',
            'accent'         => 'red',
            'badge'          => 'PRO VAULT',
            'btn_text'       => 'DOWNLOAD PRO VAULT',
            'affiliate_code' => '',
            'categories'     => array('Color Grading', 'Video Production'),
            'tags'           => array('powergrade', 'pro-vault', 'davinci-resolve'),
        ),
    );
}

/**
 * Query Scalable Resource Library (`m3_resource` CPT with full fallback for standalone preview)
 */
function mileym3dia_get_resources($args = array()) {
    $defaults = array(
        'search'   => '',
        'type'     => 'all',
        'category' => '',
        'tag'      => '',
        'access'   => 'all',
        'paged'    => 1,
        'per_page' => 9,
    );
    $args     = array_merge($defaults, is_array($args) ? $args : array());
    $search   = trim((string) $args['search']);
    $type     = sanitize_key((string) $args['type']);
    $category = sanitize_title((string) $args['category']);
    $tag      = sanitize_title((string) $args['tag']);
    $access   = sanitize_key((string) $args['access']);
    $paged    = max(1, (int) $args['paged']);
    $per_page = max(1, min(100, (int) $args['per_page']));

    $items          = array();
    $all_categories = array();
    $all_tags       = array();

    if (post_type_exists('m3_resource') && class_exists('WP_Query')) {
        $q_args = array(
            'post_type'      => 'm3_resource',
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'paged'          => $paged,
            'orderby'        => array('menu_order' => 'ASC', 'date' => 'DESC'),
        );
        if ('' !== $search) {
            $q_args['s'] = $search;
        }
        $meta_query = array();
        if ($type && 'all' !== $type) {
            $meta_query[] = array(
                'key'   => '_m3_resource_type',
                'value' => $type,
            );
        }
        if ($access && 'all' !== $access) {
            $meta_query[] = array(
                'key'   => '_m3_resource_access',
                'value' => $access,
            );
        }
        if (!empty($meta_query)) {
            $q_args['meta_query'] = $meta_query;
        }
        $tax_query = array();
        if ($category) {
            $tax_query[] = array(
                'taxonomy' => 'resource_category',
                'field'    => 'slug',
                'terms'    => $category,
            );
        }
        if ($tag) {
            $tax_query[] = array(
                'taxonomy' => 'resource_tag',
                'field'    => 'slug',
                'terms'    => $tag,
            );
        }
        if (!empty($tax_query)) {
            $q_args['tax_query'] = $tax_query;
        }

        $q = new WP_Query($q_args);
        if (!empty($q->posts)) {
            foreach ($q->posts as $rp) {
                $rid   = (int) $rp->ID;
                $cats  = function_exists('get_the_terms') ? get_the_terms($rid, 'resource_category') : array();
                $tags  = function_exists('get_the_terms') ? get_the_terms($rid, 'resource_tag') : array();
                $c_arr = array();
                if (is_array($cats)) {
                    foreach ($cats as $ct) {
                        $c_arr[] = $ct->name;
                    }
                }
                $t_arr = array();
                if (is_array($tags)) {
                    foreach ($tags as $tg) {
                        $t_arr[] = $tg->slug;
                    }
                }
                $items[] = array(
                    'id'             => $rid,
                    'slug'           => $rp->post_name,
                    'title'          => $rp->post_title,
                    'desc'           => $rp->post_excerpt ?: wp_strip_all_tags($rp->post_content),
                    'type'           => get_post_meta($rid, '_m3_resource_type', true) ?: 'download',
                    'access'         => get_post_meta($rid, '_m3_resource_access', true) ?: 'free',
                    'url'            => get_post_meta($rid, '_m3_resource_url', true) ?: '#',
                    'format'         => get_post_meta($rid, '_m3_resource_format', true) ?: 'Digital Resource',
                    'compatibility'  => get_post_meta($rid, '_m3_resource_compatibility', true) ?: 'Commercial & Personal Use',
                    'accent'         => get_post_meta($rid, '_m3_resource_accent', true) ?: 'blue',
                    'badge'          => get_post_meta($rid, '_m3_resource_badge', true) ?: 'RESOURCE',
                    'btn_text'       => get_post_meta($rid, '_m3_resource_btn_text', true) ?: 'OPEN RESOURCE',
                    'affiliate_code' => get_post_meta($rid, '_m3_resource_affiliate_code', true) ?: '',
                    'categories'     => $c_arr,
                    'tags'           => $t_arr,
                );
            }

            if (function_exists('get_terms')) {
                $cat_terms = get_terms(array('taxonomy' => 'resource_category', 'hide_empty' => false));
                if (is_array($cat_terms)) {
                    foreach ($cat_terms as $ct) {
                        $all_categories[$ct->slug] = $ct->name;
                    }
                }
                $tag_terms = get_terms(array('taxonomy' => 'resource_tag', 'hide_empty' => false));
                if (is_array($tag_terms)) {
                    foreach ($tag_terms as $tg) {
                        $all_tags[$tg->slug] = $tg->name;
                    }
                }
            }

            return array(
                'items'      => $items,
                'total'      => (int) $q->found_posts,
                'max_pages'  => max(1, (int) $q->max_num_pages),
                'paged'      => $paged,
                'categories' => $all_categories,
                'tags'       => $all_tags,
            );
        }
    }

    // Fallback / Standalone Preview filtering across default seeded catalog
    $all_items = mileym3dia_get_default_resources();
    foreach ($all_items as $ri) {
        foreach ((array) $ri['categories'] as $cn) {
            $all_categories[sanitize_title($cn)] = $cn;
        }
        foreach ((array) $ri['tags'] as $tn) {
            $all_tags[sanitize_title($tn)] = $tn;
        }
    }

    $filtered = array();
    foreach ($all_items as $ri) {
        if ($type && 'all' !== $type && $ri['type'] !== $type) {
            continue;
        }
        if ($access && 'all' !== $access && $ri['access'] !== $access) {
            continue;
        }
        if ($category) {
            $cat_slugs = array_map('sanitize_title', (array) $ri['categories']);
            if (!in_array($category, $cat_slugs, true)) {
                continue;
            }
        }
        if ($tag) {
            $tag_slugs = array_map('sanitize_title', (array) $ri['tags']);
            if (!in_array($tag, $tag_slugs, true)) {
                continue;
            }
        }
        if ('' !== $search) {
            $haystack = strtolower($ri['title'] . ' ' . $ri['desc'] . ' ' . $ri['badge'] . ' ' . $ri['format'] . ' ' . implode(' ', (array) $ri['categories']) . ' ' . implode(' ', (array) $ri['tags']));
            if (false === strpos($haystack, strtolower($search))) {
                continue;
            }
        }
        $filtered[] = $ri;
    }

    $total     = count($filtered);
    $max_pages = max(1, (int) ceil($total / $per_page));
    $paged     = min($paged, $max_pages);
    $offset    = ($paged - 1) * $per_page;

    return array(
        'items'      => array_slice($filtered, $offset, $per_page),
        'total'      => $total,
        'max_pages'  => $max_pages,
        'paged'      => $paged,
        'categories' => $all_categories,
        'tags'       => $all_tags,
    );
}

/**
 * Creator Hub Membership Tier & Protected Resource Access Helpers
 */
function mileym3dia_get_user_membership_tier($user_id = null) {
    $tier = 'guest';
    if (null === $user_id && function_exists('get_current_user_id')) {
        $user_id = get_current_user_id();
    }
    $user_id = (int) $user_id;

    if ($user_id > 0) {
        $meta_tier = function_exists('get_user_meta') ? (string) get_user_meta($user_id, 'm3_membership_tier', true) : '';
        $tier      = in_array($meta_tier, array('free', 'pro', 'agency'), true) ? $meta_tier : 'free';
        if (function_exists('user_can') && user_can($user_id, 'manage_options') && 'free' === $tier) {
            $tier = 'pro';
        }
    }

    if (function_exists('apply_filters')) {
        return (string) apply_filters('mileym3dia_user_membership_tier', $tier, $user_id);
    }
    return $tier;
}

function mileym3dia_user_can_access_resource($resource_id, $user_id = null, $access_tier = '') {
    if ('' === $access_tier && $resource_id > 0 && function_exists('get_post_meta')) {
        $access_tier = (string) get_post_meta((int) $resource_id, '_m3_resource_access', true);
    }
    if ('' === $access_tier) {
        foreach (mileym3dia_get_default_resources() as $res) {
            if ((int) $res['id'] === (int) $resource_id) {
                $access_tier = $res['access'];
                break;
            }
        }
    }
    $access_tier = sanitize_key($access_tier ?: 'free');

    $logged_in = false;
    if (null === $user_id) {
        $logged_in = function_exists('is_user_logged_in') && is_user_logged_in();
        $user_id   = function_exists('get_current_user_id') ? get_current_user_id() : 0;
    } else {
        $logged_in = ((int) $user_id > 0);
    }

    $user_tier  = $logged_in ? mileym3dia_get_user_membership_tier($user_id) : 'guest';
    $can_access = false;

    if ('free' === $access_tier) {
        $can_access = true;
    } elseif ('member' === $access_tier) {
        $can_access = $logged_in;
    } elseif ('pro' === $access_tier) {
        $can_access = $logged_in && in_array($user_tier, array('pro', 'agency'), true);
    }

    if (function_exists('apply_filters')) {
        return (bool) apply_filters('mileym3dia_user_can_access_resource', $can_access, (int) $resource_id, (int) $user_id, $access_tier);
    }
    return $can_access;
}

function mileym3dia_upgrade_user_membership($user_id, $new_tier = 'pro', $context = array()) {
    $user_id  = (int) $user_id;
    $new_tier = in_array($new_tier, array('free', 'pro', 'agency'), true) ? $new_tier : 'pro';
    if ($user_id <= 0 || !function_exists('update_user_meta')) {
        return false;
    }
    update_user_meta($user_id, 'm3_membership_tier', $new_tier);
    update_user_meta($user_id, 'm3_membership_upgraded_at', gmdate('c'));
    if (function_exists('do_action')) {
        do_action('mileym3dia_membership_upgraded', $user_id, $new_tier, $context);
    }
    return true;
}

function mileym3dia_get_resource_download_url($resource_id, $fallback_url = '', $access_tier = 'free') {
    if ('free' === $access_tier) {
        return $fallback_url;
    }
    $nonce = function_exists('wp_create_nonce') ? wp_create_nonce('m3_download_' . (int) $resource_id) : 'm3-preview';
    return add_query_arg(
        array(
            'm3_download_resource' => (int) $resource_id,
            '_wpnonce'             => $nonce,
        ),
        home_url('/')
    );
}

/**
 * Protected Resource Download Endpoint (`?m3_download_resource=<id>&_wpnonce=<nonce>`)
 */
function mileym3dia_handle_protected_resource_download() {
    if (!isset($_GET['m3_download_resource'])) {
        return;
    }
    $resource_id = absint($_GET['m3_download_resource']);
    if ($resource_id <= 0) {
        return;
    }

    $hub_url     = mileym3dia_get_page_url('creator-hub');
    $target_url  = '';
    $access_tier = 'member';

    if (function_exists('get_post_meta') && get_post($resource_id)) {
        $target_url  = (string) get_post_meta($resource_id, '_m3_resource_url', true);
        $access_tier = (string) get_post_meta($resource_id, '_m3_resource_access', true) ?: 'member';
    } else {
        foreach (mileym3dia_get_default_resources() as $res) {
            if ((int) $res['id'] === $resource_id) {
                $target_url  = $res['url'];
                $access_tier = $res['access'];
                break;
            }
        }
    }

    if (function_exists('wp_verify_nonce') && isset($_GET['_wpnonce'])) {
        $nonce = sanitize_text_field(wp_unslash($_GET['_wpnonce']));
        if (!wp_verify_nonce($nonce, 'm3_download_' . $resource_id) && 'm3-preview' !== $nonce) {
            wp_safe_redirect(add_query_arg(array('tab' => 'login', 'auth_error' => 'Download link expired. Please try again.'), $hub_url) . '#portal-access');
            exit;
        }
    }

    if (!mileym3dia_user_can_access_resource($resource_id, null, $access_tier)) {
        if ('pro' === $access_tier && function_exists('is_user_logged_in') && is_user_logged_in()) {
            wp_safe_redirect(add_query_arg(array('auth_error' => 'This resource requires a Creator Hub Pro membership. Upgrade via the Studio Store.'), $hub_url) . '#portal-access');
        } else {
            wp_safe_redirect(add_query_arg(array('tab' => 'login', 'auth_error' => 'Please sign in or create a free Creator Hub account to download this member resource.'), $hub_url) . '#portal-access');
        }
        exit;
    }

    if (empty($target_url)) {
        wp_safe_redirect(mileym3dia_get_page_url('resources'));
        exit;
    }

    // Serve local theme asset files cleanly with download headers, or redirect external URLs
    $theme_uri = get_template_directory_uri();
    if (0 === strpos($target_url, $theme_uri . '/assets/files/')) {
        $rel_file  = basename(parse_url($target_url, PHP_URL_PATH));
        $full_path = get_template_directory() . '/assets/files/' . $rel_file;
        if (file_exists($full_path) && is_readable($full_path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($full_path) . '"');
            header('Content-Length: ' . filesize($full_path));
            readfile($full_path);
            exit;
        }
    }

    wp_redirect(esc_url_raw($target_url));
    exit;
}
add_action('template_redirect', 'mileym3dia_handle_protected_resource_download', 5);

/**
 * WooCommerce URL & Cart Count Helpers (Works in real WooCommerce and standalone router.php)
 */
function mileym3dia_get_cart_url() {
    if (function_exists('wc_get_cart_url')) {
        return wc_get_cart_url();
    }
    return home_url('/cart/');
}

function mileym3dia_get_checkout_url() {
    if (function_exists('wc_get_checkout_url')) {
        return wc_get_checkout_url();
    }
    return home_url('/checkout/');
}

function mileym3dia_get_account_url() {
    if (function_exists('wc_get_page_permalink')) {
        $acc = wc_get_page_permalink('myaccount');
        if (!empty($acc)) {
            return $acc;
        }
    }
    return home_url('/my-account/');
}

function mileym3dia_get_cart_count() {
    if (function_exists('WC') && WC() && isset(WC()->cart) && is_object(WC()->cart) && method_exists(WC()->cart, 'get_cart_contents_count')) {
        return (int) WC()->cart->get_cart_contents_count();
    }
    if (function_exists('mileym3dia_preview_get_cart_count')) {
        return (int) mileym3dia_preview_get_cart_count();
    }
    return 0;
}

/**
 * Default Studio Store Products (Unified WooCommerce Catalog with Authentic M3 Branded Artwork)
 */
function mileym3dia_get_default_store_products() {
    $files_base = get_template_directory_uri() . '/assets/files/';
    return array(
        array(
            'id'              => 501,
            'slug'            => 'm3-35mm-cinema-lut-suite',
            'title'           => 'M3 35mm Cinema LUT Suite (12 LUTs)',
            'price'           => '$49',
            'regular_price'   => '49',
            'category_slug'   => 'luts-video',
            'category_label'  => 'LUTS & VIDEO',
            'badge'           => 'BEST SELLER',
            'accent'          => 'blue',
            'format'          => '.CUBE // LOG & REC.709',
            'desc'            => 'Twelve production-calibrated color grading LUTs for RED, Sony S-Log3, Blackmagic, and Canon cameras. Instant WooCommerce digital download after checkout.',
            'btn_text'        => 'ADD TO CART',
            'is_downloadable' => true,
            'is_virtual'      => true,
            'is_physical'     => false,
            'download_file'   => $files_base . 'm3-35mm-cinema-lut-pack.cube',
            'attributes'      => array(),
            'grants_tier'     => '',
            'image'           => mileym3dia_asset_image_url('portfolio-5.jpg'),
        ),
        array(
            'id'              => 502,
            'slug'            => 'obsidian-analog-drum-synth-vault',
            'title'           => 'Obsidian Analog Drum & Synth Vault',
            'price'           => '$39',
            'regular_price'   => '39',
            'category_slug'   => 'audio-stems',
            'category_label'  => 'AUDIO & STEMS',
            'badge'           => 'STUDIO MASTER',
            'accent'          => 'yellow',
            'format'          => '24-BIT / 48KHZ WAV',
            'desc'            => '140+ royalty-free punchy drums, sub-bass loops, analog synth textures, and cinema risers tracked in-house. Delivered digitally via WooCommerce.',
            'btn_text'        => 'ADD TO CART',
            'is_downloadable' => true,
            'is_virtual'      => true,
            'is_physical'     => false,
            'download_file'   => $files_base . 'm3-studio-audio-stem-guide.txt',
            'attributes'      => array(),
            'grants_tier'     => '',
            'image'           => mileym3dia_asset_image_url('portfolio-2.jpg'),
        ),
        array(
            'id'              => 503,
            'slug'            => 'brutalist-brand-lookbook-system',
            'title'           => 'Brutalist Brand & Lookbook System',
            'price'           => '$59',
            'regular_price'   => '59',
            'category_slug'   => 'templates-guides',
            'category_label'  => 'TEMPLATES & GUIDES',
            'badge'           => 'NEW DROP',
            'accent'          => 'lime',
            'format'          => 'FIGMA + INDESIGN + PDF',
            'desc'            => 'Modular 12-column editorial lookbook, pitch deck, and brand identity presentation system built for creative agencies and artists.',
            'btn_text'        => 'ADD TO CART',
            'is_downloadable' => true,
            'is_virtual'      => true,
            'is_physical'     => false,
            'download_file'   => $files_base . 'm3-brand-lookbook-layout-guide.txt',
            'attributes'      => array(),
            'grants_tier'     => '',
            'image'           => mileym3dia_asset_image_url('portfolio-3.jpg'),
        ),
        array(
            'id'              => 504,
            'slug'            => 'producer-call-sheet-set-kit-pro',
            'title'           => 'Producer Call Sheet & Set Kit Pro',
            'price'           => '$24',
            'regular_price'   => '24',
            'category_slug'   => 'templates-guides',
            'category_label'  => 'TEMPLATES & GUIDES',
            'badge'           => 'WORKFLOW',
            'accent'          => 'red',
            'format'          => 'NOTION + SHEETS + PDF',
            'desc'            => 'Complete commercial & music video pre-production toolkit: call sheets, shot lists, DIT logs, and talent release forms.',
            'btn_text'        => 'ADD TO CART',
            'is_downloadable' => true,
            'is_virtual'      => true,
            'is_physical'     => false,
            'download_file'   => $files_base . 'm3-production-call-sheet-checklist.txt',
            'attributes'      => array(),
            'grants_tier'     => '',
            'image'           => mileym3dia_asset_image_url('portfolio-8.jpg'),
        ),
        array(
            'id'              => 505,
            'slug'            => 'm3-big-red-heavyweight-studio-hoodie',
            'title'           => 'M3 Big Red Heavyweight Studio Hoodie',
            'price'           => '$75',
            'regular_price'   => '75',
            'category_slug'   => 'merch-passes',
            'category_label'  => 'MERCH & PASSES',
            'badge'           => 'PHYSICAL MERCH',
            'accent'          => 'red',
            'format'          => '480GSM // S - XXL',
            'desc'            => 'Heavyweight 480gsm jet-black French terry hoodie with high-density crimson M3 chest & back screenprint. Ships worldwide via WooCommerce.',
            'btn_text'        => 'ADD TO CART',
            'is_downloadable' => false,
            'is_virtual'      => false,
            'is_physical'     => true,
            'download_file'   => '',
            'attributes'      => array('S', 'M', 'L', 'XL', 'XXL'),
            'grants_tier'     => '',
            'image'           => mileym3dia_asset_image_url('sections/hoodie-right-alt.jpg'),
        ),
        array(
            'id'              => 506,
            'slug'            => 'priority-4k-retainer-day-pass',
            'title'           => 'Priority 4K Retainer Day Pass + Pro Hub',
            'price'           => '$450',
            'regular_price'   => '450',
            'category_slug'   => 'merch-passes',
            'category_label'  => 'MERCH & PASSES',
            'badge'           => 'PRO ACCESS',
            'accent'          => 'yellow',
            'format'          => '1-DAY STUDIO CREDIT + PRO TIER',
            'desc'            => 'Lock in a priority 1-day studio shoot, audio mix, or edit sprint with 48-hour express delivery and instant Creator Hub Pro Vault access.',
            'btn_text'        => 'ADD TO CART',
            'is_downloadable' => false,
            'is_virtual'      => true,
            'is_physical'     => false,
            'download_file'   => '',
            'attributes'      => array(),
            'grants_tier'     => 'pro',
            'image'           => mileym3dia_asset_image_url('projects/project-5-corporate-video.jpg'),
        ),
    );
}

/**
 * Query Unified WooCommerce Store Products (with seamless fallback for standalone preview)
 */
function mileym3dia_get_store_products($cat = '') {
    $cat      = sanitize_title((string) $cat);
    $defaults = mileym3dia_get_default_store_products();
    $cat_labels = array(
        'luts-video'       => 'LUTS & VIDEO',
        'audio-stems'      => 'AUDIO & STEMS',
        'templates-guides' => 'TEMPLATES & GUIDES',
        'merch-passes'     => 'MERCH & PASSES',
    );

    if (function_exists('wc_get_products')) {
        $wc_args = array(
            'status'  => 'publish',
            'limit'   => 24,
            'orderby' => 'menu_order',
            'order'   => 'ASC',
        );
        if ($cat && 'all' !== $cat) {
            $wc_args['category'] = array($cat);
        }
        $wc_products = wc_get_products($wc_args);
        if (!empty($wc_products)) {
            $out = array();
            foreach ($wc_products as $wp_prod) {
                $pid        = $wp_prod->get_id();
                $slug       = $wp_prod->get_slug();
                $terms      = get_the_terms($pid, 'product_cat');
                $cat_slug   = ($terms && !is_wp_error($terms) && !empty($terms[0])) ? $terms[0]->slug : 'luts-video';
                $cat_label  = isset($cat_labels[$cat_slug]) ? $cat_labels[$cat_slug] : (isset($terms[0]) ? strtoupper($terms[0]->name) : 'DIGITAL ASSET');
                $img_url    = get_the_post_thumbnail_url($pid, 'large');
                if (empty($img_url)) {
                    $img_url = get_post_meta($pid, '_m3_image_url', true) ?: mileym3dia_asset_image_url('portfolio-5.jpg');
                }
                $price_raw  = $wp_prod->get_price();
                $price_disp = '' !== (string) $price_raw ? '$' . number_format((float) $price_raw, (fmod((float) $price_raw, 1) > 0 ? 2 : 0)) : '$0';
                $out[] = array(
                    'id'              => $pid,
                    'slug'            => $slug,
                    'title'           => $wp_prod->get_name(),
                    'price'           => $price_disp,
                    'regular_price'   => (string) $wp_prod->get_regular_price(),
                    'category_slug'   => $cat_slug,
                    'category_label'  => $cat_label,
                    'badge'           => get_post_meta($pid, '_m3_badge', true) ?: ($wp_prod->is_downloadable() ? 'DIGITAL DOWNLOAD' : 'STUDIO GEAR'),
                    'format'          => get_post_meta($pid, '_m3_format', true) ?: ($wp_prod->is_downloadable() ? 'INSTANT DIGITAL DELIVERY' : 'SHIPS WORLDWIDE'),
                    'desc'            => $wp_prod->get_short_description() ?: wp_strip_all_tags($wp_prod->get_description()),
                    'btn_text'        => 'ADD TO CART',
                    'permalink'       => get_permalink($pid),
                    'add_to_cart_url' => esc_url_raw(add_query_arg('add-to-cart', $pid, mileym3dia_get_cart_url())),
                    'is_downloadable' => (bool) $wp_prod->is_downloadable(),
                    'is_virtual'      => (bool) $wp_prod->is_virtual(),
                    'is_physical'     => !$wp_prod->is_virtual(),
                    'attributes'      => $wp_prod->get_attribute('size') ? array_map('trim', explode('|', $wp_prod->get_attribute('size'))) : array(),
                    'grants_tier'     => (string) get_post_meta($pid, '_m3_grants_membership_tier', true),
                    'image'           => $img_url,
                );
            }
            return $out;
        }
    }

    $products = array();
    foreach ($defaults as $idx => $item) {
        $n        = $idx + 1;
        $cat_slug = get_theme_mod("mileym3dia_store_item_{$n}_category_slug", $item['category_slug']);
        if ($cat && 'all' !== $cat && $cat !== $cat_slug) {
            continue;
        }
        $img = get_theme_mod("mileym3dia_store_item_{$n}_image", $item['image']);
        if (empty($img)) {
            $img = $item['image'];
        }
        $slug = $item['slug'];
        $products[] = array(
            'id'              => $item['id'],
            'slug'            => $slug,
            'title'           => get_theme_mod("mileym3dia_store_item_{$n}_title", $item['title']),
            'price'           => get_theme_mod("mileym3dia_store_item_{$n}_price", $item['price']),
            'regular_price'   => $item['regular_price'],
            'category_slug'   => $cat_slug,
            'category_label'  => isset($cat_labels[$cat_slug]) ? $cat_labels[$cat_slug] : $item['category_label'],
            'badge'           => get_theme_mod("mileym3dia_store_item_{$n}_badge", $item['badge']),
            'format'          => get_theme_mod("mileym3dia_store_item_{$n}_format", $item['format']),
            'desc'            => get_theme_mod("mileym3dia_store_item_{$n}_desc", $item['desc']),
            'btn_text'        => get_theme_mod("mileym3dia_store_item_{$n}_btn_text", $item['btn_text']),
            'permalink'       => home_url('/product/' . $slug . '/'),
            'add_to_cart_url' => add_query_arg('add-to-cart', $item['id'], mileym3dia_get_cart_url()),
            'is_downloadable' => $item['is_downloadable'],
            'is_virtual'      => $item['is_virtual'],
            'is_physical'     => $item['is_physical'],
            'attributes'      => $item['attributes'],
            'grants_tier'     => $item['grants_tier'],
            'image'           => $img,
        );
    }
    return $products;
}

/**
 * WooCommerce Order Completion -> Automatic Creator Hub Pro Membership Upgrade Hook
 */
function mileym3dia_wc_order_upgrade_membership($order_id) {
    if (!function_exists('wc_get_order')) {
        return;
    }
    $order = wc_get_order($order_id);
    if (!$order) {
        return;
    }
    $user_id = (int) $order->get_user_id();
    if ($user_id <= 0) {
        return;
    }
    foreach ($order->get_items() as $item) {
        $product_id = method_exists($item, 'get_product_id') ? (int) $item->get_product_id() : 0;
        if ($product_id > 0) {
            $grants = (string) get_post_meta($product_id, '_m3_grants_membership_tier', true);
            if (!empty($grants)) {
                mileym3dia_upgrade_user_membership($user_id, $grants, array('order_id' => $order_id, 'product_id' => $product_id));
            }
        }
    }
}
add_action('woocommerce_order_status_completed', 'mileym3dia_wc_order_upgrade_membership');
add_action('woocommerce_payment_complete', 'mileym3dia_wc_order_upgrade_membership');

/**
 * Native WordPress Creator Hub Auth, Profile, Brief & Newsletter Handler
 */
function mileym3dia_handle_portal_and_store_posts() {
    if ('POST' !== ($_SERVER['REQUEST_METHOD'] ?? '')) {
        return;
    }

    // Server-side Newsletter subscription handler (`m3_newsletter_nonce` + `m3_newsletter_email`)
    if (isset($_POST['m3_newsletter_email'])) {
        if (!isset($_POST['m3_newsletter_nonce']) || (function_exists('wp_verify_nonce') && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['m3_newsletter_nonce'])), 'm3_newsletter_action'))) {
            return;
        }
        $sub_email = sanitize_email(wp_unslash($_POST['m3_newsletter_email']));
        $referer   = function_exists('wp_get_referer') && wp_get_referer() ? wp_get_referer() : home_url('/');
        if (!empty($sub_email) && is_email($sub_email)) {
            if (function_exists('get_option') && function_exists('update_option')) {
                $subs = get_option('mileym3dia_newsletter_subscribers', array());
                if (!is_array($subs)) {
                    $subs = array();
                }
                if (!in_array($sub_email, $subs, true)) {
                    $subs[] = $sub_email;
                    update_option('mileym3dia_newsletter_subscribers', $subs, false);
                }
            }
            if (function_exists('wp_mail')) {
                $studio_email = get_theme_mod('mileym3dia_contact_email', get_option('admin_email'));
                if (!empty($studio_email)) {
                    wp_mail($studio_email, 'New MILEYM3DIA Newsletter Subscriber', "Email: {$sub_email}");
                }
            }
            wp_safe_redirect(add_query_arg('subscribed', '1', $referer));
            exit;
        }
        wp_safe_redirect(add_query_arg('subscribed', 'invalid', $referer));
        exit;
    }

    $action = isset($_POST['mileym3dia_action']) ? sanitize_key(wp_unslash($_POST['mileym3dia_action'])) : '';
    if (empty($action)) {
        return;
    }

    $hub_url = mileym3dia_get_page_url('creator-hub');

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
        update_user_meta($user_id, 'm3_membership_tier', 'free');
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true);

        if (function_exists('wp_mail') && !empty($email)) {
            $studio_email = get_theme_mod('mileym3dia_contact_email', get_option('admin_email'));
            $welcome_body = "Welcome to MILEYM3DIA Creator Hub, " . ($fullname ?: $username) . "!\n\nYour free studio membership ({$username}) is now active. Sign in anytime at:\n{$hub_url}\n\n— MILEYM3DIA Studio";
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
        $user = wp_signon($creds, is_ssl());

        if (is_wp_error($user)) {
            wp_safe_redirect(add_query_arg(array('tab' => 'login', 'auth_error' => 'Invalid username/email or password.'), $hub_url) . '#portal-access');
            exit;
        }
        wp_safe_redirect(add_query_arg('auth', 'logged_in', $hub_url) . '#portal-access');
        exit;
    }

    if ('logout_user' === $action && function_exists('wp_logout')) {
        if (!isset($_POST['mileym3dia_logout_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mileym3dia_logout_nonce'])), 'mileym3dia_logout_action')) {
            return;
        }
        wp_logout();
        wp_safe_redirect(add_query_arg(array('tab' => 'login', 'auth' => 'logged_out'), $hub_url) . '#portal-access');
        exit;
    }

    if ('lost_password' === $action && function_exists('retrieve_password')) {
        if (!isset($_POST['mileym3dia_reset_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mileym3dia_reset_nonce'])), 'mileym3dia_reset_action')) {
            return;
        }
        $user_login = sanitize_text_field(wp_unslash($_POST['user_login'] ?? ''));
        if (empty($user_login)) {
            wp_safe_redirect(add_query_arg(array('tab' => 'reset', 'auth_error' => 'Please enter your username or email address.'), $hub_url) . '#portal-access');
            exit;
        }
        $res = retrieve_password($user_login);
        if (is_wp_error($res)) {
            wp_safe_redirect(add_query_arg(array('tab' => 'reset', 'auth_error' => $res->get_error_message()), $hub_url) . '#portal-access');
            exit;
        }
        wp_safe_redirect(add_query_arg(array('tab' => 'reset', 'auth' => 'reset_sent'), $hub_url) . '#portal-access');
        exit;
    }

    if ('update_profile' === $action && function_exists('is_user_logged_in') && is_user_logged_in() && function_exists('wp_update_user')) {
        if (!isset($_POST['mileym3dia_profile_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mileym3dia_profile_nonce'])), 'mileym3dia_profile_action')) {
            return;
        }
        $uid       = get_current_user_id();
        $disp_name = sanitize_text_field(wp_unslash($_POST['profile_display_name'] ?? ''));
        $email     = sanitize_email(wp_unslash($_POST['profile_email'] ?? ''));
        $company   = sanitize_text_field(wp_unslash($_POST['profile_company'] ?? ''));
        $acc_type  = sanitize_key(wp_unslash($_POST['profile_account_type'] ?? 'creator'));
        $website   = esc_url_raw(wp_unslash($_POST['profile_website'] ?? ''));
        $bio       = sanitize_textarea_field(wp_unslash($_POST['profile_bio'] ?? ''));
        $new_pass  = (string) ($_POST['profile_new_password'] ?? '');

        $update_args = array(
            'ID'           => $uid,
            'display_name' => $disp_name,
            'user_url'     => $website,
            'description'  => $bio,
        );
        if (!empty($email) && is_email($email)) {
            $update_args['user_email'] = $email;
        }
        if (strlen($new_pass) >= 6) {
            $update_args['user_pass'] = $new_pass;
        }

        $res = wp_update_user($update_args);
        if (is_wp_error($res)) {
            wp_safe_redirect(add_query_arg(array('auth_error' => $res->get_error_message()), $hub_url) . '#portal-access');
            exit;
        }
        update_user_meta($uid, 'm3_company', $company);
        update_user_meta($uid, 'm3_account_type', $acc_type);
        wp_safe_redirect(add_query_arg('auth', 'profile_updated', $hub_url) . '#portal-access');
        exit;
    }

    if ('submit_brief' === $action && function_exists('is_user_logged_in') && is_user_logged_in()) {
        if (!isset($_POST['mileym3dia_brief_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mileym3dia_brief_nonce'])), 'mileym3dia_brief_action')) {
            return;
        }
        $uid        = get_current_user_id();
        $user_obj   = function_exists('wp_get_current_user') ? wp_get_current_user() : null;
        $title      = sanitize_text_field(wp_unslash($_POST['brief_title'] ?? ''));
        $discipline = sanitize_text_field(wp_unslash($_POST['brief_discipline'] ?? ''));
        $timeline   = sanitize_text_field(wp_unslash($_POST['brief_timeline'] ?? ''));
        $details    = sanitize_textarea_field(wp_unslash($_POST['brief_details'] ?? ''));

        if (!empty($title) && function_exists('wp_insert_post')) {
            $brief_id = wp_insert_post(array(
                'post_title'   => $title . ($discipline ? ' [' . $discipline . ']' : ''),
                'post_content' => $details,
                'post_status'  => 'publish',
                'post_type'    => 'm3_inquiry',
                'post_author'  => $uid,
            ));
            if ($brief_id && !is_wp_error($brief_id)) {
                update_post_meta($brief_id, '_m3_brief_discipline', $discipline);
                update_post_meta($brief_id, '_m3_brief_timeline', $timeline);
                update_post_meta($brief_id, '_m3_brief_status', 'IN REVIEW');
                update_post_meta($brief_id, '_m3_brief_progress', 15);
            }
            if (function_exists('wp_mail')) {
                $studio_email = get_theme_mod('mileym3dia_contact_email', get_option('admin_email'));
                $sender_email = ($user_obj && !empty($user_obj->user_email)) ? $user_obj->user_email : '';
                if (!empty($studio_email)) {
                    wp_mail($studio_email, 'New Creator Hub Project Brief: ' . $title, "Client: {$sender_email}\nDiscipline: {$discipline}\nTimeline: {$timeline}\n\n{$details}");
                }
            }
        }
        wp_safe_redirect(add_query_arg('auth', 'brief_submitted', $hub_url) . '#portal-access');
        exit;
    }
}
add_action('template_redirect', 'mileym3dia_handle_portal_and_store_posts');

/**
 * Lightweight SEO Meta Description, OpenGraph & JSON-LD Schema (Skipped if Yoast/RankMath/AIOSEO active)
 */
function mileym3dia_output_seo_meta() {
    if (defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION') || defined('AIOSEO_VERSION')) {
        return;
    }
    $site_name = get_bloginfo('name') ?: 'MILEYM3DIA';
    $tagline   = get_bloginfo('description') ?: 'Creative Media Agency — Video Production, Photography, Branding, Web Design & Music Production.';
    $title     = is_front_page() ? ($site_name . ' — ' . $tagline) : (wp_get_document_title() ?: $site_name);
    $desc      = $tagline;
    if (is_singular() && function_exists('get_the_excerpt')) {
        $ex = trim(wp_strip_all_tags((string) get_the_excerpt()));
        if (!empty($ex)) {
            $desc = $ex;
        }
    }
    $url = home_url(isset($_SERVER['REQUEST_URI']) ? (string) parse_url((string) $_SERVER['REQUEST_URI'], PHP_URL_PATH) : '/');
    $img = mileym3dia_asset_image_url('hero-cinematic.jpg');
    if (is_singular() && function_exists('has_post_thumbnail') && has_post_thumbnail()) {
        $thumb = get_the_post_thumbnail_url(null, 'large');
        if ($thumb) {
            $img = $thumb;
        }
    }
    echo "\n" . '<meta name="description" content="' . esc_attr($desc) . '" />' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '" />' . "\n";
    echo '<meta property="og:type" content="' . (is_singular('post') ? 'article' : 'website') . '" />' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($desc) . '" />' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '" />' . "\n";
    echo '<meta property="og:image" content="' . esc_url($img) . '" />' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'Organization',
        'name'        => $site_name,
        'url'         => home_url('/'),
        'description' => $tagline,
        'logo'        => mileym3dia_asset_image_url('hero-cinematic.jpg'),
    );
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
add_action('wp_head', 'mileym3dia_output_seo_meta', 5);

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

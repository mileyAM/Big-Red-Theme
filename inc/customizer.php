<?php
/**
 * MILEYM3DIA Theme Customizer (M3 Big Red)
 * Full control over colors, dark shades, homepage section order, typography copy,
 * images, downloadable files, store products, creator hub registration, and sections.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

function mileym3dia_add_customizer_field($wp_customize, $id, $section, $label, $default = '', $type = 'text', $args = array()) {
    $sanitize = 'sanitize_text_field';
    if ('textarea' === $type) {
        $sanitize = 'wp_kses_post';
    } elseif ('url' === $type) {
        $sanitize = 'esc_url_raw';
    } elseif ('email' === $type) {
        $sanitize = 'sanitize_email';
    } elseif ('checkbox' === $type) {
        $sanitize = 'mileym3dia_sanitize_checkbox';
    } elseif ('number' === $type) {
        $sanitize = 'absint';
    }

    $wp_customize->add_setting($id, array(
        'default'           => $default,
        'sanitize_callback' => $sanitize,
        'transport'         => $args['transport'] ?? 'refresh',
    ));

    $control_args = array_merge(array(
        'type'     => $type,
        'label'    => $label,
        'section'  => $section,
        'settings' => $id,
    ), $args);

    $wp_customize->add_control($id, $control_args);
}

function mileym3dia_add_customizer_color($wp_customize, $id, $section, $label, $default) {
    $wp_customize->add_setting($id, array(
        'default'           => $default,
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, array(
        'label'    => $label,
        'section'  => $section,
        'settings' => $id,
    )));
}

function mileym3dia_add_customizer_image($wp_customize, $id, $section, $label, $default = '') {
    $wp_customize->add_setting($id, array(
        'default'           => $default,
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $id, array(
        'label'    => $label,
        'section'  => $section,
        'settings' => $id,
    )));
}

function mileym3dia_add_customizer_file($wp_customize, $id, $section, $label, $default = '') {
    $wp_customize->add_setting($id, array(
        'default'           => $default,
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    if (class_exists('WP_Customize_Upload_Control')) {
        $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, $id, array(
            'label'    => $label,
            'section'  => $section,
            'settings' => $id,
        )));
    } else {
        $wp_customize->add_control($id, array(
            'type'     => 'url',
            'label'    => $label,
            'section'  => $section,
            'settings' => $id,
        ));
    }
}

function mileym3dia_sanitize_checkbox($checked) {
    return (isset($checked) && true === (bool) $checked);
}

function mileym3dia_customize_register($wp_customize) {
    if ($wp_customize->get_setting('blogname')) {
        $wp_customize->get_setting('blogname')->transport = 'postMessage';
    }
    if ($wp_customize->get_setting('blogdescription')) {
        $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    }

    // ============================================
    // 1. BRANDING & HEADER
    // ============================================
    $wp_customize->add_section('mileym3dia_header', array(
        'title'    => __('1. Header & Branding', 'm3-big-red'),
        'priority' => 20,
    ));

    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_brand_prefix', 'mileym3dia_header', __('Brand Wordmark Prefix', 'm3-big-red'), 'MILEYM');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_brand_accent_char', 'mileym3dia_header', __('Brand Accent Character', 'm3-big-red'), '3');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_brand_suffix', 'mileym3dia_header', __('Brand Wordmark Suffix', 'm3-big-red'), 'DIA');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_brand_tagline', 'mileym3dia_header', __('Brand Badge Tagline', 'm3-big-red'), 'CREATIVE MEDIA AGENCY');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_sticky_header', 'mileym3dia_header', __('Enable Sticky Header', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_header_cta_text', 'mileym3dia_header', __('Header CTA Button Text', 'm3-big-red'), 'START A PROJECT');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_header_cta_url', 'mileym3dia_header', __('Header CTA Button URL', 'm3-big-red'), '/contact/', 'url');

    // ============================================
    // 2. DARK BASE & BOLD ACCENT COLORS
    // ============================================
    $wp_customize->add_section('mileym3dia_colors', array(
        'title'       => __('2. Colors & Dark Shades', 'm3-big-red'),
        'description' => __('Customize the layered dark background shades and bold complementary accent palette.', 'm3-big-red'),
        'priority'    => 25,
    ));

    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_bg_color', 'mileym3dia_colors', __('Dark Base Layer 1 (Obsidian Black)', 'm3-big-red'), '#080808');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_bg_elevated', 'mileym3dia_colors', __('Dark Base Layer 2 (Alternating Section Shade)', 'm3-big-red'), '#0E0E13');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_bg_surface', 'mileym3dia_colors', __('Dark Base Layer 3 (Cards & Surfaces)', 'm3-big-red'), '#14141C');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_text_color', 'mileym3dia_colors', __('Primary Text Color (Off-White)', 'm3-big-red'), '#F5F5F0');

    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_color_red', 'mileym3dia_colors', __('MILEYM3DIA Red (Primary Brand Accent)', 'm3-big-red'), '#EF252C');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_color_purple', 'mileym3dia_colors', __('Studio Purple Accent', 'm3-big-red'), '#8B38DC');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_color_blue', 'mileym3dia_colors', __('Electric Blue Accent', 'm3-big-red'), '#258DFF');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_color_lime', 'mileym3dia_colors', __('Kinetic Lime Accent', 'm3-big-red'), '#D4F329');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_color_yellow', 'mileym3dia_colors', __('Highlight Yellow Accent', 'm3-big-red'), '#FFDD00');

    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_accent_about', 'mileym3dia_colors', __('About Page Accent', 'm3-big-red'), '#EF252C');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_accent_services', 'mileym3dia_colors', __('Services & Pricing Page Accent (Electric Green)', 'm3-big-red'), '#39FF14');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_accent_work', 'mileym3dia_colors', __('Portfolio / Work Page Accent (Purple)', 'm3-big-red'), '#8B38DC');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_accent_store', 'mileym3dia_colors', __('Digital Shop Page Accent (Lime)', 'm3-big-red'), '#D4F329');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_accent_resources', 'mileym3dia_colors', __('Resources Page Accent (Blue)', 'm3-big-red'), '#258DFF');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_accent_creator_hub', 'mileym3dia_colors', __('Creator Hub Page Accent (Blue)', 'm3-big-red'), '#258DFF');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_accent_blog', 'mileym3dia_colors', __('Blog / Journal Page Accent', 'm3-big-red'), '#EF252C');
    mileym3dia_add_customizer_color($wp_customize, 'mileym3dia_accent_contact', 'mileym3dia_colors', __('Contact Page Accent', 'm3-big-red'), '#EF252C');

    // ============================================
    // 2C. BRAND BANNERS & PAGE ARTWORK (WORDPRESS-NATIVE)
    // ============================================
    if (function_exists('mileym3dia_get_page_banner_defaults')) {
        $wp_customize->add_panel('mileym3dia_banners_panel', array(
            'title'       => __('2C. Brand Banners & Page Artwork', 'm3-big-red'),
            'description' => __('Manage desktop/mobile banner artwork, alt text, focal positioning, overlay mode, editable headings, and functional CTAs for every page. Check "Restore Default Artwork" anytime to revert to the bundled original MILEYM3DIA banners.', 'm3-big-red'),
            'priority'    => 28,
        ));

        $banner_priority = 10;
        foreach (mileym3dia_get_page_banner_defaults() as $b_key => $b_def) {
            $sec_id = 'mileym3dia_banner_section_' . $b_key;
            $prefix = 'mileym3dia_banner_' . $b_key . '_';

            $wp_customize->add_section($sec_id, array(
                'title'       => $b_def['label'],
                'panel'       => 'mileym3dia_banners_panel',
                'description' => sprintf(__('Default desktop asset: %s | Default mobile asset: %s', 'm3-big-red'), $b_def['desktop_asset'], $b_def['mobile_asset']),
                'priority'    => $banner_priority,
            ));
            $banner_priority += 10;

            mileym3dia_add_customizer_image($wp_customize, $prefix . 'desktop', $sec_id, __('Desktop Banner Image (Leave empty for bundled default)', 'm3-big-red'), '');
            mileym3dia_add_customizer_image($wp_customize, $prefix . 'mobile', $sec_id, __('Mobile Banner Image (Optional — Leave empty for bundled default)', 'm3-big-red'), '');
            mileym3dia_add_customizer_field($wp_customize, $prefix . 'restore_default', $sec_id, __('Restore Default Original MILEYM3DIA Artwork', 'm3-big-red'), false, 'checkbox');
            mileym3dia_add_customizer_field($wp_customize, $prefix . 'alt', $sec_id, __('Banner Alt Text (Accessibility)', 'm3-big-red'), $b_def['alt']);
            mileym3dia_add_customizer_field($wp_customize, $prefix . 'mode', $sec_id, __('Display Mode', 'm3-big-red'), $b_def['mode'], 'select', array(
                'choices' => array(
                    'intact'  => __('Intact Original Banner + Action Bar Below (Recommended for composite art)', 'm3-big-red'),
                    'overlay' => __('Clean Plate Background + HTML Text Overlay', 'm3-big-red'),
                ),
            ));
            mileym3dia_add_customizer_field($wp_customize, $prefix . 'position', $sec_id, __('Focal Position', 'm3-big-red'), $b_def['position'], 'select', array(
                'choices' => array(
                    'center center' => __('Center', 'm3-big-red'),
                    'left center'   => __('Left Center', 'm3-big-red'),
                    'right center'  => __('Right Center', 'm3-big-red'),
                    'center top'    => __('Top Center', 'm3-big-red'),
                    'center bottom' => __('Bottom Center', 'm3-big-red'),
                ),
            ));
            mileym3dia_add_customizer_field($wp_customize, $prefix . 'overlay', $sec_id, __('Overlay Scrim Strength (Overlay Mode)', 'm3-big-red'), $b_def['overlay'], 'select', array(
                'choices' => array(
                    'none'     => __('None (0%)', 'm3-big-red'),
                    'subtle'   => __('Subtle (35%)', 'm3-big-red'),
                    'balanced' => __('Balanced (55%)', 'm3-big-red'),
                    'deep'     => __('Deep (72%)', 'm3-big-red'),
                ),
            ));
            mileym3dia_add_customizer_field($wp_customize, $prefix . 'eyebrow', $sec_id, __('Banner Eyebrow Label', 'm3-big-red'), $b_def['eyebrow']);
            mileym3dia_add_customizer_field($wp_customize, $prefix . 'heading', $sec_id, __('Banner Heading', 'm3-big-red'), $b_def['heading']);
            mileym3dia_add_customizer_field($wp_customize, $prefix . 'subheading', $sec_id, __('Banner Subheading', 'm3-big-red'), $b_def['subheading'], 'textarea');
            mileym3dia_add_customizer_field($wp_customize, $prefix . 'cta_text', $sec_id, __('Primary CTA Button Text', 'm3-big-red'), $b_def['cta_text']);
            mileym3dia_add_customizer_field($wp_customize, $prefix . 'cta_url', $sec_id, __('Primary CTA Destination (slug, #anchor, or URL)', 'm3-big-red'), $b_def['cta_url']);
        }
    }

    // ============================================
    // 2B. HOMEPAGE SECTION POSITION & ORDERING
    // ============================================
    $wp_customize->add_section('mileym3dia_section_order', array(
        'title'       => __('2B. Homepage Section Order & Visibility', 'm3-big-red'),
        'description' => __('Adjust the numeric position (10, 20, 30...) of each homepage section to reorder them, or toggle visibility.', 'm3-big-red'),
        'priority'    => 27,
    ));

    $homepage_sections = array(
        'about'    => array('Studio Bento / About', 10),
        'work'     => array('Selected Work / Portfolio', 20),
        'services' => array('Core Creative Services', 30),
        'pricing'  => array('Packages & Custom Bundles', 40),
        'store'    => array('Studio Store Featured Drops', 50),
        'blog'     => array('Latest Blog / Studio Journal', 60),
        'contact'  => array('Contact CTA Banner', 70),
    );

    foreach ($homepage_sections as $sec_key => $sec_meta) {
        mileym3dia_add_customizer_field(
            $wp_customize,
            "mileym3dia_section_order_{$sec_key}",
            'mileym3dia_section_order',
            sprintf(__('Position Order: %s', 'm3-big-red'), $sec_meta[0]),
            $sec_meta[1],
            'number',
            array('input_attrs' => array('min' => 1, 'max' => 200, 'step' => 5))
        );
    }

    // ============================================
    // 3. FULL-WIDTH HERO SECTION
    // ============================================
    $wp_customize->add_section('mileym3dia_hero', array(
        'title'       => __('3. Full-Width Hero Section', 'm3-big-red'),
        'description' => __('Full-bleed background image and oversized display typography.', 'm3-big-red'),
        'priority'    => 30,
    ));

    mileym3dia_add_customizer_image($wp_customize, 'mileym3dia_hero_slide1_image', 'mileym3dia_hero', __('Full-Width Hero Background Image', 'm3-big-red'), get_template_directory_uri() . '/assets/images/hero-cinematic.jpg');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hero_eyebrow', 'mileym3dia_hero', __('Hero Eyebrow Badge', 'm3-big-red'), 'FULL-SERVICE CREATIVE MEDIA AGENCY');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hero_headline_1', 'mileym3dia_hero', __('Oversized Headline — Line 1', 'm3-big-red'), 'WE CREATE');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hero_headline_2', 'mileym3dia_hero', __('Oversized Headline — Line 2 (Red Accent)', 'm3-big-red'), 'VISUALS THAT');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hero_headline_3', 'mileym3dia_hero', __('Oversized Headline — Line 3', 'm3-big-red'), 'HIT DIFFERENT.');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hero_disciplines', 'mileym3dia_hero', __('Core Services Strip', 'm3-big-red'), 'VIDEO PRODUCTION · PHOTOGRAPHY · BRANDING · WEB DESIGN · MUSIC & AUDIO');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hero_description', 'mileym3dia_hero', __('Hero Lead Description', 'm3-big-red'), 'We partner with ambitious brands, recording artists, and businesses to produce cinema-grade video, editorial photography, standout brand identities, custom websites, and studio audio.', 'textarea');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hero_cta_primary', 'mileym3dia_hero', __('Primary Button Text', 'm3-big-red'), 'START A PROJECT');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hero_cta_primary_url', 'mileym3dia_hero', __('Primary Button URL', 'm3-big-red'), '/contact/', 'url');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hero_cta_secondary', 'mileym3dia_hero', __('Secondary Button Text', 'm3-big-red'), 'VIEW OUR WORK');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hero_cta_secondary_url', 'mileym3dia_hero', __('Secondary Button URL', 'm3-big-red'), '/work/', 'url');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_show_trust_bar', 'mileym3dia_hero', __('Show Production Gear & Software Bar', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_trust_bar_items', 'mileym3dia_hero', __('Gear & Software Names (comma-separated)', 'm3-big-red'), 'RED DIGITAL CINEMA, SONY CINEMA LINE, CANON, BLACKMAGIC DESIGN, DJI PRO, DAVINCI RESOLVE, ADOBE CREATIVE CLOUD, LOGIC PRO');

    // ============================================
    // 4. SIDE-TO-SIDE STUDIO, ABOUT & GEAR
    // ============================================
    $wp_customize->add_section('mileym3dia_about', array(
        'title'       => __('4. Studio, About & Gear', 'm3-big-red'),
        'description' => __('Controls the Studio Bento and About page sections (#overview, #process, #gear).', 'm3-big-red'),
        'priority'    => 35,
    ));

    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_show_brand_statement', 'mileym3dia_about', __('Show Studio Bento Section on Homepage', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_eyebrow', 'mileym3dia_about', __('Section Eyebrow', 'm3-big-red'), '01 / WHO WE ARE');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_title', 'mileym3dia_about', __('Big Section Headline', 'm3-big-red'), 'CREATIVE PRODUCTION WITHOUT COMPROMISE.');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_content', 'mileym3dia_about', __('Studio Lead Paragraph', 'm3-big-red'), 'MILEYM3DIA is a full-service creative production agency uniting directors, photographers, brand designers, web developers, and audio engineers under one roof.', 'textarea');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_body_2', 'mileym3dia_about', __('Studio Secondary Paragraph', 'm3-big-red'), 'From commercial video shoots and album rollouts to complete brand overhauls and custom web builds, we handle every phase from concept to final delivery with precision and speed.', 'textarea');
    mileym3dia_add_customizer_image($wp_customize, 'mileym3dia_about_image', 'mileym3dia_about', __('Side-to-Side Studio Image', 'm3-big-red'), get_template_directory_uri() . '/assets/images/about-image.jpg');
    mileym3dia_add_customizer_image($wp_customize, 'mileym3dia_about_split2_image', 'mileym3dia_about', __('About Page Second Split Image', 'm3-big-red'), get_template_directory_uri() . '/assets/images/hero-cinematic.jpg');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_stat1_num', 'mileym3dia_about', __('Highlight 1 Number/Title', 'm3-big-red'), '4K / 8K');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_stat1_label', 'mileym3dia_about', __('Highlight 1 Label', 'm3-big-red'), 'CINEMA CAMERA PRODUCTION');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_stat2_num', 'mileym3dia_about', __('Highlight 2 Number/Title', 'm3-big-red'), '5 CORE');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_stat2_label', 'mileym3dia_about', __('Highlight 2 Label', 'm3-big-red'), 'IN-HOUSE DISCIPLINES');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_stat3_num', 'mileym3dia_about', __('Highlight 3 Number/Title', 'm3-big-red'), '100%');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_stat3_label', 'mileym3dia_about', __('Highlight 3 Label', 'm3-big-red'), 'CUSTOM STRATEGY & EXECUTION');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_split2_eyebrow', 'mileym3dia_about', __('Process Split Eyebrow', 'm3-big-red'), 'HOW WE WORK');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_split2_title', 'mileym3dia_about', __('Process Split Headline', 'm3-big-red'), 'ONE STUDIO. EVERY CREATIVE DISCIPLINE.');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_split2_desc', 'mileym3dia_about', __('Process Split Description', 'm3-big-red'), 'Instead of hiring separate freelancers for video, photography, branding, web development, and audio, our clients work with one unified creative team.', 'textarea');

    // Missing About & Studio Controls (F2)
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_hero_title', 'mileym3dia_about', __('About Page Hero Title (Optional Override)', 'm3-big-red'), '');
    mileym3dia_add_customizer_image($wp_customize, 'mileym3dia_about_hero_image', 'mileym3dia_about', __('About Page Hero Background Image (Optional)', 'm3-big-red'), '');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_story_eyebrow', 'mileym3dia_about', __('About Story Split Eyebrow', 'm3-big-red'), '01 / STUDIO OVERVIEW');

    // 4 Homepage Studio Pillars
    $default_pillars = array(
        1 => array('title' => 'CINEMA-GRADE EQUIPMENT', 'desc' => 'Shot on RED, Sony FX, and Blackmagic cinema cameras with pro lighting & audio.'),
        2 => array('title' => 'INTEGRATED BRAND & WEB', 'desc' => 'Visual identity, graphic design, and custom web builds that match your media.'),
        3 => array('title' => 'FAST 7–14 DAY DELIVERY', 'desc' => 'Clear milestones, direct communication, and on-time final masters.'),
        4 => array('title' => 'FULL COMMERCIAL RIGHTS', 'desc' => 'Every package includes complete commercial licensing for your brand or release.'),
    );
    foreach ($default_pillars as $p_idx => $p_def) {
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_pillar_{$p_idx}_title", 'mileym3dia_about', sprintf(__('Studio Pillar %d Title', 'm3-big-red'), $p_idx), $p_def['title']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_pillar_{$p_idx}_desc", 'mileym3dia_about', sprintf(__('Studio Pillar %d Description', 'm3-big-red'), $p_idx), $p_def['desc'], 'textarea');
    }

    // 2 Homepage Studio CTA Buttons
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_cta_1_text', 'mileym3dia_about', __('Homepage Studio Primary CTA Text', 'm3-big-red'), 'MORE ABOUT THE STUDIO');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_cta_1_url', 'mileym3dia_about', __('Homepage Studio Primary CTA URL', 'm3-big-red'), '/about/', 'url');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_cta_2_text', 'mileym3dia_about', __('Homepage Studio Secondary CTA Text', 'm3-big-red'), 'BOOK A CONSULTATION');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_about_cta_2_url', 'mileym3dia_about', __('Homepage Studio Secondary CTA URL', 'm3-big-red'), '/contact/', 'url');

    // 3 About Page Checklist Items
    $default_checks = array(
        1 => array('title' => 'Cinematic Visuals:', 'desc' => 'Every frame is lit, directed, and color-graded to broadcast and cinema standards.'),
        2 => array('title' => 'Cohesive Brand Identity:', 'desc' => 'Logos, typography, packaging, and web design built around a single strong brand story.'),
        3 => array('title' => 'Studio-Grade Sound:', 'desc' => 'Clean location audio, custom scoring, mixing, and mastering handled in-house.'),
    );
    foreach ($default_checks as $c_idx => $c_def) {
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_about_check_{$c_idx}_title", 'mileym3dia_about', sprintf(__('About Checklist %d Title', 'm3-big-red'), $c_idx), $c_def['title']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_about_check_{$c_idx}_desc", 'mileym3dia_about', sprintf(__('About Checklist %d Description', 'm3-big-red'), $c_idx), $c_def['desc'], 'textarea');
    }

    // 15 Gear Arsenal Settings
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_gear_eyebrow', 'mileym3dia_about', __('Gear Arsenal Section Eyebrow', 'm3-big-red'), '03 / PRODUCTION ARSENAL');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_gear_title', 'mileym3dia_about', __('Gear Arsenal Section Title', 'm3-big-red'), 'CINEMA HARDWARE & POST PIPELINE');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_gear_desc', 'mileym3dia_about', __('Gear Arsenal Section Description', 'm3-big-red'), 'Industry-standard cinema cameras, prime and anamorphic lenses, drone systems, and dedicated post-production suites.', 'textarea');

    $default_gear = array(
        1 => array('title' => 'CINEMA CAMERAS', 'desc' => 'RED Digital Cinema, Sony FX Cinema Line, and Blackmagic 6K Pro camera packages with RAW recording.', 'tag' => '4K / 6K / 8K RAW'),
        2 => array('title' => 'LENSES & LIGHTING', 'desc' => 'Cinema prime lenses, anamorphic glass, and full-spectrum LED studio and location lighting kits.', 'tag' => 'PRIME & ANAMORPHIC'),
        3 => array('title' => 'AERIAL & MOTION', 'desc' => 'Licensed drone cinematography, 3-axis cinema gimbals, vehicle mounts, and wireless director monitoring.', 'tag' => 'AERIAL & STABILIZATION'),
        4 => array('title' => 'EDIT, COLOR & AUDIO', 'desc' => 'DaVinci Resolve Studio color grading, Adobe Creative Cloud, custom web stack, and treated audio mixing suites.', 'tag' => 'POST & MASTERING'),
    );
    foreach ($default_gear as $g_idx => $g_def) {
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_gear_{$g_idx}_tag", 'mileym3dia_about', sprintf(__('Gear Card %d Tag', 'm3-big-red'), $g_idx), $g_def['tag']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_gear_{$g_idx}_title", 'mileym3dia_about', sprintf(__('Gear Card %d Title', 'm3-big-red'), $g_idx), $g_def['title']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_gear_{$g_idx}_desc", 'mileym3dia_about', sprintf(__('Gear Card %d Description', 'm3-big-red'), $g_idx), $g_def['desc'], 'textarea');
    }

    // ============================================
    // 5. SELECTED WORK / PORTFOLIO
    // ============================================
    $wp_customize->add_section('mileym3dia_portfolio', array(
        'title'       => __('5. Selected Work & Portfolio', 'm3-big-red'),
        'description' => __('Manage the Portfolio section header and all 4 featured case studies.', 'm3-big-red'),
        'priority'    => 40,
    ));

    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_show_selected_work', 'mileym3dia_portfolio', __('Show Selected Work on Homepage', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_portfolio_eyebrow', 'mileym3dia_portfolio', __('Portfolio Section Eyebrow', 'm3-big-red'), '02 / SELECTED WORK');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_portfolio_title', 'mileym3dia_portfolio', __('Portfolio Big Headline', 'm3-big-red'), 'FEATURED PRODUCTIONS');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_portfolio_hero_title', 'mileym3dia_portfolio', __('Portfolio Page Hero Title (Optional Override)', 'm3-big-red'), 'FEATURED PRODUCTIONS');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_portfolio_desc', 'mileym3dia_portfolio', __('Portfolio Section Intro', 'm3-big-red'), 'Recent commercial films, music videos, brand identity systems, web builds, and photography campaigns.', 'textarea');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_portfolio_count', 'mileym3dia_portfolio', __('Number of Projects to Display', 'm3-big-red'), 4, 'number', array('input_attrs' => array('min' => 1, 'max' => 12)));

    $default_projects = array(
        1 => array('title' => 'NIGHTFALL APPAREL CAMPAIGN', 'cat' => 'VIDEO PRODUCTION & LOOKBOOK', 'year' => '2026', 'client' => 'NIGHTFALL ATELIER', 'desc' => 'Full commercial video production, street lookbook photography, and social campaign rollout for Nightfall Atelier.'),
        2 => array('title' => 'STATIC FREQUENCY TOUR & VISUALS', 'cat' => 'MUSIC VIDEO & AUDIO PRODUCTION', 'year' => '2026', 'client' => 'STATIC FREQUENCY', 'desc' => 'Music video direction, custom live tour visuals, and surround audio mastering for independent recording artist Static Frequency.'),
        3 => array('title' => 'MONOLITH AUDIO HARDWARE', 'cat' => 'BRAND IDENTITY & WEB DESIGN', 'year' => '2025', 'client' => 'MONOLITH LABS', 'desc' => 'Complete visual identity, custom typography, packaging design, and e-commerce web design for Monolith Labs.'),
        4 => array('title' => 'APEX MOTORSPORT IDENTITY', 'cat' => 'BRANDING & PHOTOGRAPHY', 'year' => '2025', 'client' => 'APEX RACING CO.', 'desc' => 'Custom brand identity system, team apparel graphics, and trackside photography for Apex Racing.'),
    );

    foreach ($default_projects as $idx => $proj) {
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_proj_{$idx}_title", 'mileym3dia_portfolio', sprintf(__('Project %d Title', 'm3-big-red'), $idx), $proj['title']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_proj_{$idx}_cat", 'mileym3dia_portfolio', sprintf(__('Project %d Category', 'm3-big-red'), $idx), $proj['cat']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_proj_{$idx}_year", 'mileym3dia_portfolio', sprintf(__('Project %d Year', 'm3-big-red'), $idx), $proj['year']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_proj_{$idx}_client", 'mileym3dia_portfolio', sprintf(__('Project %d Client', 'm3-big-red'), $idx), $proj['client']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_proj_{$idx}_desc", 'mileym3dia_portfolio', sprintf(__('Project %d Summary', 'm3-big-red'), $idx), $proj['desc'], 'textarea');
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_proj_{$idx}_url", 'mileym3dia_portfolio', sprintf(__('Project %d External Launch URL (Optional)', 'm3-big-red'), $idx), '', 'url');
        mileym3dia_add_customizer_image($wp_customize, "mileym3dia_proj_{$idx}_image", 'mileym3dia_portfolio', sprintf(__('Project %d Image', 'm3-big-red'), $idx), get_template_directory_uri() . "/assets/images/portfolio-{$idx}.jpg");
    }

    // ============================================
    // 6. SERVICES, PRICING TIERS & BUNDLE BUILDER
    // ============================================
    $wp_customize->add_section('mileym3dia_services', array(
        'title'       => __('6. Services, Pricing & Bundle Builder', 'm3-big-red'),
        'description' => __('Edit all 5 agency disciplines, the 3 pricing packages (including features & buttons), and the 8 a-la-carte bundle items.', 'm3-big-red'),
        'priority'    => 45,
    ));

    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_show_services', 'mileym3dia_services', __('Show Services Section on Homepage', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_show_pricing', 'mileym3dia_services', __('Show Pricing Section on Homepage', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_services_eyebrow', 'mileym3dia_services', __('Services Section Eyebrow', 'm3-big-red'), '03 / WHAT WE DO');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_services_title', 'mileym3dia_services', __('Services Big Headline', 'm3-big-red'), 'CORE CREATIVE SERVICES');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_services_hero_title', 'mileym3dia_services', __('Services Page Hero Title', 'm3-big-red'), 'SERVICES & CAPABILITIES');
    mileym3dia_add_customizer_image($wp_customize, 'mileym3dia_services_hero_image', 'mileym3dia_services', __('Services Page Hero Background Image', 'm3-big-red'), get_template_directory_uri() . '/assets/images/services-bg.jpg');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_services_description', 'mileym3dia_services', __('Services Section Description', 'm3-big-red'), 'Full-spectrum production for businesses, artists, and creators who want work that stands out.', 'textarea');

    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_pricing_eyebrow', 'mileym3dia_services', __('Pricing Section Eyebrow', 'm3-big-red'), '04 / TRANSPARENT INVESTMENT');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_pricing_teaser_eyebrow', 'mileym3dia_services', __('Homepage Pricing Teaser Eyebrow', 'm3-big-red'), '04 / TRANSPARENT INVESTMENT');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_pricing_teaser_title', 'mileym3dia_services', __('Homepage Pricing Teaser Headline', 'm3-big-red'), 'PACKAGES & CUSTOM BUNDLES');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_pricing_teaser_desc', 'mileym3dia_services', __('Homepage Pricing Teaser Description', 'm3-big-red'), 'No hidden fees. Choose a ready-to-shoot package or bundle 3+ services from $95 and automatically save 10%.', 'textarea');

    $default_services = array(
        1 => array('title' => 'Video Production', 'tag' => 'COMMERCIALS · MUSIC VIDEOS · REELS', 'desc' => 'Cinema-grade music videos, brand commercials, documentaries, aerial drone capture, and professional DaVinci Resolve color grading.', 'subtags' => 'Music Videos, Brand Films, Drone Capture, Color Grading'),
        2 => array('title' => 'Photography', 'tag' => 'EDITORIAL · PRODUCT · PRESS KITS', 'desc' => 'High-impact brand lookbooks, studio & on-location portraits, artist press photos, commercial product photography, and retouching.', 'subtags' => 'Lookbooks, Artist Press Kits, Product Stills, Event Coverage'),
        3 => array('title' => 'Branding & Graphic Design', 'tag' => 'IDENTITY · LOGOS · PACKAGING', 'desc' => 'Memorable logo systems, typography, brand guidelines, merch & apparel graphics, album artwork, and physical packaging.', 'subtags' => 'Logo Systems, Brand Guidelines, Apparel & Merch, Album Art'),
        4 => array('title' => 'Web Design & Development', 'tag' => 'CUSTOM SITES · E-COMMERCE · UI/UX', 'desc' => 'Fast, modern, custom-designed websites, artist & agency portfolios, landing pages, and WooCommerce / Shopify storefronts.', 'subtags' => 'Custom WordPress, E-Commerce, Responsive UI/UX, Landing Pages'),
        5 => array('title' => 'Music & Audio Production', 'tag' => 'RECORDING · MIXING · SOUND DESIGN', 'desc' => 'Original music production, custom scoring for film & commercials, vocal mixing, mastering, and clean audio post-production.', 'subtags' => 'Custom Scoring, Mixing & Mastering, Sound Design, Audio Post'),
    );

    foreach ($default_services as $idx => $srv) {
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_service_{$idx}_title", 'mileym3dia_services', sprintf(__('Service %d Title', 'm3-big-red'), $idx), $srv['title']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_service_{$idx}_tag", 'mileym3dia_services', sprintf(__('Service %d Subtitle Tag', 'm3-big-red'), $idx), $srv['tag']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_service_{$idx}_desc", 'mileym3dia_services', sprintf(__('Service %d Description', 'm3-big-red'), $idx), $srv['desc'], 'textarea');
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_service_{$idx}_subtags", 'mileym3dia_services', sprintf(__('Service %d Deliverables (comma-separated)', 'm3-big-red'), $idx), $srv['subtags']);
    }

    $default_tiers = array(
        1 => array(
            'badge'    => 'STARTER / SINGLE SERVICE',
            'title'    => 'SINGLE SHOOT OR DESIGN',
            'price'    => '350',
            'period'   => '/ project',
            'desc'     => 'Ideal for a single promo reel shoot, photo mini-session, custom logo, or single song mix & master.',
            'features' => "Half-Day 4K Camera Shoot or Studio Session\nOr Complete Custom Logo & Brand Mark Kit\nProfessional Color Grading or Studio Audio Mix\nFast 3-5 Business Day Turnaround\n2 Rounds of Client Revisions Included",
            'btn'      => 'BOOK STARTER PACKAGE',
        ),
        2 => array(
            'badge'    => 'MOST POPULAR',
            'title'    => 'CREATOR & BRAND LAUNCH',
            'price'    => '750',
            'period'   => '/ package',
            'desc'     => 'Complete rollout package including a 4K promo or music video shoot, lookbook photo session, social vertical edits, and custom cover/flyer art.',
            'features' => "Full-Day 4K Video Production (Music Video or Promo)\nPhotography Session (15 Retouched Lookbook/Press Stills)\n3 Vertical Cutdowns for Reels, TikTok & Shorts\nCustom Cover Art, Flyer, or Social Launch Kit\nDaVinci Resolve Color Grade & Clean Audio Master\nFull Commercial & Release Licensing",
            'btn'      => 'BOOK LAUNCH PACKAGE ↗',
        ),
        3 => array(
            'badge'    => 'ALL-IN-ONE STUDIO',
            'title'    => 'FULL PRODUCTION + WEB',
            'price'    => '1,450',
            'period'   => '/ package',
            'desc'     => 'End-to-end brand identity, custom website build, flagship video production, photography set, and studio audio.',
            'features' => "Complete Brand Identity, Logo Suite & Style Guide\nCustom Multi-Section Website or Online Storefront\nFlagship 4K Commercial or Music Video Production\nFull Editorial / Product Photography Set (25+ Stills)\nCustom Audio Score or Track Mix & Master",
            'btn'      => 'BOOK FULL PRODUCTION ↗',
        ),
    );

    foreach ($default_tiers as $idx => $tier) {
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_tier_{$idx}_badge", 'mileym3dia_services', sprintf(__('Pricing Tier %d Badge', 'm3-big-red'), $idx), $tier['badge']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_tier_{$idx}_title", 'mileym3dia_services', sprintf(__('Pricing Tier %d Title', 'm3-big-red'), $idx), $tier['title']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_tier_{$idx}_price", 'mileym3dia_services', sprintf(__('Pricing Tier %d Price', 'm3-big-red'), $idx), $tier['price']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_tier_{$idx}_period", 'mileym3dia_services', sprintf(__('Pricing Tier %d Billing Period', 'm3-big-red'), $idx), $tier['period']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_tier_{$idx}_desc", 'mileym3dia_services', sprintf(__('Pricing Tier %d Description', 'm3-big-red'), $idx), $tier['desc'], 'textarea');
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_tier_{$idx}_features", 'mileym3dia_services', sprintf(__('Pricing Tier %d Features (one per line)', 'm3-big-red'), $idx), $tier['features'], 'textarea');
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_tier_{$idx}_btn", 'mileym3dia_services', sprintf(__('Pricing Tier %d Button Text', 'm3-big-red'), $idx), $tier['btn']);
    }

    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_show_bundle_builder', 'mileym3dia_services', __('Show Interactive Bundle Builder', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_bundle_eyebrow', 'mileym3dia_services', __('Bundle Builder Eyebrow', 'm3-big-red'), 'CUSTOM BUNDLE BUILDER · MIX & MATCH');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_bundle_title', 'mileym3dia_services', __('Bundle Builder Headline', 'm3-big-red'), 'BUILD YOUR OWN BUNDLE');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_bundle_subtitle', 'mileym3dia_services', __('Bundle Builder Description', 'm3-big-red'), 'Need individual creative services? Select any combination of smaller services below to build your custom bundle—and automatically save 10% when you bundle 3 or more.', 'textarea');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_bundle_discount_pct', 'mileym3dia_services', __('3+ Item Bundle Discount (%)', 'm3-big-red'), 10, 'number', array('input_attrs' => array('min' => 0, 'max' => 50)));

    $default_bundle_items = array(
        1 => array('title' => 'Vertical Reels / Shorts Edit', 'price' => 95, 'cat' => 'VIDEO EDIT', 'desc' => 'High-retention vertical edit with captions, color grade, and sound design for Reels, TikTok, or Shorts.'),
        2 => array('title' => 'Flyer, Cover Art or Social Kit', 'price' => 125, 'cat' => 'DESIGN', 'desc' => 'Custom single/album cover art, event flyer, or matching social media graphics with print & digital files.'),
        3 => array('title' => 'Single Song Mix & Master', 'price' => 150, 'cat' => 'AUDIO', 'desc' => 'Studio vocal and stem mixing plus streaming-ready mastering for Spotify, Apple Music, and YouTube.'),
        4 => array('title' => 'Custom Logo & Brand Mark', 'price' => 195, 'cat' => 'BRANDING', 'desc' => 'Original vector logo design with primary, stacked, and icon variations plus color palette guide.'),
        5 => array('title' => 'Photography Mini-Session', 'price' => 225, 'cat' => 'PHOTO', 'desc' => '2-hour studio or on-location shoot for artist press photos, portraits, or products (10 retouched stills).'),
        6 => array('title' => 'Custom Beat or Audio Score', 'price' => 250, 'cat' => 'AUDIO', 'desc' => 'Original custom-produced instrumental or commercial soundtrack with tracked-out stems and commercial rights.'),
        7 => array('title' => '4K Promo or Music Video Shoot', 'price' => 350, 'cat' => 'VIDEO', 'desc' => 'Half-day 4K cinema camera shoot on location with professional lighting, full edit, and DaVinci color grade.'),
        8 => array('title' => 'Custom 1-Page Website / EPK', 'price' => 350, 'cat' => 'WEB', 'desc' => 'Fast, mobile-ready custom landing page, artist EPK, or booking site with contact form and domain setup.'),
    );

    foreach ($default_bundle_items as $idx => $bitem) {
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_bundle_{$idx}_title", 'mileym3dia_services', sprintf(__('Bundle Item %d Title', 'm3-big-red'), $idx), $bitem['title']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_bundle_{$idx}_price", 'mileym3dia_services', sprintf(__('Bundle Item %d Price ($)', 'm3-big-red'), $idx), $bitem['price'], 'number');
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_bundle_{$idx}_cat", 'mileym3dia_services', sprintf(__('Bundle Item %d Category Tag', 'm3-big-red'), $idx), $bitem['cat']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_bundle_{$idx}_desc", 'mileym3dia_services', sprintf(__('Bundle Item %d Description', 'm3-big-red'), $idx), $bitem['desc'], 'textarea');
    }

    // ============================================
    // 6B. STUDIO STORE & PRODUCTS (ITEMS 1-6)
    // ============================================
    $wp_customize->add_section('mileym3dia_store', array(
        'title'       => __('6B. Studio Store & Products', 'm3-big-red'),
        'description' => __('Edit Store header, homepage Store teaser, and all 6 Studio Store products (titles, prices, badges, photos, button text, and checkout/file URLs).', 'm3-big-red'),
        'priority'    => 47,
    ));

    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_show_store_home', 'mileym3dia_store', __('Show Studio Store Preview on Homepage', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_store_eyebrow', 'mileym3dia_store', __('Store Eyebrow Tag', 'm3-big-red'), 'STUDIO STORE // DIGITAL & PHYSICAL');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_store_title', 'mileym3dia_store', __('Store Headline', 'm3-big-red'), 'THE STUDIO STORE');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_store_subtitle', 'mileym3dia_store', __('Store Subtitle', 'm3-big-red'), 'Production-tested LUT packs, analog drum & stem libraries, brand lookbook kits, and limited studio gear. Edit products, prices, photos, and checkout links anytime in the Customizer.', 'textarea');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_store_checkout_btn', 'mileym3dia_store', __('Checkout Submit Button Text', 'm3-big-red'), 'COMPLETE STUDIO ORDER →');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_store_stripe_link', 'mileym3dia_store', __('Stripe Payment Link / Live Checkout URL (Optional)', 'm3-big-red'), '', 'url');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_store_paypal_link', 'mileym3dia_store', __('PayPal.me / PayPal Checkout URL (Optional)', 'm3-big-red'), '', 'url');

    if (function_exists('mileym3dia_get_default_store_products')) {
        foreach (mileym3dia_get_default_store_products() as $idx => $item) {
            $n = $idx + 1;
            mileym3dia_add_customizer_field($wp_customize, "mileym3dia_store_item_{$n}_title", 'mileym3dia_store', sprintf(__('Product %d Title', 'm3-big-red'), $n), $item['title']);
            mileym3dia_add_customizer_field($wp_customize, "mileym3dia_store_item_{$n}_price", 'mileym3dia_store', sprintf(__('Product %d Price', 'm3-big-red'), $n), $item['price']);
            mileym3dia_add_customizer_field($wp_customize, "mileym3dia_store_item_{$n}_category_slug", 'mileym3dia_store', sprintf(__('Product %d Category', 'm3-big-red'), $n), $item['category_slug'], 'select', array(
                'choices' => array(
                    'luts-video'       => 'LUTs & Video',
                    'audio-stems'      => 'Audio & Stems',
                    'templates-guides' => 'Templates & Guides',
                    'merch-passes'     => 'Merch & Passes',
                ),
            ));
            mileym3dia_add_customizer_field($wp_customize, "mileym3dia_store_item_{$n}_badge", 'mileym3dia_store', sprintf(__('Product %d Badge', 'm3-big-red'), $n), $item['badge']);
            mileym3dia_add_customizer_field($wp_customize, "mileym3dia_store_item_{$n}_format", 'mileym3dia_store', sprintf(__('Product %d Format Spec', 'm3-big-red'), $n), $item['format']);
            mileym3dia_add_customizer_field($wp_customize, "mileym3dia_store_item_{$n}_desc", 'mileym3dia_store', sprintf(__('Product %d Description', 'm3-big-red'), $n), $item['desc'], 'textarea');
            mileym3dia_add_customizer_field($wp_customize, "mileym3dia_store_item_{$n}_btn_text", 'mileym3dia_store', sprintf(__('Product %d Button Text', 'm3-big-red'), $n), $item['btn_text']);
            mileym3dia_add_customizer_field($wp_customize, "mileym3dia_store_item_{$n}_checkout_url", 'mileym3dia_store', sprintf(__('Product %d Direct Payment / Sample URL', 'm3-big-red'), $n), $item['checkout_url'], 'url');
            mileym3dia_add_customizer_image($wp_customize, "mileym3dia_store_item_{$n}_image", 'mileym3dia_store', sprintf(__('Product %d Image', 'm3-big-red'), $n), $item['image']);
        }
    }

    // ============================================
    // 7. BLOG, DOWNLOADABLE FILES & RESOURCES
    // ============================================
    $wp_customize->add_section('mileym3dia_blog_settings', array(
        'title'    => __('7. Blog, Resources & Download Files', 'm3-big-red'),
        'priority' => 50,
    ));

    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_resources_title', 'mileym3dia_blog_settings', __('Resources Section Title', 'm3-big-red'), 'CREATOR TOOLS & ASSETS');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_resources_subtitle', 'mileym3dia_blog_settings', __('Resources Page Subtitle', 'm3-big-red'), 'Production-tested color grading LUTs, studio audio guides, brand design templates, and production checklists created by our in-house team.', 'textarea');

    $default_files = array(
        1 => array('title' => '35MM CINEMA LUT PACK', 'desc' => 'Calibrated look LUTs for Sony S-Log3, RED Log3G10, and Blackmagic Film Gen 5. Designed for natural skin tones and rich film contrast.', 'file' => get_template_directory_uri() . '/assets/files/m3-35mm-cinema-lut-pack.cube', 'btn' => 'DOWNLOAD .CUBE PACK'),
        2 => array('title' => 'STUDIO AUDIO STEM & MIX GUIDE', 'desc' => '24-Bit / 48kHz broadcast WAV stem grouping, loudness targets (-14 LUFS), and file naming specs.', 'file' => get_template_directory_uri() . '/assets/files/m3-studio-audio-stem-guide.txt', 'btn' => 'DOWNLOAD AUDIO SPECS'),
        3 => array('title' => 'BRAND & LOOKBOOK LAYOUT KIT', 'desc' => '12-column Swiss brutalist grid system, typography scale guides, and print/web export specs.', 'file' => get_template_directory_uri() . '/assets/files/m3-brand-lookbook-layout-guide.txt', 'btn' => 'DOWNLOAD LAYOUT KIT'),
        4 => array('title' => 'VIDEO PRODUCTION CALL SHEET & CHECKLIST', 'desc' => 'Our complete pre-production call sheet, shot list template, and location lighting checklist.', 'file' => get_template_directory_uri() . '/assets/files/m3-production-call-sheet-checklist.txt', 'btn' => 'DOWNLOAD CALL SHEET'),
    );

    foreach ($default_files as $r => $rf) {
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_resource_{$r}_title", 'mileym3dia_blog_settings', sprintf(__('Resource Pack %d Title', 'm3-big-red'), $r), $rf['title']);
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_resource_{$r}_desc", 'mileym3dia_blog_settings', sprintf(__('Resource Pack %d Description', 'm3-big-red'), $r), $rf['desc'], 'textarea');
        mileym3dia_add_customizer_field($wp_customize, "mileym3dia_resource_{$r}_btn", 'mileym3dia_blog_settings', sprintf(__('Resource Pack %d Button Label', 'm3-big-red'), $r), $rf['btn']);
        mileym3dia_add_customizer_file($wp_customize, "mileym3dia_resource_{$r}_file", 'mileym3dia_blog_settings', sprintf(__('Resource Pack %d Downloadable File', 'm3-big-red'), $r), $rf['file']);
    }

    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_show_blog', 'mileym3dia_blog_settings', __('Show Latest Articles on Homepage', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_blog_section_eyebrow', 'mileym3dia_blog_settings', __('Homepage Blog Eyebrow', 'm3-big-red'), '05 / STUDIO JOURNAL');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_blog_section_title', 'mileym3dia_blog_settings', __('Homepage Blog Headline', 'm3-big-red'), 'LATEST INSIGHTS & BEHIND THE SCENES');
    mileym3dia_add_customizer_image($wp_customize, 'mileym3dia_blog_1_image', 'mileym3dia_blog_settings', __('Default Blog Image 1 (Fallback)', 'm3-big-red'), get_template_directory_uri() . '/assets/images/blog-1.jpg');
    mileym3dia_add_customizer_image($wp_customize, 'mileym3dia_blog_2_image', 'mileym3dia_blog_settings', __('Default Blog Image 2 (Fallback)', 'm3-big-red'), get_template_directory_uri() . '/assets/images/blog-2.jpg');
    mileym3dia_add_customizer_image($wp_customize, 'mileym3dia_blog_3_image', 'mileym3dia_blog_settings', __('Default Blog Image 3 (Fallback)', 'm3-big-red'), get_template_directory_uri() . '/assets/images/blog-3.jpg');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_blog_sidebar', 'mileym3dia_blog_settings', __('Enable Blog Sidebar', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_blog_sidebar_pos', 'mileym3dia_blog_settings', __('Sidebar Position', 'm3-big-red'), 'right', 'select', array(
        'choices' => array('right' => __('Right', 'm3-big-red'), 'left' => __('Left', 'm3-big-red')),
    ));
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_blog_show_categories', 'mileym3dia_blog_settings', __('Show Category Badges', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_blog_show_date', 'mileym3dia_blog_settings', __('Show Publication Date', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_blog_show_author', 'mileym3dia_blog_settings', __('Show Post Author', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_blog_show_related', 'mileym3dia_blog_settings', __('Show Related Posts on Single Post', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_blog_related_count', 'mileym3dia_blog_settings', __('Number of Related Posts', 'm3-big-red'), 3, 'number', array('input_attrs' => array('min' => 1, 'max' => 6)));
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_blog_excerpt_length', 'mileym3dia_blog_settings', __('Excerpt Word Count', 'm3-big-red'), 24, 'number', array('input_attrs' => array('min' => 10, 'max' => 60)));
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_blog_read_more_text', 'mileym3dia_blog_settings', __('Read Article Link Label', 'm3-big-red'), 'READ ARTICLE');

    // ============================================
    // 7B. REGISTRATION & CREATOR HUB
    // ============================================
    $wp_customize->add_section('mileym3dia_creator_hub', array(
        'title'       => __('7B. Registration & Creator Hub', 'm3-big-red'),
        'description' => __('Customize the Client & Creator Registration / Sign-In portal and member vault headings.', 'm3-big-red'),
        'priority'    => 52,
    ));

    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hub_eyebrow', 'mileym3dia_creator_hub', __('Creator Hub Eyebrow', 'm3-big-red'), 'CLIENT & CREATOR PORTAL');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hub_subtitle', 'mileym3dia_creator_hub', __('Creator Hub Lead Text', 'm3-big-red'), 'Register your client or creator account, sign in to review private project deliverables, and download studio production assets.', 'textarea');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hub_register_heading', 'mileym3dia_creator_hub', __('Registration Tab Heading', 'm3-big-red'), 'CREATE STUDIO ACCOUNT');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hub_register_btn', 'mileym3dia_creator_hub', __('Registration Submit Button', 'm3-big-red'), 'REGISTER ACCOUNT →');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hub_login_heading', 'mileym3dia_creator_hub', __('Sign-In Tab Heading', 'm3-big-red'), 'CLIENT & MEMBER SIGN IN');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_hub_login_btn', 'mileym3dia_creator_hub', __('Sign-In Submit Button', 'm3-big-red'), 'SIGN IN TO PORTAL →');

    // ============================================
    // 8. CONTACT, SOCIALS & FOOTER
    // ============================================
    $wp_customize->add_section('mileym3dia_contact', array(
        'title'    => __('8. Contact, Socials & Footer', 'm3-big-red'),
        'priority' => 55,
    ));

    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_show_contact_cta', 'mileym3dia_contact', __('Show Contact CTA Banner on Homepage', 'm3-big-red'), true, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_contact_eyebrow', 'mileym3dia_contact', __('Contact CTA Eyebrow', 'm3-big-red'), 'READY WHEN YOU ARE');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_contact_cta', 'mileym3dia_contact', __('Contact CTA Big Heading', 'm3-big-red'), "LET'S BUILD YOUR NEXT PROJECT.");
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_contact_subhead', 'mileym3dia_contact', __('Contact CTA Subheading', 'm3-big-red'), 'Tell us about your upcoming video shoot, photography session, brand identity, website, or audio project. We respond to all inquiries within 24 hours.', 'textarea');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_contact_email', 'mileym3dia_contact', __('Studio Contact Email', 'm3-big-red'), 'hello@mileym3dia.com', 'email');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_contact_phone', 'mileym3dia_contact', __('Studio Phone (Optional)', 'm3-big-red'), '');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_contact_location', 'mileym3dia_contact', __('Studio Location', 'm3-big-red'), 'ORLANDO, FL · AVAILABLE WORLDWIDE');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_contact_availability', 'mileym3dia_contact', __('Booking Status Label', 'm3-big-red'), 'NOW BOOKING NEW PROJECTS');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_footer_description', 'mileym3dia_contact', __('Footer Studio Description', 'm3-big-red'), 'Full-service creative media agency specializing in video production, photography, branding, web design, and music/audio production.', 'textarea');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_show_footer_widgets', 'mileym3dia_contact', __('Show Optional Footer Widget Columns (Off by default to prevent accidental WP Archives/Meta widgets)', 'm3-big-red'), false, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_footer_copyright', 'mileym3dia_contact', __('Footer Copyright Text', 'm3-big-red'), '&copy; ' . date('Y') . ' MILEYM3DIA. All rights reserved.', 'textarea');

    $social_platforms = array(
        'instagram' => __('Instagram URL', 'm3-big-red'),
        'youtube'   => __('YouTube URL', 'm3-big-red'),
        'twitter'   => __('X / Twitter URL', 'm3-big-red'),
        'tiktok'    => __('TikTok URL', 'm3-big-red'),
        'vimeo'     => __('Vimeo URL', 'm3-big-red'),
        'behance'   => __('Behance URL', 'm3-big-red'),
        'dribbble'  => __('Dribbble URL', 'm3-big-red'),
        'linkedin'  => __('LinkedIn URL', 'm3-big-red'),
        'facebook'  => __('Facebook URL', 'm3-big-red'),
    );
    foreach ($social_platforms as $platform => $label) {
        mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_social_' . $platform, 'mileym3dia_contact', $label, '', 'url');
    }

    // ============================================
    // 8B. TRANSACTIONAL EMAIL (SMTP) & LEGAL
    // ============================================
    $wp_customize->add_section('mileym3dia_smtp_legal', array(
        'title'       => __('8B. Transactional Email (SMTP) & Legal', 'm3-big-red'),
        'description' => __('Configure reliable SMTP delivery for registration welcome emails & store invoices (or leave disabled to use WP Mail SMTP plugin), plus Privacy & Terms page details.', 'm3-big-red'),
        'priority'    => 58,
    ));

    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_smtp_enabled', 'mileym3dia_smtp_legal', __('Enable Built-In Theme SMTP Relay', 'm3-big-red'), false, 'checkbox');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_smtp_from_name', 'mileym3dia_smtp_legal', __('Sender Name', 'm3-big-red'), 'MILEYM3DIA Studio');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_smtp_from_email', 'mileym3dia_smtp_legal', __('Sender Email Address', 'm3-big-red'), 'hello@mileym3dia.com', 'email');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_smtp_host', 'mileym3dia_smtp_legal', __('SMTP Host (e.g. smtp.gmail.com / smtp.resend.com)', 'm3-big-red'), '');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_smtp_port', 'mileym3dia_smtp_legal', __('SMTP Port (587 TLS / 465 SSL)', 'm3-big-red'), 587, 'number');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_smtp_encryption', 'mileym3dia_smtp_legal', __('SMTP Encryption', 'm3-big-red'), 'tls', 'select', array(
        'choices' => array('tls' => 'TLS (Recommended)', 'ssl' => 'SSL', '' => 'None'),
    ));
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_smtp_username', 'mileym3dia_smtp_legal', __('SMTP Username', 'm3-big-red'), '');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_smtp_password', 'mileym3dia_smtp_legal', __('SMTP Password / App Key', 'm3-big-red'), '', 'password');

    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_legal_entity', 'mileym3dia_smtp_legal', __('Legal Studio / Company Name', 'm3-big-red'), 'MILEYM3DIA');
    mileym3dia_add_customizer_field($wp_customize, 'mileym3dia_legal_updated', 'mileym3dia_smtp_legal', __('Privacy & Terms Last Updated Date', 'm3-big-red'), 'November 2026');
}
add_action('customize_register', 'mileym3dia_customize_register');

function mileym3dia_customizer_preview_js() {
    wp_enqueue_script(
        'mileym3dia-customizer',
        get_template_directory_uri() . '/js/customizer.js',
        array('customize-preview'),
        MILEYM3DIA_VERSION,
        true
    );
}
add_action('customize_preview_init', 'mileym3dia_customizer_preview_js');

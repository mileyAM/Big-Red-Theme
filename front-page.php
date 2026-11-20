<?php
/**
 * Front Page Template
 * Full-width Hero, Side-to-Side Split Sections, Big Typography & Full Customizer Control.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Hero Customizer Values
$hero_bg = get_theme_mod('mileym3dia_hero_slide1_image');
if (empty($hero_bg)) {
    $hero_bg = get_template_directory_uri() . '/assets/images/sections/hero-composite-hd.jpg';
}
$hero_eyebrow     = get_theme_mod('mileym3dia_hero_eyebrow', 'FULL-SERVICE CREATIVE MEDIA AGENCY');
$hero_line_1      = get_theme_mod('mileym3dia_hero_headline_1', 'WE CREATE');
$hero_line_2      = get_theme_mod('mileym3dia_hero_headline_2', 'VISUALS THAT');
$hero_line_3      = get_theme_mod('mileym3dia_hero_headline_3', 'HIT DIFFERENT.');
$hero_disciplines = get_theme_mod('mileym3dia_hero_disciplines', 'VIDEO PRODUCTION · PHOTOGRAPHY · BRANDING · WEB DESIGN · MUSIC & AUDIO');
$hero_desc        = get_theme_mod('mileym3dia_hero_description', 'We partner with ambitious brands, recording artists, and businesses to produce cinema-grade video, editorial photography, standout brand identities, custom websites, and studio audio.');
$cta_primary_text = get_theme_mod('mileym3dia_hero_cta_primary', 'START A PROJECT');
$cta_primary_url  = get_theme_mod('mileym3dia_hero_cta_primary_url', mileym3dia_get_page_url('contact'));
$cta_sec_text     = get_theme_mod('mileym3dia_hero_cta_secondary', 'VIEW OUR WORK');
$cta_sec_url      = get_theme_mod('mileym3dia_hero_cta_secondary_url', mileym3dia_get_work_page_url());
?>

<main id="primary" class="site-main">

    <!-- 1. FULL-WIDTH EDGE-TO-EDGE HERO SECTION -->
    <section class="hero hero--fullbleed" id="hero">
        <div class="hero-fullbleed-media" style="background-image: url('<?php echo esc_url($hero_bg); ?>');"></div>
        <div class="hero-fullbleed-overlay"></div>

        <div class="container hero-fullbleed-container">
            <div class="hero-fullbleed-content">
                <?php if (!empty($hero_eyebrow)) : ?>
                    <div class="hero-welcome-badge">
                        <span class="welcome-bar"></span>
                        <span class="welcome-text"><?php echo esc_html($hero_eyebrow); ?></span>
                    </div>
                <?php endif; ?>

                <h1 class="hero-oversized-headline">
                    <?php if (!empty($hero_line_1)) : ?>
                        <span class="hero-line line--white"><?php echo esc_html($hero_line_1); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($hero_line_2)) : ?>
                        <span class="hero-line line--accent"><?php echo esc_html($hero_line_2); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($hero_line_3)) : ?>
                        <span class="hero-line line--white"><?php echo esc_html($hero_line_3); ?></span>
                    <?php endif; ?>
                </h1>

                <?php if (!empty($hero_disciplines)) : ?>
                    <p class="hero-disciplines-tagline"><?php echo esc_html($hero_disciplines); ?></p>
                <?php endif; ?>

                <?php if (!empty($hero_desc)) : ?>
                    <p class="hero-lead-description"><?php echo esc_html($hero_desc); ?></p>
                <?php endif; ?>

                <div class="hero-action-buttons">
                    <?php if (!empty($cta_primary_text)) : ?>
                        <a href="<?php echo esc_url($cta_primary_url); ?>" class="btn btn--streetwear-red">
                            <span class="btn-text"><?php echo esc_html($cta_primary_text); ?></span>
                            <span class="btn-arrow">↗</span>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($cta_sec_text)) : ?>
                        <a href="<?php echo esc_url($cta_sec_url); ?>" class="btn btn--streetwear-outline">
                            <span class="btn-text"><?php echo esc_html($cta_sec_text); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUCTION GEAR & SOFTWARE BAR -->
    <?php if (get_theme_mod('mileym3dia_show_trust_bar', true)) : ?>
        <?php
        $trust_raw   = get_theme_mod('mileym3dia_trust_bar_items', 'RED DIGITAL CINEMA, SONY CINEMA LINE, CANON, BLACKMAGIC DESIGN, DJI PRO, DAVINCI RESOLVE, ADOBE CREATIVE CLOUD, LOGIC PRO');
        $trust_items = array_filter(array_map('trim', explode(',', $trust_raw)));
        ?>
        <?php if (!empty($trust_items)) : ?>
            <section class="gear-trust-bar" id="gearTrust">
                <div class="container trust-bar-inner">
                    <div class="trust-brands-track">
                        <?php foreach ($trust_items as $i => $item) : ?>
                            <?php if ($i > 0) : ?>
                                <span class="trust-brand-sep">•</span>
                            <?php endif; ?>
                            <span class="trust-brand-name"><?php echo esc_html($item); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>

    <!-- OFFICIAL MILEYM3DIA BRAND SHOWCASE BANNER (CREATE / CAPTURE / ELEVATE) -->
    <?php
    if (function_exists('mileym3dia_render_page_banner')) {
        mileym3dia_render_page_banner('home', array(
            'heading_tag'     => 'h2',
            'show_action_bar' => false,
            'section_class'   => 'm3-home-brand-showcase',
        ));
    }
    ?>

    <!-- OPTIONAL WORDPRESS EDITOR CONTENT (WHEN STATIC PAGE IS USED) -->
    <?php if (is_page()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php if (trim(get_the_content())) : ?>
                <section class="section-loose page-editor-content bg-shade-base">
                    <div class="container">
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>

    <?php
    // Define sortable homepage sections controlled by Customizer → 2B. Homepage Section Order & Visibility
    $m3_home_sections = array();

    if (get_theme_mod('mileym3dia_show_brand_statement', true)) {
        $m3_home_sections['about'] = array(
            'order' => (int) get_theme_mod('mileym3dia_section_order_about', 10),
            'render' => function () {
                $about_img = get_theme_mod('mileym3dia_about_image');
                if (empty($about_img)) {
                    $about_img = mileym3dia_asset_image_url('about-image.jpg');
                }
                $about_stat1_num   = get_theme_mod('mileym3dia_about_stat1_num', '4K / 8K');
                $about_stat1_label = get_theme_mod('mileym3dia_about_stat1_label', 'CINEMA CAMERA PRODUCTION');
                $about_stat2_num   = get_theme_mod('mileym3dia_about_stat2_num', '5 CORE');
                $about_stat2_label = get_theme_mod('mileym3dia_about_stat2_label', 'IN-HOUSE DISCIPLINES');
                $about_stat3_num   = get_theme_mod('mileym3dia_about_stat3_num', '100%');
                $about_stat3_label = get_theme_mod('mileym3dia_about_stat3_label', 'CUSTOM STRATEGY & EXECUTION');
                ?>
                <section class="studio-bento-section bg-shade-elevated" id="about">
                    <div class="container container--wide">
                        <div class="studio-bento-grid">
                            <div class="studio-manifesto-col">
                                <div class="studio-manifesto-header">
                                    <span class="section-label text-yellow studio-eyebrow"><?php echo esc_html(get_theme_mod('mileym3dia_about_eyebrow', '01 / WHO WE ARE & HOW WE WORK')); ?></span>
                                    <h2 class="studio-big-title">
                                        <?php echo esc_html(get_theme_mod('mileym3dia_about_title', 'CREATIVE PRODUCTION WITHOUT COMPROMISE.')); ?>
                                    </h2>
                                    <p class="studio-lead-text">
                                        <?php echo esc_html(get_theme_mod('mileym3dia_about_content', 'MILEYM3DIA is a full-service creative production agency uniting directors, photographers, brand designers, web developers, and audio engineers under one roof.')); ?>
                                    </p>
                                </div>

                                <div class="studio-pillars-grid">
                                    <div class="pillar-card pillar-card--yellow">
                                        <div class="pillar-top">
                                            <span class="pillar-badge text-yellow">01</span>
                                            <h4 class="pillar-title"><?php echo esc_html(get_theme_mod('mileym3dia_pillar_1_title', 'CINEMA-GRADE EQUIPMENT')); ?></h4>
                                        </div>
                                        <p class="pillar-desc"><?php echo esc_html(get_theme_mod('mileym3dia_pillar_1_desc', 'Shot on RED, Sony FX, and Blackmagic cinema cameras with pro lighting & audio.')); ?></p>
                                    </div>
                                    <div class="pillar-card pillar-card--lime">
                                        <div class="pillar-top">
                                            <span class="pillar-badge text-lime">02</span>
                                            <h4 class="pillar-title"><?php echo esc_html(get_theme_mod('mileym3dia_pillar_2_title', 'INTEGRATED BRAND & WEB')); ?></h4>
                                        </div>
                                        <p class="pillar-desc"><?php echo esc_html(get_theme_mod('mileym3dia_pillar_2_desc', 'Visual identity, graphic design, and custom web builds that match your media.')); ?></p>
                                    </div>
                                    <div class="pillar-card pillar-card--blue">
                                        <div class="pillar-top">
                                            <span class="pillar-badge text-blue">03</span>
                                            <h4 class="pillar-title"><?php echo esc_html(get_theme_mod('mileym3dia_pillar_3_title', 'FAST 7–14 DAY DELIVERY')); ?></h4>
                                        </div>
                                        <p class="pillar-desc"><?php echo esc_html(get_theme_mod('mileym3dia_pillar_3_desc', 'Clear milestones, direct communication, and on-time final masters.')); ?></p>
                                    </div>
                                    <div class="pillar-card pillar-card--red">
                                        <div class="pillar-top">
                                            <span class="pillar-badge text-red">04</span>
                                            <h4 class="pillar-title"><?php echo esc_html(get_theme_mod('mileym3dia_pillar_4_title', 'FULL COMMERCIAL RIGHTS')); ?></h4>
                                        </div>
                                        <p class="pillar-desc"><?php echo esc_html(get_theme_mod('mileym3dia_pillar_4_desc', 'Every package includes complete commercial licensing for your brand or release.')); ?></p>
                                    </div>
                                </div>

                                <?php
                                $studio_cta1_text = get_theme_mod('mileym3dia_about_cta_1_text', 'MORE ABOUT THE STUDIO');
                                $studio_cta1_url  = get_theme_mod('mileym3dia_about_cta_1_url', mileym3dia_get_page_url('about'));
                                if (empty($studio_cta1_url) || '/about/' === $studio_cta1_url) {
                                    $studio_cta1_url = mileym3dia_get_page_url('about');
                                }
                                $studio_cta2_text = get_theme_mod('mileym3dia_about_cta_2_text', 'BOOK A CONSULTATION');
                                $studio_cta2_url  = get_theme_mod('mileym3dia_about_cta_2_url', mileym3dia_get_page_url('contact'));
                                if (empty($studio_cta2_url) || '/contact/' === $studio_cta2_url) {
                                    $studio_cta2_url = mileym3dia_get_page_url('contact');
                                }
                                ?>
                                <div class="studio-actions">
                                    <a href="<?php echo esc_url($studio_cta1_url); ?>" class="btn btn--accent-yellow">
                                        <span class="btn-text"><?php echo esc_html($studio_cta1_text); ?></span>
                                        <span class="btn-arrow">↗</span>
                                    </a>
                                    <a href="<?php echo esc_url($studio_cta2_url); ?>" class="btn btn--streetwear-outline">
                                        <span class="btn-text"><?php echo esc_html($studio_cta2_text); ?></span>
                                    </a>
                                </div>
                            </div>

                            <div class="studio-media-col">
                                <div class="studio-media-visual">
                                    <img src="<?php echo esc_url($about_img); ?>" alt="<?php echo esc_attr(get_theme_mod('mileym3dia_about_title', 'About MILEYM3DIA')); ?>" class="studio-media-img" loading="lazy" />
                                    <div class="studio-media-overlay"></div>
                                    <div class="studio-telemetry-badge">
                                        <span class="telemetry-dot"></span>
                                        <span class="telemetry-text text-mono"><?php echo esc_html(get_theme_mod('mileym3dia_contact_location', 'ORLANDO, FL · WORLDWIDE BOOKINGS')); ?></span>
                                    </div>
                                </div>

                                <div class="studio-stats-dock">
                                    <div class="studio-stat-cell">
                                        <span class="studio-stat-val text-yellow"><?php echo esc_html($about_stat1_num); ?></span>
                                        <span class="studio-stat-label"><?php echo esc_html($about_stat1_label); ?></span>
                                    </div>
                                    <div class="studio-stat-cell">
                                        <span class="studio-stat-val text-lime"><?php echo esc_html($about_stat2_num); ?></span>
                                        <span class="studio-stat-label"><?php echo esc_html($about_stat2_label); ?></span>
                                    </div>
                                    <div class="studio-stat-cell">
                                        <span class="studio-stat-val text-blue"><?php echo esc_html($about_stat3_num); ?></span>
                                        <span class="studio-stat-label"><?php echo esc_html($about_stat3_label); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php
            },
        );
    }

    if (get_theme_mod('mileym3dia_show_selected_work', true)) {
        $m3_home_sections['work'] = array(
            'order' => (int) get_theme_mod('mileym3dia_section_order_work', 20),
            'render' => function () {
                $fallback_defaults = array(
                    1 => array('slug' => 'nightfall-apparel-campaign', 'title' => 'NIGHTFALL APPAREL CAMPAIGN', 'cat' => 'VIDEO PRODUCTION & LOOKBOOK', 'year' => '2026', 'client' => 'NIGHTFALL ATELIER', 'desc' => 'Full commercial video production, street lookbook photography, and social campaign rollout for Nightfall Atelier.', 'accent' => 'red'),
                    2 => array('slug' => 'static-frequency-tour-visuals', 'title' => 'STATIC FREQUENCY TOUR & VISUALS', 'cat' => 'MUSIC VIDEO & AUDIO PRODUCTION', 'year' => '2026', 'client' => 'STATIC FREQUENCY', 'desc' => 'Music video direction, custom live tour visuals, and surround audio mastering for independent recording artist Static Frequency.', 'accent' => 'yellow'),
                    3 => array('slug' => 'monolith-audio-hardware', 'title' => 'MONOLITH AUDIO HARDWARE', 'cat' => 'BRAND IDENTITY & WEB DESIGN', 'year' => '2025', 'client' => 'MONOLITH LABS', 'desc' => 'Complete visual identity, custom typography, packaging design, and e-commerce web design for Monolith Labs.', 'accent' => 'lime'),
                    4 => array('slug' => 'apex-motorsport-identity', 'title' => 'APEX MOTORSPORT IDENTITY', 'cat' => 'BRANDING & PHOTOGRAPHY', 'year' => '2025', 'client' => 'APEX RACING CO.', 'desc' => 'Custom brand identity system, team apparel graphics, and trackside photography for Apex Racing.', 'accent' => 'blue'),
                );

                $accent_map = array(
                    'video-production' => 'red',
                    'video'            => 'red',
                    'photography'      => 'blue',
                    'photo'            => 'blue',
                    'branding-design'  => 'lime',
                    'branding'         => 'lime',
                    'web-design'       => 'yellow',
                    'web'              => 'yellow',
                    'music-audio'      => 'yellow',
                    'audio'            => 'yellow',
                );
                $accent_cycle = array('red', 'yellow', 'lime', 'blue');

                $project_items = array();
                $count_limit   = max(1, (int) get_theme_mod('mileym3dia_portfolio_count', 4));

                if (mileym3dia_has_projects() && class_exists('WP_Query')) {
                    $work_query = new WP_Query(array(
                        'post_type'      => 'project',
                        'posts_per_page' => $count_limit,
                        'post_status'    => 'publish',
                        'orderby'        => array('menu_order' => 'ASC', 'ID' => 'ASC'),
                    ));

                    if ($work_query && !empty($work_query->posts)) {
                        $slot = 1;
                        foreach ($work_query->posts as $p_post) {
                            $pid   = (int) $p_post->ID;
                            $def   = isset($fallback_defaults[$slot]) ? $fallback_defaults[$slot] : $fallback_defaults[1];
                            $terms = taxonomy_exists('project_category') ? get_the_terms($pid, 'project_category') : array();

                            $cat_names = array();
                            $first_slug = '';
                            if ($terms && !is_wp_error($terms)) {
                                foreach ($terms as $t) {
                                    $cat_names[] = strtoupper($t->name);
                                    if ('' === $first_slug) {
                                        $first_slug = $t->slug;
                                    }
                                }
                            }
                            $cat_display = !empty($cat_names) ? implode(' & ', array_slice($cat_names, 0, 2)) : $def['cat'];

                            $custom_accent = get_post_meta($pid, '_project_accent', true);
                            if (!empty($custom_accent)) {
                                $accent = $custom_accent;
                            } elseif ($first_slug && isset($accent_map[$first_slug])) {
                                $accent = $accent_map[$first_slug];
                            } else {
                                $accent = $accent_cycle[($slot - 1) % 4];
                            }

                            $title  = $p_post->post_title ?: $def['title'];
                            $year   = get_post_meta($pid, '_project_year', true) ?: $def['year'];
                            $client = get_post_meta($pid, '_project_client', true) ?: $def['client'];
                            $desc   = $p_post->post_excerpt ?: (wp_trim_words(strip_tags($p_post->post_content), 22) ?: $def['desc']);
                            $img    = (function_exists('has_post_thumbnail') && has_post_thumbnail($pid))
                                ? get_the_post_thumbnail_url($pid, 'mileym3dia-large')
                                : mileym3dia_get_project_image_url($slot);
                            $link   = get_permalink($pid);

                            // Honor non-default Customizer overrides for slots 1-4
                            if ($slot <= 4) {
                                $mod_title = get_theme_mod("mileym3dia_proj_{$slot}_title", $def['title']);
                                if (!empty($mod_title) && $mod_title !== $def['title']) {
                                    $title = $mod_title;
                                }
                                $mod_cat = get_theme_mod("mileym3dia_proj_{$slot}_cat", $def['cat']);
                                if (!empty($mod_cat) && $mod_cat !== $def['cat']) {
                                    $cat_display = $mod_cat;
                                }
                                $mod_year = get_theme_mod("mileym3dia_proj_{$slot}_year", $def['year']);
                                if (!empty($mod_year) && $mod_year !== $def['year']) {
                                    $year = $mod_year;
                                }
                                $mod_client = get_theme_mod("mileym3dia_proj_{$slot}_client", $def['client']);
                                if (!empty($mod_client) && $mod_client !== $def['client']) {
                                    $client = $mod_client;
                                }
                                $mod_desc = get_theme_mod("mileym3dia_proj_{$slot}_desc", $def['desc']);
                                if (!empty($mod_desc) && $mod_desc !== $def['desc']) {
                                    $desc = $mod_desc;
                                }
                            }

                            $project_items[] = array(
                                'title'  => $title,
                                'cat'    => $cat_display,
                                'year'   => $year,
                                'client' => $client,
                                'desc'   => $desc,
                                'img'    => $img,
                                'link'   => $link,
                                'accent' => $accent,
                            );
                            $slot++;
                        }
                    }
                }

                if (empty($project_items)) {
                    foreach ($fallback_defaults as $idx => $item) {
                        $project_items[] = array(
                            'title'  => get_theme_mod("mileym3dia_proj_{$idx}_title", $item['title']),
                            'cat'    => get_theme_mod("mileym3dia_proj_{$idx}_cat", $item['cat']),
                            'year'   => get_theme_mod("mileym3dia_proj_{$idx}_year", $item['year']),
                            'client' => get_theme_mod("mileym3dia_proj_{$idx}_client", $item['client']),
                            'desc'   => get_theme_mod("mileym3dia_proj_{$idx}_desc", $item['desc']),
                            'img'    => mileym3dia_get_project_image_url($idx),
                            'link'   => mileym3dia_get_project_url($item['slug']),
                            'accent' => $item['accent'],
                        );
                    }
                }

                $premier    = array_shift($project_items);
                $companions = $project_items;
                ?>
                <section class="work-section section-loose bg-shade-base" id="work">
                    <div class="container container--wide">
                        <div class="section-header">
                            <div class="section-header-left">
                                <span class="section-label text-red"><?php echo esc_html(get_theme_mod('mileym3dia_portfolio_eyebrow', '02 / SELECTED WORK')); ?></span>
                                <h2 class="section-title section-title--xl"><?php echo esc_html(get_theme_mod('mileym3dia_portfolio_title', 'FEATURED PRODUCTIONS')); ?></h2>
                            </div>
                            <div class="section-header-right">
                                <p class="section-header-desc">
                                    <?php echo esc_html(get_theme_mod('mileym3dia_portfolio_desc', 'Recent commercial films, music videos, brand identity systems, web builds, and photography campaigns.')); ?>
                                </p>
                                <a href="<?php echo esc_url(mileym3dia_get_work_page_url()); ?>" class="text-link-arrow">
                                    <span><?php esc_html_e('VIEW FULL PORTFOLIO', 'm3-big-red'); ?></span>
                                    <span class="link-arrow">↗</span>
                                </a>
                            </div>
                        </div>

                        <div class="work-showcase-editorial">
                            <?php if ($premier) : ?>
                                <article class="work-premier-card">
                                    <div class="work-premier-media">
                                        <img src="<?php echo esc_url($premier['img']); ?>" alt="<?php echo esc_attr($premier['title']); ?>" class="work-premier-img" loading="lazy" />
                                        <div class="work-card-overlay"></div>
                                        <span class="work-premier-tag text-mono"><?php echo esc_html($premier['year']); ?></span>
                                    </div>
                                    <div class="work-premier-content">
                                        <div class="work-premier-meta-top">
                                            <div class="work-premier-top">
                                                <span class="work-premier-badge text-mono">FEATURED PREMIERE</span>
                                                <span class="work-premier-cat text-mono text-<?php echo esc_attr($premier['accent']); ?>"><?php echo esc_html($premier['cat']); ?></span>
                                            </div>
                                            <h3 class="work-premier-title"><?php echo esc_html($premier['title']); ?></h3>
                                            <p class="work-premier-desc"><?php echo esc_html($premier['desc']); ?></p>
                                        </div>
                                        <div class="work-premier-footer">
                                            <a href="<?php echo esc_url($premier['link']); ?>" class="work-premier-cta">
                                                <span><?php esc_html_e('EXPLORE FULL CASE STUDY', 'm3-big-red'); ?></span>
                                                <span class="arrow">↗</span>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            <?php endif; ?>

                            <?php if (!empty($companions)) : ?>
                                <div class="work-companion-grid">
                                    <?php foreach ($companions as $c_item) : ?>
                                        <article class="work-companion-card work-companion-card--<?php echo esc_attr($c_item['accent']); ?>">
                                            <div class="work-companion-media">
                                                <img src="<?php echo esc_url($c_item['img']); ?>" alt="<?php echo esc_attr($c_item['title']); ?>" class="work-companion-img" loading="lazy" />
                                                <span class="work-companion-year"><?php echo esc_html($c_item['year']); ?></span>
                                            </div>
                                            <div class="work-companion-body">
                                                <div class="work-companion-meta">
                                                    <span class="text-mono text-<?php echo esc_attr($c_item['accent']); ?>"><?php echo esc_html($c_item['cat']); ?></span>
                                                </div>
                                                <h3 class="work-companion-title"><?php echo esc_html($c_item['title']); ?></h3>
                                                <p class="work-companion-desc"><?php echo esc_html($c_item['desc']); ?></p>
                                                <a href="<?php echo esc_url($c_item['link']); ?>" class="work-companion-link">
                                                    <span><?php esc_html_e('VIEW PROJECT', 'm3-big-red'); ?></span>
                                                    <span class="arrow">↗</span>
                                                </a>
                                            </div>
                                        </article>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
                <?php
            },
        );
    }

    if (get_theme_mod('mileym3dia_show_services', true)) {
        $m3_home_sections['services'] = array(
            'order' => (int) get_theme_mod('mileym3dia_section_order_services', 30),
            'render' => function () {
                $services_list = function_exists('mileym3dia_get_services') ? mileym3dia_get_services() : array();
                ?>
                <section class="disciplines-section section-loose bg-shade-elevated" id="services">
                    <div class="container container--wide">
                        <div class="section-header">
                            <div class="section-header-left">
                                <span class="section-label text-lime"><?php echo esc_html(get_theme_mod('mileym3dia_services_eyebrow', '03 / WHAT WE DO')); ?></span>
                                <h2 class="section-title section-title--xl"><?php echo esc_html(get_theme_mod('mileym3dia_services_title', 'CORE CREATIVE SERVICES')); ?></h2>
                            </div>
                            <div class="section-header-right">
                                <p class="section-header-desc">
                                    <?php echo esc_html(get_theme_mod('mileym3dia_services_description', 'Full-spectrum production for businesses, artists, and creators who want work that stands out.')); ?>
                                </p>
                                <a href="<?php echo esc_url(mileym3dia_get_page_url('services')); ?>" class="text-link-arrow disciplines-cta-link">
                                    <span><?php esc_html_e('SERVICES & PRICING PACKAGES', 'm3-big-red'); ?></span>
                                    <span class="link-arrow">↗</span>
                                </a>
                            </div>
                        </div>

                        <div class="disciplines-list">
                            <?php foreach ($services_list as $idx => $srv) :
                                $s_num     = !empty($srv['num']) ? $srv['num'] : str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT);
                                $s_title   = $srv['title'];
                                $s_tag     = $srv['tag'];
                                $s_desc    = $srv['desc'];
                                $s_subtags = !empty($srv['subtags']) && is_array($srv['subtags']) ? $srv['subtags'] : array();
                                $accent    = !empty($srv['accent']) ? $srv['accent'] : 'red';
                            ?>
                                <a href="<?php echo esc_url(mileym3dia_get_page_url('services')); ?>" class="discipline-row discipline-row--<?php echo esc_attr($accent); ?>">
                                    <div class="discipline-indicator"></div>
                                    <div class="discipline-col-num">
                                        <span class="discipline-number"><?php echo esc_html($s_num); ?></span>
                                    </div>
                                    <div class="discipline-col-title">
                                        <span class="discipline-tag text-<?php echo esc_attr($accent); ?>"><?php echo esc_html($s_tag); ?></span>
                                        <h3 class="discipline-name"><?php echo esc_html($s_title); ?></h3>
                                    </div>
                                    <div class="discipline-col-desc">
                                        <p class="discipline-summary"><?php echo esc_html($s_desc); ?></p>
                                        <?php if (!empty($s_subtags)) : ?>
                                            <div class="discipline-subtags">
                                                <?php foreach ($s_subtags as $st) : ?>
                                                    <span><?php echo esc_html($st); ?></span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="discipline-col-action">
                                        <span class="discipline-arrow">↗</span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
                <?php
            },
        );
    }

    if (get_theme_mod('mileym3dia_show_pricing', true)) {
        $m3_home_sections['pricing'] = array(
            'order' => (int) get_theme_mod('mileym3dia_section_order_pricing', 40),
            'render' => function () {
                $tier_configs = array(
                    1 => array(
                        'color'    => 'blue',
                        'featured' => false,
                        'period'   => get_theme_mod('mileym3dia_tier_1_period', 'HALF-DAY'),
                        'badge'    => get_theme_mod('mileym3dia_tier_1_badge', 'ENTRY TIER'),
                        'price'    => '$' . ltrim(get_theme_mod('mileym3dia_tier_1_price', '350'), '$'),
                        'title'    => get_theme_mod('mileym3dia_tier_1_title', 'SINGLE SHOOT OR DESIGN'),
                        'desc'     => get_theme_mod('mileym3dia_tier_1_desc', 'Ideal for emerging artists, single product launches, and rapid promo deliverables.'),
                        'features' => get_theme_mod('mileym3dia_tier_1_features', "Half-Day 4K Camera Shoot or Studio Session\nOr Complete Custom Logo & Brand Mark Kit\nProfessional Color Grading or Studio Audio Mix\nFast 3-5 Business Day Turnaround"),
                        'btn'      => get_theme_mod('mileym3dia_tier_1_btn', 'SELECT STARTER ↗'),
                        'btn_cls'  => 'btn--streetwear-outline',
                        'pkg'      => 'starter',
                    ),
                    2 => array(
                        'color'    => 'yellow',
                        'featured' => true,
                        'period'   => get_theme_mod('mileym3dia_tier_2_period', 'FULL-DAY'),
                        'badge'    => get_theme_mod('mileym3dia_tier_2_badge', 'MOST POPULAR'),
                        'price'    => '$' . ltrim(get_theme_mod('mileym3dia_tier_2_price', '750'), '$'),
                        'title'    => get_theme_mod('mileym3dia_tier_2_title', 'CREATOR & BRAND LAUNCH'),
                        'desc'     => get_theme_mod('mileym3dia_tier_2_desc', 'Complete multi-asset rollout package for single releases and brand campaign launches.'),
                        'features' => get_theme_mod('mileym3dia_tier_2_features', "Full-Day 4K Video & Photo Session\nFull Cut + 3 Social Vertical Reels\n15 Retouched Editorial Photos\nSingle / Album Cover Art Included"),
                        'btn'      => get_theme_mod('mileym3dia_tier_2_btn', 'SELECT CREATOR ↗'),
                        'btn_cls'  => 'btn--accent-yellow',
                        'pkg'      => 'creator',
                    ),
                    3 => array(
                        'color'    => 'red',
                        'featured' => false,
                        'period'   => get_theme_mod('mileym3dia_tier_3_period', 'MULTI-DAY'),
                        'badge'    => get_theme_mod('mileym3dia_tier_3_badge', 'ALL-IN-ONE STUDIO'),
                        'price'    => '$' . ltrim(get_theme_mod('mileym3dia_tier_3_price', '1,450'), '$'),
                        'title'    => get_theme_mod('mileym3dia_tier_3_title', 'FULL PRODUCTION + WEB'),
                        'desc'     => get_theme_mod('mileym3dia_tier_3_desc', 'High-impact end-to-end media campaign uniting cinema video, branding, and custom web.'),
                        'features' => get_theme_mod('mileym3dia_tier_3_features', "Complete Brand Identity, Logo Suite & Style Guide\nCustom Multi-Section Website or Online Storefront\nFlagship 4K Commercial or Music Video Production\nFull Commercial & Broadcast Rights"),
                        'btn'      => get_theme_mod('mileym3dia_tier_3_btn', 'SELECT FULL PRODUCTION ↗'),
                        'btn_cls'  => 'btn--streetwear-red',
                        'pkg'      => 'full',
                    ),
                );
                $pricing_eyebrow = get_theme_mod('mileym3dia_pricing_eyebrow', get_theme_mod('mileym3dia_pricing_teaser_eyebrow', '04 / TRANSPARENT INVESTMENT'));
                $pricing_title   = get_theme_mod('mileym3dia_pricing_teaser_title', 'PACKAGES & CUSTOM BUNDLES');
                $pricing_desc    = get_theme_mod('mileym3dia_pricing_teaser_desc', 'No hidden fees. Choose a ready-to-shoot package or bundle 3+ services from $95 and automatically save 10%.');
                ?>
                <section class="pricing-matrix-section section-loose bg-shade-base" id="pricing">
                    <div class="container container--wide">
                        <div class="section-header">
                            <div class="section-header-left">
                                <span class="section-label text-yellow"><?php echo esc_html($pricing_eyebrow); ?></span>
                                <h2 class="section-title section-title--xl"><?php echo esc_html($pricing_title); ?></h2>
                            </div>
                            <div class="section-header-right">
                                <p class="section-header-desc">
                                    <?php echo esc_html($pricing_desc); ?>
                                </p>
                                <a href="<?php echo esc_url(mileym3dia_get_page_url('services')); ?>#pricing" class="text-link-arrow">
                                    <span><?php esc_html_e('FULL PRICING DIRECTORY', 'm3-big-red'); ?></span>
                                    <span class="link-arrow">↗</span>
                                </a>
                            </div>
                        </div>

                        <div class="pricing-matrix-dock">
                            <div class="pricing-tiers-row">
                                <?php foreach ($tier_configs as $tc) :
                                    $feat_lines = array_filter(array_map('trim', explode("\n", $tc['features'])));
                                ?>
                                    <div class="pricing-mini-card <?php echo $tc['featured'] ? 'pricing-mini-card--featured ' : ''; ?>pricing-mini-card--<?php echo esc_attr($tc['color']); ?>">
                                        <div class="pricing-mini-top">
                                            <span class="pricing-badge text-<?php echo esc_attr($tc['color']); ?>"><?php echo esc_html($tc['badge']); ?></span>
                                            <span class="text-mono <?php echo $tc['featured'] ? 'text-yellow' : 'text-muted'; ?>"><?php echo esc_html($tc['period']); ?></span>
                                        </div>
                                        <div class="pricing-mini-price <?php echo $tc['featured'] ? 'text-yellow' : ''; ?>"><?php echo esc_html($tc['price']); ?></div>
                                        <h4 class="pricing-mini-title"><?php echo esc_html($tc['title']); ?></h4>
                                        <p class="pricing-mini-desc"><?php echo esc_html($tc['desc']); ?></p>
                                        <ul class="pricing-mini-features">
                                            <?php foreach (array_slice($feat_lines, 0, 4) as $fl) : ?>
                                                <li><span class="text-<?php echo esc_attr($tc['color']); ?>">✓</span> <?php echo esc_html($fl); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <a href="<?php echo esc_url(add_query_arg('tier', $tc['pkg'], mileym3dia_get_page_url('contact'))); ?>" class="btn <?php echo esc_attr($tc['btn_cls']); ?>" style="width:100%; justify-content:center; margin-top:1rem;">
                                            <span><?php echo esc_html($tc['btn']); ?></span>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="bundle-callout-dock">
                                <div class="bundle-callout-content">
                                    <span class="bundle-callout-tag text-mono">CUSTOM MIX &amp; MATCH FROM $95</span>
                                    <h3 class="bundle-callout-title">NEED SPECIFIC ASSETS? BUILD YOUR BUNDLE</h3>
                                    <p class="bundle-callout-desc">
                                        Select individual vertical edits ($95), cover graphics ($125), vocal mixes ($150), photo sessions ($225), or web pages ($350). Automatically receive 10% off when you combine 3 or more services.
                                    </p>
                                </div>
                                <div class="bundle-callout-actions">
                                    <a href="<?php echo esc_url(mileym3dia_get_page_url('services')); ?>#bundle" class="btn btn--accent-lime">
                                        <span class="btn-text">OPEN BUNDLE BUILDER</span>
                                        <span class="btn-arrow">⚡</span>
                                    </a>
                                    <a href="<?php echo esc_url(mileym3dia_get_page_url('services')); ?>#pricing" class="btn btn--streetwear-outline">
                                        <span class="btn-text">COMPARE ALL TIERS</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <?php
            },
        );
    }

    if (get_theme_mod('mileym3dia_show_store_home', true) && function_exists('mileym3dia_get_store_products')) {
        $m3_home_sections['store'] = array(
            'order' => (int) get_theme_mod('mileym3dia_section_order_store', 50),
            'render' => function () {
                $store_items = array_slice(mileym3dia_get_store_products(), 0, 3);
                $store_url   = mileym3dia_get_page_url('store');
                $store_title = get_theme_mod('mileym3dia_store_title', 'THE STUDIO STORE');
                ?>
                <section class="store-home-section section-loose bg-shade-elevated" id="store">
                    <div class="container container--wide">
                        <div class="section-header">
                            <div class="section-header-left">
                                <span class="section-label text-lime"><?php echo esc_html(get_theme_mod('mileym3dia_store_eyebrow', 'STUDIO STORE // WOOCOMMERCE DIGITAL & PHYSICAL')); ?></span>
                                <h2 class="section-title section-title--xl"><?php echo esc_html($store_title); ?></h2>
                            </div>
                            <div class="section-header-right">
                                <p class="section-header-desc">
                                    Production-tested 35mm LUTs, analog stem vaults, lookbook layout systems, and studio gear powered by WooCommerce.
                                </p>
                                <a href="<?php echo esc_url($store_url); ?>" class="text-link-arrow">
                                    <span><?php esc_html_e('ENTER FULL STUDIO STORE', 'm3-big-red'); ?></span>
                                    <span class="link-arrow">↗</span>
                                </a>
                            </div>
                        </div>

                        <div class="store-grid store-grid--home">
                            <?php foreach ($store_items as $item) :
                                $prod_link = !empty($item['permalink']) ? $item['permalink'] : add_query_arg('cat', $item['category_slug'], $store_url);
                                $add_link  = !empty($item['add_to_cart_url']) ? $item['add_to_cart_url'] : $store_url;
                            ?>
                                <article class="store-card">
                                    <a href="<?php echo esc_url($prod_link); ?>" class="store-card__media">
                                        <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy" />
                                        <?php if (!empty($item['badge'])) : ?>
                                            <span class="store-card__badge"><?php echo esc_html($item['badge']); ?></span>
                                        <?php endif; ?>
                                        <span class="store-card__price-tag"><?php echo esc_html($item['price']); ?></span>
                                    </a>
                                    <div class="store-card__body">
                                        <div class="store-card__meta">
                                            <span class="store-card__category"><?php echo esc_html($item['category_label']); ?></span>
                                            <span class="store-card__format"><?php echo esc_html($item['format']); ?></span>
                                        </div>
                                        <h3 class="store-card__title"><a href="<?php echo esc_url($prod_link); ?>"><?php echo esc_html($item['title']); ?></a></h3>
                                        <p class="store-card__desc"><?php echo esc_html($item['desc']); ?></p>
                                        <div class="store-card__actions">
                                            <a href="<?php echo esc_url($add_link); ?>" class="btn btn--streetwear-red">
                                                <span><?php echo esc_html($item['btn_text']); ?></span>
                                            </a>
                                            <a href="<?php echo esc_url($prod_link); ?>" class="btn btn--streetwear-outline">
                                                <span>DETAILS →</span>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
                <?php
            },
        );
    }

    if (get_theme_mod('mileym3dia_show_blog', true)) {
        $m3_home_sections['blog'] = array(
            'order' => (int) get_theme_mod('mileym3dia_section_order_blog', 60),
            'render' => function () {
                ?>
                <section class="blog-section section-loose bg-shade-base" id="blog">
                    <div class="container container--wide">
                        <div class="section-header">
                            <div class="section-header-left">
                                <span class="section-label text-blue"><?php echo esc_html(get_theme_mod('mileym3dia_blog_section_eyebrow', '05 / STUDIO JOURNAL')); ?></span>
                                <h2 class="section-title section-title--xl"><?php echo esc_html(get_theme_mod('mileym3dia_blog_section_title', 'LATEST INSIGHTS & BEHIND THE SCENES')); ?></h2>
                            </div>
                            <div class="section-header-right">
                                <a href="<?php echo esc_url(mileym3dia_get_blog_page_url()); ?>" class="text-link-arrow">
                                    <span><?php esc_html_e('VIEW ALL ARTICLES', 'm3-big-red'); ?></span>
                                    <span class="link-arrow">↗</span>
                                </a>
                            </div>
                        </div>

                        <div class="blog-grid">
                            <?php
                            $blog_query = new WP_Query(array(
                                'post_type'      => 'post',
                                'posts_per_page' => 3,
                                'post_status'    => 'publish',
                            ));

                            if ($blog_query->have_posts()) :
                                $blog_counter = 1;
                                while ($blog_query->have_posts()) :
                                    $blog_query->the_post();
                            ?>
                                <article class="blog-card">
                                    <a href="<?php the_permalink(); ?>" class="blog-card-link">
                                        <div class="blog-media">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <?php the_post_thumbnail('mileym3dia-medium', array('class' => 'blog-img')); ?>
                                            <?php else : ?>
                                                <img src="<?php echo esc_url(mileym3dia_get_blog_image_url($blog_counter)); ?>" alt="<?php the_title_attribute(); ?>" class="blog-img" loading="lazy" />
                                            <?php endif; ?>
                                        </div>
                                        <div class="blog-body">
                                            <div class="blog-meta">
                                                <span class="blog-date"><?php echo esc_html(get_the_date('M d, Y')); ?></span>
                                                <span class="blog-idx">0<?php echo (int) $blog_counter; ?></span>
                                            </div>
                                            <h3 class="blog-title"><?php the_title(); ?></h3>
                                            <p class="blog-excerpt"><?php echo esc_html(mileym3dia_custom_excerpt(18)); ?></p>
                                            <span class="blog-read-link"><?php echo esc_html(get_theme_mod('mileym3dia_blog_read_more_text', 'READ ARTICLE')); ?> ↗</span>
                                        </div>
                                    </a>
                                </article>
                            <?php
                                    $blog_counter++;
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                </section>
                <?php
            },
        );
    }

    if (get_theme_mod('mileym3dia_show_contact_cta', true)) {
        $m3_home_sections['contact'] = array(
            'order' => (int) get_theme_mod('mileym3dia_section_order_contact', 70),
            'render' => function () {
                $contact_email = get_theme_mod('mileym3dia_contact_email', 'hello@mileym3dia.com');
                ob_start();
                ?>
                <div class="contact-footer-telemetry">
                    <div class="telemetry-box">
                        <span class="box-label">STUDIO LOCATION</span>
                        <span class="box-val"><?php echo esc_html(get_theme_mod('mileym3dia_contact_location', 'ORLANDO, FL · AVAILABLE WORLDWIDE')); ?></span>
                    </div>
                    <div class="telemetry-box">
                        <span class="box-label">BOOKING STATUS</span>
                        <span class="box-val box-val--active">● <?php echo esc_html(get_theme_mod('mileym3dia_contact_availability', 'NOW BOOKING NEW PROJECTS')); ?></span>
                    </div>
                    <div class="telemetry-box">
                        <span class="box-label">RESPONSE TIME</span>
                        <span class="box-val">WITHIN 24 HOURS</span>
                    </div>
                </div>
                <?php
                $telemetry_html = ob_get_clean();
                if (function_exists('mileym3dia_render_cta_plate_banner')) {
                    mileym3dia_render_cta_plate_banner('red', array(
                        'id'             => 'contact',
                        'eyebrow'        => get_theme_mod('mileym3dia_contact_eyebrow', 'READY WHEN YOU ARE'),
                        'heading'        => get_theme_mod('mileym3dia_contact_cta', "LET'S BUILD YOUR NEXT PROJECT."),
                        'subheading'     => get_theme_mod('mileym3dia_contact_subhead', 'Tell us about your upcoming video shoot, photography session, brand identity, website, or audio project. We respond to all inquiries within 24 hours.'),
                        'primary_text'   => __('START YOUR PROJECT BRIEF', 'm3-big-red'),
                        'primary_url'    => mileym3dia_get_page_url('contact'),
                        'secondary_text' => $contact_email,
                        'secondary_url'  => 'mailto:' . $contact_email,
                        'footer_html'    => $telemetry_html,
                    ));
                }
            },
        );
    }

    uasort($m3_home_sections, function ($a, $b) {
        return $a['order'] <=> $b['order'];
    });

    foreach ($m3_home_sections as $sec) {
        if (is_callable($sec['render'])) {
            call_user_func($sec['render']);
        }
    }
    ?>

</main>

<?php get_footer(); ?>

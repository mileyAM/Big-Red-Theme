<?php
/**
 * Single Project Case Study Template
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) : the_post();
    $post_slug        = get_post_field('post_name', get_the_ID());
    $default_projects = function_exists('mileym3dia_get_default_projects_data') ? mileym3dia_get_default_projects_data() : array();
    $proj_fallback    = isset($default_projects[$post_slug]) ? $default_projects[$post_slug] : reset($default_projects);
    $hero_slot        = !empty($proj_fallback['slot']) ? (int) $proj_fallback['slot'] : 1;

    $meta       = mileym3dia_get_project_meta();
    $categories = taxonomy_exists('project_category') ? get_the_terms(get_the_ID(), 'project_category') : array();
    $cat_obj    = ($categories && !is_wp_error($categories)) ? reset($categories) : null;
    $cat_name   = $cat_obj ? $cat_obj->name : (!empty($proj_fallback['cat_name']) ? $proj_fallback['cat_name'] : 'CREATIVE PRODUCTION');
    $cat_slug   = $cat_obj ? $cat_obj->slug : (!empty($proj_fallback['cat_slug']) ? $proj_fallback['cat_slug'] : 'video');

    // Map category to brand color accent (canonical 5 service categories + legacy short slugs)
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
    $custom_accent = get_post_meta(get_the_ID(), '_project_accent', true);
    if (!empty($custom_accent)) {
        $accent = $custom_accent;
    } else {
        $accent = $accent_map[$cat_slug] ?? (!empty($proj_fallback['accent']) ? $proj_fallback['accent'] : 'red');
    }

    $client   = $meta['client'] ?: get_post_meta(get_the_ID(), '_project_client', true) ?: ($proj_fallback['client'] ?? 'NIGHTFALL ATELIER');
    $year     = $meta['year'] ?: get_post_meta(get_the_ID(), '_project_year', true) ?: ($proj_fallback['year'] ?? get_the_date('Y'));
    $timeline = get_post_meta(get_the_ID(), '_project_timeline', true) ?: ($proj_fallback['timeline'] ?? '4-Week Cycle');
    $services = $meta['services'] ?: get_post_meta(get_the_ID(), '_project_services', true) ?: ($proj_fallback['services'] ?? 'Commercial Production / Art Direction');
    $url      = $meta['url'] ?: get_post_meta(get_the_ID(), '_project_url', true) ?: ($proj_fallback['url'] ?? '');

    $challenge_title = get_post_meta(get_the_ID(), '_project_challenge_title', true) ?: ($proj_fallback['challenge_title'] ?? 'Defining the Visual Identity & Cinematic Scope');
    $solution_title  = get_post_meta(get_the_ID(), '_project_solution_title', true) ?: ($proj_fallback['solution_title'] ?? 'Precision Lighting, Color Mastery & Delivery');

    // Specific case study fields with fallbacks
    $challenge = get_post_meta(get_the_ID(), '_project_challenge', true);
    if (empty($challenge)) {
        $challenge = !empty($proj_fallback['challenge'])
            ? $proj_fallback['challenge']
            : 'The client approached MILEYM3DIA seeking an unmistakable visual identity and high-impact media campaign to cut through industry noise. The creative objective was to balance raw street-level energy with cinema-grade technical precision, crafting visuals that resonate deeply across digital platforms and broadcast formats.';
    }

    $solution = get_post_meta(get_the_ID(), '_project_solution', true);
    if (empty($solution)) {
        $solution = !empty($proj_fallback['solution'])
            ? $proj_fallback['solution']
            : 'Our in-house production team handled the entire pipeline from concept treatment to master delivery. Utilizing RED and Sony cinema camera packages, custom focal-length lighting setups, DaVinci Resolve color grading, and bespoke audio sound design, we crafted a cohesive narrative that outperformed engagement targets by over 140%.';
    }

    $specs_raw = get_post_meta(get_the_ID(), '_project_specs', true);
    if (empty($specs_raw)) {
        $specs_raw = !empty($proj_fallback['specs'])
            ? $proj_fallback['specs']
            : "Camera: RED Digital Cinema · Sony Cinema Line\nColor Pipeline: DaVinci Resolve Studio RAW Grading\nSound & Score: Bespoke Studio Sound Design & Master\nDeliverables: 4K Master, Social Reels, Still Lookbook";
    }
    $specs_lines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $specs_raw))));

    $stats = get_post_meta(get_the_ID(), '_project_stats', true);
    if (empty($stats) || !is_array($stats)) {
        $stats = !empty($proj_fallback['stats']) ? $proj_fallback['stats'] : array(
            array('num' => '4K RAW', 'label' => 'Cinema Camera Master'),
            array('num' => '10-DAY', 'label' => 'Concept to Delivery'),
            array('num' => '100%', 'label' => 'In-House Production'),
            array('num' => '1.8M+', 'label' => 'Multi-Platform Reach'),
        );
    }

    $gallery_meta = get_post_meta(get_the_ID(), '_project_gallery', true);
    $gallery_urls = array();
    if (is_array($gallery_meta)) {
        $gallery_urls = array_values(array_filter($gallery_meta));
    } elseif (is_string($gallery_meta) && '' !== trim($gallery_meta)) {
        $gallery_urls = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $gallery_meta))));
    }
    $gallery_frame_1 = !empty($gallery_urls[0]) ? $gallery_urls[0] : mileym3dia_get_project_image_url(2);
    $gallery_frame_2 = !empty($gallery_urls[1]) ? $gallery_urls[1] : mileym3dia_get_project_image_url(3);
    $gallery_frame_3 = !empty($gallery_urls[2]) ? $gallery_urls[2] : mileym3dia_get_project_image_url(4);

    $raw_title = get_the_title();
    $words = explode(' ', trim($raw_title));
    if (count($words) > 1) {
        $last_word = array_pop($words);
        $title_html = esc_html(implode(' ', $words)) . ' <span class="text-' . esc_attr($accent) . '">' . esc_html($last_word) . '</span>';
    } else {
        $title_html = '<span class="text-' . esc_attr($accent) . '">' . esc_html($raw_title) . '</span>';
    }
?>

<main id="primary" class="site-main single-project-main bg-shade-base">

    <!-- 01. CASE STUDY HERO HEADER -->
    <section class="case-study-hero-section section-dark">
        <div class="container container--wide">

            <div class="case-study-breadcrumbs">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('HOME', 'mileym3dia'); ?></a>
                <span class="sep">/</span>
                <a href="<?php echo esc_url(mileym3dia_get_work_page_url()); ?>"><?php esc_html_e('WORK', 'mileym3dia'); ?></a>
                <span class="sep">/</span>
                <span class="current text-<?php echo esc_attr($accent); ?>"><?php echo esc_html(strtoupper($cat_name)); ?></span>
            </div>

            <div class="case-study-title-wrap">
                <div class="case-study-badge-row">
                    <span class="section-tag tag--<?php echo esc_attr($accent); ?>">CASE STUDY</span>
                    <span class="case-study-year-pill"><?php echo esc_html($year); ?></span>
                </div>
                <h1 class="page-title page-title--mega case-study-title">
                    <?php echo $title_html; ?>
                </h1>
                <p class="page-lead case-study-lead">
                    <?php echo esc_html(get_the_excerpt() ?: ($proj_fallback['excerpt'] ?? '')); ?>
                </p>
            </div>

            <!-- 4-COLUMN PROJECT METADATA DOCK -->
            <div class="case-study-meta-dock">
                <div class="meta-dock-item">
                    <span class="dock-label"><?php esc_html_e('CLIENT', 'mileym3dia'); ?></span>
                    <span class="dock-value"><?php echo esc_html($client); ?></span>
                </div>
                <div class="meta-dock-item">
                    <span class="dock-label"><?php esc_html_e('YEAR & TIMELINE', 'mileym3dia'); ?></span>
                    <span class="dock-value"><?php echo esc_html($year); ?> &middot; <?php echo esc_html($timeline); ?></span>
                </div>
                <div class="meta-dock-item">
                    <span class="dock-label"><?php esc_html_e('SERVICES DELIVERED', 'mileym3dia'); ?></span>
                    <span class="dock-value"><?php echo esc_html($services); ?></span>
                </div>
                <div class="meta-dock-item meta-dock-action">
                    <span class="dock-label"><?php esc_html_e('PROJECT STATUS', 'mileym3dia'); ?></span>
                    <?php if ($url && $url !== '#') : ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="btn btn--streetwear-<?php echo esc_attr($accent); ?> btn--sm">
                            <span class="btn-text"><?php esc_html_e('LIVE LAUNCH', 'mileym3dia'); ?></span>
                            <span class="btn-arrow" aria-hidden="true">&nearr;</span>
                        </a>
                    <?php else : ?>
                        <span class="dock-value text-<?php echo esc_attr($accent); ?>">&bull; <?php esc_html_e('COMPLETED MASTER', 'mileym3dia'); ?></span>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>

    <!-- 02. FULL-WIDTH CINEMA FEATURE MEDIA -->
    <section class="case-study-feature-media">
        <div class="container container--wide">
            <?php $video_url = get_post_meta(get_the_ID(), '_project_video_url', true); ?>
            <div class="feature-media-frame">
                <?php if (!empty($video_url)) :
                    $is_direct_video = preg_match('/\.(mp4|webm|ogg)(\?.*)?$/i', $video_url);
                ?>
                    <?php if ($is_direct_video) : ?>
                        <video class="case-study-video-player" controls playsinline preload="metadata" poster="<?php echo esc_url(has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : mileym3dia_get_project_image_url($proj_slot)); ?>">
                            <source src="<?php echo esc_url($video_url); ?>" type="video/mp4" />
                        </video>
                    <?php elseif (function_exists('wp_oembed_get') && ($embed_html = wp_oembed_get($video_url))) : ?>
                        <div class="case-study-video-embed"><?php echo $embed_html; ?></div>
                    <?php else : ?>
                        <iframe class="case-study-video-iframe" src="<?php echo esc_url($video_url); ?>" title="<?php echo esc_attr(get_the_title() . ' Video'); ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    <?php endif; ?>
                <?php elseif (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('mileym3dia-hero', array('class' => 'feature-media-image')); ?>
                <?php else : ?>
                    <img src="<?php echo esc_url(mileym3dia_get_project_image_url($hero_slot)); ?>" alt="<?php the_title_attribute(); ?>" class="feature-media-image" />
                <?php endif; ?>
                <div class="feature-media-overlay"></div>
                <div class="feature-media-badge card-corner-badge--<?php echo esc_attr($accent); ?>">
                    <span><?php echo esc_html(strtoupper($cat_name)); ?></span>
                </div>
            </div>
        </div>
    </section>

    <!-- 03. CASE STUDY EDITORIAL BREAKDOWN (CHALLENGE & EXECUTION) -->
    <section class="case-study-breakdown-section section-loose">
        <div class="container container--wide">
            <div class="case-study-split-grid">

                <div class="case-study-col case-study-col--challenge">
                    <div class="col-header-pill">
                        <span class="pill-number">01</span>
                        <span class="pill-title text-<?php echo esc_attr($accent); ?>"><?php esc_html_e('THE CREATIVE CHALLENGE', 'mileym3dia'); ?></span>
                    </div>
                    <h2 class="col-headline"><?php echo esc_html($challenge_title); ?></h2>
                    <div class="col-body-text">
                        <p><?php echo esc_html($challenge); ?></p>
                        <?php if (trim(get_the_content())) : ?>
                            <div class="custom-post-body" style="margin-top:1.5rem;">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="case-study-col case-study-col--solution">
                    <div class="col-header-pill">
                        <span class="pill-number">02</span>
                        <span class="pill-title text-<?php echo esc_attr($accent); ?>"><?php esc_html_e('THE PRODUCTION EXECUTION', 'mileym3dia'); ?></span>
                    </div>
                    <h2 class="col-headline"><?php echo esc_html($solution_title); ?></h2>
                    <div class="col-body-text">
                        <p><?php echo esc_html($solution); ?></p>
                        <div class="case-study-specs-card">
                            <span class="specs-title"><?php esc_html_e('PRODUCTION RIG & PIPELINE', 'mileym3dia'); ?></span>
                            <ul class="specs-list">
                                <?php foreach ($specs_lines as $s_line) :
                                    if (strpos($s_line, ':') !== false) :
                                        list($s_lbl, $s_val) = explode(':', $s_line, 2);
                                ?>
                                        <li><strong><?php echo esc_html(trim($s_lbl)); ?>:</strong> <?php echo esc_html(trim($s_val)); ?></li>
                                    <?php else : ?>
                                        <li><?php echo esc_html($s_line); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 04. KEY PRODUCTION IMPACT & METRICS STRIP -->
    <section class="case-study-stats-section bg-shade-elevated">
        <div class="container container--wide">
            <div class="case-study-stats-grid">
                <?php foreach ($stats as $st) : ?>
                    <div class="stat-card">
                        <span class="stat-number text-<?php echo esc_attr($accent); ?>"><?php echo esc_html($st['num']); ?></span>
                        <span class="stat-label"><?php echo esc_html($st['label']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 05. PRODUCTION GALLERY / BTS STILLS -->
    <section class="case-study-gallery-section section-loose">
        <div class="container container--wide">
            <div class="section-title-wrap" style="margin-bottom: 2.5rem;">
                <span class="section-eyebrow text-<?php echo esc_attr($accent); ?>"><?php esc_html_e('PRODUCTION VISUALS', 'mileym3dia'); ?></span>
                <h2 class="section-title"><?php esc_html_e('STILLS & DELIVERABLES SHOWCASE', 'mileym3dia'); ?></h2>
            </div>

            <div class="case-study-gallery-grid">
                <div class="gallery-item gallery-item--wide">
                    <img src="<?php echo esc_url($gallery_frame_1); ?>" alt="<?php the_title_attribute(); ?> Stills" loading="lazy" />
                    <span class="gallery-caption"><?php esc_html_e('FRAME 01 · CINEMATOGRAPHY STILL', 'mileym3dia'); ?></span>
                </div>
                <div class="gallery-item">
                    <img src="<?php echo esc_url($gallery_frame_2); ?>" alt="<?php the_title_attribute(); ?> Detail" loading="lazy" />
                    <span class="gallery-caption"><?php esc_html_e('FRAME 02 · DETAIL & COMPOSITION', 'mileym3dia'); ?></span>
                </div>
                <div class="gallery-item">
                    <img src="<?php echo esc_url($gallery_frame_3); ?>" alt="<?php the_title_attribute(); ?> Editorial" loading="lazy" />
                    <span class="gallery-caption"><?php esc_html_e('FRAME 03 · EDITORIAL LOOKBOOK', 'mileym3dia'); ?></span>
                </div>
            </div>
        </div>
    </section>

    <!-- 06. CASE STUDY PAGINATION NAVIGATOR -->
    <section class="case-study-navigation-section bg-shade-elevated">
        <div class="container container--wide">
            <div class="case-study-nav-dock">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>
                <div class="nav-dock-side nav-dock-prev">
                    <?php if ($prev_post) : ?>
                        <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="nav-dock-link">
                            <span class="nav-dock-dir">&larr; <?php esc_html_e('PREVIOUS CASE STUDY', 'mileym3dia'); ?></span>
                            <span class="nav-dock-name"><?php echo esc_html(get_the_title($prev_post)); ?></span>
                        </a>
                    <?php else : ?>
                        <span class="nav-dock-empty">&mdash; <?php esc_html_e('FIRST CASE STUDY', 'mileym3dia'); ?></span>
                    <?php endif; ?>
                </div>

                <div class="nav-dock-center">
                    <a href="<?php echo esc_url(mileym3dia_get_work_page_url()); ?>" class="btn btn--streetwear-outline btn--sm">
                        <?php esc_html_e('VIEW ALL WORK', 'mileym3dia'); ?>
                    </a>
                </div>

                <div class="nav-dock-side nav-dock-next">
                    <?php if ($next_post) : ?>
                        <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="nav-dock-link">
                            <span class="nav-dock-dir"><?php esc_html_e('NEXT CASE STUDY', 'mileym3dia'); ?> &rarr;</span>
                            <span class="nav-dock-name"><?php echo esc_html(get_the_title($next_post)); ?></span>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url(mileym3dia_get_work_page_url()); ?>" class="nav-dock-link">
                            <span class="nav-dock-dir"><?php esc_html_e('EXPLORE MORE', 'mileym3dia'); ?> &rarr;</span>
                            <span class="nav-dock-name"><?php esc_html_e('ALL PRODUCTIONS', 'mileym3dia'); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 07. CONVERSION CALL TO ACTION -->
    <section class="case-study-cta-section section-loose bg-shade-base">
        <div class="container text-center">
            <span class="section-tag tag--<?php echo esc_attr($accent); ?>"><?php esc_html_e('START YOUR PRODUCTION', 'mileym3dia'); ?></span>
            <h2 class="cta-headline" style="margin-top: 1.25rem;">
                <?php esc_html_e('HAVE A SIMILAR VISION FOR YOUR BRAND?', 'mileym3dia'); ?>
            </h2>
            <p class="page-lead" style="max-width: 680px; margin: 1rem auto 2.5rem auto;">
                <?php esc_html_e('Let our directors, photographers, brand designers, and audio engineers bring your project to life with cinema-grade execution.', 'mileym3dia'); ?>
            </p>
            <div class="hero-action-buttons" style="justify-content: center; gap: 1rem;">
                <a href="<?php echo esc_url(mileym3dia_get_page_url('contact')); ?>" class="btn btn--streetwear-<?php echo esc_attr($accent); ?>">
                    <span class="btn-text"><?php esc_html_e('BOOK A PRODUCTION', 'mileym3dia'); ?></span>
                    <span class="btn-arrow" aria-hidden="true">&nearr;</span>
                </a>
                <a href="<?php echo esc_url(mileym3dia_get_page_url('services')); ?>#pricing" class="btn btn--streetwear-outline">
                    <span class="btn-text"><?php esc_html_e('VIEW PACKAGES &amp; BUNDLE BUILDER', 'mileym3dia'); ?></span>
                </a>
            </div>
        </div>
    </section>

</main>

<?php
endwhile;
get_footer();

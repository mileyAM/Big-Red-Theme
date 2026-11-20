<?php
/**
 * Template Name: About
 * Description: Dedicated About page template with side-to-side layout and big typography.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$about_img = get_theme_mod('mileym3dia_about_image', '');
if (empty($about_img)) {
    $about_img = get_template_directory_uri() . '/assets/images/sections/about-camera-collage.jpg';
}
$split2_img = get_theme_mod('mileym3dia_about_split2_image', '');
if (empty($split2_img)) {
    $split2_img = get_template_directory_uri() . '/assets/images/sections/hoodie-camera-right.jpg';
}
?>

<main id="primary" class="site-main">

    <!-- OFFICIAL MILEYM3DIA ABOUT BANNER (ELEVATE YOUR BRAND) -->
    <?php
    if (function_exists('mileym3dia_render_page_banner')) {
        mileym3dia_render_page_banner('about', array(
            'heading_tag'      => 'h1',
            'override_eyebrow' => get_theme_mod('mileym3dia_about_eyebrow', ''),
            'override_heading' => get_theme_mod('mileym3dia_about_hero_title', ''),
            'override_subhead' => get_theme_mod('mileym3dia_about_content', ''),
        ));
    }
    ?>

    <!-- WORDPRESS PAGE EDITOR CONTENT (IF ADDED IN WP ADMIN) -->
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

    <!-- SIDE-TO-SIDE SPLIT 1: OUR STORY & APPROACH (#overview) -->
    <section class="m3-split-section bg-shade-elevated" id="overview">
        <div class="m3-split-grid">
            <div class="m3-split-content">
                <span class="section-eyebrow text-yellow"><?php echo esc_html(get_theme_mod('mileym3dia_about_story_eyebrow', '01 / STUDIO OVERVIEW')); ?></span>
                <h2 class="split-big-title">
                    <?php echo esc_html(get_theme_mod('mileym3dia_about_title', 'CREATIVE PRODUCTION WITHOUT COMPROMISE.')); ?>
                </h2>
                <p class="split-lead-text">
                    <?php echo esc_html(get_theme_mod('mileym3dia_about_content', 'MILEYM3DIA was built on a straightforward belief: great brands and artists deserve media that looks, sounds, and feels unforgettable.')); ?>
                </p>
                <p class="split-body-text">
                    <?php echo esc_html(get_theme_mod('mileym3dia_about_body_2', 'From commercial video shoots and album rollouts to complete brand overhauls and custom web builds, we handle every phase from concept to final delivery with precision and speed.')); ?>
                </p>

                <div class="split-stats-row">
                    <div class="split-stat-item">
                        <span class="stat-num text-yellow"><?php echo esc_html(get_theme_mod('mileym3dia_about_stat1_num', '4K / 8K')); ?></span>
                        <span class="stat-label"><?php echo esc_html(get_theme_mod('mileym3dia_about_stat1_label', 'CINEMA CAMERA PRODUCTION')); ?></span>
                    </div>
                    <div class="split-stat-item">
                        <span class="stat-num text-lime"><?php echo esc_html(get_theme_mod('mileym3dia_about_stat2_num', '5 CORE')); ?></span>
                        <span class="stat-label"><?php echo esc_html(get_theme_mod('mileym3dia_about_stat2_label', 'IN-HOUSE DISCIPLINES')); ?></span>
                    </div>
                    <div class="split-stat-item">
                        <span class="stat-num text-blue"><?php echo esc_html(get_theme_mod('mileym3dia_about_stat3_num', '100%')); ?></span>
                        <span class="stat-label"><?php echo esc_html(get_theme_mod('mileym3dia_about_stat3_label', 'CUSTOM STRATEGY & EXECUTION')); ?></span>
                    </div>
                </div>
            </div>

            <div class="m3-split-media">
                <img src="<?php echo esc_url($about_img); ?>" alt="MILEYM3DIA Studio" class="m3-split-img" loading="lazy" />
            </div>
        </div>
    </section>

    <!-- SIDE-TO-SIDE SPLIT 2: END-TO-END EXECUTION & PROCESS (#process) -->
    <section class="m3-split-section m3-split-section--reverse bg-shade-surface" id="process">
        <div class="m3-split-grid">
            <div class="m3-split-media">
                <img src="<?php echo esc_url($split2_img); ?>" alt="MILEYM3DIA Production Set" class="m3-split-img" loading="lazy" />
            </div>

            <div class="m3-split-content">
                <span class="section-eyebrow text-lime"><?php echo esc_html(get_theme_mod('mileym3dia_split2_eyebrow', 'HOW WE WORK')); ?></span>
                <h2 class="split-big-title"><?php echo esc_html(get_theme_mod('mileym3dia_split2_title', 'ONE STUDIO. EVERY CREATIVE DISCIPLINE.')); ?></h2>
                <p class="split-lead-text">
                    <?php echo esc_html(get_theme_mod('mileym3dia_split2_desc', 'Instead of hiring separate freelancers for video, photography, branding, web development, and audio, our clients work with one unified creative team.')); ?>
                </p>
                <ul class="split-checklist">
                    <li><span class="check-badge text-red">01</span> <strong><?php echo esc_html(get_theme_mod('mileym3dia_about_check_1_title', 'Cinematic Visuals:')); ?></strong> <?php echo esc_html(get_theme_mod('mileym3dia_about_check_1_desc', 'Every frame is lit, directed, and color-graded to broadcast and cinema standards.')); ?></li>
                    <li><span class="check-badge text-yellow">02</span> <strong><?php echo esc_html(get_theme_mod('mileym3dia_about_check_2_title', 'Cohesive Brand Identity:')); ?></strong> <?php echo esc_html(get_theme_mod('mileym3dia_about_check_2_desc', 'Logos, typography, packaging, and web design built around a single strong brand story.')); ?></li>
                    <li><span class="check-badge text-lime">03</span> <strong><?php echo esc_html(get_theme_mod('mileym3dia_about_check_3_title', 'Studio-Grade Sound:')); ?></strong> <?php echo esc_html(get_theme_mod('mileym3dia_about_check_3_desc', 'Clean location audio, custom scoring, mixing, and mastering handled in-house.')); ?></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- STUDIO GEAR & PRODUCTION HARDWARE (#gear) -->
    <section class="gear-arsenal-section section-loose bg-shade-base" id="gear">
        <div class="container container--wide">
            <div class="section-header">
                <div class="section-header-left">
                    <span class="section-label text-blue"><?php echo esc_html(get_theme_mod('mileym3dia_gear_eyebrow', '03 / PRODUCTION ARSENAL')); ?></span>
                    <h2 class="section-title section-title--xl"><?php echo esc_html(get_theme_mod('mileym3dia_gear_title', 'CINEMA HARDWARE & POST PIPELINE')); ?></h2>
                </div>
                <div class="section-header-right">
                    <p class="section-header-desc">
                        <?php echo esc_html(get_theme_mod('mileym3dia_gear_desc', 'Industry-standard cinema cameras, prime and anamorphic lenses, drone systems, and dedicated post-production suites.')); ?>
                    </p>
                </div>
            </div>

            <?php
            $gear_defaults = array(
                1 => array('title' => 'CINEMA CAMERAS', 'desc' => 'RED Digital Cinema, Sony FX Cinema Line, and Blackmagic 6K Pro camera packages with RAW recording.', 'tag' => '4K / 6K / 8K RAW', 'color' => 'red'),
                2 => array('title' => 'LENSES & LIGHTING', 'desc' => 'Cinema prime lenses, anamorphic glass, and full-spectrum LED studio and location lighting kits.', 'tag' => 'PRIME & ANAMORPHIC', 'color' => 'yellow'),
                3 => array('title' => 'AERIAL & MOTION', 'desc' => 'Licensed drone cinematography, 3-axis cinema gimbals, vehicle mounts, and wireless director monitoring.', 'tag' => 'AERIAL & STABILIZATION', 'color' => 'lime'),
                4 => array('title' => 'EDIT, COLOR & AUDIO', 'desc' => 'DaVinci Resolve Studio color grading, Adobe Creative Cloud, custom web stack, and treated audio mixing suites.', 'tag' => 'POST & MASTERING', 'color' => 'blue'),
            );
            ?>
            <div class="gear-grid">
                <?php foreach ($gear_defaults as $g_idx => $g_def) : ?>
                    <div class="gear-card">
                        <span class="gear-num text-<?php echo esc_attr($g_def['color']); ?>">0<?php echo (int) $g_idx; ?></span>
                        <h3 class="gear-title"><?php echo esc_html(get_theme_mod("mileym3dia_gear_{$g_idx}_title", $g_def['title'])); ?></h3>
                        <p class="gear-desc"><?php echo esc_html(get_theme_mod("mileym3dia_gear_{$g_idx}_desc", $g_def['desc'])); ?></p>
                        <span class="gear-tag"><?php echo esc_html(get_theme_mod("mileym3dia_gear_{$g_idx}_tag", $g_def['tag'])); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CONTACT CTA -->
    <section class="contact-cta section-loose bg-shade-elevated">
        <div class="container container--wide cta-content text-center">
            <span class="contact-eyebrow text-yellow">WORK WITH US</span>
            <h2 class="contact-headline"><?php echo esc_html(get_theme_mod('mileym3dia_contact_cta', "LET'S BUILD YOUR NEXT PROJECT.")); ?></h2>
            <div class="hero-action-buttons" style="justify-content:center; margin-top:2rem;">
                <a href="<?php echo esc_url(mileym3dia_get_page_url('contact')); ?>" class="btn btn--streetwear-red">
                    <span class="btn-text"><?php esc_html_e('START A PROJECT', 'mileym3dia'); ?></span>
                    <span class="btn-arrow">↗</span>
                </a>
                <a href="<?php echo esc_url(mileym3dia_get_work_page_url()); ?>" class="btn btn--streetwear-outline">
                    <span class="btn-text"><?php esc_html_e('VIEW PORTFOLIO', 'mileym3dia'); ?></span>
                </a>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>

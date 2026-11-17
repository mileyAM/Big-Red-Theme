<?php
/**
 * Template Name: Resources
 * Description: Dedicated Resources, Tools & Creative Assets page template with Customizer-editable downloadable files.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$default_lut_url       = get_template_directory_uri() . '/assets/files/m3-35mm-cinema-lut-pack.cube';
$default_audio_url     = get_template_directory_uri() . '/assets/files/m3-studio-audio-stem-guide.txt';
$default_lookbook_url  = get_template_directory_uri() . '/assets/files/m3-brand-lookbook-layout-guide.txt';
$default_callsheet_url = get_template_directory_uri() . '/assets/files/m3-production-call-sheet-checklist.txt';

$packs = array(
    1 => array(
        'color'   => 'blue',
        'badge'   => 'COLOR GRADING',
        'status'  => '.CUBE LUT PACK',
        'title'   => get_theme_mod('mileym3dia_resource_1_title', '35MM CINEMA LUT PACK'),
        'desc'    => get_theme_mod('mileym3dia_resource_1_desc', 'Calibrated look LUTs for Sony S-Log3, RED Log3G10, and Blackmagic Film Gen 5. Designed for natural skin tones and rich film contrast.'),
        'spec1_k' => 'FORMAT:',
        'spec1_v' => '.CUBE (DaVinci Resolve, Premiere, Final Cut)',
        'spec2_k' => 'LICENSE:',
        'spec2_v' => 'Commercial & Personal Use',
        'file'    => get_theme_mod('mileym3dia_resource_1_file', $default_lut_url),
        'btn'     => get_theme_mod('mileym3dia_resource_1_btn', 'DOWNLOAD .CUBE PACK'),
    ),
    2 => array(
        'color'   => 'yellow',
        'badge'   => 'MUSIC & AUDIO',
        'status'  => 'MIX & STEM SPEC',
        'title'   => get_theme_mod('mileym3dia_resource_2_title', 'STUDIO AUDIO STEM & MIX GUIDE'),
        'desc'    => get_theme_mod('mileym3dia_resource_2_desc', '24-Bit / 48kHz broadcast WAV stem grouping, loudness targets (-14 LUFS), and file naming specs.'),
        'spec1_k' => 'FORMAT:',
        'spec1_v' => 'Studio Mixing & Mastering Guide (.TXT)',
        'spec2_k' => 'COMPATIBILITY:',
        'spec2_v' => 'Logic Pro, Ableton, Pro Tools, Premiere',
        'file'    => get_theme_mod('mileym3dia_resource_2_file', $default_audio_url),
        'btn'     => get_theme_mod('mileym3dia_resource_2_btn', 'DOWNLOAD AUDIO SPECS'),
    ),
    3 => array(
        'color'   => 'lime',
        'badge'   => 'BRAND DESIGN',
        'status'  => 'GRID & TYPOGRAPHY',
        'title'   => get_theme_mod('mileym3dia_resource_3_title', 'BRAND & LOOKBOOK LAYOUT KIT'),
        'desc'    => get_theme_mod('mileym3dia_resource_3_desc', '12-column Swiss brutalist grid system, typography scale guides, and print/web export specs.'),
        'spec1_k' => 'FILES:',
        'spec1_v' => 'Layout Grid & Color Profile Specification',
        'spec2_k' => 'USE CASE:',
        'spec2_v' => 'Brand Guidelines & Pitch Decks',
        'file'    => get_theme_mod('mileym3dia_resource_3_file', $default_lookbook_url),
        'btn'     => get_theme_mod('mileym3dia_resource_3_btn', 'DOWNLOAD LAYOUT KIT'),
    ),
    4 => array(
        'color'   => 'red',
        'badge'   => 'PRE-PRODUCTION',
        'status'  => 'SHOOT CHECKLIST',
        'title'   => get_theme_mod('mileym3dia_resource_4_title', 'VIDEO PRODUCTION CALL SHEET & CHECKLIST'),
        'desc'    => get_theme_mod('mileym3dia_resource_4_desc', 'Our complete pre-production call sheet, shot list template, and location lighting checklist.'),
        'spec1_k' => 'FORMAT:',
        'spec1_v' => 'Editable On-Set Checklist & Call Sheet',
        'spec2_k' => 'USE CASE:',
        'spec2_v' => 'Commercial & Music Video Shoots',
        'file'    => get_theme_mod('mileym3dia_resource_4_file', $default_callsheet_url),
        'btn'     => get_theme_mod('mileym3dia_resource_4_btn', 'DOWNLOAD CALL SHEET'),
    ),
);
?>

<main id="primary" class="site-main resources-page-main">

    <!-- FULL-WIDTH RESOURCES HEADER -->
    <section class="page-title-section resources-hero-section bg-shade-base">
        <div class="container container--wide">
            <div class="resources-hero-header">
                <span class="page-subtitle text-blue">CREATIVE TOOLS &amp; ASSETS</span>
                <?php
                $resources_raw_title = get_theme_mod('mileym3dia_resources_title', 'CREATOR TOOLS & ASSETS');
                if (strpos($resources_raw_title, '<') === false) {
                    $words = explode(' ', trim($resources_raw_title));
                    if (count($words) > 1) {
                        $last_word = array_pop($words);
                        $resources_title_html = esc_html(implode(' ', $words)) . ' <span class="text-blue">' . esc_html($last_word) . '</span>';
                    } else {
                        $resources_title_html = '<span class="text-blue">' . esc_html($resources_raw_title) . '</span>';
                    }
                } else {
                    $resources_title_html = wp_kses_post($resources_raw_title);
                }
                ?>
                <h1 class="page-title page-title--mega">
                    <?php echo $resources_title_html; ?>
                </h1>
                <p class="page-lead">
                    <?php echo esc_html(get_theme_mod('mileym3dia_resources_subtitle', 'Production-tested color grading LUTs, studio audio guides, brand design templates, and production checklists created by our in-house team.')); ?>
                </p>
            </div>
        </div>
    </section>

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

    <section class="resources-grid-section section-loose bg-shade-elevated" id="toolkits">
        <div class="container container--wide">
            <div class="section-header">
                <div class="section-header-left">
                    <span class="section-label text-blue">STUDIO DOWNLOADS</span>
                    <h2 class="section-title section-title--xl">PRODUCTION PACKS</h2>
                </div>
                <div class="section-header-right">
                    <a href="<?php echo esc_url(mileym3dia_get_page_url('store')); ?>" class="text-link-arrow">
                        <span><?php esc_html_e('OPEN PRO STUDIO STORE', 'm3-big-red'); ?></span>
                        <span class="link-arrow">↗</span>
                    </a>
                </div>
            </div>

            <div class="resources-gear-grid">
                <?php foreach ($packs as $pack) : ?>
                    <div class="resource-gear-card resource-gear-card--<?php echo esc_attr($pack['color']); ?>">
                        <div class="gear-card-top">
                            <span class="gear-card-badge text-<?php echo esc_attr($pack['color']); ?>"><?php echo esc_html($pack['badge']); ?></span>
                            <span class="gear-status-tag"><?php echo esc_html($pack['status']); ?></span>
                        </div>
                        <div class="gear-card-content">
                            <h3 class="gear-card-title"><?php echo esc_html($pack['title']); ?></h3>
                            <p class="gear-card-desc"><?php echo esc_html($pack['desc']); ?></p>
                            <div class="gear-card-specs">
                                <div class="spec-row"><span class="spec-label"><?php echo esc_html($pack['spec1_k']); ?></span><span class="spec-val"><?php echo esc_html($pack['spec1_v']); ?></span></div>
                                <div class="spec-row"><span class="spec-label"><?php echo esc_html($pack['spec2_k']); ?></span><span class="spec-val"><?php echo esc_html($pack['spec2_v']); ?></span></div>
                            </div>
                        </div>
                        <div class="gear-card-footer">
                            <a href="<?php echo esc_url($pack['file']); ?>" class="btn btn--streetwear-outline btn--full" download><?php echo esc_html($pack['btn']); ?> ↓</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section-loose resources-newsletter-section bg-shade-base" id="resources-notify">
        <div class="container">
            <?php
            mileym3dia_newsletter_box(array(
                'eyebrow'     => 'CREATOR RESOURCES',
                'title'       => __('Get New Studio Packs & Updates', 'm3-big-red'),
                'description' => __('Enter your email to receive download links for new LUT packs, audio libraries, and production templates.', 'm3-big-red'),
                'button_text' => __('GET ACCESS', 'm3-big-red'),
            ));
            ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>

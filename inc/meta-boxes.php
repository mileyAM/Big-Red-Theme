<?php
/**
 * WordPress Admin Meta Boxes for Portfolio Projects (`project`) and Core Services (`service`)
 *
 * Exposes protected `_project_*` and `_service_*` post meta keys as intuitive,
 * dashboard-editable fields in WP Admin.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register meta boxes for `project` and `service` Custom Post Types
 */
function mileym3dia_register_admin_meta_boxes() {
    if (!function_exists('add_meta_box')) {
        return;
    }

    add_meta_box(
        'mileym3dia_project_details_meta_box',
        __('M3 Project Case Study Details', 'm3-big-red'),
        'mileym3dia_render_project_details_meta_box',
        'project',
        'normal',
        'high'
    );

    add_meta_box(
        'mileym3dia_service_details_meta_box',
        __('M3 Service Details', 'm3-big-red'),
        'mileym3dia_render_service_details_meta_box',
        'service',
        'normal',
        'high'
    );

    add_meta_box(
        'mileym3dia_resource_details_meta_box',
        __('M3 Resource Library Details', 'm3-big-red'),
        'mileym3dia_render_resource_details_meta_box',
        'm3_resource',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'mileym3dia_register_admin_meta_boxes');

/**
 * Render the Project Case Study Details meta box in WP Admin
 *
 * @param WP_Post $post Current project post object.
 */
function mileym3dia_render_project_details_meta_box($post) {
    wp_nonce_field('mileym3dia_save_project_meta', 'mileym3dia_project_meta_nonce');

    $post_id   = is_object($post) && isset($post->ID) ? (int) $post->ID : 0;
    $post_slug = is_object($post) && isset($post->post_name) ? (string) $post->post_name : '';

    $defaults = function_exists('mileym3dia_get_default_projects_data') ? mileym3dia_get_default_projects_data() : array();
    $fallback = ($post_slug && isset($defaults[$post_slug])) ? $defaults[$post_slug] : array();

    $client          = get_post_meta($post_id, '_project_client', true);
    if ('' === $client && !empty($fallback['client'])) {
        $client = $fallback['client'];
    }

    $year            = get_post_meta($post_id, '_project_year', true);
    if ('' === $year && !empty($fallback['year'])) {
        $year = $fallback['year'];
    }

    $timeline        = get_post_meta($post_id, '_project_timeline', true);
    if ('' === $timeline) {
        $timeline = !empty($fallback['timeline']) ? $fallback['timeline'] : '4-Week Cycle';
    }

    $services        = get_post_meta($post_id, '_project_services', true);
    if ('' === $services && !empty($fallback['services'])) {
        $services = $fallback['services'];
    }

    $url             = get_post_meta($post_id, '_project_url', true);
    if ('' === $url && !empty($fallback['url'])) {
        $url = $fallback['url'];
    }

    $featured        = get_post_meta($post_id, '_project_featured', true);
    $accent          = get_post_meta($post_id, '_project_accent', true);

    $challenge_title = get_post_meta($post_id, '_project_challenge_title', true);
    if ('' === $challenge_title) {
        $challenge_title = 'Defining the Visual Identity & Cinematic Scope';
    }

    $challenge       = get_post_meta($post_id, '_project_challenge', true);
    if ('' === $challenge && !empty($fallback['challenge'])) {
        $challenge = $fallback['challenge'];
    }

    $solution_title  = get_post_meta($post_id, '_project_solution_title', true);
    if ('' === $solution_title) {
        $solution_title = 'Precision Lighting, Color Mastery & Delivery';
    }

    $solution        = get_post_meta($post_id, '_project_solution', true);
    if ('' === $solution && !empty($fallback['solution'])) {
        $solution = $fallback['solution'];
    }

    $specs           = get_post_meta($post_id, '_project_specs', true);
    if ('' === $specs) {
        $specs = "Camera: RED Digital Cinema · Sony Cinema Line\nColor Pipeline: DaVinci Resolve Studio RAW Grading\nSound & Score: Bespoke Studio Sound Design & Master\nDeliverables: 4K Master, Social Reels, Still Lookbook";
    }

    $stats           = get_post_meta($post_id, '_project_stats', true);
    if (empty($stats) || !is_array($stats)) {
        $stats = !empty($fallback['stats']) ? $fallback['stats'] : array(
            array('num' => '4K RAW', 'label' => 'Cinema Camera Master'),
            array('num' => '10-DAY', 'label' => 'Turnaround Delivery'),
            array('num' => '100%',   'label' => 'In-House Production'),
            array('num' => '2.4M+',  'label' => 'Organic Social Reach'),
        );
    }

    $gallery_meta    = get_post_meta($post_id, '_project_gallery', true);
    if (is_array($gallery_meta)) {
        $gallery_text = implode("\n", $gallery_meta);
    } elseif (is_string($gallery_meta) && '' !== trim($gallery_meta)) {
        $gallery_text = $gallery_meta;
    } else {
        $gallery_text = implode("\n", array(
            mileym3dia_get_project_image_url(2),
            mileym3dia_get_project_image_url(3),
            mileym3dia_get_project_image_url(4),
        ));
    }
    ?>
    <style>
        .m3-meta-box-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-top: 10px; }
        .m3-meta-box-field { display: flex; flex-direction: column; gap: 5px; }
        .m3-meta-box-field--full { grid-column: 1 / -1; }
        .m3-meta-box-field label { font-weight: 600; color: #1d2327; }
        .m3-meta-box-field input[type="text"],
        .m3-meta-box-field input[type="url"],
        .m3-meta-box-field select,
        .m3-meta-box-field textarea { width: 100%; max-width: 100%; }
        .m3-stats-table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        .m3-stats-table th, .m3-stats-table td { padding: 6px 8px; text-align: left; border-bottom: 1px solid #e2e4e7; }
    </style>

    <div class="m3-meta-box-grid">
        <div class="m3-meta-box-field">
            <label for="_project_client"><?php esc_html_e('Client Name', 'm3-big-red'); ?></label>
            <input type="text" id="_project_client" name="_project_client" value="<?php echo esc_attr($client); ?>" placeholder="e.g. NIGHTFALL ATELIER" />
        </div>

        <div class="m3-meta-box-field">
            <label for="_project_year"><?php esc_html_e('Production Year', 'm3-big-red'); ?></label>
            <input type="text" id="_project_year" name="_project_year" value="<?php echo esc_attr($year); ?>" placeholder="e.g. 2026" />
        </div>

        <div class="m3-meta-box-field">
            <label for="_project_timeline"><?php esc_html_e('Production Timeline', 'm3-big-red'); ?></label>
            <input type="text" id="_project_timeline" name="_project_timeline" value="<?php echo esc_attr($timeline); ?>" placeholder="e.g. 4-Week Cycle" />
        </div>

        <div class="m3-meta-box-field">
            <label for="_project_services"><?php esc_html_e('Services Delivered', 'm3-big-red'); ?></label>
            <input type="text" id="_project_services" name="_project_services" value="<?php echo esc_attr($services); ?>" placeholder="e.g. Cinema Video Production / Stills / DaVinci Grade" />
        </div>

        <div class="m3-meta-box-field">
            <label for="_project_url"><?php esc_html_e('External Live Launch URL (Optional)', 'm3-big-red'); ?></label>
            <input type="url" id="_project_url" name="_project_url" value="<?php echo esc_attr($url); ?>" placeholder="https://..." />
        </div>

        <div class="m3-meta-box-field">
            <label for="_project_video_url"><?php esc_html_e('Project Video / Reel URL (MP4, YouTube, or Vimeo)', 'm3-big-red'); ?></label>
            <input type="url" id="_project_video_url" name="_project_video_url" value="<?php echo esc_attr(get_post_meta($post_id, '_project_video_url', true)); ?>" placeholder="https://youtube.com/watch?v=... or .mp4" />
        </div>

        <div class="m3-meta-box-field">
            <label for="_project_accent"><?php esc_html_e('Accent Color Override', 'm3-big-red'); ?></label>
            <select id="_project_accent" name="_project_accent">
                <option value="" <?php selected($accent, ''); ?>><?php esc_html_e('Auto (From Service Category)', 'm3-big-red'); ?></option>
                <option value="red" <?php selected($accent, 'red'); ?>><?php esc_html_e('Big Red (#FF2442)', 'm3-big-red'); ?></option>
                <option value="blue" <?php selected($accent, 'blue'); ?>><?php esc_html_e('Sky Blue (#38BDF8)', 'm3-big-red'); ?></option>
                <option value="lime" <?php selected($accent, 'lime'); ?>><?php esc_html_e('Electric Lime (#00FF7F)', 'm3-big-red'); ?></option>
                <option value="yellow" <?php selected($accent, 'yellow'); ?>><?php esc_html_e('Studio Yellow (#FFDD00)', 'm3-big-red'); ?></option>
            </select>
        </div>

        <div class="m3-meta-box-field m3-meta-box-field--full">
            <label>
                <input type="checkbox" id="_project_featured" name="_project_featured" value="1" <?php checked($featured, '1'); ?> />
                <?php esc_html_e('Featured Premiere Case Study (Highlight on Homepage Selected Work)', 'm3-big-red'); ?>
            </label>
        </div>

        <div class="m3-meta-box-field m3-meta-box-field--full">
            <label for="_project_challenge_title"><?php esc_html_e('01. Creative Challenge — Section Headline', 'm3-big-red'); ?></label>
            <input type="text" id="_project_challenge_title" name="_project_challenge_title" value="<?php echo esc_attr($challenge_title); ?>" />
        </div>

        <div class="m3-meta-box-field m3-meta-box-field--full">
            <label for="_project_challenge"><?php esc_html_e('01. Creative Challenge — Narrative Body', 'm3-big-red'); ?></label>
            <textarea id="_project_challenge" name="_project_challenge" rows="4"><?php echo esc_textarea($challenge); ?></textarea>
        </div>

        <div class="m3-meta-box-field m3-meta-box-field--full">
            <label for="_project_solution_title"><?php esc_html_e('02. Production Execution — Section Headline', 'm3-big-red'); ?></label>
            <input type="text" id="_project_solution_title" name="_project_solution_title" value="<?php echo esc_attr($solution_title); ?>" />
        </div>

        <div class="m3-meta-box-field m3-meta-box-field--full">
            <label for="_project_solution"><?php esc_html_e('02. Production Execution — Narrative Body', 'm3-big-red'); ?></label>
            <textarea id="_project_solution" name="_project_solution" rows="4"><?php echo esc_textarea($solution); ?></textarea>
        </div>

        <div class="m3-meta-box-field m3-meta-box-field--full">
            <label for="_project_specs"><?php esc_html_e('Production Rig & Pipeline Specs (One "Label: Value" line per row)', 'm3-big-red'); ?></label>
            <textarea id="_project_specs" name="_project_specs" rows="4"><?php echo esc_textarea($specs); ?></textarea>
        </div>

        <div class="m3-meta-box-field m3-meta-box-field--full">
            <label><?php esc_html_e('Production Impact Metrics (4 Stats Strip)', 'm3-big-red'); ?></label>
            <table class="m3-stats-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php esc_html_e('Metric Value (e.g. 4K RAW, 10-DAY, 2.4M+)', 'm3-big-red'); ?></th>
                        <th><?php esc_html_e('Metric Label (e.g. Cinema Camera Master)', 'm3-big-red'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < 4; $i++) :
                        $st_num   = isset($stats[$i]['num']) ? $stats[$i]['num'] : '';
                        $st_label = isset($stats[$i]['label']) ? $stats[$i]['label'] : '';
                    ?>
                        <tr>
                            <td><strong>0<?php echo (int) ($i + 1); ?></strong></td>
                            <td>
                                <input type="text" name="_project_stats[<?php echo (int) $i; ?>][num]" value="<?php echo esc_attr($st_num); ?>" />
                            </td>
                            <td>
                                <input type="text" name="_project_stats[<?php echo (int) $i; ?>][label]" value="<?php echo esc_attr($st_label); ?>" />
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>

        <div class="m3-meta-box-field m3-meta-box-field--full">
            <label for="_project_gallery"><?php esc_html_e('Case Study Gallery Frame Image URLs (One image URL per line)', 'm3-big-red'); ?></label>
            <textarea id="_project_gallery" name="_project_gallery" rows="3" placeholder="https://.../portfolio-2.jpg"><?php echo esc_textarea($gallery_text); ?></textarea>
        </div>
    </div>
    <?php
}

/**
 * Save handler for `project` CPT meta box
 *
 * @param int $post_id Project post ID.
 */
function mileym3dia_save_project_meta($post_id) {
    if (!isset($_POST['mileym3dia_project_meta_nonce'])) {
        return;
    }
    $nonce = sanitize_text_field(wp_unslash($_POST['mileym3dia_project_meta_nonce']));
    if (!wp_verify_nonce($nonce, 'mileym3dia_save_project_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (function_exists('current_user_can') && !current_user_can('edit_post', $post_id)) {
        return;
    }

    $text_fields = array(
        '_project_client',
        '_project_year',
        '_project_timeline',
        '_project_services',
        '_project_challenge_title',
        '_project_solution_title',
    );
    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field(wp_unslash($_POST[$field])));
        }
    }

    if (isset($_POST['_project_url'])) {
        update_post_meta($post_id, '_project_url', esc_url_raw(wp_unslash($_POST['_project_url'])));
    }

    $featured = !empty($_POST['_project_featured']) ? '1' : '0';
    update_post_meta($post_id, '_project_featured', $featured);

    if (isset($_POST['_project_accent'])) {
        $allowed_accents = array('', 'red', 'blue', 'lime', 'yellow');
        $accent_val      = sanitize_key(wp_unslash($_POST['_project_accent']));
        if (!in_array($accent_val, $allowed_accents, true)) {
            $accent_val = '';
        }
        update_post_meta($post_id, '_project_accent', $accent_val);
    }

    $textarea_fields = array(
        '_project_challenge',
        '_project_solution',
        '_project_specs',
    );
    foreach ($textarea_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_textarea_field(wp_unslash($_POST[$field])));
        }
    }

    if (isset($_POST['_project_stats']) && is_array($_POST['_project_stats'])) {
        $raw_stats   = wp_unslash($_POST['_project_stats']);
        $clean_stats = array();
        foreach ($raw_stats as $row) {
            if (!is_array($row)) {
                continue;
            }
            $num   = isset($row['num']) ? sanitize_text_field($row['num']) : '';
            $label = isset($row['label']) ? sanitize_text_field($row['label']) : '';
            if ('' !== $num || '' !== $label) {
                $clean_stats[] = array(
                    'num'   => $num,
                    'label' => $label,
                );
            }
        }
        if (!empty($clean_stats)) {
            update_post_meta($post_id, '_project_stats', $clean_stats);
        }
    }

    if (isset($_POST['_project_gallery'])) {
        $raw_gallery = wp_unslash($_POST['_project_gallery']);
        if (is_array($raw_gallery)) {
            $lines = $raw_gallery;
        } else {
            $lines = preg_split('/\r\n|\r|\n/', (string) $raw_gallery);
        }
        $clean_urls = array();
        foreach ($lines as $line) {
            $u = esc_url_raw(trim((string) $line));
            if (!empty($u)) {
                $clean_urls[] = $u;
            }
        }
        update_post_meta($post_id, '_project_gallery', $clean_urls);
    }

    if (isset($_POST['_project_video_url'])) {
        update_post_meta($post_id, '_project_video_url', esc_url_raw(wp_unslash($_POST['_project_video_url'])));
    }
}
add_action('save_post_project', 'mileym3dia_save_project_meta');

/**
 * Render the Service Details meta box in WP Admin
 *
 * @param WP_Post $post Current service post object.
 */
function mileym3dia_render_service_details_meta_box($post) {
    wp_nonce_field('mileym3dia_save_service_meta', 'mileym3dia_service_meta_nonce');

    $post_id       = is_object($post) && isset($post->ID) ? (int) $post->ID : 0;
    $number        = get_post_meta($post_id, '_service_number', true);
    $tag           = get_post_meta($post_id, '_service_tag', true);
    $deliverables  = get_post_meta($post_id, '_service_deliverables', true);
    $accent        = get_post_meta($post_id, '_service_accent', true) ?: 'red';
    $cta_text      = get_post_meta($post_id, '_service_cta_text', true);
    $cta_url       = get_post_meta($post_id, '_service_cta_url', true);
    $category_slug = get_post_meta($post_id, '_service_category_slug', true);

    $service_cats = function_exists('mileym3dia_get_service_project_categories')
        ? mileym3dia_get_service_project_categories()
        : array();
    ?>
    <div class="m3-meta-box-grid">
        <div class="m3-meta-box-field">
            <label for="_service_number"><?php esc_html_e('Service Number (e.g. 01..05)', 'm3-big-red'); ?></label>
            <input type="text" id="_service_number" name="_service_number" value="<?php echo esc_attr($number); ?>" placeholder="01" />
        </div>

        <div class="m3-meta-box-field">
            <label for="_service_accent"><?php esc_html_e('Brand Accent Color', 'm3-big-red'); ?></label>
            <select id="_service_accent" name="_service_accent">
                <option value="red" <?php selected($accent, 'red'); ?>><?php esc_html_e('Big Red (#FF2442)', 'm3-big-red'); ?></option>
                <option value="blue" <?php selected($accent, 'blue'); ?>><?php esc_html_e('Sky Blue (#38BDF8)', 'm3-big-red'); ?></option>
                <option value="lime" <?php selected($accent, 'lime'); ?>><?php esc_html_e('Electric Lime (#00FF7F)', 'm3-big-red'); ?></option>
                <option value="yellow" <?php selected($accent, 'yellow'); ?>><?php esc_html_e('Studio Yellow (#FFDD00)', 'm3-big-red'); ?></option>
            </select>
        </div>

        <div class="m3-meta-box-field m3-meta-box-field--full">
            <label for="_service_tag"><?php esc_html_e('Service Subtitle / Eyebrow Tag', 'm3-big-red'); ?></label>
            <input type="text" id="_service_tag" name="_service_tag" value="<?php echo esc_attr($tag); ?>" placeholder="4K / 8K CINEMA · COMMERCIALS · MUSIC VIDEOS" />
        </div>

        <div class="m3-meta-box-field m3-meta-box-field--full">
            <label for="_service_deliverables"><?php esc_html_e('Key Deliverables / Capabilities (Comma or newline separated)', 'm3-big-red'); ?></label>
            <textarea id="_service_deliverables" name="_service_deliverables" rows="3" placeholder="Commercials & Brand Films, Music Videos & Performance, Color Grading & VFX, Documentary & Aerial"><?php echo esc_textarea($deliverables); ?></textarea>
        </div>

        <div class="m3-meta-box-field">
            <label for="_service_cta_text"><?php esc_html_e('CTA Button Text', 'm3-big-red'); ?></label>
            <input type="text" id="_service_cta_text" name="_service_cta_text" value="<?php echo esc_attr($cta_text); ?>" placeholder="BOOK VIDEO PRODUCTION" />
        </div>

        <div class="m3-meta-box-field">
            <label for="_service_cta_url"><?php esc_html_e('CTA Button URL (Optional override)', 'm3-big-red'); ?></label>
            <input type="text" id="_service_cta_url" name="_service_cta_url" value="<?php echo esc_attr($cta_url); ?>" placeholder="/contact/?discipline=Video+Production" />
        </div>

        <div class="m3-meta-box-field m3-meta-box-field--full">
            <label for="_service_category_slug"><?php esc_html_e('Linked Portfolio Category (project_category)', 'm3-big-red'); ?></label>
            <select id="_service_category_slug" name="_service_category_slug">
                <option value=""><?php esc_html_e('— Select Linked Project Category —', 'm3-big-red'); ?></option>
                <?php foreach ($service_cats as $cat_slug => $cat_info) : ?>
                    <option value="<?php echo esc_attr($cat_slug); ?>" <?php selected($category_slug, $cat_slug); ?>>
                        <?php echo esc_html($cat_info['name'] . ' (' . $cat_slug . ')'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <?php
}

/**
 * Save handler for `service` CPT meta box
 *
 * @param int $post_id Service post ID.
 */
function mileym3dia_save_service_meta($post_id) {
    if (!isset($_POST['mileym3dia_service_meta_nonce'])) {
        return;
    }
    $nonce = sanitize_text_field(wp_unslash($_POST['mileym3dia_service_meta_nonce']));
    if (!wp_verify_nonce($nonce, 'mileym3dia_save_service_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (function_exists('current_user_can') && !current_user_can('edit_post', $post_id)) {
        return;
    }

    $text_fields = array(
        '_service_number',
        '_service_tag',
        '_service_cta_text',
        '_service_category_slug',
    );
    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field(wp_unslash($_POST[$field])));
        }
    }

    if (isset($_POST['_service_deliverables'])) {
        update_post_meta($post_id, '_service_deliverables', sanitize_textarea_field(wp_unslash($_POST['_service_deliverables'])));
    }

    if (isset($_POST['_service_accent'])) {
        $allowed = array('red', 'blue', 'lime', 'yellow');
        $acc     = sanitize_key(wp_unslash($_POST['_service_accent']));
        if (!in_array($acc, $allowed, true)) {
            $acc = 'red';
        }
        update_post_meta($post_id, '_service_accent', $acc);
    }

    if (isset($_POST['_service_cta_url'])) {
        update_post_meta($post_id, '_service_cta_url', esc_url_raw(wp_unslash($_POST['_service_cta_url'])));
    }
}
add_action('save_post_service', 'mileym3dia_save_service_meta');

/**
 * Render the Resource Library Details meta box in WP Admin (`m3_resource` CPT)
 *
 * @param WP_Post $post Current resource post object.
 */
function mileym3dia_render_resource_details_meta_box($post) {
    wp_nonce_field('mileym3dia_save_resource_meta', 'mileym3dia_resource_meta_nonce');

    $post_id        = is_object($post) && isset($post->ID) ? (int) $post->ID : 0;
    $type           = get_post_meta($post_id, '_m3_resource_type', true) ?: 'download';
    $access         = get_post_meta($post_id, '_m3_resource_access', true) ?: 'free';
    $url            = get_post_meta($post_id, '_m3_resource_url', true);
    $format         = get_post_meta($post_id, '_m3_resource_format', true);
    $compatibility  = get_post_meta($post_id, '_m3_resource_compatibility', true);
    $accent         = get_post_meta($post_id, '_m3_resource_accent', true) ?: 'blue';
    $badge          = get_post_meta($post_id, '_m3_resource_badge', true);
    $btn_text       = get_post_meta($post_id, '_m3_resource_btn_text', true);
    $affiliate_code = get_post_meta($post_id, '_m3_resource_affiliate_code', true);
    ?>
    <div class="m3-meta-box-grid">
        <div class="m3-meta-box-field">
            <label for="_m3_resource_type"><?php esc_html_e('Resource Type', 'm3-big-red'); ?></label>
            <select id="_m3_resource_type" name="_m3_resource_type">
                <option value="download" <?php selected($type, 'download'); ?>><?php esc_html_e('Downloadable File (.CUBE, .ZIP, .PDF, .TXT)', 'm3-big-red'); ?></option>
                <option value="tool" <?php selected($type, 'tool'); ?>><?php esc_html_e('Free Tool / Software', 'm3-big-red'); ?></option>
                <option value="tutorial" <?php selected($type, 'tutorial'); ?>><?php esc_html_e('Tutorial / Guide', 'm3-big-red'); ?></option>
                <option value="link" <?php selected($type, 'link'); ?>><?php esc_html_e('Curated Reference Link', 'm3-big-red'); ?></option>
                <option value="affiliate" <?php selected($type, 'affiliate'); ?>><?php esc_html_e('Affiliate / Partner Deal', 'm3-big-red'); ?></option>
            </select>
        </div>

        <div class="m3-meta-box-field">
            <label for="_m3_resource_access"><?php esc_html_e('Access Tier (Creator Hub Gating)', 'm3-big-red'); ?></label>
            <select id="_m3_resource_access" name="_m3_resource_access">
                <option value="free" <?php selected($access, 'free'); ?>><?php esc_html_e('Free Public Access', 'm3-big-red'); ?></option>
                <option value="member" <?php selected($access, 'member'); ?>><?php esc_html_e('Free Creator Hub Member (Login Required)', 'm3-big-red'); ?></option>
                <option value="pro" <?php selected($access, 'pro'); ?>><?php esc_html_e('Creator Hub Pro Tier (Paid Upgrade)', 'm3-big-red'); ?></option>
            </select>
        </div>

        <div class="m3-meta-box-field m3-meta-box-field--full">
            <label for="_m3_resource_url"><?php esc_html_e('Target File URL or External Resource Link', 'm3-big-red'); ?></label>
            <input type="url" id="_m3_resource_url" name="_m3_resource_url" value="<?php echo esc_attr($url); ?>" placeholder="https://... or Media Library file URL" />
        </div>

        <div class="m3-meta-box-field">
            <label for="_m3_resource_badge"><?php esc_html_e('Card Badge Text', 'm3-big-red'); ?></label>
            <input type="text" id="_m3_resource_badge" name="_m3_resource_badge" value="<?php echo esc_attr($badge); ?>" placeholder="COLOR GRADING / FREE TOOL / PARTNER DEAL" />
        </div>

        <div class="m3-meta-box-field">
            <label for="_m3_resource_accent"><?php esc_html_e('Card Accent Color', 'm3-big-red'); ?></label>
            <select id="_m3_resource_accent" name="_m3_resource_accent">
                <option value="blue" <?php selected($accent, 'blue'); ?>><?php esc_html_e('Sky Blue (#38BDF8)', 'm3-big-red'); ?></option>
                <option value="yellow" <?php selected($accent, 'yellow'); ?>><?php esc_html_e('Studio Yellow (#FFDD00)', 'm3-big-red'); ?></option>
                <option value="lime" <?php selected($accent, 'lime'); ?>><?php esc_html_e('Electric Lime (#00FF7F)', 'm3-big-red'); ?></option>
                <option value="red" <?php selected($accent, 'red'); ?>><?php esc_html_e('Big Red (#FF2442)', 'm3-big-red'); ?></option>
            </select>
        </div>

        <div class="m3-meta-box-field">
            <label for="_m3_resource_format"><?php esc_html_e('Format / Platform Spec', 'm3-big-red'); ?></label>
            <input type="text" id="_m3_resource_format" name="_m3_resource_format" value="<?php echo esc_attr($format); ?>" placeholder=".CUBE / Web / macOS & Windows" />
        </div>

        <div class="m3-meta-box-field">
            <label for="_m3_resource_compatibility"><?php esc_html_e('Compatibility / License', 'm3-big-red'); ?></label>
            <input type="text" id="_m3_resource_compatibility" name="_m3_resource_compatibility" value="<?php echo esc_attr($compatibility); ?>" placeholder="DaVinci Resolve, Premiere, Commercial Use" />
        </div>

        <div class="m3-meta-box-field">
            <label for="_m3_resource_btn_text"><?php esc_html_e('Button Label', 'm3-big-red'); ?></label>
            <input type="text" id="_m3_resource_btn_text" name="_m3_resource_btn_text" value="<?php echo esc_attr($btn_text); ?>" placeholder="DOWNLOAD PACK / LAUNCH TOOL" />
        </div>

        <div class="m3-meta-box-field">
            <label for="_m3_resource_affiliate_code"><?php esc_html_e('Partner / Affiliate Promo Code (Optional)', 'm3-big-red'); ?></label>
            <input type="text" id="_m3_resource_affiliate_code" name="_m3_resource_affiliate_code" value="<?php echo esc_attr($affiliate_code); ?>" placeholder="e.g. M3STUDIO2MO" />
        </div>
    </div>
    <?php
}

/**
 * Save handler for `m3_resource` CPT meta box
 *
 * @param int $post_id Resource post ID.
 */
function mileym3dia_save_resource_meta($post_id) {
    if (!isset($_POST['mileym3dia_resource_meta_nonce'])) {
        return;
    }
    $nonce = sanitize_text_field(wp_unslash($_POST['mileym3dia_resource_meta_nonce']));
    if (!wp_verify_nonce($nonce, 'mileym3dia_save_resource_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (function_exists('current_user_can') && !current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['_m3_resource_type'])) {
        $allowed_types = array('download', 'tool', 'tutorial', 'link', 'affiliate');
        $val           = sanitize_key(wp_unslash($_POST['_m3_resource_type']));
        update_post_meta($post_id, '_m3_resource_type', in_array($val, $allowed_types, true) ? $val : 'download');
    }

    if (isset($_POST['_m3_resource_access'])) {
        $allowed_access = array('free', 'member', 'pro');
        $val            = sanitize_key(wp_unslash($_POST['_m3_resource_access']));
        update_post_meta($post_id, '_m3_resource_access', in_array($val, $allowed_access, true) ? $val : 'free');
    }

    if (isset($_POST['_m3_resource_accent'])) {
        $allowed_accents = array('blue', 'yellow', 'lime', 'red');
        $val             = sanitize_key(wp_unslash($_POST['_m3_resource_accent']));
        update_post_meta($post_id, '_m3_resource_accent', in_array($val, $allowed_accents, true) ? $val : 'blue');
    }

    if (isset($_POST['_m3_resource_url'])) {
        update_post_meta($post_id, '_m3_resource_url', esc_url_raw(wp_unslash($_POST['_m3_resource_url'])));
    }

    $text_fields = array(
        '_m3_resource_format',
        '_m3_resource_compatibility',
        '_m3_resource_badge',
        '_m3_resource_btn_text',
        '_m3_resource_affiliate_code',
    );
    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field(wp_unslash($_POST[$field])));
        }
    }
}
add_action('save_post_m3_resource', 'mileym3dia_save_resource_meta');

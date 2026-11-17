<?php
/**
 * WordPress Runtime Shim & Router for MILEYM3DIA Theme Preview
 */

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$decoded_uri = urldecode($uri);

// Serve static assets directly when running under php -S
if ($decoded_uri !== '/' && file_exists(__DIR__ . $decoded_uri) && !is_dir(__DIR__ . $decoded_uri) && pathinfo($decoded_uri, PATHINFO_EXTENSION) !== 'php') {
    return false;
}

define('ABSPATH', __DIR__ . '/');
if (!defined('OBJECT')) define('OBJECT', 'OBJECT');
if (!defined('ARRAY_A')) define('ARRAY_A', 'ARRAY_A');
if (!defined('ARRAY_N')) define('ARRAY_N', 'ARRAY_N');
$_SERVER['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Base classes needed by the theme
if (!class_exists('Walker_Nav_Menu')) {
    class Walker_Nav_Menu {
        public function walk($elements, $max_depth, ...$args) {
            return '';
        }
        public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {}
        public function start_lvl(&$output, $depth = 0, $args = null) {}
    }
}
if (!class_exists('WP_Customize_Control')) {
    class WP_Customize_Control {
        public function __construct(...$args) {}
    }
    class WP_Customize_Color_Control extends WP_Customize_Control {}
    class WP_Customize_Image_Control extends WP_Customize_Control {}
    class WP_Customize_Upload_Control extends WP_Customize_Control {}
}

// Sample Blog Posts & Projects
$GLOBALS['m3_categories'] = [
    1 => (object)['term_id' => 1, 'name' => 'Video Production', 'slug' => 'video-production', 'count' => 4],
    2 => (object)['term_id' => 2, 'name' => 'Photography', 'slug' => 'photography', 'count' => 5],
    3 => (object)['term_id' => 3, 'name' => 'Branding & Web', 'slug' => 'branding-web', 'count' => 4],
    4 => (object)['term_id' => 4, 'name' => 'Music & Audio', 'slug' => 'music-audio', 'count' => 3],
];

$GLOBALS['m3_tags'] = [
    (object)['term_id' => 10, 'name' => 'CINEMATOGRAPHY', 'slug' => 'cinematography'],
    (object)['term_id' => 11, 'name' => 'COLOR-GRADING', 'slug' => 'color-grading'],
    (object)['term_id' => 12, 'name' => 'BRAND-IDENTITY', 'slug' => 'brand-identity'],
    (object)['term_id' => 13, 'name' => 'PHOTOGRAPHY', 'slug' => 'photography'],
    (object)['term_id' => 14, 'name' => 'WEB-DESIGN', 'slug' => 'web-design'],
    (object)['term_id' => 15, 'name' => 'AUDIO-PRODUCTION', 'slug' => 'audio-production'],
];

$GLOBALS['m3_posts'] = [
    101 => (object)[
        'ID' => 101,
        'post_title' => 'Lighting & Lens Selection for High-Impact Commercial and Music Video Shoots',
        'post_name' => 'lighting-lens-selection-commercial-music-videos',
        'post_status' => 'publish',
        'post_type' => 'post',
        'post_author' => 1,
        'post_date' => '2026-10-28 14:00:00',
        'post_excerpt' => 'How pairing cinema prime lenses with intentional key-to-fill lighting ratios elevates brand commercials and music videos on location.',
        'post_content' => '<p>Great video production starts long before the camera rolls. Choosing the right lens focal lengths and shaping practical lighting on location sets the emotional tone of a commercial or music video from the very first frame.</p><h2>Why Cinema Glass Matters</h2><p>On recent campaign shoots, our camera team paired fast cinema primes with soft directional LED fixtures to maintain natural skin tones while preserving deep shadow contrast.</p><blockquote>"Intentional lighting and composition turn a simple location into a memorable visual story."</blockquote><h3>Locking Visual Pacing to the Audio Edit</h3><p>By planning camera movement alongside the music mix and sound design in pre-production, every cut in the editing suite feels seamless and purposeful.</p>',
        'thumbnail' => '/assets/images/blog-1.jpg?v=2.3.0',
        'caption' => 'ON LOCATION — COMMERCIAL & MUSIC VIDEO PRODUCTION',
        'categories' => [$GLOBALS['m3_categories'][1], $GLOBALS['m3_categories'][2]],
        'tags' => [$GLOBALS['m3_tags'][0], $GLOBALS['m3_tags'][1]],
    ],
    102 => (object)[
        'ID' => 102,
        'post_title' => 'Building a Cohesive Visual Identity Across Video, Photography, Print, and Web',
        'post_name' => 'building-cohesive-visual-identity-video-photo-web',
        'post_status' => 'publish',
        'post_type' => 'post',
        'post_author' => 1,
        'post_date' => '2026-10-14 11:30:00',
        'post_excerpt' => 'A practical breakdown of how we align logo systems, color palettes, lookbook photography, and custom web design for growing brands and recording artists.',
        'post_content' => '<p>When a business or recording artist launches a new campaign, consistency across every touchpoint is what builds lasting recognition. At MILEYM3DIA, our branding, photography, video, and web teams work from a shared creative brief.</p><h2>From Brand Guidelines to Live Website</h2><p>By defining typography, color tokens, and photographic direction early on, every deliverable—from the hero film and product photos to the e-commerce website—looks and feels unified.</p>',
        'thumbnail' => '/assets/images/blog-2.jpg?v=2.3.0',
        'caption' => 'BRAND IDENTITY & WEB DESIGN WORKFLOW',
        'categories' => [$GLOBALS['m3_categories'][3]],
        'tags' => [$GLOBALS['m3_tags'][2], $GLOBALS['m3_tags'][4]],
    ],
    103 => (object)[
        'ID' => 103,
        'post_title' => 'DaVinci Resolve Color Grading Workflow: Creating Rich Film Contrast for Brand Campaigns',
        'post_name' => 'davinci-resolve-color-grading-workflow-brand-campaigns',
        'post_status' => 'publish',
        'post_type' => 'post',
        'post_author' => 1,
        'post_date' => '2026-09-29 09:15:00',
        'post_excerpt' => 'Inside our color grading pipeline for balancing multiple camera angles, preserving highlight roll-off, and delivering consistent masters for broadcast and social.',
        'post_content' => '<p>Color grading is the final step that gives commercial and music video footage its signature look. Working in DaVinci Wide Gamut allows us to match cameras cleanly and craft film-inspired color palettes.</p>',
        'thumbnail' => '/assets/images/blog-3.jpg?v=2.3.0',
        'caption' => 'COLOR GRADING SUITE — DAVINCI RESOLVE STUDIO',
        'categories' => [$GLOBALS['m3_categories'][1]],
        'tags' => [$GLOBALS['m3_tags'][1]],
    ],
];

$GLOBALS['m3_projects'] = [
    201 => (object)[
        'ID' => 201,
        'post_title' => 'NIGHTFALL APPAREL CAMPAIGN',
        'post_name' => 'nightfall-apparel-campaign',
        'post_status' => 'publish',
        'post_type' => 'project',
        'post_author' => 1,
        'post_date' => '2026-10-20 12:00:00',
        'post_excerpt' => 'Full commercial video production, street lookbook photography, and social campaign rollout for Nightfall Atelier.',
        'post_content' => '<p>Shot on location over four nights, the Nightfall campaign combines cinema camera movement, editorial lookbook photography, and custom sound design for a multi-platform brand launch.</p>',
        'thumbnail' => '/assets/images/portfolio-1.jpg?v=2.3.0',
        'meta' => [
            '_project_year' => '2026',
            '_project_client' => 'NIGHTFALL ATELIER',
            '_project_services' => 'Cinema Video Production / Stills / DaVinci Grade',
            '_project_url' => '',
            '_project_challenge' => 'Nightfall Atelier required an unmistakable, high-tension nocturnal campaign for their Winter 2026 technical outerwear capsule. The aesthetic directive required authentic rainy neon city streets, high-speed movement, and cinema-grade lighting without appearing clinical or commercialized.',
            '_project_solution' => 'Filmed entirely over four consecutive overnight shoots using RED V-Raptor and Sony FX6 packages paired with vintage Cooke anamorphic glass. We engineered a proprietary DaVinci Resolve color pipeline that preserved shadow detail while making neon reds and cyans explode off the screen.',
            '_project_stats' => [
                ['num' => '4K RAW', 'label' => 'Cinema Camera Master'],
                ['num' => '10-DAY', 'label' => 'Turnaround Delivery'],
                ['num' => '100%', 'label' => 'In-House Production'],
                ['num' => '2.4M+', 'label' => 'Organic Social Reach'],
            ],
        ],
        'terms' => [(object)['term_id' => 30, 'name' => 'Video Production & Lookbook', 'slug' => 'video']],
    ],
    202 => (object)[
        'ID' => 202,
        'post_title' => 'STATIC FREQUENCY TOUR & VISUALS',
        'post_name' => 'static-frequency-tour-visuals',
        'post_status' => 'publish',
        'post_type' => 'project',
        'post_author' => 1,
        'post_date' => '2026-09-18 12:00:00',
        'post_excerpt' => 'Music video direction, custom live tour visuals, and surround audio mastering for independent recording artist Static Frequency.',
        'post_content' => '<p>Produced end-to-end by MILEYM3DIA, including music video production, tour visual packages, and studio audio mastering.</p>',
        'thumbnail' => '/assets/images/portfolio-2.jpg?v=2.3.0',
        'meta' => [
            '_project_year' => '2026',
            '_project_client' => 'STATIC FREQUENCY',
            '_project_services' => 'Music Video / Audio Production / Live Tour Visuals',
            '_project_url' => '',
            '_project_challenge' => 'Static Frequency needed an immersive visual world to accompany their 18-city headline tour and lead single release. The challenge was syncing 4K stage visuals to MIDI timecode while delivering a cinematic music video with authentic studio audio fidelity.',
            '_project_solution' => 'MILEYM3DIA built a multi-discipline pipeline: tracking 120fps high-speed camera footage, developing custom generative tour visual loops synced to audio triggers, and executing final Dolby Atmos stereo mix and mastering in our audio suite.',
            '_project_stats' => [
                ['num' => '18-CITY', 'label' => 'Headline Tour Visuals'],
                ['num' => '96kHz/24b', 'label' => 'Master Audio Fidelity'],
                ['num' => '100%', 'label' => 'Sync to MIDI Stage Rig'],
                ['num' => '850K+', 'label' => 'Single Stream Plays'],
            ],
        ],
        'terms' => [(object)['term_id' => 31, 'name' => 'Music Video & Audio', 'slug' => 'audio']],
    ],
    203 => (object)[
        'ID' => 203,
        'post_title' => 'MONOLITH AUDIO HARDWARE',
        'post_name' => 'monolith-audio-hardware',
        'post_status' => 'publish',
        'post_type' => 'project',
        'post_author' => 1,
        'post_date' => '2026-08-05 12:00:00',
        'post_excerpt' => 'Complete visual identity, custom typography, packaging design, and e-commerce web design for Monolith Labs.',
        'post_content' => '<p>Full brand identity system, product photography, packaging design, and custom e-commerce website built for Monolith Labs.</p>',
        'thumbnail' => '/assets/images/portfolio-3.jpg?v=2.3.0',
        'meta' => [
            '_project_year' => '2025',
            '_project_client' => 'MONOLITH LABS',
            '_project_services' => 'Brand Identity / Web Design / Packaging System',
            '_project_url' => '',
            '_project_challenge' => 'Monolith Labs engineered a premium studio monitor controller for professional audio producers and needed a visual identity and digital storefront that commanded a $1,200 retail price tag with absolute credibility.',
            '_project_solution' => 'We crafted a brutalist industrial brand system: custom wordmark typography, matte-black unboxing packaging with foil accents, studio macro product photography, and a lightning-fast responsive web store with 3D product previews.',
            '_project_stats' => [
                ['num' => '100%', 'label' => 'Sold Out Initial Run'],
                ['num' => '0.8s', 'label' => 'E-Commerce Page Speed'],
                ['num' => '32-ASSET', 'label' => 'Complete Brand Identity'],
                ['num' => '$420K+', 'label' => 'Launch Month Revenue'],
            ],
        ],
        'terms' => [(object)['term_id' => 32, 'name' => 'Brand Identity & Web Design', 'slug' => 'branding']],
    ],
    204 => (object)[
        'ID' => 204,
        'post_title' => 'APEX MOTORSPORT IDENTITY',
        'post_name' => 'apex-motorsport-identity',
        'post_status' => 'publish',
        'post_type' => 'project',
        'post_author' => 1,
        'post_date' => '2026-07-11 12:00:00',
        'post_excerpt' => 'Custom brand identity system, team apparel graphics, and trackside photography for Apex Racing.',
        'post_content' => '<p>Complete visual identity, vehicle livery design, apparel graphics, and high-speed trackside photography for Apex Racing Co.</p>',
        'thumbnail' => '/assets/images/portfolio-4.jpg?v=2.3.0',
        'meta' => [
            '_project_year' => '2025',
            '_project_client' => 'APEX RACING CO.',
            '_project_services' => 'Branding / Photography / Apparel Graphics',
            '_project_url' => '',
            '_project_challenge' => 'Apex Racing needed a high-octane visual refresh for their GT3 racing campaign, requiring vehicle liveries, paddock team kits, merchandise designs, and dynamic trackside imagery that captured blistering speeds under changing track conditions.',
            '_project_solution' => 'Our team designed full 3M wrap liveries, engineered a streetwear-inspired apparel line, and deployed trackside with high-speed telephoto setups to capture race-day drama, pit stops, and high-contrast motion blur.',
            '_project_stats' => [
                ['num' => '1/8000s', 'label' => 'High-Speed Action Stills'],
                ['num' => 'GT3', 'label' => 'Full Livery Vehicle Wrap'],
                ['num' => '14-PIECE', 'label' => 'Apparel & Paddock Line'],
                ['num' => '4.2M+', 'label' => 'Season Impressions'],
            ],
        ],
        'terms' => [(object)['term_id' => 33, 'name' => 'Branding & Photography', 'slug' => 'photo']],
    ],
];

// Route determination
$clean_path = trim($decoded_uri, '/');
$GLOBALS['m3_route'] = [
    'is_front_page' => ($clean_path === ''),
    'is_home' => ($clean_path === 'blog' || $clean_path === 'journal'),
    'is_page' => false,
    'page_slug' => '',
    'page_template' => '',
    'is_singular' => false,
    'singular_type' => '',
    'is_archive' => false,
    'is_post_type_archive' => false,
    'is_search' => isset($_GET['s']) || $clean_path === 'search',
    'is_404' => false,
];

$template_to_load = __DIR__ . '/front-page.php';

if ($GLOBALS['m3_route']['is_search']) {
    $GLOBALS['m3_route']['is_front_page'] = false;
    $GLOBALS['m3_Current_Posts'] = array_values($GLOBALS['m3_posts']);
    $template_to_load = __DIR__ . '/search.php';
} elseif ($clean_path === '') {
    $GLOBALS['m3_Current_Posts'] = array_values($GLOBALS['m3_posts']);
    $template_to_load = __DIR__ . '/front-page.php';
} elseif (in_array($clean_path, ['about', 'services', 'portfolio', 'work', 'store', 'shop', 'resources', 'contact', 'creator-hub', 'privacy-terms', 'privacy', 'terms'], true)) {
    $GLOBALS['m3_route']['is_page'] = true;
    $GLOBALS['m3_route']['is_singular'] = true;
    $GLOBALS['m3_route']['singular_type'] = 'page';
    $tpl_slug = $clean_path;
    if ($clean_path === 'work') $tpl_slug = 'portfolio';
    if ($clean_path === 'shop') $tpl_slug = 'store';
    if ($clean_path === 'privacy' || $clean_path === 'terms') $tpl_slug = 'privacy-terms';
    $GLOBALS['m3_route']['page_slug'] = $tpl_slug;
    $GLOBALS['m3_route']['page_template'] = 'page-' . $tpl_slug . '.php';
    $GLOBALS['m3_Current_Posts'] = [
        (object)[
            'ID' => 50,
            'post_title' => strtoupper(str_replace('-', ' ', $clean_path)),
            'post_name' => $clean_path,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1,
            'post_date' => '2026-09-10 12:00:00',
            'post_excerpt' => '',
            'post_content' => '',
        ]
    ];
    $template_to_load = __DIR__ . '/page-' . $tpl_slug . '.php';
} elseif ($clean_path === 'blog' || $clean_path === 'journal') {
    $GLOBALS['m3_Current_Posts'] = array_values($GLOBALS['m3_posts']);
    $template_to_load = __DIR__ . '/home.php';
} elseif (strpos($clean_path, 'dispatch/') === 0 || strpos($clean_path, 'blog/') === 0) {
    $slug = basename($clean_path);
    $found = null;
    foreach ($GLOBALS['m3_posts'] as $p) {
        if ($p->post_name === $slug || (string)$p->ID === $slug) {
            $found = $p;
            break;
        }
    }
    if (!$found) {
        $found = reset($GLOBALS['m3_posts']);
    }
    $GLOBALS['m3_route']['is_singular'] = true;
    $GLOBALS['m3_route']['singular_type'] = 'post';
    $GLOBALS['m3_Current_Posts'] = [$found];
    $template_to_load = __DIR__ . '/single.php';
} elseif (strpos($clean_path, 'project/') === 0) {
    $slug = basename($clean_path);
    $found = null;
    foreach ($GLOBALS['m3_projects'] as $p) {
        if ($p->post_name === $slug || (string)$p->ID === $slug) {
            $found = $p;
            break;
        }
    }
    if (!$found) {
        $found = reset($GLOBALS['m3_projects']);
    }
    $GLOBALS['m3_route']['is_singular'] = true;
    $GLOBALS['m3_route']['singular_type'] = 'project';
    $GLOBALS['m3_Current_Posts'] = [$found];
    $template_to_load = __DIR__ . '/single-project.php';
} elseif (strpos($clean_path, 'category/') === 0 || strpos($clean_path, 'tag/') === 0) {
    $GLOBALS['m3_route']['is_archive'] = true;
    $GLOBALS['m3_Current_Posts'] = array_values($GLOBALS['m3_posts']);
    $template_to_load = __DIR__ . '/archive.php';
} else {
    $GLOBALS['m3_route']['is_404'] = true;
    $GLOBALS['m3_Current_Posts'] = [];
    http_response_code(404);
    $template_to_load = __DIR__ . '/404.php';
}

class WP_Query {
    public $posts = [];
    public $post_count = 0;
    public $found_posts = 0;
    public $current_post = -1;
    public $post = null;
    public $max_num_pages = 1;

    public function __construct($args = []) {
        $post_type = $args['post_type'] ?? 'post';
        if ($post_type === 'project') {
            $pool = array_values($GLOBALS['m3_projects']);
        } elseif (is_array($args) && !empty($args)) {
            $pool = array_values($GLOBALS['m3_posts']);
            if (!empty($args['post__not_in'])) {
                $pool = array_values(array_filter($pool, fn($p) => !in_array($p->ID, (array)$args['post__not_in'])));
            }
            if (!empty($args['posts_per_page']) && $args['posts_per_page'] > 0) {
                $pool = array_slice($pool, 0, (int)$args['posts_per_page']);
            }
        } else {
            $pool = $GLOBALS['m3_Current_Posts'] ?? array_values($GLOBALS['m3_posts']);
        }
        $this->posts = $pool;
        $this->post_count = count($pool);
        $this->found_posts = count($pool);
        if ($this->post_count > 0) {
            $this->post = $this->posts[0];
        }
    }

    public function have_posts() {
        return ($this->current_post + 1) < $this->post_count;
    }

    public function the_post() {
        $this->current_post++;
        $this->post = $this->posts[$this->current_post] ?? null;
        $GLOBALS['post'] = $this->post;
    }
}

$GLOBALS['wp_query'] = new WP_Query();
$GLOBALS['post'] = $GLOBALS['wp_query']->post;
$GLOBALS['m3_actions'] = [];
$GLOBALS['m3_filters'] = [];
$GLOBALS['m3_styles'] = [];
$GLOBALS['m3_inline_styles'] = [];
$GLOBALS['m3_scripts'] = [];

// Core WordPress Functions Shim
function __($text, $domain = 'default') { return $text; }
function _e($text, $domain = 'default') { echo $text; }
function _n($single, $plural, $number, $domain = 'default') { return $number == 1 ? $single : $plural; }
function esc_html($text) { return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8'); }
function esc_html__($text, $domain = 'default') { return esc_html($text); }
function esc_html_e($text, $domain = 'default') { echo esc_html($text); }
function esc_attr($text) { return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8'); }
function esc_attr__($text, $domain = 'default') { return esc_attr($text); }
function esc_attr_e($text, $domain = 'default') { echo esc_attr($text); }
function esc_url($url) { return htmlspecialchars((string)$url, ENT_QUOTES, 'UTF-8'); }
function esc_js($text) { return addslashes((string)$text); }
function wp_kses($string, $allowed_html = []) { return (string)$string; }
function wp_kses_post($string) { return (string)$string; }
function absint($maybeint) { return abs((int)$maybeint); }
function sanitize_hex_color($color) { return preg_match('/^#([A-Fa-f0-9]{3}){1,2}$/', (string)$color) ? $color : ''; }
function sanitize_html_class($class, $fallback = '') { return preg_replace('/[^A-Za-z0-9_-]/', '', (string)$class) ?: $fallback; }
function sanitize_text_field($str) { return trim(strip_tags((string)$str)); }
function sanitize_textarea_field($str) { return trim(strip_tags((string)$str)); }
function sanitize_email($email) { return filter_var($email, FILTER_SANITIZE_EMAIL); }
function is_email($email) { return (bool)filter_var($email, FILTER_VALIDATE_EMAIL); }
function number_format_i18n($number, $decimals = 0) { return number_format((float)$number, $decimals); }
function is_wp_error($thing) { return false; }

function wp_parse_args($args, $defaults = []) {
    if (is_object($args)) $args = get_object_vars($args);
    elseif (!is_array($args)) parse_str((string)$args, $args);
    return array_merge($defaults, $args);
}

function add_query_arg($key, $value = '', $url = '') {
    if (is_array($key)) {
        $base = $value ?: ($_SERVER['REQUEST_URI'] ?? '/');
        $sep = (strpos($base, '?') === false) ? '?' : '&';
        return $base . $sep . http_build_query($key);
    }
    $base = $url ?: ($_SERVER['REQUEST_URI'] ?? '/');
    $sep = (strpos($base, '?') === false) ? '?' : '&';
    return $base . $sep . urlencode($key) . '=' . urlencode($value);
}

function get_template_directory() { return __DIR__; }
function get_template_directory_uri() { return ''; }
function get_stylesheet_uri() { return '/style.css'; }
function home_url($path = '/') {
    $p = '/' . ltrim((string)$path, '/');
    return $p;
}

function language_attributes() { echo 'lang="en-US"'; }
function bloginfo($show = '') { echo get_bloginfo($show); }
function get_bloginfo($show = '') {
    switch ($show) {
        case 'charset': return 'UTF-8';
        case 'name': return 'MILEYM3DIA';
        case 'description': return 'Art-directed creative media studio operating at the intersection of music, design, and digital art.';
        default: return 'MILEYM3DIA';
    }
}

function get_theme_mod($name, $default = false) {
    return $default;
}
function get_option($option, $default = false) { return $default; }

function add_action($tag, $callback, $priority = 10, $accepted_args = 1) {
    $GLOBALS['m3_actions'][$tag][] = $callback;
}
function remove_action($tag, $callback, $priority = 10) {}
function do_action($tag, ...$args) {
    if (!empty($GLOBALS['m3_actions'][$tag])) {
        foreach ($GLOBALS['m3_actions'][$tag] as $cb) {
            if (is_callable($cb)) call_user_func_array($cb, $args);
        }
    }
}
function add_filter($tag, $callback, $priority = 10, $accepted_args = 1) {
    $GLOBALS['m3_filters'][$tag][] = $callback;
}
function apply_filters($tag, $value, ...$args) {
    if (!empty($GLOBALS['m3_filters'][$tag])) {
        foreach ($GLOBALS['m3_filters'][$tag] as $cb) {
            if (is_callable($cb)) {
                $value = call_user_func_array($cb, array_merge([$value], $args));
            }
        }
    }
    return $value;
}

function add_theme_support($feature, ...$args) {}
function add_editor_style($stylesheet = 'editor-style.css') {}
function register_nav_menus($locations = []) {}
function register_sidebar($args = []) {}
function set_post_thumbnail_size($width = 0, $height = 0, $crop = false) {}
function add_image_size($name, $width = 0, $height = 0, $crop = false) {}

function wp_enqueue_style($handle, $src = '', $deps = [], $ver = false, $media = 'all') {
    if ($src) {
        if ($ver && strpos($src, 'googleapis.com') === false) {
            $sep = (strpos($src, '?') === false) ? '?' : '&';
            $src .= $sep . 'ver=' . rawurlencode((string)$ver);
        }
        $GLOBALS['m3_styles'][$handle] = $src;
    }
}
function wp_add_inline_style($handle, $data) {
    $GLOBALS['m3_inline_styles'][$handle][] = $data;
}
function wp_enqueue_script($handle, $src = '', $deps = [], $ver = false, $in_footer = false) {
    if ($src) {
        if ($ver) {
            $sep = (strpos($src, '?') === false) ? '?' : '&';
            $src .= $sep . 'ver=' . rawurlencode((string)$ver);
        }
        $GLOBALS['m3_scripts'][$handle] = ['src' => $src, 'in_footer' => $in_footer];
    }
}

function wp_head() {
    do_action('wp_enqueue_scripts');
    echo '<title>MILEYM3DIA — Creative Media Studio</title>' . "\n";
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin="anonymous">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">' . "\n";
    foreach ($GLOBALS['m3_styles'] as $handle => $src) {
        echo '<link rel="stylesheet" id="' . esc_attr($handle) . '-css" href="' . esc_url($src) . '" media="all" />' . "\n";
        if (!empty($GLOBALS['m3_inline_styles'][$handle])) {
            echo '<style id="' . esc_attr($handle) . '-inline-css">' . implode("\n", $GLOBALS['m3_inline_styles'][$handle]) . '</style>' . "\n";
        }
    }
    foreach ($GLOBALS['m3_scripts'] as $handle => $info) {
        if (!$info['in_footer']) {
            echo '<script id="' . esc_attr($handle) . '-js" src="' . esc_url($info['src']) . '"></script>' . "\n";
        }
    }
}

function wp_body_open() { do_action('wp_body_open'); }

function wp_footer() {
    foreach ($GLOBALS['m3_scripts'] as $handle => $info) {
        if ($info['in_footer']) {
            $tag = '<script id="' . esc_attr($handle) . '-js" src="' . esc_url($info['src']) . '"></script>';
            $tag = apply_filters('script_loader_tag', $tag, $handle, $info['src']);
            echo $tag . "\n";
        }
    }
    do_action('wp_footer');
}

function is_front_page() { return (bool)$GLOBALS['m3_route']['is_front_page']; }
function is_home() { return (bool)$GLOBALS['m3_route']['is_home']; }
function is_singular($post_types = '') {
    if (!$GLOBALS['m3_route']['is_singular']) return false;
    if (empty($post_types)) return true;
    return in_array($GLOBALS['m3_route']['singular_type'], (array)$post_types, true);
}
function is_page($page = '') {
    if (!$GLOBALS['m3_route']['is_page']) return false;
    if (empty($page)) return true;
    $slug = $GLOBALS['m3_route']['page_slug'];
    if ($page === 'work' && $slug === 'portfolio') return true;
    return in_array($slug, (array)$page, true);
}
function is_page_template($template = '') {
    if (!$GLOBALS['m3_route']['is_page']) return false;
    if (empty($template)) return !empty($GLOBALS['m3_route']['page_template']);
    return in_array($GLOBALS['m3_route']['page_template'], (array)$template, true);
}
function is_archive() { return (bool)$GLOBALS['m3_route']['is_archive']; }
function is_post_type_archive($post_types = '') { return (bool)$GLOBALS['m3_route']['is_post_type_archive']; }
function is_category($category = '') { return false; }
function is_tag($tag = '') { return false; }
function is_author($author = '') { return false; }
function is_search() { return (bool)$GLOBALS['m3_route']['is_search']; }
function is_404() { return (bool)$GLOBALS['m3_route']['is_404']; }
function is_user_logged_in() { return false; }
function is_active_sidebar($index) { return false; }
function dynamic_sidebar($index = 1) { return false; }
function has_custom_logo() { return false; }
function the_custom_logo() {}
function has_nav_menu($location) { return false; }
function wp_nav_menu($args = []) {
    if (!empty($args['fallback_cb']) && is_callable($args['fallback_cb'])) {
        call_user_func($args['fallback_cb'], $args);
    }
}

function body_class($class = '') {
    $classes = ['wp-theme-mileym3dia'];
    if ($class) {
        $classes = array_merge($classes, is_array($class) ? $class : explode(' ', $class));
    }
    $classes = apply_filters('body_class', $classes);
    echo 'class="' . esc_attr(implode(' ', array_unique($classes))) . '"';
}

function post_class($class = '', $post_id = null) {
    $classes = ['hentry'];
    if ($class) {
        $classes = array_merge($classes, is_array($class) ? $class : explode(' ', $class));
    }
    echo 'class="' . esc_attr(implode(' ', array_unique($classes))) . '"';
}

function get_header($name = null) { include __DIR__ . '/header.php'; }
function get_footer($name = null) { include __DIR__ . '/footer.php'; }
function get_sidebar($name = null) { include __DIR__ . '/sidebar.php'; }
function get_search_form($echo = true) {
    ob_start();
    include __DIR__ . '/searchform.php';
    $form = ob_get_clean();
    if ($echo) echo $form;
    return $form;
}
function get_search_query($escaped = true) {
    $q = $_GET['s'] ?? '';
    return $escaped ? esc_attr($q) : $q;
}
function get_template_part($slug, $name = null, $args = []) {
    $files = [];
    if ($name) $files[] = __DIR__ . "/{$slug}-{$name}.php";
    $files[] = __DIR__ . "/{$slug}.php";
    foreach ($files as $file) {
        if (file_exists($file)) {
            include $file;
            return;
        }
    }
}

function post_type_exists($post_type) { return in_array($post_type, ['post', 'page', 'project'], true); }
function taxonomy_exists($taxonomy) { return in_array($taxonomy, ['category', 'post_tag', 'project_category'], true); }
function get_page_by_path($page_path, $output = OBJECT, $post_type = 'page') {
    $slug = trim($page_path, '/');
    if ($post_type === 'project') {
        foreach ($GLOBALS['m3_projects'] as $p) {
            if ($p->post_name === $slug) {
                return $p;
            }
        }
        return null;
    }
    if (in_array($slug, ['about', 'services', 'portfolio', 'work', 'store', 'shop', 'resources', 'contact', 'creator-hub', 'blog', 'privacy-terms'], true)) {
        return (object)['ID' => crc32($slug), 'post_name' => $slug, 'post_status' => 'publish'];
    }
    return null;
}
function get_post_type_archive_link($post_type) {
    return $post_type === 'project' ? '/work/' : '/blog/';
}

function have_posts() { return $GLOBALS['wp_query']->have_posts(); }
function the_post() { $GLOBALS['wp_query']->the_post(); }
function wp_reset_postdata() {
    $GLOBALS['post'] = $GLOBALS['wp_query']->post ?? null;
}
function wp_reset_query() { wp_reset_postdata(); }
function setup_postdata($post) {
    $GLOBALS['post'] = is_object($post) ? $post : get_post($post);
    return true;
}

function get_post($post = null) {
    if (is_object($post)) return $post;
    if (is_numeric($post)) {
        $id = (int)$post;
        if (isset($GLOBALS['m3_posts'][$id])) return $GLOBALS['m3_posts'][$id];
        if (isset($GLOBALS['m3_projects'][$id])) return $GLOBALS['m3_projects'][$id];
    }
    return $GLOBALS['post'] ?? reset($GLOBALS['m3_posts']);
}
function get_the_ID() {
    $p = get_post();
    return $p ? $p->ID : 0;
}
function the_ID() { echo get_the_ID(); }
function get_post_type($post = null) {
    $p = get_post($post);
    return $p ? ($p->post_type ?? 'post') : 'post';
}
function get_post_field($field, $post = null) {
    $p = get_post($post);
    return $p && isset($p->$field) ? $p->$field : '';
}
function get_post_meta($post_id, $key = '', $single = false) {
    $p = get_post($post_id);
    if ($p && isset($p->meta[$key])) {
        return $single ? $p->meta[$key] : [$p->meta[$key]];
    }
    return $single ? '' : [];
}

function get_the_title($post = null) {
    $p = get_post($post);
    return $p ? $p->post_title : '';
}
function the_title($before = '', $after = '', $echo = true) {
    $t = $before . get_the_title() . $after;
    if ($echo) echo $t;
    return $t;
}
function the_title_attribute($args = '') { echo esc_attr(get_the_title()); }

function get_permalink($post = null) {
    if (is_numeric($post)) {
        foreach (['about', 'services', 'portfolio', 'work', 'store', 'shop', 'resources', 'contact', 'creator-hub', 'blog', 'privacy-terms'] as $slug) {
            if ((int)$post === crc32($slug)) {
                if ($slug === 'portfolio') return '/work/';
                if ($slug === 'shop') return '/store/';
                return '/' . $slug . '/';
            }
        }
    }
    $p = get_post($post);
    if (!$p) return '/';
    if (($p->post_type ?? '') === 'project') {
        return '/project/' . $p->post_name . '/';
    }
    if (($p->post_type ?? '') === 'page') {
        return '/' . $p->post_name . '/';
    }
    return '/dispatch/' . $p->post_name . '/';
}
function the_permalink() { echo esc_url(get_permalink()); }

function get_the_excerpt($post = null) {
    $p = get_post($post);
    return $p ? ($p->post_excerpt ?: wp_trim_words(strip_tags($p->post_content ?? ''), 28)) : '';
}
function the_excerpt() { echo '<p>' . esc_html(get_the_excerpt()) . '</p>'; }
function get_the_content($more_link_text = null, $strip_teaser = false, $post = null) {
    $p = get_post($post);
    return $p ? ($p->post_content ?? '') : '';
}
function the_content($more_link_text = null, $strip_teaser = false) {
    echo get_the_content($more_link_text, $strip_teaser);
}
function wp_link_pages($args = []) {}

function get_the_date($format = '', $post = null) {
    $p = get_post($post);
    $ts = $p && !empty($p->post_date) ? strtotime($p->post_date) : time();
    return date($format ?: 'M d, Y', $ts);
}
function get_the_author() { return 'MILEYM3DIA EDITORIAL'; }
function the_author() { echo get_the_author(); }
function get_the_author_meta($field = '', $user_id = false) {
    switch ($field) {
        case 'ID': return 1;
        case 'display_name': return 'MILEYM3DIA STUDIO';
        case 'description': return 'Creative direction, cinema optics, and audio-visual architecture from the MILEYM3DIA studio floor.';
        default: return 'MILEYM3DIA STUDIO';
    }
}
function get_author_posts_url($author_id, $author_nicename = '') { return '/blog/'; }
function get_avatar($id_or_email, $size = 96, $default = '', $alt = '', $args = null) {
    return '<img src="/assets/images/ui-mark.svg" width="' . (int)$size . '" height="' . (int)$size . '" alt="Author" class="avatar" />';
}

function has_post_thumbnail($post = null) {
    $p = get_post($post);
    return $p && !empty($p->thumbnail);
}
function get_the_post_thumbnail($post = null, $size = 'post-thumbnail', $attr = []) {
    $p = get_post($post);
    if (!$p || empty($p->thumbnail)) return '';
    $cls = $attr['class'] ?? 'wp-post-image';
    return '<img src="' . esc_url($p->thumbnail) . '" alt="' . esc_attr($p->post_title) . '" class="' . esc_attr($cls) . '" loading="lazy" />';
}
function the_post_thumbnail($size = 'post-thumbnail', $attr = []) {
    echo get_the_post_thumbnail(null, $size, $attr);
}
function get_the_post_thumbnail_url($post = null, $size = 'post-thumbnail') {
    $p = get_post($post);
    return ($p && !empty($p->thumbnail)) ? $p->thumbnail : '';
}
function get_the_post_thumbnail_caption($post = null) {
    $p = get_post($post);
    return $p && !empty($p->caption) ? $p->caption : '';
}
function wp_get_attachment_image($attachment_id, $size = 'thumbnail', $icon = false, $attr = '') {
    return '<img src="/assets/images/portfolio-1.jpg" alt="" loading="lazy" />';
}

function get_categories($args = []) { return array_values($GLOBALS['m3_categories']); }
function get_the_category($id = false) {
    $p = get_post($id);
    return $p && !empty($p->categories) ? $p->categories : [reset($GLOBALS['m3_categories'])];
}
function wp_get_post_categories($post_id = 0, $args = []) {
    $cats = get_the_category($post_id);
    return array_map(fn($c) => $c->term_id, $cats);
}
function get_category_link($category) {
    $id = is_object($category) ? $category->term_id : (int)$category;
    $cat = $GLOBALS['m3_categories'][$id] ?? reset($GLOBALS['m3_categories']);
    return '/category/' . $cat->slug . '/';
}
function get_tags($args = []) { return $GLOBALS['m3_tags']; }
function get_the_tags($id = 0) {
    $p = get_post($id);
    return $p && !empty($p->tags) ? $p->tags : array_slice($GLOBALS['m3_tags'], 0, 3);
}
function get_tag_link($tag) {
    return '/blog/';
}
function get_the_terms($post, $taxonomy) {
    $p = get_post($post);
    if ($taxonomy === 'project_category' && $p && !empty($p->terms)) {
        return $p->terms;
    }
    return false;
}
function get_term_by($field, $value, $taxonomy = '') {
    return reset($GLOBALS['m3_categories']);
}

function get_query_var($var, $default = '') {
    return $_GET[$var] ?? $default;
}
function paginate_links($args = []) { return ''; }
function the_posts_pagination($args = []) {}
function the_post_navigation($args = []) {}
function get_previous_post() {
    $posts = array_values($GLOBALS['m3_posts']);
    return $posts[1] ?? null;
}
function get_next_post() {
    $posts = array_values($GLOBALS['m3_posts']);
    return $posts[2] ?? null;
}

function wp_get_recent_posts($args = [], $output = ARRAY_A) {
    $res = [];
    foreach ($GLOBALS['m3_posts'] as $p) {
        $res[] = [
            'ID' => $p->ID,
            'post_title' => $p->post_title,
            'post_date' => $p->post_date,
        ];
    }
    return $res;
}

function comments_open($post_id = null) { return false; }
function get_comments_number($post_id = 0) { return 0; }
function comments_number($zero = false, $one = false, $more = false) { echo $zero ?: '0 Comments'; }
function comments_template($file = '/comments.php', $separate_comments = false) {}
function post_password_required($post = null) { return false; }
function have_comments() { return false; }
function wp_list_comments($args = [], $comments = null) {}
function the_comments_navigation($args = []) {}
function comment_form($args = [], $post_id = null) {}
function comment_ID() { echo '1'; }
function comment_class($class = '', $comment_id = null, $post_id = null, $echo = true) { if ($echo) echo 'class="comment"'; }
function comment_author_link($comment_id = 0) { echo 'Anonymous'; }
function comment_date($format = '', $comment_id = 0) { echo date('M d, Y'); }
function edit_comment_link($text = null, $before = '', $after = '') {}
function comment_text($comment_id = 0, $args = []) {}
function comment_reply_link($args = [], $comment = null, $post = null) {}

function get_the_archive_title() { return 'EDITORIAL ARCHIVE'; }
function the_archive_title($before = '', $after = '') { echo $before . get_the_archive_title() . $after; }
function get_the_archive_description() { return 'Curated field notes, optical tests, and studio dispatches.'; }
function the_archive_description($before = '', $after = '') { echo $before . get_the_archive_description() . $after; }
function single_cat_title($prefix = '', $display = true) { if ($display) echo $prefix . 'Cinema Optics'; return $prefix . 'Cinema Optics'; }
function single_tag_title($prefix = '', $display = true) { if ($display) echo $prefix . 'Editorial'; return $prefix . 'Editorial'; }
function single_term_title($prefix = '', $display = true) { if ($display) echo $prefix . 'Campaigns'; return $prefix . 'Campaigns'; }

function wp_nonce_field($action = -1, $name = "_wpnonce", $referer = true, $echo = true) {
    $html = '<input type="hidden" name="' . esc_attr($name) . '" value="preview_nonce" />';
    if ($echo) echo $html;
    return $html;
}
function wp_verify_nonce($nonce, $action = -1) { return true; }
function wp_mail($to, $subject, $message, $headers = '', $attachments = []) { return true; }
function wp_login_url($redirect = '', $force_reauth = false) { return '#'; }
function wp_logout_url($redirect = '') { return '#'; }

function wp_get_current_user() { return (object)['ID' => 0, 'display_name' => 'Guest', 'user_email' => '']; }
function wp_unslash($value) { return is_string($value) ? stripslashes($value) : $value; }
function wp_safe_redirect($location, $status = 302) { header('Location: ' . $location, true, $status); }

// Load theme functions and setup
require_once __DIR__ . '/functions.php';
do_action('after_setup_theme');
do_action('widgets_init');

// Preview POST handling for Registration, Sign-In, and Store Order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!empty($_POST['mileym3dia_action']) || !empty($_POST['m3_action']))) {
    $action = sanitize_text_field($_POST['mileym3dia_action'] ?? $_POST['m3_action']);
    if ($action === 'register_user') {
        $email = sanitize_email($_POST['reg_email'] ?? $_POST['user_email'] ?? '');
        $name  = sanitize_text_field($_POST['reg_fullname'] ?? $_POST['user_name'] ?? '');
        $pass  = $_POST['reg_password'] ?? $_POST['user_pass'] ?? '';
        if ($email && is_email($email) && !empty($pass)) {
            header('Location: /creator-hub/?tab=login&auth=registered&name=' . rawurlencode($name ?: 'Creator') . '#portal-access');
            exit;
        }
        header('Location: /creator-hub/?tab=register&auth_error=' . rawurlencode('Please enter a valid email and password.') . '#portal-access');
        exit;
    } elseif ($action === 'login_user') {
        $login = sanitize_text_field($_POST['log'] ?? '');
        if ($login && !empty($_POST['pwd'])) {
            header('Location: /creator-hub/?tab=login&auth=logged_in#portal-access');
            exit;
        }
        header('Location: /creator-hub/?tab=login&auth_error=' . rawurlencode('Invalid username or password.') . '#portal-access');
        exit;
    } elseif ($action === 'store_order') {
        $email = sanitize_email($_POST['order_email'] ?? '');
        if ($email && is_email($email)) {
            header('Location: /store/?order=placed#checkout');
            exit;
        }
        header('Location: /store/?order=error#checkout');
        exit;
    }
}

// Render the matched template
include $template_to_load;

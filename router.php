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

if (PHP_SAPI !== 'cli' && session_status() === PHP_SESSION_NONE && !headers_sent()) {
    @session_save_path(sys_get_temp_dir());
    @session_start();
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
            'terms' => [
                (object)['term_id' => 30, 'name' => 'Video Production', 'slug' => 'video-production'],
                (object)['term_id' => 33, 'name' => 'Photography', 'slug' => 'photography'],
            ],
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
                '_project_timeline' => '4-Week Cycle',
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
            'terms' => [
                (object)['term_id' => 31, 'name' => 'Music & Audio Production', 'slug' => 'music-audio'],
                (object)['term_id' => 30, 'name' => 'Video Production', 'slug' => 'video-production'],
            ],
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
                '_project_timeline' => '4-Week Cycle',
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
            'terms' => [
                (object)['term_id' => 32, 'name' => 'Branding & Graphic Design', 'slug' => 'branding-design'],
                (object)['term_id' => 34, 'name' => 'Web Design & Development', 'slug' => 'web-design'],
            ],
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
                '_project_timeline' => '4-Week Cycle',
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
            'terms' => [
                (object)['term_id' => 33, 'name' => 'Photography', 'slug' => 'photography'],
                (object)['term_id' => 32, 'name' => 'Branding & Graphic Design', 'slug' => 'branding-design'],
            ],
        ],
    ];

$GLOBALS['m3_services'] = [
    301 => (object)[
        'ID' => 301,
        'post_title' => 'Video Production',
        'post_name' => 'video-production',
        'post_status' => 'publish',
        'post_type' => 'service',
        'menu_order' => 1,
        'post_excerpt' => 'Cinema-grade music videos, brand commercials, documentaries, aerial drone capture, and professional DaVinci Resolve color grading.',
        'post_content' => '<p>Cinema-grade music videos, brand commercials, documentaries, aerial drone capture, and professional DaVinci Resolve color grading.</p>',
        'meta' => [
            '_service_number' => '01',
            '_service_tag' => '4K / 8K CINEMA · COMMERCIALS · MUSIC VIDEOS',
            '_service_deliverables' => 'Commercials & Brand Films, Music Videos & Performance, Color Grading & VFX, Documentary & Aerial',
            '_service_accent' => 'red',
            '_service_cta_text' => 'BOOK VIDEO PRODUCTION',
            '_service_cta_url' => '',
            '_service_category_slug' => 'video-production',
        ],
    ],
    302 => (object)[
        'ID' => 302,
        'post_title' => 'Photography',
        'post_name' => 'photography',
        'post_status' => 'publish',
        'post_type' => 'service',
        'menu_order' => 2,
        'post_excerpt' => 'High-impact brand lookbooks, studio & on-location portraits, artist press photos, commercial product photography, and retouching.',
        'post_content' => '<p>High-impact brand lookbooks, studio & on-location portraits, artist press photos, commercial product photography, and retouching.</p>',
        'meta' => [
            '_service_number' => '02',
            '_service_tag' => 'EDITORIAL · PRODUCT · CAMPAIGN STILLS',
            '_service_deliverables' => 'Lookbooks & Apparel, Product & Studio Stills, Artist Press & Portraits, Event & BTS Coverage',
            '_service_accent' => 'blue',
            '_service_cta_text' => 'BOOK PHOTOGRAPHY',
            '_service_cta_url' => '',
            '_service_category_slug' => 'photography',
        ],
    ],
    303 => (object)[
        'ID' => 303,
        'post_title' => 'Branding & Graphic Design',
        'post_name' => 'branding-design',
        'post_status' => 'publish',
        'post_type' => 'service',
        'menu_order' => 3,
        'post_excerpt' => 'Memorable logo systems, typography, brand guidelines, merch & apparel graphics, album artwork, and physical packaging.',
        'post_content' => '<p>Memorable logo systems, typography, brand guidelines, merch & apparel graphics, album artwork, and physical packaging.</p>',
        'meta' => [
            '_service_number' => '03',
            '_service_tag' => 'VISUAL IDENTITY · PACKAGING · KEY ART',
            '_service_deliverables' => 'Logo & Identity Systems, Album & Tour Key Art, Packaging & Merch Design, Brand Guidelines',
            '_service_accent' => 'lime',
            '_service_cta_text' => 'BOOK BRANDING & GRAPHIC DESIGN',
            '_service_cta_url' => '',
            '_service_category_slug' => 'branding-design',
        ],
    ],
    304 => (object)[
        'ID' => 304,
        'post_title' => 'Web Design & Development',
        'post_name' => 'web-design',
        'post_status' => 'publish',
        'post_type' => 'service',
        'menu_order' => 4,
        'post_excerpt' => 'Fast, modern, custom-designed websites, artist & agency portfolios, landing pages, and WooCommerce / Shopify storefronts.',
        'post_content' => '<p>Fast, modern, custom-designed websites, artist & agency portfolios, landing pages, and WooCommerce / Shopify storefronts.</p>',
        'meta' => [
            '_service_number' => '04',
            '_service_tag' => 'CUSTOM WORDPRESS · E-COMMERCE · INTERACTIVE',
            '_service_deliverables' => 'Custom WordPress Themes, WooCommerce Storefronts, Interactive Launch Sites, Performance & SEO',
            '_service_accent' => 'yellow',
            '_service_cta_text' => 'BOOK WEB DESIGN & DEVELOPMENT',
            '_service_cta_url' => '',
            '_service_category_slug' => 'web-design',
        ],
    ],
    305 => (object)[
        'ID' => 305,
        'post_title' => 'Music & Audio Production',
        'post_name' => 'music-audio',
        'post_status' => 'publish',
        'post_type' => 'service',
        'menu_order' => 5,
        'post_excerpt' => 'Original music production, custom scoring for film & commercials, vocal mixing, mastering, and clean audio post-production.',
        'post_content' => '<p>Original music production, custom scoring for film & commercials, vocal mixing, mastering, and clean audio post-production.</p>',
        'meta' => [
            '_service_number' => '05',
            '_service_tag' => 'MIXING · MASTERING · SOUND DESIGN · SCORING',
            '_service_deliverables' => 'Dolby Atmos & Stereo Mixing, Commercial Sound Design, Original Film Scoring, Stem Mastering',
            '_service_accent' => 'red',
            '_service_cta_text' => 'BOOK MUSIC & AUDIO PRODUCTION',
            '_service_cta_url' => '',
            '_service_category_slug' => 'music-audio',
        ],
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
} elseif (strpos($clean_path, 'product/') === 0) {
    $GLOBALS['m3_route']['is_page'] = true;
    $GLOBALS['m3_route']['page_slug'] = 'store';
    $GLOBALS['m3_wc_preview_view'] = 'product';
    $GLOBALS['m3_wc_preview_slug'] = basename($clean_path);
    $GLOBALS['m3_Current_Posts'] = [];
    $template_to_load = null;
} elseif (in_array($clean_path, ['cart', 'checkout', 'my-account'], true)) {
    $GLOBALS['m3_route']['is_page'] = true;
    $GLOBALS['m3_route']['page_slug'] = 'store';
    $GLOBALS['m3_wc_preview_view'] = $clean_path;
    $GLOBALS['m3_Current_Posts'] = [];
    $template_to_load = null;
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
            if (!empty($args['posts_per_page']) && $args['posts_per_page'] > 0) {
                $pool = array_slice($pool, 0, (int)$args['posts_per_page']);
            }
        } elseif ($post_type === 'service') {
            $pool = array_values($GLOBALS['m3_services']);
            if (!empty($args['posts_per_page']) && $args['posts_per_page'] > 0) {
                $pool = array_slice($pool, 0, (int)$args['posts_per_page']);
            }
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
function esc_url_raw($url) { return (string)$url; }
function esc_textarea($text) { return htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8'); }
function esc_js($text) { return addslashes((string)$text); }
function wp_kses($string, $allowed_html = []) { return (string)$string; }
function wp_kses_post($string) { return (string)$string; }
function absint($maybeint) { return abs((int)$maybeint); }
function sanitize_hex_color($color) { return preg_match('/^#([A-Fa-f0-9]{3}){1,2}$/', (string)$color) ? $color : ''; }
function sanitize_html_class($class, $fallback = '') { return preg_replace('/[^A-Za-z0-9_-]/', '', (string)$class) ?: $fallback; }
function sanitize_key($key) { return preg_replace('/[^a-z0-9_\-]/', '', strtolower((string)$key)); }
function sanitize_title($title) { return trim(preg_replace('/[^a-z0-9\-]+/', '-', strtolower((string)$title)), '-'); }
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
function is_user_logged_in() { return !empty($_SESSION['m3_user']); }
function get_current_user_id() { return !empty($_SESSION['m3_user']['ID']) ? (int)$_SESSION['m3_user']['ID'] : 0; }
function get_user_meta($user_id, $key = '', $single = false) {
    if (empty($_SESSION['m3_user'])) return $single ? '' : [];
    $val = $_SESSION['m3_user'][$key] ?? '';
    return $single ? $val : [$val];
}
function update_user_meta($user_id, $key, $value) {
    if (!empty($_SESSION['m3_user'])) {
        $_SESSION['m3_user'][$key] = $value;
    }
    return true;
}
function wp_create_nonce($action = -1) { return 'm3-preview'; }
function wp_redirect($location, $status = 302) { header('Location: ' . $location, true, $status); }
function wp_json_encode($data, $options = 0, $depth = 512) { return json_encode($data, $options, $depth); }
function wp_strip_all_tags($string, $remove_breaks = false) { return trim(strip_tags((string)$string)); }
function wp_get_document_title() { return 'MILEYM3DIA — Creative Media Agency'; }
function wp_get_referer() { return $_SERVER['HTTP_REFERER'] ?? '/'; }
function mileym3dia_preview_get_cart_count() {
    $count = 0;
    foreach (($_SESSION['m3_cart'] ?? []) as $item) {
        $count += (int)($item['qty'] ?? 1);
    }
    return $count;
}
function mileym3dia_preview_get_briefs() {
    return $_SESSION['m3_briefs'] ?? [];
}
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

function post_type_exists($post_type) { return in_array($post_type, ['post', 'page', 'project', 'service'], true); }
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
    if ($post_type === 'service') {
        foreach ($GLOBALS['m3_services'] as $s) {
            if ($s->post_name === $slug) {
                return $s;
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
        if (isset($GLOBALS['m3_services'][$id])) return $GLOBALS['m3_services'][$id];
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

function wp_get_current_user() {
    if (!empty($_SESSION['m3_user'])) {
        return (object) $_SESSION['m3_user'];
    }
    return (object) ['ID' => 0, 'user_login' => '', 'display_name' => 'Guest', 'user_email' => '', 'user_url' => '', 'description' => ''];
}
function wp_unslash($value) { return is_string($value) ? stripslashes($value) : $value; }
function wp_safe_redirect($location, $status = 302) { header('Location: ' . $location, true, $status); }

// Load theme functions and setup
require_once __DIR__ . '/functions.php';
do_action('after_setup_theme');
do_action('widgets_init');

// Protected resource download endpoint in preview
if (isset($_GET['m3_download_resource']) && function_exists('mileym3dia_handle_protected_resource_download')) {
    mileym3dia_handle_protected_resource_download();
}

// WooCommerce preview cart GET actions (`?add-to-cart=<id>`, `?remove_cart_item=<id>`)
if (isset($_GET['add-to-cart'])) {
    $add_id   = absint($_GET['add-to-cart']);
    $add_size = isset($_GET['size']) ? sanitize_text_field($_GET['size']) : '';
    $catalog  = mileym3dia_get_default_store_products();
    foreach ($catalog as $prod) {
        if ((int)$prod['id'] === $add_id) {
            $_SESSION['m3_cart'] = $_SESSION['m3_cart'] ?? [];
            $key = $add_id . ($add_size ? '_' . $add_size : '');
            if (isset($_SESSION['m3_cart'][$key])) {
                $_SESSION['m3_cart'][$key]['qty']++;
            } else {
                $_SESSION['m3_cart'][$key] = [
                    'id'              => $prod['id'],
                    'slug'            => $prod['slug'],
                    'title'           => $prod['title'] . ($add_size ? ' (Size: ' . $add_size . ')' : ''),
                    'price'           => (float)$prod['regular_price'],
                    'image'           => $prod['image'],
                    'is_downloadable' => $prod['is_downloadable'],
                    'is_physical'     => $prod['is_physical'],
                    'download_file'   => $prod['download_file'],
                    'grants_tier'     => $prod['grants_tier'],
                    'qty'             => 1,
                ];
            }
            header('Location: /cart/?added=' . $add_id);
            exit;
        }
    }
}
if (isset($_GET['remove_cart_item'])) {
    $rm_key = sanitize_text_field($_GET['remove_cart_item']);
    if (isset($_SESSION['m3_cart'][$rm_key])) {
        unset($_SESSION['m3_cart'][$rm_key]);
    }
    header('Location: /cart/');
    exit;
}

// Preview POST handling for Newsletter, Creator Hub Auth/Profile/Briefs, and WooCommerce Checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['m3_newsletter_email'])) {
        $sub_email = sanitize_email($_POST['m3_newsletter_email']);
        $ref       = $_SERVER['HTTP_REFERER'] ?? '/';
        $sep       = strpos($ref, '?') === false ? '?' : '&';
        header('Location: ' . $ref . $sep . 'subscribed=' . ($sub_email && is_email($sub_email) ? '1' : 'invalid'));
        exit;
    }

    $action = sanitize_key($_POST['mileym3dia_action'] ?? $_POST['m3_action'] ?? '');
    if ($action === 'register_user') {
        $email    = sanitize_email($_POST['reg_email'] ?? '');
        $username = sanitize_text_field($_POST['reg_username'] ?? '');
        $name     = sanitize_text_field($_POST['reg_fullname'] ?? '');
        $company  = sanitize_text_field($_POST['reg_company'] ?? '');
        $acc_type = sanitize_key($_POST['reg_account_type'] ?? 'creator');
        $pass     = (string)($_POST['reg_password'] ?? '');
        if ($email && is_email($email) && strlen($pass) >= 6) {
            $_SESSION['m3_user'] = [
                'ID'                 => 901,
                'user_login'         => $username ?: strstr($email, '@', true),
                'display_name'       => $name ?: ($username ?: 'Creator'),
                'user_email'         => $email,
                'user_url'           => '',
                'description'        => '',
                'm3_company'         => $company,
                'm3_account_type'    => $acc_type,
                'm3_membership_tier' => 'free',
            ];
            header('Location: /creator-hub/?auth=registered#portal-access');
            exit;
        }
        header('Location: /creator-hub/?tab=register&auth_error=' . rawurlencode('Please enter a valid email and password (min 6 chars).') . '#portal-access');
        exit;
    } elseif ($action === 'login_user') {
        $login = sanitize_text_field($_POST['log'] ?? '');
        $pass  = (string)($_POST['pwd'] ?? '');
        if ($login && $pass) {
            $_SESSION['m3_user'] = [
                'ID'                 => 901,
                'user_login'         => $login,
                'display_name'       => ucfirst(strstr($login, '@', true) ?: $login),
                'user_email'         => is_email($login) ? $login : ($login . '@studio.local'),
                'user_url'           => '',
                'description'        => '',
                'm3_company'         => 'MILEYM3DIA Member',
                'm3_account_type'    => 'creator',
                'm3_membership_tier' => 'free',
            ];
            header('Location: /creator-hub/?auth=logged_in#portal-access');
            exit;
        }
        header('Location: /creator-hub/?tab=login&auth_error=' . rawurlencode('Invalid username or password.') . '#portal-access');
        exit;
    } elseif ($action === 'logout_user') {
        unset($_SESSION['m3_user']);
        header('Location: /creator-hub/?tab=login&auth=logged_out#portal-access');
        exit;
    } elseif ($action === 'lost_password') {
        $u = sanitize_text_field($_POST['user_login'] ?? '');
        if ($u) {
            header('Location: /creator-hub/?tab=reset&auth=reset_sent#portal-access');
            exit;
        }
        header('Location: /creator-hub/?tab=reset&auth_error=' . rawurlencode('Please enter your username or email.') . '#portal-access');
        exit;
    } elseif ($action === 'update_profile' && !empty($_SESSION['m3_user'])) {
        $_SESSION['m3_user']['display_name']    = sanitize_text_field($_POST['profile_display_name'] ?? $_SESSION['m3_user']['display_name']);
        $_SESSION['m3_user']['user_email']      = sanitize_email($_POST['profile_email'] ?? $_SESSION['m3_user']['user_email']);
        $_SESSION['m3_user']['m3_company']      = sanitize_text_field($_POST['profile_company'] ?? '');
        $_SESSION['m3_user']['m3_account_type'] = sanitize_key($_POST['profile_account_type'] ?? 'creator');
        $_SESSION['m3_user']['user_url']        = esc_url_raw($_POST['profile_website'] ?? '');
        $_SESSION['m3_user']['description']     = sanitize_textarea_field($_POST['profile_bio'] ?? '');
        header('Location: /creator-hub/?auth=profile_updated#portal-access');
        exit;
    } elseif ($action === 'submit_brief' && !empty($_SESSION['m3_user'])) {
        $title = sanitize_text_field($_POST['brief_title'] ?? '');
        if ($title) {
            $_SESSION['m3_briefs'] = $_SESSION['m3_briefs'] ?? [];
            array_unshift($_SESSION['m3_briefs'], [
                'title'      => $title,
                'discipline' => sanitize_text_field($_POST['brief_discipline'] ?? 'Video Production'),
                'timeline'   => sanitize_text_field($_POST['brief_timeline'] ?? 'Next 30 Days'),
                'status'     => 'IN REVIEW',
                'progress'   => 20,
            ]);
        }
        header('Location: /creator-hub/?auth=brief_submitted#portal-access');
        exit;
    } elseif ($action === 'wc_place_order') {
        $cart = $_SESSION['m3_cart'] ?? [];
        if (!empty($cart)) {
            $order_id = 'M3-' . rand(10000, 99999);
            $total    = 0;
            $dls      = [];
            foreach ($cart as $ci) {
                $total += ((float)$ci['price'] * (int)$ci['qty']);
                if (!empty($ci['is_downloadable']) && !empty($ci['download_file'])) {
                    $dls[] = ['title' => $ci['title'], 'file' => $ci['download_file']];
                }
                if (!empty($ci['grants_tier']) && !empty($_SESSION['m3_user'])) {
                    $_SESSION['m3_user']['m3_membership_tier'] = $ci['grants_tier'];
                }
            }
            $_SESSION['m3_orders'] = $_SESSION['m3_orders'] ?? [];
            array_unshift($_SESSION['m3_orders'], [
                'id'        => $order_id,
                'date'      => date('M d, Y'),
                'total'     => $total,
                'status'    => 'Completed',
                'items'     => array_values($cart),
                'downloads' => $dls,
            ]);
            $_SESSION['m3_cart'] = [];
            header('Location: /my-account/?order_placed=' . rawurlencode($order_id));
            exit;
        }
        header('Location: /cart/');
        exit;
    }
}

// Render WooCommerce Preview Views (`/product/<slug>/`, `/cart/`, `/checkout/`, `/my-account/`)
if (!empty($GLOBALS['m3_wc_preview_view'])) {
    $wc_view  = $GLOBALS['m3_wc_preview_view'];
    $catalog  = mileym3dia_get_store_products();
    $cart     = $_SESSION['m3_cart'] ?? [];
    $orders   = $_SESSION['m3_orders'] ?? [];
    $cart_cnt = mileym3dia_preview_get_cart_count();
    get_header();
    ?>
    <main id="primary" class="site-main m3-wc-main">
        <section class="page-title-section bg-shade-base">
            <div class="container container--wide">
                <span class="page-subtitle text-lime">STUDIO STORE // WOOCOMMERCE</span>
                <h1 class="page-title page-title--mega">
                    <?php
                    if ($wc_view === 'product') echo 'PRODUCT <span class="text-lime">DETAILS</span>';
                    elseif ($wc_view === 'cart') echo 'YOUR <span class="text-lime">CART</span>';
                    elseif ($wc_view === 'checkout') echo 'STUDIO <span class="text-lime">CHECKOUT</span>';
                    else echo 'MY <span class="text-lime">ACCOUNT</span>';
                    ?>
                </h1>
                <div class="store-hero-bar">
                    <div class="store-hero-badges">
                        <a href="/store/" class="store-pill">← BACK TO STUDIO STORE</a>
                        <span class="store-pill">WOOCOMMERCE DIGITAL &amp; PHYSICAL</span>
                    </div>
                    <div class="m3-wc-nav-actions">
                        <a href="/cart/" class="btn btn--streetwear-red"><span>CART (<?php echo esc_html((string)$cart_cnt); ?>)</span></a>
                        <a href="/checkout/" class="btn btn--streetwear-outline"><span>CHECKOUT</span></a>
                        <a href="/my-account/" class="btn btn--streetwear-outline"><span>MY ACCOUNT</span></a>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-loose bg-shade-elevated">
            <div class="container container--wide woocommerce-m3-shell">
                <?php if ($wc_view === 'product') :
                    $slug = $GLOBALS['m3_wc_preview_slug'] ?? '';
                    $prod = $catalog[0];
                    foreach ($catalog as $c) {
                        if ($c['slug'] === $slug) { $prod = $c; break; }
                    }
                ?>
                    <div class="m3-wc-single-grid">
                        <div class="m3-wc-single-media">
                            <img src="<?php echo esc_url($prod['image']); ?>" alt="<?php echo esc_attr($prod['title']); ?>" />
                        </div>
                        <div class="m3-wc-single-info">
                            <span class="store-card__badge" style="position:static;display:inline-block;margin-bottom:1rem;"><?php echo esc_html($prod['badge']); ?></span>
                            <h2 class="section-title" style="margin-bottom:0.75rem;"><?php echo esc_html($prod['title']); ?></h2>
                            <div class="m3-wc-single-price text-lime"><?php echo esc_html($prod['price']); ?></div>
                            <p class="page-lead" style="margin:1.25rem 0;"><?php echo esc_html($prod['desc']); ?></p>
                            <div class="gear-card-specs" style="margin-bottom:1.5rem;">
                                <div class="spec-row"><span class="spec-label">CATEGORY:</span><span class="spec-val"><?php echo esc_html($prod['category_label']); ?></span></div>
                                <div class="spec-row"><span class="spec-label">FORMAT:</span><span class="spec-val"><?php echo esc_html($prod['format']); ?></span></div>
                                <div class="spec-row"><span class="spec-label">FULFILLMENT:</span><span class="spec-val"><?php echo !empty($prod['is_physical']) ? 'Physical Shipping (Worldwide)' : 'Instant WooCommerce Digital Access'; ?></span></div>
                            </div>
                            <form method="get" action="/cart/" class="m3-wc-add-form">
                                <input type="hidden" name="add-to-cart" value="<?php echo esc_attr((string)$prod['id']); ?>" />
                                <?php if (!empty($prod['attributes'])) : ?>
                                    <div class="form-group" style="margin-bottom:1rem;">
                                        <label for="wc-size-select">SELECT SIZE</label>
                                        <select id="wc-size-select" name="size">
                                            <?php foreach ($prod['attributes'] as $sz) : ?>
                                                <option value="<?php echo esc_attr($sz); ?>"><?php echo esc_html($sz); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <button type="submit" class="btn btn--streetwear-red btn--full"><span>ADD TO CART — <?php echo esc_html($prod['price']); ?></span></button>
                            </form>
                        </div>
                    </div>

                <?php elseif ($wc_view === 'cart') : ?>
                    <?php if (empty($cart)) : ?>
                        <div class="portal-notice">
                            <strong>YOUR CART IS EMPTY //</strong> Browse our digital LUT packs, audio vaults, merch, and Pro passes in the <a href="/store/" class="text-lime">Studio Store →</a>
                        </div>
                    <?php else :
                        $subtotal = 0;
                    ?>
                        <table class="shop_table cart">
                            <thead><tr><th>PRODUCT</th><th>PRICE</th><th>QTY</th><th>SUBTOTAL</th><th></th></tr></thead>
                            <tbody>
                            <?php foreach ($cart as $ck => $ci) :
                                $line = (float)$ci['price'] * (int)$ci['qty'];
                                $subtotal += $line;
                            ?>
                                <tr>
                                    <td><strong><?php echo esc_html($ci['title']); ?></strong></td>
                                    <td>$<?php echo esc_html(number_format((float)$ci['price'], 2)); ?></td>
                                    <td><?php echo esc_html((string)$ci['qty']); ?></td>
                                    <td>$<?php echo esc_html(number_format($line, 2)); ?></td>
                                    <td><a href="/cart/?remove_cart_item=<?php echo esc_attr(rawurlencode($ck)); ?>" class="text-red">Remove ×</a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="m3-wc-cart-summary">
                            <div class="m3-wc-cart-total"><span>TOTAL</span><strong>$<?php echo esc_html(number_format($subtotal, 2)); ?></strong></div>
                            <a href="/checkout/" class="btn btn--streetwear-red"><span>PROCEED TO CHECKOUT →</span></a>
                        </div>
                    <?php endif; ?>

                <?php elseif ($wc_view === 'checkout') :
                    $subtotal     = 0;
                    $has_physical = false;
                    foreach ($cart as $ci) {
                        $subtotal += (float)$ci['price'] * (int)$ci['qty'];
                        if (!empty($ci['is_physical'])) $has_physical = true;
                    }
                ?>
                    <?php if (empty($cart)) : ?>
                        <div class="portal-notice"><strong>NO ITEMS TO CHECK OUT //</strong> Add products in the <a href="/store/" class="text-lime">Studio Store →</a></div>
                    <?php else : ?>
                        <form method="post" action="/checkout/" class="contact-form m3-wc-checkout-grid">
                            <input type="hidden" name="mileym3dia_action" value="wc_place_order" />
                            <div>
                                <h2 class="section-title" style="margin-bottom:1.25rem;">BILLING <?php echo $has_physical ? '&amp; SHIPPING ' : ''; ?>DETAILS</h2>
                                <div class="form-row">
                                    <div class="form-group"><label for="billing-first">FIRST NAME *</label><input type="text" id="billing-first" name="billing_first" required /></div>
                                    <div class="form-group"><label for="billing-last">LAST NAME *</label><input type="text" id="billing-last" name="billing_last" required /></div>
                                </div>
                                <div class="form-group"><label for="billing-email">EMAIL ADDRESS *</label><input type="email" id="billing-email" name="billing_email" required /></div>
                                <?php if ($has_physical) : ?>
                                    <div class="form-group"><label for="shipping-addr">SHIPPING ADDRESS *</label><input type="text" id="shipping-addr" name="shipping_addr" placeholder="Street, City, State, ZIP" required /></div>
                                <?php endif; ?>
                            </div>
                            <div class="m3-wc-order-review">
                                <h3 style="margin-bottom:1rem;">ORDER SUMMARY</h3>
                                <?php foreach ($cart as $ci) : ?>
                                    <div class="spec-row"><span><?php echo esc_html($ci['title']); ?> × <?php echo esc_html((string)$ci['qty']); ?></span><strong>$<?php echo esc_html(number_format((float)$ci['price'] * (int)$ci['qty'], 2)); ?></strong></div>
                                <?php endforeach; ?>
                                <div class="spec-row" style="margin-top:1rem;padding-top:1rem;border-top:1px solid rgba(255,255,255,0.12);"><span>TOTAL</span><strong class="text-lime">$<?php echo esc_html(number_format($subtotal, 2)); ?></strong></div>
                                <button type="submit" class="btn btn--streetwear-red btn--full" style="margin-top:1.5rem;"><span>PLACE WOOCOMMERCE ORDER →</span></button>
                            </div>
                        </form>
                    <?php endif; ?>

                <?php else : /* my-account */ ?>
                    <?php if (!empty($_GET['order_placed'])) : ?>
                        <div class="portal-notice portal-notice--success" role="status">
                            <strong>ORDER CONFIRMED //</strong> Order <strong><?php echo esc_html(sanitize_text_field($_GET['order_placed'])); ?></strong> is complete. Your digital downloads are unlocked below.
                        </div>
                    <?php endif; ?>
                    <div class="m3-wc-account-grid">
                        <div class="hub-auth-card" style="padding:2rem;">
                            <h2 style="margin-bottom:1rem;">RECENT ORDERS &amp; DIGITAL DOWNLOADS</h2>
                            <?php if (empty($orders)) : ?>
                                <p class="text-muted">No orders yet. Visit the <a href="/store/" class="text-lime">Studio Store</a> to purchase digital packs, merch, or a Pro Retainer Pass.</p>
                            <?php else : ?>
                                <?php foreach ($orders as $ord) : ?>
                                    <div class="m3-tracker-item" style="margin-bottom:1rem;">
                                        <div class="m3-tracker-item__top">
                                            <strong>ORDER #<?php echo esc_html($ord['id']); ?> (<?php echo esc_html($ord['date']); ?>)</strong>
                                            <span class="m3-tracker-status m3-tracker-status--lime"><?php echo esc_html($ord['status']); ?> — $<?php echo esc_html(number_format((float)$ord['total'], 2)); ?></span>
                                        </div>
                                        <?php if (!empty($ord['downloads'])) : ?>
                                            <div style="margin-top:0.75rem;display:flex;flex-wrap:wrap;gap:0.5rem;">
                                                <?php foreach ($ord['downloads'] as $dl) : ?>
                                                    <a href="<?php echo esc_url($dl['file']); ?>" class="btn btn--streetwear-outline" download><span>DOWNLOAD <?php echo esc_html($dl['title']); ?> ↓</span></a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="hub-auth-card" style="padding:2rem;">
                            <h2 style="margin-bottom:1rem;">CREATOR HUB MEMBERSHIP</h2>
                            <p class="text-muted" style="margin-bottom:1.25rem;">Manage your studio profile, submit project briefs, and unlock free &amp; Pro member vault assets.</p>
                            <a href="/creator-hub/" class="btn btn--streetwear-red btn--full"><span>OPEN CREATOR HUB →</span></a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <?php
    get_footer();
    exit;
}

// Render the matched template
include $template_to_load;

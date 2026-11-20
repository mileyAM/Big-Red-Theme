<?php
/**
 * Template Name: Resources
 * Description: Scalable, searchable Resource Library directory supporting downloads, free tools,
 * tutorials, curated links, and affiliate partner resources managed via the `m3_resource` CPT.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$res_search   = isset($_GET['q']) ? sanitize_text_field(wp_unslash($_GET['q'])) : '';
$res_type     = isset($_GET['type']) ? sanitize_key(wp_unslash($_GET['type'])) : 'all';
$res_category = isset($_GET['rcat']) ? sanitize_title(wp_unslash($_GET['rcat'])) : '';
$res_tag      = isset($_GET['rtag']) ? sanitize_title(wp_unslash($_GET['rtag'])) : '';
$res_paged    = isset($_GET['rpage']) ? max(1, absint($_GET['rpage'])) : 1;

$allowed_types = array(
    'all'       => 'ALL RESOURCES',
    'download'  => 'DOWNLOADS',
    'tool'      => 'FREE TOOLS',
    'tutorial'  => 'TUTORIALS',
    'link'      => 'CURATED LINKS',
    'affiliate' => 'PARTNER DEALS',
);
if (!isset($allowed_types[$res_type])) {
    $res_type = 'all';
}

$resource_query = function_exists('mileym3dia_get_resources')
    ? mileym3dia_get_resources(array(
        'search'   => $res_search,
        'type'     => $res_type,
        'category' => $res_category,
        'tag'      => $res_tag,
        'paged'    => $res_paged,
        'per_page' => 9,
    ))
    : array('items' => array(), 'total' => 0, 'max_pages' => 1, 'paged' => 1, 'categories' => array(), 'tags' => array());

$items          = $resource_query['items'];
$total_found    = (int) $resource_query['total'];
$max_pages      = (int) $resource_query['max_pages'];
$current_page   = (int) $resource_query['paged'];
$all_categories = $resource_query['categories'];
$all_tags       = $resource_query['tags'];

$resources_base_url = mileym3dia_get_page_url('resources');
$hub_url            = mileym3dia_get_page_url('creator-hub');
$store_url          = mileym3dia_get_page_url('store');
$type_labels        = array(
    'download'  => 'DOWNLOAD',
    'tool'      => 'FREE TOOL',
    'tutorial'  => 'TUTORIAL',
    'link'      => 'CURATED LINK',
    'affiliate' => 'AFFILIATE PARTNER',
);
?>

<main id="primary" class="site-main resources-page-main">

    <!-- OFFICIAL MILEYM3DIA RESOURCES BANNER (YOUR VISION — BLUE ACCENT) -->
    <?php
    if (function_exists('mileym3dia_render_page_banner')) {
        mileym3dia_render_page_banner('resources', array(
            'heading_tag' => 'h1',
        ));
    }
    ?>

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

    <!-- SEARCH, TYPE TABS, CATEGORY/TAG FILTERS & DIRECTORY GRID -->
    <section class="resources-grid-section section-loose bg-shade-elevated" id="toolkits">
        <div class="container container--wide">
            <div class="section-header">
                <div class="section-header-left">
                    <span class="section-label text-blue">RESOURCE DIRECTORY</span>
                    <h2 class="section-title section-title--xl">TOOLS, DOWNLOADS &amp; LINKS</h2>
                </div>
                <div class="section-header-right">
                    <a href="<?php echo esc_url($store_url); ?>" class="text-link-arrow">
                        <span><?php esc_html_e('OPEN PRO STUDIO STORE', 'm3-big-red'); ?></span>
                        <span class="link-arrow">↗</span>
                    </a>
                </div>
            </div>

            <!-- DIRECTORY FILTER BAR -->
            <form class="m3-resource-toolbar" method="get" action="<?php echo esc_url($resources_base_url); ?>#toolkits" role="search" aria-label="<?php esc_attr_e('Search and filter resources', 'm3-big-red'); ?>">
                <div class="m3-resource-search-row">
                    <div class="m3-resource-search-field">
                        <label for="m3-resource-q" class="screen-reader-text"><?php esc_html_e('Search resources', 'm3-big-red'); ?></label>
                        <input
                            type="search"
                            id="m3-resource-q"
                            name="q"
                            value="<?php echo esc_attr($res_search); ?>"
                            placeholder="Search LUTs, tools, tutorials, audio stems, partner deals..."
                        />
                    </div>

                    <div class="m3-resource-select-wrap">
                        <label for="m3-resource-cat" class="screen-reader-text"><?php esc_html_e('Category', 'm3-big-red'); ?></label>
                        <select id="m3-resource-cat" name="rcat">
                            <option value=""><?php esc_html_e('All Categories', 'm3-big-red'); ?></option>
                            <?php foreach ($all_categories as $c_slug => $c_name) : ?>
                                <option value="<?php echo esc_attr($c_slug); ?>" <?php selected($res_category, $c_slug); ?>>
                                    <?php echo esc_html($c_name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="m3-resource-select-wrap">
                        <label for="m3-resource-tag" class="screen-reader-text"><?php esc_html_e('Tag', 'm3-big-red'); ?></label>
                        <select id="m3-resource-tag" name="rtag">
                            <option value=""><?php esc_html_e('All Tags', 'm3-big-red'); ?></option>
                            <?php foreach ($all_tags as $t_slug => $t_name) : ?>
                                <option value="<?php echo esc_attr($t_slug); ?>" <?php selected($res_tag, $t_slug); ?>>
                                    #<?php echo esc_html($t_name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <input type="hidden" name="type" value="<?php echo esc_attr($res_type); ?>" />

                    <button type="submit" class="btn btn--page-accent">
                        <span><?php esc_html_e('FILTER', 'm3-big-red'); ?></span>
                    </button>

                    <?php if ($res_search || 'all' !== $res_type || $res_category || $res_tag) : ?>
                        <a href="<?php echo esc_url($resources_base_url); ?>#toolkits" class="btn btn--streetwear-outline">
                            <span><?php esc_html_e('RESET', 'm3-big-red'); ?></span>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- RESOURCE TYPE TABS -->
                <div class="portfolio-filters m3-resource-type-tabs" role="tablist" aria-label="<?php esc_attr_e('Filter resources by type', 'm3-big-red'); ?>">
                    <?php foreach ($allowed_types as $t_key => $t_label) :
                        $tab_url = add_query_arg(
                            array_filter(array(
                                'type' => 'all' === $t_key ? null : $t_key,
                                'q'    => $res_search ?: null,
                                'rcat' => $res_category ?: null,
                                'rtag' => $res_tag ?: null,
                            )),
                            $resources_base_url
                        ) . '#toolkits';
                    ?>
                        <a
                            href="<?php echo esc_url($tab_url); ?>"
                            class="filter-btn <?php echo $res_type === $t_key ? 'active' : ''; ?>"
                            role="tab"
                            aria-selected="<?php echo $res_type === $t_key ? 'true' : 'false'; ?>"
                        >
                            <?php echo esc_html($t_label); ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="m3-resource-meta-bar">
                    <span class="m3-resource-count">
                        SHOWING <strong><?php echo esc_html((string) count($items)); ?></strong> OF <strong><?php echo esc_html((string) $total_found); ?></strong> RESOURCES
                    </span>
                    <span class="m3-resource-disclosure">
                        Partner links may include studio affiliate perks at no extra cost to you.
                    </span>
                </div>
            </form>

            <?php if (!empty($items)) : ?>
                <div class="resources-gear-grid">
                    <?php foreach ($items as $res) :
                        $accent        = in_array($res['accent'], array('blue', 'yellow', 'lime', 'red'), true) ? $res['accent'] : 'blue';
                        $access        = sanitize_key($res['access'] ?: 'free');
                        $can_access    = function_exists('mileym3dia_user_can_access_resource')
                            ? mileym3dia_user_can_access_resource($res['id'], null, $access)
                            : ('free' === $access);
                        $type_badge    = isset($type_labels[$res['type']]) ? $type_labels[$res['type']] : strtoupper($res['type']);
                        $is_external   = ('download' !== $res['type']) && (0 === strpos((string) $res['url'], 'http')) && (false === strpos((string) $res['url'], home_url()));
                        $action_url    = $res['url'];
                        if ('free' !== $access) {
                            $action_url = $can_access
                                ? mileym3dia_get_resource_download_url($res['id'], $res['url'], $access)
                                : ('pro' === $access ? $store_url . '#catalog' : add_query_arg('tab', 'register', $hub_url) . '#portal-access');
                        }
                    ?>
                        <article class="resource-gear-card resource-gear-card--<?php echo esc_attr($accent); ?>" data-resource-type="<?php echo esc_attr($res['type']); ?>" data-resource-access="<?php echo esc_attr($access); ?>">
                            <div class="gear-card-top">
                                <span class="gear-card-badge text-<?php echo esc_attr($accent); ?>"><?php echo esc_html($res['badge']); ?></span>
                                <span class="gear-status-tag">
                                    <?php
                                    if ('pro' === $access) {
                                        echo 'PRO VAULT';
                                    } elseif ('member' === $access) {
                                        echo 'MEMBER FREE';
                                    } else {
                                        echo esc_html($type_badge);
                                    }
                                    ?>
                                </span>
                            </div>

                            <div class="gear-card-content">
                                <h3 class="gear-card-title"><?php echo esc_html($res['title']); ?></h3>
                                <p class="gear-card-desc"><?php echo esc_html($res['desc']); ?></p>

                                <div class="gear-card-specs">
                                    <div class="spec-row"><span class="spec-label">FORMAT:</span><span class="spec-val"><?php echo esc_html($res['format']); ?></span></div>
                                    <div class="spec-row"><span class="spec-label">DETAILS:</span><span class="spec-val"><?php echo esc_html($res['compatibility']); ?></span></div>
                                    <?php if (!empty($res['affiliate_code'])) : ?>
                                        <div class="spec-row"><span class="spec-label">PROMO CODE:</span><span class="spec-val text-yellow"><strong><?php echo esc_html($res['affiliate_code']); ?></strong></span></div>
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($res['tags'])) : ?>
                                    <div class="m3-resource-tags">
                                        <?php foreach (array_slice((array) $res['tags'], 0, 4) as $tg) :
                                            $tg_slug = sanitize_title($tg);
                                            $tg_url  = add_query_arg('rtag', $tg_slug, $resources_base_url) . '#toolkits';
                                        ?>
                                            <a href="<?php echo esc_url($tg_url); ?>" class="m3-resource-tag-pill">#<?php echo esc_html($tg_slug); ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="gear-card-footer">
                                <?php if ('free' === $access || $can_access) : ?>
                                    <a
                                        href="<?php echo esc_url($action_url); ?>"
                                        class="btn btn--streetwear-outline btn--full"
                                        <?php echo ('download' === $res['type'] && 'free' === $access) ? 'download' : ''; ?>
                                        <?php echo $is_external ? 'target="_blank" rel="noopener noreferrer' . ('affiliate' === $res['type'] ? ' sponsored' : '') . '"' : ''; ?>
                                    >
                                        <?php echo esc_html($res['btn_text']); ?> <?php echo 'download' === $res['type'] ? '↓' : '↗'; ?>
                                    </a>
                                <?php elseif ('pro' === $access) : ?>
                                    <a href="<?php echo esc_url($action_url); ?>" class="btn btn--page-accent btn--full">
                                        UNLOCK WITH PRO PASS →
                                    </a>
                                <?php else : ?>
                                    <a href="<?php echo esc_url($action_url); ?>" class="btn btn--page-accent btn--full">
                                        FREE ACCOUNT TO UNLOCK →
                                    </a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <?php if ($max_pages > 1) : ?>
                    <nav class="m3-resource-pagination" aria-label="<?php esc_attr_e('Resource library pagination', 'm3-big-red'); ?>">
                        <?php for ($p = 1; $p <= $max_pages; $p++) :
                            $page_url = add_query_arg(
                                array_filter(array(
                                    'type'  => 'all' === $res_type ? null : $res_type,
                                    'q'     => $res_search ?: null,
                                    'rcat'  => $res_category ?: null,
                                    'rtag'  => $res_tag ?: null,
                                    'rpage' => $p > 1 ? $p : null,
                                )),
                                $resources_base_url
                            ) . '#toolkits';
                        ?>
                            <a href="<?php echo esc_url($page_url); ?>" class="filter-btn <?php echo $p === $current_page ? 'active' : ''; ?>" <?php echo $p === $current_page ? 'aria-current="page"' : ''; ?>>
                                <?php echo esc_html(str_pad((string) $p, 2, '0', STR_PAD_LEFT)); ?>
                            </a>
                        <?php endfor; ?>
                    </nav>
                <?php endif; ?>
            <?php else : ?>
                <div class="portal-notice" role="status">
                    <strong>NO MATCHING RESOURCES //</strong> Try clearing your search query or switching to <strong>ALL RESOURCES</strong>.
                    <a href="<?php echo esc_url($resources_base_url); ?>#toolkits" class="text-blue" style="margin-left: 0.75rem;">Reset Directory →</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="section-loose resources-newsletter-section bg-shade-base" id="resources-notify">
        <div class="container">
            <?php
            mileym3dia_newsletter_box(array(
                'eyebrow'     => 'CREATOR RESOURCES',
                'title'       => __('Get New Studio Packs & Updates', 'm3-big-red'),
                'description' => __('Enter your email to receive download links for new LUT packs, free tools, audio libraries, and production templates.', 'm3-big-red'),
                'button_text' => __('GET ACCESS', 'm3-big-red'),
            ));
            ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>

<?php
/**
 * Custom Walker for Navigation Menu
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Mileym3dia_Walker_Nav_Menu
 */
class Mileym3dia_Walker_Nav_Menu extends Walker_Nav_Menu {

    /**
     * Counter for sequential nav item numbers (01, 02, etc.)
     *
     * @var int
     */
    protected $item_count = 0;

    /**
     * Resets counter at the start of menu tree.
     */
    public function walk($elements, $max_depth, ...$args) {
        $this->item_count = 0;
        return parent::walk($elements, $max_depth, ...$args);
    }

    /**
     * Resolves the canonical tag for a navigation label.
     */
    public static function get_subtag_for_item($title) {
        $clean = strtoupper(trim(strip_tags($title)));
        $map = array(
            'HOME'        => 'START',
            'ABOUT'       => 'MANIFESTO',
            'SERVICES'    => 'DISCIPLINES',
            'WORK'        => 'PORTFOLIO',
            'PORTFOLIO'   => 'ARCHIVE',
            'STORE'       => 'SHOP',
            'SHOP'        => 'STORE',
            'PRICING'     => 'PACKAGES',
            'BLOG'        => 'JOURNAL',
            'JOURNAL'     => 'DISPATCHES',
            'CONTACT'     => 'INQUIRIES',
            'RESOURCES'   => 'REPOSITORY',
            'CREATOR HUB' => 'MEMBER STUDIO',
            'PORTAL'      => 'REGISTER',
        );

        foreach ($map as $key => $tag) {
            if (false !== strpos($clean, $key)) {
                return $tag;
            }
        }

        return 'STUDIO';
    }

    /**
     * Dynamically normalizes menu item URLs to valid WordPress page routes.
     */
    public static function resolve_dynamic_url($raw_url, $title) {
        $trimmed_url = trim((string) $raw_url);
        $clean_title = strtolower(trim(strip_tags((string) $title)));

        if (preg_match('#/pricing/?$#i', $trimmed_url)) {
            return mileym3dia_get_pricing_page_url();
        }

        $has_specific_anchor = (false !== strpos($trimmed_url, '#') && !preg_match('/^(\/)?#[a-z0-9_-]*$/i', $trimmed_url));
        $is_core_nav_label   = in_array($clean_title, array('home', 'start', 'about', 'manifesto', 'services', 'disciplines', 'work', 'portfolio', 'store', 'shop', 'pricing', 'packages', 'blog', 'journal', 'contact', 'inquiries', 'resources', 'creator hub', 'portal', 'register'), true);

        $is_hash = (
            '' === $trimmed_url ||
            '#' === $trimmed_url ||
            home_url('/') === $trimmed_url ||
            home_url('/#') === $trimmed_url ||
            preg_match('/^(\/)?#([a-z0-9_-]+)$/i', $trimmed_url, $hash_match)
        );

        if (!$is_hash && !($is_core_nav_label && !$has_specific_anchor)) {
            return $raw_url;
        }

        // 1. Check title keywords
        if (false !== strpos($clean_title, 'home') || 'start' === $clean_title) {
            return home_url('/');
        }
        if (false !== strpos($clean_title, 'about') || false !== strpos($clean_title, 'manifesto')) {
            return mileym3dia_get_page_url('about');
        }
        if (false !== strpos($clean_title, 'service') || false !== strpos($clean_title, 'discipline')) {
            return mileym3dia_get_page_url('services');
        }
        if (false !== strpos($clean_title, 'work') || false !== strpos($clean_title, 'portfolio')) {
            return mileym3dia_get_work_page_url();
        }
        if (false !== strpos($clean_title, 'store') || false !== strpos($clean_title, 'shop')) {
            return mileym3dia_get_page_url('store');
        }
        if (false !== strpos($clean_title, 'pricing') || false !== strpos($clean_title, 'package')) {
            return mileym3dia_get_pricing_page_url();
        }
        if (false !== strpos($clean_title, 'blog') || false !== strpos($clean_title, 'journal') || false !== strpos($clean_title, 'dispatch') || false !== strpos($clean_title, 'article')) {
            return mileym3dia_get_blog_page_url();
        }
        if (false !== strpos($clean_title, 'contact') || false !== strpos($clean_title, 'inquir')) {
            return mileym3dia_get_page_url('contact');
        }
        if (false !== strpos($clean_title, 'resource') || false !== strpos($clean_title, 'tool')) {
            return mileym3dia_get_page_url('resources');
        }
        if (false !== strpos($clean_title, 'creator') || false !== strpos($clean_title, 'hub') || false !== strpos($clean_title, 'portal') || false !== strpos($clean_title, 'register')) {
            return mileym3dia_get_page_url('creator-hub');
        }

        // 2. Check hash slug if title didn't match
        if (!empty($hash_match[2])) {
            $slug = strtolower($hash_match[2]);
            if ('pricing' === $slug) {
                return mileym3dia_get_pricing_page_url();
            }
            if ('work' === $slug || 'portfolio' === $slug) {
                return mileym3dia_get_work_page_url();
            }
            if ('store' === $slug || 'shop' === $slug) {
                return mileym3dia_get_page_url('store');
            }
            if ('blog' === $slug || 'journal' === $slug) {
                return mileym3dia_get_blog_page_url();
            }
            return mileym3dia_get_page_url($slug);
        }

        return $raw_url ?: home_url('/');
    }

    /**
     * Determines whether the item corresponds to the current page view.
     */
    protected function is_item_active($item_url, $item_title) {
        $clean_title = strtolower(trim(strip_tags($item_title)));

        if (is_front_page()) {
            return (false !== strpos($clean_title, 'home'));
        }

        if (is_page('about') || is_page_template('page-about.php')) {
            return (false !== strpos($clean_title, 'about'));
        }

        if (is_page('services') || is_page_template('page-services.php')) {
            if (false !== strpos($item_url, '#pricing') || false !== strpos($clean_title, 'pricing')) {
                return false;
            }
            return (false !== strpos($clean_title, 'service'));
        }

        if (is_page('work') || is_page('portfolio') || is_page_template('page-portfolio.php') || is_page_template('page-work.php') || is_post_type_archive('project') || is_singular('project')) {
            return (false !== strpos($clean_title, 'work') || false !== strpos($clean_title, 'portfolio'));
        }

        if (is_page('store') || is_page('shop') || is_page_template('page-store.php') || (function_exists('is_woocommerce') && is_woocommerce())) {
            return (false !== strpos($clean_title, 'store') || false !== strpos($clean_title, 'shop'));
        }

        if (is_home() || (is_archive() && !is_post_type_archive('project')) || is_singular('post') || is_search()) {
            return (false !== strpos($clean_title, 'blog') || false !== strpos($clean_title, 'journal'));
        }

        if (is_page('contact') || is_page_template('page-contact.php')) {
            return (false !== strpos($clean_title, 'contact'));
        }

        if (is_page('resources') || is_page_template('page-resources.php')) {
            return (false !== strpos($clean_title, 'resource'));
        }

        if (is_page('creator-hub') || is_page_template('page-creator-hub.php')) {
            return (false !== strpos($clean_title, 'creator') || false !== strpos($clean_title, 'hub') || false !== strpos($clean_title, 'portal'));
        }

        return false;
    }

    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if (isset($args->walker) && is_object($args->walker)) {
            $args->walker = $this;
        }

        $this->item_count++;
        $num_str = str_pad($this->item_count, 2, '0', STR_PAD_LEFT);

        $is_mobile = (
            (isset($args->theme_location) && 'mobile' === $args->theme_location) ||
            (isset($args->menu_class) && false !== strpos($args->menu_class, 'mobile-nav-menu'))
        );

        $resolved_url = self::resolve_dynamic_url($item->url, $item->title);
        $is_active    = in_array('current-menu-item', (array) $item->classes, true) || $this->is_item_active($resolved_url, $item->title);

        $classes   = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $classes[] = $is_mobile ? 'mobile-nav-item' : 'nav-item';
        $classes[] = 'nav-item-depth-' . $depth;

        if ($is_active) {
            $classes[] = 'active';
            $classes[] = 'current-menu-item';
        }

        $has_children = in_array('menu-item-has-children', $classes, true);
        if ($has_children) {
            $classes[] = 'has-submenu';
            $classes[] = 'has-dropdown';
        }

        $class_names = join(' ', array_unique(array_filter($classes)));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $atts = array();
        $atts['title']        = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target']       = !empty($item->target) ? $item->target : '';
        $atts['rel']          = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']         = esc_url($resolved_url);
        $atts['aria-current'] = $is_active ? 'page' : '';
        $atts['data-number']  = $num_str;

        if ($has_children) {
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value       = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_title = apply_filters('the_title', $item->title, $item->ID);

        $output .= '<li' . $class_names . '>';

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';

        if ($is_mobile) {
            $subtag = self::get_subtag_for_item($item_title);
            $item_output .= '<span class="nav-num">' . esc_html($num_str) . '</span>';
            $item_output .= '<span class="nav-label">' . esc_html($item_title) . '</span>';
            $item_output .= '<span class="nav-tag">' . esc_html($subtag) . '</span>';
        } else {
            $item_output .= isset($args->link_before) ? $args->link_before : '';
            $item_output .= esc_html($item_title);
            if ($has_children && $depth === 0) {
                $item_output .= ' <span class="nav-caret" aria-hidden="true">▾</span>';
            }
            $item_output .= isset($args->link_after) ? $args->link_after : '';
        }

        $item_output .= '</a>';
        if ($is_mobile && $has_children) {
            $item_output .= '<button type="button" class="mobile-sub-toggle" aria-label="Toggle submenu">▾</button>';
        }
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu sub-menu-depth-" . ($depth + 1) . "\">\n";
    }
}

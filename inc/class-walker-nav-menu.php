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
     * Optional mobile subtag: strictly uses the WordPress Menu Item Description if set,
     * never injects hardcoded labels like "ARCHIVE" or "REPOSITORY".
     */
    public static function get_subtag_for_item($title, $description = '') {
        $desc = trim(strip_tags((string) $description));
        return '' !== $desc ? $desc : '';
    }

    /**
     * Preserves the exact URL configured in WordPress Appearance -> Menus.
     * Never overrides or rewrites intentional menu destinations based on item titles.
     */
    public static function resolve_dynamic_url($raw_url, $title = '') {
        $trimmed_url = trim((string) $raw_url);
        return '' !== $trimmed_url ? $trimmed_url : '#';
    }

    /**
     * Determines whether the item corresponds to the current page view using
     * WordPress native menu classes and normalized URL path matching (never title matching).
     */
    protected function is_item_active($item_url, $item_classes = array()) {
        $native_active = array('current-menu-item', 'current_page_item', 'current-menu-ancestor', 'current-menu-parent', 'current_page_parent');
        foreach ($native_active as $cls) {
            if (in_array($cls, (array) $item_classes, true)) {
                return true;
            }
        }

        $trimmed_url = trim((string) $item_url);
        if ('' === $trimmed_url || '#' === $trimmed_url || 0 === strpos($trimmed_url, '#')) {
            return false;
        }

        $item_path = trim((string) wp_parse_url($trimmed_url, PHP_URL_PATH), '/');
        $req_uri   = isset($_SERVER['REQUEST_URI']) ? (string) wp_unslash($_SERVER['REQUEST_URI']) : '/';
        $curr_path = trim((string) wp_parse_url($req_uri, PHP_URL_PATH), '/');

        if ('' === $item_path) {
            return ('' === $curr_path && is_front_page());
        }

        return ($item_path === $curr_path);
    }

    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if (isset($args->walker) && is_object($args->walker)) {
            $args->walker = $this;
        }

        if (0 === (int) $depth) {
            $this->item_count++;
        }
        $num_str = str_pad($this->item_count, 2, '0', STR_PAD_LEFT);

        $is_mobile = (
            (isset($args->theme_location) && 'mobile' === $args->theme_location) ||
            (isset($args->menu_class) && false !== strpos($args->menu_class, 'mobile-nav-menu'))
        );

        $raw_classes  = empty($item->classes) ? array() : (array) $item->classes;
        $resolved_url = self::resolve_dynamic_url($item->url, $item->title);
        $is_active    = $this->is_item_active($resolved_url, $raw_classes);

        $classes   = $raw_classes;
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
            if ($is_mobile) {
                $classes[] = 'mobile-nav-has-children';
            }
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
        if ($is_mobile && $has_children && 0 === (int) $depth) {
            $item_output .= '<div class="mobile-nav-link-row">';
        }
        $item_output .= '<a' . $attributes . '>';

        if ($is_mobile && 0 === (int) $depth) {
            $subtag = self::get_subtag_for_item($item_title, isset($item->description) ? $item->description : '');
            $item_output .= '<span class="nav-num">' . esc_html($num_str) . '</span>';
            $item_output .= '<span class="nav-label">' . esc_html($item_title) . '</span>';
            if ('' !== $subtag) {
                $item_output .= '<span class="nav-tag">' . esc_html($subtag) . '</span>';
            }
        } else {
            $item_output .= isset($args->link_before) ? $args->link_before : '';
            $item_output .= esc_html($item_title);
            if ($has_children && 0 === (int) $depth) {
                $item_output .= ' <span class="nav-caret" aria-hidden="true">▾</span>';
            }
            $item_output .= isset($args->link_after) ? $args->link_after : '';
        }

        $item_output .= '</a>';
        if ($is_mobile && $has_children && 0 === (int) $depth) {
            $item_output .= '<button type="button" class="mobile-sub-toggle" aria-label="Toggle submenu">▾</button>';
            $item_output .= '</div>';
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

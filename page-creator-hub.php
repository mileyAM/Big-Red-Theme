<?php
/**
 * Template Name: Creator Hub
 * Description: Client & Creator Membership Portal with Registration, Sign-In, Password Recovery,
 * Authenticated Member Dashboard, Profile Editor, Live Studio Project Tracker, In-Portal Project Briefs,
 * and Tier-Gated Member Deliverables Vault.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$hub_eyebrow  = get_theme_mod('mileym3dia_hub_eyebrow', 'CLIENT & CREATOR PORTAL');
$hub_subtitle = get_theme_mod('mileym3dia_hub_subtitle', 'Register your free creator or client account, manage your studio profile, track active deliverables, and unlock protected production assets.');
$hub_url      = mileym3dia_get_page_url('creator-hub');
$store_url    = mileym3dia_get_page_url('store');
$res_url      = mileym3dia_get_page_url('resources');

$active_tab = isset($_GET['tab']) ? sanitize_key(wp_unslash($_GET['tab'])) : 'register';
if (!in_array($active_tab, array('login', 'register', 'reset'), true)) {
    $active_tab = 'register';
}

$auth_status  = isset($_GET['auth']) ? sanitize_key(wp_unslash($_GET['auth'])) : '';
$auth_err     = isset($_GET['auth_error']) ? sanitize_text_field(wp_unslash($_GET['auth_error'])) : '';

// Verified authentication only — never trust URL query parameters
$is_logged_in = function_exists('is_user_logged_in') && is_user_logged_in();
$current_user = ($is_logged_in && function_exists('wp_get_current_user')) ? wp_get_current_user() : null;
$user_id      = ($current_user && isset($current_user->ID)) ? (int) $current_user->ID : 0;
$user_tier    = $is_logged_in && function_exists('mileym3dia_get_user_membership_tier') ? mileym3dia_get_user_membership_tier($user_id) : 'guest';
$user_name    = ($current_user && !empty($current_user->display_name)) ? $current_user->display_name : (($current_user && !empty($current_user->user_login)) ? $current_user->user_login : 'Creator');
$user_login   = ($current_user && !empty($current_user->user_login)) ? $current_user->user_login : '';
$user_email   = ($current_user && !empty($current_user->user_email)) ? $current_user->user_email : '';
$user_url     = ($current_user && !empty($current_user->user_url)) ? $current_user->user_url : '';
$user_bio     = ($current_user && !empty($current_user->description)) ? $current_user->description : '';
$user_company = ($user_id > 0 && function_exists('get_user_meta')) ? (string) get_user_meta($user_id, 'm3_company', true) : '';
$user_type    = ($user_id > 0 && function_exists('get_user_meta')) ? (string) get_user_meta($user_id, 'm3_account_type', true) : 'creator';

// Fetch member's submitted project briefs (`m3_inquiry` CPT) if logged in
$member_briefs = array();
if ($is_logged_in && $user_id > 0 && post_type_exists('m3_inquiry') && class_exists('WP_Query')) {
    $brief_q = new WP_Query(array(
        'post_type'      => 'm3_inquiry',
        'post_status'    => 'publish',
        'author'         => $user_id,
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));
    if (!empty($brief_q->posts)) {
        foreach ($brief_q->posts as $bp) {
            $member_briefs[] = array(
                'title'      => $bp->post_title,
                'discipline' => get_post_meta($bp->ID, '_m3_brief_discipline', true) ?: 'Production Brief',
                'timeline'   => get_post_meta($bp->ID, '_m3_brief_timeline', true) ?: 'Scheduled',
                'status'     => get_post_meta($bp->ID, '_m3_brief_status', true) ?: 'IN REVIEW',
                'progress'   => (int) (get_post_meta($bp->ID, '_m3_brief_progress', true) ?: 20),
            );
        }
    }
}
if ($is_logged_in && empty($member_briefs) && function_exists('mileym3dia_preview_get_briefs')) {
    $member_briefs = mileym3dia_preview_get_briefs();
}

// Vault resources from the scalable `m3_resource` catalog (prioritizing member/pro & downloadable files)
$vault_query = function_exists('mileym3dia_get_resources')
    ? mileym3dia_get_resources(array('per_page' => 6, 'type' => 'download'))
    : array('items' => array());
$vault_files = !empty($vault_query['items']) ? $vault_query['items'] : array();
?>

<main id="primary" class="site-main creator-hub-main">

    <!-- OFFICIAL MILEYM3DIA CREATOR HUB BANNER (PURPLE / BLUE PLATE) -->
    <?php
    if (function_exists('mileym3dia_render_page_banner')) {
        mileym3dia_render_page_banner('creator_hub', array(
            'heading_tag'      => 'h1',
            'override_eyebrow' => $hub_eyebrow,
            'override_subhead' => $hub_subtitle,
        ));
    }
    ?>

    <?php while (have_posts()) : the_post(); ?>
        <?php if (trim(get_the_content())) : ?>
            <section class="section-loose creator-hub-content bg-shade-base">
                <div class="container">
                    <div class="entry-content reading-column">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endwhile; ?>

    <!-- AUTHENTICATION / MEMBER DASHBOARD PORTAL -->
    <section class="creator-hub-foundation-section section-loose bg-shade-elevated" id="portal-access">
        <div class="container container--wide">

            <?php if ('registered' === $auth_status && $is_logged_in) : ?>
                <div class="portal-notice portal-notice--success" role="status">
                    <strong>ACCOUNT CREATED //</strong> Welcome to the M3 Creator Hub, <?php echo esc_html($user_name); ?>! Your free membership is active and member downloads are unlocked below.
                </div>
            <?php elseif ('logged_in' === $auth_status && $is_logged_in) : ?>
                <div class="portal-notice portal-notice--success" role="status">
                    <strong>SIGNED IN //</strong> Welcome back, <?php echo esc_html($user_name); ?>. Your member dashboard and deliverables vault are ready.
                </div>
            <?php elseif ('logged_out' === $auth_status) : ?>
                <div class="portal-notice" role="status">
                    <strong>SIGNED OUT //</strong> Your Creator Hub session has been closed securely.
                </div>
            <?php elseif ('reset_sent' === $auth_status) : ?>
                <div class="portal-notice portal-notice--success" role="status">
                    <strong>PASSWORD RESET SENT //</strong> If an account matches that username or email, recovery instructions have been sent.
                </div>
            <?php elseif ('profile_updated' === $auth_status && $is_logged_in) : ?>
                <div class="portal-notice portal-notice--success" role="status">
                    <strong>PROFILE UPDATED //</strong> Your Creator Hub studio profile settings have been saved.
                </div>
            <?php elseif ('brief_submitted' === $auth_status && $is_logged_in) : ?>
                <div class="portal-notice portal-notice--success" role="status">
                    <strong>BRIEF LOGGED //</strong> Your project brief has been added to your Live Studio Project Tracker and sent to our producers.
                </div>
            <?php elseif (!empty($auth_err)) : ?>
                <div class="portal-notice portal-notice--error" role="alert">
                    <strong>AUTHENTICATION NOTICE //</strong> <?php echo esc_html($auth_err); ?>
                </div>
            <?php endif; ?>

            <?php if ($is_logged_in) : ?>
                <!-- AUTHENTICATED MEMBER DASHBOARD -->
                <div class="m3-member-dashboard">
                    <div class="m3-member-topbar">
                        <div class="m3-member-identity">
                            <span class="hub-status-dot"></span>
                            <div>
                                <span class="m3-member-eyebrow">AUTHENTICATED MEMBER // <?php echo esc_html(strtoupper($user_type ?: 'CREATOR')); ?></span>
                                <h2 class="m3-member-name"><?php echo esc_html($user_name); ?> <span class="m3-tier-badge m3-tier-badge--<?php echo esc_attr($user_tier); ?>"><?php echo esc_html(strtoupper($user_tier)); ?> TIER</span></h2>
                            </div>
                        </div>

                        <div class="m3-member-actions">
                            <div class="m3-promo-pill" title="Member Discount Code">
                                <span>MEMBER CODE:</span> <strong>M3FIRST10</strong> <small>(10% OFF 1ST PROJECT)</small>
                            </div>
                            <a href="<?php echo esc_url(mileym3dia_get_account_url()); ?>" class="btn btn--streetwear-outline">
                                <span>ORDERS &amp; DOWNLOADS</span>
                            </a>
                            <form method="post" action="<?php echo esc_url($hub_url); ?>" class="m3-logout-form">
                                <?php if (function_exists('wp_nonce_field')) { wp_nonce_field('mileym3dia_logout_action', 'mileym3dia_logout_nonce'); } ?>
                                <input type="hidden" name="mileym3dia_action" value="logout_user" />
                                <button type="submit" class="btn btn--streetwear-red"><span>SIGN OUT</span></button>
                            </form>
                        </div>
                    </div>

                    <div class="hub-portal-layout m3-dashboard-layout">
                        <!-- LEFT: DASHBOARD WORKSPACE TABS -->
                        <div class="hub-auth-card">
                            <div class="hub-auth-tabs" role="tablist" aria-label="<?php esc_attr_e('Member dashboard sections', 'm3-big-red'); ?>">
                                <button type="button" class="hub-auth-tab active" data-tab="overview" role="tab" aria-selected="true">
                                    01 // PROJECT TRACKER
                                </button>
                                <button type="button" class="hub-auth-tab" data-tab="profile" role="tab" aria-selected="false">
                                    02 // PROFILE SETTINGS
                                </button>
                                <button type="button" class="hub-auth-tab" data-tab="brief" role="tab" aria-selected="false">
                                    03 // SUBMIT BRIEF
                                </button>
                            </div>

                            <!-- PANEL 1: LIVE STUDIO PROJECT TRACKER -->
                            <div class="hub-auth-panel active" id="hub-panel-overview" role="tabpanel">
                                <div class="hub-auth-panel__header">
                                    <h3>ACTIVE PROJECTS &amp; DELIVERABLES</h3>
                                    <p>Track production milestones, review status, and deliverables for your active MILEYM3DIA studio bookings.</p>
                                </div>

                                <div class="m3-tracker-list">
                                    <?php if (!empty($member_briefs)) : ?>
                                        <?php foreach ($member_briefs as $mb) : ?>
                                            <div class="m3-tracker-item">
                                                <div class="m3-tracker-item__top">
                                                    <strong><?php echo esc_html($mb['title']); ?></strong>
                                                    <span class="m3-tracker-status"><?php echo esc_html($mb['status']); ?></span>
                                                </div>
                                                <div class="m3-tracker-item__meta">
                                                    <span><?php echo esc_html($mb['discipline']); ?></span>
                                                    <span>TARGET: <?php echo esc_html($mb['timeline']); ?></span>
                                                </div>
                                                <div class="m3-tracker-bar" aria-label="Progress <?php echo esc_attr((string) $mb['progress']); ?>%">
                                                    <div class="m3-tracker-bar__fill" style="width: <?php echo esc_attr((string) min(100, max(5, (int) $mb['progress']))); ?>%;"></div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div class="m3-tracker-item">
                                            <div class="m3-tracker-item__top">
                                                <strong>CREATOR HUB ONBOARDING &amp; VAULT ACCESS</strong>
                                                <span class="m3-tracker-status m3-tracker-status--lime">ACTIVE</span>
                                            </div>
                                            <div class="m3-tracker-item__meta">
                                                <span>Brand / Studio: <?php echo esc_html($user_company ?: 'Independent Creator'); ?></span>
                                                <span>Membership: <?php echo esc_html(strtoupper($user_tier)); ?></span>
                                            </div>
                                            <div class="m3-tracker-bar"><div class="m3-tracker-bar__fill" style="width: 100%;"></div></div>
                                        </div>
                                        <div class="m3-tracker-item">
                                            <div class="m3-tracker-item__top">
                                                <strong>NO ACTIVE PRODUCTION BRIEF YET</strong>
                                                <span class="m3-tracker-status">READY TO START</span>
                                            </div>
                                            <div class="m3-tracker-item__meta">
                                                <span>Use tab 03 // SUBMIT BRIEF to launch a video, photo, audio, brand, or web sprint.</span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- PANEL 2: MEMBER PROFILE EDITOR -->
                            <div class="hub-auth-panel" id="hub-panel-profile" role="tabpanel">
                                <div class="hub-auth-panel__header">
                                    <h3>EDIT MEMBER PROFILE</h3>
                                    <p>Update your studio contact details, brand affiliation, account type, or password.</p>
                                </div>

                                <form class="contact-form hub-form" method="post" action="<?php echo esc_url($hub_url . '#portal-access'); ?>">
                                    <?php if (function_exists('wp_nonce_field')) { wp_nonce_field('mileym3dia_profile_action', 'mileym3dia_profile_nonce'); } ?>
                                    <input type="hidden" name="mileym3dia_action" value="update_profile" />

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="profile-display-name">DISPLAY NAME *</label>
                                            <input type="text" id="profile-display-name" name="profile_display_name" value="<?php echo esc_attr($user_name); ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="profile-email">EMAIL ADDRESS *</label>
                                            <input type="email" id="profile-email" name="profile_email" value="<?php echo esc_attr($user_email); ?>" required />
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="profile-company">BRAND / STUDIO / PROJECT CODE</label>
                                            <input type="text" id="profile-company" name="profile_company" value="<?php echo esc_attr($user_company); ?>" placeholder="Your brand or label" />
                                        </div>
                                        <div class="form-group">
                                            <label for="profile-account-type">ACCOUNT TYPE</label>
                                            <select id="profile-account-type" name="profile_account_type">
                                                <option value="creator" <?php selected($user_type, 'creator'); ?>>Creator / Filmmaker</option>
                                                <option value="client" <?php selected($user_type, 'client'); ?>>Studio Client</option>
                                                <option value="agency" <?php selected($user_type, 'agency'); ?>>Agency / Production Partner</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="profile-website">PORTFOLIO / WEBSITE URL</label>
                                            <input type="url" id="profile-website" name="profile_website" value="<?php echo esc_attr($user_url); ?>" placeholder="https://..." />
                                        </div>
                                        <div class="form-group">
                                            <label for="profile-new-password">NEW PASSWORD (OPTIONAL)</label>
                                            <input type="password" id="profile-new-password" name="profile_new_password" placeholder="Leave blank to keep current" minlength="6" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="profile-bio">CREATOR / PROJECT BIO</label>
                                        <textarea id="profile-bio" name="profile_bio" rows="3" placeholder="Tell our studio team about your visual style, camera setup, or upcoming releases..."><?php echo esc_textarea($user_bio); ?></textarea>
                                    </div>

                                    <button type="submit" class="btn btn--streetwear-red btn--full">
                                        <span>SAVE PROFILE CHANGES →</span>
                                    </button>
                                </form>
                            </div>

                            <!-- PANEL 3: IN-PORTAL PROJECT BRIEF -->
                            <div class="hub-auth-panel" id="hub-panel-brief" role="tabpanel">
                                <div class="hub-auth-panel__header">
                                    <h3>SUBMIT IN-PORTAL PROJECT BRIEF</h3>
                                    <p>Launch a new production brief directly from your Creator Hub dashboard. Mention <strong>M3FIRST10</strong> for 10% off your first booking.</p>
                                </div>

                                <form class="contact-form hub-form" method="post" action="<?php echo esc_url($hub_url . '#portal-access'); ?>">
                                    <?php if (function_exists('wp_nonce_field')) { wp_nonce_field('mileym3dia_brief_action', 'mileym3dia_brief_nonce'); } ?>
                                    <input type="hidden" name="mileym3dia_action" value="submit_brief" />

                                    <div class="form-group">
                                        <label for="brief-title">PROJECT / CAMPAIGN TITLE *</label>
                                        <input type="text" id="brief-title" name="brief_title" placeholder="e.g. Autumn Capsule Music Video & Lookbook" required />
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="brief-discipline">PRIMARY DISCIPLINE</label>
                                            <select id="brief-discipline" name="brief_discipline">
                                                <option value="Video Production">Video Production</option>
                                                <option value="Photography">Photography</option>
                                                <option value="Branding & Graphic Design">Branding &amp; Graphic Design</option>
                                                <option value="Web Design & Development">Web Design &amp; Development</option>
                                                <option value="Music & Audio Production">Music &amp; Audio Production</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="brief-timeline">TARGET LAUNCH TIMELINE</label>
                                            <input type="text" id="brief-timeline" name="brief_timeline" placeholder="e.g. Next 30 Days" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="brief-details">CREATIVE SCOPE &amp; DELIVERABLES *</label>
                                        <textarea id="brief-details" name="brief_details" rows="4" placeholder="Describe your creative vision, deliverables, references, and budget range..." required></textarea>
                                    </div>

                                    <button type="submit" class="btn btn--streetwear-red btn--full">
                                        <span>SUBMIT BRIEF TO STUDIO →</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- RIGHT: MEMBERSHIP TIER & UPGRADE PATH -->
                        <div class="hub-benefits-col">
                            <div class="m3-membership-card">
                                <span class="hub-card-tag text-yellow">MEMBERSHIP TIER</span>
                                <h3 class="hub-card-title">
                                    <?php echo in_array($user_tier, array('pro', 'agency'), true) ? 'PRO STUDIO ACCESS UNLOCKED' : 'FREE CREATOR MEMBERSHIP ACTIVE'; ?>
                                </h3>
                                <p class="hub-card-desc">
                                    <?php if (in_array($user_tier, array('pro', 'agency'), true)) : ?>
                                        You have full access to all Free, Member, and Pro PowerGrade Vault downloads plus priority 48-hour studio turnaround.
                                    <?php else : ?>
                                        Your free Creator Hub account unlocks all member LUTs, call sheets, and project tracking. Upgrade anytime via the WooCommerce Studio Store to unlock Pro 8K RAW PowerGrades and priority retainer booking.
                                    <?php endif; ?>
                                </p>
                                <ul class="m3-tier-perks">
                                    <li>✓ Member Deliverables &amp; Asset Vault</li>
                                    <li>✓ Live Studio Project Tracker &amp; Briefs</li>
                                    <li>✓ 10% First Project Code (<code>M3FIRST10</code>)</li>
                                    <li><?php echo in_array($user_tier, array('pro', 'agency'), true) ? '✓' : '○'; ?> Pro 8K RAW PowerGrades &amp; Retainer Priority</li>
                                </ul>
                                <?php if (!in_array($user_tier, array('pro', 'agency'), true)) : ?>
                                    <a href="<?php echo esc_url(home_url('/product/priority-4k-retainer-day-pass/')); ?>" class="btn btn--streetwear-red btn--full">
                                        <span>UPGRADE TO PRO TIER →</span>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="hub-quick-links">
                                <a href="#member-vault" class="btn btn--streetwear-outline"><span>OPEN DOWNLOAD VAULT ↓</span></a>
                                <a href="<?php echo esc_url($res_url); ?>" class="btn btn--streetwear-outline"><span>FULL RESOURCE DIRECTORY →</span></a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else : ?>
                <!-- GUEST VIEW: TABBED REGISTRATION, SIGN-IN & PASSWORD RECOVERY -->
                <div class="hub-portal-layout">
                    <div class="hub-auth-card">
                        <div class="hub-auth-tabs" role="tablist" aria-label="<?php esc_attr_e('Account authentication tabs', 'm3-big-red'); ?>">
                            <button type="button" class="hub-auth-tab <?php echo 'register' === $active_tab ? 'active' : ''; ?>" data-tab="register" role="tab" aria-selected="<?php echo 'register' === $active_tab ? 'true' : 'false'; ?>">
                                01 // CREATE ACCOUNT
                            </button>
                            <button type="button" class="hub-auth-tab <?php echo 'login' === $active_tab ? 'active' : ''; ?>" data-tab="login" role="tab" aria-selected="<?php echo 'login' === $active_tab ? 'true' : 'false'; ?>">
                                02 // SIGN IN
                            </button>
                            <button type="button" class="hub-auth-tab <?php echo 'reset' === $active_tab ? 'active' : ''; ?>" data-tab="reset" role="tab" aria-selected="<?php echo 'reset' === $active_tab ? 'true' : 'false'; ?>">
                                03 // RESET PASSWORD
                            </button>
                        </div>

                        <!-- REGISTER PANEL -->
                        <div class="hub-auth-panel <?php echo 'register' === $active_tab ? 'active' : ''; ?>" id="hub-panel-register" role="tabpanel">
                            <div class="hub-auth-panel__header">
                                <h3><?php echo esc_html(get_theme_mod('mileym3dia_hub_register_heading', 'CREATE FREE STUDIO ACCOUNT')); ?></h3>
                                <p>Start with a free Creator Hub membership to unlock protected LUTs &amp; templates, track client projects, and claim 10% off your first booking.</p>
                            </div>

                            <form class="contact-form hub-form" method="post" action="<?php echo esc_url($hub_url . '#portal-access'); ?>">
                                <?php if (function_exists('wp_nonce_field')) { wp_nonce_field('mileym3dia_register_action', 'mileym3dia_register_nonce'); } ?>
                                <input type="hidden" name="mileym3dia_action" value="register_user" />

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="reg-fullname">FULL NAME *</label>
                                        <input type="text" id="reg-fullname" name="reg_fullname" placeholder="Alex Mercer" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="reg-username">USERNAME *</label>
                                        <input type="text" id="reg-username" name="reg_username" placeholder="alexmercer" required />
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="reg-email">EMAIL ADDRESS *</label>
                                        <input type="email" id="reg-email" name="reg_email" placeholder="alex@studio.com" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="reg-account-type">ACCOUNT TYPE</label>
                                        <select id="reg-account-type" name="reg_account_type">
                                            <option value="creator">Creator / Filmmaker (Free Membership)</option>
                                            <option value="client">Studio Client (Project Deliverables)</option>
                                            <option value="agency">Agency / Production Partner</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="reg-company">BRAND / STUDIO / PROJECT CODE</label>
                                        <input type="text" id="reg-company" name="reg_company" placeholder="Optional: Brand name or project ID" />
                                    </div>
                                    <div class="form-group">
                                        <label for="reg-password">PASSWORD *</label>
                                        <input type="password" id="reg-password" name="reg_password" placeholder="Min. 6 characters" minlength="6" required />
                                    </div>
                                </div>

                                <button type="submit" class="btn btn--streetwear-red btn--full">
                                    <span><?php echo esc_html(get_theme_mod('mileym3dia_hub_register_btn', 'REGISTER FREE ACCOUNT →')); ?></span>
                                </button>
                            </form>
                        </div>

                        <!-- SIGN IN PANEL -->
                        <div class="hub-auth-panel <?php echo 'login' === $active_tab ? 'active' : ''; ?>" id="hub-panel-login" role="tabpanel">
                            <div class="hub-auth-panel__header">
                                <h3><?php echo esc_html(get_theme_mod('mileym3dia_hub_login_heading', 'CLIENT & MEMBER SIGN IN')); ?></h3>
                                <p>Sign in with your username or email address to access your Member Dashboard, profile settings, and protected asset vault.</p>
                            </div>

                            <form class="contact-form hub-form" method="post" action="<?php echo esc_url($hub_url . '#portal-access'); ?>">
                                <?php if (function_exists('wp_nonce_field')) { wp_nonce_field('mileym3dia_login_action', 'mileym3dia_login_nonce'); } ?>
                                <input type="hidden" name="mileym3dia_action" value="login_user" />

                                <div class="form-group">
                                    <label for="login-username">USERNAME OR EMAIL *</label>
                                    <input type="text" id="login-username" name="log" placeholder="username or email@studio.com" required />
                                </div>

                                <div class="form-group">
                                    <label for="login-password">PASSWORD *</label>
                                    <input type="password" id="login-password" name="pwd" placeholder="••••••••••••" required />
                                </div>

                                <div class="hub-form-meta">
                                    <label class="hub-checkbox">
                                        <input type="checkbox" name="rememberme" value="forever" checked />
                                        <span>Keep my studio session signed in</span>
                                    </label>
                                    <a href="<?php echo esc_url(add_query_arg('tab', 'reset', $hub_url) . '#portal-access'); ?>" class="hub-forgot-link" data-switch-tab="reset">Reset Password</a>
                                </div>

                                <button type="submit" class="btn btn--streetwear-red btn--full">
                                    <span><?php echo esc_html(get_theme_mod('mileym3dia_hub_login_btn', 'SIGN IN TO PORTAL →')); ?></span>
                                </button>
                            </form>
                        </div>

                        <!-- PASSWORD RECOVERY PANEL -->
                        <div class="hub-auth-panel <?php echo 'reset' === $active_tab ? 'active' : ''; ?>" id="hub-panel-reset" role="tabpanel">
                            <div class="hub-auth-panel__header">
                                <h3>RECOVER STUDIO PASSWORD</h3>
                                <p>Enter your account username or email address and we will send you a secure password reset link.</p>
                            </div>

                            <form class="contact-form hub-form" method="post" action="<?php echo esc_url($hub_url . '#portal-access'); ?>">
                                <?php if (function_exists('wp_nonce_field')) { wp_nonce_field('mileym3dia_reset_action', 'mileym3dia_reset_nonce'); } ?>
                                <input type="hidden" name="mileym3dia_action" value="lost_password" />

                                <div class="form-group">
                                    <label for="reset-user-login">USERNAME OR EMAIL ADDRESS *</label>
                                    <input type="text" id="reset-user-login" name="user_login" placeholder="username or email@studio.com" required />
                                </div>

                                <button type="submit" class="btn btn--streetwear-red btn--full">
                                    <span>SEND RESET LINK →</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- RIGHT: PORTAL STATUS & BENEFIT CARDS -->
                    <div class="hub-benefits-col">
                        <div class="hub-status-banner">
                            <span class="hub-status-dot"></span>
                            <span>PORTAL STATUS: <strong>ONLINE // FREE MEMBERSHIP OPEN</strong></span>
                        </div>

                        <div class="creator-hub-grid">
                            <div class="creator-hub-card">
                                <span class="hub-card-tag text-red">VIDEO &amp; PHOTO</span>
                                <h3 class="hub-card-title"><?php esc_html_e('Client Review & Deliverables', 'm3-big-red'); ?></h3>
                                <p class="hub-card-desc"><?php esc_html_e('Track active production milestones, review cuts, and download high-resolution studio masters.', 'm3-big-red'); ?></p>
                                <div class="hub-card-meta">
                                    <span>4K / 8K MASTERS</span>
                                    <span>LIVE TRACKER</span>
                                </div>
                            </div>

                            <div class="creator-hub-card">
                                <span class="hub-card-tag text-yellow">MUSIC &amp; AUDIO</span>
                                <h3 class="hub-card-title"><?php esc_html_e('Audio Stems & Masters', 'm3-big-red'); ?></h3>
                                <p class="hub-card-desc"><?php esc_html_e('Uncompressed 24-bit WAV mixes, multitrack session stems, and broadcast mastering specs.', 'm3-big-red'); ?></p>
                                <div class="hub-card-meta">
                                    <span>24-BIT / 48KHZ</span>
                                    <span>STUDIO MASTERS</span>
                                </div>
                            </div>

                            <div class="creator-hub-card">
                                <span class="hub-card-tag text-lime">BRAND &amp; WEB</span>
                                <h3 class="hub-card-title"><?php esc_html_e('Brand Kits & Web Assets', 'm3-big-red'); ?></h3>
                                <p class="hub-card-desc"><?php esc_html_e('Logo vector packages, lookbook grid systems, typography licenses, and launch checklists.', 'm3-big-red'); ?></p>
                                <div class="hub-card-meta">
                                    <span>VECTOR &amp; WEB</span>
                                    <span>BRAND GUIDELINES</span>
                                </div>
                            </div>

                            <div class="creator-hub-card">
                                <span class="hub-card-tag text-blue">FREE + PRO TIERS</span>
                                <h3 class="hub-card-title"><?php esc_html_e('Protected Asset Vault', 'm3-big-red'); ?></h3>
                                <p class="hub-card-desc"><?php esc_html_e('Start free today with member downloads & 10% off code M3FIRST10. Upgrade to Pro anytime.', 'm3-big-red'); ?></p>
                                <div class="hub-card-meta">
                                    <span>FREE TO JOIN</span>
                                    <span>PRO READY</span>
                                </div>
                            </div>
                        </div>

                        <div class="hub-quick-links">
                            <a href="#member-vault" class="btn btn--streetwear-outline"><span>PREVIEW MEMBER VAULT ↓</span></a>
                            <a href="<?php echo esc_url($store_url); ?>" class="btn btn--streetwear-outline"><span>BROWSE STUDIO STORE →</span></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </section>

    <!-- PROTECTED MEMBER & CLIENT DOWNLOAD VAULT -->
    <section class="section-loose bg-shade-base" id="member-vault">
        <div class="container container--wide">
            <div class="section-header">
                <div class="section-header-left">
                    <span class="section-label text-blue">PROTECTED STUDIO ASSETS</span>
                    <h2 class="section-title section-title--xl">MEMBER &amp; CLIENT VAULT</h2>
                </div>
                <div class="section-header-right">
                    <a href="<?php echo esc_url($res_url); ?>" class="text-link-arrow">
                        <span><?php esc_html_e('EXPLORE FULL RESOURCE DIRECTORY', 'm3-big-red'); ?></span>
                        <span class="link-arrow">↗</span>
                    </a>
                </div>
            </div>

            <div class="resources-gear-grid">
                <?php foreach ($vault_files as $idx => $vf) :
                    $accent     = in_array($vf['accent'], array('blue', 'yellow', 'lime', 'red'), true) ? $vf['accent'] : 'blue';
                    $access     = sanitize_key($vf['access'] ?: 'free');
                    $can_access = function_exists('mileym3dia_user_can_access_resource')
                        ? mileym3dia_user_can_access_resource($vf['id'], null, $access)
                        : ('free' === $access);
                    $dl_url     = ('free' === $access)
                        ? $vf['url']
                        : mileym3dia_get_resource_download_url($vf['id'], $vf['url'], $access);
                    $code_label = 'VAULT // ' . str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT);
                ?>
                    <article class="resource-gear-card resource-gear-card--<?php echo esc_attr($accent); ?>">
                        <div class="gear-card-top">
                            <span class="gear-card-badge text-<?php echo esc_attr($accent); ?>"><?php echo esc_html($code_label); ?></span>
                            <span class="gear-status-tag">
                                <?php
                                if ('pro' === $access) {
                                    echo $can_access ? 'PRO UNLOCKED' : 'PRO TIER';
                                } elseif ('member' === $access) {
                                    echo $can_access ? 'MEMBER UNLOCKED' : 'MEMBER LOCKED';
                                } else {
                                    echo 'FREE DOWNLOAD';
                                }
                                ?>
                            </span>
                        </div>
                        <div class="gear-card-content">
                            <h3 class="gear-card-title"><?php echo esc_html($vf['title']); ?></h3>
                            <p class="gear-card-desc"><?php echo esc_html($vf['desc']); ?></p>
                        </div>
                        <div class="gear-card-footer">
                            <?php if ($can_access) : ?>
                                <a href="<?php echo esc_url($dl_url); ?>" class="btn btn--streetwear-outline btn--full" <?php echo 'free' === $access ? 'download' : ''; ?>>
                                    <?php echo esc_html($vf['btn_text']); ?> ↓
                                </a>
                            <?php elseif ('pro' === $access) : ?>
                                <a href="<?php echo esc_url(home_url('/product/priority-4k-retainer-day-pass/')); ?>" class="btn btn--streetwear-red btn--full">
                                    UPGRADE TO PRO TO UNLOCK →
                                </a>
                            <?php else : ?>
                                <a href="<?php echo esc_url(add_query_arg('tab', 'register', $hub_url) . '#portal-access'); ?>" class="btn btn--streetwear-red btn--full">
                                    SIGN IN / REGISTER FREE TO DOWNLOAD →
                                </a>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</main>

<script>
(function() {
    var tabs = document.querySelectorAll('.hub-auth-tab');
    var panels = document.querySelectorAll('.hub-auth-panel');
    if (!tabs.length || !panels.length) return;

    function activateTab(target) {
        tabs.forEach(function(t) {
            var isMatch = t.getAttribute('data-tab') === target;
            t.classList.toggle('active', isMatch);
            t.setAttribute('aria-selected', isMatch ? 'true' : 'false');
        });
        panels.forEach(function(p) {
            p.classList.toggle('active', p.id === 'hub-panel-' + target);
        });
    }

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            activateTab(tab.getAttribute('data-tab'));
        });
    });

    document.querySelectorAll('[data-switch-tab]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            activateTab(link.getAttribute('data-switch-tab'));
        });
    });
})();
</script>

<?php get_footer(); ?>

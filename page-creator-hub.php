<?php
/**
 * Template Name: Creator Hub
 * Description: Client & Creator Portal with full Account Registration, Sign-In,
 * and a Client Deliverables & Resource Vault with Customizer-editable files.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$hub_eyebrow  = get_theme_mod('mileym3dia_hub_eyebrow', 'CLIENT & CREATOR PORTAL');
$hub_subtitle = get_theme_mod('mileym3dia_hub_subtitle', 'Register your client or creator account, sign in to review private project deliverables, and download studio production assets.');

$active_tab = isset($_GET['tab']) ? sanitize_key(wp_unslash($_GET['tab'])) : 'register';
if (!in_array($active_tab, array('login', 'register'), true)) {
    $active_tab = 'register';
}

$auth_status  = isset($_GET['auth']) ? sanitize_key(wp_unslash($_GET['auth'])) : '';
$auth_err     = isset($_GET['auth_error']) ? sanitize_text_field(wp_unslash($_GET['auth_error'])) : '';
$is_logged_in = (function_exists('is_user_logged_in') && is_user_logged_in()) || ('registered' === $auth_status) || ('logged_in' === $auth_status);

$default_lut_url       = get_template_directory_uri() . '/assets/files/m3-35mm-cinema-lut-pack.cube';
$default_audio_url     = get_template_directory_uri() . '/assets/files/m3-studio-audio-stem-guide.txt';
$default_lookbook_url  = get_template_directory_uri() . '/assets/files/m3-brand-lookbook-layout-guide.txt';
$default_callsheet_url = get_template_directory_uri() . '/assets/files/m3-production-call-sheet-checklist.txt';

$vault_files = array(
    array(
        'code'  => 'DELIVERABLE // 01',
        'color' => 'blue',
        'title' => get_theme_mod('mileym3dia_resource_1_title', '35MM CINEMA LUT PACK'),
        'desc'  => get_theme_mod('mileym3dia_resource_1_desc', 'Calibrated look LUTs for Sony S-Log3, RED Log3G10, and Blackmagic Film Gen 5. Designed for natural skin tones and rich film contrast.'),
        'file'  => get_theme_mod('mileym3dia_resource_1_file', $default_lut_url),
        'btn'   => get_theme_mod('mileym3dia_resource_1_btn', 'DOWNLOAD .CUBE PACK'),
    ),
    array(
        'code'  => 'DELIVERABLE // 02',
        'color' => 'yellow',
        'title' => get_theme_mod('mileym3dia_resource_2_title', 'STUDIO AUDIO STEM & MIX GUIDE'),
        'desc'  => get_theme_mod('mileym3dia_resource_2_desc', '24-Bit / 48kHz broadcast WAV stem grouping, loudness targets (-14 LUFS), and file naming specs.'),
        'file'  => get_theme_mod('mileym3dia_resource_2_file', $default_audio_url),
        'btn'   => get_theme_mod('mileym3dia_resource_2_btn', 'DOWNLOAD AUDIO SPECS'),
    ),
    array(
        'code'  => 'DELIVERABLE // 03',
        'color' => 'lime',
        'title' => get_theme_mod('mileym3dia_resource_3_title', 'BRAND & LOOKBOOK LAYOUT KIT'),
        'desc'  => get_theme_mod('mileym3dia_resource_3_desc', '12-column Swiss brutalist grid system, typography scale guides, and print/web export specs.'),
        'file'  => get_theme_mod('mileym3dia_resource_3_file', $default_lookbook_url),
        'btn'   => get_theme_mod('mileym3dia_resource_3_btn', 'DOWNLOAD LAYOUT KIT'),
    ),
    array(
        'code'  => 'DELIVERABLE // 04',
        'color' => 'red',
        'title' => get_theme_mod('mileym3dia_resource_4_title', 'VIDEO PRODUCTION CALL SHEET & CHECKLIST'),
        'desc'  => get_theme_mod('mileym3dia_resource_4_desc', 'Our complete pre-production call sheet, shot list template, and location lighting checklist.'),
        'file'  => get_theme_mod('mileym3dia_resource_4_file', $default_callsheet_url),
        'btn'   => get_theme_mod('mileym3dia_resource_4_btn', 'DOWNLOAD CALL SHEET'),
    ),
);
?>

<main id="primary" class="site-main creator-hub-main">

    <section class="page-title-section creator-hub-title-section bg-shade-base">
        <div class="container container--wide">
            <span class="page-subtitle text-blue"><?php echo esc_html($hub_eyebrow); ?></span>
            <h1 class="page-title page-title--mega">
                CREATOR <span class="text-blue">HUB</span>
            </h1>
            <p class="page-lead"><?php echo esc_html($hub_subtitle); ?></p>
        </div>
    </section>

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

    <!-- REGISTRATION & SIGN-IN PORTAL -->
    <section class="creator-hub-foundation-section section-loose bg-shade-elevated" id="portal-access">
        <div class="container container--wide">

            <?php if ('registered' === $auth_status) : ?>
                <div class="portal-notice portal-notice--success" role="status">
                    <strong>ACCOUNT CREATED //</strong> Welcome to the M3 Creator Hub! Your studio account is active and your member deliverables vault is unlocked below.
                </div>
            <?php elseif ('logged_in' === $auth_status) : ?>
                <div class="portal-notice portal-notice--success" role="status">
                    <strong>SIGNED IN //</strong> Welcome back to the M3 Creator Hub. Your client deliverables and studio assets are ready below.
                </div>
            <?php elseif (!empty($auth_err)) : ?>
                <div class="portal-notice portal-notice--error" role="alert">
                    <strong>AUTHENTICATION NOTICE //</strong> <?php echo esc_html($auth_err); ?>
                </div>
            <?php endif; ?>

            <div class="hub-portal-layout">

                <!-- LEFT: TABBED REGISTRATION & SIGN-IN -->
                <div class="hub-auth-card">
                    <div class="hub-auth-tabs" role="tablist" aria-label="<?php esc_attr_e('Account authentication tabs', 'm3-big-red'); ?>">
                        <button type="button" class="hub-auth-tab <?php echo 'register' === $active_tab ? 'active' : ''; ?>" data-tab="register" role="tab" aria-selected="<?php echo 'register' === $active_tab ? 'true' : 'false'; ?>">
                            01 // CREATE ACCOUNT
                        </button>
                        <button type="button" class="hub-auth-tab <?php echo 'login' === $active_tab ? 'active' : ''; ?>" data-tab="login" role="tab" aria-selected="<?php echo 'login' === $active_tab ? 'true' : 'false'; ?>">
                            02 // SIGN IN
                        </button>
                    </div>

                    <!-- REGISTER PANEL -->
                    <div class="hub-auth-panel <?php echo 'register' === $active_tab ? 'active' : ''; ?>" id="hub-panel-register" role="tabpanel">
                        <div class="hub-auth-panel__header">
                            <h3><?php echo esc_html(get_theme_mod('mileym3dia_hub_register_heading', 'CREATE STUDIO ACCOUNT')); ?></h3>
                            <p>Create your profile to access private client delivery folders, member LUTs &amp; production templates, and priority studio booking.</p>
                        </div>

                        <form class="contact-form hub-form" method="post" action="<?php echo esc_url(add_query_arg('auth', 'registered', mileym3dia_get_page_url('creator-hub')) . '#portal-access'); ?>">
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
                                        <option value="client">Studio Client (Project Deliverables)</option>
                                        <option value="creator">Creator / Filmmaker (Resources &amp; Store)</option>
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
                                <span><?php echo esc_html(get_theme_mod('mileym3dia_hub_register_btn', 'REGISTER ACCOUNT →')); ?></span>
                            </button>
                        </form>
                    </div>

                    <!-- SIGN IN PANEL -->
                    <div class="hub-auth-panel <?php echo 'login' === $active_tab ? 'active' : ''; ?>" id="hub-panel-login" role="tabpanel">
                        <div class="hub-auth-panel__header">
                            <h3><?php echo esc_html(get_theme_mod('mileym3dia_hub_login_heading', 'CLIENT & MEMBER SIGN IN')); ?></h3>
                            <p>Sign in with your username or email address to access your private client deliverables vault and order history.</p>
                        </div>

                        <form class="contact-form hub-form" method="post" action="<?php echo esc_url(add_query_arg('auth', 'logged_in', mileym3dia_get_page_url('creator-hub')) . '#portal-access'); ?>">
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
                                <?php if (function_exists('wp_lostpassword_url')) : ?>
                                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="hub-forgot-link">Reset Password</a>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn--streetwear-red btn--full">
                                <span><?php echo esc_html(get_theme_mod('mileym3dia_hub_login_btn', 'SIGN IN TO PORTAL →')); ?></span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- RIGHT: PORTAL STATUS & BENEFIT CARDS -->
                <div class="hub-benefits-col">
                    <div class="hub-status-banner">
                        <span class="hub-status-dot"></span>
                        <span>PORTAL STATUS: <strong><?php echo $is_logged_in ? 'AUTHENTICATED // VAULT UNLOCKED' : 'ONLINE // REGISTRATION OPEN'; ?></strong></span>
                    </div>

                    <div class="creator-hub-grid" style="grid-template-columns: repeat(2, 1fr);">
                        <div class="creator-hub-card">
                            <span class="hub-card-tag text-red">VIDEO &amp; PHOTO</span>
                            <h3 class="hub-card-title"><?php esc_html_e('Client Review & Deliverables', 'm3-big-red'); ?></h3>
                            <p class="hub-card-desc"><?php esc_html_e('High-resolution video masters, frame-accurate review cuts, and retouched photography galleries for active client projects.', 'm3-big-red'); ?></p>
                            <div class="hub-card-meta">
                                <span>4K / 8K MASTERS</span>
                                <span>DIRECT DOWNLOAD</span>
                            </div>
                        </div>

                        <div class="creator-hub-card">
                            <span class="hub-card-tag text-yellow">MUSIC &amp; AUDIO</span>
                            <h3 class="hub-card-title"><?php esc_html_e('Audio Stems & Masters', 'm3-big-red'); ?></h3>
                            <p class="hub-card-desc"><?php esc_html_e('Uncompressed 24-bit WAV mixes, multitrack session stems, and final mastered audio files ready for distribution.', 'm3-big-red'); ?></p>
                            <div class="hub-card-meta">
                                <span>24-BIT / 48KHZ</span>
                                <span>STUDIO MASTERS</span>
                            </div>
                        </div>

                        <div class="creator-hub-card">
                            <span class="hub-card-tag text-lime">BRAND &amp; WEB</span>
                            <h3 class="hub-card-title"><?php esc_html_e('Brand Kits & Web Assets', 'm3-big-red'); ?></h3>
                            <p class="hub-card-desc"><?php esc_html_e('Logo vector packages, brand style guides, typography licenses, and web launch documentation.', 'm3-big-red'); ?></p>
                            <div class="hub-card-meta">
                                <span>VECTOR &amp; WEB</span>
                                <span>BRAND GUIDELINES</span>
                            </div>
                        </div>

                        <div class="creator-hub-card">
                            <span class="hub-card-tag text-blue">STORE &amp; TOOLS</span>
                            <h3 class="hub-card-title"><?php esc_html_e('Member Asset Vault', 'm3-big-red'); ?></h3>
                            <p class="hub-card-desc"><?php esc_html_e('Instant access to studio LUTs, call sheets, lookbook grids, and priority booking discounts.', 'm3-big-red'); ?></p>
                            <div class="hub-card-meta">
                                <span>INSTANT ACCESS</span>
                                <span>STUDIO LICENSE</span>
                            </div>
                        </div>
                    </div>

                    <div class="hub-quick-links">
                        <a href="#member-vault" class="btn btn--streetwear-outline"><span>JUMP TO DOWNLOAD VAULT ↓</span></a>
                        <a href="<?php echo esc_url(mileym3dia_get_page_url('store')); ?>" class="btn btn--streetwear-outline"><span>BROWSE STUDIO STORE →</span></a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- MEMBER & CLIENT DOWNLOAD VAULT -->
    <section class="section-loose bg-shade-base" id="member-vault">
        <div class="container container--wide">
            <div class="section-header">
                <div class="section-header-left">
                    <span class="section-label text-blue">DOWNLOADABLE STUDIO FILES</span>
                    <h2 class="section-title section-title--xl">MEMBER &amp; CLIENT VAULT</h2>
                </div>
                <div class="section-header-right">
                    <p class="section-header-desc">
                        Every file below can be uploaded or swapped anytime in <strong>Appearance → Customize → Blog, Resources &amp; Download Files</strong>.
                    </p>
                </div>
            </div>

            <div class="resources-gear-grid">
                <?php foreach ($vault_files as $vf) : ?>
                    <div class="resource-gear-card resource-gear-card--<?php echo esc_attr($vf['color']); ?>">
                        <div class="gear-card-top">
                            <span class="gear-card-badge text-<?php echo esc_attr($vf['color']); ?>"><?php echo esc_html($vf['code']); ?></span>
                            <span class="gear-status-tag">DIRECT DOWNLOAD</span>
                        </div>
                        <div class="gear-card-content">
                            <h3 class="gear-card-title"><?php echo esc_html($vf['title']); ?></h3>
                            <p class="gear-card-desc"><?php echo esc_html($vf['desc']); ?></p>
                        </div>
                        <div class="gear-card-footer">
                            <a href="<?php echo esc_url($vf['file']); ?>" class="btn btn--streetwear-outline btn--full" download><?php echo esc_html($vf['btn']); ?> ↓</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</main>

<script>
(function() {
    var tabs = document.querySelectorAll('.hub-auth-tab');
    var panelRegister = document.getElementById('hub-panel-register');
    var panelLogin = document.getElementById('hub-panel-login');

    if (!tabs.length || !panelRegister || !panelLogin) return;

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            var target = tab.getAttribute('data-tab');
            tabs.forEach(function(t) {
                t.classList.remove('active');
                t.setAttribute('aria-selected', 'false');
            });
            tab.classList.add('active');
            tab.setAttribute('aria-selected', 'true');

            if (target === 'login') {
                panelRegister.classList.remove('active');
                panelLogin.classList.add('active');
            } else {
                panelLogin.classList.remove('active');
                panelRegister.classList.add('active');
            }
        });
    });
})();
</script>

<?php get_footer(); ?>

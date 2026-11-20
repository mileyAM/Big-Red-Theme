<?php
/**
 * Template Name: Contact
 * Description: Dedicated Contact and Project Inquiry page template.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

$m3_feedback = array('status' => '', 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['m3_contact_nonce'])) {
    if (!wp_verify_nonce($_POST['m3_contact_nonce'], 'm3_contact_action')) {
        $m3_feedback = array(
            'status'  => 'error',
            'message' => __('Security verification failed. Please refresh the page and try again.', 'mileym3dia'),
        );
    } else {
        $name       = sanitize_text_field($_POST['name'] ?? '');
        $email      = sanitize_email($_POST['email'] ?? '');
        $discipline = sanitize_text_field($_POST['selected_discipline'] ?? '');
        $budget     = sanitize_text_field($_POST['selected_budget'] ?? '');
        $timeline   = sanitize_text_field($_POST['timeline'] ?? '');
        $company    = sanitize_text_field($_POST['company'] ?? '');
        $message    = sanitize_textarea_field($_POST['message'] ?? '');

        if (empty($name) || empty($email) || !is_email($email) || empty($message)) {
            $m3_feedback = array(
                'status'  => 'error',
                'message' => __('Please complete all required fields with a valid email address.', 'mileym3dia'),
            );
        } else {
            $admin_email = get_theme_mod('mileym3dia_contact_email', get_option('admin_email'));
            $subject     = sprintf('[MILEYM3DIA Project Inquiry] %s — %s', $discipline ?: 'General Inquiry', $name);
            $body        = "New Project Inquiry from MILEYM3DIA:\n\n"
                         . "Name: $name\n"
                         . "Email: $email\n"
                         . "Brand / Company: $company\n"
                         . "Service Needed: $discipline\n"
                         . "Estimated Budget: $budget\n"
                         . "Target Timeline: $timeline\n\n"
                         . "Project Details:\n$message\n\n"
                         . "---\nSent from: " . home_url();
            $headers     = array(
                'Content-Type: text/plain; charset=UTF-8',
                "Reply-To: $name <$email>",
            );

            wp_mail($admin_email, $subject, $body, $headers);
            $m3_feedback = array(
                'status'  => 'success',
                'message' => __('Thank you! Your project inquiry has been received. Our team will get back to you within 24 hours.', 'mileym3dia'),
            );
        }
    }
}

get_header();
?>

<main id="primary" class="site-main contact-page-main">

    <!-- OFFICIAL MILEYM3DIA CONTACT BANNER (BRING TO LIFE — RED ACCENT) -->
    <?php
    if (function_exists('mileym3dia_render_page_banner')) {
        mileym3dia_render_page_banner('contact', array(
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

    <section class="section-loose contact-page-section bg-shade-elevated" id="contact-brief">
        <div class="container container--wide">
            <div class="contact-layout-grid">

                <!-- Left Column: Studio Contact Details -->
                <div class="contact-info-col">
                    <div class="studio-status-card">
                        <div class="status-top">
                            <span class="status-indicator live"></span>
                            <span class="status-label"><?php echo esc_html(get_theme_mod('mileym3dia_contact_availability', 'NOW BOOKING NEW PROJECTS')); ?></span>
                        </div>
                        <div class="studio-meta-list">
                            <div class="studio-meta-item">
                                <span class="meta-label">DIRECT EMAIL</span>
                                <?php $contact_email = get_theme_mod('mileym3dia_contact_email', 'hello@mileym3dia.com'); ?>
                                <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="meta-link-large"><?php echo esc_html($contact_email); ?></a>
                            </div>

                            <?php $contact_phone = get_theme_mod('mileym3dia_contact_phone', ''); ?>
                            <?php if (!empty($contact_phone)) : ?>
                                <div class="studio-meta-item">
                                    <span class="meta-label">PHONE</span>
                                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $contact_phone)); ?>" class="meta-link-large"><?php echo esc_html($contact_phone); ?></a>
                                </div>
                            <?php endif; ?>

                            <div class="studio-meta-item">
                                <span class="meta-label">STUDIO LOCATION</span>
                                <p class="meta-value"><?php echo esc_html(get_theme_mod('mileym3dia_contact_location', 'ORLANDO, FL · AVAILABLE WORLDWIDE')); ?></p>
                            </div>

                            <div class="studio-meta-item">
                                <span class="meta-label">RESPONSE TIME</span>
                                <p class="meta-value text-lime">WITHIN 24 HOURS</p>
                            </div>
                        </div>

                        <div class="studio-social-section">
                            <span class="meta-label">FOLLOW THE STUDIO</span>
                            <div class="contact-social-wrapper">
                                <?php mileym3dia_social_links('contact-social-links'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="studio-equipment-box">
                        <span class="weaponry-label">CORE AGENCY CAPABILITIES</span>
                        <div class="weaponry-chips">
                            <span>Video Production</span>
                            <span>Photography</span>
                            <span>Brand Identity &amp; Design</span>
                            <span>Custom Web Design</span>
                            <span>Music &amp; Audio Production</span>
                            <span>Monthly Retainers</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Project Inquiry Form -->
                <div class="contact-form-col">
                    <div class="contact-form-card">
                        <div class="form-header">
                            <div class="form-step-tag text-yellow">PROJECT INQUIRY</div>
                            <h2 class="form-title">TELL US ABOUT YOUR PROJECT</h2>
                            <p class="form-subtitle">Select the services you need and share a few details about your goals and timeline.</p>
                        </div>

                        <?php if (!empty($m3_feedback['message'])) : ?>
                            <div class="m3-form-feedback m3-form-feedback--<?php echo esc_attr($m3_feedback['status']); ?>" role="alert">
                                <span class="m3-feedback-tag"><?php echo $m3_feedback['status'] === 'success' ? 'INQUIRY SENT' : 'ERROR'; ?></span>
                                <span class="m3-feedback-text"><?php echo esc_html($m3_feedback['message']); ?></span>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo esc_url(get_permalink()); ?>" method="post" class="contact-form" id="m3BookingForm">
                            <?php wp_nonce_field('m3_contact_action', 'm3_contact_nonce'); ?>

                            <div class="form-group-block">
                                <label class="contact-form-label">
                                    01 / SERVICE NEEDED <span class="required-star">*</span>
                                </label>
                                <div class="discipline-chips" id="disciplineChips">
                                    <button type="button" class="discipline-chip active" data-discipline="Video Production">Video Production</button>
                                    <button type="button" class="discipline-chip" data-discipline="Photography">Photography</button>
                                    <button type="button" class="discipline-chip" data-discipline="Branding & Graphic Design">Branding &amp; Design</button>
                                    <button type="button" class="discipline-chip" data-discipline="Web Design & Development">Web Design</button>
                                    <button type="button" class="discipline-chip" data-discipline="Music & Audio Production">Music &amp; Audio</button>
                                    <button type="button" class="discipline-chip" data-discipline="Custom Service Bundle">Custom Bundle</button>
                                </div>
                                <input type="hidden" name="selected_discipline" id="selectedDisciplineInput" value="Video Production" />
                            </div>

                            <div class="form-row-duo">
                                <div class="contact-form-group">
                                    <label for="contact-name" class="contact-form-label">
                                        YOUR NAME <span class="required-star">*</span>
                                    </label>
                                    <input type="text" id="contact-name" name="name" required class="contact-form-control" placeholder="Your full name">
                                </div>

                                <div class="contact-form-group">
                                    <label for="contact-email" class="contact-form-label">
                                        EMAIL ADDRESS <span class="required-star">*</span>
                                    </label>
                                    <input type="email" id="contact-email" name="email" required class="contact-form-control" placeholder="you@company.com">
                                </div>
                            </div>

                            <div class="form-group-block">
                                <label class="contact-form-label">
                                    02 / ESTIMATED BUDGET
                                </label>
                                <div class="budget-chips" id="budgetChips">
                                    <button type="button" class="budget-chip" data-budget="$95 - $350 (Single / Mini)">$95 – $350 (Single / Mini)</button>
                                    <button type="button" class="budget-chip active" data-budget="$350 - $750 (Starter / Bundle)">$350 – $750 (Starter / Bundle)</button>
                                    <button type="button" class="budget-chip" data-budget="$750 - $1,450 (Launch Package)">$750 – $1,450 (Launch Package)</button>
                                    <button type="button" class="budget-chip" data-budget="$1,450+ (Full Production / Web)">$1,450+ (Full Production / Web)</button>
                                </div>
                                <input type="hidden" name="selected_budget" id="selectedBudgetInput" value="$350 - $750 (Starter / Bundle)" />
                            </div>

                            <div class="form-row-duo">
                                <div class="contact-form-group">
                                    <label for="contact-company" class="contact-form-label">
                                        BRAND / ARTIST / COMPANY
                                    </label>
                                    <input type="text" id="contact-company" name="company" class="contact-form-control" placeholder="Company or artist name">
                                </div>

                                <div class="contact-form-group">
                                    <label for="contact-timeline" class="contact-form-label">
                                        TARGET TIMELINE
                                    </label>
                                    <input type="text" id="contact-timeline" name="timeline" class="contact-form-control" placeholder="e.g. Next month / Q2 Launch">
                                </div>
                            </div>

                            <div class="contact-form-group">
                                <label for="contact-message" class="contact-form-label">
                                    03 / PROJECT DETAILS &amp; GOALS <span class="required-star">*</span>
                                </label>
                                <textarea id="contact-message" name="message" rows="5" required class="contact-form-control contact-form-textarea" placeholder="Tell us about your project, deliverables, locations, and what you want to achieve..."></textarea>
                            </div>

                            <div class="contact-form-submit-wrap">
                                <button type="submit" class="btn btn--streetwear-red btn--full">
                                    <span class="btn-text"><?php esc_html_e('SEND PROJECT INQUIRY', 'mileym3dia'); ?></span>
                                    <span class="btn-arrow">↗</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var disciplineChips = document.querySelectorAll('#disciplineChips .discipline-chip');
    var disciplineInput = document.getElementById('selectedDisciplineInput');

    function activateDiscipline(val) {
        if (!val) return;
        disciplineChips.forEach(function(chip) {
            var disc = chip.getAttribute('data-discipline') || '';
            if (disc.toLowerCase().indexOf(val.toLowerCase()) !== -1 || val.toLowerCase().indexOf(disc.toLowerCase()) !== -1) {
                disciplineChips.forEach(function(c) { c.classList.remove('active'); });
                chip.classList.add('active');
                if (disciplineInput) disciplineInput.value = disc;
            }
        });
    }

    disciplineChips.forEach(function(chip) {
        chip.addEventListener('click', function() {
            disciplineChips.forEach(function(c) { c.classList.remove('active'); });
            chip.classList.add('active');
            if (disciplineInput) {
                disciplineInput.value = chip.getAttribute('data-discipline');
            }
        });
    });

    var budgetChips = document.querySelectorAll('#budgetChips .budget-chip');
    var budgetInput = document.getElementById('selectedBudgetInput');

    function activateBudget(val) {
        if (!val) return;
        budgetChips.forEach(function(chip) {
            var b = chip.getAttribute('data-budget') || '';
            if (b.toLowerCase().indexOf(val.toLowerCase()) !== -1) {
                budgetChips.forEach(function(c) { c.classList.remove('active'); });
                chip.classList.add('active');
                if (budgetInput) budgetInput.value = b;
            }
        });
    }

    budgetChips.forEach(function(chip) {
        chip.addEventListener('click', function() {
            budgetChips.forEach(function(c) { c.classList.remove('active'); });
            chip.classList.add('active');
            if (budgetInput) {
                budgetInput.value = chip.getAttribute('data-budget');
            }
        });
    });

    var urlParams = new URLSearchParams(window.location.search);
    var tierParam = (urlParams.get('tier') || '').toLowerCase();
    var discParam = (urlParams.get('discipline') || '').toLowerCase();
    var bundleParam = urlParams.get('bundle') || '';
    var estimateParam = urlParams.get('estimate') || '';
    var msgField = document.getElementById('contact-message');

    if (tierParam === 'starter' || tierParam === 'single') {
        activateDiscipline('Video Production');
        activateBudget('350 - $750');
    } else if (tierParam === 'launch' || tierParam === 'brand') {
        activateDiscipline('Branding');
        activateBudget('750 - $1,450');
    } else if (tierParam === 'full' || tierParam === 'retainer') {
        activateDiscipline('Web Design');
        activateBudget('1,450+');
    }

    if (discParam) {
        activateDiscipline(discParam);
    }

    if (bundleParam) {
        activateDiscipline('Custom Service Bundle');
        var estNum = parseInt(String(estimateParam).replace(/[^0-9]/g, ''), 10) || 0;
        if (estNum > 0 && estNum <= 350) {
            activateBudget('95 - $350');
        } else if (estNum <= 750) {
            activateBudget('350 - $750');
        } else if (estNum <= 1450) {
            activateBudget('750 - $1,450');
        } else {
            activateBudget('1,450+');
        }
        if (budgetInput && estimateParam) {
            budgetInput.value = 'Custom Bundle Estimate: ' + estimateParam;
        }
        if (msgField && !msgField.value) {
            msgField.value = "Selected Custom Service Bundle:\n• " + bundleParam.split(' + ').join("\n• ") + (estimateParam ? "\n\nEstimated Bundle Total: " + estimateParam : "") + "\n\nProject Details & Goals:\n";
        }
    }
});
</script>

<?php get_footer(); ?>

<?php
/**
 * Template Name: Privacy & Terms
 * Description: Studio Privacy Policy, Digital Asset Licensing, and Account Terms.
 *
 * @package MILEYM3DIA
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$legal_entity  = get_theme_mod('mileym3dia_legal_entity', 'MILEYM3DIA');
$legal_updated = get_theme_mod('mileym3dia_legal_updated', 'November 2026');
$contact_email = get_theme_mod('mileym3dia_contact_email', 'hello@mileym3dia.com');
$location      = get_theme_mod('mileym3dia_contact_location', 'ORLANDO, FL');
?>

<main id="primary" class="site-main legal-main">

    <section class="page-title-section bg-shade-base">
        <div class="container container--wide">
            <span class="page-subtitle text-red">STUDIO LEGAL // COMPLIANCE</span>
            <h1 class="page-title page-title--mega">
                PRIVACY &amp; <span class="text-red">TERMS</span>
            </h1>
            <p class="page-lead">
                Data privacy, commercial digital asset licensing, and Creator Hub account terms for <?php echo esc_html($legal_entity); ?>. Last updated <?php echo esc_html($legal_updated); ?>.
            </p>
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

    <section class="section-loose bg-shade-elevated">
        <div class="container container--wide">
            <div class="legal-grid">

                <article class="legal-card">
                    <span class="legal-card__tag text-red">01 // PRIVACY POLICY</span>
                    <h2>Information We Collect</h2>
                    <p>
                        When you register a Creator Hub account, submit a project inquiry, or place an order in the <?php echo esc_html($legal_entity); ?> Studio Store, we collect only the details needed to fulfill your request—such as your name, email address, username, company/project code, and order notes.
                    </p>
                    <p>
                        We never sell, rent, or trade your personal information to third-party brokers. Project files, footage, and stems shared inside client portals remain strictly confidential.
                    </p>
                </article>

                <article class="legal-card">
                    <span class="legal-card__tag text-lime">02 // STORE &amp; LICENSING</span>
                    <h2>Digital &amp; Physical Orders</h2>
                    <p>
                        All LUT packs, audio stem libraries, and layout templates purchased or downloaded from the Studio Store include a non-exclusive <strong>Commercial Studio License</strong> for unlimited personal and client productions by the purchasing creator or studio.
                    </p>
                    <p>
                        Redistribution, reselling, or repackaging raw LUTs, stems, or templates as standalone stock products is prohibited. Due to the instant nature of digital downloads, digital pack sales are final once delivered.
                    </p>
                </article>

                <article class="legal-card">
                    <span class="legal-card__tag text-blue">03 // CREATOR HUB PORTAL</span>
                    <h2>Accounts &amp; Client Vault</h2>
                    <p>
                        Creator Hub accounts grant access to member starter packs and private client project deliverables. You are responsible for maintaining the confidentiality of your login credentials and notifying us immediately at <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="text-blue"><?php echo esc_html($contact_email); ?></a> if unauthorized access is suspected.
                    </p>
                    <p>
                        You may request account updates or complete data deletion at any time by emailing our studio team.
                    </p>
                </article>

                <article class="legal-card">
                    <span class="legal-card__tag text-yellow">04 // PAYMENTS &amp; CONTACT</span>
                    <h2>Checkout &amp; Inquiries</h2>
                    <p>
                        Card payments processed via Stripe, PayPal, or WooCommerce are handled over encrypted TLS connections; <?php echo esc_html($legal_entity); ?> does not store raw payment card numbers on our servers. Essential session cookies are used solely for login state and cart persistence.
                    </p>
                    <p>
                        Questions regarding these terms? Reach <?php echo esc_html($legal_entity); ?> (<?php echo esc_html($location); ?>) at <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="text-yellow"><?php echo esc_html($contact_email); ?></a>.
                    </p>
                </article>

            </div>
        </div>
    </section>

</main>

<?php
get_footer();

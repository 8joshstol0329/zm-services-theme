<?php
/**
 * Fallback template. WordPress uses this for any page or post that doesn't
 * have a more specific template file yet (About, Gallery, Contact and so on).
 * It shows the title and whatever content was typed into the dashboard editor,
 * using the same layout classes as the static site's Privacy and Terms pages.
 */

get_header();
?>

<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>

<section class="legal-hero">
    <h1><?php the_title(); ?></h1>
    <?php // The date this page was last saved in the dashboard. ?>
    <p class="legal-updated">Last updated: <?php echo esc_html( get_the_modified_date() ); ?></p>
</section>

<section class="legal-section">
    <div class="legal-content">
        <?php the_content(); ?>
    </div>
</section>

    <?php endwhile; ?>
<?php endif; ?>

<?php
get_footer();

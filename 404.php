<?php
/**
 * 404 page: shown when an address doesn't match any page.
 * Converted from the static site's 404.html.
 */

get_header();
?>

<section class="error-page">
    <div class="eyebrow">Error 404</div>
    <h1 class="error-page-h1">This Page Got Mowed Over</h1>
    <p>We couldn't find the page you're looking for. It may have been moved, removed, or never existed.</p>
    <div class="error-page-actions">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary">Back to Home</a>
    </div>
</section>

<?php
get_footer();

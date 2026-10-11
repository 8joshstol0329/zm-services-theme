<?php
/**
 * Gallery page. WordPress uses this file for the page whose slug is "gallery".
 * Converted from the static site's gallery.html.
 *
 * The project cards are no longer typed in here. They come from the dashboard
 * (Projects), so adding a project there adds a card here.
 */

get_header();

// Ask WordPress for every project: lowest Order number first, and newest
// first when two have the same number.
$projects = new WP_Query(
	array(
		'post_type'      => 'zm_project',
		'posts_per_page' => -1,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
		'no_found_rows'  => true,
	)
);
?>

<section class="gallery-hero">
   <div class="eyebrow">Our Work</div>
    <h1 class="gallery-hero-h1">SEE THE DIFFERENCE</h1>

    <p class="eyebrow-p">Real before-and-after results from recent projects</p>
</section>

<section class="gallery-section">

    <div class="gallery-grid" id="gallery-grid">

    <?php if ( $projects->have_posts() ) : ?>

        <?php
        // "The Loop": run the card markup once for each project.
        // the_post() moves to the next project and makes the_title() and
        // get_the_ID() refer to it.
        while ( $projects->have_posts() ) :
            $projects->the_post();

            $before   = zm_project_photo( get_the_ID(), 'before' );
            $after    = zm_project_photo( get_the_ID(), 'after' );
            $category = get_post_meta( get_the_ID(), 'zm_category', true );
            $summary  = get_post_meta( get_the_ID(), 'zm_summary', true );
            ?>

    <div class="project-card">
      <div class="ba-compare">
        <?php if ( $before ) : ?>
        <figure class="ba-photo">
          <?php echo $before; // Already a safe <img> tag built by WordPress. ?>
          <figcaption class="ba-tag before">Before</figcaption>
        </figure>
        <?php endif; ?>
        <?php if ( $after ) : ?>
        <figure class="ba-photo">
          <?php echo $after; ?>
          <figcaption class="ba-tag after">After</figcaption>
        </figure>
        <?php endif; ?>
      </div>
      <div class="project-info">
        <?php if ( $category ) : ?>
        <span class="category"><?php echo esc_html( $category ); ?></span>
        <?php endif; ?>
        <h3><?php the_title(); ?></h3>
        <?php if ( $summary ) : ?>
        <p><?php echo esc_html( $summary ); ?></p>
        <?php endif; ?>
      </div>
    </div>

        <?php endwhile; ?>

        <?php
        // The loop changed which post WordPress thinks is "current".
        // Put it back so the rest of the page (and the footer) behaves normally.
        wp_reset_postdata();
        ?>

    <?php else : ?>

    <p class="gallery-empty">New project photos are on the way. Check back soon.</p>

    <?php endif; ?>

  </div>
</section>
 
<section class="gallery-cta">
  <h2>Ready For Your Own Before &amp; After?</h2>
  <p>Get a free quote and see what we can do for your property.</p>
  <a href="<?php echo zm_page_url( 'contact' ); ?>" class="btn-primary">Get A Free Quote</a>
</section>

<?php
get_footer();

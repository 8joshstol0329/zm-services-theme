<?php
/**
 * About page. WordPress uses this file for the page whose slug is "about".
 * The wording comes from Appearance > Customize > Page text.
 */

get_header();
?>


   <!-- ===== SECTION 1: about-us-section ===== -->
    <section class="about-us-section">
        <div class="about-us-grid">
            <div class="about-us-image">
                                <img src="<?php echo zm_asset( 'images/family-business.jpg' ); ?>" alt="Z&amp;M Services property work">
            </div>
            <div class="about-us-content">
                <div class="eyebrow"><?php echo esc_html( zm_text( 'about_eyebrow' ) ); ?></div>
                <?php zm_paragraphs( 'about_story' ); // One <p> for each paragraph of the story. ?>
                <a href="#meet-zach" class="btn-primary">Get To Know Us</a>
            </div>
        </div>
    </section>
 
    <!-- ===== SECTION 2: values-grid ===== -->
    <section class="values-grid-section">
        <div class="values-grid">
 
            <div class="value-card">
                <svg class="value-icon" style="color:#3B82F6;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8.5" cy="8" r="3"/><circle cx="15.5" cy="8" r="3"/><path d="M2 20c0-3 3-5 6.5-5s6.5 2 6.5 5"/><path d="M12.5 15c3.5 0 6.5 2 6.5 5"/></svg>
                <h3><?php echo esc_html( zm_text( 'value_1_title' ) ); ?></h3>
                <p><?php echo esc_html( zm_text( 'value_1_text' ) ); ?></p>
            </div>
 
            <div class="value-card">
                <svg class="value-icon" style="color:#2C2E2F;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2a5 5 0 0 1 5 5v1h1a1 1 0 0 1 1 1v1H5V9a1 1 0 0 1 1-1h1V7a5 5 0 0 1 5-5z"/><path d="M4 12h16l-1.5 7a2 2 0 0 1-2 1.6H7.5a2 2 0 0 1-2-1.6L4 12z"/></svg>
                <h3><?php echo esc_html( zm_text( 'value_2_title' ) ); ?></h3>
                <p><?php echo esc_html( zm_text( 'value_2_text' ) ); ?></p>
            </div>
 
            <div class="value-card">
                <svg class="value-icon" style="color:#2C2E2F;" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3 6 6.5.9-4.7 4.6 1.1 6.5L12 17l-5.9 3 1.1-6.5L2.5 8.9 9 8l3-6z"/></svg>
                <h3><?php echo esc_html( zm_text( 'value_3_title' ) ); ?></h3>
                <p><?php echo esc_html( zm_text( 'value_3_text' ) ); ?></p>
            </div>
 
            <div class="value-card">
                <svg class="value-icon" style="color:#EC4899;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                <h3><?php echo esc_html( zm_text( 'value_4_title' ) ); ?></h3>
                <p><?php echo esc_html( zm_text( 'value_4_text' ) ); ?></p>
            </div>
 
        </div>
    </section>
 
    <!-- ===== SECTION 3: meet-zach ===== -->
    <section class="meet-zach-section" id="meet-zach">
        <div class="meet-zach-grid">
            <div class="meet-zach-image">
                                <img src="<?php echo zm_asset( 'images/about.jpg' ); ?>" alt="Zach, owner of Z&amp;M Services">
            </div>
            <div class="meet-zach-content">
                <h2><?php echo esc_html( zm_text( 'bio_heading' ) ); ?></h2>
                <?php zm_paragraphs( 'bio_text', 'bio-text' ); ?>
            </div>
        </div>
    </section>
 
    <!-- ===== SECTION 4: law-enforcement ===== -->
    <section class="law-enforcement-section">
        <svg class="badge-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2l3 1.5 3-.5 1 3 2 2-1 3 1 3-2 2-1 3-3-.5L12 22l-3-1.5-3 .5-1-3-2-2 1-3-1-3 2-2 1-3 3 .5L12 2z"/></svg>
        <p class="tagline-text"><?php echo esc_html( zm_text( 'integrity_tagline' ) ); ?></p>
        <h2 class="headline"><?php echo esc_html( zm_text( 'integrity_heading' ) ); ?></h2>
        <p class="body-text"><?php echo esc_html( zm_text( 'integrity_text' ) ); ?></p>
    </section>
 
<?php
get_footer();
<?php
/**
 * Front page: the homepage content between the header and the footer.
 * WordPress uses this file automatically for the site's front page.
 */

get_header();
?>

    <!-- Hero section-->


<section class="hero" id="home" style="background-image: url('<?php echo zm_asset( 'images/hero.jpg' ); ?>');">
  <div class="hero-content">
    <?php // The wording on this page comes from Appearance > Customize > Page text. ?>
    <h1><?php echo esc_html( zm_text( 'hero_heading' ) ); ?></h1>
    <p><?php echo esc_html( zm_text( 'hero_text' ) ); ?></p>
    <div class="hero-cta">
      <a href="<?php echo zm_page_url( 'contact' ); ?>#quote" class="btn btn-primary">Get a Free Quote</a>
      <a href="<?php echo zm_page_url( 'contact' ); ?>" class="btn btn-secondary">Contact Us</a>
    </div>
  </div>
</section>



<!-- ABOUT SECTION -->
<section class="about" id="about">
<div class="about-container">
    <div class="about-image">
        <img src="<?php echo zm_asset( 'images/index-page.jpg' ); ?>" alt="About Z&M Services">
    </div>
    <div class="about-content">
        <h2>About Us</h2>
        <h3><?php echo esc_html( zm_text( 'home_about_heading' ) ); ?></h3>
        <p><?php echo esc_html( zm_text( 'home_about_text' ) ); ?></p>
        <a href="<?php echo zm_page_url( 'about' ); ?>" class="btn btn-primary">Learn More About Us</a>
    </div>
</div>
   
</section>


    <!-- SERVICES SECTION -->
    <section class="services" id="services">
  <h2>Our Services</h2>
  <p class="services-intro">
    <?php echo esc_html( zm_text( 'services_intro' ) ); ?>
  </p>

  <div class="services-grid">

    <!-- LANDSCAPING -->
    <div class="service-card">
      <div class="service-icon">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="grad-landscaping" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" stop-color="#3DA03D"/>
              <stop offset="100%" stop-color="#1A6B1A"/>
            </linearGradient>
            <filter id="drop-landscaping" x="-20%" y="-20%" width="140%" height="140%">
              <feDropShadow dx="0" dy="6" stdDeviation="6" flood-color="#000" flood-opacity="0.22"/>
            </filter>
          </defs>
          <path fill="url(#grad-landscaping)" filter="url(#drop-landscaping)"
                d="M2.5 19h19v2h-19zm16.84-3.15c.8.21 1.62-.26 1.84-1.06c.21-.8-.26-1.62-1.06-1.84l-5.31-1.42l-2.76-9.02L10.12 2v8.28L5.15 8.95l-.93-2.32l-1.45-.39v5.17z"/>
        </svg>
      </div>
      <h3>Landscaping</h3>
      <p><?php echo esc_html( zm_text( 'service_landscaping' ) ); ?></p>
      <a href="<?php echo zm_page_url( 'contact' ); ?>" class="btn btn-primary">Get a Quote</a>
    </div>

    <!-- JUNK REMOVAL -->
    <div class="service-card">
      <div class="service-icon">
        <svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
          <path
            fill="#CC6600"
            stroke="#000000"
            stroke-width=".30"
            d="m10.57 4.38l-3.48.87a.38.38 0 0 1-.46-.27c-.05-.2.08-.41.28-.46l1.56-.39l-3.4-1.1L3.76 5.4l3.74.89h4.71l-.53-2.06zm3.42 3.64l-.35 3.48l-.98-.1c-.05.55-.53.94-1.07.89a.99.99 0 0 1-.87-1.1l-1.79-1.7l-5.01.97l-.11.99c-.05.55-.53.95-1.07.89a.99.99 0 0 1-.87-1.1l.1-.99l-.97-.11l.36-3.48c.07-.69.59-1.24 1.26-1.33l1.71-3.1c.1-.15.27-.24.45-.23l4.76 1.52c.2.02 2.41-.62 2.46-.43l1.02 3.37c.64.23 1.04.87.97 1.56M3.3 9.28c.44.04.88-.31 1.32-1.07l-1.07-.13V6.89c-.83.27-1.27.63-1.32 1.07c-.06.66.41 1.25 1.07 1.32m8.55.26c.55.06.93-.12 1.15-.54q-.225-.375-1.05-.45c-.83-.09-1.52.06-1.55.34c-.03.27.62.56 1.45.65M6.6 12.01c-.15-.18-.33-.36-.6-.51c-1-.55 1.5-.5 2-.5s2-.05 2 .5S8.99 13 7.88 13c-.1 0-.19-.01-.27-.02c-.19.01-.4.02-.61.02c-1.1 0-2-.22-2-.5c0-.24.68-.44 1.6-.49"
          />
        </svg>
      </div>
      <h3>Junk Removal</h3>
      <p><?php echo esc_html( zm_text( 'service_junk' ) ); ?></p>
      <a href="<?php echo zm_page_url( 'contact' ); ?>" class="btn btn-primary">Book Now</a>
    </div>

    <!-- TREE REMOVAL -->
    <div class="service-card">
      <div class="service-icon">
        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="grad-tree" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" stop-color="#3DA03D" />
              <stop offset="100%" stop-color="#1A6B1A" />
            </linearGradient>
            <filter id="drop-tree" x="-20%" y="-20%" width="140%" height="140%">
              <feDropShadow dx="0" dy="6" stdDeviation="6" flood-color="#000000" flood-opacity="0.22" />
            </filter>
          </defs>
          <path
            d="M50 10 L70 40 L60 40 L80 70 L20 70 L40 40 L30 40 Z"
            fill="url(#grad-tree)"
            filter="url(#drop-tree)"
          />
        </svg>
      </div>
      <h3>Tree Removal</h3>
      <p><?php echo esc_html( zm_text( 'service_tree' ) ); ?></p>
      <a href="<?php echo zm_page_url( 'contact' ); ?>" class="btn btn-primary">Schedule</a>
    </div>

    <!-- LAWN CARE -->
    <div class="service-card">
      <div class="service-icon">
       <svg width="180" height="180" viewBox="0 0 512 512">
  <defs>
    <linearGradient id="grad4" x1="0%" y1="0%" x2="100%" y2="0%">
      <stop offset="0%" stop-color="#3DA03D"/>
      <stop offset="100%" stop-color="#1A6B1A"/>
    </linearGradient>

    <filter id="drop4">
      <feDropShadow dx="0" dy="6" stdDeviation="12" flood-color="#000" flood-opacity="0.22"/>
    </filter>

    <filter id="inner4">
      <feOffset dx="0" dy="2"/>
      <feGaussianBlur stdDeviation="3" result="blur"/>
      <feComposite operator="arithmetic" k2="-1" k3="1" in2="blur" in="SourceGraphic"/>
      <feFlood flood-color="#000" flood-opacity="0.12"/>
      <feComposite in2="SourceGraphic" operator="in"/>
    </filter>
  </defs>

  <path fill="url(#grad4)" filter="url(#drop4)"
        d="m18 494l36.35-330.4c6.728 107.62 4.086 231.82 35.556 295.67c11.205-84.926 15.707-168.18 10.562-249.01c15.225 71.69 35.543 141.68 39.468 217.14c7.395-55.935 12.667-111.52 31.798-169.41c-.76 65.19-17.16 124.9 12.677 157.47c14.433-51.01 28.992-101.9 31.46-164.88c21.27 61.862 18.342 135.82 24.948 205.02c8.417-68.06 15.28-257.84 46.907-318.17c-3.11 124.98-3.862 223.94 27.398 274.23c30.897-38.673 33.566-114.44 34.28-186.34c21.812 61.75 36.457 132.1 37.857 218.34c8.626-71.955 18.667-143.91 43.39-215.86c-5.748 88.29-1.284 156.95 19.525 194.17c13.76-55.55 25.504-111.1 29.12-166.66c18.42 82.78 13 159.59 16.706 238.69z"/>
  <path fill="url(#grad4)" filter="url(#inner4)"
        d="m18 494l36.35-330.4c6.728 107.62 4.086 231.82 35.556 295.67c11.205-84.926 15.707-168.18 10.562-249.01c15.225 71.69 35.543 141.68 39.468 217.14c7.395-55.935 12.667-111.52 31.798-169.41c-.76 65.19-17.16 124.9 12.677 157.47c14.433-51.01 28.992-101.9 31.46-164.88c21.27 61.862 18.342 135.82 24.948 205.02c8.417-68.06 15.28-257.84 46.907-318.17c-3.11 124.98-3.862 223.94 27.398 274.23c30.897-38.673 33.566-114.44 34.28-186.34c21.812 61.75 36.457 132.1 37.857 218.34c8.626-71.955 18.667-143.91 43.39-215.86c-5.748 88.29-1.284 156.95 19.525 194.17c13.76-55.55 25.504-111.1 29.12-166.66c18.42 82.78 13 159.59 16.706 238.69z"/>
</svg>


      </div>
      <h3>Lawn Care</h3>
      <p><?php echo esc_html( zm_text( 'service_lawn' ) ); ?></p>
      <a href="<?php echo zm_page_url( 'contact' ); ?>" class="btn btn-primary">Schedule</a>
    </div>
       <!-- SNOW REMOVAL -->
    <div class="service-card">
      <div class="service-icon">
        <svg width="180" height="180" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="grad-snow" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%" stop-color="#7FBFE0"/>
              <stop offset="100%" stop-color="#2C6E96"/>
            </linearGradient>
            <filter id="drop-snow" x="-20%" y="-20%" width="140%" height="140%">
              <feDropShadow dx="0" dy="6" stdDeviation="6" flood-color="#000" flood-opacity="0.22"/>
            </filter>
          </defs>
          <path fill="url(#grad-snow)" filter="url(#drop-snow)"
                d="M11 2v3.59L8.71 3.29L7.29 4.71L11 8.41v2.18l-1.89-1.09l-.01-2.52l-1.5-.02l.01 1.68l-1.46-.84l-.75 1.3l1.46.84l-1.46.84l.75 1.3l1.6-.92l1.85 1.07l-1.85 1.07l-1.6-.92l-.75 1.3l1.46.84l-1.46.84l.75 1.3l1.46-.84l-.01 1.68l1.5-.02l.01-2.52L10 14.51v2.18l-3.71 3.7l1.42 1.42L11 18.41V22h2v-3.59l2.29 2.3l1.42-1.42L13 15.59v-2.18l1.89 1.09l.01 2.52l1.5.02l-.01-1.68l1.46.84l.75-1.3l-1.46-.84l1.46-.84l-.75-1.3l-1.6.92L14.4 12l1.85-1.07l1.6.92l.75-1.3l-1.46-.84l1.46-.84l-.75-1.3l-1.46.84l.01-1.68l-1.5-.02l-.01 2.52L13 9.51V7.41l3.71-3.7l-1.42-1.42L13 5.59V2z"/>
        </svg>
      </div>
      <h3>Snow Removal</h3>
      <p><?php echo esc_html( zm_text( 'service_snow' ) ); ?></p>
      <a href="<?php echo zm_page_url( 'contact' ); ?>" class="btn btn-primary">Schedule</a>
    </div>


  </div>
</section>


 

    <!-- TESTIMONIALS SECTION -->
     
<section class="testimonials" id="testimonials">
  <h2>Testimonials</h2>
  <p class="testimonials-intro">
    <?php echo esc_html( zm_text( 'testimonials_intro' ) ); ?>
  </p>
  <a href="https://www.google.com/search?q=Z%26M+Services+Austin+MN+reviews" 
     target="_blank" 
     rel="noopener" 
     class="btn btn-primary review-link">
    Read Our Google Reviews
  </a>
</section>



    <!-- CTA / QUOTE FORM SECTION -->
    <section class="quote-section" id="contact">
        <div class="quote-container">
            <h2>Get a Free Quote</h2>
            <p><?php echo esc_html( zm_text( 'quote_intro' ) ); ?></p>
            <?php
            // Shows "Thanks!" (or an error) after the form is submitted.
            zm_form_notice();

            // On the static site Netlify handled this form. Here it sends to
            // admin-post.php, and zm_handle_quote() in functions.php does the work.
            ?>
            <form class="quote-form" name="quote-form" method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <?php // These hidden fields tell WordPress which handler to run, which form this is, and prove the request came from this page. ?>
                <input type="hidden" name="action" value="zm_quote">
                <input type="hidden" name="zm_form" value="home">
                <?php wp_nonce_field( 'zm_quote', 'zm_nonce' ); ?>
                <p class="hidden-field">
                    <label>Don't fill this out if you're human: <input name="bot-field" tabindex="-1" autocomplete="off"></label>
                </p>
                <div class="form-row">
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                </div>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="tel" name="phone" placeholder="(555) 123 - 4567" required>
                <textarea name="project_details" placeholder="Describe your project" rows="6" required></textarea>
                <button type="submit" class="btn btn-primary">Get Free Quote</button>
            </form>
        </div>
    </section>

<?php
get_footer();

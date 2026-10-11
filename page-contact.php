<?php
/**
 * Contact page. WordPress uses this file for the page whose slug is "contact".
 * Converted from the static site's contact.html.
 */

get_header();
?>

 <section class="contact-hero">
        <div class="eyebrow">Get In Touch</div>
        <h1 class="contact-hero-h1">Let's Talk About Your Property</h1>
        <p>Send us a few details and we'll get back to you with a free quote.</p>
    </section>
 
    <section class="contact-section">
        <div class="contact-grid">
 
            <!-- LEFT: form card -->
            <div class="contact-form-card" id="quote">
                <h2>Request A Free Quote</h2>
 
                <?php
                // Shows "Thanks!" (or an error) after the form is submitted.
                zm_form_notice();

                // On the static site Netlify handled this form. Here it sends to
                // admin-post.php, and zm_handle_quote() in functions.php does the work.
                ?>
                <form class="contact-form" name="contact-form" method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                    <?php // These hidden fields tell WordPress which handler to run, which form this is, and prove the request came from this page. ?>
                    <input type="hidden" name="action" value="zm_quote">
                    <input type="hidden" name="zm_form" value="contact">
                    <?php wp_nonce_field( 'zm_quote', 'zm_nonce' ); ?>
                    <p class="hidden-field">
                        <label>Don't fill this out if you're human: <input name="bot-field" tabindex="-1" autocomplete="off"></label>
                    </p>
 
                    <div class="form-row">
                        <div class="form-field">
                            <label for="name">Name</label>
                            <?php // The field is called "full_name" because WordPress reserves the word "name"; a field named "name" makes the page 404 on submit. ?>
                            <input type="text" id="name" name="full_name" required>
                        </div>
                        <div class="form-field">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                    </div>
 
                    <div class="form-field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
 
                    <div class="form-field">
                        <label for="service">Service Needed</label>
                        <select id="service" name="service" required>
                            <option value="" disabled selected>Select a service</option>
                            <option value="Lawn Care">Lawn Care</option>
                            <option value="Landscaping">Landscaping</option>
                            <option value="Tree Removal">Tree Removal</option>
                            <option value="Junk Removal">Junk Removal</option>
                            <option value="Snow Removal">Snow Removal</option>
                        </select>
                    </div>
 
                    <div class="form-field">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5"></textarea>
                    </div>
 
                    <button type="submit" class="btn-primary">Send Message</button>
                </form>
            </div>
 
            <!-- RIGHT: info column -->
            <div class="contact-info-column">
 
                <div class="contact-info-card">
                    <h3>Contact Info</h3>
 
                    <?php // Phone and hours come from Appearance > Customize > Business details. ?>
 
                    <div class="contact-info-row">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <div>
                            <p class="row-title"><?php echo esc_html( zm_detail( 'phone' ) ); ?></p>
                            <p class="row-sub">Call or Text</p>
                        </div>
                    </div>
 
                    <div class="contact-info-row">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 11l19-9-9 19-2-8-8-2z"/></svg>
                        <div>
                            <p class="row-title">Austin, MN</p>
                            <p class="row-sub">And surrounding  areas</p>
                        </div>
                    </div>
 
                    <div class="contact-info-row">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        <div>
                            <p class="row-title"><?php echo esc_html( zm_detail( 'hours' ) ); ?></p>
                            <p class="row-sub"><?php echo esc_html( zm_detail( 'hours_note' ) ); ?></p>
                        </div>
                    </div>
                </div>
 
                <div class="contact-trust-card">
                    <div class="trust-heading">
                        <svg class="icon" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01L12 2z"/></svg>
                        <span>Family Owned, Integrity First</span>
                    </div>
                    <p>Free quotes, no obligation. We'll get back to you fast.</p>
                </div>
 
                <div class="contact-map-block">
                    <p class="map-label"> </p>
                    <div class="map-embed">
                       
                      <iframe
    src="https://www.google.com/maps?q=Austin,MN&output=embed"
    allowfullscreen=""
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade">
</iframe>
                    </div>
                </div>
 
            </div>
 
        </div>
    </section>

<?php
get_footer();

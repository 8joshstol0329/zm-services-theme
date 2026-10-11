<?php
/**
 * Footer: the site footer through </html>.
 * Every page ends with this file. Templates pull it in with get_footer().
 */
?>

    <!-- FOOTER -->
    <footer class="footer">
    <div class="footer-container">
        <div class="footer-brand">
            <img src="<?php echo zm_asset( 'images/zm-logo.png' ); ?>" alt="Z&M Services" class="footer-logo">
            <p class="footer-tagline">Trusted lawn care, landscaping, and property services in Austin, MN.</p>
            <div class="footer-contact">
                <?php // Phone and email come from Appearance > Customize > Business details. ?>
                <p><a href="<?php echo esc_attr( zm_phone_href() ); ?>"><?php echo esc_html( zm_detail( 'phone' ) ); ?></a></p>
                <p><a href="mailto:<?php echo esc_attr( zm_detail( 'email' ) ); ?>"><?php echo esc_html( zm_detail( 'email' ) ); ?></a></p>
            </div>
        </div>

        <div class="footer-column">
            <h4>Services</h4>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/#services' ) ); ?>">Landscaping</a></li>
                <li><a href="<?php echo esc_url( home_url( '/#services' ) ); ?>">Lawn Care</a></li>
                <li><a href="<?php echo esc_url( home_url( '/#services' ) ); ?>">Tree Removal</a></li>
                <li><a href="<?php echo esc_url( home_url( '/#services' ) ); ?>">Junk Removal</a></li>
                <li><a href="<?php echo esc_url( home_url( '/#services' ) ); ?>">Snow Removal</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Z & M Services</h4>
            <ul>
                <li><a href="<?php echo zm_page_url( 'about' ); ?>">About Us</a></li>
                <li><a href="<?php echo zm_page_url( 'gallery' ); ?>">Gallery</a></li>
                <li><a href="<?php echo zm_page_url( 'contact' ); ?>">Contact</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Connect</h4>
            <div class="social-icons">
                <a href="https://www.facebook.com/profile.php?id=61590995967924" aria-label="Facebook">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.5 9.87v-6.98H7.9V12h2.6V9.8c0-2.56 1.52-3.98 3.86-3.98 1.12 0 2.29.2 2.29.2v2.5h-1.29c-1.27 0-1.67.79-1.67 1.6V12h2.84l-.45 2.89h-2.39v6.98A10 10 0 0 0 22 12z"/></svg>
                </a>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
    <p>© <?php echo esc_html( wp_date( 'Y' ) ); ?> Z&M SERVICES. All rights reserved.</p>
    <p class="footer-links"><a href="<?php echo zm_page_url( 'privacy' ); ?>">Privacy Policy</a> | <a href="<?php echo zm_page_url( 'terms' ); ?>">Terms &amp; Conditions</a></p>
    <p class="footer-credit">Designed & developed by <a href="https://stoltzwebdesign.com" target="_blank" rel="noopener">Stoltz Web Design</a></p>
</div>
</footer>

<?php
// WordPress prints the scripts from functions.php (nav.js) and anything
// plugins need, right here.
wp_footer();
?>
</body>
</html>

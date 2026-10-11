<?php
/**
 * ZM Services theme: setup and helper functions.
 *
 * WordPress loads this file automatically on every page.
 */

/* --------------------------------------------------------------------------
   Theme features
   -------------------------------------------------------------------------- */

add_action( 'after_setup_theme', function () {
	// Let WordPress write the <title> tag, so header.php doesn't need one.
	add_theme_support( 'title-tag' );

	// A menu slot that can be filled from the dashboard: Appearance > Menus.
	// header.php prints whatever menu is assigned to it.
	register_nav_menus(
		array(
			'primary' => 'Main navigation',
		)
	);
} );

/* --------------------------------------------------------------------------
   Navigation menu
   -------------------------------------------------------------------------- */

// WordPress marks the current page's menu item with its own class names.
// The site's CSS styles a link with the class "current", so add that class
// to the link whenever WordPress says the item is the current page.
add_filter( 'nav_menu_link_attributes', function ( $atts, $item ) {
	if ( in_array( 'current-menu-item', (array) $item->classes, true ) ) {
		$existing      = isset( $atts['class'] ) ? $atts['class'] . ' ' : '';
		$atts['class'] = $existing . 'current';
	}
	return $atts;
}, 10, 2 );

/* --------------------------------------------------------------------------
   CSS and JavaScript
   In a static site these were <link> and <script> tags in every HTML file.
   In WordPress you "enqueue" them here once, and wp_head() / wp_footer()
   print the tags on every page.
   -------------------------------------------------------------------------- */

add_action( 'wp_enqueue_scripts', function () {
	// Google Fonts (same URL the static site used).
	wp_enqueue_style(
		'zm-fonts',
		'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@400;500;600&family=Inter:wght@400;500;600&display=swap',
		array(),
		null
	);

	// The site's main stylesheet. Using the file's "last modified" time as the
	// version number makes browsers fetch a fresh copy whenever you edit it.
	wp_enqueue_style(
		'zm-main',
		get_theme_file_uri( 'assets/css/styles.css' ),
		array( 'zm-fonts' ),
		filemtime( get_theme_file_path( 'assets/css/styles.css' ) )
	);

	// The theme's own style.css (WordPress-only fixes).
	wp_enqueue_style(
		'zm-theme',
		get_stylesheet_uri(),
		array( 'zm-main' ),
		filemtime( get_stylesheet_directory() . '/style.css' )
	);

	// Hamburger menu script, loaded in the footer with "defer" like before.
	wp_enqueue_script(
		'zm-nav',
		get_theme_file_uri( 'assets/js/nav.js' ),
		array(),
		filemtime( get_theme_file_path( 'assets/js/nav.js' ) ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
} );

/* --------------------------------------------------------------------------
   Business details
   Phone, email and hours are saved once in the dashboard
   (Appearance > Customize > Business details) and printed wherever the
   templates ask for them, so a change shows up everywhere at once.
   -------------------------------------------------------------------------- */

/**
 * The starting values, used until something is saved in the Customizer.
 */
function zm_detail_defaults() {
	return array(
		'zm_phone'      => '(612) 232-6251',
		'zm_email'      => 'work@zmservicesllc.com',
		'zm_hours'      => 'Mon - Sat: 7am - 7pm',
		'zm_hours_note' => 'Closed Sundays',
	);
}

// Add the "Business details" panel and its four fields to the Customizer.
add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_section(
		'zm_business',
		array(
			'title'    => 'Business details',
			'priority' => 30,
		)
	);

	// Each field: label, input type, and the function that cleans what was typed.
	$fields = array(
		'zm_phone'      => array( 'Phone number', 'text', 'sanitize_text_field' ),
		'zm_email'      => array( 'Email address', 'email', 'sanitize_email' ),
		'zm_hours'      => array( 'Opening hours', 'text', 'sanitize_text_field' ),
		'zm_hours_note' => array( 'Hours note (for example: Closed Sundays)', 'text', 'sanitize_text_field' ),
	);

	$defaults = zm_detail_defaults();

	foreach ( $fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $defaults[ $id ],
				'sanitize_callback' => $field[2],
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field[0],
				'section' => 'zm_business',
				'type'    => $field[1],
			)
		);
	}
} );

/**
 * One business detail, for use in templates.
 * Example: echo esc_html( zm_detail( 'phone' ) );
 * Accepts: phone, email, hours, hours_note.
 */
function zm_detail( $key ) {
	$id       = 'zm_' . $key;
	$defaults = zm_detail_defaults();
	$default  = isset( $defaults[ $id ] ) ? $defaults[ $id ] : '';
	return get_theme_mod( $id, $default );
}

/**
 * The phone number as a tap-to-call link target, for example tel:+16122326251.
 * Strips everything except digits, so the number can be typed in any format.
 */
function zm_phone_href() {
	$digits = preg_replace( '/\D+/', '', zm_detail( 'phone' ) );
	if ( 10 === strlen( $digits ) ) {
		$digits = '1' . $digits; // add the US country code
	}
	return 'tel:+' . $digits;
}

/* --------------------------------------------------------------------------
   Helpers used by the template files
   -------------------------------------------------------------------------- */

/**
 * URL of a file inside the theme's assets folder.
 * Example: zm_asset( 'images/hero.jpg' )
 */
function zm_asset( $path ) {
	return esc_url( get_theme_file_uri( 'assets/' . ltrim( $path, '/' ) ) );
}

/**
 * URL of a WordPress page, found by its slug (the last part of its address).
 * Example: zm_page_url( 'about' ) replaces the old href="about.html".
 * If the page hasn't been created in the dashboard yet, this still returns
 * the address it will have.
 */
function zm_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	$url  = $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
	return esc_url( $url );
}

/**
 * Marks the navigation link for the page you're on.
 * The static site did this in nav.js by comparing file names; WordPress
 * already knows which page is showing, so PHP can do it.
 * Example: <a href="..."<?php echo zm_current( 'about' ); ?>>About</a>
 */
function zm_current( $slug ) {
	$is_current = ( 'home' === $slug ) ? is_front_page() : is_page( $slug );
	return $is_current ? ' class="current" aria-current="page"' : '';
}

/* --------------------------------------------------------------------------
   Quote requests
   The two forms (the homepage quote form and the Contact page form) both
   send to the same handler below. Each request is:
     1. checked and cleaned,
     2. saved in the dashboard under "Quote requests", and
     3. emailed to the site's admin address (Settings > General).
   Then the visitor is sent back to the form with a confirmation message.
   -------------------------------------------------------------------------- */

// A private place in the dashboard to keep the requests. "public => false"
// means they never show up on the website itself; "show_ui => true" adds the
// "Quote requests" item to the dashboard menu.
add_action( 'init', function () {
	register_post_type(
		'zm_quote',
		array(
			'labels'    => array(
				'name'          => 'Quote requests',
				'singular_name' => 'Quote request',
				'edit_item'     => 'Quote request',
				'search_items'  => 'Search quote requests',
				'not_found'     => 'No quote requests yet.',
			),
			'public'    => false,
			'show_ui'   => true,
			'menu_icon' => 'dashicons-email-alt',
			'supports'  => array( 'title', 'editor' ),
		)
	);
} );

// Both forms have a hidden field: <input type="hidden" name="action" value="zm_quote">
// and send to wp-admin/admin-post.php. WordPress reads that "action" value and runs
// whatever is hooked to admin_post_{action}. The "nopriv" version is for visitors
// who aren't logged in, which is nearly everyone, so both are hooked.
add_action( 'admin_post_nopriv_zm_quote', 'zm_handle_quote' );
add_action( 'admin_post_zm_quote', 'zm_handle_quote' );

/**
 * One text field from the submitted form, cleaned up.
 * wp_unslash() removes the backslashes WordPress adds to incoming data;
 * sanitize_text_field() strips tags, line breaks and extra spaces.
 */
function zm_posted( $field ) {
	return isset( $_POST[ $field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) : '';
}

/**
 * Runs when either form is submitted.
 */
function zm_handle_quote() {
	// Which form was it? Decides where on the page the visitor lands afterwards.
	$anchor = ( 'contact' === zm_posted( 'zm_form' ) ) ? '#quote' : '#contact';

	// The page the form was on. wp_nonce_field() adds this as a hidden field.
	$back = wp_get_referer();
	if ( ! $back ) {
		$back = home_url( '/' );
	}
	$back = remove_query_arg( 'quote', $back );

	// Small helper: send the visitor back with ?quote=sent or ?quote=error.
	$finish = function ( $status ) use ( $back, $anchor ) {
		wp_safe_redirect( add_query_arg( 'quote', $status, $back ) . $anchor );
		exit;
	};

	// 1. Security check. The nonce is a short-lived code WordPress prints in the
	//    form; if it's missing or wrong, the request didn't come from our form.
	$nonce = isset( $_POST['zm_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['zm_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'zm_quote' ) ) {
		$finish( 'error' );
	}

	// 2. Spam trap. Real visitors never see the "bot-field" input, so if it has
	//    anything in it a bot filled it out. Pretend it worked and save nothing.
	if ( '' !== zm_posted( 'bot-field' ) ) {
		$finish( 'sent' );
	}

	// 3. Collect and clean the fields. The two forms name things differently,
	//    so read whichever version was sent.
	$name = zm_posted( 'full_name' );
	if ( '' === $name ) {
		$name = trim( zm_posted( 'first_name' ) . ' ' . zm_posted( 'last_name' ) );
	}

	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = zm_posted( 'phone' );
	$service = zm_posted( 'service' );

	// The message keeps its line breaks, so it gets the textarea version of the cleaner.
	$message = '';
	foreach ( array( 'message', 'project_details' ) as $field ) {
		if ( ! empty( $_POST[ $field ] ) ) {
			$message = sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) );
		}
	}

	// 4. Make sure the required fields are really there. The "required" attribute
	//    in the HTML only stops honest browsers, so the server checks again.
	if ( '' === $name || '' === $phone || ! is_email( $email ) ) {
		$finish( 'error' );
	}

	// 5. Put the request together as plain text.
	$lines = array(
		'Name: ' . $name,
		'Phone: ' . $phone,
		'Email: ' . $email,
	);
	if ( '' !== $service ) {
		$lines[] = 'Service: ' . $service;
	}
	$lines[] = '';
	$lines[] = ( '' !== $message ) ? $message : '(No message)';
	$body    = implode( "\n", $lines );

	// 6. Save it in the dashboard (Quote requests).
	$saved = wp_insert_post(
		array(
			'post_type'    => 'zm_quote',
			'post_status'  => 'publish',
			'post_title'   => $name . ( '' !== $service ? ' - ' . $service : '' ),
			'post_content' => $body,
		)
	);

	// 7. Email it. "Reply-To" means hitting Reply answers the customer directly.
	//    On XAMPP this usually returns false because the computer has no mail
	//    server; on real hosting it sends.
	$mailed = wp_mail(
		get_option( 'admin_email' ),
		'New quote request from ' . $name,
		$body,
		array( 'Reply-To: ' . $email )
	);

	// 8. As long as the request was saved or emailed, it reached us.
	$finish( ( $saved || $mailed ) ? 'sent' : 'error' );
}

/**
 * The message shown above a form after it's submitted.
 * The handler sends the visitor back with ?quote=sent or ?quote=error in the
 * address; this prints the matching message, or nothing on a normal visit.
 * Example: <?php zm_form_notice(); ?>
 */
function zm_form_notice() {
	// sanitize_key() keeps only lowercase letters, numbers, dashes and underscores.
	$status = isset( $_GET['quote'] ) ? sanitize_key( wp_unslash( $_GET['quote'] ) ) : '';

	if ( 'sent' === $status ) {
		echo '<div class="form-notice form-notice-success" role="status">Thanks! Your request was sent. We\'ll get back to you shortly.</div>';
	} elseif ( 'error' === $status ) {
		echo '<div class="form-notice form-notice-error" role="alert">Sorry, that didn\'t go through. Please check the form and try again, or call us at ' . esc_html( zm_detail( 'phone' ) ) . '.</div>';
	}
}

/* --------------------------------------------------------------------------
   Projects (the Gallery page)
   On the static site the before/after projects were typed into gallery.html.
   Here each project is its own entry in the dashboard under "Projects", and
   page-gallery.php prints one card for each entry it finds.
   -------------------------------------------------------------------------- */

// The "Projects" item in the dashboard menu. Like quote requests, projects
// don't get pages of their own on the site ("public => false"); they only
// appear as cards on the Gallery page.
add_action( 'init', function () {
	register_post_type(
		'zm_project',
		array(
			'labels'    => array(
				'name'          => 'Projects',
				'singular_name' => 'Project',
				'add_new_item'  => 'Add project',
				'edit_item'     => 'Edit project',
				'search_items'  => 'Search projects',
				'not_found'     => 'No projects yet.',
			),
			'public'    => false,
			'show_ui'   => true,
			'menu_icon' => 'dashicons-format-gallery',
			// "title" is the card's heading. "page-attributes" adds an Order
			// number, so the cards can be put in any order (lowest first).
			'supports'  => array( 'title', 'page-attributes' ),
		)
	);
} );

/**
 * The extra fields a project has besides its title.
 * Each one is saved as "post meta": a named value attached to the project.
 */
function zm_project_fields() {
	return array(
		'zm_category'  => 'text',  // small orange label above the title
		'zm_summary'   => 'text',  // one line under the title
		'zm_before_id' => 'photo', // Media Library ID of the before photo
		'zm_after_id'  => 'photo', // Media Library ID of the after photo
	);
}

// Add the "Project details" box to the Add/Edit project screen.
add_action( 'add_meta_boxes_zm_project', function () {
	add_meta_box( 'zm_project_details', 'Project details', 'zm_project_box', 'zm_project', 'normal', 'high' );
} );

/**
 * Prints the fields inside the "Project details" box.
 */
function zm_project_box( $post ) {
	// A nonce, so the save function below can tell the request came from this screen.
	wp_nonce_field( 'zm_project_save', 'zm_project_nonce' );

	$category = get_post_meta( $post->ID, 'zm_category', true );
	$summary  = get_post_meta( $post->ID, 'zm_summary', true );
	?>
	<p>
		<label for="zm_category"><strong>Label</strong></label><br>
		<input type="text" class="widefat" id="zm_category" name="zm_category" value="<?php echo esc_attr( $category ); ?>">
		<span class="description">The small orange text above the title. Example: Lawn Care</span>
	</p>
	<p>
		<label for="zm_summary"><strong>Short description</strong></label><br>
		<input type="text" class="widefat" id="zm_summary" name="zm_summary" value="<?php echo esc_attr( $summary ); ?>">
		<span class="description">One line under the title. Example: Full mow, edge, and cleanup</span>
	</p>

	<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;max-width:640px;">
		<?php foreach ( array( 'before' => 'Before photo', 'after' => 'After photo' ) as $which => $label ) : ?>
			<?php $photo_id = (int) get_post_meta( $post->ID, 'zm_' . $which . '_id', true ); ?>
			<div class="zm-photo">
				<p><strong><?php echo esc_html( $label ); ?></strong></p>
				<div class="zm-photo-preview" style="margin-bottom:8px;">
					<?php
					if ( $photo_id ) {
						echo wp_get_attachment_image( $photo_id, 'medium', false, array( 'style' => 'max-width:100%;height:auto;display:block;' ) );
					}
					?>
				</div>
				<?php // The picker (assets/js/admin-project.js) puts the chosen photo's ID in this hidden field. ?>
				<input type="hidden" class="zm-photo-id" name="zm_<?php echo esc_attr( $which ); ?>_id" value="<?php echo esc_attr( $photo_id ? $photo_id : '' ); ?>">
				<button type="button" class="button zm-photo-choose">Choose photo</button>
				<button type="button" class="button-link zm-photo-remove">Remove</button>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

// Load the Media Library picker and our small script, but only on the project screens.
add_action( 'admin_enqueue_scripts', function () {
	$screen = get_current_screen();
	if ( ! $screen || 'zm_project' !== $screen->post_type || 'post' !== $screen->base ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script(
		'zm-admin-project',
		get_theme_file_uri( 'assets/js/admin-project.js' ),
		array(),
		filemtime( get_theme_file_path( 'assets/js/admin-project.js' ) ),
		true
	);
} );

// Save the fields when a project is saved. WordPress runs save_post_{post type}
// every time one is created or updated.
add_action( 'save_post_zm_project', function ( $post_id ) {
	// Only continue for a real save from our box, by someone allowed to edit.
	$nonce = isset( $_POST['zm_project_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['zm_project_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'zm_project_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( zm_project_fields() as $key => $type ) {
		// Text is cleaned by zm_posted(); a photo is stored as a whole number (its ID).
		$value = ( 'photo' === $type ) ? absint( zm_posted( $key ) ) : zm_posted( $key );
		update_post_meta( $post_id, $key, $value );
	}
} );

/**
 * A project's before or after photo as a full <img> tag.
 * wp_get_attachment_image() also adds srcset, so phones get a smaller file.
 * Example: echo zm_project_photo( get_the_ID(), 'before' );
 */
function zm_project_photo( $post_id, $which ) {
	$photo_id = (int) get_post_meta( $post_id, 'zm_' . $which . '_id', true );
	if ( ! $photo_id ) {
		return '';
	}

	// Use the alt text typed in the Media Library; if there isn't any, describe
	// the photo from the project title.
	$alt = get_post_meta( $photo_id, '_wp_attachment_image_alt', true );
	if ( '' === trim( (string) $alt ) ) {
		$alt = get_the_title( $post_id ) . ' (' . $which . ')';
	}

	return wp_get_attachment_image( $photo_id, 'large', false, array( 'alt' => $alt ) );
}

/* --------------------------------------------------------------------------
   Page text
   The wording on the Home and About pages used to be typed into the templates.
   Now each piece is a field in the dashboard:
   Appearance > Customize > Page text.

   It works the same way as "Business details" above: every field has a
   starting value (the original wording), and the templates ask for the
   current value with zm_text().

   To make another piece of text editable:
     1. add one line for it to the list in zm_text_fields(), and
     2. replace the text in the template with zm_text( 'its_name' ).
   -------------------------------------------------------------------------- */

/**
 * Every editable piece of text, grouped by the section it appears under in
 * the Customizer. Each field is: 'setting name' => array( label, type, starting text ).
 * "text" is a one-line box; "textarea" is a bigger box for longer text.
 */
function zm_text_fields() {
	return array(
		'zm_text_home'     => array(
			'title'  => 'Homepage',
			'fields' => array(
				'zm_hero_heading'       => array( 'Hero heading', 'text', 'Transform your Outdoor Space' ),
				'zm_hero_text'          => array( 'Hero text', 'textarea', 'Design and installation of beautiful outdoor spaces that enhance your property.' ),
				'zm_home_about_heading' => array( 'About section heading', 'text', 'Dependable, High-Quality Outdoor Services' ),
				'zm_home_about_text'    => array( 'About section text', 'textarea', 'Whether you need regular lawn maintenance, expert landscaping, safe tree removal, or fast and reliable junk removal, you can count on Z&M Services to get the job done right. We look forward to helping you create and maintain a property you can be proud of.' ),
				'zm_testimonials_intro' => array( 'Testimonials text', 'textarea', "Don't just take our word for it. See what our customers are saying on Google." ),
				'zm_quote_intro'        => array( 'Quote form text', 'text', "Tell us about your project and we'll get back to shortly" ),
			),
		),
		'zm_text_services' => array(
			'title'  => 'Homepage services',
			'fields' => array(
				'zm_services_intro'      => array( 'Text under "Our Services"', 'textarea', 'Professional outdoor solutions with a personal touch, designed to make your property shine.' ),
				'zm_service_landscaping' => array( 'Landscaping', 'textarea', 'Thoughtful landscaping that keeps your property looking its best year round.' ),
				'zm_service_junk'        => array( 'Junk Removal', 'textarea', 'Fast hasstle-free junk removal so you can reclaim your space.' ),
				'zm_service_tree'        => array( 'Tree Removal', 'textarea', 'Safe, professtional tree removal for storm damage, overgrowth, or dead trees.' ),
				'zm_service_lawn'        => array( 'Lawn Care', 'textarea', 'Regular, reliable mowing and lawn upkeep to keep your yard looking sharp all season.' ),
				'zm_service_snow'        => array( 'Snow Removal', 'textarea', 'Fast, dependable snow removal to keep your driveway and walkways safe all winter.' ),
			),
		),
		'zm_text_about'    => array(
			'title'  => 'About page',
			'fields' => array(
				'zm_about_eyebrow'     => array( 'Small heading at the top', 'text', 'Family Business You Can Trust' ),
				// A blank line between blocks of text starts a new paragraph.
				'zm_about_story'       => array(
					'Our story (leave a blank line between paragraphs)',
					'textarea',
					"At Z&M Services, we believe every property deserves to look its best. Since opening our business in 2025, we've been committed to providing dependable, high-quality outdoor services for both residential and commercial customers.\n\nWe specialize in lawn care, junk removal, tree removal, landscaping and snow removal helping our customers keep their properties clean, safe, and beautiful year-round. Whether it's routine lawn maintenance or a major cleanup project, we approach every job with professionalism, attention to detail, and pride in our work.\n\nOur mission is simple: to leave every yard looking its absolute best and ensure every customer is completely satisfied with our work. We believe that quality service, clear communication, and a strong work ethic are the foundation of lasting customer relationships.",
				),
				'zm_bio_heading'       => array( 'Owner section heading', 'text', 'Meet Zach' ),
				'zm_bio_text'          => array(
					'Owner bio (leave a blank line between paragraphs)',
					'textarea',
					"Zach is a sheriff for Mower County, and when he's not on duty, you'll find him out working on properties around Austin, MN — mowing, landscaping, and clearing out projects big and small.\n\nZ&M Services started as something Zach runs alongside his law enforcement career, built with the same values he brings to the job every day: honesty, reliability, and treating people right.\n\nOutside of work, Zach is a husband and family man, and that's part of what drives him — he treats every property like it's one he'd want to come home to himself.",
				),
				'zm_integrity_tagline' => array( 'Integrity section: small line', 'text', 'Law Enforcement Values, On Every Job' ),
				'zm_integrity_heading' => array( 'Integrity section: heading', 'text', 'Integrity Is What Sets Us Apart' ),
				'zm_integrity_text'    => array( 'Integrity section: text', 'textarea', 'As a law enforcement professional, I bring the same values of honesty, reliability, and dedication to every project. I treat every property with care and every customer with respect, because earning your trust is just as important as delivering exceptional results.' ),
			),
		),
		'zm_text_values'   => array(
			'title'  => 'About page value cards',
			'fields' => array(
				'zm_value_1_title' => array( 'Card 1 title', 'text', 'Family-Owned &Operated' ),
				'zm_value_1_text'  => array( 'Card 1 text', 'text', 'Personal, hands-on, not a franchise' ),
				'zm_value_2_title' => array( 'Card 2 title', 'text', 'Integrity First' ),
				'zm_value_2_text'  => array( 'Card 2 text', 'text', "Tied to Zach's background in law enforcement" ),
				'zm_value_3_title' => array( 'Card 3 title', 'text', 'Licensed & Insured' ),
				'zm_value_3_text'  => array( 'Card 3 text', 'text', 'Practical trust signal' ),
				'zm_value_4_title' => array( 'Card 4 title', 'text', 'Reliable &On-Time' ),
				'zm_value_4_text'  => array( 'Card 4 text', 'text', 'Practical trust signal' ),
			),
		),
		// The text search engines and social media show for each page.
		// The part after "zm_seo_" matches the page's slug (see zm_seo_description() below).
		'zm_text_seo'      => array(
			'title'  => 'Search and sharing',
			'fields' => array(
				'zm_seo_home_title' => array( 'Homepage title (the browser tab and search result heading)', 'text', 'Z&M Services | Lawn Care, Landscaping & Tree Removal in Austin, MN' ),
				'zm_seo_home'       => array( 'Homepage description', 'textarea', 'Trusted lawn care, landscaping, tree removal, and junk removal in Austin, MN. Get a free quote today.' ),
				'zm_seo_about'      => array( 'About page description', 'textarea', 'Meet the team behind Z&M Services — dependable lawn care, landscaping, and tree removal serving Austin, MN and the surrounding area.' ),
				'zm_seo_gallery'    => array( 'Gallery page description', 'textarea', "See real before-and-after results from Z&M Services' lawn care, landscaping, tree removal, and junk removal projects in Austin, MN." ),
				'zm_seo_contact'    => array( 'Contact page description', 'textarea', 'Request a free quote from Z&M Services. Call, email, or fill out our form for lawn care, landscaping, tree removal, or junk removal.' ),
				'zm_seo_privacy'    => array( 'Privacy page description', 'textarea', 'Privacy policy for Z&M Services — how we collect, use, and protect information submitted through our website.' ),
				'zm_seo_terms'      => array( 'Terms page description', 'textarea', 'Terms of service for Z&M Services — website use, service estimates, scheduling, and liability information.' ),
				'zm_seo_default'    => array( 'Description for any other page', 'textarea', 'Trusted lawn care, landscaping, tree removal, and junk removal in Austin, MN. Get a free quote today.' ),
			),
		),
	);
}

// Build the "Page text" panel in the Customizer from the list above:
// one section per group, one box per field.
add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_panel(
		'zm_text',
		array(
			'title'    => 'Page text',
			'priority' => 31,
		)
	);

	foreach ( zm_text_fields() as $section_id => $section ) {
		$wp_customize->add_section(
			$section_id,
			array(
				'title' => $section['title'],
				'panel' => 'zm_text',
			)
		);

		foreach ( $section['fields'] as $id => $field ) {
			$wp_customize->add_setting(
				$id,
				array(
					'default'           => $field[2],
					// Both cleaners strip HTML tags; the textarea one keeps line breaks.
					'sanitize_callback' => ( 'textarea' === $field[1] ) ? 'sanitize_textarea_field' : 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				$id,
				array(
					'label'   => $field[0],
					'section' => $section_id,
					'type'    => $field[1],
				)
			);
		}
	}
} );

/**
 * One piece of page text, for use in templates.
 * Returns what was saved in the Customizer, or the starting text if nothing
 * has been saved yet.
 * Example: echo esc_html( zm_text( 'hero_heading' ) );
 */
function zm_text( $key ) {
	$id = 'zm_' . $key;
	foreach ( zm_text_fields() as $section ) {
		if ( isset( $section['fields'][ $id ] ) ) {
			return get_theme_mod( $id, $section['fields'][ $id ][2] );
		}
	}
	return '';
}

/**
 * Prints a longer piece of page text as paragraphs: every blank line in the
 * text starts a new <p>. The optional second value is a CSS class for each one.
 * Example: zm_paragraphs( 'bio_text', 'bio-text' );
 */
function zm_paragraphs( $key, $class = '' ) {
	$class_attr = $class ? ' class="' . esc_attr( $class ) . '"' : '';

	// Split the text wherever there's an empty line.
	$parts = preg_split( '/\R\s*\R/', trim( zm_text( $key ) ) );

	foreach ( $parts as $part ) {
		if ( '' !== trim( $part ) ) {
			echo '<p' . $class_attr . '>' . esc_html( trim( $part ) ) . "</p>\n";
		}
	}
}

/* --------------------------------------------------------------------------
   Search and sharing tags
   On the static site every HTML file had its own <title>, description and
   social tags typed into its <head>. Here one function prints them for
   whichever page is showing, using the text saved under
   Appearance > Customize > Page text > Search and sharing.
   -------------------------------------------------------------------------- */

// WordPress builds the <title> as "Page name - Site name". Use a | between
// the two, like the static site did.
add_filter( 'document_title_separator', function () {
	return '|';
} );

// The homepage gets its own full title instead of the automatic one.
add_filter( 'document_title_parts', function ( $parts ) {
	if ( is_front_page() ) {
		return array( 'title' => zm_text( 'seo_home_title' ) );
	}
	return $parts;
} );

/**
 * The description for the page that's showing.
 * is_front_page() and is_page() are "conditional tags": questions you can ask
 * WordPress about the current page.
 */
function zm_seo_description() {
	if ( is_front_page() ) {
		return zm_text( 'seo_home' );
	}

	if ( is_page() ) {
		// The slug is the last part of the page's address, for example "about".
		// If there's a field named after it (zm_seo_about), use that.
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		$text = zm_text( 'seo_' . $slug );
		if ( '' !== $text ) {
			return $text;
		}
	}

	return zm_text( 'seo_default' );
}

/**
 * The picture shown when a page is shared: the one chosen in the Customizer,
 * or the homepage hero photo if none has been chosen.
 */
function zm_share_image_url() {
	$image_id = (int) get_theme_mod( 'zm_share_image', 0 );
	$url      = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : '';

	return $url ? $url : get_theme_file_uri( 'assets/images/hero.jpg' );
}

// Add a "Sharing image" picker to the Search and sharing section.
add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_setting(
		'zm_share_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'zm_share_image',
			array(
				'label'       => 'Sharing image',
				'description' => 'Shown when a page is shared on Facebook or in a text message. Best size: 1200 x 630. Leave empty to use the homepage hero photo.',
				'section'     => 'zm_text_seo',
				'mime_type'   => 'image',
			)
		)
	);
}, 20 );

// Print the tags inside <head>. wp_head() in header.php runs this.
// The 1 means "run early", so they sit near the top of the <head>.
add_action( 'wp_head', function () {
	$title       = wp_get_document_title();
	$description = zm_seo_description();
	$image       = zm_share_image_url();

	// The address of the page that's showing. Pages and projects know their own
	// address; anything else (the homepage, a 404) uses the homepage address.
	$url = is_singular() ? get_permalink() : home_url( '/' );
	?>
	<meta name="description" content="<?php echo esc_attr( $description ); ?>">
	<?php if ( is_front_page() && ! is_singular() ) : ?>
	<?php // WordPress adds this tag itself on pages; the homepage needs it added by hand. ?>
	<link rel="canonical" href="<?php echo esc_url( $url ); ?>">
	<?php endif; ?>
	<!-- Social sharing (Open Graph) -->
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
	<meta property="og:url" content="<?php echo esc_url( $url ); ?>">
	<meta property="og:image" content="<?php echo esc_url( $image ); ?>">
	<meta name="twitter:card" content="summary_large_image">
	<?php
}, 1 );

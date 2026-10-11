<?php
/**
 * Header: everything from <!DOCTYPE> through the navigation.
 * Every page starts with this file. Templates pull it in with get_header().
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php // The page description and social sharing tags are printed by wp_head() below.
          // They're set up in functions.php under "Search and sharing tags". ?>

    <link rel="icon" href="<?php echo zm_asset( 'favicon/favicon.ico' ); ?>" sizes="any">
    <link rel="icon" href="<?php echo zm_asset( 'favicon/favicon.svg' ); ?>" type="image/svg+xml">
    <link rel="apple-touch-icon" href="<?php echo zm_asset( 'favicon/apple-touch-icon.png' ); ?>">
    <meta name="theme-color" content="#2C2E2F">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <?php
    // WordPress prints the <title>, the stylesheets from functions.php,
    // and anything plugins need, right here.
    wp_head();
    ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

   <!-- navbar -->
<nav class="navbar">
    <div class="navbar-container">
        <div class="logo">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Z&M Services Home">
            <img src="<?php echo zm_asset( 'images/zm-logo.png' ); ?>" alt="Z&M Services">
          </a>
        </div>

        <button class="hamburger" aria-label="Toggle menu" aria-expanded="false">
            <span class="hamburger-lines">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <span class="hamburger-label">Menu</span>
        </button>

        <div class="nav-right">
            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <?php
                // A menu has been built in the dashboard (Appearance > Menus) and
                // assigned to "Main navigation": print it with the same <ul class="nav-links">
                // the design expects.
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'nav-links',
                        'depth'          => 1,
                    )
                );
                ?>
            <?php else : ?>
                <?php // No dashboard menu yet: fall back to these fixed links. ?>
                <ul class="nav-links">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo zm_current( 'home' ); ?>>Home</a></li>
                    <li><a href="<?php echo zm_page_url( 'about' ); ?>"<?php echo zm_current( 'about' ); ?>>About</a></li>
                    <li><a href="<?php echo zm_page_url( 'gallery' ); ?>"<?php echo zm_current( 'gallery' ); ?>>Gallery</a></li>
                    <li><a href="<?php echo zm_page_url( 'contact' ); ?>"<?php echo zm_current( 'contact' ); ?>>Contact</a></li>
                </ul>
            <?php endif; ?>
            <a class="cta-btn" href="<?php echo zm_page_url( 'contact' ); ?>">Quote</a>
        </div>
    </div>
</nav>
<div class="nav-backdrop"></div>

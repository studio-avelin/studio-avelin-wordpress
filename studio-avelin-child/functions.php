<?php
/**
 * Studio Avelin Child — theme setup and asset loading.
 *
 * German-only. The site was bilingual until 2026-09; the Polylang / language
 * switcher scaffolding was removed with the Ich-Marke rebuild.
 *
 * @package studio-avelin-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'SA_CHILD_VERSION' ) ) {
	define( 'SA_CHILD_VERSION', '2.1.2' );
}

/** Output the Studio Avelin browser icon set. */
function sa_child_favicon() {
	$base = get_stylesheet_directory_uri() . '/assets/img/favicons';
	echo '<link rel="icon" href="' . esc_url( $base . '/favicon.svg' ) . '" type="image/svg+xml">' . "\n";
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url( $base . '/favicon-32x32.png' ) . '">' . "\n";
	echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url( $base . '/favicon-16x16.png' ) . '">' . "\n";
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url( $base . '/apple-touch-icon.png' ) . '">' . "\n";
	echo '<link rel="shortcut icon" href="' . esc_url( $base . '/favicon.ico' ) . '">' . "\n";
	echo '<link rel="manifest" href="' . esc_url( $base . '/site.webmanifest' ) . '">' . "\n";
}
add_action( 'wp_head', 'sa_child_favicon', 100 );

/** Return the intentional browser and search-result title for Studio pages. */
function sa_child_document_title( $title ) {
	$request_path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );

	$studio_titles = array(
		'work'                             => 'Projekte – Studio Avelin',
		'services'                         => 'Leistungen – Studio Avelin',
		'contact'                          => 'Kontakt – Studio Avelin',
		'experiments'                      => 'Experiments – Studio Avelin',
		'about-me'                         => 'Über mich – Studio Avelin',
		'about'                            => 'Über mich – Studio Avelin',
		'datenschutzerklaerung'            => 'Datenschutzerklärung – Studio Avelin',
		'datenschutz'                      => 'Datenschutzerklärung – Studio Avelin',
		'impressum'                        => 'Impressum – Studio Avelin',
		'work/stan'                        => 'STAN – Studio Avelin',
		'work/stat'                        => 'StAT – Studio Avelin',
		'work/stau'                        => 'StAU – Studio Avelin',
		'work/hawaiimassage'               => 'Hawaiimassage zu Hause – Studio Avelin',
		'work/baeckerei-curfs'             => 'Bäckerei Curfs – Studio Avelin',
		'work/monroe-toyparty-landingpage' => 'Portfolio Page – Studio Avelin',
	);

	if ( is_front_page() ) {
		return 'Studio Avelin – Design. Code. Create.';
	}

	if ( isset( $studio_titles[ $request_path ] ) ) {
		return $studio_titles[ $request_path ];
	}

	if ( 0 === strpos( $request_path, 'experiments/' ) ) {
		return ucwords( str_replace( '-', ' ', basename( $request_path ) ) ) . ' – Studio Avelin';
	}

	if ( is_home() ) {
		return 'Journal – Studio Avelin';
	}

	if ( is_singular( 'post' ) ) {
		return get_the_title() . ' – Studio Avelin';
	}

	return $title;
}
add_filter( 'pre_get_document_title', 'sa_child_document_title', 100 );
add_filter( 'wpseo_title', 'sa_child_document_title', 100 );

/**
 * Add a canonical URL for routes rendered directly by the child theme, where
 * WordPress does not have a normal queried object to generate one from.
 */
function sa_child_route_canonical_link() {
	$request_path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );

	$aliases = array(
		'about'       => 'about-me',
		'datenschutz' => 'datenschutzerklaerung',
	);
	if ( isset( $aliases[ $request_path ] ) ) {
		$request_path = $aliases[ $request_path ];
	}

	$direct_routes = array(
		'services',
		'contact',
		'about-me',
		'work',
		'work/stan',
		'work/stat',
		'work/stau',
		'work/hawaiimassage',
		'work/baeckerei-curfs',
		'work/monroe-toyparty-landingpage',
		'datenschutzerklaerung',
		'impressum',
	);
	if ( ! in_array( $request_path, $direct_routes, true ) ) {
		return;
	}

	$url = trailingslashit( home_url( '/' ) ) . trailingslashit( $request_path );
	echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
}
add_action( 'wp_head', 'sa_child_route_canonical_link', 2 );

/** Avoid a duplicate Yoast canonical on the routes covered above. */
function sa_child_route_wpseo_canonical( $canonical ) {
	$request_path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	$request_path = 'about' === $request_path ? 'about-me' : $request_path;
	$request_path = 'datenschutz' === $request_path ? 'datenschutzerklaerung' : $request_path;
	$direct_routes = array( 'services', 'contact', 'about-me', 'work', 'work/stan', 'work/stat', 'work/stau', 'work/hawaiimassage', 'work/baeckerei-curfs', 'work/monroe-toyparty-landingpage', 'datenschutzerklaerung', 'impressum' );

	return in_array( $request_path, $direct_routes, true ) ? false : $canonical;
}
add_filter( 'wpseo_canonical', 'sa_child_route_wpseo_canonical', 100 );

/** Intentional descriptions for the homepage, Services and native Journal routes. */
function sa_child_meta_description( $description = '' ) {
	$request_path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );

	if ( is_front_page() ) {
		return 'Studio Avelin gestaltet und entwickelt individuelle Websites für Selbstständige und kleine Unternehmen – persönlich betreut, von der ersten Idee bis zur Sichtbarkeit.';
	}

	if ( 'services' === $request_path ) {
		return 'Individuelle Websites, Landingpages, Portfolios und WordPress-Systeme – Konzept, Design, Entwicklung und Betreuung aus einer Hand.';
	}

	if ( 'work' === $request_path ) {
		return 'Ausgewählte Kundenprojekte und eigene digitale Produkte von Studio Avelin – gestaltet, entwickelt und verfeinert im direkten Austausch.';
	}

	if ( 'contact' === $request_path ) {
		return 'Projektanfrage an Studio Avelin – persönlich, unkompliziert und direkt.';
	}

	if ( is_home() || is_singular( 'post' ) || is_category() || is_tag() ) {
		return 'Kein Marketing-Blog – ein Einblick in die Person hinter Studio Avelin: Reisen, Training und Bücher.';
	}

	return $description;
}
add_filter( 'wpseo_metadesc', 'sa_child_meta_description', 100 );

/** Output a description when no SEO plugin is managing it. */
function sa_child_meta_description_tag() {
	if ( defined( 'WPSEO_VERSION' ) ) {
		return;
	}

	$description = sa_child_meta_description();
	if ( $description ) {
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'sa_child_meta_description_tag', 2 );

/**
 * Open Graph / Twitter Card polish.
 *
 * Yoast emits Open Graph tags but, on this install, with a generic title
 * ("Startseite - Studio-Avelin"), no description and no image, so shared links
 * render bare. We feed it the intentional title/description and a default
 * sharing image.
 *
 * Note: the leftover "og:locale:alternate" / hreflang "en" come from Polylang
 * still having an English language configured — that needs the Polylang
 * setting, not theme code.
 */
function sa_child_social_image_url() {
	return get_stylesheet_directory_uri() . '/assets/img/og-default.png';
}

function sa_child_og_title( $title ) {
	$intentional = sa_child_document_title( '' );
	return $intentional ? $intentional : $title;
}
add_filter( 'wpseo_opengraph_title', 'sa_child_og_title', 20 );
add_filter( 'wpseo_twitter_title', 'sa_child_og_title', 20 );

function sa_child_og_desc( $desc ) {
	$intentional = sa_child_meta_description( '' );
	return $intentional ? $intentional : $desc;
}
add_filter( 'wpseo_opengraph_desc', 'sa_child_og_desc', 20 );
add_filter( 'wpseo_twitter_description', 'sa_child_og_desc', 20 );

/**
 * Emit a default sharing image. Yoast currently ships no og:image on this
 * install, so we add one everywhere except on singular content that has its
 * own featured image (there Yoast emits the thumbnail and we must not double up).
 */
function sa_child_fallback_social_image() {
	if ( is_admin() ) {
		return;
	}
	if ( is_singular() && has_post_thumbnail() ) {
		return;
	}
	$img = esc_url( sa_child_social_image_url() );
	echo '<meta property="og:image" content="' . $img . '">' . "\n";
	echo '<meta property="og:image:width" content="1200">' . "\n";
	echo '<meta property="og:image:height" content="630">' . "\n";
	echo '<meta name="twitter:image" content="' . $img . '">' . "\n";
}
add_action( 'wp_head', 'sa_child_fallback_social_image', 6 );

/**
 * Basic theme supports. Twenty Twenty-Four already declares most of these,
 * but the child theme keeps them explicit so nothing depends on parent order.
 */
function sa_child_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'sa_child_setup' );

/**
 * Preconnect to the Google Fonts hosts so the webfonts arrive early.
 *
 * @param array  $urls          URLs to print.
 * @param string $relation_type Relation type.
 * @return array
 */
function sa_child_resource_hints( $urls, $relation_type ) {
	if ( 'preload' === $relation_type ) {
		foreach ( array( 'poppins-300-latin.woff2', 'raleway-latin.woff2' ) as $font ) {
			$urls[] = array(
				'href'        => get_stylesheet_directory_uri() . '/assets/fonts/' . $font,
				'as'          => 'font',
				'type'        => 'font/woff2',
				'crossorigin' => 'anonymous',
			);
		}
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'sa_child_resource_hints', 10, 2 );

/**
 * Enqueue styles and scripts.
 *
 * Order matters: parent style, Google Fonts, child style, then the
 * homepage-only stylesheet and script.
 */
function sa_child_enqueue_assets() {
	$theme_dir = get_stylesheet_directory();
	$theme_uri = get_stylesheet_directory_uri();

	// Self-hosted webfonts — Poppins (display) + Raleway (body).
	// No third-party request; @font-face rules live in assets/css/sa-fonts.css.
	wp_enqueue_style(
		'sa-fonts',
		$theme_uri . '/assets/css/sa-fonts.css',
		array(),
		(string) filemtime( $theme_dir . '/assets/css/sa-fonts.css' )
	);

	// Parent theme stylesheet (Twenty Twenty-Four is a block theme; this is a no-op
	// when the file is absent, so it is guarded).
	if ( file_exists( get_template_directory() . '/style.css' ) ) {
		wp_enqueue_style(
			'sa-parent-style',
			get_template_directory_uri() . '/style.css',
			array(),
			SA_CHILD_VERSION
		);
	}

	// Child theme stylesheet — global brand tokens.
	wp_enqueue_style(
		'sa-child-style',
		$theme_uri . '/style.css',
		array( 'sa-fonts' ),
		SA_CHILD_VERSION
	);

	// Shared Studio Avelin CSS files (base tokens, header/footer chrome, page layouts).
	$base_css = $theme_dir . '/assets/css/sa-base.css';
	if ( file_exists( $base_css ) ) {
		wp_enqueue_style(
			'sa-base',
			$theme_uri . '/assets/css/sa-base.css',
			array( 'sa-child-style' ),
			(string) filemtime( $base_css )
		);
	}

	$home_css = $theme_dir . '/assets/css/home.css';
	if ( file_exists( $home_css ) ) {
		wp_enqueue_style(
			'sa-home',
			$theme_uri . '/assets/css/home.css',
			array( 'sa-child-style' ),
			(string) filemtime( $home_css )
		);
	}

	$home_js = $theme_dir . '/assets/js/home.js';
	if ( file_exists( $home_js ) ) {
		wp_enqueue_script(
			'sa-home',
			$theme_uri . '/assets/js/home.js',
			array(),
			(string) filemtime( $home_js ),
			true
		);
	}

	$pages_css = $theme_dir . '/assets/css/pages.css';
	if ( file_exists( $pages_css ) ) {
		wp_enqueue_style(
			'sa-pages',
			$theme_uri . '/assets/css/pages.css',
			array( 'sa-home' ),
			(string) filemtime( $pages_css )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'sa_child_enqueue_assets' );

/**
 * Drop the parent theme's global block styles on the homepage. The custom
 * template supplies its own layout and does not need block-theme chrome.
 */
function sa_child_dequeue_block_noise() {
	if ( ! is_front_page() ) {
		return;
	}

	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'global-styles' );
}
add_action( 'wp_enqueue_scripts', 'sa_child_dequeue_block_noise', 100 );

/**
 * Remove the WordPress admin bar margin hack on the homepage so the hero can
 * really occupy the full viewport height for logged-in editors.
 */
function sa_child_front_page_body_class( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'sa-front-body';
		$classes[] = 'sa-home';
	}

	return $classes;
}
add_filter( 'body_class', 'sa_child_front_page_body_class' );

/**
 * Site-wide cleanup: emoji scripts and the WP generator tag add nothing here.
 */
function sa_child_head_cleanup() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
}
add_action( 'init', 'sa_child_head_cleanup' );

/**
 * Route legal, About, Services and Contact pages to their custom Studio Avelin
 * PHP templates so they use the exact flat Studio Avelin header and footer.
 */
function sa_child_legal_template_include( $template ) {
	if ( is_page() ) {
		$slug = get_post_field( 'post_name', get_post() );
		if ( 'datenschutzerklaerung' === $slug || 'datenschutz' === $slug ) {
			$php_template = get_stylesheet_directory() . '/page-datenschutzerklaerung.php';
			if ( file_exists( $php_template ) ) {
				return $php_template;
			}
		}
		if ( 'about-me' === $slug || 'about' === $slug ) {
			$php_template = get_stylesheet_directory() . '/page-about-me.php';
			if ( file_exists( $php_template ) ) {
				return $php_template;
			}
		}
		if ( 'services' === $slug ) {
			$php_template = get_stylesheet_directory() . '/page-services.php';
			if ( file_exists( $php_template ) ) {
				return $php_template;
			}
		}
		if ( 'contact' === $slug || 'kontakt' === $slug ) {
			$php_template = get_stylesheet_directory() . '/page-contact.php';
			if ( file_exists( $php_template ) ) {
				return $php_template;
			}
		}
		if ( 'impressum' === $slug ) {
			$php_template = get_stylesheet_directory() . '/page-impressum.php';
			if ( file_exists( $php_template ) ) {
				return $php_template;
			}
		}
	}
	return $template;
}
add_filter( 'template_include', 'sa_child_legal_template_include', 99 );

add_action( 'template_redirect', function() {
	if ( is_admin() ) {
		return;
	}
	$request_uri = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
	if ( 'work/maaike-fiebus' === $request_uri ) {
		wp_safe_redirect( home_url( '/work/monroe-toyparty-landingpage/' ), 301 );
		exit;
	}
	if ( 'work/doula-anja' === $request_uri ) {
		wp_safe_redirect( home_url( '/work/' ), 301 );
		exit;
	}
	if ( 'about-me' === $request_uri || 'about' === $request_uri ) {
		status_header( 200 );
		$GLOBALS['wp_query']->is_404 = false;
		include get_stylesheet_directory() . '/page-about-me.php';
		exit;
	}
	if ( 'services' === $request_uri ) {
		status_header( 200 );
		$GLOBALS['wp_query']->is_404 = false;
		include get_stylesheet_directory() . '/page-services.php';
		exit;
	}
	if ( 'contact' === $request_uri || 'kontakt' === $request_uri ) {
		status_header( 200 );
		$GLOBALS['wp_query']->is_404 = false;
		include get_stylesheet_directory() . '/page-contact.php';
		exit;
	}
	if ( 'datenschutzerklaerung' === $request_uri || 'datenschutz' === $request_uri ) {
		status_header( 200 );
		$GLOBALS['wp_query']->is_404 = false;
		include get_stylesheet_directory() . '/page-datenschutzerklaerung.php';
		exit;
	}
	if ( 'impressum' === $request_uri ) {
		status_header( 200 );
		$GLOBALS['wp_query']->is_404 = false;
		include get_stylesheet_directory() . '/page-impressum.php';
		exit;
	}
	if ( 'experiments' === $request_uri ) {
		status_header( 200 );
		$GLOBALS['wp_query']->is_404 = false;
		include get_stylesheet_directory() . '/page-experiments.php';
		exit;
	}
	if ( 0 === strpos( $request_uri, 'experiments/' ) ) {
		status_header( 200 );
		$GLOBALS['wp_query']->is_404 = false;
		include get_stylesheet_directory() . '/single-experiment.php';
		exit;
	}
	if ( 'work' === $request_uri ) {
		status_header( 200 );
		$GLOBALS['wp_query']->is_404 = false;
		include get_stylesheet_directory() . '/page-work.php';
		exit;
	}
	if ( 0 === strpos( $request_uri, 'work/' ) ) {
		$sub  = trim( str_replace( 'work/', '', $request_uri ), '/' );
		$file = get_stylesheet_directory() . '/page-work-' . sanitize_file_name( $sub ) . '.php';
		if ( ! file_exists( $file ) ) {
			// Unknown or retired project slug (e.g. the removed "doula-anja"):
			// send it to the projects index instead of showing a soft 404.
			wp_safe_redirect( home_url( '/work/' ), 301 );
			exit;
		}
		status_header( 200 );
		$GLOBALS['wp_query']->is_404 = false;
		include $file;
		exit;
	}
}, 0 );

/** Return the public contact page URL. */
function sa_child_contact_url() {
	return trailingslashit( home_url( '/' ) ) . 'contact/';
}

/** Process a project enquiry and send it by email without database storage. */
function sa_child_handle_contact_form() {
	$redirect = sa_child_contact_url();

	if ( ! isset( $_POST['sa_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sa_contact_nonce'] ) ), 'sa_contact_submit' ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'invalid', $redirect ) );
		exit;
	}

	if ( ! empty( $_POST['sa_company'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'sent', $redirect ) );
		exit;
	}

	$name     = isset( $_POST['sa_name'] ) ? sanitize_text_field( wp_unslash( $_POST['sa_name'] ) ) : '';
	$email    = isset( $_POST['sa_email'] ) ? sanitize_email( wp_unslash( $_POST['sa_email'] ) ) : '';
	$project  = isset( $_POST['sa_project'] ) ? sanitize_key( wp_unslash( $_POST['sa_project'] ) ) : '';
	$timeline = isset( $_POST['sa_timeline'] ) ? sanitize_text_field( wp_unslash( $_POST['sa_timeline'] ) ) : '';
	$message  = isset( $_POST['sa_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['sa_message'] ) ) : '';
	$consent  = ! empty( $_POST['sa_consent'] );
	$projects = array(
		'website'   => 'Individuelle Website',
		'landing'   => 'Landingpage oder Portfolio',
		'wordpress' => 'WordPress',
		'optimize'  => 'Bestehende Website optimieren',
		'other'     => 'Etwas anderes',
	);

	if ( '' === $name || ! is_email( $email ) || ! isset( $projects[ $project ] ) || '' === $message || ! $consent ) {
		wp_safe_redirect( add_query_arg( 'contact', 'missing', $redirect ) );
		exit;
	}

	$rate_key = 'sa_contact_' . md5( (string) ( $_SERVER['REMOTE_ADDR'] ?? '' ) );
	if ( get_transient( $rate_key ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'later', $redirect ) );
		exit;
	}

	$subject = sprintf( 'Projektanfrage von %s — Studio Avelin', $name );
	$body    = "Name: {$name}\nE-Mail: {$email}\nProjekt: {$projects[$project]}\nZeitraum: " . ( $timeline ?: '–' ) . "\n\nNachricht:\n{$message}";
	$headers = array(
		'From: Studio Avelin <hello@studio-avelin.com>',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	if ( wp_mail( 'hello@studio-avelin.com', $subject, $body, $headers ) ) {
		set_transient( $rate_key, 1, 2 * MINUTE_IN_SECONDS );
		wp_safe_redirect( add_query_arg( 'contact', 'sent', $redirect ) );
	} else {
		wp_safe_redirect( add_query_arg( 'contact', 'failed', $redirect ) );
	}
	exit;
}
add_action( 'admin_post_sa_contact_submit', 'sa_child_handle_contact_form' );
add_action( 'admin_post_nopriv_sa_contact_submit', 'sa_child_handle_contact_form' );

/**
 * Send WordPress mail through the authenticated IONOS mailbox when its
 * credentials are defined outside the theme in wp-config.php.
 *
 * @param PHPMailer\PHPMailer\PHPMailer $phpmailer WordPress mailer instance.
 */
function sa_child_configure_ionos_smtp( $phpmailer ) {
	if ( ! defined( 'SA_SMTP_USER' ) || ! defined( 'SA_SMTP_PASSWORD' ) || ! SA_SMTP_USER || ! SA_SMTP_PASSWORD ) {
		return;
	}

	$phpmailer->isSMTP();
	$phpmailer->Host       = 'smtp.ionos.de';
	$phpmailer->Port       = 465;
	$phpmailer->SMTPSecure = 'ssl';
	$phpmailer->SMTPAuth   = true;
	$phpmailer->Username   = SA_SMTP_USER;
	$phpmailer->Password   = SA_SMTP_PASSWORD;
	$phpmailer->setFrom( SA_SMTP_USER, 'Studio Avelin', false );
	$phpmailer->Sender = SA_SMTP_USER;
}
add_action( 'phpmailer_init', 'sa_child_configure_ionos_smtp' );

require_once get_stylesheet_directory() . '/inc/sa-journal.php';

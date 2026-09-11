<?php
/**
 * Studio Avelin Journal: editor controls and template helpers for the
 * native `post` post type, styled and routed as the "Journal".
 *
 * Journal entries are normal WordPress posts (so they can be published via
 * the WordPress REST API from Ulysses) using the standard `category` and
 * `post_tag` taxonomies. Routing and design come from home.php, single.php,
 * category.php and tag.php plus the journal/* partials, picked up
 * automatically through WordPress's normal template hierarchy.
 *
 * @package studio-avelin-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Add the native featured-entry control. */
function sa_journal_add_featured_box() {
	add_meta_box( 'sa-journal-featured', __( 'Journal feature', 'studio-avelin-child' ), 'sa_journal_featured_box', 'post', 'side' );
}
add_action( 'add_meta_boxes', 'sa_journal_add_featured_box' );

/** Render featured-entry control. */
function sa_journal_featured_box( $post ) {
	wp_nonce_field( 'sa_journal_save_featured', 'sa_journal_featured_nonce' );
	?>
	<label><input type="checkbox" name="sa_journal_featured" value="1" <?php checked( '1', get_post_meta( $post->ID, 'sa_journal_featured', true ) ); ?>> <?php esc_html_e( 'Use as featured entry', 'studio-avelin-child' ); ?></label>
	<p class="description"><?php esc_html_e( 'The most recently published checked entry is shown.', 'studio-avelin-child' ); ?></p>
	<?php
}

/** Save featured-entry metadata. */
function sa_journal_save_featured( $post_id ) {
	if ( ! isset( $_POST['sa_journal_featured_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sa_journal_featured_nonce'] ) ), 'sa_journal_save_featured' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || ! current_user_can( 'edit_post', $post_id ) || 'post' !== get_post_type( $post_id ) ) {
		return;
	}
	if ( isset( $_POST['sa_journal_featured'] ) ) {
		update_post_meta( $post_id, 'sa_journal_featured', '1' );
	} else {
		delete_post_meta( $post_id, 'sa_journal_featured' );
	}
}
add_action( 'save_post_post', 'sa_journal_save_featured' );

/** Whether the current request belongs to the Journal (the blog). */
function sa_journal_is_request() {
	return is_home() || is_singular( 'post' ) || is_category() || is_tag();
}

/** URL of the Journal archive (the WordPress "posts page"). */
function sa_journal_archive_url() {
	$page_id = (int) get_option( 'page_for_posts' );
	return $page_id ? get_permalink( $page_id ) : home_url( '/journal/' );
}

/** Load Journal assets only on Journal routes. */
function sa_journal_enqueue_assets() {
	if ( ! sa_journal_is_request() ) {
		return;
	}
	$dir = get_stylesheet_directory();
	$uri = get_stylesheet_directory_uri();
	$css = $dir . '/assets/css/sa-journal.css';
	$js  = $dir . '/assets/js/sa-journal.js';
	wp_enqueue_style( 'sa-journal', $uri . '/assets/css/sa-journal.css', array( 'sa-base' ), (string) filemtime( $css ) );
	wp_enqueue_script( 'sa-journal', $uri . '/assets/js/sa-journal.js', array(), (string) filemtime( $js ), true );
}
add_action( 'wp_enqueue_scripts', 'sa_journal_enqueue_assets', 20 );

/** Calculate reading time from saved post content. */
function sa_journal_reading_time( $post_id = null ) {
	$content = get_post_field( 'post_content', $post_id ?: get_the_ID() );
	$words   = preg_match_all( '/[\p{L}\p{N}]+/u', wp_strip_all_tags( strip_shortcodes( $content ) ), $matches );
	return max( 1, (int) ceil( $words / 220 ) );
}

/** Return the chosen feature, or the newest published entry. */
function sa_journal_featured_post() {
	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => 'sa_journal_featured',
			'meta_value'     => '1',
		)
	);
	if ( empty( $posts ) ) {
		$posts = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 1 ) );
	}
	return $posts ? $posts[0] : null;
}

/** Make a stable, unique heading ID. */
function sa_journal_unique_heading_id( $text, &$used ) {
	$base = sanitize_title( $text );
	$base = $base ?: 'section';
	$id   = $base;
	$i    = 2;
	while ( isset( $used[ $id ] ) ) {
		$id = $base . '-' . $i++;
	}
	$used[ $id ] = true;
	return $id;
}

/** Add heading IDs and return the H2/H3 table of contents. */
function sa_journal_prepare_content( $content ) {
	$headings = array();
	$used     = array();
	$content  = preg_replace_callback(
		'/<h([23])([^>]*)>(.*?)<\/h\1>/is',
		function ( $match ) use ( &$headings, &$used ) {
			$text = trim( wp_strip_all_tags( $match[3] ) );
			if ( preg_match( '/\sid=(["\'])([^"\']+)\1/i', $match[2], $id_match ) ) {
				$id       = sa_journal_unique_heading_id( $id_match[2], $used );
				$match[2] = preg_replace( '/\sid=(["\'])([^"\']+)\1/i', ' id="' . esc_attr( $id ) . '"', $match[2], 1 );
			} else {
				$id       = sa_journal_unique_heading_id( $text, $used );
				$match[2] = rtrim( $match[2] ) . ' id="' . esc_attr( $id ) . '"';
			}
			$headings[] = array( 'level' => (int) $match[1], 'id' => $id, 'text' => $text );
			return '<h' . $match[1] . $match[2] . '>' . $match[3] . '</h' . $match[1] . '>';
		},
		$content
	);
	return array( 'content' => $content, 'headings' => $headings );
}

/** Render an image or deterministic abstract SVG fallback. */
function sa_journal_post_cover( $post_id = null, $size = 'large' ) {
	$post_id = $post_id ?: get_the_ID();
	if ( has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail( $post_id, $size, array( 'loading' => 'lazy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		return;
	}
	$post = get_post( $post_id );
	$seed = abs( crc32( $post->post_name ) );
	$x    = 42 + ( $seed % 120 );
	$y    = 38 + ( ( $seed >> 4 ) % 70 );
	$kind = $seed % 3;
	?>
	<svg class="sa-post-cover" viewBox="0 0 640 400" role="img" aria-label="<?php echo esc_attr( sprintf( __( 'Abstract cover for %s', 'studio-avelin-child' ), get_the_title( $post_id ) ) ); ?>" preserveAspectRatio="xMidYMid slice">
		<rect width="640" height="400" fill="#181818"/>
		<?php if ( 0 === $kind ) : ?>
			<path d="M0 80H640M0 160H640M0 240H640M0 320H640M80 0V400M160 0V400M240 0V400M320 0V400M400 0V400M480 0V400M560 0V400" stroke="#C7F000" opacity=".15"/>
			<rect x="<?php echo esc_attr( $x ); ?>" y="<?php echo esc_attr( $y ); ?>" width="220" height="220" fill="#C7F000"/><rect x="<?php echo esc_attr( $x + 150 ); ?>" y="150" width="300" height="90" fill="#181818" stroke="#C7F000" stroke-width="3"/>
		<?php elseif ( 1 === $kind ) : ?>
			<circle cx="<?php echo esc_attr( 150 + ( $seed % 100 ) ); ?>" cy="200" r="120" fill="#C7F000"/><rect x="300" y="90" width="270" height="220" fill="#181818" stroke="#C7F000" stroke-width="3"/><path d="M300 200H570" stroke="#C7F000" stroke-width="3"/>
		<?php else : ?>
			<text x="55" y="185" fill="#F2F2F2" font-family="Poppins, sans-serif" font-size="150" font-weight="800">0<?php echo esc_html( 1 + ( $seed % 9 ) ); ?></text><path d="M55 225H585" stroke="#C7F000" stroke-width="4"/><rect x="455" y="260" width="130" height="70" fill="#C7F000"/>
		<?php endif; ?>
		<rect x="24" y="356" width="9" height="9" fill="#C7F000"/><text x="43" y="365" fill="#F2F2F2" opacity=".65" font-family="Poppins, sans-serif" font-size="13" letter-spacing="3">A/ JOURNAL</text>
	</svg>
	<?php
}

/** Find related entries: same categories first, then recent entries. */
function sa_journal_related_posts( $post_id, $limit = 3 ) {
	$term_ids = wp_get_post_terms( $post_id, 'category', array( 'fields' => 'ids' ) );
	$args     = array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $limit, 'post__not_in' => array( $post_id ) );
	if ( $term_ids ) {
		$args['tax_query'] = array( array( 'taxonomy' => 'category', 'field' => 'term_id', 'terms' => $term_ids ) );
	}
	$related = get_posts( $args );
	if ( count( $related ) < $limit ) {
		$exclude = array_merge( array( $post_id ), wp_list_pluck( $related, 'ID' ) );
		$fill    = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $limit - count( $related ), 'post__not_in' => $exclude ) );
		$related = array_merge( $related, $fill );
	}
	return $related;
}

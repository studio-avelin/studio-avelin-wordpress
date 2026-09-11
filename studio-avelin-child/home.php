<?php
/** Journal archive: the WordPress posts page, plus category and tag archives (see category.php / tag.php). */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$featured  = sa_journal_featured_post();
$term      = ( is_category() || is_tag() ) ? get_queried_object() : null;
$is_filter = $term instanceof WP_Term;
$paged     = max( 1, get_query_var( 'paged' ) );
$args      = array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 12, 'paged' => $paged );
if ( ! $is_filter && $featured ) { $args['post__not_in'] = array( $featured->ID ); }
if ( $is_filter ) { $args['tax_query'] = array( array( 'taxonomy' => $term->taxonomy, 'field' => 'term_id', 'terms' => $term->term_id ) ); }
$entries    = new WP_Query( $args );
$categories = get_terms( array( 'taxonomy' => 'category', 'hide_empty' => true ) );
?>
<!doctype html><html <?php language_attributes(); ?>><head><meta charset="<?php bloginfo( 'charset' ); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class( 'sa-subpage sa-journal-body' ); ?>><?php wp_body_open(); get_template_part( 'journal/header' ); ?>
<main id="primary" class="sa-page sa-journal">
	<section class="sa-journal-hero"><div class="sa-journal-container sa-journal-hero__grid">
		<div><p class="sa-journal-kicker"><?php echo $is_filter ? esc_html( 'Journal / ' . ( $term->taxonomy === 'post_tag' ? 'Tag' : 'Kategorie' ) ) : 'Studio Avelin'; ?></p><h1><?php echo $is_filter ? esc_html( $term->name ) : wp_kses_post( 'Notizen aus<br>dem Studio.' ); ?></h1><span class="sa-journal-rule" aria-hidden="true"></span><p class="sa-journal-lede"><?php echo $is_filter && $term->description ? esc_html( $term->description ) : esc_html( 'Gedanken zu Design, Entwicklung und digitaler Arbeit.' ); ?></p></div>
		<aside class="sa-journal-note"><p class="sa-journal-label"><?php echo esc_html( 'Aus dem Studio' ); ?></p><p><?php echo esc_html( 'Hier geht es um laufende Projekte, Entscheidungen, Werkzeuge und Erkenntnisse aus dem Studioalltag.' ); ?></p><small><?php echo esc_html( wp_count_posts( 'post' )->publish ); ?> <?php echo esc_html( 'Einträge' ); ?></small></aside>
	</div></section>
	<?php if ( ! $is_filter && $featured ) : setup_postdata( $featured ); ?>
	<section class="sa-journal-container sa-featured"><p class="sa-journal-label"><i aria-hidden="true"></i><?php echo esc_html( 'Ausgewählter Beitrag' ); ?></p><article class="sa-featured__grid"><a class="sa-featured__media" href="<?php the_permalink(); ?>"><?php get_template_part( 'journal/post-cover', null, array( 'size' => 'large' ) ); ?></a><div class="sa-featured__body"><p class="sa-journal-card__meta"><?php echo esc_html( strtoupper( get_the_date( 'F j, Y' ) ) ); ?> · <?php echo esc_html( sa_journal_reading_time() ); ?> <?php echo esc_html( 'MIN. LESEZEIT' ); ?></p><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 35, '…' ) ); ?></p><a class="sa-read-link" href="<?php the_permalink(); ?>"><?php echo esc_html( 'Artikel lesen' ); ?> <span aria-hidden="true">→</span></a></div></article></section>
	<?php wp_reset_postdata(); endif; ?>
	<section class="sa-journal-container sa-archive"><header class="sa-archive__head"><div><h2><?php echo esc_html( $is_filter ? 'Einträge' : 'Alle Einträge' ); ?></h2><p><?php echo esc_html( 'Die neuesten Notizen aus dem Studio.' ); ?></p></div><div class="sa-archive__tools"><nav aria-label="<?php echo esc_attr( 'Journal-Kategorien' ); ?>"><a class="<?php echo ! $is_filter ? 'is-active' : ''; ?>" href="<?php echo esc_url( sa_journal_archive_url() ); ?>"><?php echo esc_html( 'Alle' ); ?></a><?php foreach ( $categories as $category ) : ?><a class="<?php echo $is_filter && $term->term_id === $category->term_id ? 'is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a><?php endforeach; ?></nav><label class="sa-journal-search"><span class="screen-reader-text"><?php echo esc_html( 'Einträge durchsuchen' ); ?></span><span aria-hidden="true">⌕</span><input type="search" data-journal-search placeholder="<?php echo esc_attr( 'Einträge und Tags durchsuchen …' ); ?>"></label></div></header>
		<?php if ( $entries->have_posts() ) : ?><div class="sa-journal-grid" data-journal-grid><?php while ( $entries->have_posts() ) : $entries->the_post(); get_template_part( 'journal/template-card' ); endwhile; ?></div><p class="sa-journal-no-results" data-journal-empty hidden><?php echo esc_html( 'Keine passenden Einträge. Versuche eine andere Suche.' ); ?></p><?php else : ?><p class="sa-journal-empty"><?php echo esc_html( 'Hier ist noch nichts.' ); ?></p><?php endif; ?>
		<?php $links = paginate_links( array( 'total' => $entries->max_num_pages, 'current' => $paged, 'type' => 'array' ) ); if ( $links ) : ?><nav class="sa-journal-pagination" aria-label="<?php esc_attr_e( 'Journal pagination', 'studio-avelin-child' ); ?>"><?php foreach ( $links as $link ) { echo wp_kses_post( $link ); } ?></nav><?php endif; wp_reset_postdata(); ?>
	</section>
</main><?php get_template_part( 'journal/footer' ); wp_footer(); ?></body></html>

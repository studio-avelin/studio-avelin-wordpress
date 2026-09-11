<?php
/** Single Journal entry (native post). */
if ( ! defined( 'ABSPATH' ) ) { exit; }
the_post();
$prepared   = sa_journal_prepare_content( apply_filters( 'the_content', get_the_content() ) );
$categories = get_the_terms( get_the_ID(), 'category' );
$category   = $categories && ! is_wp_error( $categories ) ? $categories[0] : null;
$tags       = get_the_terms( get_the_ID(), 'post_tag' );
$related    = sa_journal_related_posts( get_the_ID() );
?>
<!doctype html><html <?php language_attributes(); ?>><head><meta charset="<?php bloginfo( 'charset' ); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class( 'sa-subpage sa-journal-body' ); ?>><?php wp_body_open(); get_template_part( 'journal/header' ); ?>
<main id="primary" class="sa-page sa-journal"><article class="sa-single"><div class="sa-journal-container sa-single__grid">
	<aside class="sa-single__aside"><div class="sa-single__sticky"><a class="sa-back" href="<?php echo esc_url( sa_journal_archive_url() ); ?>">← <?php echo esc_html( 'Zurück zum Journal' ); ?></a>
	<?php if ( $prepared['headings'] ) : ?><nav class="sa-toc" aria-label="<?php echo esc_attr( 'Auf dieser Seite' ); ?>"><p class="sa-journal-label"><?php echo esc_html( 'Auf dieser Seite' ); ?></p><ol><?php foreach ( $prepared['headings'] as $index => $heading ) : ?><li class="sa-toc__level-<?php echo esc_attr( $heading['level'] ); ?>"><span><?php echo esc_html( str_pad( $index + 1, 2, '0', STR_PAD_LEFT ) ); ?></span><a href="#<?php echo esc_attr( $heading['id'] ); ?>"><?php echo esc_html( $heading['text'] ); ?></a></li><?php endforeach; ?></ol></nav><?php endif; ?>
	<div><p class="sa-journal-label"><?php echo esc_html( 'Teilen' ); ?></p><button class="sa-copy-link" type="button" data-copy-link data-default-label="<?php echo esc_attr( 'Link kopieren' ); ?>"><?php echo esc_html( 'Link kopieren' ); ?></button></div>
	<?php if ( $tags && ! is_wp_error( $tags ) ) : ?><div class="sa-single__tags"><p class="sa-journal-label"><?php esc_html_e( 'Tags', 'studio-avelin-child' ); ?></p><?php foreach ( $tags as $tag ) : ?><a href="<?php echo esc_url( get_term_link( $tag ) ); ?>">#<?php echo esc_html( $tag->name ); ?></a><?php endforeach; ?></div><?php endif; ?></div></aside>
	<div class="sa-single__main"><header class="sa-single__header"><p class="sa-single__meta"><?php if ( $category ) : ?><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a><span> · </span><?php endif; ?><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( strtoupper( get_the_date( 'F j, Y' ) ) ); ?></time><span> · </span><?php echo esc_html( sa_journal_reading_time() ); ?> <?php echo esc_html( 'MIN. LESEZEIT' ); ?></p><h1><?php the_title(); ?></h1><span class="sa-journal-rule" aria-hidden="true"></span><?php if ( has_excerpt() ) : ?><p class="sa-single__lede"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?><figure class="sa-single__cover"><?php get_template_part( 'journal/post-cover', null, array( 'size' => 'full' ) ); ?></figure></header>
	<div class="sa-prose"><?php echo $prepared['content']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
	<footer class="sa-single__foot"><a href="<?php echo esc_url( sa_journal_archive_url() ); ?>">← <?php echo esc_html( 'Zurück zum Journal' ); ?></a><?php if ( $category ) : ?><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( sprintf( 'Mehr in %s', $category->name ) ); ?> →</a><?php endif; ?></footer></div>
</div></article>
<?php if ( $related ) : ?><section class="sa-related sa-journal-container"><header><h2><?php echo esc_html( 'Ähnliche Beiträge' ); ?></h2><a href="<?php echo esc_url( sa_journal_archive_url() ); ?>"><?php echo esc_html( 'Alle Einträge' ); ?> →</a></header><div class="sa-journal-grid sa-journal-grid--related"><?php foreach ( $related as $post ) : setup_postdata( $post ); get_template_part( 'journal/template-card' ); endforeach; wp_reset_postdata(); ?></div></section><?php endif; ?>
</main><?php get_template_part( 'journal/footer' ); wp_footer(); ?></body></html>

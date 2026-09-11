<?php
/** Flat editorial Journal card. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$categories = get_the_terms( get_the_ID(), 'category' );
$category   = $categories && ! is_wp_error( $categories ) ? $categories[0] : null;
$category_names = $category ? wp_list_pluck( $categories, 'name' ) : array();
?>
<article <?php post_class( 'sa-journal-card' ); ?> data-journal-card data-search-text="<?php echo esc_attr( get_the_title() . ' ' . get_the_excerpt() . ' ' . implode( ' ', $category_names ) . ' ' . implode( ' ', wp_get_post_terms( get_the_ID(), 'post_tag', array( 'fields' => 'names' ) ) ) ); ?>">
	<a class="sa-journal-card__media" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( '%s lesen', get_the_title() ) ); ?>">
		<?php get_template_part( 'journal/post-cover', null, array( 'size' => 'medium_large' ) ); ?>
	</a>
	<div class="sa-journal-card__body">
		<p class="sa-journal-card__meta">
			<?php if ( $category ) : ?><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a><span aria-hidden="true"> · </span><?php endif; ?>
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( strtoupper( get_the_date( 'M j, Y' ) ) ); ?></time>
		</p>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="sa-journal-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24, '…' ) ); ?></p>
		<div class="sa-journal-card__foot"><span><?php echo esc_html( sa_journal_reading_time() ); ?> <?php echo esc_html( 'Min.' ); ?></span><a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( '%s lesen', get_the_title() ) ); ?>">→</a></div>
	</div>
</article>

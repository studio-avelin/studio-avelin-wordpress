<?php
/** Journal-specific navigation. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$archive_url    = sa_journal_archive_url();
$journal_terms  = get_terms( array( 'taxonomy' => 'category', 'hide_empty' => true, 'number' => 1 ) );
$categories_url = $journal_terms && ! is_wp_error( $journal_terms ) ? get_term_link( $journal_terms[0] ) : $archive_url;
$is_taxonomy    = is_category() || is_tag();
?>
<header class="sa-journal-header">
	<div class="sa-journal-header__inner">
		<a class="sa-journal-brand" href="<?php echo esc_url( $archive_url ); ?>" aria-label="Startseite des Studio Avelin Journals">
			<span class="sa-journal-brand__mark" aria-hidden="true">A<span>/</span></span>
			<span class="sa-journal-brand__studio">Studio Avelin</span>
			<span class="sa-journal-brand__section">Journal</span>
		</a>
		<nav class="sa-journal-nav" aria-label="Journal-Navigation">
			<a class="<?php echo ! $is_taxonomy ? 'is-active' : ''; ?>" href="<?php echo esc_url( $archive_url ); ?>">Journal</a>
			<a class="<?php echo $is_taxonomy ? 'is-active' : ''; ?>" href="<?php echo esc_url( $categories_url ); ?>">Kategorien</a>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Studio</a>
		</nav>
	</div>
</header>

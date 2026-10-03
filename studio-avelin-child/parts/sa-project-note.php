<?php
/**
 * Studio Avelin – shared project note renderer.
 *
 * Expects $sa_project (array) before including this part:
 *   title, summary, status, role, stack, state
 *   description (array of paragraphs)
 *   link (url|''), link_display, link_label
 *   hero (image url|''), gallery (array of image urls)
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( empty( $sa_project ) || ! is_array( $sa_project ) ) {
	return;
}

$sa_hero_img  = ! empty( $sa_project['hero'] ) ? $sa_project['hero'] : '';
$sa_gallery   = ! empty( $sa_project['gallery'] ) && is_array( $sa_project['gallery'] ) ? $sa_project['gallery'] : array();
$sa_home_base = trailingslashit( home_url( '/' ) );
$sa_link_ext  = ! empty( $sa_project['link'] ) && 0 === strpos( $sa_project['link'], 'http' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class( array( 'sa-subpage', 'sa-front', 'sa-projectnote' ) ); ?>>
<?php wp_body_open(); ?>

<a class="sa-skip" href="#sa-pn-main">Zum Inhalt springen</a>

<?php get_template_part('parts/sa-header'); ?>

<main id="sa-pn-main" class="sa-pn">
  <div class="sa-shell">

    <header class="sa-pn__head sa-reveal">
      <span class="sa-sec-kicker">Projektnotiz</span>
      <h1 class="sa-pn__title"><?php echo esc_html( $sa_project['title'] ); ?></h1>
      <?php if ( ! empty( $sa_project['subtitle'] ) ) : ?>
        <p class="sa-pn__subtitle"><?php echo esc_html( $sa_project['subtitle'] ); ?></p>
      <?php endif; ?>
      <p class="sa-pn__lead"><?php echo esc_html( $sa_project['summary'] ); ?></p>
      <div class="sa-pn__meta">
        <span class="sa-pn__pill"><span class="sa-pn__pill-dot" aria-hidden="true"></span><?php echo esc_html( $sa_project['status'] ); ?></span>
        <?php if ( ! empty( $sa_project['link'] ) ) : ?>
          <a class="sa-textlink" href="<?php echo esc_url( $sa_project['link'] ); ?>"<?php echo $sa_link_ext ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
            <?php echo esc_html( $sa_project['link_label'] ); ?> <span aria-hidden="true">&rarr;</span>
          </a>
        <?php endif; ?>
      </div>
    </header>

    <?php if ( $sa_hero_img ) : ?>
      <figure class="sa-pn__hero sa-reveal">
        <img src="<?php echo esc_url( $sa_hero_img ); ?>" alt="<?php echo esc_attr( trim( $sa_project['title'] . ( ! empty( $sa_project['subtitle'] ) ? ' – ' . $sa_project['subtitle'] : '' ) ) ); ?>" loading="eager" />
      </figure>
    <?php else : ?>
      <div class="sa-pn__hero sa-pn__hero--placeholder sa-reveal" aria-hidden="true">
        <span class="sa-pn__chrome"><span></span><span></span><span></span></span>
        <span class="sa-pn__ph"><?php echo esc_html( $sa_project['title'] ); ?></span>
      </div>
    <?php endif; ?>

    <div class="sa-pn__body">
      <div class="sa-pn__text sa-reveal">
        <?php foreach ( $sa_project['description'] as $sa_paragraph ) : ?>
          <p><?php echo esc_html( $sa_paragraph ); ?></p>
        <?php endforeach; ?>
      </div>

      <aside class="sa-pn__facts sa-reveal">
        <dl>
          <div><dt>Status</dt><dd><?php echo esc_html( $sa_project['status'] ); ?></dd></div>
          <div><dt>Rolle</dt><dd><?php echo esc_html( $sa_project['role'] ); ?></dd></div>
          <div><dt>Stack</dt><dd><?php echo esc_html( $sa_project['stack'] ); ?></dd></div>
          <div><dt>Stand</dt><dd><?php echo esc_html( $sa_project['state'] ); ?></dd></div>
          <?php if ( ! empty( $sa_project['link'] ) ) : ?>
            <div><dt>Live</dt><dd><a class="sa-textlink" href="<?php echo esc_url( $sa_project['link'] ); ?>"<?php echo $sa_link_ext ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $sa_project['link_display'] ); ?> <span aria-hidden="true">&rarr;</span></a></dd></div>
          <?php endif; ?>
        </dl>
      </aside>
    </div>

    <?php if ( $sa_gallery ) : ?>
      <div class="sa-pn__gallery sa-reveal">
        <?php foreach ( $sa_gallery as $sa_img ) : ?>
          <figure><img src="<?php echo esc_url( $sa_img ); ?>" alt="" loading="lazy" /></figure>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="sa-pn__foot sa-reveal">
      <a class="sa-textlink" href="<?php echo esc_url( $sa_home_base . 'work/' ); ?>"><span aria-hidden="true">&larr;</span> Zurück zu den Projekten</a>
      <a class="sa-textlink" href="<?php echo esc_url( $sa_home_base . 'about-me/' ); ?>">Über das Studio <span aria-hidden="true">&rarr;</span></a>
    </div>

  </div>
</main>

<?php get_template_part('parts/sa-footer'); ?>

<?php wp_footer(); ?>
</body>
</html>

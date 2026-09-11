<?php
/**
 * Studio Avelin — standalone homepage template.
 *
 * Deliberately does NOT call get_header() / get_footer(): the flat Studio Avelin
 * header and footer live directly below and the Twenty Twenty-Four block chrome
 * must not appear on the homepage.
 *
 * @package studio-avelin-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sa_home = trailingslashit( home_url( '/' ) );
$sa_uri  = get_stylesheet_directory_uri();

/** Leistungen — the four from the live site, with begleitung/beratung folded in. */
$sa_services = array(
	array(
		'title' => 'Individuelle Websites',
		'text'  => 'Individuelle, responsive Websites, die zur Arbeit, zur Zielgruppe und zum Alltag passen.',
	),
	array(
		'title' => 'Landingpages & Portfolios',
		'text'  => 'Kompakte Auftritte für Selbstständige, Dienstleistungen, Produkte und Launches.',
	),
	array(
		'title' => 'WordPress & redaktionelle Systeme',
		'text'  => 'Flexible Publishing-Systeme, mit denen Inhalte auch nach dem Launch einfach gepflegt werden können.',
	),
	array(
		'title' => 'Optimierung, Betreuung & Beratung',
		'text'  => 'Laufende Verbesserungen an Design, Performance und Bedienbarkeit – plus Beratung zu Inhalten, Sichtbarkeit und Marketing, wenn du sie brauchst.',
	),
);

/** Two featured projects. The full list lives on /work/. */
$sa_projects = array(
	array(
		'name'   => 'Hawaiimassage zu Hause',
		'full'   => 'Anja Krampe · Kelkheim',
		'status' => 'Live',
		'meta'   => 'Kundenprojekt · Website',
		'text'   => 'Eine ruhige, warme Website für mobile Wellnessmassagen zu Hause – klare Angebotsübersicht, viel Raum für Bild und Text.',
		'url'    => $sa_home . 'work/hawaiimassage/',
		'image'  => $sa_uri . '/assets/img/work/hawaiimassage/hero.jpg',
		'tint'   => 'warm',
	),
	array(
		'name'   => 'Portfolio Page',
		'full'   => 'MONROE Toyparty Landingpage',
		'status' => 'Live',
		'meta'   => 'Kundenprojekt · Landingpage',
		'text'   => 'Eine warme, zurückhaltende Portfolio- und Landingpage, die Angebot, Persönlichkeit und Kontakt stimmig zusammenbringt.',
		'url'    => $sa_home . 'work/monroe-toyparty-landingpage/',
		'image'  => $sa_uri . '/assets/img/work/monroe/hero.jpg',
		'tint'   => 'rose',
	),
);

$sa_journal_posts = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 3,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'no_found_rows'       => true,
		'ignore_sticky_posts' => true,
	)
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'sa-front' ); ?>>
<?php wp_body_open(); ?>

<a class="sa-skip" href="#work">Zum Inhalt springen</a>

<?php get_template_part( 'parts/sa-header' ); ?>

<main class="sa-main" id="sa-main">

	<!-- ============================ HERO ============================ -->
	<section class="sa-hero sa-hero--dark" id="top" aria-label="Einführung">
		<div class="sa-hero__canvas-wrap" aria-hidden="true">
			<canvas class="sa-hero__canvas" id="sa-hero-canvas"></canvas>
		</div>
		<span class="sa-hero__glow sa-hero__glow--a" aria-hidden="true"></span>
		<span class="sa-hero__glow sa-hero__glow--b" aria-hidden="true"></span>

		<div class="sa-hero__inner sa-shell">
			<div class="sa-hero__content">
				<div class="sa-hero__eyebrow-row">
					<span class="sa-hero__rule" aria-hidden="true"></span>
					<span class="sa-hero__eyebrow">Unabhängiges Webdesign, Entwicklung &amp; Marketing</span>
				</div>

				<p class="sa-hero__claim">DESIGN. <span>CODE.</span> CREATE.</p>

				<h1 class="sa-hero__title">
					<span class="sa-rw"><span>Websites mit Charakter.</span></span><br />
					<span class="sa-rw"><span>Gut gestaltet.</span></span><br />
					<span class="sa-rw"><span>Sauber umgesetzt.</span></span>
				</h1>

				<div class="sa-hero__foot">
					<p class="sa-hero__lead">
						Studio Avelin gestaltet und entwickelt individuelle Websites für Selbstständige und
						kleine Unternehmen – persönlich betreut, von der ersten Idee bis zur Sichtbarkeit.
					</p>
					<div class="sa-hero__actions">
						<a class="sa-btn sa-btn--lime" href="#work">
							<span>Projekte ansehen</span>
							<span class="sa-btn__arrow" aria-hidden="true">&rarr;</span>
						</a>
						<a class="sa-btn sa-btn--outline" href="<?php echo esc_url( $sa_home . 'contact/' ); ?>">
							<span>Projekt besprechen</span>
							<span class="sa-btn__arrow" aria-hidden="true">&rarr;</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ============================ LEISTUNGEN ============================ -->
	<section class="sa-section" id="services" aria-labelledby="sa-services-title">
		<div class="sa-shell">
			<span class="sa-sec-kicker sa-reveal">Leistungen</span>
			<h2 class="sa-sec-title sa-reveal" id="sa-services-title">Von der ersten Idee bis zur fertigen Website.</h2>
			<p class="sa-sec-intro sa-reveal">
				Konzept, Design und Entwicklung kommen aus einer Hand – mit direkter Abstimmung,
				persönlicher Betreuung und ohne wechselnde Ansprechpartner. Auf Wunsch begleite ich dich
				auch nach dem Launch: bei Optimierung, Inhalten und Sichtbarkeit.
			</p>

			<div class="sa-arc">
				<?php foreach ( $sa_services as $index => $service ) : ?>
					<div class="sa-arc__item sa-reveal">
						<span class="sa-arc__n"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<div>
							<h3 class="sa-arc__h"><?php echo esc_html( $service['title'] ); ?></h3>
							<p class="sa-arc__p"><?php echo esc_html( $service['text'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="sa-sec-foot sa-reveal">
				<a class="sa-textlink" href="<?php echo esc_url( $sa_home . 'services/' ); ?>">Leistungen entdecken <span aria-hidden="true">&rarr;</span></a>
			</div>
		</div>
	</section>

	<!-- ============================ PROJEKTE ============================ -->
	<section class="sa-section sa-section--tint" id="work" aria-labelledby="sa-work-title">
		<div class="sa-shell">
			<span class="sa-sec-kicker sa-reveal">Projekte</span>
			<h2 class="sa-sec-title sa-reveal" id="sa-work-title">Ausgewählte Projekte</h2>
			<p class="sa-sec-intro sa-reveal">
				Kundenprojekte und eigene Produkte, die Gestaltung und technische Umsetzung zusammenbringen.
			</p>

			<div class="sa-feat">
				<?php foreach ( $sa_projects as $index => $project ) : ?>
					<a class="sa-feat__item sa-reveal" href="<?php echo esc_url( $project['url'] ); ?>">
						<div class="sa-feat__visual sa-feat__visual--<?php echo esc_attr( $project['tint'] ); ?>">
							<?php if ( $project['image'] ) : ?>
								<img src="<?php echo esc_url( $project['image'] ); ?>" alt="" loading="lazy" />
							<?php else : ?>
								<span class="sa-feat__chrome" aria-hidden="true"><span></span><span></span><span></span></span>
								<span class="sa-feat__ph" aria-hidden="true"><?php echo esc_html( $project['name'] ); ?></span>
							<?php endif; ?>
						</div>
						<div class="sa-feat__body">
							<span class="sa-feat__index"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
							<span class="sa-feat__meta"><?php echo esc_html( $project['meta'] ); ?><span class="sa-feat__meta-status"><?php echo esc_html( $project['status'] ); ?></span></span>
							<h3 class="sa-feat__name"><?php echo esc_html( $project['name'] ); ?></h3>
							<span class="sa-feat__full"><?php echo esc_html( $project['full'] ); ?></span>
							<p class="sa-feat__desc"><?php echo esc_html( $project['text'] ); ?></p>
							<span class="sa-feat__link">Projekt ansehen <span aria-hidden="true">&rarr;</span></span>
						</div>
					</a>
				<?php endforeach; ?>
			</div>

			<div class="sa-sec-foot sa-reveal">
				<a class="sa-textlink" href="<?php echo esc_url( $sa_home . 'work/' ); ?>">Alle Projekte <span aria-hidden="true">&rarr;</span></a>
			</div>
		</div>
	</section>

	<!-- ============================ ÜBER MICH ============================ -->
	<section class="sa-section" id="about" aria-labelledby="sa-about-title">
		<div class="sa-shell">
			<div class="sa-about2">
				<div class="sa-about2__mark sa-reveal" aria-hidden="true">
					<span class="sa-about2__logo">A<span>/</span></span>
					<span class="sa-about2__name">Studio Avelin</span>
				</div>
				<div class="sa-about2__body sa-reveal d1">
					<span class="sa-sec-kicker">Über mich</span>
					<h2 class="sa-about2__h" id="sa-about-title">
						Ich bin Michael, Designer und Entwickler hinter Studio Avelin. Ich verbinde
						Gestaltung und Technik zu Websites und digitalen Produkten, die im Alltag funktionieren.
					</h2>
					<p class="sa-about2__p">
						Keine Agentur mit vielen Zwischenstationen, sondern ein direkter Ansprechpartner –
						von der ersten Idee über Design und Umsetzung bis zur Betreuung nach dem Launch.
					</p>
					<a class="sa-textlink" href="<?php echo esc_url( $sa_home . 'about-me/' ); ?>">Mehr über mich <span aria-hidden="true">&rarr;</span></a>
				</div>
			</div>
		</div>
	</section>

	<!-- ============================ JOURNAL ============================ -->
	<?php if ( $sa_journal_posts->have_posts() ) : ?>
	<section class="sa-section sa-section--tint" id="journal" aria-labelledby="sa-journal-title">
		<div class="sa-shell">
			<span class="sa-sec-kicker sa-reveal">Notizen &amp; Texte</span>
			<h2 class="sa-sec-title sa-reveal" id="sa-journal-title">Journal</h2>
			<p class="sa-sec-intro sa-reveal">Notizen aus Design, Entwicklung und dem Studioalltag – und aus dem, was daneben passiert.</p>

			<div class="sa-jrn">
				<?php while ( $sa_journal_posts->have_posts() ) : ?>
					<?php
					$sa_journal_posts->the_post();
					$sa_terms    = get_the_terms( get_the_ID(), 'category' );
					$sa_category  = ( $sa_terms && ! is_wp_error( $sa_terms ) ) ? $sa_terms[0]->name : 'Journal';
					$sa_excerpt  = get_the_excerpt();
					?>
					<a class="sa-jrn__item sa-reveal" href="<?php the_permalink(); ?>">
						<span class="sa-jrn__cat"><?php echo esc_html( $sa_category ); ?></span>
						<span class="sa-jrn__t"><?php the_title(); ?></span>
						<?php if ( $sa_excerpt ) : ?>
							<span class="sa-jrn__d"><?php echo esc_html( wp_trim_words( $sa_excerpt, 20, '…' ) ); ?></span>
						<?php endif; ?>
						<span class="sa-jrn__date"><?php echo esc_html( get_the_date() ); ?></span>
					</a>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>

			<div class="sa-sec-foot sa-reveal">
				<a class="sa-textlink" href="<?php echo esc_url( sa_journal_archive_url() ); ?>">Alle Notizen <span aria-hidden="true">&rarr;</span></a>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- ============================ PROJEKT STARTEN ============================ -->
	<section class="sa-section sa-section--dark sa-closing" id="contact" aria-labelledby="sa-closing-title">
		<div class="sa-shell">
			<span class="sa-sec-kicker sa-reveal">Projekt besprechen</span>
			<h2 class="sa-closing__h sa-reveal" id="sa-closing-title">Du hast eine Website im Kopf?</h2>
			<p class="sa-closing__p sa-reveal">
				Erzähl mir, woran du arbeitest, was die Website leisten soll und wo du im Prozess stehst.
				Eine grobe Skizze reicht für den Anfang.
			</p>

			<ul class="sa-closing__brief sa-reveal">
				<li><span>01</span>Deine Idee oder bestehende Website</li>
				<li><span>02</span>Der gewünschte Umfang</li>
				<li><span>03</span>Dein gewünschter Zeitrahmen</li>
			</ul>

			<a class="sa-btn sa-btn--light sa-reveal" href="<?php echo esc_url( $sa_home . 'contact/' ); ?>">
				Projekt besprechen <span class="sa-btn__arrow" aria-hidden="true">&rarr;</span>
			</a>

			<div class="sa-closing__social sa-reveal">
				<a href="https://www.instagram.com/studio_avelin" target="_blank" rel="noopener noreferrer">Instagram</a>
				<a href="https://github.com/studio-avelin" target="_blank" rel="noopener noreferrer">GitHub</a>
			</div>
		</div>
	</section>

</main>

<?php get_template_part( 'parts/sa-footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>

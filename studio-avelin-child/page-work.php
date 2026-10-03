<?php
/**
 * Studio Avelin — Projekte.
 *
 * Kundenprojekte und, klar davon getrennt, eigene digitale Produkte.
 * Jedes Projekt bekommt einen großen, halbseitigen Block.
 *
 * @package studio-avelin-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sa_home = trailingslashit( home_url( '/' ) );
$sa_uri  = get_stylesheet_directory_uri();

$sa_clients = array(
	array(
		'name'   => 'Hawaiimassage zu Hause',
		'full'   => 'Mobile Wellnessmassage · Kelkheim',
		'meta'   => 'Kundenprojekt · Website',
		'status' => 'Live',
		'text'   => 'Eine ruhige, warme Website für mobile Wellnessmassagen zu Hause. Klare Angebotsübersicht, viel Raum für Bild und Text, ein einfacher Weg zur Terminanfrage.',
		'url'    => $sa_home . 'work/hawaiimassage/',
		'image'  => $sa_uri . '/assets/img/work/hawaiimassage/hero.jpg',
		'tint'   => 'warm',
	),
	array(
		'name'   => 'Portfolio Page',
		'full'   => 'MONROE Toyparty Landingpage',
		'meta'   => 'Kundenprojekt · Landingpage',
		'status' => 'Live',
		'text'   => 'Eine warme, diskrete Portfolio- und Landingpage für eine selbstständige MONROE-Beraterin – stilvoll, einladend und mit einem einfachen Weg zum Kontakt.',
		'url'    => $sa_home . 'work/monroe-toyparty-landingpage/',
		'image'  => $sa_uri . '/assets/img/work/monroe/hero.jpg',
		'tint'   => 'rose',
	),
	array(
		'name'   => 'Bäckerei Curfs',
		'full'   => 'Handwerksbäckerei',
		'meta'   => 'Kundenprojekt · Website',
		'status' => 'Live',
		'text'   => 'Ein stilvoller digitaler Auftritt für eine kleine, handwerkliche Bäckerei – reduziert, ästhetikgetrieben und einfach zu pflegen.',
		'url'    => $sa_home . 'work/baeckerei-curfs/',
		'image'  => $sa_uri . '/assets/img/work/baeckerei-curfs/hero.jpg',
		'tint'   => 'warm',
	),
);

$sa_products = array(
	array(
		'name'   => 'STAN',
		'full'   => 'Studio Avelin Notes',
		'meta'   => 'Eigenes Produkt · App',
		'status' => 'Live-MVP',
		'text'   => 'Eine ruhige Notiz- und Denk-App, die Ideen, Bereiche, Notizen und Tags an einem Ort zusammenhält – reduziert, schnell und für den Alltag gemacht.',
		'url'    => $sa_home . 'work/stan/',
		'image'  => '',
		'tint'   => 'cool',
	),
	array(
		'name'   => 'StAT',
		'full'   => 'Studio Avelin Training',
		'meta'   => 'Eigenes Produkt · App',
		'status' => 'In Entwicklung',
		'text'   => 'Ein privates Trainingstagebuch für Laufen, Krafttraining, Ziele, Strecken und Fortschritte – Daten, die wirklich helfen, ohne endlose Fitnessmetriken.',
		'url'    => $sa_home . 'work/stat/',
		'image'  => '',
		'tint'   => 'warm',
	),
	array(
		'name'   => 'StAU',
		'full'   => 'Studio Avelin Travel Planner',
		'meta'   => 'Eigenes Produkt · App',
		'status' => 'Live',
		'text'   => 'Eine ruhige App für Reiseplanung und Reisetagebuch, die Ideen, Routen und Erinnerungen an einem Ort sammelt – von der ersten gespeicherten Idee bis zum Rückblick.',
		'url'    => $sa_home . 'work/stau/',
		'image'  => '',
		'tint'   => 'rose',
	),
);

/**
 * Render one big project block.
 *
 * @param array $p       Project data.
 * @param int   $number  1-based index within its group.
 * @param string $cta    Link label.
 */
function sa_work_block( $p, $number, $cta ) {
	?>
	<a class="sa-feat__item sa-reveal" href="<?php echo esc_url( $p['url'] ); ?>">
		<div class="sa-feat__visual sa-feat__visual--<?php echo esc_attr( $p['tint'] ); ?>">
			<?php if ( ! empty( $p['image'] ) ) : ?>
				<img src="<?php echo esc_url( $p['image'] ); ?>" alt="" loading="lazy" />
			<?php else : ?>
				<span class="sa-feat__chrome" aria-hidden="true"><span></span><span></span><span></span></span>
				<span class="sa-feat__ph" aria-hidden="true"><?php echo esc_html( $p['name'] ); ?></span>
			<?php endif; ?>
		</div>
		<div class="sa-feat__body">
			<span class="sa-feat__index"><?php echo esc_html( str_pad( (string) $number, 2, '0', STR_PAD_LEFT ) ); ?></span>
			<span class="sa-feat__meta"><?php echo esc_html( $p['meta'] ); ?><span class="sa-feat__meta-status"><?php echo esc_html( $p['status'] ); ?></span></span>
			<h3 class="sa-feat__name"><?php echo esc_html( $p['name'] ); ?></h3>
			<span class="sa-feat__full"><?php echo esc_html( $p['full'] ); ?></span>
			<p class="sa-feat__desc"><?php echo esc_html( $p['text'] ); ?></p>
			<span class="sa-feat__link"><?php echo esc_html( $cta ); ?> <span aria-hidden="true">&rarr;</span></span>
		</div>
	</a>
	<?php
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class( array( 'home', 'sa-front', 'sa-page', 'sa-page--work' ) ); ?>>
<?php wp_body_open(); ?>

<a class="sa-skip" href="#sa-main">Zum Inhalt springen</a>

<?php get_template_part( 'parts/sa-header' ); ?>

<main class="sa-main" id="sa-main">
	<div class="sa-shell">

		<section class="sa-workpage-hero sa-reveal">
			<span class="sa-sec-kicker">Projekte</span>
			<h1 class="sa-workpage-hero__h">
				<?php echo wp_kses_post( 'Für <span class="sa-lime-text">echte Aufgaben</span> gestaltet.' ); ?>
			</h1>
			<p class="sa-workpage-hero__p">
				Eine Auswahl aus Kundenprojekten und eigenen digitalen Produkten. Überschaubar im
				Umfang, durchdacht in der Umsetzung, gemacht für den Alltag.
			</p>
		</section>

		<section class="sa-section" aria-labelledby="sa-work-clients-title">
			<span class="sa-sec-kicker sa-reveal">Kundenprojekte</span>
			<h2 class="sa-sec-title sa-reveal" id="sa-work-clients-title">Arbeiten mit kleinen, inhabergeführten Marken.</h2>
			<div class="sa-feat">
				<?php foreach ( $sa_clients as $i => $project ) : ?>
					<?php sa_work_block( $project, $i + 1, 'Projekt ansehen' ); ?>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="sa-section" aria-labelledby="sa-work-products-title">
			<span class="sa-sec-kicker sa-reveal">Eigene Produkte</span>
			<h2 class="sa-sec-title sa-reveal" id="sa-work-products-title">Design-Beispiele aus dem eigenen Studio.</h2>
			<p class="sa-sec-intro sa-reveal">
				Kleine digitale Produkte, an denen ich Gestaltung und Umsetzung ausprobiere – keine
				Produktlinie, sondern Beispiele für die Arbeitsweise.
			</p>
			<div class="sa-feat">
				<?php foreach ( $sa_products as $i => $project ) : ?>
					<?php sa_work_block( $project, $i + 1, 'Projektnotiz lesen' ); ?>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="sa-section sa-workpage-cta sa-reveal">
			<span class="sa-sec-kicker">Sag hallo</span>
			<h2 class="sa-workpage-cta__h">Du hast etwas im Kopf?</h2>
			<p class="sa-workpage-cta__p">Lass uns sprechen, ob und wie ich dich begleiten kann.</p>
			<div class="sa-workpage-cta__actions">
				<a class="sa-btn sa-btn--lime" href="<?php echo esc_url( $sa_home . 'contact/' ); ?>">
					Projekt besprechen <span class="sa-btn__arrow" aria-hidden="true">&rarr;</span>
				</a>
				<a class="sa-textlink" href="<?php echo esc_url( $sa_home . 'services/' ); ?>">Leistungen entdecken <span aria-hidden="true">&rarr;</span></a>
			</div>
		</section>

	</div>
</main>

<?php get_template_part( 'parts/sa-footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>

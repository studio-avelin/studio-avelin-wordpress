<?php
/**
 * Studio Avelin — Leistungen.
 *
 * @package studio-avelin-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sa_home = trailingslashit( home_url( '/' ) );

$sa_offers = array(
	array(
		'title'    => 'Individuelle Websites',
		'text'     => 'Eine vollständige Website, abgestimmt auf deine Arbeit, deine Zielgruppe und deine Ziele. Struktur und Gestaltung entstehen passend zum Projekt.',
		'included' => array( 'Struktur und inhaltliche Richtung', 'Visuelles Design und responsive Layouts', 'Frontend-Entwicklung und Launch' ),
	),
	array(
		'title'    => 'Landingpages & Portfolios',
		'text'     => 'Ein kompakter digitaler Auftritt für eine Person, eine Dienstleistung, ein Produkt oder einen Launch – leicht verständlich und mit eigenständigem Charakter.',
		'included' => array( 'Klare Seitenführung und Botschaft', 'Individuelle visuelle Richtung', 'Ein einfacher Weg zur Kontaktaufnahme' ),
	),
	array(
		'title'    => 'WordPress & redaktionelle Systeme',
		'text'     => 'Individuelle WordPress-Systeme für Websites, Journals und wachsende Inhalte – so aufgebaut, dass sie auch nach dem Launch einfach zu bedienen bleiben.',
		'included' => array( 'Individuelle WordPress-Umsetzung', 'Sinnvolle Inhaltsstrukturen', 'Einfache Pflege und Übergabe' ),
	),
	array(
		'title'    => 'Optimierung, Betreuung & Beratung',
		'text'     => 'Gezielte Verbesserungen für bestehende Websites – und auf Wunsch laufende Betreuung: Beratung zu Inhalten, Sichtbarkeit und Marketing.',
		'included' => array( 'Design, Abstände und Performance verfeinern', 'Beratung zu Inhalten, SEO und Sichtbarkeit', 'Persönliche Betreuung, auch nach dem Launch' ),
	),
);

$sa_process = array(
	array( 'Verstehen', 'Deine Arbeit, Zielgruppe, Ziele und den tatsächlichen Umfang des Projekts.' ),
	array( 'Strukturieren', 'Inhalte, Hierarchie und einen klaren Weg durch die Website.' ),
	array( 'Gestalten & entwickeln', 'Design und technische Umsetzung entstehen gemeinsam statt nacheinander.' ),
	array( 'Verfeinern & veröffentlichen', 'Details, mobile Darstellung und Performance werden geprüft und alles sauber übergeben.' ),
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class( array( 'sa-front', 'sa-page', 'sa-page--services' ) ); ?>>
<?php wp_body_open(); ?>

<a class="sa-skip" href="#sa-main">Zum Inhalt springen</a>

<?php get_template_part( 'parts/sa-header' ); ?>

<main class="sa-main" id="sa-main">
	<div class="sa-shell">

		<section class="sa-phero sa-reveal">
			<span class="sa-sec-kicker">Leistungen</span>
			<h1 class="sa-phero__h"><?php echo wp_kses_post( 'Websites, die <span class="sa-lime-text">gut aussehen</span> und gut funktionieren.' ); ?></h1>
			<p class="sa-phero__lede">
				Studio Avelin gestaltet und entwickelt individuelle Websites für Selbstständige und kleine
				Unternehmen. Konzept, Design und Entwicklung kommen aus einer Hand – persönlich betreut,
				vom ersten Gespräch bis zum Launch und, auf Wunsch, darüber hinaus.
			</p>
		</section>

		<section class="sa-section" aria-labelledby="sa-svc-title">
			<span class="sa-sec-kicker sa-reveal">Wobei ich helfen kann</span>
			<h2 class="sa-sec-title sa-reveal" id="sa-svc-title">Die passende Website für deine Arbeit.</h2>

			<div class="sa-arc">
				<?php foreach ( $sa_offers as $index => $offer ) : ?>
					<div class="sa-arc__item sa-reveal">
						<span class="sa-arc__n sa-slash" aria-hidden="true">/</span>
						<div>
							<h3 class="sa-arc__h"><?php echo esc_html( $offer['title'] ); ?></h3>
							<p class="sa-arc__p"><?php echo esc_html( $offer['text'] ); ?></p>
							<ul class="sa-arc__details">
								<?php foreach ( $offer['included'] as $item ) : ?>
									<li><?php echo esc_html( $item ); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="sa-section" aria-labelledby="sa-proc-title">
			<span class="sa-sec-kicker sa-reveal">Der Prozess</span>
			<h2 class="sa-sec-title sa-reveal" id="sa-proc-title">Ein klarer Weg zur fertigen Website.</h2>
			<p class="sa-sec-intro sa-reveal">
				Du arbeitest vom Anfang bis zum Ende direkt mit mir. Gemeinsam klären wir die Anforderungen,
				treffen die wichtigen Entscheidungen und bringen die Website Schritt für Schritt zum Launch.
			</p>
			<ol class="sa-steps sa-reveal">
				<?php foreach ( $sa_process as $index => $step ) : ?>
					<li>
						<span><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<strong><?php echo esc_html( $step[0] ); ?></strong>
						<p><?php echo esc_html( $step[1] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</section>

		<section class="sa-section" aria-labelledby="sa-fit-title">
			<div class="sa-split">
				<div class="sa-reveal">
					<span class="sa-sec-kicker">Gute Zusammenarbeit</span>
					<h2 class="sa-sec-title" id="sa-fit-title">Persönlich, ohne unnötige Umwege.</h2>
				</div>
				<div class="sa-reveal d1">
					<p class="sa-sec-intro" style="margin-top:0;max-width:46ch">
						Diese Arbeitsweise passt gut, wenn dir verlässliche Abstimmung, gutes Design und der
						direkte Kontakt zur umsetzenden Person wichtig sind.
					</p>
					<ul class="sa-checklist">
						<li>Du brauchst eine neue Website mit klarem Zweck.</li>
						<li>Design und Entwicklung sollen zusammengehören.</li>
						<li>Du bevorzugst eine enge, praktische Zusammenarbeit.</li>
						<li>Details sind dir wichtig, ohne den Prozess kompliziert zu machen.</li>
					</ul>
				</div>
			</div>
		</section>

	</div>

	<section class="sa-section sa-section--dark sa-ctaband sa-reveal">
		<div class="sa-shell">
			<span class="sa-sec-kicker">Projekt besprechen</span>
			<h2 class="sa-ctaband__h">Du hast etwas im Kopf?</h2>
			<p class="sa-ctaband__p">Erzähl mir, woran du arbeitest, was die Website leisten soll und wo du gerade stehst.</p>
			<a class="sa-btn sa-btn--lime" href="<?php echo esc_url( $sa_home . 'contact/' ); ?>">
				Projekt besprechen <span class="sa-btn__arrow" aria-hidden="true">&rarr;</span>
			</a>
		</div>
	</section>
</main>

<?php get_template_part( 'parts/sa-footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>

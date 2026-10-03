<?php
/**
 * Studio Avelin — Über mich.
 *
 * @package studio-avelin-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sa_home = trailingslashit( home_url( '/' ) );

$sa_values = array(
	array( 'Design + Entwicklung', 'kommen aus einer Hand, nicht nacheinander' ),
	array( 'Ein Ansprechpartner', 'kein anonymer Prozess, keine Zwischenstationen' ),
	array( 'Fokussierung', 'ein Gespür fürs Wesentliche, im Design wie im Alltag' ),
	array( 'Für den Alltag gemacht', 'durchdacht statt dekorativ, auf Dauer angelegt' ),
);

$sa_skills = array(
	'Design'     => array( 'Visuelle Identität', 'Interface-Design', 'Typografie', 'Designsysteme' ),
	'Umsetzung'  => array( 'Individuelle Websites', 'Landingpages & Portfolios', 'Frontend-Entwicklung', 'WordPress' ),
	'Sichtbarkeit' => array( 'Technisches SEO', 'Content-Empfehlungen', 'Performance-Review', 'Beratung zu Marketing' ),
);

$sa_available = array(
	'Website- und Landingpage-Projekte',
	'WordPress- und redaktionelle Systeme',
	'Optimierung bestehender Websites',
	'Laufende Betreuung und Beratung',
);

$sa_facts = array(
	'Zusammenarbeit'           => 'ortsunabhängig, komplett digital',
	'Arbeitsweise'             => 'direkt & persönlich',
	'Abseits vom Schreibtisch' => 'Laufen, Reisen, Lesen',
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class( array( 'sa-front', 'sa-page', 'sa-page--about' ) ); ?>>
<?php wp_body_open(); ?>

<a class="sa-skip" href="#sa-main">Zum Inhalt springen</a>

<?php get_template_part( 'parts/sa-header' ); ?>

<main class="sa-main" id="sa-main">
	<div class="sa-shell">

		<section class="sa-phero sa-reveal">
			<span class="sa-sec-kicker">Über mich</span>
			<h1 class="sa-phero__h">Ich bin <span class="sa-lime-text">Michael</span>, Designer und Entwickler hinter Studio Avelin.</h1>
			<p class="sa-phero__lede">
				Ich verbinde Gestaltung und Technik zu Websites und digitalen Produkten, die im Alltag
				funktionieren. Keine Agentur mit vielen Zwischenstationen, sondern ein direkter
				Ansprechpartner – von der ersten Idee über Design und Umsetzung bis zur Betreuung nach dem Launch.
			</p>
			<p class="sa-phero__lede">
				Fokussierung und ein Gespür fürs Wesentliche ziehen sich durch alles, was ich tue – auch
				abseits der Arbeit, ob beim Laufen, auf Reisen oder beim Lesen. Mehr davon im
				<a class="sa-lime-text" href="<?php echo esc_url( $sa_home . 'journal/' ); ?>">Journal</a>.
			</p>
		</section>

		<section class="sa-section sa-afig sa-reveal" aria-labelledby="sa-about-figure-title">
			<div class="sa-afig__panel">
				<figure class="sa-afig__media">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/about/michael.jpg' ); ?>" alt="Michael, Gründer von Studio Avelin" loading="lazy" width="1014" height="1200" />
				</figure>
				<div class="sa-afig__text">
					<span class="sa-sec-kicker">Wer dahintersteht</span>
					<p class="sa-afig__quote" id="sa-about-figure-title">„Kein Team, kein Umweg. Von der ersten Idee bis zum Launch arbeitest du direkt mit mir.“</p>
					<dl class="sa-afig__facts">
						<?php foreach ( $sa_facts as $label => $value ) : ?>
							<div>
								<dt><?php echo esc_html( $label ); ?></dt>
								<dd><?php echo esc_html( $value ); ?></dd>
							</div>
						<?php endforeach; ?>
					</dl>
				</div>
			</div>
		</section>

		<section class="sa-section" aria-labelledby="sa-about-work-title">
			<span class="sa-sec-kicker sa-reveal">Wie ich arbeite</span>
			<h2 class="sa-sec-title sa-reveal" id="sa-about-work-title">Direkt, fokussiert, für den Alltag gemacht.</h2>
			<div class="sa-arc">
				<?php foreach ( $sa_values as $index => $v ) : ?>
					<div class="sa-arc__item sa-reveal">
						<span class="sa-arc__n sa-slash" aria-hidden="true">/</span>
						<div>
							<h3 class="sa-arc__h"><?php echo esc_html( $v[0] ); ?></h3>
							<p class="sa-arc__p"><?php echo esc_html( $v[1] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="sa-section" aria-labelledby="sa-about-skills-title">
			<span class="sa-sec-kicker sa-reveal">Was ich mache</span>
			<h2 class="sa-sec-title sa-reveal" id="sa-about-skills-title">Drei Bereiche, ein Prozess.</h2>
			<div class="sa-skillgrid sa-reveal">
				<?php foreach ( $sa_skills as $group => $items ) : ?>
					<div class="sa-skillgrid__col">
						<h3><?php echo esc_html( $group ); ?></h3>
						<ul>
							<?php foreach ( $items as $item ) : ?>
								<li><?php echo esc_html( $item ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="sa-section" aria-labelledby="sa-about-available-title">
			<div class="sa-split">
				<div class="sa-reveal">
					<span class="sa-sec-kicker">Zusammenarbeit</span>
					<h2 class="sa-sec-title" id="sa-about-available-title">Neue Projekte entstehen auf Anfrage.</h2>
				</div>
				<div class="sa-reveal d1">
					<p class="sa-sec-intro" style="margin-top:0;max-width:46ch">
						Ich arbeite an wenigen Projekten gleichzeitig und sehe mir jede Anfrage
						persönlich an. Eine Antwort bekommst du auf jeden Fall – und wenn es
						zeitlich und inhaltlich passt, mit einem konkreten nächsten Schritt.
					</p>
					<ul class="sa-checklist">
						<?php foreach ( $sa_available as $item ) : ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</section>

	</div>

	<section class="sa-section sa-section--dark sa-ctaband sa-reveal">
		<div class="sa-shell">
			<span class="sa-sec-kicker">Projekt besprechen</span>
			<h2 class="sa-ctaband__h">Klingt nach einer Zusammenarbeit?</h2>
			<p class="sa-ctaband__p">Erzähl mir, woran du arbeitest und was die Website leisten soll. Eine grobe Skizze reicht.</p>
			<a class="sa-btn sa-btn--lime" href="<?php echo esc_url( $sa_home . 'contact/' ); ?>">
				Projekt besprechen <span class="sa-btn__arrow" aria-hidden="true">&rarr;</span>
			</a>
			<div class="sa-ctaband__links">
				<a class="sa-textlink" href="<?php echo esc_url( $sa_home . 'work/' ); ?>">Projekte ansehen <span aria-hidden="true">&rarr;</span></a>
				<a class="sa-textlink" href="<?php echo esc_url( $sa_home . 'services/' ); ?>">Leistungen entdecken <span aria-hidden="true">&rarr;</span></a>
			</div>
		</div>
	</section>
</main>

<?php get_template_part( 'parts/sa-footer' ); ?>

<?php wp_footer(); ?>
</body>
</html>

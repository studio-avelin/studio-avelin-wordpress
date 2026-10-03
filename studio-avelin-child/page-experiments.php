<?php
/**
 * Studio Avelin — Experiments page template.
 *
 * Visual laboratory, sketchbook and archive of creative coding experiments.
 *
 * @package studio-avelin-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sa_home = trailingslashit( home_url( '/' ) );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class( array( 'home', 'sa-front', 'sa-page', 'sa-page--experiments' ) ); ?>>
<?php wp_body_open(); ?>

<a class="sa-skip" href="#sa-main">Skip to content</a>

<?php get_template_part( 'parts/sa-header' ); ?>

<!-- ========================= MAIN CONTENT ========================= -->
<main class="sa-main" id="sa-main">
	<div class="sa-about-container">

		<!-- HERO SECTION -->
		<section class="sa-exp-hero">
			<div class="sa-exp-hero__left">
				<span class="sa-about-eyebrow">EXPERIMENTS</span>

				<h1 class="sa-about-hero-headline">
					ideas in <span class="sa-lime-text">progress</span>.
				</h1>

				<div class="sa-about-intro" style="max-width: 620px;">
					<p>
						A playground for experiments, side projects and early ideas.<br />
						Nothing here is final. Everything is a test, a learning, a step forward.
					</p>
					<p>
						Concepts, code, visuals &mdash; works in progress.
					</p>
				</div>
			</div>

			<div class="sa-exp-hero__right">
				<div class="sa-exp-hero-note">
					<span class="sa-exp-lime-line" aria-hidden="true"></span>
					<p class="sa-exp-hero-note__text">
						Exploring the intersection of<br />
						design, code and curiosity.
					</p>
					<p class="sa-exp-hero-note__sub">
						Building. Testing. Learning.
					</p>
				</div>
			</div>
		</section>

		<!-- FILTER / CATEGORY CONTROL -->
		<section class="sa-exp-filters-wrapper">
			<div class="sa-exp-filters" role="tablist" aria-label="Filter experiments">
				<button class="sa-exp-filter-btn is-active" type="button" data-filter="all">ALL</button>
				<button class="sa-exp-filter-btn" type="button" data-filter="code">CODE</button>
				<button class="sa-exp-filter-btn" type="button" data-filter="design">DESIGN</button>
				<button class="sa-exp-filter-btn" type="button" data-filter="interaction">INTERACTION</button>
				<button class="sa-exp-filter-btn" type="button" data-filter="visuals">VISUALS</button>
			</div>
		</section>

		<!-- EXPERIMENT GRID -->
		<section class="sa-exp-grid-section">
			<div class="sa-exp-grid">

				<!-- EXPERIMENT 01 -->
				<article class="sa-exp-card" data-tags="code typography motion interaction all">
					<a class="sa-exp-card__link" href="<?php echo esc_url( $sa_home . 'experiments/matrix/' ); ?>">
						<div class="sa-exp-card__preview">
							<canvas id="sa-canvas-matrix" class="sa-exp-canvas"></canvas>
						</div>
						<div class="sa-exp-card__body">
							<div class="sa-exp-card__head">
								<span class="sa-exp-card__num sa-slash" aria-hidden="true">/</span>
								<span class="sa-exp-card__eyebrow">GENERATIVE TYPE GRID</span>
							</div>
							<h2 class="sa-exp-card__title">Matrix</h2>
							<p class="sa-exp-card__desc">
								A shifting field of characters, noise and movement. A small browser experiment exploring rhythm, density and controlled randomness.
							</p>
							<div class="sa-exp-card__foot">
								<span class="sa-exp-card__meta">CODE &middot; TYPOGRAPHY &middot; MOTION</span>
								<span class="sa-exp-card__cta">Open experiment <span class="sa-exp-arrow">&rarr;</span></span>
							</div>
						</div>
					</a>
				</article>

				<!-- EXPERIMENT 02 -->
				<article class="sa-exp-card" data-tags="code canvas interaction visuals all">
					<a class="sa-exp-card__link" href="<?php echo esc_url( $sa_home . 'experiments/avelin-signal-grid/' ); ?>">
						<div class="sa-exp-card__preview">
							<canvas id="sa-canvas-signal" class="sa-exp-canvas"></canvas>
						</div>
						<div class="sa-exp-card__body">
							<div class="sa-exp-card__head">
								<span class="sa-exp-card__num sa-slash" aria-hidden="true">/</span>
								<span class="sa-exp-card__eyebrow">CANVAS STUDY</span>
							</div>
							<h2 class="sa-exp-card__title">Avelin Signal Grid</h2>
							<p class="sa-exp-card__desc">
								Signals travelling across a fine digital grid. A study in small rules, interaction and quiet interference patterns.
							</p>
							<div class="sa-exp-card__foot">
								<span class="sa-exp-card__meta">CODE &middot; CANVAS &middot; INTERACTION</span>
								<span class="sa-exp-card__cta">Open experiment <span class="sa-exp-arrow">&rarr;</span></span>
							</div>
						</div>
					</a>
				</article>

				<!-- EXPERIMENT 03 -->
				<article class="sa-exp-card" data-tags="design typography tool visuals all">
					<a class="sa-exp-card__link" href="<?php echo esc_url( $sa_home . 'experiments/poster-generator/' ); ?>">
						<div class="sa-exp-card__preview">
							<canvas id="sa-canvas-poster" class="sa-exp-canvas"></canvas>
						</div>
						<div class="sa-exp-card__body">
							<div class="sa-exp-card__head">
								<span class="sa-exp-card__num sa-slash" aria-hidden="true">/</span>
								<span class="sa-exp-card__eyebrow">DESIGN TOOL</span>
							</div>
							<h2 class="sa-exp-card__title">Poster Generator</h2>
							<p class="sa-exp-card__desc">
								A small tool for generating editorial posters using typography, spacing and a single accent colour. Controlled randomness turns a few simple rules into constantly changing compositions.
							</p>
							<div class="sa-exp-card__foot">
								<span class="sa-exp-card__meta">DESIGN &middot; TYPOGRAPHY &middot; TOOL</span>
								<span class="sa-exp-card__cta">Open experiment <span class="sa-exp-arrow">&rarr;</span></span>
							</div>
						</div>
					</a>
				</article>

				<!-- EXPERIMENT 04 (FUTURE ARCHIVE PLACEHOLDER) -->
				<article class="sa-exp-card sa-exp-card--disabled" data-tags="all">
					<div class="sa-exp-card__inner">
						<div class="sa-exp-card__preview sa-exp-card__preview--placeholder" aria-hidden="true">
							<div class="sa-exp-cursor-anim">
								<span class="sa-exp-cursor-dot"></span>
								<span class="sa-exp-cursor-text">LAB_READY //</span>
							</div>
						</div>
						<div class="sa-exp-card__body">
							<div class="sa-exp-card__head">
								<span class="sa-exp-card__num sa-slash" aria-hidden="true">/</span>
								<span class="sa-exp-card__eyebrow">IN PROGRESS</span>
							</div>
							<h2 class="sa-exp-card__title">Future Experiments</h2>
							<p class="sa-exp-card__desc">
								Small ideas usually start here. Some become projects. Some remain experiments. Both are useful.
							</p>
							<div class="sa-exp-card__foot">
								<span class="sa-exp-card__badge">IN PROGRESS</span>
							</div>
						</div>
					</div>
				</article>

			</div>
		</section>

		<!-- THE PROCESS STATEMENT SECTION -->
		<section class="sa-exp-process-section">
			<span class="sa-about-eyebrow">THE PROCESS</span>

			<h2 class="sa-exp-process-headline">
				<span class="sa-proc-word">build</span>.
				<span class="sa-proc-word">break</span>.
				<span class="sa-proc-word sa-lime-text">learn</span>.
				<span class="sa-proc-word">repeat</span>.
			</h2>

			<p class="sa-exp-process-desc">
				Experiments are not unfinished projects.<br />
				They are a way to understand ideas by making them real.
			</p>
		</section>

	</div>
</main>

<?php get_template_part( 'parts/sa-footer' ); ?>

<!-- CLIENT-SIDE FILTER & INTERACTIVE CANVASES -->
<script>
document.addEventListener('DOMContentLoaded', function() {
	// Filter logic
	const filterBtns = document.querySelectorAll('.sa-exp-filter-btn');
	const cards = document.querySelectorAll('.sa-exp-card');

	filterBtns.forEach(btn => {
		btn.addEventListener('click', function() {
			filterBtns.forEach(b => b.classList.remove('is-active'));
			this.classList.add('is-active');

			const filter = this.getAttribute('data-filter');

			cards.forEach(card => {
				const tags = card.getAttribute('data-tags') || '';
				if (filter === 'all' || tags.includes(filter)) {
					card.style.display = 'block';
				} else {
					card.style.display = 'none';
				}
			});
		});
	});

	// Canvas 01: Matrix
	const matrixCanvas = document.getElementById('sa-canvas-matrix');
	if (matrixCanvas) {
		const ctx = matrixCanvas.getContext('2d');
		function resizeMatrix() {
			matrixCanvas.width = matrixCanvas.parentElement.clientWidth * window.devicePixelRatio;
			matrixCanvas.height = matrixCanvas.parentElement.clientHeight * window.devicePixelRatio;
			ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
		}
		resizeMatrix();

		let mFrame = 0;
		const chars = 'STUDIOAVELIN0123456789+-_/[]{}';

		function drawMatrix() {
			mFrame++;
			const w = matrixCanvas.parentElement.clientWidth;
			const h = matrixCanvas.parentElement.clientHeight;

			ctx.fillStyle = '#0A0A0B';
			ctx.fillRect(0, 0, w, h);
			ctx.font = '12px monospace';

			const cols = Math.floor(w / 16);
			const rows = Math.floor(h / 20);

			for (let i = 0; i < cols; i++) {
				for (let j = 0; j < rows; j++) {
					if ((i * 5 + j * 9 + Math.floor(mFrame / 8)) % 7 === 0) {
						const char = chars[(i + j + mFrame) % chars.length];
						const isLime = (i * 3 + j * 7 + Math.floor(mFrame / 15)) % 23 === 0;
						ctx.fillStyle = isLime ? '#C7F000' : 'rgba(255, 255, 255, 0.35)';
						ctx.fillText(char, i * 16 + 8, j * 20 + 15);
					}
				}
			}
			requestAnimationFrame(drawMatrix);
		}
		drawMatrix();
	}

	// Canvas 02: Signal Grid
	const signalCanvas = document.getElementById('sa-canvas-signal');
	if (signalCanvas) {
		const ctx = signalCanvas.getContext('2d');
		function resizeSignal() {
			signalCanvas.width = signalCanvas.parentElement.clientWidth * window.devicePixelRatio;
			signalCanvas.height = signalCanvas.parentElement.clientHeight * window.devicePixelRatio;
			ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
		}
		resizeSignal();

		let sFrame = 0;

		function drawSignal() {
			sFrame++;
			const w = signalCanvas.parentElement.clientWidth;
			const h = signalCanvas.parentElement.clientHeight;

			ctx.fillStyle = '#0A0A0B';
			ctx.fillRect(0, 0, w, h);

			const gridStep = 30;
			ctx.strokeStyle = 'rgba(255, 255, 255, 0.07)';
			ctx.lineWidth = 1;

			for (let x = 0; x < w; x += gridStep) {
				ctx.beginPath();
				ctx.moveTo(x, 0);
				ctx.lineTo(x, h);
				ctx.stroke();
			}
			for (let y = 0; y < h; y += gridStep) {
				ctx.beginPath();
				ctx.moveTo(0, y);
				ctx.lineTo(w, y);
				ctx.stroke();
			}

			// Moving signal pulses
			for (let i = 0; i < 4; i++) {
				const x = ((sFrame * (1.5 + i * 0.5) + i * 90) % (w + 80)) - 40;
				const y = (i * 45 + 30) % h;
				ctx.strokeStyle = '#C7F000';
				ctx.lineWidth = 1.5;
				ctx.beginPath();
				ctx.moveTo(x - 30, y);
				ctx.lineTo(x, y);
				ctx.stroke();

				ctx.fillStyle = '#C7F000';
				ctx.beginPath();
				ctx.arc(x, y, 2.5, 0, Math.PI * 2);
				ctx.fill();
			}
			requestAnimationFrame(drawSignal);
		}
		drawSignal();
	}

	// Canvas 03: Poster Generator
	const posterCanvas = document.getElementById('sa-canvas-poster');
	if (posterCanvas) {
		const ctx = posterCanvas.getContext('2d');
		function resizePoster() {
			posterCanvas.width = posterCanvas.parentElement.clientWidth * window.devicePixelRatio;
			posterCanvas.height = posterCanvas.parentElement.clientHeight * window.devicePixelRatio;
			ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
		}
		resizePoster();

		let pFrame = 0;

		function drawPoster() {
			pFrame++;
			const w = posterCanvas.parentElement.clientWidth;
			const h = posterCanvas.parentElement.clientHeight;

			ctx.fillStyle = '#F2F2F2';
			ctx.fillRect(0, 0, w, h);

			ctx.fillStyle = '#0A0A0B';
			ctx.fillRect(20, 20, w - 40, h - 40);

			ctx.fillStyle = '#FFFFFF';
			ctx.font = 'bold 22px "Inter", sans-serif';
			ctx.fillText('POSTER #0' + (Math.floor(pFrame / 90) % 4 + 1), 35, 55);

			ctx.fillStyle = '#C7F000';
			ctx.fillRect(35, 70, 80, 3);

			ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
			ctx.font = '11px sans-serif';
			ctx.fillText('SYSTEM / TYPOGRAPHY / SPACE', 35, 95);

			const boxW = 60 + Math.sin(pFrame * 0.03) * 30;
			ctx.fillStyle = '#C7F000';
			ctx.fillRect(35, 115, boxW, 40);

			requestAnimationFrame(drawPoster);
		}
		drawPoster();
	}
});
</script>

<?php wp_footer(); ?>
</body>
</html>

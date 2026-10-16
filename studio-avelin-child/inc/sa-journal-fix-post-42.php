<?php
/**
 * One-time repair of Journal post 42 ("Now-Playing-Display …").
 *
 * The post was pasted from a hard-wrapped Markdown file, so every line became
 * its own paragraph block. On the first request after deployment this replaces
 * the content with real paragraphs (WordPress keeps the old version as a
 * revision) and remembers that it ran. Safe to delete once it has run.
 *
 * @package studio-avelin-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sa_journal_fix_post_42() {
	if ( get_option( 'sa_journal_fix_post_42' ) ) {
		return;
	}
	$post = get_post( 42 );
	// Only touch the post while it still has the broken one-line paragraphs.
	if ( ! $post || substr_count( $post->post_content, '<p' ) < 30 || false === strpos( $post->post_content, 'den eigentlichen</p>' ) ) {
		update_option( 'sa_journal_fix_post_42', 'skipped', false );
		return;
	}
	update_option( 'sa_journal_fix_post_42', 'running', false );

	$content = <<<'SA_BLOCKS'
<!-- wp:heading -->
<h2 class="wp-block-heading">Ausgangslage</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Im Rahmen eines Heimautomatisierungs-Projekts wurde ein bestehender Debian-Rechner zu einem zentralen Medien- und Automatisierungs-Hub ausgebaut. Ein Teil davon: ein AirPlay-Empfänger, über den sich Musik von jedem Apple-Gerät im Netzwerk direkt an die Stereoanlage im Wohnzimmer streamen lässt. Technisch übernimmt dabei <a href="https://github.com/mikebrady/shairport-sync">shairport-sync</a> den eigentlichen AirPlay-Empfang und gibt das Audiosignal über die Soundkarte des Rechners aus.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Ein reiner Audio-Stream verrät aber nichts darüber, was gerade läuft. Ziel war deshalb ein Display, das in Echtzeit zeigt, welcher Titel gerade abgespielt wird – inklusive Cover, Interpret und Hintergrundinformationen zur Band – und das sich direkt am Gerät per Bildschirm bedienen lässt.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Technische Umsetzung</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Metadaten aus dem AirPlay-Stream</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>shairport-sync kann Metadaten (Titel, Interpret, Album, Cover-Art, Wiedergabestatus) über eine benannte Pipe im Dateisystem ausgeben. Ein eigens dafür geschriebener Python-Dienst öffnet diese Pipe dauerhaft, parst den binären Metadaten-Strom und hält daraus den aktuellen Wiedergabezustand in einer JSON-Datei fest. Da eine benannte Pipe nur so lange Daten liefert, wie ein Leseprozess sie offen hält, öffnet der Dienst sie in einer Schleife automatisch neu, falls die Verbindung unterbrochen wird.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Empfangene Cover-Art wird als Bilddatei auf die Festplatte geschrieben und über einen Versions-Zähler referenziert, damit das Frontend neue Cover zuverlässig nachladen kann, ohne unnötig oft Netzwerkanfragen zu stellen.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Anreicherung mit Hintergrundinformationen</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Sobald sich der Interpret ändert, lädt der Dienst im Hintergrund zusätzliche Informationen nach:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li><strong>Biografie und Bildmaterial</strong> über die <a href="https://www.theaudiodb.com/">TheAudioDB</a>-API.</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><strong>Diskografie</strong> über die <a href="https://musicbrainz.org/">MusicBrainz</a>-API, gefiltert auf <code>primary-type = Album</code> ohne Nebentypen wie Live-Alben, Compilations oder Soundtracks – damit ausschließlich echte Studioalben angezeigt werden.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Da MusicBrainz strikte Rate-Limits durchsetzt, laufen alle Anfragen serialisiert über eine gemeinsame Sperre mit automatischem Backoff bei temporären Serverfehlern. Bereits abgefragte Interpreten werden zwischengespeichert, damit bei wiederholter Wiedergabe keine unnötigen externen Anfragen entstehen.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Fernsteuerung der Wiedergabe</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>shairport-sync stellt eine <a href="https://specifications.freedesktop.org/mpris-spec/latest/">MPRIS</a>-Schnittstelle über D-Bus bereit. Ein kleiner HTTP-Server nimmt Steuerbefehle (Play, Pause, Titel vor/zurück) vom Frontend entgegen und leitet sie über <code>busctl</code> an diese Schnittstelle weiter. Dadurch lässt sich die Wiedergabe direkt am Display steuern, ohne das ursprüngliche Wiedergabegerät in die Hand nehmen zu müssen.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Darstellung</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Das Frontend ist eine schlanke HTML/JavaScript-Oberfläche, die die Wiedergabe- und Interpreten-Daten per Polling abruft und ohne Neuladen der Seite aktualisiert. Sie läuft im Kiosk-Modus von Firefox und wird beim Systemstart automatisch angezeigt – der Bildschirm zeigt damit permanent den aktuellen Wiedergabestatus, ohne dass eine Interaktion nötig ist.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Ergebnis</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Das fertige Display zeigt Cover, Titel und Interpret der aktuellen Wiedergabe, Wiedergabesteuerung sowie einen Informationsbereich mit Kurzbiografie, Bildmaterial und vollständiger Studio-Diskografie des Interpreten – mit farblicher Hervorhebung des aktuell gespielten Albums.</p>
<!-- /wp:paragraph -->

<!-- wp:image -->
<figure class="wp-block-image"><img src="https://studio-avelin.com/wp-content/uploads/2026/09/now-playing-screenshot.png" alt="Now-Playing-Display mit Cover, Wiedergabesteuerung und Interpreten-Informationen"/><figcaption class="wp-element-caption">Now-Playing-Display mit Cover, Wiedergabesteuerung und Interpreten-Informationen</figcaption></figure>
<!-- /wp:image -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Eingesetzte Technologien</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>shairport-sync (AirPlay-Empfang, MPRIS-Steuerung)</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Python (Metadaten-Verarbeitung, HTTP-Backend)</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>TheAudioDB- und MusicBrainz-API (Interpreten- und Diskografie-Daten)</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>HTML, CSS, JavaScript (Frontend)</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Firefox im Kiosk-Modus (Anzeige)</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>systemd (Dienstverwaltung, automatischer Neustart)</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->
SA_BLOCKS;

	kses_remove_filters();
	$result = wp_update_post(
		array(
			'ID'           => 42,
			'post_content' => wp_slash( $content ),
		),
		true
	);
	update_option( 'sa_journal_fix_post_42', is_wp_error( $result ) ? 'error: ' . $result->get_error_message() : 'done ' . gmdate( 'c' ), false );
}
add_action( 'wp_loaded', 'sa_journal_fix_post_42' );

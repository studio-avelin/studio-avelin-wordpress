<?php
/**
 * Template Name: Studio Avelin – Projekt: Hawaiimassage zu Hause
 * Projektnotiz: /work/hawaiimassage/
 *
 * Die Website selbst ist seit Oktober 2026 live unter https://hawaiimassage-zu-hause.de/.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sa_project = array(
	'title'        => 'Hawaiimassage zu Hause',
	'subtitle'     => 'Mobile Wellnessmassage · Kelkheim',
	'summary'      => 'Eine ruhige, warme Website für mobile Wellnessmassagen zu Hause – Lomi Lomi, Schwangerschafts-, Hot-Stone-, Aromaöl- und Babymassage.',
	'status'       => 'Live',
	'role'         => 'Design, Entwicklung, Textunterstützung',
	'stack'        => 'Statische Seite, Cormorant Garamond & DM Sans',
	'state'        => 'Live seit Oktober 2026 unter eigener Domain',
	'link'         => 'https://hawaiimassage-zu-hause.de/',
	'link_display' => 'hawaiimassage-zu-hause.de',
	'link_label'   => 'Website öffnen',
	'description'  => array(
		'Ausgangslage: Eine mobile Masseurin bietet Wellnessmassagen bei Kundinnen zu Hause an und brauchte einen Auftritt, der genauso entspannt wirkt wie die Behandlung selbst.',
		'Ansatz: Eine klare Angebotsübersicht mit viel Raum für Bild und Text, warme Typografie und eine ruhige Farbwelt. Die Seite führt von der ersten Neugier bis zur Terminanfrage, ohne zu drängen.',
		'Ergebnis: Eine statisch umgesetzte Website mit eigener visueller Identität – unabhängig vom Designsystem von Studio Avelin und ohne WordPress. Seit Oktober 2026 ist sie unter hawaiimassage-zu-hause.de live.',
	),
	'hero'    => get_stylesheet_directory_uri() . '/assets/img/work/hawaiimassage/hero.jpg',
	'gallery' => array( get_stylesheet_directory_uri() . '/assets/img/work/hawaiimassage/lomi.jpg', get_stylesheet_directory_uri() . '/assets/img/work/hawaiimassage/aromaoel.jpg', get_stylesheet_directory_uri() . '/assets/img/work/hawaiimassage/hotstone.jpg' ),
);

set_query_var( 'sa_project', $sa_project );
get_template_part( 'parts/sa-project-note' );

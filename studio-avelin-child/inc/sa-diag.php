<?php
/**
 * Cleanup: removes the temporary error log written while debugging the
 * Journal "critical error" (October 2026). Can be deleted with its require.
 *
 * @package studio-avelin-child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sa_diag_log = WP_CONTENT_DIR . '/uploads/sa-diag-07666df06dff5b98.log';
if ( file_exists( $sa_diag_log ) ) {
	@unlink( $sa_diag_log ); // phpcs:ignore
}
unset( $sa_diag_log );

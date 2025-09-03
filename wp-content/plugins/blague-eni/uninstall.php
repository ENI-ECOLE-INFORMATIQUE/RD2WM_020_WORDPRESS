<?php
// Uninstall cleanup for ENI Blague & Citation
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;
$table = $wpdb->prefix . 'eni_blague';
// Remove table if it exists
$wpdb->query( "DROP TABLE IF EXISTS {$table}" );

// Delete plugin options/transients if any
delete_option( 'eni_blague_db_version' );
delete_transient( 'eni_blague_cache' );

<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die('no access');
}

global $wpdb,$table_prefix;

$wpdb->query('DROP TABLE IF EXISTS `'.$table_prefix.'wpads_zone`');
$wpdb->query('DROP TABLE IF EXISTS `'.$table_prefix.'wpads_advertise`');
$wpdb->query('DROP TABLE IF EXISTS `'.$table_prefix.'wpads_stat`');


delete_option('wpads_options');
delete_option('wpads_db_version');
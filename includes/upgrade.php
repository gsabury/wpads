<?php

global $wpdb, $table_prefix;


$zone_table = 'CREATE TABLE IF NOT EXISTS `'.$table_prefix.'wpads_zone` (
    `zone_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
    `zone_name` varchar(100) NOT NULL,
    `zone_type` bigint(4),
    `zone_width` INTEGER(11),
    `zone_height` INTEGER(11),
    `zone_price` bigint(20) NOT NULL,
    `zone_created_at` datetime NOT NULL
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;';

$banner_table = 'CREATE TABLE IF NOT EXISTS `'.$table_prefix.'wpads_advertise` (
    `ID` bigint(20) AUTO_INCREMENT PRIMARY KEY,
    `zone_id` bigint(20),
    `ad_user_id` bigint(20),
    `ad_text` varchar(100),
    `ad_url` varchar(100),
    `ad_image_file` varchar(100),
    `ad_expire_at` datetime NOT NULL,
    `ad_status` tinyint(4) DEFAULT 0,
    `ad_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_zone_id (zone_id),
    INDEX idx_user_id (ad_user_id)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;';


  $statistics_table = 'CREATE TABLE IF NOT EXISTS `'.$table_prefix.'wpads_stat` (
    `id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
    `ad_id` bigint(20),
    `total_clicks` INTEGER(11),
    `stat_date` datetime NOT NULL
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;';

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

$wpads_db_version = get_option('wpads_db_version');

  if(intval($wpads_db_version) != WPADS_DB_VERSION){
        dbDelta($zone_table);
        dbDelta($banner_table);
        dbDelta($statistics_table);
        update_option('wpads_db_version', WPADS_DB_VERSION);
  }
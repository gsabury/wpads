<?php
/*
Plugin Name: WordPress Ads 
Plugin URI: https://yaransoft.com
Description: Plugin for Advertisment Managment
Author: Abdulg Ghafor Sabury
Version: 1.0.0
Author URI:  https://yaransoft.com
*/

defined('ABSPATH') || exit('NO ACCESS');

//Define Constants
define('WPADS_DIR', trailingslashit(plugin_dir_path(__FILE__)));
define('WPADS_URL', trailingslashit(plugin_dir_url(__FILE__)));

define('WPADS_INC', trailingslashit(WPADS_DIR . 'includes'));
define('WPADS_LIBS', trailingslashit(WPADS_DIR . 'libs'));
define('WPADS_TPLS', trailingslashit(WPADS_DIR . 'tpls'));

$upload_path = wp_upload_dir();

define('WPADS_BANNER_URL', trailingslashit($upload_path['baseurl'] . DIRECTORY_SEPARATOR . 'wpads'));
define('WPADS_BANNER_DIR', trailingslashit($upload_path['basedir'] . DIRECTORY_SEPARATOR . 'wpads'));

define('WPADS_ASSETS', trailingslashit(WPADS_URL . 'assets'));

//define main hooks
add_action('init', function () {
    ob_start();
}, 1);

function wpads_activation()
{
    $options = get_option('wpads_options');
    if (empty($options) || (is_array($options) && count($options) == 0)) {
        $options['general']['wpads_is_active'] = 0;
        update_option('wpads_options', $options);
    }

    include WPADS_INC . 'upgrade.php'; // *
}

function wpads_deactivation() {}

register_activation_hook(__FILE__, 'wpads_activation');
register_deactivation_hook(__FILE__, 'wpads_deactivation');

//do includes
if (is_admin()) {
    if (!defined('DOING_AJAX')) {
        include WPADS_INC . 'admin_page.php'; // *
        include WPADS_INC . 'admin_menu.php'; // *
        include WPADS_INC . 'functions.php'; // *
    }
}

include WPADS_INC . 'user_functions.php'; // *
include WPADS_INC . 'shortcodes.php'; // *
include WPADS_INC . 'widget.php';

define('WPADS_DB_VERSION', 1);

add_theme_support('widgets');

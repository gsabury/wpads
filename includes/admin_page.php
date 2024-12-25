<?php
function wpads_admin_page() // *
{
    echo "Plugin Dashboard";
}

function wpads_zones_page() // *
{
    global $wpdb, $table_prefix;
    $action = isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : NULL;

    switch ($action) {
        case 'edit':
            $zone_id = isset($_GET['zone_id']) && ctype_digit($_GET['zone_id']) ? $_GET['zone_id'] : null;
            if (isset($_POST['submit'])) {
                intval($zone_id) || exit('no access');
                $zone_name = sanitize_text_field($_POST['wpads_zone_name']);
                $zone_type = intval($_POST['wpads_zone_type']);
                $zone_width = intval($_POST['zone_width']);
                $zone_height = intval($_POST['zone_height']);
                $zone_price = intval($_POST['wpads_zone_price']);
                $wpdb->update($table_prefix . 'wpads_zone', array(
                    'zone_name'   => $zone_name,
                    'zone_type'   => $zone_type,
                    'zone_width'  => $zone_width,
                    'zone_height' => $zone_height,
                    'zone_price'   => $zone_price
                ), array(
                    'zone_id'   => $zone_id
                ), array(
                    '%s',
                    '%d',
                    '%d',
                    '%d'
                ), array('%d'));

            }
            $edit_zone = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table_prefix}wpads_zone WHERE zone_id=%d", $zone_id));

            include WPADS_TPLS . 'admin/zones/form.php';
            break;
        case 'add_new_zone':
            if (isset($_POST['submit'])) {
                $zone_name = sanitize_text_field($_POST['wpads_zone_name']);
                $zone_type = intval($_POST['wpads_zone_type']);
                $zone_price = intval($_POST['wpads_zone_price']);
                $zone_width = intval($_POST['zone_width']);
                $zone_height = intval($_POST['zone_height']);

                $wpdb->insert($table_prefix . 'wpads_zone', array(
                    'zone_name' => $zone_name,
                    'zone_type' => $zone_type,
                    'zone_width'  => $zone_width,
                    'zone_height' => $zone_height,
                    'zone_price' => $zone_price,
                    'zone_created_at' => date('Y-m-d H:s:i')
                ), array('%s', '%d', '%d', '%d', '%d', '%s'));
            }

            include WPADS_TPLS . 'admin/zones/form.php';
            break;
        default:
            $all_zones = $wpdb->get_results("SELECT * 
                                            FROM {$table_prefix}wpads_zone");
            include WPADS_TPLS . 'admin/zones/list.php';
            break;
    }
}

function wpads_banners_page() // *
{
    global $wpdb, $table_prefix;
    $action = isset($_GET['action']) && !empty($_GET['action']) ? $_GET['action'] : NULL;
    switch ($action) {
        case 'save_banner':
            $banner_image_name = null;
            if (isset($_POST['submit'])) {
                $zone_id = intval($_POST['wpads_banner_zone']);
                $user_id = intval($_POST['wpads_banner_user']);
                $banner_image = $_FILES['wpads_banner_image'];
                $banner_text = sanitize_text_field($_POST['wpads_banner_text']);
                $banner_url = sanitize_text_field($_POST['wpads_banner_url']);
                $banner_expire_days = intval($_POST['wpads_banner_expire_days']);
                $expire_date = wpads_calculate_expire_date($banner_expire_days);
                if (!empty($banner_image['name'])) {
                    $banner_image_name = wpads_process_banner_image($banner_image);
                }

                $data = array(
                    'zone_id'    => $zone_id,
                    'ad_user_id' => $user_id,
                    'ad_text'   => $banner_text,
                    'ad_url'    => $banner_url,
                    'ad_expire_at' => $expire_date->format("Y-m-d H:i:s")
                );
                if (!empty($banner_image_name)) {
                    $data['ad_image_file'] = $banner_image_name;
                }

                $wpdb->insert($table_prefix . 'wpads_advertise', $data);
            }

            $all_zones = $wpdb->get_results("SELECT zone_id,zone_name FROM {$table_prefix}wpads_zone");
            $all_users = $wpdb->get_results("SELECT ID,display_name FROM {$wpdb->users}");

            include WPADS_TPLS . 'admin/banners/form.php';

            break;
        case 'delete':
            (isset($_GET['ad_id']) && intval($_GET['ad_id'])) || exit('no access');
            $ad_id = intval($_GET['ad_id']);
            $banner = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table_prefix}wpads_advertise WHERE ID= %d ORDER BY ID DESC", $ad_id));

            $banner_name = isset($banner->ad_image_file) ? $banner->ad_image_file : '';
            $banner_full_path = WPADS_BANNER_DIR.''.$banner_name;
            if(file_exists($banner_full_path)){
                unlink($banner_full_path);
            }

            $wpdb->query($wpdb->prepare("DELETE  FROM {$table_prefix}wpads_advertise WHERE ID= %d ORDER BY ID DESC", $ad_id));
           
            wp_redirect(admin_url('admin.php?page=wpads_admin_banners'));

            break;
        default:
            $all_ads = $wpdb->get_results("SELECT  
                                           ads.*,
                                           users.display_name,
                                           zones.zone_name
                                          FROM 
                                          {$table_prefix}wpads_advertise ads
                                          JOIN {$wpdb->users} users 
                                          ON ads.ad_user_id=users.ID
                                          JOIN {$table_prefix}wpads_zone zones
                                          ON ads.zone_id = zones.zone_id
                                          ORDER BY ad_created_at DESC");

            include WPADS_TPLS . 'admin/banners/list.php';
            break;
    }
}

function wpads_admin_settings() // *
{
    $wpads_options = get_option('wpads_options');  

    if (isset($_POST['submit'])) {
        if (isset($_POST['wpads_is_active'])) {
            $wpads_options['general']['wpads_is_active'] = 1;
        } else {
            $wpads_options['general']['wpads_is_active'] = 0;
        }
        update_option('wpads_options', $wpads_options);

        $wpads_options = get_option('wpads_options');
    }

    include WPADS_TPLS . 'admin/settings/settings.php';
}

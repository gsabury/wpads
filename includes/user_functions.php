<?php

function wpads_calculate_expire_date($days) // *
{

    $expire_date = new DateTime();
    $expire_date->add(new DateInterval("P{$days}D"));
    return $expire_date;
}

function wpads_process_banner_image($file) // *
{
    $white_list = array(
        image_type_to_mime_type(IMAGETYPE_JPEG),
        image_type_to_mime_type(IMAGETYPE_GIF),
        image_type_to_mime_type(IMAGETYPE_PNG),
        image_type_to_mime_type(IMAGETYPE_SWF)
    );

    if (!in_array($file['type'], $white_list)) {
        return  false;
    }

    $wp_upload_data = wp_upload_dir();
    $wpads_base_upload_path = trailingslashit($wp_upload_data['basedir'] . DIRECTORY_SEPARATOR . 'wpads');

    if (!file_exists($wpads_base_upload_path)) {
        @mkdir($wpads_base_upload_path);
    }

    $file_extension = explode('.', $file['name']);
    $file_extension = end($file_extension);
    $file_name = md5_file($file['tmp_name']) . '.' . $file_extension;
    move_uploaded_file($file['tmp_name'], $wpads_base_upload_path . $file_name);
    return $file_name;
}

if (!function_exists('dd')) { // *
    function dd()
    {
        echo '<pre>';
        var_dump(func_get_args());
        echo '</pre>';
    }
}

function wpads_show_zone_ads($zone_type, $zone_banners) // *
{
    $output_html = '';
    if (intval($zone_type) == 1) {
        $output_html .= '<div class="wpads_wrapper wpads_banner">';
        foreach ($zone_banners as $banner) {
            $output_html .= wpads_show_banner_ad($banner);
        }
        return $output_html;
    }

    if (intval($zone_type) == 2) {
        $output_html = '<div class="wpads_wrapper wpads_text">';
        foreach ($zone_banners as $banner) {
            $output_html .= wpads_show_text_ad($banner);
        }
        return $output_html;
    }
    $output_html .= '<div>';
    return $output_html;
}

function wpads_show_banner_ad($ad) // *
{
    if ($ad && !empty($ad)) {
        $ad_src = WPADS_BANNER_URL . $ad->ad_image_file;
        $html = '<div  class="ad_item_wrapper ad_banner ad_' . $ad->zone_width . '_' . $ad->zone_height . '">
                    <a class="ad_item" href="/?display_ad=' . $ad->ID . '" target="_blank">
                        <img src="' . $ad_src . '"  height="' . $ad->zone_height . '" width="' . $ad->zone_width . '">
                    </a>
               </div>';
        return $html;
    }
    return '';
}

function wpads_show_text_ad($ad) // *
{
    if ($ad && !empty($ad)) {
        $html = '<div class="ad_item_wrapper ad_text">
            <a class="ad_item" href="' . $ad->ad_url . '" target="_blank">
                <div class="ad_item_inner">
                    <span>' . $ad->ad_text . '</span>
                    <span>' . $ad->ad_url . '</span>
                </div>
            </a>
        </div>';
        return $html;
    }
    return '';
}

add_action('wp_enqueue_scripts', function () { // *
    wp_enqueue_style('wpads_user_style', WPADS_ASSETS . 'css/wpads.css');

    wp_enqueue_script(
        "wpads_jquery",
        "https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js",
        array(),
        "3.7.1",
        false
    );

});

// Logs Visit Statistics
add_action('init', function () { // *
    if (isset($_GET['display_ad']) && intval($_GET['display_ad'])) {
        global $wpdb, $table_prefix;
        $banner_id = intval($_GET['display_ad']); 
        $banner_url = $wpdb->get_var(
            $wpdb->prepare("SELECT ad_url FROM {$table_prefix}wpads_advertise WHERE `ID`=%d", $banner_id)
        );
        if ($banner_url) {
            wpads_update_ad_stats($banner_id);
            wp_redirect($banner_url);
            exit;
        }
    }
}, 1);

function wpads_update_ad_stats($ad_id) // *
{
    if (intval($ad_id) == 0) {
        return false;
    }

    global $wpdb, $table_prefix;
    $today = date('Y-m-d');
    $today_stat_exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$table_prefix}wpads_stat WHERE ad_id=%d AND DATE(stat_date)=DATE(%s) LIMIT 1", $ad_id, $today));
    
    if (intval($today_stat_exists)) {
        $wpdb->query($wpdb->prepare("UPDATE {$table_prefix}wpads_stat SET total_clicks=total_clicks + 1 WHERE ad_id=%d LIMIT 1", $ad_id));
    } else {
        $wpdb->insert($table_prefix . 'wpads_stat', array(
            'ad_id'   => $ad_id,
            'total_clicks' => 1,
            'stat_date'    => date('Y-m-d')
        ), array(
            '%d',
            '%d',
            '%s'
        ));
    }
}

function wpads_get_options() // *
{
    return get_option('wpads_options');
}

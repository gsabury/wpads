<?php
// Show Adds
add_shortcode('wpads_show','wpads_show_callback'); // *
function wpads_show_callback($atts,$content=null){

    $args = shortcode_atts(array(
        'id'  => 0,
    ), $atts);

    if(!intval($args['id'])){
        return false;
    }

    $zone_id = intval($args['id']);

    global $wpdb,$table_prefix;

    $zone_type = $wpdb->get_var($wpdb->prepare("SELECT zone_type FROM {$table_prefix}wpads_zone WHERE zone_id=%d",$zone_id));
    
    $zone_banners = $wpdb->get_results($wpdb->prepare("SELECT 
                                        a.*,
                                        z.zone_width,
                                        z.zone_height 
                                        FROM {$table_prefix}wpads_advertise a
                                        JOIN {$table_prefix}wpads_zone z
                                        ON a.zone_id = z.zone_id
                                        WHERE a.zone_id=%d", $zone_id));

    if(!$zone_banners || count($zone_banners) == 0){
        return false;
    }

    return wpads_show_zone_ads($zone_type,$zone_banners);
}

// Show Order Form
add_shortcode('wpads_order_form','wpads_order_form_callback');
function wpads_order_form_callback($atts,$content=null){ // *

    if(!is_user_logged_in()){
        return false;
    }

    if(isset($options['general']['wpads_is_active']) && intval($options['general']['wpads_is_active']) == 0){
        return false;
    }

    global $wpdb, $table_prefix;
    $options = wpads_get_options();

    if(isset($_POST['ads_submit'])){
        $current_user = wp_get_current_user();

        $banner_image_name = null;
                
        $zone_id = intval($_POST['zone']);
        $month = intval($_POST['month']);
        $banner_expire_days = ($month*30);
        $expire_date = wpads_calculate_expire_date($banner_expire_days);

    
        $banner_url = sanitize_text_field($_POST['ads_url']);
        $banner_text = sanitize_text_field($_POST['ads_text']);

        $user_id = $current_user->ID;

        $banner_image = $_FILES['ads_image'];      
                
        if (!empty($banner_image['name'])) {
            $banner_image_name = wpads_process_banner_image($banner_image);
        }

        $data = array(
            'zone_id'    => $zone_id, // *
            'ad_user_id' => $user_id, // *
            'ad_text'   => $banner_text, // *
            'ad_url'    => $banner_url, // *
            'ad_expire_at' => $expire_date->format("Y-m-d H:i:s") // *
        );
        if (!empty($banner_image_name)) {
            $data['ad_image_file'] = $banner_image_name;
        }

        $wpdb->insert($table_prefix . 'wpads_advertise', $data);
    }

    ob_start();

    $all_zones = $wpdb->get_results("SELECT * FROM {$table_prefix}wpads_zone");

    include WPADS_TPLS.'user/forms/order_form.php';

    $form_template = ob_get_clean();

    return $form_template;
}

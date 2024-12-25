<?php

class Wpads_Widget extends WP_Widget
{
    public function __construct()
    {
        $widget_options = array(
            'classname'  => 'wpads_widget',
            'description'  => 'ابزارک نمایش تبلیغات',
        );
        parent::__construct('wpads_widget', 'ابزارک تبلیغات', $widget_options);
    }

    public function widget($args, $instance)
    {
        global $wpdb, $table_prefix;
        $title = apply_filters('widget_title', $instance['title']);
        $zone_id = intval($instance['zone_id']);
        $zone_items = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$table_prefix}wpads_advertise WHERE zone_id=%d", $zone_id));
        echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title'];
        foreach($zone_items as $item){
            $ad_src = WPADS_BANNER_URL . $item->ad_image_file;
            echo '<div class="wpads_wrapper_image"><a href="/?display_ad=' . $item->ID . '" target="_blank"><img src="' . $ad_src . '"></a></div>';
        }
?>

    <?php
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        global $wpdb, $table_prefix;
        $all_zones = $wpdb->get_results("SELECT zone_id,zone_name FROM {$table_prefix}wpads_zone");
        $title = ! empty($instance['title']) ? $instance['title'] : '';
        $zone_id = intval($instance['zone_id']) > 0 ? $instance['zone_id'] : 0;
    ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">عنوان:</label>
            <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('zone_id'); ?>">ناحیه :</label>
            <select name="<?php echo $this->get_field_name('zone_id'); ?>" id="<?php echo $this->get_field_id('zone_id'); ?>">
                <?php foreach ($all_zones as $zone): ?>
                    <option value="<?php echo $zone->zone_id ?>" <?php selected($zone_id, $zone->zone_id); ?>><?php echo $zone->zone_name; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['zone_id'] = intval($new_instance['zone_id']);
        return $instance;
    }
}

function wpads_register_widget()
{
    $options = wpads_get_options();
    if (isset($options['general']['wpads_is_active']) && intval($options['general']['wpads_is_active']) == 0) {
        return false;
    }
    register_widget('Wpads_Widget');
}
add_action('widgets_init', 'wpads_register_widget');
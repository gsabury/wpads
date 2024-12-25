<?php
function wpads_init_admin_menu()
{
    add_menu_page( // *
        'تبلیغات',
        'تبلیغات',
        'manage_options',
        'wpads_admin',
        'wpads_admin_page'
    );

    add_submenu_page( // *
        'wpads_admin',
        'داشبورد',
        'داشبورد',
        'manage_options',
        'wpads_admin',
        'wpads_admin_page'
    );

    add_submenu_page( // *
        'wpads_admin',
        'ناحیه ها',
        'ناحیه ها',
        'manage_options',
        'wpads_admin_zones',
        'wpads_zones_page'
    );

    add_submenu_page( // *
        'wpads_admin',
        'بنر ها',
        'بنر ها',
        'manage_options',
        'wpads_admin_banners',
        'wpads_banners_page'
    );

    add_submenu_page( // *
        'wpads_admin',
        'تنظیمات',
        'تنظیمات',
        'manage_options',
        'wpads_admin_settings',
        'wpads_admin_settings'
    );
}

add_action('admin_menu', 'wpads_init_admin_menu');

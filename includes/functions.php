<?php

function wpads_get_zone_type($zone_type){
    return intval($zone_type == 1) ? 'بنر':'متنی';
}

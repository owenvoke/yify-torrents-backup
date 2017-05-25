<?php
/**
 * @param $time
 * @param string $format
 *
 * @return false|string
 */
function smarty_modifier_absolute_time($time, $format = '')
{
    if (!$time) {
        return 'N/A';
    }
    if (!ctype_digit($time)) {
        $time = strtotime($time);
    }
    if (!$format) {
        $format = 'j M o, g:i:sA';
    }

    return date($format, $time);
}

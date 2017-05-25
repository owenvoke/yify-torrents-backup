<?php
/**
 * @param int $int
 * @param int $length
 *
 * @return string
 */
function smarty_modifier_file_size($int, $length = 4)
{
    $int = (int) $int;
    switch (true) {
        case $int < 1024:
            return $int.'B';
        case $int < 1048576:
            return trim_num($int / 1024, $length).' <span>KB</span>';
        case $int < 1073741824:
            return trim_num($int / 1048576, $length).' <span>MB</span>';
        default:
            return trim_num($int / 1073741824, $length).' <span>GB</span>';
    }
}

/**
 * @param int $num
 * @param int $len
 *
 * @return string
 */
function trim_num($num, $len)
{
    if (strlen($num) <= $len) {
        return $num;
    }
    while (strlen($num) > $len) {
        $num = substr($num, 0, -1);
    }
    $num = trim($num, '.');

    return $num;
}

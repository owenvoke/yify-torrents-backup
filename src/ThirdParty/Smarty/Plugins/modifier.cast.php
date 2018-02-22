<?php
/**
 * @param * $var
 * @param string $type
 *
 * @return false|string
 */
function smarty_modifier_cast($var, $type = 'string')
{
    switch ($type) {
        case 'string':
            $new = (string)$var;
            break;
        case 'array':
            $new = (array)$var;
            break;
        case 'object':
            $new = (object)$var;
            break;
        case 'int':
            $new = (int)$var;
            break;
        case 'bool':
            $new = (bool)$var;
            break;
        case 'float':
            $new = (float)$var;
            break;
        default:
            $new = (string)$var;
            break;
    }

    return $new;
}

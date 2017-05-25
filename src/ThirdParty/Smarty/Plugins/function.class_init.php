<?php
/**
 * @param array $params
 * @param \Smarty $smarty
 */
function smarty_function_class_init(array $params, &$smarty)
{
    $class = $params['class'];
    if (isset($params['init'])) {
        $smarty->assign($params['var'], new $class($params['init']));
    } else {
        $smarty->assign($params['var'], new $class());
    }
}

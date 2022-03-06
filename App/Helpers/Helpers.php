<?php


/**
 * ####################
 * #####   View   #####
 * ####################
 */
function view(string $module, array $vars = [], string $action = 'index')
{
    if (!empty($vars)) {
        extract($vars);
    }
    
    require_once APP . 'Views/_includes/header.phtml';
    require_once APP . 'Views/_includes/menu.phtml';
    require_once APP . 'Views/' . $module . '/' . $action . '.phtml';
    require_once APP . 'Views/_includes/footer.phtml';
}

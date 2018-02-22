<?php

namespace pxgamer\YifyTorrents\Modules\Base;

use pxgamer\YifyTorrents\Routing;

class Controller extends Routing\Base
{
    public function index()
    {
        $data = new \stdClass();

        $this->smarty->display(
            'index.tpl',
            [
                'data' => $data
            ]
        );
    }

    public function errorNotFound()
    {
        $error = new \Error('Page not found.', 404);

        $this->smarty->display(
            'error.tpl',
            [
                'error' => $error
            ]
        );
    }
}

<?php

namespace pxgamer\YifyTorrents\Server;

use pxgamer\YifyTorrents\Config;

class Logger
{
    public static function log($data, $optional_message = null)
    {
        if (!is_dir(Config\App::LOG_DIRECTORY)) {
            mkdir(Config\App::LOG_DIRECTORY);
        }

        if (Config\App::ENV_MODE == Config\App::ENV_DEVELOPMENT) {
            file_put_contents(
                Config\App::LOG_DIRECTORY . DS . Config\App::LOG_ERROR,
                date('Y-m-d H:i:s') . ($optional_message ? " - " . $optional_message : null) .
                PHP_EOL . print_r($data, true) . PHP_EOL,
                FILE_APPEND
            );
        }
    }
}
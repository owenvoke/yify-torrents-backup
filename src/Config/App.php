<?php

namespace pxgamer\YifyTorrents\Config;

class App
{
    // App Configuration
    const APP_NAME = 'YIFY Torrents Backup';

    // Environment Configuration
    const ENV_PRODUCTION = 'production';
    const ENV_DEVELOPMENT = 'development';
    const ENV_MODE = self::ENV_DEVELOPMENT;

    // Logging Configuration
    const LOG_DIRECTORY = ROOT_PATH . 'logs';
    const LOG_ERROR = 'errors.log';
}
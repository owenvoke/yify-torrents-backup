<?php

namespace pxgamer\YifyTorrents\Routing;

use pxgamer\YifyTorrents\Accounts;
use pxgamer\YifyTorrents\Config;
use pxgamer\YifyTorrents\Server;
use System\Request;

/**
 * Class Base
 */
class Base
{
    /**
     * @var \Smarty
     */
    protected $smarty;
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var \PDO
     */
    protected $db;
    /**
     * @var Accounts\User
     */
    protected $user;

    /**
     * Base constructor.
     */
    public function __construct()
    {
        // Start session
        Server\Session::start();

        // Define controller env
        $this->request = Request::instance();
        $this->smarty = new \Smarty();
        $this->user = new Accounts\User();

        // Set up Smarty env
        $this->smarty->addTemplateDir(ROOT_PATH . 'templates');
        $this->smarty->setCompileDir(ROOT_PATH . 'templates_c');
        $this->smarty->addPluginsDir([SRC_PATH . 'ThirdParty/Smarty/Plugins']);
        $this->smarty->assign('_user', $this->user);
        $this->smarty->assign('_request', $this->request);
        $this->smarty->assign('_config', new Config\App());

        // Connect to database
        $this->db = Server\Database::connect();
    }
}
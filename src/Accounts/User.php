<?php

namespace pxgamer\YifyTorrents\Accounts;

use pxgamer\YifyTorrents\Accounts;
use pxgamer\YifyTorrents\Server;

class User
{
    private $id;
    private $username;
    private $acl;
    private $api_key;

    public function __construct()
    {
        if (Server\Session::isset('id')) {
            $this->id = (int)Server\Session::get('id');

            $db = Server\Database::connect();
            $db->query('USE id_pxgamer');

            $stmt = $db->prepare('SELECT u.id, u.username, u.acl, u.is_deleted
                                            FROM users u
                                            WHERE u.id = :user_id');
            $stmt->bindParam(':user_id', $this->id, \PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(\PDO::FETCH_OBJ);

            if (isset($user->username)) {
                if (!$user->is_deleted) {
                    $this->id = (int)$user->id ?? 0;
                    $this->username = $user->username ?? null;
                    $this->acl = (int)$user->acl ?? 0;
                    $this->api_key = $user->api_key ?? null;
                }
                unset($user);
            }
            $db->query('USE `yify-torrents`');
        } else {
            $this->acl = Accounts\ACL::ANON;
        }
    }

    public function acl($requested)
    {
        if (!$this->acl || !$this->username) {
            return false;
        }

        switch ($requested) {
            case 'logged_in':
                return true;
            default:
                return false;
        }
    }

    public function __get($name)
    {
        return $this->$name ?? null;
    }

    public function __set($name, $value)
    {
        return ($this->$name = $value);
    }
}
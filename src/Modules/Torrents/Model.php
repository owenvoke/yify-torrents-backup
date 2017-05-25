<?php

namespace pxgamer\YifyTorrents\Modules\Torrents;

use pxgamer\YifyTorrents\Server;

class Model
{
    public static function search($query)
    {
        if (!is_string($query)) {
            return [];
        }

        $query = '%' . $query . '%';

        $db = Server\Database::connect();

        $stmt = $db->prepare('SELECT * FROM torrents WHERE title LIKE :query');
        $stmt->bindParam(':query', $query, \PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
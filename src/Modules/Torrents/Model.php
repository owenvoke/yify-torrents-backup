<?php

namespace pxgamer\YifyTorrents\Modules\Torrents;

use pxgamer\YifyTorrents\Config;
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

    public static function byId($torrent_id)
    {
        if (!is_numeric($torrent_id)) {
            return null;
        }

        $torrent_id = (int)$torrent_id;

        $db = Server\Database::connect();

        $stmt = $db->prepare('SELECT * FROM torrents WHERE id =  :torrent_id');
        $stmt->bindParam(':torrent_id', $torrent_id, \PDO::PARAM_INT);
        $stmt->execute();

        $torrent = $stmt->fetch(\PDO::FETCH_OBJ);

        if (!$torrent) {
            return null;
        }

        if (isset($torrent->title) && $torrent->title != '') {
            foreach ($torrent as $item => $value) {
                if (is_numeric($value)) {
                    $torrent->$item = $value;
                }
            }

            $stmt = $db->prepare('SELECT td.tmdb_data
                                            FROM tmdb_data td
                                            JOIN data_link dl ON dl.tmdb_id = td.tmdb_id
                                            WHERE dl.torrent_id = :torrent_id');
            $stmt->bindParam(':torrent_id', $torrent_id, \PDO::PARAM_INT);
            $stmt->execute();
            $tmdb_data = $stmt->fetch(\PDO::FETCH_OBJ);

            if (isset($tmdb_data->tmdb_data)) {
                $torrent->tmdb = json_decode($tmdb_data->tmdb_data);
            }

            preg_match('/^.*?([0-9]{3,4}p) .*? YIFY$/i', $torrent->title, $matches);

            $torrent->quality = $matches[1] ?? 'UNKNOWN';
        }

        if (!isset($torrent->tmdb) || !$torrent->tmdb) {
            $torrent->tmdb = self::addTMDb($torrent);

            if (!$torrent->tmdb) {
                return null;
            }
        }

        return $torrent;
    }

    public static function addTMDb($torrent)
    {
        if (!is_object($torrent)) {
            return null;
        }

        $db = Server\Database::connect();

        $tmdb_id = $torrent->tmdb->tmdb_id ?? null;

        if (!$tmdb_id) {
            preg_match('/^(.*?)(?: 3D?)?(?: )?\(([0-9]{4})\).*?([0-9]{3,4}p)?.*?YIFY$/i', $torrent->title, $matches);

            if (empty($matches)) {
                return null;
            }

            $url = 'https://api.themoviedb.org/3/search/movie?query=' . urlencode($matches[1]) .
                '&year=' . urlencode($matches[2]) .
                '&primary_release_year=' . urlencode($matches[2]) .
                '&language=en-US&page=1&include_adult=false' .
                '&api_key=' . Config\App::TMDB_API_KEY;

            $response = self::curl_it($url);

            if ($response->success) {
                $json = json_decode($response->response);

                if (!isset($json->results[0])) {
                    return null;
                }

                $tmdb_id = $json->results[0]->id;
            }
        }

        $url = 'https://api.themoviedb.org/3/movie/' . $tmdb_id . '?language=en-US&api_key=' . Config\App::TMDB_API_KEY;

        $response = self::curl_it($url);

        if ($response->success) {
            $stmt = $db->prepare('INSERT INTO tmdb_data (tmdb_id, tmdb_data) VALUES (:tmdb_id, :tmdb_data)');
            $stmt->bindParam(':tmdb_id', $tmdb_id, \PDO::PARAM_INT);
            $stmt->bindParam(':tmdb_data', $response->response, \PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $db->prepare('INSERT INTO data_link (tmdb_id, torrent_id) VALUES (:tmdb_id, :torrent_id)');
            $stmt->bindParam(':tmdb_id', $tmdb_id, \PDO::PARAM_INT);
            $stmt->bindParam(':torrent_id', $torrent->id, \PDO::PARAM_INT);
            $stmt->execute();

            return json_decode($response->response);
        }

        return null;
    }

    public static function curl_it($url)
    {
        $status = new \stdClass();
        $status->success = false;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
        ));

        $status->response = curl_exec($curl);
        $status->error = curl_error($curl);

        curl_close($curl);

        $status->success = !$status->error;
        return $status;
    }
}
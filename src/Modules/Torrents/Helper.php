<?php

namespace pxgamer\YifyTorrents\Modules\Torrents;

use pxgamer\YifyTorrents\Config;

class Helper
{
    public static function magnetLink($hash, $title = '', $bTorrentPage = false)
    {
        $trackers = '';

        foreach (Config\App::DEFAULT_TRACKERS as $tracker) {
            $trackers .= '&tr=' . $tracker;
        }

        if ($bTorrentPage) {
            return '<span class="fa fa-fw fa-magnet"></span>
                    <a href="magnet:?xt=urn:btih:' . $hash . '&dn=' . $title . $trackers . '">
                        <span>Download via Magnet</span>
                    </a>';
        }

        return '<a href="magnet:?xt=urn:btih:' . $hash . '&dn=' . $title . $trackers . '">
                    <span class="fa fa-fw fa-magnet fa-rotate-180 text-danger"></span>
                    ' . ($bTorrentPage ? '<span>Download via Magnet</span>' : '') . '
                </a>';
    }

    public static function torrentLink($hash, $title = '', $bTorrentPage = false)
    {
        if ($bTorrentPage) {
            return '<span class="fa fa-fw fa-download"></span>
                    <a href="https://itorrents.org/torrent/' . $hash . '.torrent" download="' . $title . '.torrent">
                        <span>Download via Torrent</span>
                    </a>';
        }

        return '<a href="https://itorrents.org/torrent/' . $hash . '.torrent" download="' . $title . '.torrent">
                    <span class="fa fa-fw fa-download"></span>
                </a>';
    }
}
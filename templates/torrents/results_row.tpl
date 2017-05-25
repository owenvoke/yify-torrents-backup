<tr>
    <td><a class="no-underline" href="/torrent/{$torrent->id}">{$torrent->title}</a></td>
    <td class="date-column"><span class="pull-right">{$torrent->age_absolute|absolute_time}</span></td>
    <td class="hash-column">{$torrent->hash}</td>
    <td class="size-column"><span class="pull-right">{$torrent->size}</span></td>
    <td>{pxgamer\YifyTorrents\Modules\Torrents\Helper::magnetLink($torrent->hash, $torrent->title)}</td>
</tr>
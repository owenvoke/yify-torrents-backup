<table class="table">
    <tr class="firstr">
        <th>Title</th>
        <th class="date-column">Added</th>
        <th class="hash-column">Hash</th>
        <th class="size-column text-right">Size</th>
        <th class="magnet-column">&nbsp;</th>
    </tr>
    {foreach $data->torrents as $torrent}
        {include file='torrents/results_row.tpl' torrent=$torrent}
        {foreachelse}
        <tr>
            <td colspan="5"><h3 class="text-center">No Results Found</h3></td>
        </tr>
    {/foreach}
</table>
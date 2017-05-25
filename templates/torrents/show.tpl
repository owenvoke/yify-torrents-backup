{include file='include/header.tpl'}
<div class="container text-center">
    <div class="row">
        <div class="col-md-4">
            <img class="poster-image" alt="Poster" src="//image.tmdb.org/t/p/w185{$data->torrent->tmdb->poster_path}">
        </div>
        <div class="col-md-8 text-left">
            <h2 class="page-header">
                <span>{$data->torrent->tmdb->title}</span>
                <span>({$data->torrent->tmdb->release_date|absolute_time:'Y'})</span>
            </h2>
            <span class="small">
                <span title="Runtime">
                    <span class="fa fa-fw fa-clock-o" aria-hidden="true"></span>
                    <span>{$data->torrent->tmdb->runtime}m</span>
                </span>
                <span title="Quality">
                    <span class="fa fa-fw fa-video-camera" aria-hidden="true"></span>
                    <span>{$data->torrent->quality}</span>
                </span>
                {if $data->torrent->tmdb->original_title !== $data->torrent->tmdb->title}
                    <span title="Original Title">
                        <span class="fa fa-fw fa-language" aria-hidden="true"></span>
                        <span>{$data->torrent->tmdb->original_title}</span>
                    </span>
                {/if}
            </span>
            <hr>
            <div class="summary">
                <p>{$data->torrent->tmdb->overview}</p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h3>Rating</h3>
                    <p>Rated an average of {$data->torrent->tmdb->vote_average} by {$data->torrent->tmdb->vote_count}
                        people.</p>
                </div>
                <div class="col-md-6">
                    <h3>Languages</h3>
                    <ul class="list-unstyled">
                        {foreach $data->torrent->tmdb->spoken_languages as $language}
                            <li>{$language->name} ({$language->iso_639_1})</li>
                        {/foreach}
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h3>Genres</h3>
                    <ul class="list-unstyled">
                        {foreach $data->torrent->tmdb->genres as $genre}
                            <li>{$genre->name}</li>
                        {/foreach}
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3>More Info</h3>
                    <ul class="list-unstyled">
                        <li>
                            <strong>Budget:</strong>
                            <i class="fa fa-usd" aria-hidden="true"></i>
                            <span>{$data->torrent->tmdb->budget}</span>
                        </li>
                        <li>
                            <strong>Revenue:</strong>
                            <i class="fa fa-usd" aria-hidden="true"></i>
                            <span>{$data->torrent->tmdb->revenue}</span>
                        </li>
                        <li>
                            <strong>Runtime:</strong>
                            <span>{$data->torrent->tmdb->runtime} minutes</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Other Sites</h3>
                    <ul class="list-inline">
                        <li>
                            <a class="text-warning no-underline" target="_blank"
                               title="IMDb"
                               href="//www.imdb.com/title/{$data->torrent->tmdb->imdb_id}">
                                <i class="fa fa-imdb" aria-hidden="true"></i> IMDb
                            </a>
                        </li>
                        <li>
                            <a class="text-success no-underline" target="_blank"
                               title="TMDb"
                               href="//www.themoviedb.org/movie/{$data->torrent->tmdb->id}">
                                <i class="fa fa-comment" aria-hidden="true"></i> TMDb
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
{include file='include/footer.tpl'}

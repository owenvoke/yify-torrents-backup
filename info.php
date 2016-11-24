<?php
	date_default_timezone_set('UTC');
	include './header.php';
	
	// TMDB API INFO
	$tmdb_api_key = '';
    $base_url = 'https://api.themoviedb.org/3';
	$default_language = 'en-GB';
	$contentTypes = [
      'movie' => 'movie',
      'tv' => 'tv',
    ];
	$end_url = '?api_key='.$tmdb_api_key.'&language='.$default_language;
	
	if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
	{
		$id = (int) $_REQUEST['id'];
		include './connect.php';
		
		$statement = $mysqli->prepare('SELECT title FROM torrents WHERE id = ?');
        if(!$statement->bind_param('i', $id))
		{
			header('Location: /');
		}
        $statement->execute();
        $statement->bind_result($title);
		$statement->fetch();
		$statement->close();
		
		$statement = $mysqli->prepare('SELECT * FROM data_link WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        $statement->bind_result($entry_id, $torrent_id, $tmdb_id);
		$statement->fetch();
		$statement->close();
		if (!isset($entry_id))
		{
			$url = $base_url . '/search/movie' . $end_url . '&query=' . urlencode(explode('(', $title)[0]) . ((is_numeric(explode(')', explode('(', $title)[1])[0])) ? '&year=' . explode(')', explode('(', $title)[1])[0] : '');
			$tmdb_id = (count(json_decode(get($url))->results) > 0) ? json_decode(get($url))->results[0]->id : false;
			if (is_numeric($tmdb_id))
			{
				$statement = $mysqli->prepare('INSERT INTO data_link (torrent_id, tmdb_id) VALUES (?, ?)');
				$statement->bind_param('ii', $id, $tmdb_id);
				$statement->execute();
				$statement->close();
			}
		}
		
		$url = $base_url . '/movie/' . $tmdb_id . $end_url;
		
		$movie_data = json_decode(get($url));
	}
	else
	{
		header('Location: /');
	}
?>
<html>
<head>
	<title>Torrent Search</title>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<style>
	div {
		vertical-align: top;
	}
	.movie-block {
		max-width: 800px;
		margin: 0 auto;
	}
	.movie-title {
		margin-top: 0px;
	}
	.info-block {
		display: inline-block;
		text-align: left;
		color: white;
		margin-right: 10px;
	}
	ul {
		padding: 0px;
		list-style-type: none;
		margin-bottom: 0px;
	}
	.genres ul li {
		color: white;
		display: inline-block;
		padding: 5px;
		margin-right: 3px;
		border: 1px solid grey;
		border-radius: 3px;
	}
	.languages ul li {
		color: white;
		display: inline-block;
		padding: 5px;
		margin-right: 3px;
		border: 1px solid grey;
		border-radius: 3px;
	}
	.other-sites ul li a {
		font-size: 40px;
		color: white;
		display: inline-block;
	}
	.sbs {
		display: inline-block;
		margin-right: 5px;
	}
	.small {
		    font-size: 65%;
	}
	</style>
</head>
<body>
<div class="container">
	<div class="movie-block">
		<div class="info-block">
			<img src="https://image.tmdb.org/t/p/w185<?=$movie_data->poster_path?>" />
		</div>
		<div class="info-block">
			<h1 class="movie-title"><?=$movie_data->title . ' (' . date('Y', strtotime($movie_data->release_date)) . ')'?> <span class="small"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$movie_data->runtime?></span></h1>
			<?=(isset($movie_data->original_title) && $movie_data->original_title !== $movie_data->title) ? '<h4>Original Title: ' . $movie_data->original_title . '</h4>' : ''?>
			<div class="summary">
				<p><?=$movie_data->overview?></p>
			</div>
			<div>
				<div class="rating sbs">
					<h3>Rating</h3>
					<p>Rated an average of <?=$movie_data->vote_average?> by <?=$movie_data->vote_count?> people.</p>
				</div>
				<div class="languages sbs">
					<h3>Languages</h3>
					<ul>
						<?php
							foreach ($movie_data->spoken_languages as $language)
							{
								echo "<li>$language->name ($language->iso_639_1)</li> ";
							}
						?>
					</ul>
				</div>
			</div>
			<div>
				<div class="genres sbs">
					<h3>Genres</h3>
					<ul>
						<?php
							foreach ($movie_data->genres as $genre)
							{
								echo "<li>$genre->name</li> ";
							}
						?>
					</ul>
				</div>
				<div class="more-info sbs">
					<h3>More Info</h3>
					<ul>
						<li><strong>Budget:</strong> <i class="fa fa-usd" aria-hidden="true"></i><?=$movie_data->budget?></li>
						<li><strong>Revenue:</strong> <i class="fa fa-usd" aria-hidden="true"></i><?=$movie_data->revenue?></li>
						<li><strong>Runtime:</strong> <?=$movie_data->runtime?> minutes</li>
					</ul>
				</div>
			</div>
			<div class="other-sites">
				<h3>Other Sites</h3>
				<ul>
					<li><a href="http://www.imdb.com/title/<?=$movie_data->imdb_id?>/"><i class="fa fa-imdb" aria-hidden="true"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<?php
function get($url)
    {
        $cu = curl_init();
        curl_setopt_array(
          $cu,
          [
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_RETURNTRANSFER => 1,
          ]
        );
        return curl_exec($cu);
    }
?>
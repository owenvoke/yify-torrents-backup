<html>
<head>
    <?php include './header.php'; ?>
    <title>Torrent Search</title>
</head>
<body>
<div class="container">
    <div class="search-sect">
        <a href="/">
            <img src="/public/assets/images/logo-YTS-TB.png" align="center"/>
        </a>
    </div>
    <div class="search-sect">
        <form action="/templates/search.phpsearch.php" method="post">
            <input placeholder="I want to watch..." autocomplete="off" name="q" type="text"
                   class="hover-bottom big-search"/>
        </form>
    </div>
    <div class="years search-sect">
        <ul>
            <li><a href="/templates/search.phpsearch.php?q=(2015)">2015</a></li>
            <li><a href="/templates/search.phpsearch.php?q=(2014)">2014</a></li>
            <li><a href="/templates/search.phpsearch.php?q=(2013)">2013</a></li>
            <li><a href="/templates/search.phpsearch.php?q=(2012)">2012</a></li>
        </ul>
    </div>

</div>
</body>
</html>
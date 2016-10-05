<div class="search-sect">
    <form action="/search.php" method="post">
        <input placeholder="I want to watch..." value="<?= isset($search) ? htmlspecialchars($search) : '' ?>"
               autocomplete="off" name="q" type="text" class="hover-bottom big-search"/>
    </form>
</div>
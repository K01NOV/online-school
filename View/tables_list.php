<nav class="bo-side-nav">
    <?php if(isset($tables)): foreach($tables as $table): ?>
        <a href="?table=<?= urlencode($table) ?>" class="bo-nav-link <?= (isset($_GET['table']) && $_GET['table'] == $table) ? 'active' : '' ?>"><?= htmlspecialchars($table) ?></a>
    <?php endforeach; endif;?>
</nav>
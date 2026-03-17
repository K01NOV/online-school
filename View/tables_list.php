<nav class="bo-side-nav">
    <?php if(isset($tables)): foreach($tables as $table): ?>
        <a href="?<?php if(isset($_GET['mode'])) echo "mode=" . $_GET['mode'] . '&'?>table=<?= urlencode($table) ?>" class="bo-nav-link <?= (isset($_GET['table']) && $_GET['table'] == $table) ? 'active' : '' ?>"><?= htmlspecialchars($table) ?></a>
    <?php endforeach; endif;?>
</nav>
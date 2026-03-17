<main class="dashboard-content">
    <nav class="navigation-row">
        <a href="?mode=table<?php if(isset($_GET['table'])) echo "&table=" . $_GET['table']?>" class="nav-btn"><h2>Таблицы</h2></a>
        <a href="?mode=query<?php if(isset($_GET['table'])) echo "&table=" . $_GET['table']?>" class="nav-btn"><h2>Запросы</h2></a>
        <a href="?mode=construct<?php if(isset($_GET['table'])) echo "&table=" . $_GET['table']?>" class="nav-btn"><h2>Конструктор</h2></a>
    </nav>
</main>
<div class="bo-body">
    <div class="bo-container">
        <?php require_once __DIR__ . "/tables_list.php" ?>
    </div>
    <main class="bo-main-content">
        <?php if(isset($_GET['mode']) && $_GET['mode'] == 'table')
            require_once __DIR__ . "/table.php"?>
        <?php if(isset($_GET['mode']) && $_GET['mode'] == 'construct')
            require_once __DIR__ . "/construct.php"?>
    </main>
</div>
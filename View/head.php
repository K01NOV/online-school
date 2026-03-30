<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="auth-token" content="<?= $_SESSION['auth_token'] ?>">
    <title>Царская академия</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="icon" href="favicon.ico">
</head>
<body>

<header class="main-dashboard">
    <aside class="dashboard-sidebar">
        <?php require_once __DIR__ . "/miniProfile.php"; ?>
    </aside>
    <main class="dashboard-content">
        <form class="search-form" action="/search-results" method="POST">
            <input class="search-input" type="text" name="query" placeholder="Найти предмет или тему...">
            <button class="search-button" type="submit">
                <span>Поиск</span>
                <img src="assets/search_icon.svg" class="search-icon">
            </button>
            <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['auth_token'])?>" style="display: none">
        </form>
        <nav class="navigation-row">
            <a href="#" class="nav-btn"><h2>Задания</h2></a>
            <a href="#" class="nav-btn"><h2>Тесты</h2></a>
            <a href="#" class="nav-btn"><h2>Тетради</h2></a>
            <a href="#" class="nav-btn"><h2>Видеотека</h2></a>
            <a href="#" class="nav-btn"><h2>Проверить сочинение</h2></a>
        </nav>
        <nav class="classes-row">
            <a href="/<?=urldecode($a)?>" class="class-pill">Все</a>
            <a href="/<?=urldecode($a)?>&class=1-4" class="class-pill <?= (isset($_GET['class']) && $_GET['class'] == '1-4') ? 'active' : '' ?>">1-4 класс</a>
            <a href="/<?=urldecode($a)?>&class=5-9" class="class-pill <?= (isset($_GET['class']) && $_GET['class'] == '5-9') ? 'active' : '' ?>">5-9 класс</a>
            <a href="/<?=urldecode($a)?>&class=10-11" class="class-pill <?= (isset($_GET['class']) && $_GET['class'] == '10-11') ? 'active' : '' ?>">10-11 класс</a>
        </nav>
        <?php if(isset($grades)): ?>
            <nav class="classes-row">
                <?php foreach($grades as $id => $title): ?>
                    <a href="/<?=urldecode($a)?>&class=<?= urldecode($_GET['class'])?>&grade=<?= urldecode($id) ?>" class="class-pill <?= (isset($_GET['grade']) && $_GET['grade'] == $id) ? 'active' : '' ?>"><?= htmlspecialchars($title) ?></a>
                <?php endforeach?>
            </nav>
        <?php endif?>
    </main>
</header>
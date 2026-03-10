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
<?php if(isset($_SESSION['name'])):?>
    <header class="main-dashboard">
        <aside class="dashboard-sidebar">
            <?php require_once __DIR__ . "/miniProfile.php"; ?>
        </aside>

        <main class="dashboard-content">
            <nav class="navigation-row">
                <a href="/back-office/crud" class="nav-btn"><h2>CRUD</h2></a>
                <a href="#" class="nav-btn"><h2>Предметы</h2></a>
                <a href="#" class="nav-btn"><h2>Пользователи</h2></a>
                <a href="/back-office" class="nav-btn"><h2>Домой</h2></a>
                <a href="#" class="nav-btn nav-btn--special"><h2>Почта</h2></a>
            </nav>
            <nav class="navigation-row">
                <a href="#" class="nav-btn"><h2>Достижения</h2></a>
                <a href="#" class="nav-btn"><h2>Модераторы</h2></a>
                <a href="#" class="nav-btn"><h2>Журнал функций</h2></a>
            </nav>
        </main>
    </header>
<?php endif?>
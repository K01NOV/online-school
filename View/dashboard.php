<?php if(!isset($_SESSION['name'])){header("Location: /registration"); exit(); } ?>

<header class="main-dashboard">
    <aside class="dashboard-sidebar">
        <?php require_once __DIR__ . "/miniProfile.php"; ?>
    </aside>
    
    <main class="dashboard-content">
        <form class="search-form" action="" method="POST">
            <input class="search-input" type="text" name="search" placeholder="Найти предмет или тему...">
            <button class="search-button" type="submit">
                <span>Поиск</span>
                <img src="assets/search_icon.svg" class="search-icon">
            </button>
        </form>

        <nav class="navigation-row">
            <a href="#" class="nav-btn"><h2>Задания</h2></a>
            <a href="#" class="nav-btn"><h2>Тесты</h2></a>
            <a href="#" class="nav-btn"><h2>Тетради</h2></a>
            <a href="#" class="nav-btn"><h2>Видеотека</h2></a>
            <a href="#" class="nav-btn nav-btn--special"><h2>Проверить сочинение</h2></a>
        </nav>

        <nav class="classes-row">
            <a href="#" class="class-pill">1-4 класс</a>
            <a href="#" class="class-pill">5-9 класс</a>
            <a href="#" class="class-pill">10-11 класс</a>
        </nav>
    </main>
</header>

<section class="subjects-grid">
    <?php for($i=0; $i<8; $i++): ?>
    <a href="#" class="subject-card">
        <img src="assets\avatar2.png" alt="Математика"> 
        <h2>Математика</h2>
    </a>
    <?php endfor; ?>
</section>
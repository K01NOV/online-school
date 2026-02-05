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
            <a href="subject-info?id=<?= htmlspecialchars($_GET['id'])?>" class="class-pill">Все</a>
            <a href="subject-info?id=<?= htmlspecialchars($_GET['id'])?>&class=12" class="class-pill">1-4 класс</a>
            <a href="subject-info?id=<?= htmlspecialchars($_GET['id'])?>&class=13" class="class-pill">5-9 класс</a>
            <a href="subject-info?id=<?= htmlspecialchars($_GET['id'])?>&class=14" class="class-pill">10-11 класс</a>
        </nav>
        <?php if(isset($grades)): ?>
            <nav class="classes-row">
                <?php foreach($grades as $id => $title): ?>
                    <a href="subject-info?id=<?= htmlspecialchars($_GET['id'])?>&class=<?= htmlspecialchars($_GET['class'])?>&grade=<?= htmlspecialchars($id)?>" class="class-pill <?= (isset($_GET['grade']) && $_GET['grade'] == $id) ? 'active' : '' ?>"><?= htmlspecialchars($title) ?></a>
                <?php endforeach?>
            </nav>
        <?php endif?>
    </main>
</header>

<div class="subject-container">
    <header class="subject-header-hero">
        <div class="subject-cover">
            <img src="<?= htmlspecialchars($subject->image) ?>" alt="Cover" referrerpolicy="no-referrer">
        </div>

        <div class="subject-details">
            <span class="badge">ПРЕДМЕТ</span>
            <h1 class="subject-title"><?= htmlspecialchars($subject->name) ?></h1>
            
            <div class="subject-description">
                <p>Изучаем тайны природы, историю и устройство нашего мира. Курс адаптирован специально для учеников 4 класса.</p>
            </div>

            <div class="subject-stats">
                <div class="stat-item">
                    <span class="stat-value">142</span>
                    <span class="stat-label">записались</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-value">89</span>
                    <span class="stat-label">прошли курс</span>
                </div>
            </div>
        </div>
    </header>
</div>

<main class="topics-section">    
    <?php if(isset($topics) && !empty($topics)): ?>
        <div class="topics-grid">
            <section class="learning-path">
                <h2 class="path-title">Программа обучения</h2>
                <div class="accordion">
                    <?php foreach($topics as $topic):?>
                        <div class="topic-item">
                            <div class="topic-header" onclick="toggleTopic(this)">
                                <div class="topic-marker"></div>
                                <h3 class="topic-name"><?= htmlspecialchars($topic->name) ?></h3>
                                <span class="topic-status"><?= htmlspecialchars($topic->write_lessons_amount())?></span>
                            </div>
                        <?php if(!empty($topic->lessons)): ?>
                            <div class="lessons-list">
                                <div class="lessons-list-inner"> 
                                    <?php foreach($topic->lessons as $lesson): ?>
                                        <a href="#" class="lesson-link">
                                            <div class="lesson-marker-orange"></div>
                                            <span><?= htmlspecialchars($lesson->name)?></span>
                                        </a>
                                    <?php endforeach?>
                                </div>
                            </div>
                        <?php endif?>
                        </div>
                    <?php endforeach ?>
                </div>
            </section>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <?php require_once __DIR__ . "/placeholder.php" ?>
        </div>
    <?php endif; ?>
</main>
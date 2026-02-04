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
            <a href="#" class="class-pill">Все</a>
            <a href="#" class="class-pill">1-4 класс</a>
            <a href="#" class="class-pill">5-9 класс</a>
            <a href="#" class="class-pill">10-11 класс</a>
        </nav>
        <?php if(isset($grades)): ?>
            <nav class="classes-row">
                <?php foreach($grades as $id => $title): ?>
                    <a href="#" class="class-pill <?= (isset($_GET['grade']) && $_GET['grade'] == $id) ? 'active' : '' ?>"><?= htmlspecialchars($title) ?></a>
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
    <?php if($subject->id == 6): ?>
        <div class="topics-grid">
            <section class="learning-path">
                <h2 class="path-title">Программа обучения</h2>
                <div class="accordion">
                    <div class="topic-item">
                        <div class="topic-header" onclick="toggleTopic(this)">
                            <div class="topic-marker"></div>
                            <h3 class="topic-name">Земля и человечество</h3>
                            <span class="topic-status">4 урока</span>
                        </div>
                        
                        <div class="lessons-list">
                            <div class="lessons-list-inner"> <a href="#" class="lesson-link">
                                    <div class="lesson-marker-orange"></div>
                                    <span>Мир глазами астронома</span>
                                </a>
                                <a href="#" class="lesson-link">
                                    <div class="lesson-marker-orange"></div>
                                    <span>Планета на бумаге</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="topic-item">
                        <div class="topic-header" onclick="toggleTopic(this)">
                            <div class="topic-marker"></div>
                            <h3 class="topic-name">Земля и человечество</h3>
                            <span class="topic-status">4 урока</span>
                        </div>
                        
                        <div class="lessons-list">
                            <div class="lessons-list-inner"> <a href="#" class="lesson-link">
                                    <div class="lesson-marker-orange"></div>
                                    <span>Мир глазами астронома</span>
                                </a>
                                <a href="#" class="lesson-link">
                                    <div class="lesson-marker-orange"></div>
                                    <span>Планета на бумаге</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">📂</div>
            <h3>Контент в разработке</h3>
            <p>Мы еще готовим материалы по этому предмету. Загляните позже!</p>
        </div>
    <?php endif; ?>
</main>
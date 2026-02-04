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
            <a href="/dashboard" class="class-pill">Все</a>
            <a href="/dashboard?class=12" class="class-pill">1-4 класс</a>
            <a href="/dashboard?class=13" class="class-pill">5-9 класс</a>
            <a href="/dashboard?class=14" class="class-pill">10-11 класс</a>
        </nav>
        <?php if(isset($grades)): ?>
            <nav class="classes-row">
                <?php foreach($grades as $id => $title): ?>
                    <a href="/dashboard?class=<?= htmlspecialchars($_GET['class'])?>&grade=<?= htmlspecialchars($id) ?>" class="class-pill <?= (isset($_GET['grade']) && $_GET['grade'] == $id) ? 'active' : '' ?>"><?= htmlspecialchars($title) ?></a>
                <?php endforeach?>
            </nav>
        <?php endif?>
    </main>
</header>

<?php if(isset($subjects)):?>
    <section class="subjects-grid">
        <?php foreach($subjects as $subject): ?>
            <a href="/subject-info?id=<?= htmlspecialchars($subject->id); ?>" class="subject-card">
                <img src="<?= htmlspecialchars($subject->image) ?>" alt="<?= htmlspecialchars($subject->image) ?>" referrerpolicy="no-referrer"> 
                <h2><?php echo htmlspecialchars($subject->name) ?></h2>
            </a>
        <?php endforeach; ?>
    </section>
<?php endif?>
<div class="landing-page">

    <header class="landing-header">
        <div class="logo">
            <img src="assets/logo.png" alt="Царская Академия" class="logo-img">
            <h1>Царская Академия</h1>
        </div>
        <nav class="auth-nav">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="/dashboard" class="nav-btn nav-btn--special">В личный кабинет</a>
            <?php else: ?>
                <a href="/registration" class="nav-btn">Вход</a>
                <a href="/registration" class="nav-btn nav-btn--special">Регистрация</a>
            <?php endif; ?>
        </nav>
    </header>

    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Образование, достойное <span class="highlight">царей</span></h1>
            <p class="hero-subtitle">Индивидуальный подход, современные методики и база знаний для учеников 1-11 классов.</p>
            <div class="hero-actions">
                <a href="/dashboard" class="search-button">Начать обучение</a>
            </div>
        </div>
    </section>

    <section class="features-row">
        <div class="feature-item"> 
            <h3>Доступ 24/7</h3>
        </div>
        <div class="feature-item">
            <h3>Проверка заданий</h3>
        </div>
        <div class="feature-item">
            <h3>Расширяющаяся библиотека курсов</h3>
        </div>
    </section>

    <section id="subjects" class="landing-subjects">
        <h2 class="section-title">Доступные курсы на данный момент</h2>
        
        <?php if(isset($subjects)): ?>
            <div class="subjects-grid-landing">
                <?php foreach($subjects as $subject): ?>
                    <a href="/registration" class="subject-card">
                        <img src="<?= htmlspecialchars($subject->image) ?>" alt="" referrerpolicy="no-referrer"> 
                        <h2><?= htmlspecialchars($subject->name) ?></h2>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>



</div>
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
                        <div class="topic-item" id="topic-<?= $topic->id ?>" data-topic-id="<?= $topic->id ?>">
                            <div class="topic-header" onclick="toggleTopic(this)">
                                <div class="topic-marker"></div>
                                <h3 class="topic-name"><?= htmlspecialchars($topic->name) ?></h3>
                                <span class="topic-status"><?= htmlspecialchars($topic->write_lessons_amount())?></span>
                            </div>
                        <?php if(!empty($topic->lessons)): ?>
                            <div class="lessons-list">
                                <div class="lessons-list-inner"> 
                                    <?php foreach($topic->lessons as $lesson): ?>
                                        <a href="/lesson&id=<?= $lesson->id?>" class="lesson-link">
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
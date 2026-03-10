<main class="search-page">
    <div class="search-container">
        <nav class="search-tabs">
            <a href="?type=subject" class="tab <?= $type === 'subject' ? 'active' : '' ?>">Курсы</a>
            <a href="?type=topic" class="tab <?= $type === 'topic' ? 'active' : '' ?>">Темы</a>
            <a href="?type=lesson" class="tab <?= $type === 'lesson' ? 'active' : '' ?>">Уроки</a>
            <a href="?type=media" class="tab <?= $type === 'media' ? 'active' : '' ?>">Медиа</a>
        </nav>

        <div class="search-results" id="results-container">
            <?php if (empty($result)): ?>
                <div class="search-placeholder">
                    <img src="/assets/placeholder.png" alt="Пусто" class="placeholder-image" referrerpolicy="no-referrer">
                    <h2 class="placeholder-text">По вашему запросу ничего не найдено</h2>
                </div>
            <?php else: ?>
                <?php foreach ($result as $item): ?>
                    
                    <?php if ($type === 'subject'): ?>
                        <div class="result-item result-item--with-image">
                            <div class="result-item__image-container">
                                <img src="<?= htmlspecialchars($item->image ?? '/assets/img/default.png') ?>" class="result-item__img" referrerpolicy="no-referrer">
                            </div>
                            <div class="result-item__content">
                                <h3 class="result-item__title"><?= htmlspecialchars($item->name) ?></h3>
                                <p class="result-item__desc"><?= htmlspecialchars($item->description ?? '') ?></p>
                                <a href="/subject-info?id=<?= $item->id ?>" class="result-item__link">Перейти к предмету</a>
                            </div>
                        </div>

                    <?php elseif ($type === 'topic'): ?>
                        <div class="result-item">
                            <div class="result-item__content">
                                <h3 class="result-item__title"><?= htmlspecialchars($item->name) ?></h3>
                                <span class="result-item__subtitle">Предмет: <?= htmlspecialchars($item->subject_title ?? 'Не указан') ?></span>
                                <p class="result-item__desc"><?= htmlspecialchars($item->description ?? '') ?></p>
                                <a href="/subject-info?id=<?= $item->parent_id ?>&topic_id=<?= $item->id ?>#topic-<?= $item->id ?>" class="result-item__link">Смотреть тему</a>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="result-item">
                            <div class="result-item__content">
                                <h3 class="result-item__title"><?= htmlspecialchars($item->name ?? $item->title ?? "Без названия") ?></h3>
                                <p class="result-item__desc"><?= htmlspecialchars($item->description ?? '') ?></p>
                                <p class="result-item__subtitle">Тема: <?= htmlspecialchars($item->topic_title ?? 'Не указан') ?></p>
                                <a href="/lesson?id=<?= $item->id ?>" class="result-item__link">Открыть</a>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>
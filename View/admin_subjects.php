<div class="bo-body">
    <?php require_once __DIR__ . "/subject_list.php"; 
    if(isset($current)):?>
    <div style="width: 80%;">
        <div class="subject-container">
            <header class="subject-header-hero">
                <div class="subject-cover">
                    <img src="<?= htmlspecialchars($current->image) ?>" alt="Cover" referrerpolicy="no-referrer">
                </div>

                <div class="subject-details">
                    <span class="badge">ПРЕДМЕТ</span>
                    <h1 class="subject-title"><?= htmlspecialchars($current->name) ?></h1>
                    
                    <div class="subject-description">
                        <p><?= $current->description ? htmlspecialchars($current->description) : '' ?></p>
                    </div>

                    <div class="subject-stats">
                        <div class="stat-item">
                            <span class="stat-value">0</span>
                            <span class="stat-label">записались</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-value">0</span>
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
                                    <div class="lessons-list">
                                        <div class="lessons-list-inner"> 
                                            <?php if(!empty($topic->lessons)): ?>
                                                <?php foreach($topic->lessons as $lesson): ?>
                                                    <a href="/lesson&id=<?= $lesson->id?>" class="lesson-link">
                                                        <div class="lesson-marker-orange"></div>
                                                        <span><?= htmlspecialchars($lesson->name)?></span>
                                                    </a>
                                                <?php endforeach?>
                                            <?php endif?>
                                            <a class="lesson-link new-lesson-row" style="display: none;">
                                                <div class="lesson-marker-orange"></div>
                                                <h3 class="topic-name">
                                                <input type="text" 
                                                    name="name"
                                                    class="ajax-empty admin-edit-input" 
                                                    data-table="lessons" 
                                                    data-parent-column="topic_id"
                                                    data-parent-id="<?= htmlspecialchars($topic->id) ?>"
                                                    placeholder="Название нового урока...">
                                            </h3>
                                            </a>
                                            <button onclick="showNewLessonRow(this)" class="add" data-action="add-lesson">
                                                <img src="/assets/plus.svg" alt="">
                                            </button>
                                        </div>
                                        
                                    </div>
                                </div>
                            <?php endforeach ?>
                            <div class="topic-item new-topic-row" style="display: none;">
                                <div class="topic-header">
                                    <div class="topic-marker"></div>
                                    <h3 class="topic-name">
                                        <input type="text" 
                                            name="name"
                                            class="ajax-empty admin-edit-input" 
                                            data-table="topics" 
                                            data-parent-column="subject_id"
                                            data-parent-id="<?= htmlspecialchars($current->id) ?>"
                                            placeholder="Название новой темы...">
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <button onclick="showNewRow('.new-topic-row')" class="add" data-action="add-topic">
                            <img src="/assets/plus.svg" alt="">
                        </button>
                    </section>
                </div>
            <?php endif; ?>
            
        </main>
    </div>
    <?php endif?>
</div>

<div id="context-menu" class="context-menu">
    <ul>
        <li id="cm-delete" class="cm-danger">Удалить</li>
    </ul>
</div>
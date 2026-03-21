<div class="subjects-list-container">
    <?php foreach($subjects as $subject): ?>
        <a href="<?= '?id=' . htmlspecialchars($subject->id) ?>">
            <div class="subject-card">
                <img src="<?= htmlspecialchars($subject->image) ?>" 
                        alt="Название предмета" 
                        referrerpolicy="no-referrer"
                        class="subject-img">
                <h3 class="subject-title-list"><?= htmlspecialchars($subject->name) ?></h3>
            </div>
        </a>
    <?php endforeach?>

    <div class="add" data-action="add-subject">
        <img src="/assets/plus.svg" alt="">
    </div>

</div>
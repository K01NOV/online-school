<?php if(!isset($_SESSION['name'])){header("Location: /registration"); exit(); } ?>

<?php if(isset($subjects)):?>
    <section class="subjects-grid">
        <?php foreach($subjects as $subject): ?>
            <?php 
                $link = '/subject-info?id=' . urlencode($subject->id);
                $link .= isset($_GET['class']) ? '&class=' . urlencode($_GET['class']) : ''; 
                $link .= isset($_GET['grade']) ? '&grade=' . urlencode($_GET['grade']) : ''; 
            ?>
            <a href="<?= htmlspecialchars($link)?>" class="subject-card">
                <img src="<?= htmlspecialchars($subject->image) ?>" alt="<?= htmlspecialchars($subject->image) ?>" referrerpolicy="no-referrer"> 
                <h2><?php echo htmlspecialchars($subject->name) ?></h2>
            </a>
        <?php endforeach; ?>
    </section>
<?php endif?>
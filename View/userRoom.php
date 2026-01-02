<?php if(isset($_SESSION['name'])): ?>
    <h1>Hello, <?php echo htmlspecialchars($name)?></h1>
<?php else: ?>
    <h1>Ошибка: Имя пользователя не получено</h1>
<?php endif; ?>
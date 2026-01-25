<?php if(!isset($_SESSION['name'])){header("Location: /registration"); exit(); } ?>
<h1>Hello, <?php echo htmlspecialchars($_SESSION['name'])?></h1>
<form action="/logout" method="POST">
    <button type="submit">Выйти</button>
</form>
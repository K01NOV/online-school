<?php if(!isset($_SESSION['name'])){header("Location: /registration"); exit(); } ?>
<h1>Hello, <?php echo htmlspecialchars($name)?></h1>
<?php if(!isset($_SESSION['name'])){header("Location: /registration"); exit(); } ?>
<?php require_once __DIR__ . "/miniProfile.php"; ?>
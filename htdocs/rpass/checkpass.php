<?php
require ("PasswordHash.php"); 
$pwhash = new PasswordHash(8, false);
$result = $pwhash->CheckPassword($_POST['input'], $_POST['hash']) ? "1" : "0"
?>
<?= $result ?>

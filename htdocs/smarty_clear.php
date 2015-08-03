<?php
require('Smarty.class.php');
$smarty = new Smarty;

$smarty->caching = 1;

// clear only cache for index.tpl
//$smarty->clear_cache('index.tpl');

// clear out all cache files
$smarty->clear_all_cache();

//$smarty->display('index.tpl');
?>

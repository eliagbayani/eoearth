<?php 
include_once(dirname(__FILE__) . "/../config/settings.php");

// /*
$params =& $_GET;
if(!$params) $params =& $_POST;
// */

include_once(dirname(__FILE__) . "/../../../LiteratureEditor/Custom/lib/Functions.php");
include_once(dirname(__FILE__) . "/../controllers/eoearth.php");

$ctrler = new eoearth_controller($params);
$ctrler->backup_uploads_today();
?>


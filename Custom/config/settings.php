<?php
session_start();
/*
session_start([
    'cookie_lifetime' => 86400,
    'read_and_close'  => true,
]);
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/New_York');

if(!defined('DOWNLOAD_WAIT_TIME')) define('DOWNLOAD_WAIT_TIME', '300000'); //.3 seconds
define('DOWNLOAD_ATTEMPTS', '2');
if(!defined('DOWNLOAD_TIMEOUT_SECONDS')) define('DOWNLOAD_TIMEOUT_SECONDS', '30');

define('MEDIAWIKI_MAIN_FOLDER', 'eoearth');

//let us borrow cach path from BHL Lit Editor project
define('CACHE_PATH', '/Volumes/MacMini_HD2/cache_LiteratureEditor/');    //for mac mini
// define('CACHE_PATH', '/var/www/html/cache_LiteratureEditor/');           //for archive

// define('DOMAIN_SERVER', 'editors.eol.localhost');                       //for mac mini
define('DOMAIN_SERVER', 'editors.eol.org');                              //for archive



define('BACKUP_FOLDER', '/Volumes/MacMini_HD2/cache_LiteratureEditor/eoearth_backup_uploads/');    //for mac mini
// define('BACKUP_FOLDER', '/var/www/html/cache_LiteratureEditor/eoearth_backup_uploads/');           //for archive



?>

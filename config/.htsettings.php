<?php
//=== for archive ===
// /*
$conf['wgServer']           = "https://editors.eol.org";

// database
$conf['wgDBuser']           = "root";
$conf['wgDBpassword']       = "-secret-";

// cache
$conf['wgMainCacheType']    = CACHE_ACCEL;
$conf['wgMemCachedServers'] = array();

// images
$conf['images_folder']      = "/var/www/html/eoearth_images";
$conf['wgUploadDirectory']  = $conf['images_folder'];               //where MediaWiki uploades images
$conf['wgUploadPath']       = "/eoearth_images";                    //where MediaWiki views images
$conf['wgDeletedDirectory'] = $conf['images_folder']."/deleted";
$conf['wgTmpDirectory']     = $conf['images_folder']."/temp";

// ImageMagick
$conf['wgUseImageMagick']               = true;
$conf['wgImageMagickConvertCommand']    = "/usr/bin/convert";
// */

//==========================================================================

//=== for mac mini ===
/*
$conf['wgServer']       = "http://editors.eol.localhost";

// database
$conf['wgDBuser']       = "root";
$conf['wgDBpassword']   = "m173";

// cache
$conf['wgMainCacheType']    = CACHE_DB; //CACHE_DB or CACHE_MEMCACHED; ---- CACHE_ACCEL should work OK locally and in eol-archive. MW 1.26.2 and in PHP 5.6.30 & PHP 5.4.16
//as of Sep 21, 2017 CACHE_DB is the one that works :-)
$conf['wgMemCachedServers'] = array();     //array( '127.0.0.1:11211' );  ---- array()     should work OK locally and in eol-archive  MW 1.26.2 and in PHP 5.6.30 & PHP 5.4.16

// images
$conf['images_folder']      = "/Library/WebServer/Documents/eoearth_images";
$conf['wgUploadDirectory']  = $conf['images_folder'];                           //where MediaWiki uploades images
$conf['wgUploadPath']       = "/eoearth_images";    //where MediaWiki views images
$conf['wgDeletedDirectory'] = $conf['images_folder']."/deleted";
$conf['wgTmpDirectory']     = $conf['images_folder']."/temp";

// ImageMagick
$conf['wgUseImageMagick']               = true;
$conf['wgImageMagickConvertCommand']    = "/usr/local/bin/convert";
*/
?>
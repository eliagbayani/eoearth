<?php
//=== for archive ===
// /*
$conf['wgServer']           = "http://editors.eol.org";

// database
$conf['wgDBuser']           = "root";
$conf['wgDBpassword']       = "m173!XAbc*";

// cache
$conf['wgMainCacheType']    = CACHE_ACCEL;
$conf['wgMemCachedServers'] = array();

// images
$conf['images_folder']      = "/var/www/html/eoearth_images";
$conf['wgUploadDirectory']  = $images_folder;               //where MediaWiki uploades images
$conf['wgUploadPath']       = "/eoearth_images";            //where MediaWiki views images
$conf['wgDeletedDirectory'] = "$images_folder/deleted";
$conf['wgTmpDirectory']     = "$images_folder/temp";

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
$conf['wgMainCacheType']    = CACHE_MEMCACHED;
$conf['wgMemCachedServers'] = array( '127.0.0.1:11211' );

// images
$conf['images_folder']      = $IP . "_images";
$conf['wgUploadDirectory']  = $conf['images_folder'];               //where MediaWiki uploades images
$conf['wgUploadPath']       = $wgScriptPath . "_images";            //where MediaWiki views images
$conf['wgDeletedDirectory'] = $conf['images_folder']."/deleted";
$conf['wgTmpDirectory']     = $conf['images_folder']."/temp";

// ImageMagick
$conf['wgUseImageMagick']               = true;
$conf['wgImageMagickConvertCommand']    = "/usr/local/bin/convert";
*/
?>
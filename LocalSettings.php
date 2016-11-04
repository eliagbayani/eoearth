<?php
# This file was automatically generated by the MediaWiki 1.26.2
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
    exit;
}

// start by eli =====================
// Define constants for my additional namespaces.
/*
define("NS_ForReview", 5000); // This MUST be even.
define("NS_ForReview_TALK", 5001); // This MUST be the following odd integer.
$wgExtraNamespaces[NS_ForReview]      = "ForReview";
$wgExtraNamespaces[NS_ForReview_TALK] = "ForReview_talk"; // Note underscores in the namespace name.
*/
// end by eli =====================


## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = "The Encyclopedia of Earth";
$wgMetaNamespace = "Project";

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "/eoearth"; // $wgScriptPath = "/w";
$wgArticlePath = "/eoearth/wiki/$1";
$wgScriptExtension = ".php";

require_once("config/.htsettings.php");

## The protocol and server name to use in fully-qualified URLs
$wgServer = $conf['wgServer']; //"http://localhost";

## The relative URL path to the skins directory
$wgStylePath = "$wgScriptPath/skins";
$wgResourceBasePath = $wgScriptPath;

## The URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
// $wgLogo = "$wgResourceBasePath/resources/assets/wiki.png";
// $wgLogo = "$wgResourceBasePath/images/three_balls.png";
// $wgLogo = "$wgResourceBasePath/resources/assets/eol black bg.png";
$wgLogo = "$wgResourceBasePath/resources/assets/EoE_logo_white_bg.png";
$wgLogo = "$wgResourceBasePath/resources/assets/EoE version 5 (2).jpg";

## UPO means: this is also a user preference option

## Database settings
$wgDBtype       = "mysql";
$wgDBserver     = "localhost";
$wgDBname       = "wiki_eoearth"; //"wiki_eoearth_126";

$wgDBuser       = $conf['wgDBuser'];//"root";
$wgDBpassword   = $conf['wgDBpassword'];//"m173";

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Experimental charset support for MySQL 5.0.
$wgDBmysql5 = false;

## Shared memory settings

$wgMainCacheType = $conf['wgMainCacheType']; //CACHE_ACCEL;
$wgMemCachedServers = $conf['wgMemCachedServers']; //array();

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick               = $conf['wgUseImageMagick']; //true;
$wgImageMagickConvertCommand    = $conf['wgImageMagickConvertCommand']; //"/usr/local/bin/convert";

// change images folder:
// orig is     : /Library/WebServer/Documents/LiteratureEditor/images
// changed to  : /Library/WebServer/Documents/LiteratureEditor_images

$images_folder      = $conf['images_folder'];
$wgUploadDirectory  = $conf['wgUploadDirectory'];   //where MediaWiki uploades images
$wgUploadPath       = $conf['wgUploadPath'];        //where MediaWiki views images
$wgDeletedDirectory = $conf['wgDeletedDirectory'];
$wgTmpDirectory     = $conf['wgTmpDirectory'];



// 2. Setup in Apache vhosts file, inside <VirtualHost *:80></VirtualHost>
// Alias /LiteratureEditor/images/    "/Library/WebServer/Documents/LiteratureEditor_images/"


///////////////////////

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "en_US.UTF-8";

## If you want to use image uploads under safe mode,
## create the directories images/archive, images/thumb and
## images/temp, and make them all writable. Then uncomment
## this, if it's not already uncommented:
#$wgHashedUploadDirectory = false;

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
#$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/Names.php
$wgLanguageCode = "en";

$wgSecretKey = "1562dc2eff071446356db8f277980f2cf86266b49ac4fb56b562e04a20a8d932";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = "bbfa264cac2065d8";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "https://creativecommons.org/licenses/by-sa/3.0/";
$wgRightsText = "Creative Commons Attribution-ShareAlike";
$wgRightsIcon = "$wgResourceBasePath/resources/assets/licenses/cc-by-sa.png";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

# The following permissions were set based on your choice in the installer
    //initialize false rights
    $rights = array('createaccount', 'createpage', 'edit', 'move', 'writeapi', 'upload', 'changetags', 'applychangetags', 'minoredit', 'move-categorypages', 'movefile', 'move', 'move-subpages', 'move-rootuserpages', 'reupload-shared', 'reupload', 'purge', 'sendemail');
    foreach(array('*', 'user') as $eoe_user)
    {
        foreach($rights as $right) $wgGroupPermissions[$eoe_user][$right] = false;
    }
    //initialize allowed rights
    $rights = array('read', 'createtalk', 'editmyoptions', 'editmyprivateinfo', 'editmyusercss', 'editmyuserjs', 'editmywatchlist', 'viewmyprivateinfo', 'viewmywatchlist');
    foreach(array('EoE_Member', 'EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor') as $eoe_user)
    {
        foreach($rights as $right) $wgGroupPermissions[$eoe_user][$right] = true;
    }
    //initialize basic rights
    $rights = array('createpage', 'edit', 'delete', 'undelete', 'upload', 'sendemail', 'writeapi');
    foreach(array('EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor') as $eoe_user)
    {
        foreach($rights as $right) $wgGroupPermissions[$eoe_user][$right] = true;
    }
    //initialize special rights
    $rights = array('createaccount', 'userrights', 'move', 'suppressredirect', 'confirmaccount', 'sendbatchemail');
    foreach(array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor') as $eoe_user)
    {
        foreach($rights as $right) $wgGroupPermissions[$eoe_user][$right] = true;
    }

    /*
    Member          - can only post comments after an article.
    Author          - can create articles and edit other articles. None of this work becomes public until....
    Topic Editor    - approves work by an author so can click the Publish button to make the article public; has authority to edit and publish there own work; can approve an application for someone who wants to be an author, 
    though this might need someone higher to carry it out.
    Administrator   - can do almost anything - all the items from Topic Editor; change the status of anyone to anything except Managing Editor; change the structure of the site - 
        such as adding topics and managing the rotating photos.
    Managing Editor - can do anything, including emailing anyone and everyone.

    A member of the public can request to be a member, but the application needs to be approved.
    Usually the managing editor did the approving and setting up the account. I am not sure if others can approve, but I would expect that they could.
    This is also the case for a member being moved up to an author.

    EoE groups:
        Managing Editor
        Administrator
        Topic Editor
        Author
        Member

    MediaWiki default groups
        administrator   
        bureaucrat      
        user            
    */


## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin( 'CologneBlue' );
wfLoadSkin( 'Modern' );
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'Vector' );


# Enabled Extensions. Most extensions are enabled by including the base extension file here
# but check specific extension documentation for more details
# The following extensions were automatically enabled:
wfLoadExtension( 'Cite' );
wfLoadExtension( 'CiteThisPage' );
wfLoadExtension( 'ConfirmEdit' );
wfLoadExtension( 'Gadgets' );
wfLoadExtension( 'ImageMap' );
wfLoadExtension( 'InputBox' );
wfLoadExtension( 'Interwiki' );
wfLoadExtension( 'LocalisationUpdate' );
wfLoadExtension( 'Nuke' );
wfLoadExtension( 'ParserFunctions' );
wfLoadExtension( 'PdfHandler' );
wfLoadExtension( 'Poem' );
wfLoadExtension( 'Renameuser' );
wfLoadExtension( 'SpamBlacklist' );
wfLoadExtension( 'SyntaxHighlight_GeSHi' );
wfLoadExtension( 'TitleBlacklist' );
wfLoadExtension( 'WikiEditor' );
//added later on
require_once "$IP/extensions/CreatePage/CreatePage.php";            //downloaded 1.26 ver.
require_once "$IP/extensions/Lockdown/Lockdown.php";                //downloaded 1.26 ver.
require_once("$IP/extensions/TalkRight/TalkRight.php");             //DONE[***] ver 1.5.1 -> This makes EoE_Member write to Talk/Discussion pages but readonly to regular pages
require_once "$IP/extensions/ConfirmAccount/ConfirmAccount.php";    //downloaded 1.26 ver.
require_once("$IP/extensions/EmailUsers/EmailUsers.php");           //DONE[***] copied from MW 1.25.2
wfLoadExtension( 'EmbedVideo' );                                    //DONE[***] copied from MW 1.25.2

/* seems not needed
$wgEnableAPI = true;
$wgEnableWriteAPI = true; //are required in order to use the write API.
*/

//===================DeleteHistory===================================
$wgGroupPermissions['sysop']['DeleteHistory'] = true;
require_once("$IP/extensions/DeleteHistory/DeleteHistory.php");
//===================VisualEditor===================================
require_once "$IP/extensions/VisualEditor/VisualEditor.php";

// Enable by default for everybody
$wgDefaultUserOptions['visualeditor-enable'] = 1;

// Don't allow users to disable it
$wgHiddenPrefs[] = 'visualeditor-enable';

// OPTIONAL: Enable VisualEditor's experimental code features
#$wgDefaultUserOptions['visualeditor-enable-experimental'] = 1;

/*seems not needed
//from: https://www.mediawiki.org/wiki/Thread:Extension_talk:VisualEditor/Enable_Visual_Editor_for_'create'_page
$wgVisualEditorNamespaces = array(NS_MAIN, NS_TALK, NS_USER, NS_USER_TALK, NS_ForReview, NS_ForReview_TALK);
*/

$wgContentNamespaces[] = NS_TEMPLATE; //this adds the Template namespace in VisualEditor
$wgContentNamespaces[] = NS_TEMPLATE_TALK; //this adds this namespace in VisualEditor

///* not needed on mac mini
$wgVirtualRestConfig['modules']['parsoid'] = array(
  // URL to the Parsoid instance
  // Use port 8142 if you use the Debian package
  'url' => 'http://127.0.0.1:8000',
  // Parsoid "domain", see below (optional)
  'domain' => 'localhost',
  // Parsoid "prefix", see below (optional)
  'prefix' => 'eoearth'
);
//*/
// echo "<br>wgCanonicalServer: [$wgCanonicalServer]<br>"; exit;

/* https://www.mediawiki.org/wiki/User:Andru~mediawikiwiki/Allow_Parsoid_Server
if ( $_SERVER['REMOTE_ADDR'] == '127.0.0.1' ) {
 $wgGroupPermissions['*']['read'] = true;
 $wgGroupPermissions['*']['edit'] = true;
}
*/
//==================================================================

require_once "$IP/extensions/UserFunctions/UserFunctions.php";      //added 10-Oct-2016

//================================================= UserFunctions: https://www.mediawiki.org/wiki/Extension:UserFunctions
$wgUFEnablePersonalDataFunctions = true;
$wgUFAllowedNamespaces = array(NS_MAIN => true, NS_USER => true);
// $wgUFEnableSpecialContexts = false;
//================================================= 


# End of automatically generated settings.
# Add more configuration options below.

$wgFileExtensions = array_merge($wgFileExtensions, explode(" ", "pdf xls xlsx csv txt doc png ppt pptx ods jp2 webp PDF XLS XLSX CSV TXT DOC PNG PPT PPTX ODS JP2 WEBP svg png jpg jpeg gif bmp SVG PNG JPG JPEG GIF BMP")); //e.g. array('txt', 'pdf', 'doc') by Eli
$wgFileExtensions = array_unique($wgFileExtensions); 
// print_r($wgFileExtensions);exit;

//================================================= The Encyclopedia of Earth
/* for mac mini
$wgSMTP = array('host'      => 'ssl://smtp.gmail.com',
                'IDHost'    => 'gmail.com',
                'port'      => 465,
                'username'  => 'eagbayanieol@gmail.com',
                'password'  => 'erjaeol1309',
                'auth'      => true);
*/

$wgEmailAuthentication  = true;
$wgEnableEmail          = true;
$wgAllowHTMLEmail       = true;
$wgEnableUserEmail      = true; # UPO
$wgEmergencyContact     = "hammockj@si.edu";
$wgPasswordSender       = "hammockj@si.edu";
$wgEnotifUserTalk       = true; # UPO
$wgEnotifWatchlist      = true; # UPO


// echo "\n" . $( '#t-emailuser' ).length ? true : false;
//=================================================

//from CreatePage
$wgCreatePageEditExisting = true;
$wgCreatePageUseVisualEditor = true;
//=================================================

//from TalkRight
$wgGroupPermissions['EoE_Member']['talk']           = true;
$wgGroupPermissions['EoE_Author']['talk']           = true;
$wgGroupPermissions['EoE_Topic_Editor']['talk']     = true;
$wgGroupPermissions['EoE_Administrator']['talk']    = true;
$wgGroupPermissions['EoE_Managing_Editor']['talk']  = true;

//=================================================

//from Lockdown
// Add namespaces.

$wgSpecialPageLockdown['*']         = array('EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgSpecialPageLockdown['BlockList'] = array('EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgSpecialPageLockdown['Export']    = array('EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');

/*
$wgNamespacePermissionLockdown[NS_ForReview]['*']      = array('EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_ForReview_TALK]['*'] = array('EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
*/

//so that public won't see articles in Template namespace, or those for review articles
$wgNamespacePermissionLockdown[NS_TEMPLATE]['*']      = array('EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_TEMPLATE_TALK]['*'] = array('EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');

$spaces = array(NS_TEMPLATE, NS_TEMPLATE_TALK);
foreach($spaces as $space)
{
    $wgNamespacePermissionLockdown[$space]['edit']         = array('EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
    $wgNamespacePermissionLockdown[$space]['createpage']   = array('EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
    $wgNamespacePermissionLockdown[$space]['delete']       = array('EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
    $wgNamespacePermissionLockdown[$space]['undelete']     = array('EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
}

/* To modify NS_MEDIAWIKI & NS_MEDIAWIKI_TALK user must be both 'administrator' and 'EoE_Administrator' */
$spaces = array(NS_MEDIAWIKI, NS_MEDIAWIKI_TALK);
foreach($spaces as $space)
{
    $wgNamespacePermissionLockdown[$space]['edit']         = array('EoE_Administrator');
    $wgNamespacePermissionLockdown[$space]['createpage']   = array('EoE_Administrator');
    $wgNamespacePermissionLockdown[$space]['delete']       = array(''); //no one can delete
    $wgNamespacePermissionLockdown[$space]['undelete']     = array(''); //no one can undelete
    $wgNamespacePermissionLockdown[$space]['move']         = array(''); //no one can move
}

$wgNamespacePermissionLockdown[NS_MAIN]['edit']         = array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_MAIN]['createpage']   = array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_MAIN]['delete']       = array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_MAIN]['undelete']     = array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');

$wgNamespacePermissionLockdown[NS_PROJECT]['edit']         = array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_PROJECT]['createpage']   = array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_PROJECT]['delete']       = array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_PROJECT]['undelete']     = array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');

$wgNamespacePermissionLockdown[NS_TALK]['edit']         = array('EoE_Member', 'EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_TALK]['createpage']   = array('EoE_Member', 'EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_TALK]['delete']       = array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_TALK]['undelete']     = array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');

$wgNamespacePermissionLockdown[NS_USER]['edit']         = array('EoE_Member', 'EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_USER]['createpage']   = array('EoE_Member', 'EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_USER]['delete']       = array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
$wgNamespacePermissionLockdown[NS_USER]['undelete']     = array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');

/*
for($i=0; $i<16; $i++)
{
    $wgNamespacePermissionLockdown[$i]['edit']         = array('EoE_Topic_Editor');
    $wgNamespacePermissionLockdown[$i]['createpage']   = array('EoE_Topic_Editor');
    $wgNamespacePermissionLockdown[$i]['delete']       = array('EoE_Topic_Editor');
    $wgNamespacePermissionLockdown[$i]['undelete']     = array('EoE_Topic_Editor');
}
*/

// $wgNamespacePermissionLockdown[NS_SPECIAL]['read'] = array('EoE_Author', 'EoE_Topic_Editor'); --- this is not working...


/* Respective index numbers for the different Namespaces:
0                   NS_MAIN
1   Talk:           NS_TALK
2   User:           NS_USER
3   User_Talk:      NS_USER_TALK
4   Project:        NS_PROJECT
5   Project_Talk:   NS_PROJECT_TALK
6   File:           NS_FILE
7   File_Talk:      NS_FILE_TALK
8   MediaWiki:      NS_MEDIAWIKI
9   MediaWiki_Talk: NS_MEDIAWIKI_TALK
10  Template:       NS_TEMPLATE
11  Template_Talk:  NS_TEMPLATE_TALK
12  Help:           NS_HELP
13  Help_Talk:      NS_HELP_TALK
14  Category:       NS_CATEGORY
15  Category_Talk:  NS_CATEGORY_TALK
*/

//=================================================

//from ConfirmAccount

//set to minimun requirements:
$wgMakeUserPageFromBio = false;
$wgAutoWelcomeNewUsers = false;
$wgConfirmAccountRequestFormItems = array(  'UserName'        => array( 'enabled' => true ),
                                            'RealName'        => array( 'enabled' => true ),
                                            'Biography'       => array( 'enabled' => false, 'minWords' => 0 ),
                                            'AreasOfInterest' => array( 'enabled' => true ),
                                            'CV'              => array( 'enabled' => false ),
                                            'Notes'           => array( 'enabled' => true ),
                                            'Links'           => array( 'enabled' => false ),
                                            'TermsOfService'  => array( 'enabled' => true ));


$wgConfirmAccountRequestFormItems['Biography']['minWords'] = 0;
// $wgGroupPermissions['sysop']['createaccount'] = false; //do this to disable sysop from creating accounts
$wgConfirmAccountContact = 'hammockj@si.edu'; // a beaurocrat or EoE_Topic_Editor or EoE_Managing_Editor


//all these folders must have write permissions

$wgFileStore['accountreqs']['directory']       = "$IP/images/accountreqs";
$wgFileStore['accountreqs']['url'] = null; 
$wgFileStore['accountreqs']['hash'] = 3;

$wgFileStore['accountcreds']['directory']       = "$IP/images/accountcreds";
$wgFileStore['accountcreds']['url'] = null; 
$wgFileStore['accountcreds']['hash'] = 3;

$wgFileStore['deleted']['directory'] = "$IP/images/imagesDeleted";
$wgFileStore['deleted']['url'] = null; 
$wgFileStore['deleted']['hash'] = 3;


$wgAccountRequestThrottle  = 100;
//=================================================
//WikiEditor settings
# Enables use of WikiEditor by default but still allows users to disable it in preferences
$wgDefaultUserOptions['usebetatoolbar'] = 1;

# Enables link and table wizards by default but still allows users to disable them in preferences
$wgDefaultUserOptions['usebetatoolbar-cgd'] = 1;

# Displays the Preview and Changes tabs
$wgDefaultUserOptions['wikieditor-preview'] = 1;

# Displays the Publish and Cancel buttons on the top right side
$wgDefaultUserOptions['wikieditor-publish'] = 0;

//================================================
// $wgSpamBlacklistFiles = array(
//    "[[m:Spam blacklist]]",
//    "https://en.wikipedia.org/wiki/MediaWiki:Spam-blacklist"
// );
// print_r($wgSpamBlacklistFiles);


//================================================ from extension EmailUsers
/*
Configuration parameters

$wgEmailUsersMaxRecipients  : Defines the max number of recipients
$wgEmailUsersUseJobQueue    : Use Manual:Job queue when sending mails
User rights
    sendbatchemail
    Allows users to use this extension. General rights for sending mails is also required.
*/
$wgEmailUsersMaxRecipients  = 5;    //: Defines the max number of recipients
$wgEmailUsersUseJobQueue = true;    //: Use Manual:Job queue when sending mails

//================================================
/* display debug info
error_reporting( -1 );
ini_set( 'display_errors', 1 );

    $wgShowExceptionDetails = true;
    $wgDebugToolbar = true;
    $wgShowDebug = true;
    $wgDevelopmentWarnings = true;
*/
$wgShowIPinHeader = false;
//================================================ history
//added 2016 May 14
//$wgActionLockdown['history'] = array('user'); //only logged-in users can view history - working but used below instead
$wgActionLockdown['history']              = array('EoE_Author', 'EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor');
//$wgNamespacePermissionLockdown[*]['move'] = array('EoE_Topic_Editor', 'EoE_Administrator', 'EoE_Managing_Editor'); - this caused probs.
//================================================ Footer maintenance: https://www.mediawiki.org/wiki/Manual:Footer
/* Just FYI: when editing MediaWiki:Aboutsite, you'll get this:
About {{SITENAME}}
I then put a single dash "-" so link will not appear. Then just added abouttheeoe below, so it will appear last in footer links. */
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'lfTOSLink';
function lfTOSLink( $sk, &$tpl )
{
    $tpl->set( 'neutralitypolicy', $sk->footerLink( 'neutralitypolicy', 'neutralitypolicypage' ) );
    $tpl->data['footerlinks']['places'][] = 'neutralitypolicy';
    $tpl->set( 'termsofuse', $sk->footerLink( 'termsofuse', 'termsofusepage' ) );
    $tpl->data['footerlinks']['places'][] = 'termsofuse';
    $tpl->set( 'abouttheeoe', $sk->footerLink( 'abouttheeoe', 'abouttheeoepage' ) );
    $tpl->data['footerlinks']['places'][] = 'abouttheeoe';
    return true;
}
//==================================================
// $wgReadOnly = 'Upgrading to MediaWiki 1.26.2'; //uncomment this line everytime we upgrade to have database-readonly access.
//==================================================


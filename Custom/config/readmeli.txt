============================================================================================================
Uploaded files, (mostly images, spreadsheets, docs, .ppt, etc.) is now about 35 GB in size. We will use a script to backup these files.
Script will backup daily uploads. Then will use SCP to final backup destination.

Background: How the different files are saved:
- Main MediaWiki PHP files is saved through GitHub (done)
- MySQL database is saved through cron (daily) backup. Then use SCP to final backup destination. (done)
- Uploaded files (as described in this ticket).


Basically to process these uploads:
http://editors.eol.org/eoearth/index.php?title=Special:Log&type=upload&user=&page=&tagfilter=
another view is this:
http://editors.eol.org/eoearth/wiki/Special:NewFiles
http://editors.eol.org/eoearth/wiki/Special:NewFiles


Good way to get the exact path e.g.
http://editors.eol.org/eoearth/wiki/Special:Filepath/Pressure_altitude.jpg
-> based on https://www.mediawiki.org/wiki/Thread:Project:Support_desk/How_to_get_exact_image_path%3F/reply


Making use of the API log events:
https://www.mediawiki.org/wiki/API:Logevents

first:
http://editors.eol.org/eoearth/api.php?action=query&list=logevents&letype=upload&lelimit=1&rawcontinue

2nd:
get value of lecontinue (e.g. 20170105143921|27995), then pass it as "@lecontinue=20170105143921|27995"

http://editors.eol.org/eoearth/api.php?action=query&list=logevents&letype=upload&lelimit=1&rawcontinue&lecontinue=20170105143921|27995

and so on...
============================================================================================================
good source to sort filetime in php
-> based on http://stackoverflow.com/questions/11923235/scandir-to-sort-by-date-modified

function scan_dir($dir) {
    $ignored = array('.', '..', '.svn', '.htaccess');

    $files = array();    
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
    }

    arsort($files);
    $files = array_keys($files);
    
    return ($files) ? $files : false;
}
============================================================================================================
manual backup up wiki
https://www.mediawiki.org/wiki/Manual:Backing_up_a_wiki
https://github.com/nischayn22/mw_backup/blob/master/backup.php

============================================================================================================
============================================================================================================


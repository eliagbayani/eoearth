<?php
/* This will put redirect to applicable pages...

This is ran in command-line. Can be ran in two ways:
Note: in archive, we need to use: 
$ sudo php edit_wiki.php

1st: provide a title
$ php Custom/edit_wiki.php "Agriculture II"

2nd: will run many titles...
$ php Custom/edit_wiki.php
*/

/* for archive server (remote)
$GLOBALS['doc_root'] = "/var/www/html";                 //for archive
$GLOBALS['domain'] = "http://editors.eol.org";          //for archive
*/

// /* for mac mini (local)
$GLOBALS['doc_root'] = "/Library/WebServer/Documents";  //for mac mini
$GLOBALS['domain'] = "http://editors.eol.localhost";    //for mac mini
// */

if($title = @$argv[1]) {
    print_r($argv);
    process_title($title);
}
else { //will run many titles...
    process_one();
    // process_urls();
}
//========================================[start functions]========================================
function process_one() //you can use command line with interactive title like so: $ php Custom/edit_wiki.php "Agriculture II"
{
    $destination_title = "Black-footed penguin";
    $destination_title = "Scope &amp; Content";
    $destination_title = "Environment &amp; Security";
    $destination_title = "Black, Joseph";
    $destination_title = "Heaviside's dolphin";
    $destination_title = "Capitalism 3.0: Chapter 6";
    $destination_title = "United States";
    $destination_title = "Saddle-backed dolphin";
    $destination_title = "Hector's dolphin";
    $destination_title = "Rough-toothed dolphin";
    $destination_title = "Argentina";
    $destination_title = "Ecoregions (collection)";
    $destination_title = "Biodiversity"; //not found
    $destination_title = "Marine biodiversity"; //done
    $destination_title = "Côte d'Ivoire";
    process_title($destination_title);
}
function process_title($destination_title)
{
    $orig_title = $destination_title;                       echo "\norig: [$orig_title]\n";
    $destination_title = format_title($destination_title);  echo "\nformatted title: [$destination_title]\n";
    if($wiki_path = get_wiki_text($destination_title)) {    echo "\nwiki_path: [$wiki_path]\n"; 
        $wiki = file_get_contents($wiki_path);
        /* =<span>Argentina</span>= */
        $str = "=<span>$orig_title</span>=";
        if(stripos($wiki, $str) !== false) { //string is found
            echo "\nstring is found\n";
            $updated_wiki = str_replace($str, "", $wiki);
            // /*
            //start saving...
            $temp_write_file = $GLOBALS['doc_root'] . "/eoearth/Custom/temp/write.wiki";
            $handle = fopen($temp_write_file, "w"); 
            fwrite($handle, $updated_wiki); 
            fclose($handle);
            echo "\nsaving title: [$orig_title]...\n";   
            shell_exec("php " . $GLOBALS['doc_root'] . "/eoearth/maintenance/edit.php -m " . $destination_title . " < $temp_write_file");
            // */
        }
        else { // 2nd title will not be removed
            echo "\nstring NOT found\n";
        }
        
    }
    else echo("\nWiki not found... Next -> \n");
}
function process_urls()
{
    $url = $GLOBALS['domain'] . "/eoearth/wiki/Search_Results_for_Main_Topics";
    $html = file_get_contents($url);
    if(preg_match("/<div id=\"mw-content-text\" lang=\"en\" dir=\"ltr\" class=\"mw-content-ltr\">(.*?)<\/div>/ims", $html, $arr)) {
        //href="/eoearth/wiki/About_the_EoE_(search_results_for)"
        if(preg_match_all("/href=\"(.*?)\"/ims", $arr[1], $arr2)) { //23 urls
            // /* working but not being used anymore... decided to run these 23 urls one by one in archive... bec it will take time and better to run them one by one for manageability
            $urls = $arr2[1];
            // */
            
            // $urls = array("/eoearth/wiki/About_the_EoE_(search_results_for)");
            // $urls = array("/eoearth/wiki/Agricultural_%26_Resource_Economics_(search_results_for)");
            // $urls = array("/eoearth/wiki/Biodiversity_(search_results_for)");
            // $urls = array("/eoearth/wiki/Biology_(search_results_for)");
            // $urls = array("/eoearth/wiki/Climate_Change_(search_results_for)");
            // $urls = array("/eoearth/wiki/Ecology_(search_results_for)");
            // $urls = array("/eoearth/wiki/Environmental_%26_Earth_Science_(search_results_for)");
            // $urls = array("/eoearth/wiki/Energy_(search_results_for)");
            // $urls = array("/eoearth/wiki/Environmental_Law_%26_Policy_(search_results_for)");
            // $urls = array("/eoearth/wiki/Environmental_Humanities_(search_results_for)");
            // $urls = array("/eoearth/wiki/Food_(search_results_for)");
            // $urls = array("/eoearth/wiki/Forests_(search_results_for)");
            // $urls = array("/eoearth/wiki/Geography_(search_results_for)");
            // $urls = array("/eoearth/wiki/Hazards_%26_Disasters_(search_results_for)");
            // $urls = array("/eoearth/wiki/Health_(search_results_for)");
            // $urls = array("/eoearth/wiki/Mining_%26_Materials_(search_results_for)");
            // $urls = array("/eoearth/wiki/People_(search_results_for)");
            // $urls = array("/eoearth/wiki/Physics_%26_Chemistry_(search_results_for)");
            // $urls = array("/eoearth/wiki/Pollution_(search_results_for)");
            // $urls = array("/eoearth/wiki/Society_%26_Environment_(search_results_for)");
            // $urls = array("/eoearth/wiki/Water_(search_results_for)");
            // $urls = array("/eoearth/wiki/Weather_%26_Climate_(search_results_for)");
            // $urls = array("/eoearth/wiki/Wildlife_(search_results_for)");
            print_r($urls);

            foreach($urls as $url) {
                $html = file_get_contents($GLOBALS['domain'].$url);
                if(preg_match("/<title>(.*?) \(search results for\)/ims", $html, $arr3)) $titlex = "(".$arr3[1].")"; //the one in parenthesis "About the EoE" in (About the EoE)
                if(preg_match("/<div id=\"mw-content-text\" lang=\"en\" dir=\"ltr\" class=\"mw-content-ltr\">(.*?)<\/div>/ims", $html, $arr4)) {
                    // if(preg_match_all("/href=(.*?)<\/a>/ims", $arr4[1], $arr5)) //many urls
                    if(preg_match_all("/title=\"(.*?)\"/ims", $arr4[1], $arr5)) { //many urls
                        foreach($arr5[1] as $row) {
                            if(stripos($row, $titlex) !== false) {
                                echo "\n$row";
                                $row = trim(str_replace(" $titlex", "", $row));
                                echo " --- [$row]";

                                /* process_title($row); -- for some reason this does not work, thus using shell below which works */
                                echo "\n processing: [$row]\n";   shell_exec("php " . $GLOBALS['doc_root'] . "/eoearth/Custom/edit_wiki.php " . "\"$row\"");
                            }
                        }
                    }
                }
                // break; //debug
            }
        }
    }
}
function get_wiki_text($title)
{
    $temp_wiki_file = $GLOBALS['doc_root'] . "/eoearth/Custom/temp/temp.wiki";
    $handle = fopen($temp_wiki_file, "w"); fclose($handle); //initialize temp wiki
    clearstatcache(); //important additon, a function to clear the information that PHP caches about a file.
    echo "\n reading title: [$title]\n";  shell_exec("php " . $GLOBALS['doc_root'] . "/eoearth/maintenance/getText.php " . $title . " > $temp_wiki_file");
    if(filesize($temp_wiki_file)) return $temp_wiki_file;
    else {
        // echo("\nnot valid title or does not exist [$title]");
        // echo "\nfilesize[$temp_wiki_file]: " . filesize($temp_wiki_file) . "\n";
        return false;
    }
}
function format_title($title)
{
    $title = str_replace(" ", "_", $title);
    $title = str_replace("&amp;", "\&", $title);
    $title = str_replace("(", "\(", $title);
    $title = str_replace(")", "\)", $title);
    $title = str_replace("'", "\'", $title);
    return $title;
}

/*
function get_search_titles()
{
    $search_titles = array(
    "About_the_EoE_\(search_results_for\)",
    "Agricultural_\&_Resource_Economics_\(search_results_for\)",
    "Biodiversity_\(search_results_for\)",
    "Biology_\(search_results_for\)",
    "Climate_Change_\(search_results_for\)",
    "Ecology_\(search_results_for\)",
    "Environmental_\&_Earth_Science_\(search_results_for\)",
    "Energy_\(search_results_for\)",
    "Environmental_Law_\&_Policy_\(search_results_for\)",
    "Environmental_Humanities_\(search_results_for\)",
    "Food_\(search_results_for\)",
    "Forests_\(search_results_for\)",
    "Geography_\(search_results_for\)",
    "Hazards_\&_Disasters_\(search_results_for\)",
    "Health_\(search_results_for\)",
    "Mining_\&_Materials_\(search_results_for\)",
    "People_\(search_results_for\)",
    "Physics_\&_Chemistry_\(search_results_for\)",
    "Pollution_\(search_results_for\)",
    "Society_\&_Environment_\(search_results_for\)",
    "Water_\(search_results_for\)",
    "Weather_\&_Climate_\(search_results_for\)",
    "Wildlife_\(search_results_for\)");
    return $search_titles;
}*/

?>

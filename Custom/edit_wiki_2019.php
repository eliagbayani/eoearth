<?php
/* 
This is ran in command-line. Can be ran in two ways:
Note: in archive, we need to use: 
$ sudo php edit_wiki_2019.php

1st: provide a title
$ php Custom/edit_wiki_2019.php "Agriculture II"

2nd: will run many titles...
$ php Custom/edit_wiki_2019.php
*/

// /* for archive server (remote)
$GLOBALS['doc_root'] = "/var/www/html";                 //for archive
$GLOBALS['domain'] = "http://editors.eol.org";          //for archive
// */

/* for mac mini (local)
$GLOBALS['doc_root'] = "/Library/WebServer/Documents";  //for mac mini
$GLOBALS['domain'] = "http://editors.eol.localhost";    //for mac mini
*/

if($title = @$argv[1]) {
    print_r($argv); echo " -- there is a title param\n";
    process_title($title);
}
else { //will run many titles...
    /*
    process_one();
    */
    
    // /*
    process_urls("v1"); //this is now done
    // */

    /*
    process_urls("v2");
    $GLOBALS['processed'] = array();
    */
    
}
//========================================[start functions]========================================
function process_one() //you can use command line with interactive title like so: $ php Custom/edit_wiki_2019.php "Agriculture II"
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
    /*
    http://editors.eol.localhost/eoearth/wiki/Search_Results_for_Main_Topics
    */
}
function process_title($destination_title)
{
    $orig_title = $destination_title;                       echo "\norig: [$orig_title]\n";
    $destination_title = format_title($destination_title);  //echo "\nformatted title: [$destination_title]\n";
    if($wiki_path = get_wiki_text($destination_title)) {    //echo "\nwiki_path: [$wiki_path]\n"; 
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
function process_urls($ver)
{
    $url = $GLOBALS['domain'] . "/eoearth/wiki/Search_Results_for_Main_Topics";
    $html = file_get_contents($url);
    if(preg_match("/<div id=\"mw-content-text\" lang=\"en\" dir=\"ltr\" class=\"mw-content-ltr\">(.*?)<\/div>/ims", $html, $arr)) {
        //href="/eoearth/wiki/About_the_EoE_(search_results_for)"
        if(preg_match_all("/href=\"(.*?)\"/ims", $arr[1], $arr2)) { //23 urls
            /* working but not being used anymore... decided to run these 23 urls one by one in archive... bec it will take time and better to run them one by one for manageability
            $urls = $arr2[1];
            */

            $urls = array();
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
            $urls[] = "/eoearth/wiki/Water_(search_results_for)";
            $urls[] = "/eoearth/wiki/Weather_%26_Climate_(search_results_for)";

            // $urls = array("/eoearth/wiki/Wildlife_(search_results_for)"); done


            // $urls = array("/eoearth/wiki/Wildlife_(main)"); --- diff WIP
            print_r($urls);

            foreach($urls as $url) {
                $GLOBALS['current_url'] = $url;
                $html = file_get_contents($GLOBALS['domain'].$url);
                if(preg_match("/<title>(.*?) \(search results for\)/ims", $html, $arr3)) $titlex = "(".$arr3[1].")"; //the one in parenthesis "About the EoE" in (About the EoE)
                if(preg_match("/<div id=\"mw-content-text\" lang=\"en\" dir=\"ltr\" class=\"mw-content-ltr\">(.*?)<\/div>/ims", $html, $arr4)) {
                    if(preg_match_all("/title=\"(.*?)\"/ims", $arr4[1], $arr5)) { //many urls
                        foreach($arr5[1] as $row) { // echo "\n$row";
                            $row_orig = $row;
                            // echo "\n[$row]\n"; exit("\n[$titlex]\n");
                            $row = trim(str_replace(" $titlex", "", $row));

                            if($ver == "v1") {
                                echo "\n processing v1: [$row]\n";
                                // /*
                                shell_exec("php " . $GLOBALS['doc_root'] . "/eoearth/Custom/edit_wiki_2019.php " . "\"$row\"");
                                // break; //just process one, temporary.
                                // */
                                // echo("\nphp " . $GLOBALS['doc_root'] . "/eoearth/Custom/edit_wiki_2019.php " . "\"$row\"");
                            }
                            elseif($ver == "v2") {
                                // exit("\n[$row_orig][$row]\n");
                                process_all_links_from_a_page($row_orig);
                                process_all_links_from_a_page($row);
                                break;
                            }

                        }
                    }
                }
                // break; //debug
            }
        }
    }
    echo "\n\n--end--\n\n";
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
function process_all_links_from_a_page($destination_title) //this will run edit_wiki_2019 for all links in a page
{   // exit("\n[$destination_title]\n");
    $title = format_title($destination_title);
    echo "\nprocess_all_links_from_a_page: [$title]\n";
    if($wiki_path = get_wiki_text($title)) {
        $str = file_get_contents($wiki_path);
        
        $str = str_replace("]s]", "s]]", $str);
        $str = str_replace("]es]", "es]]", $str);
        $str = str_replace("Antarctic]a]", "Antarctica]]", $str);
        $str = str_replace("] change]", " change]]", $str);
        $str = str_replace("] systems]", " systems]]", $str);
        $str = str_replace("] areas]", " areas]]", $str);
        $str = str_replace("]s (Mid-latitude cyclone)]", "s (Mid-latitude cyclone)]]", $str);
        $str = str_replace("]al]", "al]]", $str);
        $str = str_replace("plant] species]", "plant species]]", $str);
        $str = str_replace("]flora]]", "flora]]", $str);

        #REDIRECT [[Weathering_(Environmental_&_Earth_Science)]]
        if(preg_match("/REDIRECT \[\[(.*?)\]\]/ims", $str, $arr)) { //new block --- to accommodate REDIRECTs
            $title = $arr[1];
            //Weathering (Weather &amp; Climate) --- $title has to be of this format -- IMPORTANT
            $title = str_replace("_&_", "_&amp;_", $title);
            $title = str_replace("_", " ", $title);
            
            $GLOBALS['processed'][$title] = '';
            $title = ucfirst($title);
            echo "\nprocessing v2a: [$title]\n"; //exit;
            process_all_links_from_a_page($title);
        }
        elseif(preg_match_all("/\[\[(.*?)\]\]/ims", $str, $arr)) { // for regular pages, not a REDIRECT
            $good_titles = get_good_titles($arr[1]);
            echo "\n good titles: "; print_r($good_titles); //exit;
            // /*
            foreach($good_titles as $title) {
                if(!$title) continue;
                if(stripos($title, '[') !== false) continue; //string is found
                if(stripos($title, ']') !== false) continue; //string is found
                if(stripos($title, 'class=') !== false) continue; //string is found
                if(stripos($title, 'width=') !== false) continue; //string is found
                if(stripos($title, 'align=') !== false) continue; //string is found
                if(stripos($title, 'colspan=') !== false) continue; //string is found
                if(stripos($title, '<br') !== false) continue; //string is found
                if(strlen($title) > 300) continue;
                if(isset($GLOBALS['processed'][$title])) {}
                else {
                    $GLOBALS['processed'][$title] = '';
                    $title = ucfirst($title);
                    echo "\nprocessing v2: [$title]\n";
                    // /*
                    $output = shell_exec("php " . $GLOBALS['doc_root'] . "/eoearth/Custom/edit_wiki_2019.php " . "\"$title\"");
                    // echo "\n---start debug---\n[$output]\n---end debug---\n";
                    // */
                    echo "\n------------\n".$GLOBALS['current_url']."\n------------\n";
                }
            }
            // */
        }
    }
}
function get_good_titles($raw_titles)
{
    $final = array();
    //remove e.g. "Image:"
    foreach($raw_titles as $title) {
        if(is_title_valid($title)) $final[$title] = '';
    }
    //remove the pipe e.g. "Content Source Index|More »"
    $temp = array_keys($final);
    $final = array();
    foreach($temp as $t) {
        $arr = explode("|", $t);
        foreach($arr as $a) $final[$a] = '';
    }
    unset($final['More »']);
    $final = array_keys($final);
    $final = array_map("trim", $final);
    return $final;
}
function is_title_valid($title)
{
    if(substr($title, 0, 1) == "'") return false;
    if(substr($title, 0, 1) == "#") return false;
    if(substr($title, 0, 5) == "http:") return false;
    if(substr($title, 0, 6) == "Image:") return false;
    if(substr($title, 0, 8) == "Special:") return false;
    if(substr($title, 0, 6) == "Media:") return false;
    if(substr($title, 0, 5) == "File:") return false;
    if(substr($title, 0, 6) == "image:") return false;
    if(substr($title, 0, 8) == "special:") return false;
    if(substr($title, 0, 6) == "media:") return false;
    if(substr($title, 0, 5) == "file:") return false;
    return true;
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
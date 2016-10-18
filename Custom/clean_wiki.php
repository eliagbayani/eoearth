<?php
/* This will remove portions of an article...

This is ran in command-line. Can be ran in two ways:
Note: in archive, we need to use: 
$ sudo php clean_wiki.php

1st: provide a title
$ php Custom/clean_wiki.php "Agriculture II"

2nd: will run many titles...
$ php Custom/clean_wiki.php
*/


/* for archive server (remote)
$GLOBALS['doc_root'] = "/var/www/html";                 //for archive
$GLOBALS['domain'] = "http://editors.eol.org";          //for archive
*/

// /* for mac mini (local)
$GLOBALS['doc_root'] = "/Library/WebServer/Documents";  //for mac mini
$GLOBALS['domain'] = "http://editors.eol.localhost";    //for mac mini
// */

if($title = @$argv[1])
{
    // print_r($argv);
    process_title($title);
}
else //will run many titles...
{
    exit("\nexit muna...\n");
    // process_one();
    process_urls();
}
//========================================[start functions]========================================
function process_one() //you can use command line with interactive title like so: $ php Custom/clean_wiki.php "Agriculture II"
{
    $destination_title = "Black-footed penguin"; //ok
    $destination_title = "Scope &amp; Content"; //ok
    $destination_title = "Ecoregions (collection)"; //ok
    $destination_title = "Black, Joseph"; //ok
    $destination_title = "Heaviside's dolphin"; //ok
    $destination_title = "Capitalism 3.0: Chapter 6"; //ok
    $destination_title = "United States";
    $destination_title = "Argentina"; //ok
    process_title($destination_title);
}

function process_urls()
{
    $url = $GLOBALS['domain'] . "/eoearth/wiki/Search_Results_for_Main_Topics";
    $html = file_get_contents($url);
    if(preg_match("/<div id=\"mw-content-text\" lang=\"en\" dir=\"ltr\" class=\"mw-content-ltr\">(.*?)<\/div>/ims", $html, $arr))
    {
        //href="/eoearth/wiki/About_the_EoE_(search_results_for)"
        if(preg_match_all("/href=\"(.*?)\"/ims", $arr[1], $arr2)) //23 urls
        {
            // /* working but not being used anymore... decided to run these 23 urls one by one in archive... bec it will take time and better to run them one by one for manageability
            $urls = $arr2[1];
            // */
            
            $urls = array("/eoearth/wiki/About_the_EoE_(search_results_for)");
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

            foreach($urls as $url)
            {
                $html = file_get_contents($GLOBALS['domain'].$url);
                if(preg_match("/<title>(.*?) \(search results for\)/ims", $html, $arr3)) $titlex = "(".$arr3[1].")"; //the one in parenthesis "About the EoE" in (About the EoE)
                if(preg_match("/<div id=\"mw-content-text\" lang=\"en\" dir=\"ltr\" class=\"mw-content-ltr\">(.*?)<\/div>/ims", $html, $arr4))
                {
                    // if(preg_match_all("/href=(.*?)<\/a>/ims", $arr4[1], $arr5)) //many urls
                    if(preg_match_all("/title=\"(.*?)\"/ims", $arr4[1], $arr5)) //many urls
                    {
                        foreach($arr5[1] as $row)
                        {
                            if(stripos($row, $titlex) !== false)
                            {
                                echo "\n$row";
                                $row = trim(str_replace(" $titlex", "", $row));
                                echo " --- [$row]";
                                
                                /* process_title($row); -- for some reason this does not work, thus using shell below which works */
                                echo "\nprocessing: [$row]\n";   shell_exec("php " . $GLOBALS['doc_root'] . "/eoearth/Custom/clean_wiki.php " . "\"$row\"");
                            }
                        }
                    }
                }
                // break; //debug
            }
        }
    }
}

function process_title($destination_title)
{
    $destination_title = str_replace(" ", "_", $destination_title);
    $destination_title = str_replace("&amp;", "\&", $destination_title);
    $destination_title = str_replace("(", "\(", $destination_title);
    $destination_title = str_replace(")", "\)", $destination_title);
    $destination_title = str_replace("'", "\'", $destination_title);
    $title = $destination_title;
    if($wiki_path = get_wiki_text($title))
    {
        $continue_with_clean = true;
        if($continue_with_clean) //then start with clean, remove portions of the wiki at the bottom
        {
            $str = file_get_contents($wiki_path);
            $str = remove_others($str);
            
            if(are_there_comments($str))
            {
                echo "\nthere are comments\n";
                $comments = get_comments($str);
            }
            else
            {
                echo "\nthere are NO comments\n";
                $comments = "";
            }

            $adjusted_str = adjust_bottom_portion($str, $title); //$title here is just for debug
            if($adjusted_str != $str)
            {
                $adjusted_str .= $comments;
                save_adjustments_to_wiki($adjusted_str, $title); //start saving...
            }



            
            
        }
        else echo "\nwiki not found...ERROR \n";

    }
    else //The whole-word search is negative
    {}
}

function remove_others($str)
{
    $str = str_ireplace('<div class="formSection searchBox">  [index.html#  [[Image:searchDown.png|expand search options]]]</div>', "", $str);
    return $str;
}

function get_comments($str)
{
    if(preg_match("/class=\"module-Comments plain comments\">(.*?)<\/div><\/div><\/div><\/div>/ims", $str, $arr))
    {
        return '<div class="module-Comments plain comments">' . $arr[1] . "</div></div></div></div>";
    }
    return "";
}

function save_adjustments_to_wiki($str, $title)
{
    $temp_write_file = $GLOBALS['doc_root'] . "/eoearth/Custom/temp/write.wiki";
    $handle = fopen($temp_write_file, "w"); fwrite($handle, $str); fclose($handle);
    echo "\nadjusting bottom part of title: [$title]";   shell_exec("php " . $GLOBALS['doc_root'] . "/eoearth/maintenance/edit.php -m " . $title . " < $temp_write_file");
}

function adjust_bottom_portion($str, $title)
{
    $citation = get_citation_block($str);
    
    if(preg_match("/<div id=\"glossaryDisplay\"(.*?) Processing... <\/div><\/div>/ims", $str, $arr))
    {
        $replace = '<div id="glossaryDisplay"' . $arr[1] . " Processing... </div></div>";
        $str = str_replace($replace, "", $str);
        $str .= $citation;
        return $str;
    }
    else
    {
        $items = array();
        $items[] = '<div id=\"citation\"';
        $items[] = '<div id=\"contentViewImageViewDialog\"';
        $items[] = '<div id=\"pmid_1470\" class=\"module-Comments plain comments\"';
        $items[] = '<div class=\"wrapper\"';
        foreach($items as $item)
        {
            if(preg_match("/" . $item . "(.*?) Processing... <\/div><\/div>/ims", $str, $arr))
            {
                $replace = str_replace("\\", "", $item) . $arr[1] . " Processing... </div></div>";
                $str = str_replace($replace, "", $str);
                $str .= $citation;
                return $str;
            }
        }
    }
    echo "\n[$title]- did not change\n";
    return $str;
}

function get_citation_block($str)
{   /*
    <div id="citation" class="marg_b_15">
      ===Citation===
      Ruygt, J. (2013). Flora of Napa County, California. Retrieved from http://editors.eol.org/eoearth/wiki/Flora_of_Napa_County,_California
    </div>
    */
    if(preg_match("/<div id=\"citation\"(.*?)<\/div>/ims", $str, $arr))
    {
        return '<div id="citation"' . $arr[1] . "</div>";
    }
    return "";
}

function are_there_comments($str)
{
    if(stripos($str, '===<span class="strong">0</span> Comments===') !== false) return false; //no comments //string is found
    else
    {
        if(stripos($str, '<div class="userCommentContainer">') !== false) return true; //with comments //string is found
        else return false; //no comments
    }
}

// =====================================================================

/*
$destination_title = "Agricultural_\&_Resource_Economics_\(search_results_for\)";
*/

function edit_the_search_results_topic_page($page_to_open, $to_replace, $replace_with)
{
    $to_replace = str_replace("\\", "", $to_replace);
    $to_replace = str_replace("_", " ", $to_replace);
    $to_replace = str_replace("&", "&amp;", $to_replace);

    $replace_with = str_replace("\\", "", $replace_with);
    $replace_with = str_replace("_", " ", $replace_with);
    $replace_with = str_replace("&", "&amp;", $replace_with);
    
    echo "\n -- to replace [$to_replace]\n";
    echo "\n -- replace with [$replace_with]\n";
    
    if($wiki_path = get_wiki_text($page_to_open))
    {
        if(filesize($wiki_path))
        {
            $html = file_get_contents($wiki_path);
            $html = str_replace($to_replace, $replace_with, $html);

            //start saving...
            $temp_write_file = $GLOBALS['doc_root'] . "/eoearth/Custom/temp/write.wiki";
            $handle = fopen($temp_write_file, "w"); fwrite($handle, $html); fclose($handle);
            echo "\n updating links on: [$page_to_open]";   shell_exec("php " . $GLOBALS['doc_root'] . "/eoearth/maintenance/edit.php -m " . $page_to_open . " < $temp_write_file");
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
    else 
    {
        // echo("\nnot valid title or does not exist [$title]");
        // echo "\nfilesize[$temp_wiki_file]: " . filesize($temp_wiki_file) . "\n";
        return false;
    }
}

function get_post_titles()
{
    $search_titles = array(
    "\(About_the_EoE\)",
    "\(Agricultural_\&_Resource_Economics\)",
    "\(Biodiversity\)",
    "\(Biology\)",
    "\(Climate_Change\)",
    "\(Ecology\)",
    "\(Environmental_\&_Earth_Science\)",
    "\(Energy\)",
    "\(Environmental_Law_\&_Policy\)",
    "\(Environmental_Humanities\)",
    "\(Food\)",
    "\(Forests\)",
    "\(Geography\)",
    "\(Hazards_\&_Disasters\)",
    "\(Health\)",
    "\(Mining_\&_Materials\)",
    "\(People\)",
    "\(Physics_\&_Chemistry\)",
    "\(Pollution\)",
    "\(Society_\&_Environment\)",
    "\(Water\)",
    "\(Weather_\&_Climate\)",
    "\(Wildlife\)");

    //additional
    $search_titles[] = "\(Aquaculture\)";
    $search_titles[] = "\(Complex_Systems\)";
    $search_titles[] = "\(Consumption\)";
    $search_titles[] = "\(Ecosystem_Services\)";
    $search_titles[] = "\(Food_security\)";
    $search_titles[] = "\(Fisheries\)";
    $search_titles[] = "\(Global\)";

    // $search_titles = array("\(About_the_EoE\)");
    return $search_titles;
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

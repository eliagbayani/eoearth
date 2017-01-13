<?php
// namespace php_active_record;

class eoearth_controller
{
    function __construct($params)
    {
        $this->download_options = array('download_timeout_seconds' => 4800, 'download_wait_time' => 300000, 'expire_seconds' => 0); //0 - expires now - normal operation; 'false' doesn't expire
        $this->mediawiki_api = "http://" . DOMAIN_SERVER . "/" . MEDIAWIKI_MAIN_FOLDER . "/api.php";
        $lelimit = 500; //orig 500
        $this->api_call = $this->mediawiki_api . "?action=query&list=logevents&letype=upload&lelimit=" . $lelimit . "&format=json&rawcontinue";
                                               // ?action=query&list=logevents&letype=upload&lelimit=" . $lelimit . "&format=json&rawcontinue&lecontinue=20170105143921|27995
        $this->exact_path = "http://" . DOMAIN_SERVER . "/" . MEDIAWIKI_MAIN_FOLDER . "/wiki/Special:Filepath/";

        // script runs everyday as cron: 1:30 AM
        // 20 13 * * *  cd /Library/WebServer/Documents/eoearth && php Custom/apps/backup.php
    }

    function backup_uploads_today()
    {
        // /* normal operation
        self::check_backup_folder(BACKUP_FOLDER);
        
        $today = date('Y-m-d');                                             //e.g. 2016-07-13
        echo "\nToday: $today\n";
        $range = self::get_range($today);
        self::backup_now($range);
        
        $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($today))); //e.g. 2016-07-12
        echo "\n\nYesterday: $yesterday\n";
        $range = self::get_range($yesterday);
        self::backup_now($range);
        // */
        
        // /* used in initial backup last Jan 12, 2017
        // $range = self::get_range("2016-05-01", "2016-05-31"); self::backup_now($range);
        // $range = self::get_range("2016-10-01", "2016-10-31"); self::backup_now($range);
        // $range = self::get_range("2016-11-01", "2016-11-31"); self::backup_now($range);
        // $range = self::get_range("2016-12-01", "2016-12-31"); self::backup_now($range);
        // $range = self::get_range("2017-01-01", "2017-01-31"); self::backup_now($range);
        // */
    }
    
    private function backup_now($range)
    {
        print_r($range);
        $lecontinue = "";
        while(true)
        {
            $url = $this->api_call . "&lestart=$range[lestart]&leend=$range[leend]&ledir=newer";
            if($lecontinue) $url .= "&lecontinue=$lecontinue";
            $json = Functions::lookup_with_cache($url, $this->download_options);
            echo "\n$url\n";
            $arr = json_decode($json, true);
            // print_r($arr);
            if($recs = $arr['query']['logevents'])
            {
                $path = BACKUP_FOLDER . substr($range["lestart"],0,10);
                self::check_backup_folder($path);
                foreach($recs as $rec)
                {
                    echo "\n".$rec['title']." -- ".$rec['timestamp'];
                    $filename = str_replace("File:", "", $rec['title']);
                    $remote_image_path = $this->exact_path . str_replace(" ", "_", $filename);
                    $destination_file = "$path/$filename";

                    // /*
                    if(!file_exists($destination_file))
                    {
                        $imageString = file_get_contents($remote_image_path);
                        if($save = file_put_contents($destination_file, $imageString)) echo "\nSaved OK [$save][$destination_file]";
                    }
                    else echo " - already saved.";
                    sleep(3);
                    // */
                }
            }
            else echo "\nNo uploads between " . substr($range["lestart"],0,10) . " and " . substr($range["leend"],0,10) . "\n";
            $lecontinue = @$arr['query-continue']['logevents']['lecontinue'];
            if(!$lecontinue) break;
        }//end while
    }
    
    private function get_range($start, $end = null)
    {
        if(!$end) $end = $start;
        return array("lestart" => $start."T00:00:00Z", "leend" => $end."T23:59:59Z");
    }
    
    private function check_backup_folder($folder)
    {
        if(!file_exists($folder))
        {
            mkdir($folder);
            echo "\nbackup folder created OK\n";
        }
        else echo "\nbackup folder already created...\n";
    }
    
    /*
    $file_contents = Functions::get_remote_file($remote_image_path, $this->download_options);
    if($FILE = Functions::file_open($destination_file, 'w')) // normal
    {
        fwrite($FILE, $file_contents);
        fclose($FILE);
    }
    */
    
}
?>
